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
    <style>
        @media (max-width: 768px) {
            body {
                margin-left: 0 !important;
                padding-top: 100px !important;
            }

            header {
                position: fixed !important;
                left: 0 !important;
                top: 0 !important;
                right: 0 !important;
                height: auto !important;
                width: 100% !important;
                flex-direction: column !important;
                padding: 0.8rem 0 !important;
            }

            header h1 {
                margin: 0 0 0.5rem 0 !important;
                font-size: 1.2rem !important;
            }

            header nav {
                flex-direction: row !important;
                justify-content: center !important;
                gap: 1.5rem !important;
                padding: 0 !important;
            }

            header nav a {
                margin: 0 !important;
                display: inline-block !important;
            }

            main {
                margin-left: 0 !important;
                padding: 1rem !important;
                width: 100% !important;
            }
        }
    </style>
    <script>
        function checkMobile() {
            if (window.innerWidth <= 768) {
                document.body.style.marginLeft = '0';
                document.body.style.paddingTop = '100px';
            } else {
                document.body.style.marginLeft = '280px';
                document.body.style.paddingTop = '0';
            }
        }
        window.addEventListener('load', checkMobile);
        window.addEventListener('resize', checkMobile);
    </script>
</head>

<body style="margin-left: 280px !important;">
    <header
        style="position: fixed !important; left: 0; top: 0; height: 100vh; width: 280px; z-index: 1000; background: #5d4037; box-shadow: 2px 0 8px rgba(0,0,0,0.2); padding: 2rem 0; display: flex; flex-direction: column;">
        <h1 style="text-align: center; padding: 0 1rem; margin: 0 0 2rem 0; font-size: 1.3rem; line-height: 1.3;">Patio
            Café Management System</h1>
        <nav style="display: flex; flex-direction: column; padding: 0 1rem;">
            <a href="menu.php" style="margin: 1rem 0; display: block;">Menu</a>
            <?php if (empty($_SESSION['admin_logged_in'])): ?>
                <a href="cart.php" class="cart-link" style="margin: 1rem 0; display: block;">Cart <span class="cart-count"
                        id="cartCount" style="margin-left: 0.5rem;"></span></a>
            <?php else: ?>
                <a href="index.php" style="margin: 1rem 0; display: block;">Admin Home</a>
                <a href="orders.php" style="margin: 1rem 0; display: block;">Orders</a>
                <a href="revenue.php" style="margin: 1rem 0; display: block;">Revenue</a>
                <a href="search.php" style="margin: 1rem 0; display: block;">Search</a>
                <a href="categories.php" style="margin: 1rem 0; display: block;">Categories</a>
                <a href="logout.php" style="margin: 1rem 0; display: block;">Logout</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>