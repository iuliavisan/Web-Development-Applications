<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['cart_id'])) {
    $db = new DBController();
    $db->updateDB("DELETE FROM tbl_cart WHERE id = ?", [$_GET['cart_id']]);
}

header("Location: cart.php");
exit;
?>