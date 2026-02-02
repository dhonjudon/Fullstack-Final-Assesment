<?php
// index.php: Admin dashboard
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
include '../includes/header.php';

// Fetch all menu items
$stmt = $pdo->query('SELECT * FROM menu_items ORDER BY created_at DESC');
$items = $stmt->fetchAll();
?>
<h2>Menu Items</h2>
<a href="add.php" class="button">Add New Item</a>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Description</th>
            <th>Available</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= sanitize($item['name']) ?></td>
                <td><?= sanitize($item['category']) ?></td>
                <td>रु <?= number_format($item['price'], 2) ?></td>
                <td><?= sanitize($item['description']) ?></td>
                <td class="<?= $item['availability'] ? 'availability-yes' : 'availability-no' ?>">
                    <?= $item['availability'] ? 'Yes' : 'No' ?>
                </td>
                <td>
                    <a href="edit.php?id=<?= $item['id'] ?>" class="button">Edit</a>
                    <a href="#" class="button button-danger" onclick="openDeleteModal(<?= $item['id'] ?>, '<?= htmlspecialchars(sanitize($item['name'])) ?>'); return false;">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>