<?php
include 'auth-check.php';
include '../db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids = $_POST['id'];
    $icons = $_POST['icon'];
    $titles = $_POST['title'];
    $descriptions = $_POST['description'];

    $hasEmpty = false;
    foreach ($titles as $i => $val) {
        if (trim($val) === '' || trim($icons[$i]) === '' || trim($descriptions[$i]) === '') {
            $hasEmpty = true;
        }
    }

    if ($hasEmpty) {
        $error = "All fields are required. Nothing was saved.";
    } else {
        for ($i = 0; $i < count($ids); $i++) {
            $id = intval($ids[$i]);
            $icon = trim($icons[$i]);
            $title = trim($titles[$i]);
            $description = trim($descriptions[$i]);

            $stmt = mysqli_prepare($conn, "UPDATE about_features SET icon = ?, title = ?, description = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "sssi", $icon, $title, $description, $id);
            mysqli_stmt_execute($stmt);
        }
        $success = "About Features updated successfully!";
    }
}

$features_result = mysqli_query($conn, "SELECT * FROM about_features ORDER BY display_order ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage About Features</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h1>About Features</h1>
                <div class="topbar-subtitle">Edit the 4 feature cards in the About section</div>
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
                <table class="crud-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Icon Path</th>
                            <th>Title</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($features_result)): ?>
                            <tr>
                                <td><?php echo $row['display_order']; ?></td>
                                <td>
                                    <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
                                    <input type="text" name="icon[]" value="<?php echo htmlspecialchars($row['icon']); ?>" required>
                                </td>
                                <td>
                                    <input type="text" name="title[]" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                </td>
                                <td>
                                    <input type="text" name="description[]" value="<?php echo htmlspecialchars($row['description']); ?>" required>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn-save" style="margin-top:20px;">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>