<!DOCTYPE html>
<html>

<head>
    <title>Online Store - Place Order</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #f8f9fa);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 480px;
            background: white;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .heading {
            text-align: center;
            margin-bottom: 8px;
        }

        .heading h1 {
            margin: 0;
            font-size: 28px;
            color: #222;
        }

        .heading p {
            margin-top: 8px;
            color: #777;
            font-size: 14px;
        }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 7px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #2196f3;
        }

        .submit-btn {
            width: 100%;
            margin-top: 25px;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background-color: #2196f3;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #1976d2;
        }

        .view-section {
            text-align: center;
            margin-top: 22px;
        }

        .view-btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 8px;
            background-color: #f1f1f1;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .view-btn:hover {
            background-color: #e0e0e0;
        }

    </style>
</head>

<body>

    <div class="card">

        <div class="heading">
            <h1>Place Your Order</h1>
            <p>Enter the details of your product below</p>
        </div>

        <form action="insert_order.php" method="POST">

            <label>Customer Name</label>
            <input type="text" name="customer_name"
                   placeholder="Enter your name" required>

            <label>Product Name</label>
            <input type="text" name="product_name"
                   placeholder="Enter product name" required>

            <label>Quantity</label>
            <input type="number" name="quantity"
                   min="1" placeholder="Enter quantity" required>

            <label>Price</label>
            <input type="number" name="price"
                   step="0.01" min="0"
                   placeholder="Enter price" required>

            <input type="submit"
                   value="Place Order"
                   class="submit-btn">

        </form>

        <div class="view-section">
            <a href="view_orders.php" class="view-btn">
                View Existing Orders
            </a>
        </div>

    </div>

</body>

</html>