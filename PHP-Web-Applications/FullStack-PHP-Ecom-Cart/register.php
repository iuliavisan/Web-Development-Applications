<?php
require_once 'DBController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $db = new DBController();
    $query = "INSERT INTO users (username, password) VALUES (?, ?)";

    try {
        $db->updateDB($query, [$username, $password]);
        echo "Registration successful! <a href='login.php'>Login here</a>";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Register</h2>
    <form method="post">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>