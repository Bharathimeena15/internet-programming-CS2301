<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';
requireLogin();

$pageTitle = "My Orders";
$basePath = "";

$stmt = $conn->prepare("SELECT order_id, total_amount, status, order_date FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$orders = $stmt->get_result();

include 'includes/header.php';
?>

<h1 class="section-title">My Orders</h1>

<?php if ($orders->num_rows === 0): ?>
    <p>You haven't placed any orders yet. <a href="menu.php">Order something delicious</a>.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Items</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $order['order_id']; ?></td>
                    <td><?php echo date("d M Y, h:i A", strtotime($order['order_date'])); ?></td>
                    <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td><span class="badge <?php echo str_replace(' ', '-', $order['status']); ?>"><?php echo clean($order['status']); ?></span></td>
                    <td>
                        <?php
                        $itemStmt = $conn->prepare("SELECT m.item_name, oi.quantity FROM order_items oi JOIN menu_items m ON oi.item_id = m.item_id WHERE oi.order_id = ?");
                        $itemStmt->bind_param("i", $order['order_id']);
                        $itemStmt->execute();
                        $itemsResult = $itemStmt->get_result();
                        $lines = [];
                        while ($it = $itemsResult->fetch_assoc()) {
                            $lines[] = clean($it['item_name']) . " x" . $it['quantity'];
                        }
                        echo implode(", ", $lines);
                        $itemStmt->close();
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include 'includes/footer.php'; $stmt->close(); ?>
