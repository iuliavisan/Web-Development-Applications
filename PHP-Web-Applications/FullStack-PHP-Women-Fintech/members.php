<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$search = isset($_GET['search']) ? $_GET['search'] : ''; 
$filter_prof = isset($_GET['profession']) ? $_GET['profession'] : '';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 6; 

$query = "SELECT * FROM members WHERE 1=1"; //!nu e bine
$params = []; 

if (!empty($search)) {
    $query .= " AND (first_name LIKE ? OR last_name LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($filter_prof)) {
    $query .= " AND profession = ?";
    $params[] = $filter_prof;
}

if ($sort_by == 'name_asc') {
    $query .= " ORDER BY last_name ASC";
} elseif ($sort_by == 'name_desc') {
    $query .= " ORDER BY last_name DESC";
} else {
    $query .= " ORDER BY created_at DESC"; 
}

$offset = ($page - 1) * $records_per_page;
$query_count = $query; 
$query .= " LIMIT $offset, $records_per_page";

$stmt = $db->prepare($query);
$stmt->execute($params); 

$stmt_count = $db->prepare($query_count);
$stmt_count->execute($params);
$total_rows = $stmt_count->rowCount();
$total_pages = ceil($total_rows / $records_per_page);

$stmt_prof = $db->query("SELECT DISTINCT profession FROM members WHERE profession IS NOT NULL AND profession != ''");
?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="text-left" style="color: var(--raspberry);">Members Directory</h2>
        
        <div class="p-3 mb-3" style="background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 10px;">
            <form method="GET" class="form-inline justify-content-center">
                
                <input type="text" name="search" class="form-control mr-3" 
                       placeholder="Search name..." 
                       value="<?php echo htmlspecialchars($search); ?>">

                <select name="profession" class="form-control mr-3" onchange="this.form.submit()">
                    <option value="">All Professions</option>
                    <?php while($prof = $stmt_prof->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $prof['profession']; ?>" 
                            <?php if($filter_prof == $prof['profession']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($prof['profession']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <select name="sort" class="form-control mr-3" onchange="this.form.submit()">
                    <option value="newest" <?php if($sort_by == 'newest') echo 'selected'; ?>>Newest First</option>
                    <option value="name_asc" <?php if($sort_by == 'name_asc') echo 'selected'; ?>>Name (A-Z)</option>
                    <option value="name_desc" <?php if($sort_by == 'name_desc') echo 'selected'; ?>>Name (Z-A)</option>
                </select>
                
                <button type="submit" class="btn btn-primary btn-sm mr-2">Search</button>
                <a href="members.php" class="btn btn-outline-secondary btn-sm">Reset</a>
            </form>
        </div>
    </div>
</div>

<?php if($stmt->rowCount() == 0): ?>
    <div class="alert alert-warning text-center">
        No members found matching your search. <a href="members.php">View all</a>.
    </div>
<?php endif; ?>

<div class="row">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <div class="col-md-4">
        <div class="card member-card h-100">
            <?php 
                $img_path = !empty($row['profile_image']) ? "uploads/" . $row['profile_image'] : "https://via.placeholder.com/150?text=No+Image";
            ?>
            <div style="text-align: center; padding-top: 20px;">
                <img src="<?php echo $img_path; ?>" 
                     alt="Profile" 
                     style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid var(--pale-pink);">
            </div>

            <div class="card-body text-center">
                <h5 class="card-title"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h5>
                <p class="card-text">
                    <span class="badge badge-pill" style="background-color: var(--soft-green); color: white;">
                        <?php echo htmlspecialchars($row['profession']); ?>
                    </span>
                    <br>
                    <small class="text-muted"><?php echo htmlspecialchars($row['company']); ?></small>
                </p>
                
                <div class="mt-3">
                    <a href="edit_member.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="delete_member.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php if ($total_pages > 1): ?>
<nav aria-label="Page navigation" class="mt-4">
  <ul class="pagination justify-content-center">
    <?php for($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?php if($page == $i) echo 'active'; ?>">
            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>&sort=<?php echo $sort_by; ?>&profession=<?php echo $filter_prof; ?>"
               style="color: var(--deep-green);">
                <?php echo $i; ?>
            </a>
        </li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>

<?php
include_once "includes/footer.php";
?>