<?php
// orders.php: Admin orders management and revenue tracking
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
include '../includes/header.php';

// Handle status update
if (isset($_GET['update_status'])) {
    $order_id = intval($_GET['update_status']);
    $new_status = isset($_GET['status']) ? sanitize($_GET['status']) : 'pending';

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $order_id]);
    header('Location: orders.php');
    exit;
}

// Get summary statistics
$total_revenue = $pdo->query("SELECT SUM(total) as revenue FROM orders")->fetch()['revenue'] ?? 0;
$total_orders = $pdo->query("SELECT COUNT(*) as count FROM orders")->fetch()['count'] ?? 0;
$pending_orders = $pdo->query("SELECT COUNT(*) as count FROM orders WHERE status = 'pending'")->fetch()['count'] ?? 0;
$completed_orders = $pdo->query("SELECT COUNT(*) as count FROM orders WHERE status = 'done'")->fetch()['count'] ?? 0;

// Fetch all orders with their items
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();

// Fetch order items for display
$order_items = [];
foreach ($orders as $order) {
    $stmt = $pdo->prepare("SELECT oi.*, mi.name FROM order_items oi 
                           LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id 
                           WHERE oi.order_id = ?");
    $stmt->execute([$order['id']]);
    $order_items[$order['id']] = $stmt->fetchAll();
}
?>

<h2>Orders Management</h2>

<!-- Revenue Summary -->
<div class="summary-cards">
    <div class="summary-card">
        <h3>Total Revenue</h3>
        <p class="summary-value">रु <?= number_format($total_revenue, 2) ?></p>
    </div>
    <div class="summary-card">
        <h3>Total Orders</h3>
        <p class="summary-value"><?= $total_orders ?></p>
    </div>
    <div class="summary-card">
        <h3>Pending</h3>
        <p class="summary-value" style="color: #d4a574;"><?= $pending_orders ?></p>
    </div>
    <div class="summary-card">
        <h3>Completed</h3>
        <p class="summary-value" style="color: #8d9f87;"><?= $completed_orders ?></p>
    </div>
</div>

<!-- Orders List -->
<?php if ($orders): ?>
    <div class="orders-container">
        <?php foreach ($orders as $order): ?>
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <h3>Order #<?= $order['id'] ?></h3>
                        <p class="order-customer"><strong>Customer:</strong> <?= sanitize($order['customer_name']) ?></p>
                        <p class="order-phone"><strong>Phone:</strong> <?= sanitize($order['customer_phone'] ?? 'N/A') ?></p>
                    </div>
                    <div class="order-meta">
                        <p><strong>Date:</strong> <?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></p>
                        <p><strong>Total:</strong> रु <?= number_format($order['total'], 2) ?></p>
                    </div>
                </div>

                <div class="order-items">
                    <h4>Items:</h4>
                    <ul>
                        <?php foreach ($order_items[$order['id']] ?? [] as $item): ?>
                            <li>
                                <?= sanitize($item['name'] ?? 'Unknown Item') ?>
                                x <?= $item['quantity'] ?>
                                @ रु <?= number_format($item['price'], 2) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="order-status">
                    <span class="status-badge status-<?= $order['status'] ?>">
                        <?= ucfirst(sanitize($order['status'])) ?>
                    </span>
                    <?php if ($order['status'] === 'pending'): ?>
                        <a href="orders.php?update_status=<?= $order['id'] ?>&status=done" class="button button-small">Mark Done</a>
                    <?php else: ?>
                        <a href="orders.php?update_status=<?= $order['id'] ?>&status=pending" class="button button-small">Reopen</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-state">
        <p>No orders yet. When customers place orders, they will appear here.</p>
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>