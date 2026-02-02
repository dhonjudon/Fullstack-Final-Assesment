<?php
// search.php: Search menu items
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';
include '../includes/header.php';

$search = sanitize($_GET['q'] ?? '');
$category = sanitize($_GET['category'] ?? '');

$sql = 'SELECT * FROM menu_items WHERE 1';
$params = [];
if ($search) {
    $sql .= ' AND name LIKE ?';
    $params[] = "%$search%";
}
if ($category) {
    $sql .= ' AND category LIKE ?';
    $params[] = "%$category%";
}
$sql .= ' ORDER BY created_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$items = $stmt->fetchAll();
?>
<h2>Search Menu Items</h2>
<form method="get" action="" id="searchForm">
    <input type="text" name="q" id="searchInput" placeholder="Search by name..." value="<?= $search ?>">
    <input type="text" name="category" id="categoryInput" placeholder="Category..." value="<?= $category ?>">
    <button type="submit" class="button">Search</button>
</form>
<div id="results">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Description</th>
                <th>Available</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= sanitize($item['name']) ?></td>
                    <td><?= sanitize($item['category']) ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td><?= sanitize($item['description']) ?></td>
                    <td class="<?= $item['availability'] ? 'availability-yes' : 'availability-no' ?>">
                        <?= $item['availability'] ? 'Yes' : 'No' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    // Ajax live search
    const searchInput = document.getElementById('searchInput');
    const categoryInput = document.getElementById('categoryInput');
    const resultsDiv = document.getElementById('results');

    function fetchResults() {
        const q = searchInput.value;
        const cat = categoryInput.value;
        fetch(`search.php?q=${encodeURIComponent(q)}&category=${encodeURIComponent(cat)}&ajax=1`)
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const table = doc.querySelector('#results').innerHTML;
                resultsDiv.innerHTML = table;
            });
    }

    searchInput.addEventListener('input', fetchResults);
    categoryInput.addEventListener('input', fetchResults);

    // Only run Ajax if ?ajax=1
    if (new URLSearchParams(window.location.search).get('ajax') === '1') {
        // Only output the table for Ajax
        exit;
    }
</script>
<?php include '../includes/footer.php'; ?>