<?php
include_once "config/database.php"; //ia din php intreaga baza de date

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - WomenTechPower</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <!-- prop a atributului -->

<?php
// daca utilizatorul a apasat pe register, trecem la POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection(); //conexiunea dintre php si sql

    //verificarea de duplicate, validare
    $check = $db->prepare("SELECT id FROM members WHERE email = ?");//cautam in tabelul members email ul ?daca exista deja
    $check->execute([$_POST['email']]);
    
    if($check->rowCount() > 0) {
        $error = "This email is already used!";
    } else {
        //encr
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO members (first_name, last_name, email, password, role, profession, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $db->prepare($sql);
        
        if($stmt->execute([
            $_POST['first_name'], 
            $_POST['last_name'], 
            $_POST['email'], 
            $hashed_password, 
            $_POST['role'],
            $_POST['profession']
        ])) {
            $new_id = $db->lastInsertId();//incrementare
            //adaugare de notificari
            $db->prepare("INSERT INTO notifications (member_id, message) VALUES (?, 'Welcome! Complete your profile.')")->execute([$new_id]);
            
            echo "<div class='alert alert-success text-center'>Successfully created! <a href='login.php'>Login here</a>.</div>";
        } else {
            $error = "Registration error.";
        }
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4" style="color: var(--raspberry);">Join WomenTechPower</h3>
                    
                    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    
                    <form method="POST">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Parolă</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Profession (ex: Developer, Student)</label>
                            <input type="text" name="profession" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Desired role</label>
                            <select name="role" class="form-control">
                                <option value="member">Member (I want to learn)</option>
                                <option value="mentor">Mentor (I want to help)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Register here</button>
                    </form>
                    <p class="text-center mt-3">Already registered? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>