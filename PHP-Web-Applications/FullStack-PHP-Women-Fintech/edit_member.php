<?php
include_once "config/database.php";
include_once "includes/header.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>window.location.href='members.php';</script>";
    exit();
}

$database = new Database();
$db = $database->getConnection();
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image_update_sql = ""; 
    $params = [
        $_POST['first_name'], $_POST['last_name'], $_POST['email'],
        $_POST['profession'], $_POST['company'], $_POST['expertise'],
        $_POST['linkedin_profile']
    ];

    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['profile_image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if(in_array(strtolower($filetype), $allowed)) {
            $image_name = uniqid() . "." . $filetype;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], "uploads/" . $image_name);
            
            $image_update_sql = ", profile_image = ?";
            $params[] = $image_name;
        }
    }

    $params[] = $id;
    
    $query = "UPDATE members 
              SET first_name=?, last_name=?, email=?, profession=?, company=?, expertise=?, linkedin_profile=?" . $image_update_sql . " 
              WHERE id=?";
              
    $stmt = $db->prepare($query);
    
    if($stmt->execute($params)) {
        echo "<script>window.location.href='members.php';</script>";
        exit();
    }
}

$query = "SELECT * FROM members WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$id]);
$member = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Edit Member (Admin Only)</h4>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" 
                                           value="<?php echo htmlspecialchars($member['first_name']); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" 
                                           value="<?php echo htmlspecialchars($member['last_name']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Current Photo</label><br>
                            <?php if(!empty($member['profile_image'])): ?>
                                <img src="uploads/<?php echo $member['profile_image']; ?>" width="100" class="rounded mb-2">
                            <?php else: ?>
                                <p class="text-muted">No photo uploaded.</p>
                            <?php endif; ?>
                            
                            <label class="d-block mt-2">Change Photo</label>
                            <input type="file" name="profile_image" class="form-control-file">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?php echo htmlspecialchars($member['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Profession</label>
                            <input type="text" name="profession" class="form-control" 
                                   value="<?php echo htmlspecialchars($member['profession']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" name="company" class="form-control" 
                                   value="<?php echo htmlspecialchars($member['company']); ?>">
                        </div>
                        <div class="form-group">
                            <label>Expertise</label>
                            <textarea name="expertise" class="form-control"><?php echo htmlspecialchars($member['expertise']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>LinkedIn Profile</label>
                            <input type="url" name="linkedin_profile" class="form-control" 
                                   value="<?php echo htmlspecialchars($member['linkedin_profile']); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Update Member</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>