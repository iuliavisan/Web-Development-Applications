<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new DBController();
$products = $db->getDBResult("SELECT * FROM tbl_product");
?>
<!DOCTYPE html>
<html>
<body>
    <h1>Products</h1>
    <a href="cart.php">View Cart</a> | <a href="home.php">Home</a>
    <hr>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <strong><?php echo htmlspecialchars($product['name']); ?></strong> 
                - $<?php echo htmlspecialchars($product['price']); ?>
                <a href='addToCart.php?product_id=<?php echo $product['id']; ?>'>[Add to Cart]</a>
            </li>
            <br>
        <?php endforeach; ?>
    </ul>
</body>
</html>