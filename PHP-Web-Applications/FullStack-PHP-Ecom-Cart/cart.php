<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new DBController();
$id_member = $_SESSION['user_id'];

$query = "SELECT p.name, p.price, c.quantity, c.id 
          FROM tbl_cart c 
          JOIN tbl_product p ON c.product_id = p.id 
          WHERE c.id_member = ?";
$cart_items = $db->getDBResult($query, [$id_member]);
?>
<!DOCTYPE html>
<html>
<body>
    <h1>Shopping Cart</h1>
    <a href="index.php">Back to Shop</a>
    <hr>
    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <?php foreach ($cart_items as $item): ?>
            <div>
                <?php echo htmlspecialchars($item['name']); ?> 
                ($<?php echo htmlspecialchars($item['price']); ?>)
                
                <form method='post' action='updateCart.php' style="display:inline;">
                    Qty: 
                    <input type='number' name='quantity' value='<?php echo $item['quantity']; ?>' min='1' style="width: 50px"/>
                    <input type='hidden' name='cart_id' value='<?php echo $item['id']; ?>' />
                    <input type='submit' value='Update' />
                </form>
                
                <a href='removeFromCart.php?cart_id=<?php echo $item['id']; ?>'>Remove</a>
            </div>
            <br>
        <?php endforeach; ?>
        <br>
        <a href='emptyCart.php'>Empty Cart</a>
    <?php endif; ?>
</body>
</html>