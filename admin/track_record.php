<?php
include 'auth-check.php';
include '../db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $label_text = trim($_POST['label_text']);
    $heading = trim($_POST['heading']);
    $description = trim($_POST['description']);
    $link_text = trim($_POST['link_text']);

    if (empty($label_text) || empty($heading) || empty($description) || empty($link_text)) {
        $error = "All fields are required. Nothing was saved.";
    } else {
        $query = "UPDATE track_record SET label_text = ?, heading = ?, description = ?, link_text = ? WHERE id = 1";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $label_text, $heading, $description, $link_text);
        mysqli_stmt_execute($stmt);
        $success = "Track Record updated successfully!";
    }
}

$track_result = mysqli_query($conn, "SELECT * FROM track_record LIMIT 1");
$track_record = mysqli_fetch_assoc($track_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Track Record</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h1>Track Record</h1>
                <div class="topbar-subtitle">Edit the Track Record section content</div>
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
                    <label>Label Text</label>
                    <input type="text" name="label_text" value="<?php echo htmlspecialchars($track_record['label_text']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Heading</label>
                    <input type="text" name="heading" value="<?php echo htmlspecialchars($track_record['heading']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" required><?php echo htmlspecialchars($track_record['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Link Text</label>
                    <input type="text" name="link_text" value="<?php echo htmlspecialchars($track_record['link_text']); ?>" required>
                </div>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>