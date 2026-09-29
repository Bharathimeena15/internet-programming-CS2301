<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';

$pageTitle = "Home";
$basePath = "";

// Fetch 4 featured items for the homepage (dynamic content from DB)
$featured = [];
$result = $conn->query("SELECT item_id, item_name, description, price, image FROM menu_items WHERE is_available = 1 ORDER BY item_id DESC LIMIT 4");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $featured[] = $row;
    }
}

include 'includes/header.php';
?>

<section class="hero">
    <h1>Authentic Flavours, Delivered Fresh</h1>
    <p>Order your favourite dishes online from Spice Route Restaurant.</p>
    <a href="menu.php" class="btn btn-primary">View Menu</a>
</section>

<h2 class="section-title">Popular Right Now</h2>
<div class="menu-grid">
    <?php foreach ($featured as $item): ?>
        <div class="menu-card">
            <div class="menu-card-img">🍛</div>
            <div class="menu-card-body">
                <h3><?php echo clean($item['item_name']); ?></h3>
                <p><?php echo clean($item['description']); ?></p>
                <div class="menu-card-footer">
                    <span class="price">₹<?php echo number_format($item['price'], 2); ?></span>
                    <a href="menu.php" class="btn btn-small btn-primary">Order</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($featured)): ?>
        <p>No menu items available yet. Please check back soon.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
