<?php
include_once "config/database.php";
include_once "includes/header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    
    $image_name = null;
    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['profile_image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        if(in_array(strtolower($filetype), $allowed)) {
            $image_name = uniqid() . "." . $filetype;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], "uploads/" . $image_name);
        }
    }

    $query = "INSERT INTO members (first_name, last_name, email, profession, company, expertise, linkedin_profile, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    
    if($stmt->execute([
        $_POST['first_name'], $_POST['last_name'], $_POST['email'],
        $_POST['profession'], $_POST['company'], $_POST['expertise'],
        $_POST['linkedin_profile'], $image_name
    ])) {

        $new_id = $db->lastInsertId(); 
        $message = "New member joined: " . $_POST['first_name'] . " " . $_POST['last_name'];
        
        $sql_notif = "INSERT INTO notifications (member_id, message) VALUES (?, ?)";
        $stmt_notif = $db->prepare($sql_notif);
        $stmt_notif->execute([$new_id, $message]);

        echo "<script>window.location.href='members.php';</script>";
        exit();
    }
}
?>

<div class="form-container">
    <h2>Add New Member</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Profile Photo</label>
            <input type="file" name="profile_image" class="form-control-file">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Profession</label>
            <input type="text" name="profession" class="form-control">
        </div>
        <div class="form-group">
            <label>Company</label>
            <input type="text" name="company" class="form-control">
        </div>
        <div class="form-group">
            <label>Expertise</label>
            <textarea name="expertise" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>LinkedIn Profile</label>
            <input type="url" name="linkedin_profile" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Add Member</button>
    </form>
</div>

<?php include_once "includes/footer.php"; ?>