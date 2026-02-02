<?php
// add.php: Add new menu item
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
include '../includes/header.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $category = sanitize($_POST['category'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $description = sanitize($_POST['description'] ?? '');
    $availability = isset($_POST['availability']) ? 1 : 0;

    // Validation
    if (!$name)
        $errors[] = 'Name is required.';
    if (!$category)
        $errors[] = 'Category is required.';
    if ($price <= 0)
        $errors[] = 'Price must be positive.';

    if (!$errors) {
        // Handle image upload
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            $image = uploadImage($_FILES['image']);
        }

        $stmt = $pdo->prepare('INSERT INTO menu_items (name, category, price, description, availability, image, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([$name, $category, $price, $description, $availability, $image]);
        header('Location: index.php');
        exit;
    }
}
// Fetch categories for dropdown
$cat_stmt = $pdo->query('SELECT name FROM categories ORDER BY name');
$cat_list = $cat_stmt->fetchAll(PDO::FETCH_COLUMN);

?>
<h2>Add Menu Item</h2>
<?php if ($errors): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $e)
            echo "<li>$e</li>"; ?>
    </ul>
<?php endif; ?>
<form method="post" action="" enctype="multipart/form-data">
    <label>Name: <input type="text" name="name" required></label><br><br>
    <label>Category:
        <select name="category" required>
            <option value="">Select category</option>
            <?php foreach ($cat_list as $cat): ?>
                <option value="<?= sanitize($cat) ?>" <?= (isset($category) && $category == $cat) ? 'selected' : '' ?>>
                    <?= sanitize($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>
    <label>Price: <input type="number" name="price" step="0.01" min="0.01" required></label><br><br>
    <label>Description: <textarea name="description"></textarea></label><br><br>
    <label>Image: <input type="file" name="image" accept="image/jpeg,image/png,image/gif"></label><br><br>
    <label>Available: <input type="checkbox" name="availability" checked></label><br><br>
    <button type="submit" class="button">Add Item</button>
    <a href="index.php" class="button">Cancel</a>
</form>
<?php include '../includes/footer.php'; ?>