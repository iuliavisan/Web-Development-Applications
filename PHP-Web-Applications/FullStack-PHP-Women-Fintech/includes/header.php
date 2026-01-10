<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    // daca nu e pornita deja o sesiune, o incepem acum
}

$current_page = basename($_SERVER['PHP_SELF']);
// pagina curenta->dashboard

$public_pages = ['login.php', 'register.php', 'index.php'];
// pagini unde are voie oricine sa intre

if (!isset($_SESSION['user_id']) && !in_array($current_page, $public_pages)) {
    header("Location: login.php");
    exit();
}
// daca nu e public, trebuie sa te loghezi
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- pentru tel -->
    <title>WomenTechPower Platform</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Rokkitt:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- bara navigatie -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top mr-2" alt="Logo">
                WomenTechPower
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="members.php">Members</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="members.php">Community</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="resources.php">Resource Hub</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="events.php">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="jobs.php">Jobs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mentors.php">Find Mentor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="my_mentorship.php">My Mentorships</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="notifications.php">Notifications</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                About me:  <?php echo htmlspecialchars($_SESSION['name']); ?> (<?php echo ucfirst($_SESSION['role']); ?>)
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="profile.php">My profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="logout.php">Logout</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light ml-2" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <button class="btn btn-sm btn-outline-light mt-1 ml-2" onclick="toggleDarkMode()">Dark Mode</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">