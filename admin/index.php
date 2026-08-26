<?php
include 'auth-check.php';
include '../db.php';

$counters_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM counters"))['c'];
$services_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM service_cards"))['c'];
$projects_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM projects"))['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h1>Dashboard</h1>
                <div class="topbar-subtitle">Manage your portfolio content</div>
            </div>
            <div class="user-badge">
                <div class="avatar"><?php echo strtoupper(substr($_SESSION['admin_username'], 0, 1)); ?></div>
                <div class="user-info">
                    <div class="label">Logged in as</div>
                    <div class="name"><?php echo $_SESSION['admin_username']; ?></div>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-chart-simple"></i></div>
                <div>
                    <div class="stat-number"><?php echo $counters_count; ?></div>
                    <div class="stat-label">Counter Items</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                <div>
                    <div class="stat-number"><?php echo $services_count; ?></div>
                    <div class="stat-label">Services</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-building"></i></div>
                <div>
                    <div class="stat-number"><?php echo $projects_count; ?></div>
                    <div class="stat-label">Projects</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>