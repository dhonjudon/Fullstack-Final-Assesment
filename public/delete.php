<?php
// delete.php: Delete menu item
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';

$id = intval($_GET['id'] ?? 0);
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM menu_items WHERE id = ?');
    $stmt->execute([$id]);
}
header('Location: index.php');
exit;
