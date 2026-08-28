<?php
include 'auth-check.php';
include '../db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $label_text = trim($_POST['label_text']);
    $heading = trim($_POST['heading']);
    $description = trim($_POST['description']);
    $main_image = trim($_POST['main_image']);
    $secondary_image = trim($_POST['secondary_image']);
    $badge_number = trim($_POST['badge_number']);
    $badge_label = trim($_POST['badge_label']);
    $btn_primary_text = trim($_POST['btn_primary_text']);
    $btn_outline_text = trim($_POST['btn_outline_text']);

    if (empty($label_text) || empty($heading) || empty($description) || empty($main_image) || empty($secondary_image) || empty($badge_number) || empty($badge_label) || empty($btn_primary_text) || empty($btn_outline_text)) {
        $error = "All fields are required. Nothing was saved.";
    } else {
        $query = "UPDATE about SET 
            label_text = ?, heading = ?, description = ?, main_image = ?, 
            secondary_image = ?, badge_number = ?, badge_label = ?, 
            btn_primary_text = ?, btn_outline_text = ? 
            WHERE id = 1";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssss", 
            $label_text, $heading, $description, $main_image, 
            $secondary_image, $badge_number, $badge_label, 
            $btn_primary_text, $btn_outline_text
        );
        mysqli_stmt_execute($stmt);
        $success = "About section updated successfully!";
    }
}

$about_result = mysqli_query($conn, "SELECT * FROM about LIMIT 1");
$about = mysqli_fetch_assoc($about_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit About Section</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h1>About Section</h1>
                <div class="topbar-subtitle">Edit the homepage about content</div>
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
                    <input type="text" name="label_text" value="<?php echo htmlspecialchars($about['label_text']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Heading</label>
                    <input type="text" name="heading" value="<?php echo htmlspecialchars($about['heading']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" required><?php echo htmlspecialchars($about['description']); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Main Image Path</label>
                        <input type="text" name="main_image" value="<?php echo htmlspecialchars($about['main_image']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Secondary Image Path</label>
                        <input type="text" name="secondary_image" value="<?php echo htmlspecialchars($about['secondary_image']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Badge Number</label>
                        <input type="text" name="badge_number" value="<?php echo htmlspecialchars($about['badge_number']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Badge Label</label>
                        <input type="text" name="badge_label" value="<?php echo htmlspecialchars($about['badge_label']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Primary Button Text</label>
                        <input type="text" name="btn_primary_text" value="<?php echo htmlspecialchars($about['btn_primary_text']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Outline Button Text</label>
                        <input type="text" name="btn_outline_text" value="<?php echo htmlspecialchars($about['btn_outline_text']); ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>