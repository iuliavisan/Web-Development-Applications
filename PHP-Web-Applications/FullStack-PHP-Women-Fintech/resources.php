<?php
include_once "config/database.php";
include_once "includes/header.php";

$database = new Database();
$db = $database->getConnection();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_type = isset($_GET['type']) ? $_GET['type'] : '';

$query = "SELECT * FROM resources WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND (title LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($filter_type)) {
    $query .= " AND type = ?";
    $params[] = $filter_type;
}

$query .= " ORDER BY created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2 style="color: var(--raspberry);">Resource Hub</h2>
        <p class="lead">Curated articles, videos, and tools for your growth.</p>

        <div class="card p-3 shadow-sm border-0" style="background-color: #f8f9fa;">
            <form method="GET" class="form-inline justify-content-center">
                <input type="text" name="search" class="form-control mr-2" placeholder="Search resources..." value="<?php echo htmlspecialchars($search); ?>" style="width: 300px;">
                
                <select name="type" class="form-control mr-2">
                    <option value="">All Types</option>
                    <option value="article" <?php if($filter_type == 'article') echo 'selected'; ?>>Articles</option>
                    <option value="video" <?php if($filter_type == 'video') echo 'selected'; ?>>Videos</option>
                    <option value="podcast" <?php if($filter_type == 'podcast') echo 'selected'; ?>>Podcasts</option>
                    <option value="download" <?php if($filter_type == 'download') echo 'selected'; ?>>Downloads</option>
                </select>
                
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="resources.php" class="btn btn-outline-secondary ml-2">Reset</a>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header text-white font-weight-bold" style="background-color: var(--deep-green);">
                <?php 
                    if($row['type'] == 'article') echo 'Article';
                    elseif($row['type'] == 'video') echo 'Video';
                    elseif($row['type'] == 'podcast') echo 'Podcast';
                    else echo 'Download';
                ?>
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                <p class="card-text text-muted"><?php echo htmlspecialchars($row['description']); ?></p>
                
                <div class="mt-auto">
                    <?php if($row['type'] == 'download'): ?>
                        <a href="#" class="btn btn-outline-dark btn-block" onclick="alert('This is a demo. In a real app, the file would download now.')">Download PDF</a>
                    <?php else: ?>
                        <a href="<?php echo htmlspecialchars($row['link']); ?>" target="_blank" class="btn btn-outline-primary btn-block">
                            <?php 
                                if($row['type'] == 'article') echo 'Read Article';
                                elseif($row['type'] == 'video') echo 'Watch Video';
                                else echo 'Listen Now';
                            ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>

    <?php if($stmt->rowCount() == 0): ?>
        <div class="col-12 text-center mt-5">
            <h4 class="text-muted">No resources found matching your criteria.</h4>
        </div>
    <?php endif; ?>
</div>

<?php include_once "includes/footer.php"; ?>