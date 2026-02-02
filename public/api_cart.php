<?php
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if (!isset($_GET['action'])) {
    echo json_encode(['success' => false, 'message' => 'No action specified']);
    exit;
}

$action = sanitize($_GET['action']);

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($action === 'add') {
    $id = intval($_GET['id'] ?? 0);
    if ($id > 0) {
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
        echo json_encode(['success' => true, 'count' => array_sum($_SESSION['cart'])]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid item ID']);
    }
} elseif ($action === 'count') {
    $count = array_sum($_SESSION['cart'] ?? []);
    echo json_encode(['count' => $count]);
} else {
    echo json_encode(['success' => false, 'message' => 'Unknown action']);
}
?>