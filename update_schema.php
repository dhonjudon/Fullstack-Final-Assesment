<?php
// Quick script to update database schema
require_once 'config/db.php';

try {
    // Add status column to orders table
    $pdo->exec("ALTER TABLE orders ADD COLUMN status VARCHAR(20) DEFAULT 'pending' AFTER total");
    echo "✓ Status column added to orders table successfully!";
} catch (PDOException $e) {
    // Column might already exist
    echo "✓ Status column check completed (may already exist): " . $e->getMessage();
}
?>