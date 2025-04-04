
<?php
session_start();

$products = [
    ['id' => 1, 'name' => 'HP Laptop', 'price' => 600000, 'brand' => 'HP', 'image' => 'images/hp_laptop.jpg'],
    ['id' => 2, 'name' => 'Dell XPS 13', 'price' => 800000, 'brand' => 'Dell', 'image' => 'images/dell_xps.jpeg'],
    ['id' => 3, 'name' => 'Lenovo ThinkPad', 'price' => 7000950, 'brand' => 'Lenovo', 'image' => 'images/lenovo_thinkpad.jpeg'],
    ['id' => 4, 'name' => 'MacBook Air', 'price' => 12988700, 'brand' => 'Apple', 'image' => 'images/macbook_air.jpeg'],
    ['id' => 5, 'name' => 'Alienware Gaming Laptop', 'price' => 15546500, 'brand' => 'Alienware', 'image' => 'images/alienware_gaming.jpeg'],
    ['id' => 6, 'name' => 'Asus ROG Strix', 'price' => 1467800, 'brand' => 'Asus', 'image' => 'images/asus_rog.jpeg'],
    ['id' => 7, 'name' => 'MSI Modern 14', 'price' => 6599900, 'brand' => 'MSI', 'image' => 'images/msi_modern14.jpeg'],
    ['id' => 8, 'name' => 'Acer Aspire 7', 'price' => 5799900, 'brand' => 'Acer', 'image' => 'images/acer_aspire7.jpeg'],
    ['id' => 9, 'name' => 'Samsung Galaxy Book 3', 'price' => 8199900, 'brand' => 'Samsung', 'image' => 'images/galaxy_book3.jpeg'],
    ['id' => 10, 'name' => 'Microsoft Surface Laptop Go', 'price' => 6299900, 'brand' => 'Microsoft', 'image' => 'images/surface_laptop_go.jpeg'],
];

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$search = strtolower($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? '';

$filtered_products = array_filter($products, function ($product) use ($search) {
    return $search === '' || strpos(strtolower($product['name']), $search) !== false;
});

if ($sort === 'price_asc') usort($filtered_products, fn($a, $b) => $a['price'] - $b['price']);
if ($sort === 'price_desc') usort($filtered_products, fn($a, $b) => $b['price'] - $a['price']);

if (isset($_GET['action'])) {
    $id = $_GET['id'];
    switch ($_GET['action']) {
        case 'add':
            if (isset($products[$id - 1])) {
                if (isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]['quantity']++;
                else $_SESSION['cart'][$id] = ['name' => $products[$id - 1]['name'], 'price' => $products[$id - 1]['price'], 'quantity' => 1];
            }
            break;
        case 'remove':
            unset($_SESSION['cart'][$id]);
            break;
        case 'clear_cart':
            $_SESSION['cart'] = [];
            break;
    }
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Shop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Roboto', sans-serif; background-color: #f5f5f5; color: #333; }

        .navbar {
            background: #212529;
            padding: 15px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar h2 { font-weight: 700; font-size: 24px; }
        .navbar a {
            color: #ddd;
            text-decoration: none;
            margin-left: 20px;
            transition: color 0.3s;
        }
        .navbar a:hover { color: #fff; }

        .layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: 220px;
            background: #343a40;
            padding: 25px 15px;
            color: white;
            height: 100vh;
        }
        .sidebar h3 { font-size: 18px; margin-bottom: 20px; }
        .sidebar a {
            color: #ccc;
            display: block;
            margin: 12px 0;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar a:hover {
            background: #495057;
            color: #fff;
        }

        .container {
            flex-grow: 1;
            padding: 30px;
        }

        .form-inline {
            margin-bottom: 20px;
        }
        .form-inline input, .form-inline select {
            padding: 8px 12px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-inline button {
            padding: 8px 14px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
        }
        .product {
            width: 250px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin: 15px;
            overflow: hidden;
            transition: transform 0.3s;
        }
        .product:hover {
            transform: translateY(-5px);
        }
        .product img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .product-info {
            padding: 15px;
        }
        .product-info h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .product-info p {
            margin: 5px 0;
            color: #555;
        }
        .add-to-cart {
            background: linear-gradient(to right, #28a745, #218838);
            color: white;
            padding: 10px;
            text-align: center;
            display: block;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }

        .cart {
            margin-top: 40px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .cart ul {
            list-style: none;
            padding: 0;
        }
        .cart li {
            margin: 8px 0;
        }
        .cart a {
            margin-left: 10px;
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="navbar">
    <h2>🖥️ Computer Shop</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="checkout.php">Checkout</a>
        <a href="?action=clear_cart" onclick="return confirm('Clear cart?')">Clear Cart</a>
    </div>
</div>

<div class="layout">
    <div class="sidebar">
        <h3>📋 Menu</h3>
        <a href="index.php"> Home</a>
        <a href="checkout.php">Checkout</a>
        <a href="?action=clear_cart" onclick="return confirm('Clear cart?')">Clear Cart</a>
        <a href="#">About Us</a>
        <a href="#">Contact</a>
    </div>

    <div class="container">
        <h1 style="margin-bottom: 20px;">Welcome to Our Computer Shop</h1>

        <form method="GET" class="form-inline">
            <input type="text" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
            <select name="sort">
                <option value="">Sort by</option>
                <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
            </select>
            <button type="submit">Apply</button>
        </form>

        <div class="product-list">
            <?php foreach ($filtered_products as $product): ?>
                <div class="product">
                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <div class="product-info">
                        <h3><?= $product['name'] ?></h3>
                        <p>Brand: <?= $product['brand'] ?></p>
                        <p>Price: ₹<?= $product['price'] ?></p>
                        <a href="?action=add&id=<?= $product['id'] ?>" class="add-to-cart">Add to Cart</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart">
            <h2>Your Cart</h2>
            <?php if (!empty($_SESSION['cart'])): ?>
                <ul>
                    <?php $total = 0; foreach ($_SESSION['cart'] as $id => $item): 
                        $total += $item['price'] * $item['quantity']; ?>
                        <li><?= $item['name'] ?> x<?= $item['quantity'] ?> - ₹<?= $item['price'] * $item['quantity'] ?>
                            <a href="?action=remove&id=<?= $id ?>">Remove</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>Total: ₹<?= $total ?></strong></p>
                <a href="?action=clear_cart" class="add-to-cart" style="background:#dc3545;">Clear Cart</a><br><br>
                <a href="checkout.php" class="add-to-cart" style="background:#007bff;">Proceed to Checkout</a>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
