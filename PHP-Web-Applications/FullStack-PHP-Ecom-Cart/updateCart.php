<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new DBController();
$cart_id = $_POST['cart_id'];
$quantity = $_POST['quantity'];

if ($quantity > 0) {
    $db->updateDB("UPDATE tbl_cart SET quantity = ? WHERE id = ?", [$quantity, $cart_id]);
} else {
    $db->updateDB("DELETE FROM tbl_cart WHERE id = ?", [$cart_id]);
}

header("Location: cart.php");
exit;
?>