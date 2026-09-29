<?php
require_once '../includes/functions.php';
require_once '../includes/db.php';
requireLogin();
requireAdmin();

$pageTitle = "Admin Dashboard";
$basePath = "../";

$totalOrders = $conn->query("SELECT COUNT(*) AS c FROM orders")->fetch_assoc()['c'];
$totalRevenue = $conn->query("SELECT COALESCE(SUM(total_amount),0) AS s FROM orders WHERE status != 'Cancelled'")->fetch_assoc()['s'];
$totalUsers = $conn->query("SELECT COUNT(*) AS c FROM users WHERE role = 'customer'")->fetch_assoc()['c'];
$totalItems = $conn->query("SELECT COUNT(*) AS c FROM menu_items")->fetch_assoc()['c'];

include '../includes/header.php';
?>

<h1 class="section-title">Admin Dashboard</h1>

<div class="menu-grid" style="margin-bottom:30px;">
    <div class="menu-card"><div class="menu-card-body"><h3>Total Orders</h3><p class="price"><?php echo $totalOrders; ?></p></div></div>
    <div class="menu-card"><div class="menu-card-body"><h3>Revenue</h3><p class="price">₹<?php echo number_format($totalRevenue, 2); ?></p></div></div>
    <div class="menu-card"><div class="menu-card-body"><h3>Customers</h3><p class="price"><?php echo $totalUsers; ?></p></div></div>
    <div class="menu-card"><div class="menu-card-body"><h3>Menu Items</h3><p class="price"><?php echo $totalItems; ?></p></div></div>
</div>

<div style="display:flex; gap:14px; flex-wrap:wrap;">
    <a href="manage_menu.php" class="btn btn-primary">Manage Menu Items</a>
    <a href="manage_orders.php" class="btn btn-primary">Manage Orders</a>
</div>

<?php include '../includes/footer.php'; ?>
