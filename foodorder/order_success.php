<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';
requireLogin();

$pageTitle = "Order Confirmed";
$basePath = "";

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

// Make sure this order belongs to the logged-in user
$stmt = $conn->prepare("SELECT order_id, total_amount, delivery_address, payment_mode, status, order_date FROM orders WHERE order_id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $_SESSION['user_id']);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    redirect("index.php");
}

include 'includes/header.php';
?>

<div class="form-card" style="text-align:center;">
    <h2 style="color:var(--success);">✅ Order Placed Successfully!</h2>
    <p style="margin:14px 0;">Thank you! Your order <strong>#<?php echo $order['order_id']; ?></strong> has been received.</p>
    <p>Total: <strong>₹<?php echo number_format($order['total_amount'], 2); ?></strong></p>
    <p>Payment Mode: <?php echo clean($order['payment_mode']); ?></p>
    <p>Status: <span class="badge <?php echo str_replace(' ', '-', $order['status']); ?>"><?php echo clean($order['status']); ?></span></p>
    <a href="my_orders.php" class="btn btn-primary" style="margin-top:18px;">View My Orders</a>
</div>

<?php include 'includes/footer.php'; ?>
