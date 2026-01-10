<?php
include_once "config/database.php";
include_once "includes/header.php";

if (!isset($_GET['id'])) {
    header("Location: events.php");
    exit();
}

$event_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$database = new Database();
$db = $database->getConnection();

$msg = "";

//join
if (isset($_POST['register'])) {
    $sql_reg = "INSERT INTO event_registrations (user_id, event_id) VALUES (?, ?)";
    $stmt_reg = $db->prepare($sql_reg);
    if ($stmt_reg->execute([$user_id, $event_id])) {
        $msg = "<div class='alert alert-success'>You have successfully registered!</div>";
    }
}
//review
if (isset($_POST['submit_review'])) {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $sql_rev = "INSERT INTO event_reviews (user_id, event_id, rating, comment) VALUES (?, ?, ?, ?)";
    $stmt_rev = $db->prepare($sql_rev);
    $stmt_rev->execute([$user_id, $event_id, $rating, $comment]);
    $msg = "<div class='alert alert-success'>Thank you for your feedback!</div>";
}

$stmt = $db->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt_check = $db->prepare("SELECT * FROM event_registrations WHERE user_id = ? AND event_id = ?");
$stmt_check->execute([$user_id, $event_id]);
$is_registered = $stmt_check->rowCount() > 0;

$stmt_reviews = $db->prepare("SELECT r.*, m.first_name, m.last_name FROM event_reviews r JOIN members m ON r.user_id = m.id WHERE event_id = ? ORDER BY r.created_at DESC");
$stmt_reviews->execute([$event_id]);

$stmt_avg = $db->prepare("SELECT AVG(rating) as avg_rate FROM event_reviews WHERE event_id = ?");
$stmt_avg->execute([$event_id]);
$avg = round($stmt_avg->fetchColumn(), 1);
?>

<div class="container">
    <?php echo $msg; ?>
    
    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <span class="badge badge-primary float-right"><?php echo strtoupper($event['type']); ?></span>
            <h1 style="color: var(--deep-green);"><?php echo htmlspecialchars($event['title']); ?></h1>
            <p class="text-muted">
                📅 <?php echo date('d M Y, H:i', strtotime($event['event_date'])); ?> <br>
                📍 <?php echo htmlspecialchars($event['location']); ?>
            </p>
            <hr>
            <p class="lead"><?php echo htmlspecialchars($event['description']); ?></p>
            
            <?php if(!$is_registered): ?>
                <form method="POST">
                    <button type="submit" name="register" class="btn btn-success btn-lg">Join Event</button>
                </form>
            <?php else: ?>
                <button class="btn btn-secondary btn-lg" disabled>You are registered!</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3 class="mb-3">⭐ Reviews & Feedback (Avg: <?php echo $avg ? $avg : '0'; ?>/5)</h3>
            
            <div class="card mb-4 bg-light">
                <div class="card-body">
                    <h5>Leave a Review</h5>
                    <form method="POST">
                        <div class="form-group">
                            <label>Rating</label>
                            <select name="rating" class="form-control" style="width: 100px;">
                                <option value="5">5 ⭐</option>
                                <option value="4">4 ⭐</option>
                                <option value="3">3 ⭐</option>
                                <option value="2">2 ⭐</option>
                                <option value="1">1 ⭐</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="comment" class="form-control" placeholder="How was the event?" required></textarea>
                        </div>
                        <button type="submit" name="submit_review" class="btn btn-primary btn-sm">Submit Review</button>
                    </form>
                </div>
            </div>

            <div class="list-group">
                <?php while($rev = $stmt_reviews->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo htmlspecialchars($rev['first_name'] . ' ' . $rev['last_name']); ?></h5>
                            <small class="text-warning font-weight-bold"><?php echo $rev['rating']; ?> / 5 ⭐</small>
                        </div>
                        <p class="mb-1"><?php echo htmlspecialchars($rev['comment']); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>