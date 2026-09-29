<?php
require_once '../includes/functions.php';
require_once '../includes/db.php';
requireLogin();
requireAdmin();

$pageTitle = "Manage Menu";
$basePath = "../";
$errors = [];

// ---- Handle Add Item ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $item_name = trim($_POST['item_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $category_id = (int)($_POST['category_id'] ?? 0);

    if ($item_name === '' || $price <= 0 || $category_id <= 0) {
        $errors[] = "Please fill in a valid name, price, and category.";
    } else {
        $stmt = $conn->prepare("INSERT INTO menu_items (category_id, item_name, description, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $category_id, $item_name, $description, $price);
        $stmt->execute();
        $stmt->close();
        $_SESSION['flash_message'] = "Menu item added.";
        $_SESSION['flash_type'] = "success";
        redirect("manage_menu.php");
    }
}

// ---- Handle Delete Item ----
if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM menu_items WHERE item_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['flash_message'] = "Menu item removed.";
    $_SESSION['flash_type'] = "info";
    redirect("manage_menu.php");
}

// ---- Handle Toggle Availability ----
if (isset($_GET['toggle'])) {
    $toggle_id = (int)$_GET['toggle'];
    $conn->query("UPDATE menu_items SET is_available = 1 - is_available WHERE item_id = $toggle_id");
    redirect("manage_menu.php");
}

$categories = $conn->query("SELECT category_id, category_name FROM categories ORDER BY category_name");
$items = $conn->query("SELECT m.*, c.category_name FROM menu_items m LEFT JOIN categories c ON m.category_id = c.category_id ORDER BY m.item_id DESC");

include '../includes/header.php';
?>

<h1 class="section-title">Manage Menu Items</h1>

<div class="form-card" style="max-width:560px;">
    <h2>Add New Item</h2>
    <?php if (!empty($errors)): ?>
        <div class="form-error"><?php foreach ($errors as $e) echo "<p>" . clean($e) . "</p>"; ?></div>
    <?php endif; ?>
    <form method="POST" action="manage_menu.php">
        <div class="form-group">
            <label>Item Name</label>
            <input type="text" name="item_name" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="2"></textarea>
        </div>
        <div class="form-group">
            <label>Price (₹)</label>
            <input type="number" step="0.01" name="price" required>
        </div>
        <div class="form-group">
            <label>Category</label>
            <select name="category_id" required>
                <option value="">-- Select --</option>
                <?php
                $categories->data_seek(0);
                while ($cat = $categories->fetch_assoc()):
                ?>
                    <option value="<?php echo $cat['category_id']; ?>"><?php echo clean($cat['category_name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" name="add_item" class="btn btn-primary" style="width:100%;">Add Item</button>
    </form>
</div>

<h2 class="section-title">Existing Items</h2>
<table>
    <thead>
        <tr><th>Name</th><th>Category</th><th>Price</th><th>Status</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php while ($item = $items->fetch_assoc()): ?>
            <tr>
                <td><?php echo clean($item['item_name']); ?></td>
                <td><?php echo clean($item['category_name'] ?? '-'); ?></td>
                <td>₹<?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['is_available'] ? '<span class="badge Delivered">Available</span>' : '<span class="badge Cancelled">Hidden</span>'; ?></td>
                <td>
                    <a href="manage_menu.php?toggle=<?php echo $item['item_id']; ?>" class="btn btn-small">Toggle</a>
                    <a href="manage_menu.php?delete=<?php echo $item['item_id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Delete this item?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
