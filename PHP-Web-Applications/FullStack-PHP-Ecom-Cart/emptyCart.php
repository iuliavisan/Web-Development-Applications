<?php
session_start();
require_once 'DBController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new DBController();
$db->updateDB("DELETE FROM tbl_cart WHERE id_member = ?", [$_SESSION['user_id']]);

header("Location: cart.php");
exit;
?>