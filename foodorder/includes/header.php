<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($pageTitle) ? clean($pageTitle) . ' - ' : ''; ?>Spice Route Restaurant</title>
<link rel="stylesheet" href="<?php echo isset($basePath) ? $basePath : ''; ?>css/style.css">
</head>
<body>

<header class="navbar">
    <div class="nav-container">
        <a href="<?php echo isset($basePath) ? $basePath : ''; ?>index.php" class="logo">🍽️ Spice Route</a>
        <nav>
            <ul class="nav-links">
                <li><a href="<?php echo isset($basePath) ? $basePath : ''; ?>index.php">Home</a></li>
                <li><a href="<?php echo isset($basePath) ? $basePath : ''; ?>menu.php">Menu</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="<?php echo isset($basePath) ? $basePath : ''; ?>cart.php">Cart (<span id="cartCount"><?php echo cartCount(); ?></span>)</a></li>
                    <li><a href="<?php echo isset($basePath) ? $basePath : ''; ?>my_orders.php">My Orders</a></li>
                    <?php if (isAdmin()): ?>
                        <li><a href="<?php echo isset($basePath) ? $basePath : ''; ?>admin/dashboard.php">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo isset($basePath) ? $basePath : ''; ?>logout.php">Logout (<?php echo clean($_SESSION['full_name']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="<?php echo isset($basePath) ? $basePath : ''; ?>login.php">Login</a></li>
                    <li><a href="<?php echo isset($basePath) ? $basePath : ''; ?>register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="flash-message <?php echo clean($_SESSION['flash_type'] ?? 'info'); ?>">
        <?php echo clean($_SESSION['flash_message']); unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<main class="page-content">
