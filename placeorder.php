<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customer_name = $_POST["customer_name"];
    $email = $_POST["email"];
    $product_name = $_POST["product_name"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    // Calculate total price
    $total = $quantity * $price;

    // Insert order into database
    $sql = "INSERT INTO orders
            (customer_name, email, product_name, quantity, price, total)
            VALUES
            ('$customer_name', '$email', '$product_name',
             '$quantity', '$price', '$total')";

    if ($conn->query($sql) === TRUE) {

        echo "<h2>Order placed successfully!</h2>";

        echo "<p>Customer Name: " . $customer_name . "</p>";
        echo "<p>Product: " . $product_name . "</p>";
        echo "<p>Quantity: " . $quantity . "</p>";
        echo "<p>Total: ₹" . $total . "</p>";

        echo "<br>";
        echo "<a href='index.php'>Back to Shopping</a>";

        echo "<br><br>";
        echo "<a href='viewOrders.php'>View All Orders</a>";

    } else {

        echo "Error: " . $conn->error;
    }
}

$conn->close();

?>