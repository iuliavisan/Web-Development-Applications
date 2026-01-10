<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <nav>
        <a href="index.php">Go to Shop</a> | 
        <a href="todo.php">Todo List</a> | 
        <a href="logout.php">Logout</a>
    </nav>
</body>
</html>