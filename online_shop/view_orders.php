<?php

include "db_connect.php";

$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Order History</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #f8f9fa);
            min-height: 100vh;
            padding: 45px 20px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            color: #222;
            font-size: 28px;
        }

        .header p {
            color: #777;
            margin-top: 8px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #2196f3;
            color: white;
            padding: 13px;
            text-align: center;
        }

        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: #444;
        }

        tr:hover {
            background-color: #f5f9ff;
        }

        .price {
            font-weight: bold;
        }

        .empty {
            padding: 25px;
            color: #777;
        }

        .actions {
            text-align: center;
            margin-top: 25px;
        }

        .button {
            display: inline-block;
            padding: 11px 20px;
            margin: 5px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .new-order {
            background-color: #2196f3;
            color: white;
        }

        .new-order:hover {
            background-color: #1976d2;
        }

        .home {
            background-color: #eeeeee;
            color: #333;
        }

        .home:hover {
            background-color: #dddddd;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="header">

        <h1>Order History</h1>

        <p>View all orders stored in the online shop database</p>

    </div>

    <div class="table-wrapper">

        <table>

            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Order Date</th>
            </tr>

            <?php

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    echo "<tr>";

                    echo "<td>" . $row['order_id'] . "</td>";

                    echo "<td>" . $row['customer_name'] . "</td>";

                    echo "<td>" . $row['product_name'] . "</td>";

                    echo "<td>" . $row['quantity'] . "</td>";

                    echo "<td class='price'>₹" . number_format($row['price'], 2) . "</td>";

                    echo "<td>" . $row['order_date'] . "</td>";

                    echo "</tr>";
                }

            } else {

                echo "<tr>";
                echo "<td colspan='6' class='empty'>";
                echo "No orders have been placed yet.";
                echo "</td>";
                echo "</tr>";
            }

            ?>

        </table>

    </div>

    <div class="actions">

        <a href="index.php" class="button new-order">
            + Place New Order
        </a>

        <a href="index.php" class="button home">
            Back to Home
        </a>

    </div>

</div>

</body>

</html>

<?php

$conn->close();

?>