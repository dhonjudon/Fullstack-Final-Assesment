<?php
// cart.php: Customer shopping cart page
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';
include '../includes/header.php';

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle clear cart
if (isset($_GET['clear'])) {
    $_SESSION['cart'] = [];
    header('Location: cart.php');
    exit;
}

// Handle add/remove actions
if (isset($_GET['add'])) {
    $id = intval($_GET['add']);
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header('Location: cart.php');
    exit;
}
if (isset($_GET['increase'])) {
    $id = intval($_GET['increase']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    }
    header('Location: cart.php');
    exit;
}
if (isset($_GET['decrease'])) {
    $id = intval($_GET['decrease']);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]--;
        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }
    header('Location: cart.php');
    exit;
}
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    unset($_SESSION['cart'][$id]);
    header('Location: cart.php');
    exit;
}

// Fetch cart items
$cart = $_SESSION['cart'];
$items = [];
$total = 0;
if ($cart) {
    // Remove any empty or zero quantity items
    $cart = array_filter($cart, function ($qty) {
        return $qty > 0;
    });
    $_SESSION['cart'] = $cart;

    if (!empty($cart)) {
        $ids = implode(',', array_map('intval', array_keys($cart)));
        $stmt = $pdo->query("SELECT DISTINCT * FROM menu_items WHERE id IN ($ids)");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Ensure items are keyed by ID to prevent duplicates
        $uniqueItems = [];
        foreach ($items as $item) {
            if (!isset($uniqueItems[$item['id']])) {
                $item['quantity'] = $cart[$item['id']];
                $item['subtotal'] = $item['quantity'] * $item['price'];
                $total += $item['subtotal'];
                $uniqueItems[$item['id']] = $item;
            }
        }
        $items = array_values($uniqueItems);
    }
}
?>
<h2>Your Cart</h2>
<?php if (!$items): ?>
    <div class="empty-cart">
        <div class="empty-cart-icon">🛒</div>
        <h3>Your cart is empty</h3>
        <p>Looks like you haven't added anything yet. Explore our delicious menu!</p>
        <a href="menu.php" class="button button-large">Continue Shopping</a>
    </div>
<?php else: ?>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= sanitize($item['name']) ?></td>
                <td>रु <?= number_format($item['price'], 2) ?></td>
                <td>
                    <div class="quantity-controls">
                        <a href="cart.php?decrease=<?= $item['id'] ?>" class="qty-btn">-</a>
                        <span class="qty-value"><?= $item['quantity'] ?></span>
                        <a href="cart.php?increase=<?= $item['id'] ?>" class="qty-btn">+</a>
                    </div>
                </td>
                <td>रु <?= number_format($item['subtotal'], 2) ?></td>
                <td><a href="cart.php?remove=<?= $item['id'] ?>" class="button">Remove</a></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Total</strong></td>
            <td colspan="2"><strong>रु <?= number_format($total, 2) ?></strong></td>
        </tr>
    </table>
    <div class="cart-actions">
        <div class="cart-left">
            <a href="menu.php" class="button button-secondary">Continue Shopping</a>
            <a href="cart.php?clear=1" class="button button-danger"
                onclick="return confirm('Clear all items from cart?');">Clear Cart</a>
        </div>
        <a href="checkout.php" class="button button-large">Proceed to Checkout</a>
    </div>
    <!-- Sticky checkout button for mobile -->
    <a href="checkout.php" class="button sticky-checkout">Checkout</a>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>