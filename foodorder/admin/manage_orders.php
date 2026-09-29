<?php
require_once '../includes/functions.php';
require_once '../includes/db.php';
requireLogin();
requireAdmin();

$pageTitle = "Manage Orders";
$basePath = "../";

$validStatuses = ['Pending', 'Confirmed', 'Preparing', 'Out for Delivery', 'Delivered', 'Cancelled'];

// ---- Handle status update ----
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $status = $_POST['status'];
    if (in_array($status, $validStatuses)) {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
        $stmt->bind_param("si", $status, $order_id);
        $stmt->execute();
        $stmt->close();
        $_SESSION['flash_message'] = "Order #$order_id updated to $status.";
        $_SESSION['flash_type'] = "success";
    }
    redirect("manage_orders.php");
}

$orders = $conn->query("
    SELECT o.order_id, o.total_amount, o.status, o.order_date, o.delivery_address, u.full_name, u.phone
    FROM orders o JOIN users u ON o.user_id = u.user_id
    ORDER BY o.order_date DESC
");

include '../includes/header.php';
?>

<h1 class="section-title">Manage Orders</h1>

<table>
    <thead>
        <tr><th>Order</th><th>Customer</th><th>Address</th><th>Total</th><th>Status</th><th>Update</th></tr>
    </thead>
    <tbody>
        <?php while ($o = $orders->fetch_assoc()): ?>
            <tr>
                <td>#<?php echo $o['order_id']; ?><br><small><?php echo date("d M, h:i A", strtotime($o['order_date'])); ?></small></td>
                <td><?php echo clean($o['full_name']); ?><br><small><?php echo clean($o['phone']); ?></small></td>
                <td><?php echo clean($o['delivery_address']); ?></td>
                <td>₹<?php echo number_format($o['total_amount'], 2); ?></td>
                <td><span class="badge <?php echo str_replace(' ', '-', $o['status']); ?>"><?php echo clean($o['status']); ?></span></td>
                <td>
                    <form method="POST" action="manage_orders.php" style="display:flex; gap:6px;">
                        <input type="hidden" name="order_id" value="<?php echo $o['order_id']; ?>">
                        <select name="status">
                            <?php foreach ($validStatuses as $s): ?>
                                <option value="<?php echo $s; ?>" <?php echo $s === $o['status'] ? 'selected' : ''; ?>><?php echo $s; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-small btn-primary">Save</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
