<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Please login first.']);
    exit();
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';
$item_id = isset($_POST['item_id']) ? (int)$_POST['item_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($item_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid item.']);
    exit();
}

switch ($action) {

    case 'add':
        // Look up item details from DB so price can't be tampered with client-side
        $stmt = $conn->prepare("SELECT item_id, item_name, price FROM menu_items WHERE item_id = ? AND is_available = 1");
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'Item not found.']);
            exit();
        }
        $item = $result->fetch_assoc();
        $stmt->close();

        if (isset($_SESSION['cart'][$item_id])) {
            $_SESSION['cart'][$item_id]['quantity'] += max(1, $quantity);
        } else {
            $_SESSION['cart'][$item_id] = [
                'item_id' => $item['item_id'],
                'item_name' => $item['item_name'],
                'price' => $item['price'],
                'quantity' => max(1, $quantity)
            ];
        }
        echo json_encode(['success' => true, 'cartCount' => cartCount()]);
        break;

    case 'update':
        if (isset($_SESSION['cart'][$item_id])) {
            $_SESSION['cart'][$item_id]['quantity'] = max(1, $quantity);
        }
        echo json_encode(['success' => true, 'cartCount' => cartCount()]);
        break;

    case 'remove':
        unset($_SESSION['cart'][$item_id]);
        echo json_encode(['success' => true, 'cartCount' => cartCount()]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Unknown action.']);
}
?>
