<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patio Management System</title>
    <link rel="stylesheet" href="/final-ass/assets/css/style.css">
</head>

<body>
    <header>
        <h1>Patio Café Management System</h1>
        <nav>
            <a href="menu.php">Menu</a>
            <?php if (empty($_SESSION['admin_logged_in'])): ?>
                <a href="cart.php">Cart</a>
            <?php else: ?>
                | <a href="index.php">Admin Home</a>
                | <a href="add.php">Add Item</a>
                | <a href="orders.php">Orders</a>
                | <a href="search.php">Search</a>
                | <a href="categories.php">Categories</a>
                | <a href="logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>