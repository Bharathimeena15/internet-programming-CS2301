<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';
requireLogin();

$pageTitle = "My Cart";
$basePath = "";

$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

include 'includes/header.php';
?>

<h1 class="section-title">My Cart</h1>

<?php if (empty($cart)): ?>
    <p>Your cart is empty. <a href="menu.php">Browse the menu</a> to add items.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart as $item): ?>
                <tr>
                    <td><?php echo clean($item['item_name']); ?></td>
                    <td>₹<?php echo number_format($item['price'], 2); ?></td>
                    <td>
                        <input type="number" class="qty-input" min="1" value="<?php echo (int)$item['quantity']; ?>" data-item-id="<?php echo (int)$item['item_id']; ?>">
                    </td>
                    <td>₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    <td><button class="btn btn-small btn-danger remove-item-btn" data-item-id="<?php echo (int)$item['item_id']; ?>">Remove</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="cart-summary">
        <div class="row total">
            <span>Total</span>
            <span>₹<?php echo number_format($total, 2); ?></span>
        </div>
        <a href="checkout.php" class="btn btn-primary" style="width:100%; text-align:center; margin-top:14px;">Proceed to Checkout</a>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
