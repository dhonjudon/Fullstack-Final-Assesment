<?php
// edit.php: Edit menu item
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
include '../includes/header.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    echo '<p>Invalid item ID.</p>';
    include '../includes/footer.php';
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM menu_items WHERE id = ?');
$stmt->execute([$id]);
$item = $stmt->fetch();
if (!$item) {
    echo '<p>Item not found.</p>';
    include '../includes/footer.php';
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $category = sanitize($_POST['category'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $description = sanitize($_POST['description'] ?? '');
    $availability = isset($_POST['availability']) ? 1 : 0;

    if (!$name)
        $errors[] = 'Name is required.';
    if (!$category)
        $errors[] = 'Category is required.';
    if ($price <= 0)
        $errors[] = 'Price must be positive.';

    if (!$errors) {
        // Handle image upload
        $image = $item['image'];
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $new_image = uploadImage($_FILES['image']);
            if ($new_image)
                $image = $new_image;
        }

        $stmt = $pdo->prepare('UPDATE menu_items SET name=?, category=?, price=?, description=?, availability=?, image=? WHERE id=?');
        $stmt->execute([$name, $category, $price, $description, $availability, $image, $id]);
        header('Location: index.php');
        exit;
    }
}

// Fetch categories for dropdown
$cat_stmt = $pdo->query('SELECT name FROM categories ORDER BY name');
$cat_list = $cat_stmt->fetchAll(PDO::FETCH_COLUMN);

?>
<h2>Edit Menu Item</h2>
<?php if ($errors): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $e)
            echo "<li>$e</li>"; ?>
    </ul>
<?php endif; ?>
<form method="post" action="" enctype="multipart/form-data">
    <label>Name: <input type="text" name="name" value="<?= sanitize($item['name']) ?>" required></label><br><br>
    <label>Category:
        <select name="category" required>
            <option value="">Select category</option>
            <?php foreach ($cat_list as $cat): ?>
                <option value="<?= sanitize($cat) ?>" <?= ($item['category'] == $cat) ? 'selected' : '' ?>>
                    <?= sanitize($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>
    <label>Price: <input type="number" name="price" step="0.01" min="0.01"
            value="<?= number_format($item['price'], 2) ?>" required></label><br><br>
    <label>Description: <textarea name="description"><?= sanitize($item['description']) ?></textarea></label><br><br>
    <label>Image: <input type="file" name="image" accept="image/jpeg,image/png,image/gif"></label>
    <?php if ($item['image']): ?>
        <br>(Current: <?= sanitize($item['image']) ?>)
    <?php endif; ?><br><br>
    <label>Available: <input type="checkbox" name="availability" <?= $item['availability'] ? 'checked' : '' ?>></label><br><br>
    <button type="submit" class="button">Update Item</button>
    <a href="index.php" class="button">Cancel</a>
</form>
<?php include '../includes/footer.php'; ?>