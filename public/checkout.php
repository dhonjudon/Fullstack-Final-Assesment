<?php
// checkout.php: Customer checkout page
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';
include '../includes/header.php';

$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    echo '<p>Your cart is empty.</p>';
    include '../includes/footer.php';
    exit;
}

$items = [];
$total = 0;
$ids = implode(',', array_map('intval', array_keys($cart)));
$stmt = $pdo->query("SELECT * FROM menu_items WHERE id IN ($ids)");
$dbItems = $stmt->fetchAll();
foreach ($dbItems as $item) {
    $item['quantity'] = $cart[$item['id']];
    $item['subtotal'] = $item['quantity'] * $item['price'];
    $total += $item['subtotal'];
    $items[] = $item;
}

$success = false;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    if (!$name)
        $errors[] = 'Name is required.';
    if (!$errors) {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('INSERT INTO orders (customer_name, customer_phone, total) VALUES (?, ?, ?)');
        $stmt->execute([$name, $phone, $total]);
        $order_id = $pdo->lastInsertId();
        $stmt = $pdo->prepare('INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES (?, ?, ?, ?)');
        foreach ($items as $item) {
            $stmt->execute([$order_id, $item['id'], $item['quantity'], $item['price']]);
        }
        $pdo->commit();
        $_SESSION['cart'] = [];
        $success = true;
    }
}
?>
<h2>Checkout</h2>
<?php if ($success): ?>
    <div class="success-message">
        <div class="success-icon">✓</div>
        <h3>Order Placed Successfully!</h3>
        <p>Thank you for your order. Your order has been received and is being prepared.</p>
        <div class="button-group">
            <a href="menu.php" class="button button-large">Back to Menu</a>
        </div>
    </div>
<?php else: ?>
    <div class="checkout-container">
        <div class="checkout-form">
            <?php if ($errors): ?>
                <ul style="color:red;"><?php foreach ($errors as $e)
                    echo "<li>$e</li>"; ?></ul>
            <?php endif; ?>
            <h3>Delivery Information</h3>
            <form method="post" action="">
                <label>Name: <input type="text" name="name" required></label>
                <label>Phone: <input type="tel" name="phone" id="phoneInput" inputmode="numeric" pattern="[0-9]*"
                        placeholder="Optional" maxlength="15"></label>
                <button type="submit" class="button" style="width: 100%; margin-top: 1rem;">Place Order</button>
            </form>
            <script>
                document.getElementById('phoneInput').addEventListener('input', function (e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            </script>
        </div>
        <div class="checkout-summary">
            <h3>Order Summary</h3>
            <table class="table">
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= sanitize($item['name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>रु <?= number_format($item['subtotal'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td><strong>रु <?= number_format($total, 2) ?></strong></td>
                </tr>
            </table>
        </div>
    </div>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>