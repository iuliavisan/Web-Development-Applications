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

if (isset($_POST['accept_request'])) {
    $req_id = $_POST['req_id'];
    $db->prepare("UPDATE mentorship_requests SET status = 'accepted' WHERE id = ?")->execute([$req_id]);
    $msg = "<div class='alert alert-success'>Mentorship accepted!</div>";
}

if (isset($_POST['schedule_session'])) {
    $req_id = $_POST['req_id'];
    $date = $_POST['session_date'];
    $link = $_POST['meeting_link'];
    $sql = "INSERT INTO mentorship_sessions (request_id, session_date, meeting_link) VALUES (?, ?, ?)";
    $db->prepare($sql)->execute([$req_id, $date, $link]);
    $msg = "<div class='alert alert-success'>Session scheduled!</div>";
}

if (isset($_POST['complete_session'])) {
    $session_id = $_POST['session_id'];
    $feedback = $_POST['feedback'];
    $sql = "UPDATE mentorship_sessions SET status = 'completed', feedback = ? WHERE id = ?";
    $db->prepare($sql)->execute([$feedback, $session_id]);
    $msg = "<div class='alert alert-info'>Feedback saved. Session completed.</div>";
}

$sql_req = "SELECT r.*, m.first_name, m.last_name, m.profession 
            FROM mentorship_requests r 
            JOIN members m ON (r.mentee_id = m.id OR r.mentor_id = m.id)
            WHERE (r.mentor_id = ? OR r.mentee_id = ?) AND m.id != ?
            ORDER BY r.status DESC";
$stmt_req = $db->prepare($sql_req);
$stmt_req->execute([$user_id, $user_id, $user_id]);

$sql_sess = "SELECT s.*, m.first_name, m.last_name 
             FROM mentorship_sessions s 
             JOIN mentorship_requests r ON s.request_id = r.id
             JOIN members m ON (r.mentor_id = m.id OR r.mentee_id = m.id)
             WHERE (r.mentor_id = ? OR r.mentee_id = ?) AND m.id != ?
             ORDER BY s.session_date ASC";
$stmt_sess = $db->prepare($sql_sess);
$stmt_sess->execute([$user_id, $user_id, $user_id]);
?>

<div class="container">
    <?php echo $msg; ?>
    
    <div class="row">
        <div class="col-md-5">
            <h4 style="color: var(--deep-green);">My Connections</h4>
            <ul class="list-group mb-4">
                <?php while($conn = $stmt_req->fetch(PDO::FETCH_ASSOC)): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?php echo htmlspecialchars($conn['first_name'] . ' ' . $conn['last_name']); ?></strong><br>
                            <small><?php echo htmlspecialchars($conn['profession']); ?></small>
                        </div>
                        
                        <?php if($conn['status'] == 'pending' && $conn['mentor_id'] == $user_id): ?>
                            <form method="POST" class="m-0">
                                <input type="hidden" name="req_id" value="<?php echo $conn['id']; ?>">
                                <button type="submit" name="accept_request" class="btn btn-sm btn-success">Accept</button>
                            </form>
                        <?php elseif($conn['status'] == 'accepted'): ?>
                            <span class="badge badge-success">Active</span>
                            <button class="btn btn-sm btn-outline-primary ml-2" type="button" data-toggle="collapse" data-target="#sched<?php echo $conn['id']; ?>">
                                Schedule
                            </button>
                        <?php else: ?>
                            <span class="badge badge-secondary">Pending</span>
                        <?php endif; ?>
                    </li>
                    
                    <div class="collapse p-3 bg-light border" id="sched<?php echo $conn['id']; ?>">
                        <form method="POST">
                            <input type="hidden" name="req_id" value="<?php echo $conn['id']; ?>">
                            <div class="form-group">
                                <label>Date & Time</label>
                                <input type="datetime-local" name="session_date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Meeting Link</label>
                                <input type="text" name="meeting_link" class="form-control" placeholder="Zoom/Meet Link">
                            </div>
                            <button type="submit" name="schedule_session" class="btn btn-primary btn-sm">Set Meeting</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="col-md-7">
            <h4 style="color: var(--raspberry);">Upcoming & Past Sessions</h4>
            <?php while($sess = $stmt_sess->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="card mb-3 shadow-sm <?php echo $sess['status'] == 'completed' ? 'border-success' : ''; ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5>Meeting with <?php echo htmlspecialchars($sess['first_name']); ?></h5>
                            <small><?php echo date('d M Y, H:i', strtotime($sess['session_date'])); ?></small>
                        </div>
                        
                        <?php if($sess['status'] == 'scheduled'): ?>
                            <p>Link: <a href="<?php echo htmlspecialchars($sess['meeting_link']); ?>" target="_blank">Join Meeting</a></p>
                            
                            <form method="POST">
                                <input type="hidden" name="session_id" value="<?php echo $sess['id']; ?>">
                                <div class="input-group">
                                    <input type="text" name="feedback" class="form-control" placeholder="Session notes/feedback..." required>
                                    <div class="input-group-append">
                                        <button type="submit" name="complete_session" class="btn btn-success">Complete</button>
                                    </div>
                                </div>
                            </form>
                        <?php else: ?>
                            <span class="badge badge-success">Completed</span>
                            <p class="text-muted mt-2"><em>"<?php echo htmlspecialchars($sess['feedback']); ?>"</em></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>