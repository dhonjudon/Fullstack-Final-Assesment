<?php
// categories.php: Admin category management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../includes/auth.php';
require_once '../config/db.php';
require_once '../includes/functions.php';
include '../includes/header.php';

// Handle add category
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $cat = sanitize($_POST['category'] ?? '');
    if (!$cat)
        $errors[] = 'Category name required.';
    else {
        $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->execute([$cat]);
    }
}
// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $pdo->prepare('DELETE FROM categories WHERE id=?')->execute([$id]);
}
// Fetch all categories
$cats = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
?>
<h2>Manage Categories</h2>
<form method="post">
    <input type="text" name="category" placeholder="New category" required>
    <button type="submit" name="add" class="button">Add Category</button>
</form>
<?php if ($errors): ?>
    <ul style="color:red;"><?php foreach ($errors as $e)
        echo "<li>$e</li>"; ?></ul><?php endif; ?>
<table class="table">
    <tr>
        <th>Name</th>
        <th>Action</th>
    </tr>
    <?php foreach ($cats as $cat): ?>
        <tr>
            <td><?= sanitize($cat['name']) ?></td>
            <td><a href="categories.php?delete=<?= $cat['id'] ?>" class="button"
                    onclick="return confirm('Delete this category?');">Delete</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php include '../includes/footer.php'; ?>