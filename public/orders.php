<?php
// orders.php: Admin orders management and revenue tracking
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Handle daily reset - BEFORE any HTML output
if (isset($_GET['reset_daily']) && $_GET['reset_daily'] === 'confirm') {
    try {
        $pdo->beginTransaction();

        // Calculate today's totals
        $today_stats = $pdo->query("SELECT COUNT(*) as orders, COALESCE(SUM(total), 0) as revenue FROM orders")->fetch();

        // Only proceed if there are orders to reset
        if ($today_stats['orders'] == 0) {
            $pdo->rollBack();
            $_SESSION['reset_error'] = "No orders to reset.";
            header('Location: orders.php');
            exit;
        }

        // Archive all orders to archived_orders
        $orders_to_archive = $pdo->query("SELECT * FROM orders")->fetchAll();
        foreach ($orders_to_archive as $order) {
            $stmt = $pdo->prepare("INSERT INTO archived_orders (original_order_id, customer_name, customer_phone, total, status, order_date) 
                                   VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $order['id'],
                $order['customer_name'],
                $order['customer_phone'],
                $order['total'],
                $order['status'],
                $order['created_at']
            ]);

            $archived_id = $pdo->lastInsertId();

            // Archive order items
            $items = $pdo->prepare("SELECT oi.*, mi.name FROM order_items oi 
                                   LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id 
                                   WHERE oi.order_id = ?");
            $items->execute([$order['id']]);
            foreach ($items->fetchAll() as $item) {
                $stmt = $pdo->prepare("INSERT INTO archived_order_items (archived_order_id, menu_item_name, quantity, price) 
                                      VALUES (?, ?, ?, ?)");
                $stmt->execute([$archived_id, $item['name'], $item['quantity'], $item['price']]);
            }
        }

        // Log revenue for today
        $stmt = $pdo->prepare("INSERT INTO revenue_logs (log_date, total_orders, total_revenue) 
                              VALUES (CURDATE(), ?, ?) 
                              ON DUPLICATE KEY UPDATE 
                              total_orders = total_orders + ?, 
                              total_revenue = total_revenue + ?");
        $stmt->execute([
            $today_stats['orders'],
            $today_stats['revenue'],
            $today_stats['orders'],
            $today_stats['revenue']
        ]);

        // Clear current orders and order_items
        $pdo->exec("DELETE FROM order_items");
        $pdo->exec("DELETE FROM orders");

        $pdo->commit();
        $_SESSION['reset_message'] = "Daily orders reset successfully! Revenue logged.";
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['reset_error'] = "Error resetting orders: " . $e->getMessage();
    }
    header('Location: orders.php');
    exit;
}

// Handle status update - BEFORE any HTML output
if (isset($_GET['update_status'])) {
    $order_id = intval($_GET['update_status']);
    $new_status = isset($_GET['status']) ? sanitize($_GET['status']) : 'pending';

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $order_id]);
    header('Location: orders.php');
    exit;
}

// Now include header (HTML output starts here)
include '../includes/header.php';

// Get summary statistics
$total_revenue = $pdo->query("SELECT SUM(total) as revenue FROM orders")->fetch()['revenue'] ?? 0;
$total_orders = $pdo->query("SELECT COUNT(*) as count FROM orders")->fetch()['count'] ?? 0;
$pending_orders = $pdo->query("SELECT COUNT(*) as count FROM orders WHERE status = 'pending'")->fetch()['count'] ?? 0;
$completed_orders = $pdo->query("SELECT COUNT(*) as count FROM orders WHERE status = 'done'")->fetch()['count'] ?? 0;

// Fetch pending and completed orders separately
$stmt_pending = $pdo->query("SELECT * FROM orders WHERE status = 'pending' ORDER BY id ASC");
$pending = $stmt_pending->fetchAll();

$stmt_completed = $pdo->query("SELECT * FROM orders WHERE status = 'done' ORDER BY id ASC");
$completed = $stmt_completed->fetchAll();

