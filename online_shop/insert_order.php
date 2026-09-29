<?php

include "db_connect.php";

$customer_name = $_POST['customer_name'];
$product_name = $_POST['product_name'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];

$sql = "INSERT INTO orders
        (customer_name, product_name, quantity, price)
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssid",
    $customer_name,
    $product_name,
    $quantity,
    $price
);

if ($stmt->execute()) {

?>

<!DOCTYPE html>
<html>

<head>

    <title>Order Confirmed</title>

    <style>

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #f8f9fa);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .message-box {
            width: 450px;
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .message-box h1 {
            color: #2196f3;
            margin-bottom: 12px;
        }

        .message-box p {
            color: #666;
            margin-bottom: 25px;
        }

        .button {
            display: inline-block;
            padding: 11px 20px;
            margin: 5px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .view-button {
            background-color: #2196f3;
            color: white;
        }

        .view-button:hover {
            background-color: #1976d2;
        }

        .new-button {
            background-color: #eeeeee;
            color: #333;
        }

        .new-button:hover {
            background-color: #dddddd;
        }

    </style>

</head>

<body>

    <div class="message-box">

        <h1>Order Confirmed!</h1>

        <p>
            Your order has been saved successfully.
        </p>

        <a href="view_orders.php" class="button view-button">
            View All Orders
        </a>

        <a href="index.php" class="button new-button">
            Place Another Order
        </a>

    </div>

</body>

</html>

<?php

} else {

    echo "Unable to save the order: " . $stmt->error;

}

$stmt->close();
$conn->close();

?>