<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';
requireLogin();

$pageTitle = "Checkout";
$basePath = "";
$errors = [];

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    redirect("cart.php");
}

$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delivery_address = trim($_POST['delivery_address'] ?? '');
    $payment_mode = $_POST['payment_mode'] ?? 'COD';

    if (strlen($delivery_address) < 10) {
        $errors[] = "Please enter a complete delivery address.";
    }
    if (!in_array($payment_mode, ['COD', 'Online'])) {
        $payment_mode = 'COD';
    }

    if (empty($errors)) {
        // Start a transaction so the order and its items are saved together
        $conn->begin_transaction();
        try {
            $user_id = $_SESSION['user_id'];

            $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, delivery_address, payment_mode, status) VALUES (?, ?, ?, ?, 'Pending')");
            $stmt->bind_param("idss", $user_id, $total, $delivery_address, $payment_mode);
            $stmt->execute();
            $order_id = $conn->insert_id;
            $stmt->close();

            $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, item_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($cart as $item) {
                $itemStmt->bind_param("iiid", $order_id, $item['item_id'], $item['quantity'], $item['price']);
                $itemStmt->execute();
            }
            $itemStmt->close();

            $conn->commit();

            // Clear the cart after a successful order
            $_SESSION['cart'] = [];

            redirect("order_success.php?order_id=" . $order_id);
        } catch (Exception $e) {
            $conn->rollback();
            $errors[] = "Could not place your order. Please try again.";
        }
    }
}

include 'includes/header.php';
?>

<h1 class="section-title">Checkout</h1>

<div class="form-card">
    <?php if (!empty($errors)): ?>
        <div class="form-error">
            <?php foreach ($errors as $e) echo "<p>" . clean($e) . "</p>"; ?>
        </div>
    <?php endif; ?>

    <form id="checkoutForm" method="POST" action="checkout.php">
        <div class="form-group">
            <label for="delivery_address">Delivery Address</label>
            <textarea id="delivery_address" name="delivery_address" rows="3" required><?php echo isset($_POST['delivery_address']) ? clean($_POST['delivery_address']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="payment_mode">Payment Mode</label>
            <select id="payment_mode" name="payment_mode">
                <option value="COD">Cash on Delivery</option>
                <option value="Online">Online Payment</option>
            </select>
        </div>

        <div class="cart-summary" style="margin:0 0 18px;">
            <div class="row total">
                <span>Order Total</span>
                <span>₹<?php echo number_format($total, 2); ?></span>
            </div>
        </div>

        <p class="form-error" id="checkoutError"></p>
        <button type="submit" class="btn btn-primary" style="width:100%;">Place Order</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
