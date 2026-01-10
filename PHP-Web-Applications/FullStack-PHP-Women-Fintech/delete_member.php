<?php
session_start();
include_once "config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: members.php");
    exit();
}

if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->getConnection();
    $id = $_GET['id'];

    $query_img = "SELECT profile_image FROM members WHERE id = ?";
    $stmt_img = $db->prepare($query_img);
    $stmt_img->execute([$id]);
    $row = $stmt_img->fetch(PDO::FETCH_ASSOC);

    if ($row && !empty($row['profile_image'])) {
        $file_path = "uploads/" . $row['profile_image'];
        if (file_exists($file_path)) {
            unlink($file_path); 
        }
    }
    
    $query = "DELETE FROM members WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
}

header("Location: members.php");
exit();
?>