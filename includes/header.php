<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Patio Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/patio_fav/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/patio_fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/patio_fav/favicon-16x16.png">
    <link rel="apple-touch-icon" href="../assets/img/patio_fav/apple-touch-icon.png">
    <link rel="manifest" href="../assets/img/patio_fav/site.webmanifest">
    <script>
        // Handle responsive layout: sidebar on desktop, navbar on mobile
        function handleLayout() {
            if (window.innerWidth <= 768) {
                document.body.style.marginLeft = '0';
            } else {
                document.body.style.marginLeft = '280px';
            }
        }
        window.addEventListener('load', handleLayout);
        window.addEventListener('resize', handleLayout);
    </script>
</head>

<body>
    <header>
        <h1>Patio Café Management System</h1>
        <nav>
            <a href="menu.php">Menu</a>
            <?php if (empty($_SESSION['admin_logged_in'])): ?>
                <a href="cart.php" class="cart-link">Cart <span class="cart-count" id="cartCount"></span></a>
            <?php else: ?>
                <a href="index.php">Admin Home</a>
                <a href="orders.php">Orders</a>
                <a href="revenue.php">Revenue</a>
                <a href="search.php">Search</a>
                <a href="categories.php">Categories</a>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>