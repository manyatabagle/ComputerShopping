<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && isset($_POST['address'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    unset($_SESSION['cart']);
} else {

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        /* Global reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
            color: #333;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('images/back.jpeg');
            background-size: cover;
            background-position: center;
            transition: all 0.3s ease;
        }

        /* Container for the content */
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        /* Heading styling */
        h1 {
            font-size: 2.5em;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Paragraph styling */
        p {
            font-size: 1.2em;
            color: #34495e;
            margin-bottom: 20px;
        }

        /* Button styling */
        .btn {
            background-color: #3498db;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.1em;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            display: inline-block;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        /* Animation for fade-in */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-50px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Thank You for Your Order, <?php echo htmlspecialchars($name); ?>!</h1>
    <p>Your order will be shipped to:</p>
    <p><strong><?php echo htmlspecialchars($address); ?></strong></p>
    <a href="index.php" class="btn">Go Back to Home</a>
</div>

</body>
</html>