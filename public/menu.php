<?php
// menu.php: Public menu page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';
require_once '../includes/functions.php';
include '../includes/header.php';

// Fetch only available menu items
$stmt = $pdo->prepare('SELECT * FROM menu_items WHERE availability = 1 ORDER BY category, name');
$stmt->execute();
$items = $stmt->fetchAll();

// Group items by category
$grouped = [];
foreach ($items as $item) {
    $grouped[$item['category']][] = $item;
}
?>
<h2>Our Menu</h2>
<?php foreach ($grouped as $category => $catItems): ?>
    <h3><?= sanitize($category) ?></h3>
    <div class="menu-category">
        <?php foreach ($catItems as $item): ?>
            <div class="menu-item">
                <?php if ($item['image']): ?>
                    <img src="/final-ass/assets/img/<?= sanitize($item['image']) ?>" alt="<?= sanitize($item['name']) ?>">
                <?php else: ?>
                    <img src="/final-ass/assets/img/placeholder.jpg" alt="No image">
                <?php endif; ?>
                <strong><?= sanitize($item['name']) ?></strong>
                <div class="price">रु <?= number_format($item['price'], 2) ?></div>
                <div class="desc"><?= sanitize($item['description']) ?></div>
                <a href="cart.php?add=<?= $item['id'] ?>" class="button">Add to Cart</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
<?php include '../includes/footer.php'; ?>