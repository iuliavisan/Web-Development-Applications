<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();
$user_id = $_SESSION['user_id'];

$stmt_user = $db->prepare("SELECT profession FROM members WHERE id = ?");
$stmt_user->execute([$user_id]);
$user_prof = $stmt_user->fetchColumn();

$sql_rec = "SELECT * FROM jobs WHERE title LIKE ? LIMIT 3";
$stmt_rec = $db->prepare($sql_rec);
$stmt_rec->execute(["%$user_prof%"]);

$search = isset($_GET['search']) ? $_GET['search'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

$query = "SELECT * FROM jobs WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND (title LIKE ? OR company LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}
if (!empty($location)) {
    $query .= " AND location LIKE ?";
    $params[] = "%$location%";
}
if (!empty($type)) {
    $query .= " AND type = ?";
    $params[] = $type;
}

$query .= " ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute($params);
?>

<div class="row mb-4">
    <div class="col-12">
        <h2 style="color: var(--raspberry);">💼 Jobs Board</h2>
        <p class="lead">Find your next career opportunity.</p>
    </div>
</div>

<?php if($stmt_rec->rowCount() > 0): ?>
<div class="alert alert-info shadow-sm border-0 mb-4">
    <h5 class="alert-heading">Recommended for you (<?php echo htmlspecialchars($user_prof); ?>)</h5>
    <div class="row mt-3">
        <?php while($rec = $stmt_rec->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-primary"><?php echo htmlspecialchars($rec['title']); ?></h6>
                        <small class="text-muted"><?php echo htmlspecialchars($rec['company']); ?></small>
                        <a href="job_details.php?id=<?php echo $rec['id']; ?>" class="btn btn-sm btn-outline-primary float-right">View</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php endif; ?>

<div class="card p-4 shadow-sm mb-4 border-0" style="background-color: #f8f9fa;">
    <form method="GET" class="form-row">
        <div class="col-md-4 mb-2">
            <input type="text" name="search" class="form-control" placeholder="Job title or company" value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <div class="col-md-3 mb-2">
            <input type="text" name="location" class="form-control" placeholder="Location" value="<?php echo htmlspecialchars($location); ?>">
        </div>
        <div class="col-md-3 mb-2">
            <select name="type" class="form-control">
                <option value="">All Types</option>
                <option value="Full-time" <?php if($type=='Full-time') echo 'selected'; ?>>Full-time</option>
                <option value="Part-time" <?php if($type=='Part-time') echo 'selected'; ?>>Part-time</option>
                <option value="Remote" <?php if($type=='Remote') echo 'selected'; ?>>Remote</option>
                <option value="Freelance" <?php if($type=='Freelance') echo 'selected'; ?>>Freelance</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-block">Filter</button>
        </div>
    </form>
</div>

<div class="row">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <div class="col-md-12 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1 text-primary"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="mb-1 text-dark font-weight-bold"><?php echo htmlspecialchars($row['company']); ?></p>
                    <small class="text-muted">📍 <?php echo htmlspecialchars($row['location']); ?> | 🕒 <?php echo htmlspecialchars($row['type']); ?></small>
                </div>
                <a href="job_details.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success">Apply Now</a>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php include_once "includes/footer.php"; ?>