// Fetch order items for display
$order_items = [];
$all_orders = array_merge($pending, $completed);
foreach ($all_orders as $order) {
    $stmt = $pdo->prepare("SELECT oi.*, mi.name FROM order_items oi 
                           LEFT JOIN menu_items mi ON oi.menu_item_id = mi.id 
                           WHERE oi.order_id = ?");
    $stmt->execute([$order['id']]);
    $order_items[$order['id']] = $stmt->fetchAll();
}
?>

<h2>Orders Management</h2>

<?php if (isset($_SESSION['reset_message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['reset_message'] ?>
        <a href="revenue.php" class="button button-small">View Revenue Reports</a>
    </div>
    <?php unset($_SESSION['reset_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['reset_error'])): ?>
    <div class="alert alert-error"><?= $_SESSION['reset_error'] ?></div>
    <?php unset($_SESSION['reset_error']); ?>
<?php endif; ?>

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

<div class="orders-actions-bar">
    <a href="revenue.php" class="button button-secondary">View Revenue Reports</a>
    <?php if ($total_orders > 0): ?>
        <a href="#" onclick="openResetModal(); return false;" class="button button-danger">Reset Daily Orders</a>
    <?php endif; ?>
</div>

<!-- Pending Orders Section -->
<?php if ($pending): ?>
    <h3 class="section-title pending-section">⏳ Pending Orders (<?= count($pending) ?>)</h3>
    <div class="orders-list">
        <div class="orders-header">
            <div class="col-order">Order ID</div>
            <div class="col-customer">Customer</div>
            <div class="col-phone">Phone</div>
            <div class="col-items">Items</div>
            <div class="col-total">Total</div>
            <div class="col-status">Status</div>
            <div class="col-action"></div>
        </div>

        <?php foreach ($pending as $order): ?>
            <div class="order-row">
                <div class="order-row-main" onclick="toggleOrderDetails(this)">
                    <div class="col-order">#<?= $order['id'] ?></div>
                    <div class="col-customer"><?= sanitize($order['customer_name']) ?></div>
                    <div class="col-phone"><?= sanitize($order['customer_phone'] ?? 'N/A') ?></div>
                    <div class="col-items"><?= count($order_items[$order['id']] ?? []) ?> item(s)</div>
                    <div class="col-total">रु <?= number_format($order['total'], 2) ?></div>
                    <div class="col-status">
                        <span class="status-badge status-<?= $order['status'] ?>">
                            <?= ucfirst(sanitize($order['status'])) ?>
                        </span>
                    </div>
                    <div class="col-action">
                        <span class="expand-icon">▼</span>
                    </div>
                </div>

                <div class="order-details">
                    <div class="details-content">
                        <div class="details-section">
                            <h4>Order Details</h4>
                            <div class="detail-row">
                                <span>Date & Time:</span>
                                <span><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></span>
                            </div>
                        </div>

                        <div class="details-section">
                            <h4>Items Ordered</h4>
                            <div class="items-table">
                                <?php foreach ($order_items[$order['id']] ?? [] as $item): ?>
                                    <div class="item-row">
                                        <span class="item-name"><?= sanitize($item['name'] ?? 'Unknown Item') ?></span>
                                        <span class="item-qty">x<?= $item['quantity'] ?></span>
                                        <span class="item-price">रु <?= number_format($item['price'], 2) ?></span>
                                        <span class="item-subtotal">रु
                                            <?= number_format($item['quantity'] * $item['price'], 2) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="details-actions">
                            <a href="orders.php?update_status=<?= $order['id'] ?>&status=done" class="button button-success">✓
                                Mark as Done</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Completed Orders Section -->
<?php if ($completed): ?>
    <h3 class="section-title completed-section">✓ Completed Orders (<?= count($completed) ?>)</h3>
    <div class="orders-list orders-list-completed">
        <div class="orders-header">
            <div class="col-order">Order ID</div>
            <div class="col-customer">Customer</div>
            <div class="col-phone">Phone</div>
            <div class="col-items">Items</div>
            <div class="col-total">Total</div>
            <div class="col-status">Status</div>
            <div class="col-action"></div>
        </div>

        <?php foreach ($completed as $order): ?>
            <div class="order-row">
                <div class="order-row-main" onclick="toggleOrderDetails(this)">
                    <div class="col-order">#<?= $order['id'] ?></div>
                    <div class="col-customer"><?= sanitize($order['customer_name']) ?></div>
                    <div class="col-phone"><?= sanitize($order['customer_phone'] ?? 'N/A') ?></div>
                    <div class="col-items"><?= count($order_items[$order['id']] ?? []) ?> item(s)</div>
                    <div class="col-total">रु <?= number_format($order['total'], 2) ?></div>
                    <div class="col-status">
                        <span class="status-badge status-<?= $order['status'] ?>">
                            <?= ucfirst(sanitize($order['status'])) ?>
                        </span>
                    </div>
                    <div class="col-action">
                        <span class="expand-icon">▼</span>
                    </div>
                </div>

                <div class="order-details">
                    <div class="details-content">
                        <div class="details-section">
                            <h4>Order Details</h4>
                            <div class="detail-row">
                                <span>Date & Time:</span>
                                <span><?= date('M d, Y h:i A', strtotime($order['created_at'])) ?></span>
                            </div>
                        </div>

                        <div class="details-section">
                            <h4>Items Ordered</h4>
                            <div class="items-table">
                                <?php foreach ($order_items[$order['id']] ?? [] as $item): ?>
                                    <div class="item-row">
                                        <span class="item-name"><?= sanitize($item['name'] ?? 'Unknown Item') ?></span>
                                        <span class="item-qty">x<?= $item['quantity'] ?></span>
                                        <span class="item-price">रु <?= number_format($item['price'], 2) ?></span>
                                        <span class="item-subtotal">रु
                                            <?= number_format($item['quantity'] * $item['price'], 2) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="details-actions">
                            <a href="orders.php?update_status=<?= $order['id'] ?>&status=pending"
                                class="button button-secondary">↻ Reopen Order</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!$pending && !$completed): ?>
    <div class="empty-state">
        <p>No orders yet. When customers place orders, they will appear here.</p>
    </div>
<?php endif; ?>

<!-- Reset Daily Orders Modal -->
<div id="resetModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Reset Daily Orders</h3>
            <button class="modal-close" onclick="closeResetModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p>Reset all orders for today? This will archive orders and log revenue. This cannot be undone!</p>
        </div>
        <div class="modal-footer">
            <button class="button" onclick="confirmReset()">OK</button>
            <button class="button button-secondary" onclick="closeResetModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
    function openResetModal() {
        const modal = document.getElementById('resetModal');
        modal.style.display = 'flex';
        modal.style.visibility = 'visible';
        modal.style.opacity = '1';
    }

    function closeResetModal() {
        const modal = document.getElementById('resetModal');
        modal.style.display = 'none';
        modal.style.visibility = 'hidden';
        modal.style.opacity = '0';
    }

    function confirmReset() {
        window.location.href = 'orders.php?reset_daily=confirm';
    }

    window.onclick = function (event) {
        const modal = document.getElementById('resetModal');
        if (event.target == modal) {
            closeResetModal();
        }
    }
</script>

<?php include '../includes/footer.php'; ?>