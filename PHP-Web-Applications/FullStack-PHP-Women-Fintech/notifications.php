<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$query = "SELECT n.*, m.first_name, m.last_name, m.profile_image 
          FROM notifications n 
          JOIN members m ON n.member_id = m.id 
          ORDER BY n.created_at DESC";
$stmt = $db->query($query);
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4" style="color: var(--raspberry);">Recent Notifications</h2>
        
        <div class="list-group">
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="list-group-item list-group-item-action flex-column align-items-start mb-2 shadow-sm" style="border-radius: 10px; border-left: 5px solid var(--soft-green);">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1" style="color: var(--deep-green);">
                            <?php echo htmlspecialchars($row['message']); ?>
                        </h5>
                        <small class="text-muted"><?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></small>
                    </div>
                    <div class="mt-2 d-flex align-items-center">
                        <?php $img = !empty($row['profile_image']) ? "uploads/".$row['profile_image'] : "https://via.placeholder.com/30"; ?>
                        <img src="<?php echo $img; ?>" class="rounded-circle mr-2" width="30" height="30">
                        <small>Member ID: #<?php echo $row['member_id']; ?></small>
                    </div>
                </div>
            <?php endwhile; ?>
            
            <?php if($stmt->rowCount() == 0): ?>
                <div class="alert alert-info">No notifications yet. Add a new member to see one!</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>