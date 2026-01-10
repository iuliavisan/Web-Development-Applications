<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM events ORDER BY event_date ASC";
$stmt = $db->query($query);
?>

<div class="row mb-4">
    <div class="col-12 text-center">
        <h2 style="color: var(--raspberry);">📅 Events Calendar</h2>
        <p class="lead">Join our upcoming online and offline events.</p>
    </div>
</div>

<div class="row">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <?php 
            $is_past = strtotime($row['event_date']) < time();
            $card_class = $is_past ? "opacity-50" : "";
            $badge_color = $row['type'] == 'online' ? 'info' : 'warning';
        ?>
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm <?php echo $card_class; ?>">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge badge-<?php echo $badge_color; ?> text-uppercase">
                            <?php echo $row['type']; ?>
                        </span>
                        <small class="text-muted">
                            <?php echo date('d M Y, H:i', strtotime($row['event_date'])); ?>
                        </small>
                    </div>
                    
                    <h4 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h4>
                    <p class="card-text"><?php echo htmlspecialchars(substr($row['description'], 0, 100)) . '...'; ?></p>
                    <p class="small text-muted">📍 <?php echo htmlspecialchars($row['location']); ?></p>
                    
                    <a href="event_details.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-block">
                        <?php echo $is_past ? "View Recap & Reviews" : "View Details & Register"; ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php include_once "includes/footer.php"; ?>