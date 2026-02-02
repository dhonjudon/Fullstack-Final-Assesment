<?php
// revenue.php: Monthly revenue tracking and reports
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
include '../includes/header.php';

// Get monthly revenue data
$stmt = $pdo->query("SELECT 
    DATE_FORMAT(log_date, '%Y-%m') as month,
    SUM(total_orders) as orders,
    SUM(total_revenue) as revenue
    FROM revenue_logs 
    GROUP BY DATE_FORMAT(log_date, '%Y-%m')
    ORDER BY month DESC");
$monthly_data = $stmt->fetchAll();

// Get total all-time revenue
$total_all_time = $pdo->query("SELECT SUM(total_revenue) as total FROM revenue_logs")->fetch()['total'] ?? 0;
$total_orders_all_time = $pdo->query("SELECT SUM(total_orders) as total FROM revenue_logs")->fetch()['total'] ?? 0;
?>

<h2>Revenue Reports</h2>

<div class="summary-cards">
    <div class="summary-card">
        <h3>All-Time Revenue</h3>
        <p class="summary-value">रु <?= number_format($total_all_time, 2) ?></p>
    </div>
    <div class="summary-card">
        <h3>Total Orders Served</h3>
        <p class="summary-value"><?= $total_orders_all_time ?></p>
    </div>
    <div class="summary-card">
        <h3>Months Tracked</h3>
        <p class="summary-value"><?= count($monthly_data) ?></p>
    </div>
</div>

<h3 class="section-title">Monthly Revenue Breakdown</h3>

<?php if ($monthly_data): ?>
    <table class="table">
        <thead>
            <tr>
                <th>Month</th>
                <th>Total Orders</th>
                <th>Revenue</th>
                <th>Avg per Order</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monthly_data as $data):
                $avg = $data['orders'] > 0 ? $data['revenue'] / $data['orders'] : 0;
                $month_name = date('F Y', strtotime($data['month'] . '-01'));
                ?>
                <tr>
                    <td><strong><?= $month_name ?></strong></td>
                    <td><?= $data['orders'] ?></td>
                    <td>रु <?= number_format($data['revenue'], 2) ?></td>
                    <td>रु <?= number_format($avg, 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="empty-state">
        <p>No revenue data yet. Complete some orders and reset daily to track revenue.</p>
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>