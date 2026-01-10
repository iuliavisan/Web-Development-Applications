<?php
session_start();
require_once 'DBController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $db = new DBController();
    
    $query = "SELECT id, password FROM users WHERE username = ?";
    $user = $db->getDBResult($query, [$username]);

    if ($user && password_verify($password, $user[0]['password'])) {
        $_SESSION['user_id'] = $user[0]['id'];
        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit;
    } else {
        echo "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Login</h2>
    <form method="post">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <a href="register.php">Create an account</a>
</body>
</html>