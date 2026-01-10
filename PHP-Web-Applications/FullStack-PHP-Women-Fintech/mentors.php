<?php
include_once "config/database.php";
include_once "includes/header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$user_id = $_SESSION['user_id'];
$msg = "";

if (isset($_POST['request_mentorship'])) {
    $mentor_id = $_POST['mentor_id'];
    
    $check = $db->prepare("SELECT id FROM mentorship_requests WHERE mentor_id = ? AND mentee_id = ?");
    $check->execute([$mentor_id, $user_id]);
    
    if($check->rowCount() == 0) {
        $sql = "INSERT INTO mentorship_requests (mentor_id, mentee_id) VALUES (?, ?)";
        $stmt = $db->prepare($sql);
        if($stmt->execute([$mentor_id, $user_id])) {
            $msg = "<div class='alert alert-success'>Request sent successfully!</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>You already sent a request to this mentor.</div>";
    }
}

$query = "SELECT * FROM members WHERE role = 'mentor' AND id != ?";
$stmt = $db->prepare($query);
$stmt->execute([$user_id]);
?>

<div class="row mb-4">
    <div class="col-12 text-center">
        <h2 style="color: var(--raspberry);">Find a Mentor</h2>
        <p class="lead">Connect with experienced professionals to guide your career.</p>
        <?php echo $msg; ?>
    </div>
</div>

<div class="row">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm text-center p-3">
            <?php 
                $img = !empty($row['profile_image']) ? "uploads/".$row['profile_image'] : "https://via.placeholder.com/100";
            ?>
            <img src="<?php echo $img; ?>" class="rounded-circle mx-auto d-block mb-3" width="100" height="100" style="object-fit: cover;">
            
            <h4><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h4>
            <p class="text-muted"><?php echo htmlspecialchars($row['profession']); ?></p>
            <p class="small"><?php echo htmlspecialchars(substr($row['expertise'], 0, 100)); ?>...</p>
            
            <form method="POST">
                <input type="hidden" name="mentor_id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="request_mentorship" class="btn btn-outline-primary btn-block">Request Mentorship</button>
            </form>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php include_once "includes/footer.php"; ?>