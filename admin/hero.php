<?php
include 'auth-check.php';
include '../db.php';

$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $badge_text = $_POST['badge_text'];
    $title_line1 = $_POST['title_line1'];
    $title_line2 = $_POST['title_line2'];
    $highlight_word = $_POST['highlight_word'];
    $subtitle = $_POST['subtitle'];
    $background_image = $_POST['background_image'];
    $btn_primary_text = $_POST['btn_primary_text'];
    $btn_outline_text = $_POST['btn_outline_text'];

    $query = "UPDATE hero SET 
        badge_text = ?, 
        title_line1 = ?, 
        title_line2 = ?, 
        highlight_word = ?, 
        subtitle = ?, 
        background_image = ?, 
        btn_primary_text = ?, 
        btn_outline_text = ? 
        WHERE id = 1";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssss", 
        $badge_text, $title_line1, $title_line2, $highlight_word, 
        $subtitle, $background_image, $btn_primary_text, $btn_outline_text
    );
    mysqli_stmt_execute($stmt);

    $success = "Hero section updated successfully!";
}

$hero_result = mysqli_query($conn, "SELECT * FROM hero LIMIT 1");
$hero = mysqli_fetch_assoc($hero_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Hero Section</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h1>Hero Section</h1>
                <div class="topbar-subtitle">Edit the homepage hero content</div>
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
            <?php if ($success): ?>
                <div class="alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Badge Text</label>
                    <input type="text" name="badge_text" value="<?php echo htmlspecialchars($hero['badge_text']); ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Title Line 1</label>
                        <input type="text" name="title_line1" value="<?php echo htmlspecialchars($hero['title_line1']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Title Line 2</label>
                        <input type="text" name="title_line2" value="<?php echo htmlspecialchars($hero['title_line2']); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Highlighted Word</label>
                    <input type="text" name="highlight_word" value="<?php echo htmlspecialchars($hero['highlight_word']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Subtitle</label>
                    <textarea name="subtitle" required><?php echo htmlspecialchars($hero['subtitle']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Background Image Path</label>
                    <input type="text" name="background_image" value="<?php echo htmlspecialchars($hero['background_image']); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Primary Button Text</label>
                        <input type="text" name="btn_primary_text" value="<?php echo htmlspecialchars($hero['btn_primary_text']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Outline Button Text</label>
                        <input type="text" name="btn_outline_text" value="<?php echo htmlspecialchars($hero['btn_outline_text']); ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>