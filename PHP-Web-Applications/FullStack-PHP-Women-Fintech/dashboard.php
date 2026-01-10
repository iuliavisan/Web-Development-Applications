<?php
include_once "config/database.php";
include_once "includes/header.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$database = new Database();
$db = $database->getConnection();
$my_id = $_SESSION['user_id'];
$my_role = $_SESSION['role'];
$msg = "";

if (isset($_POST['send_request'])) {
    $target_id = $_POST['target_id'];
    
    $check = $db->prepare("SELECT id FROM mentorship_requests WHERE (mentor_id = ? AND mentee_id = ?) OR (mentor_id = ? AND mentee_id = ?)");
    $check->execute([$target_id, $my_id, $my_id, $target_id]);
    
    if($check->rowCount() == 0) {
        $sql = "INSERT INTO mentorship_requests (mentor_id, mentee_id, status) VALUES (?, ?, 'pending')";
        $stmt = $db->prepare($sql);
        if($stmt->execute([$target_id, $my_id])) {
            $msg = "<div class='alert alert-success'>Connection request sent!</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>Request already pending or connected.</div>";
    }
}

$stmt_me = $db->prepare("SELECT profession FROM members WHERE id = ?");
$stmt_me->execute([$my_id]);
$me = $stmt_me->fetch(PDO::FETCH_ASSOC);
$my_profession = $me['profession'];

$total_members = $db->query("SELECT COUNT(*) FROM members")->fetchColumn();
$new_members_count = $db->query("SELECT COUNT(*) FROM members WHERE MONTH(created_at) = MONTH(CURRENT_DATE())")->fetchColumn();

$query_rec = "SELECT * FROM members 
              WHERE id != ? 
              AND (profession LIKE ? OR role = 'mentor') 
              ORDER BY RAND() 
              LIMIT 3";
$stmt_rec = $db->prepare($query_rec);
$stmt_rec->execute([$my_id, "%$my_profession%"]);
?>

<div class="row mb-4">
    <div class="col-12">
        <h2 style="color: var(--raspberry);">
            Hello, <?php echo htmlspecialchars($_SESSION['name']); ?>!
        </h2>
        <p class="lead">Welcome to your personalized dashboard.</p>
        <?php echo $msg; ?>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-4">
        <div class="card text-white text-center p-3 mb-3 shadow-sm" style="background-color: var(--deep-green); border-radius: 15px;">
            <h3><?php echo $total_members; ?></h3>
            <small>Community Members</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white text-center p-3 mb-3 shadow-sm" style="background-color: var(--raspberry); border-radius: 15px;">
            <h3><?php echo $new_members_count; ?></h3>
            <small>New This Month</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white text-center p-3 mb-3 shadow-sm" style="background-color: var(--greige); border-radius: 15px;">
            <h3><?php echo ucfirst($my_role); ?></h3>
            <small>Your Current Role</small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0" style="color: var(--deep-green);">Recommended Connections for You</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if($stmt_rec->rowCount() > 0): ?>
                        <?php while($rec = $stmt_rec->fetch(PDO::FETCH_ASSOC)): ?>
                        <div class="col-md-4">
                            <div class="card mb-3 border-0" style="background-color: #f9f9f9;">
                                <div class="card-body text-center">
                                    <?php 
                                        $img = !empty($rec['profile_image']) ? "uploads/".$rec['profile_image'] : "https://via.placeholder.com/80";
                                    ?>
                                    <img src="<?php echo $img; ?>" class="rounded-circle mb-2" width="80" height="80" style="object-fit: cover;">
                                    
                                    <h5 class="card-title mb-1"><?php echo htmlspecialchars($rec['first_name'] . ' ' . $rec['last_name']); ?></h5>
                                    
                                    <span class="badge badge-pill badge-info mb-2">
                                        <?php echo htmlspecialchars($rec['profession']); ?>
                                    </span>
                                    
                                    <?php if($rec['role'] == 'mentor'): ?>
                                        <span class="badge badge-pill badge-warning">Mentor 🌟</span>
                                    <?php endif; ?>
                                    
                                    <p class="small text-muted text-truncate"><?php echo htmlspecialchars($rec['company']); ?></p>
                                    
                                    <form method="POST">
                                        <input type="hidden" name="target_id" value="<?php echo $rec['id']; ?>">
                                        <button type="submit" name="send_request" class="btn btn-sm btn-primary btn-block">Connect (Request)</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12 text-center p-4">
                            <p class="text-muted">No specific recommendations yet. Invite more friends to join!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>