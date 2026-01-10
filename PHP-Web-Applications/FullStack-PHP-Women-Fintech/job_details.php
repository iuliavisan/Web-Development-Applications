<?php
include_once "config/database.php";
include_once "includes/header.php";

if (!isset($_GET['id'])) {
    header("Location: jobs.php");
    exit();
}

$job_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$database = new Database();
$db = $database->getConnection();
$msg = "";

if (isset($_POST['apply'])) {
    $check = $db->prepare("SELECT id FROM job_applications WHERE job_id = ? AND user_id = ?");
    $check->execute([$job_id, $user_id]);
    
    if($check->rowCount() == 0) {
        $sql = "INSERT INTO job_applications (job_id, user_id) VALUES (?, ?)";
        if($db->prepare($sql)->execute([$job_id, $user_id])) {
            $msg = "<div class='alert alert-success'>Application submitted successfully! Good luck.</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>You have already applied for this job.</div>";
    }
}

$stmt = $db->prepare("SELECT * FROM jobs WHERE id = ?");
$stmt->execute([$job_id]);
$job = $stmt->fetch(PDO::FETCH_ASSOC);

$check_app = $db->prepare("SELECT id FROM job_applications WHERE job_id = ? AND user_id = ?");
$check_app->execute([$job_id, $user_id]);
$has_applied = $check_app->rowCount() > 0;
?>

<div class="container mt-4">
    <?php echo $msg; ?>
    
    <div class="card shadow-lg">
        <div class="card-header bg-white border-bottom-0 pt-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-primary mb-0"><?php echo htmlspecialchars($job['title']); ?></h2>
                    <h4 class="text-muted"><?php echo htmlspecialchars($job['company']); ?></h4>
                </div>
                <span class="badge badge-info p-2"><?php echo htmlspecialchars($job['type']); ?></span>
            </div>
        </div>
        <div class="card-body">
            <p class="text-muted">📍 <?php echo htmlspecialchars($job['location']); ?> • Posted on <?php echo date('d M Y', strtotime($job['created_at'])); ?></p>
            <hr>
            <h5>Job Description</h5>
            <p class="lead"><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
            
            <hr class="mt-5">
            <?php if(!$has_applied): ?>
                <form method="POST">
                    <button type="submit" name="apply" class="btn btn-success btn-lg px-5">Submit Application</button>
                    <a href="jobs.php" class="btn btn-outline-secondary btn-lg ml-3">Back to Jobs</a>
                </form>
            <?php else: ?>
                <button class="btn btn-secondary btn-lg px-5" disabled>Applied!</button>
                <a href="jobs.php" class="btn btn-outline-secondary btn-lg ml-3">Back to Jobs</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>