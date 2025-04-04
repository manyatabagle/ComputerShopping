<?php
session_start();

// Calculate total price
$total_price = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }
}

// If no items in the cart, redirect to the homepage
if ($total_price == 0) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 80%;
            max-width: 600px;
            margin-top: 50px;
        }

        h1 {
            font-size: 2.5em;
            color: #FF5722;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 15px;
        }

        .cart-items {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: left;
        }

        .cart-items li {
            margin-bottom: 15px;
            font-size: 1.2em;
            color: #555;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .cart-items li span {
            color: #FF5722;
        }

        .total-price {
            font-size: 1.6em;
            font-weight: bold;
            color: #333;
            margin-top: 20px;
        }

        .form-container {
            margin-top: 30px;
            text-align: left;
        }

        .form-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 1.2em;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .form-container button {
            background-color: #FF5722;
            color: white;
            padding: 15px;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #E64A19;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #FF5722;
            font-size: 1.2em;
        }

        .back-link:hover {
            color: #E64A19;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Checkout</h1>

    <h2>Your Cart</h2>
    <ul class="cart-items">
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <li>
                <?php echo $item['name']; ?> (x<?php echo $item['quantity']; ?>) - <span><?php echo $item['price'] * $item['quantity']; ?></span>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="total-price">
        <h2>Total Price: <?php echo number_format($total_price, 2); ?></h2>
    </div>

    <div class="form-container">
        <h3>Enter Shipping Information</h3>
        <form action="order.php" method="post">
            <input type="text" name="name" placeholder="Your Name" required><br>
            <input type="text" name="address" placeholder="Your Address" required><br>
            <button type="submit">Place Order</button>
        </form>
    </div>

    <a href="index.php" class="back-link">Back to Shopping</a>
</div>

</body>
</html>