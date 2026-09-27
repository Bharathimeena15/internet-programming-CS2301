<!DOCTYPE html>
<html>
<head>

    <title>Online Shopping</title>

    <style>

        body {
            font-family: Arial;
            background-color: #f2f2f2;
            margin: 0;
        }

        .header {
            background-color: #2874f0;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .container {
            width: 90%;
            margin: 30px auto;
        }

        .order-box {
            background-color: white;
            padding: 25px;
            margin-top: 30px;
            border-radius: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px 0;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px 0;
        }

        button {
            background-color: #2874f0;
            color: white;
            border: none;
            padding: 12px 25px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #1259c3;
        }

        .view-button {
            display: inline-block;
            background-color: green;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

    </style>

</head>

<body>

<div class="header">

    <h1>Online Shopping</h1>

    <p>PHP + MySQL Order Management</p>

</div>


<div class="container">

    <div class="order-box">

        <h2>Place Your Order</h2>

        <form action="placeOrder.php" method="POST">

            <label>Customer Name:</label>

            <input type="text"
                   name="customer_name"
                   required>


            <label>Email:</label>

            <input type="email"
                   name="email"
                   required>


            <label>Select Product:</label>

            <select name="product_name" required>

                <option value="Laptop">
                    Laptop - ₹55000
                </option>

                <option value="Smart Phone">
                    Smart Phone - ₹25000
                </option>

                <option value="Headphones">
                    Headphones - ₹1500
                </option>

                <option value="Smart Watch">
                    Smart Watch - ₹3500
                </option>

                <option value="Bluetooth Speaker">
                    Bluetooth Speaker - ₹2200
                </option>

            </select>


            <label>Quantity:</label>

            <input type="number"
                   name="quantity"
                   min="1"
                   value="1"
                   required>


            <label>Price:</label>

            <input type="number"
                   name="price"
                   value="55000"
                   required>


            <button type="submit">
                Place Order
            </button>

        </form>


        <a class="view-button"
           href="viewOrders.php">

            View All Orders

        </a>

    </div>

</div>

</body>
</html>