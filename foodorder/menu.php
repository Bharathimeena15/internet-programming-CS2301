<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';

$pageTitle = "Menu";
$basePath = "";

// Fetch categories dynamically
$categories = [];
$catResult = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
while ($row = $catResult->fetch_assoc()) {
    $categories[] = $row;
}

// Fetch all available menu items with their category name
$items = [];
$itemResult = $conn->query("
    SELECT m.item_id, m.item_name, m.description, m.price, m.image, c.category_name
    FROM menu_items m
    LEFT JOIN categories c ON m.category_id = c.category_id
    WHERE m.is_available = 1
    ORDER BY c.category_name, m.item_name
");
while ($row = $itemResult->fetch_assoc()) {
    $items[] = $row;
}

include 'includes/header.php';
?>

<h1 class="section-title">Our Menu</h1>

<div class="category-filter">
    <a href="#" data-category="all" class="active">All</a>
    <?php foreach ($categories as $cat): ?>
        <a href="#" data-category="<?php echo clean($cat['category_name']); ?>"><?php echo clean($cat['category_name']); ?></a>
    <?php endforeach; ?>
</div>

<div class="menu-grid">
    <?php foreach ($items as $item): ?>
        <div class="menu-card" data-category="<?php echo clean($item['category_name']); ?>">
            <div class="menu-card-img">🍽️</div>
            <div class="menu-card-body">
                <h3><?php echo clean($item['item_name']); ?></h3>
                <p><?php echo clean($item['description']); ?></p>
                <div class="menu-card-footer">
                    <span class="price">₹<?php echo number_format($item['price'], 2); ?></span>

                    <?php if (isLoggedIn()): ?>
                        <form class="add-to-cart-form" style="display:flex; gap:6px; align-items:center;">
                            <input type="hidden" name="item_id" value="<?php echo (int)$item['item_id']; ?>">
                            <input type="number" name="quantity" value="1" min="1" class="qty-input" style="width:46px;">
                            <button type="submit" class="btn btn-small btn-primary">Add</button>
                        </form>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-small">Login to order</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($items)): ?>
        <p>No menu items are available right now.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
