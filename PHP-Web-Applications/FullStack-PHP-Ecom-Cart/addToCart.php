<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new DBController();
$product_id = $_GET['product_id'];
$id_member = $_SESSION['user_id'];
$quantity = 1;

$query = "INSERT INTO tbl_cart (product_id, quantity, id_member) VALUES (?, ?, ?)";
$db->updateDB($query, [$product_id, $quantity, $id_member]);

header("Location: index.php");
exit;
?>