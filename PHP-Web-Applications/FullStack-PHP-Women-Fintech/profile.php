<?php
include_once "config/database.php";
include_once "includes/header.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$database = new Database();
$db = $database->getConnection();
$user_id = $_SESSION['user_id'];

$msg = "";
$msg_type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $profession = $_POST['profession'];
    $company = $_POST['company'];
    $linkedin = $_POST['linkedin_profile'];
    $expertise = $_POST['expertise'];
    
    $image_sql_part = "";
    $params = [$first_name, $last_name, $profession, $company, $linkedin, $expertise];
    
    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['profile_image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if(in_array(strtolower($filetype), $allowed)) {
            $image_name = uniqid() . "." . $filetype;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], "uploads/" . $image_name);
            
            $image_sql_part = ", profile_image = ?";
            $params[] = $image_name;
        }
    }
    
    $params[] = $user_id;

    $sql = "UPDATE members SET first_name=?, last_name=?, profession=?, company=?, linkedin_profile=?, expertise=? $image_sql_part WHERE id=?";
    $stmt = $db->prepare($sql);
    
    if($stmt->execute($params)) {
        $msg = "Profile updated successfully!";
        $msg_type = "success";
        $_SESSION['name'] = $first_name;
    } else {
        $msg = "An error occurred.";
        $msg_type = "danger";
    }
}

$query = "SELECT * FROM members WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mt-4 mb-5">
                <div class="card-header text-white" style="background-color: var(--deep-green);">
                    <h4 class="mb-0">Edit My Profile</h4>
                </div>
                <div class="card-body">
                    
                    <?php if($msg): ?>
                        <div class="alert alert-<?php echo $msg_type; ?>"><?php echo $msg; ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="text-center mb-4">
                            <?php 
                                $img_src = !empty($user['profile_image']) ? "uploads/".$user['profile_image'] : "https://via.placeholder.com/150";
                            ?>
                            <img src="<?php echo $img_src; ?>" class="rounded-circle mb-3" width="120" height="120" style="object-fit: cover; border: 4px solid var(--raspberry);">
                            <br>
                            <label class="btn btn-sm btn-outline-primary">
                                Change Photo <input type="file" name="profile_image" hidden>
                            </label>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email (cannot be changed)</label>
                            <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Profession</label>
                                    <input type="text" name="profession" class="form-control" value="<?php echo htmlspecialchars($user['profession']); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company</label>
                                    <input type="text" name="company" class="form-control" value="<?php echo htmlspecialchars($user['company']); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>LinkedIn Profile</label>
                            <input type="url" name="linkedin_profile" class="form-control" value="<?php echo htmlspecialchars($user['linkedin_profile']); ?>">
                        </div>

                        <div class="form-group">
                            <label>My Expertise / Bio</label>
                            <textarea name="expertise" class="form-control" rows="4"><?php echo htmlspecialchars($user['expertise']); ?></textarea>
                            <small class="text-muted">Describe your skills so we can recommend connections.</small>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" style="background-color: var(--raspberry); border: none;">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>