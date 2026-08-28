<?php
include 'auth-check.php';
include '../db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $heading = trim($_POST['heading']);
    $subtitle = trim($_POST['subtitle']);
    $side_image = trim($_POST['side_image']);
    $overlay_heading = trim($_POST['overlay_heading']);
    $overlay_link_text = trim($_POST['overlay_link_text']);

    if (empty($heading) || empty($subtitle) || empty($side_image) || empty($overlay_heading) || empty($overlay_link_text)) {
        $error = "All fields are required. Nothing was saved.";
    } else {
        $query = "UPDATE services_header SET 
            heading = ?, subtitle = ?, side_image = ?, overlay_heading = ?, overlay_link_text = ? 
            WHERE id = 1";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", 
            $heading, $subtitle, $side_image, $overlay_heading, $overlay_link_text
        );
        mysqli_stmt_execute($stmt);
        $success = "Services header updated successfully!";
    }
}

$services_result = mysqli_query($conn, "SELECT * FROM services_header LIMIT 1");
$services_header = mysqli_fetch_assoc($services_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Services Header</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h1>Services Header</h1>
                <div class="topbar-subtitle">Edit the Services section heading and side image</div>
            </div>
            <div class="user-badge">
                <div class="avatar"><?php echo strtoupper(substr($_SESSION['admin_username'], 0, 1)); ?></div>
                <div class="user-info">
                    <div class="label">Logged in as</div>
                    <div class="name"><?php echo $_SESSION['admin_username']; ?></div>
                </div>
            </div>
        </div>

        <div class="content-card">
            <?php if ($error): ?>
                <div class="alert-success" style="background:#fee2e2; color:#dc2626;"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Heading</label>
                    <input type="text" name="heading" value="<?php echo htmlspecialchars($services_header['heading']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Subtitle</label>
                    <textarea name="subtitle" required><?php echo htmlspecialchars($services_header['subtitle']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Side Image Path</label>
                    <input type="text" name="side_image" value="<?php echo htmlspecialchars($services_header['side_image']); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Overlay Heading</label>
                        <input type="text" name="overlay_heading" value="<?php echo htmlspecialchars($services_header['overlay_heading']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Overlay Link Text</label>
                        <input type="text" name="overlay_link_text" value="<?php echo htmlspecialchars($services_header['overlay_link_text']); ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>