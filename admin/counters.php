<?php
include 'auth-check.php';
include '../db.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids = $_POST['id'];
    $number_values = $_POST['number_value'];
    $labels = $_POST['label'];

    $hasEmpty = false;
    foreach ($number_values as $i => $val) {
        if (trim($val) === '' || trim($labels[$i]) === '') {
            $hasEmpty = true;
        }
    }

    if ($hasEmpty) {
        $error = "All fields are required. Nothing was saved.";
    } else {
        for ($i = 0; $i < count($ids); $i++) {
            $id = intval($ids[$i]);
            $number_value = trim($number_values[$i]);
            $label = trim($labels[$i]);

            $stmt = mysqli_prepare($conn, "UPDATE counters SET number_value = ?, label = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ssi", $number_value, $label, $id);
            mysqli_stmt_execute($stmt);
        }
        $success = "Counters updated successfully!";
    }
}

$counters_result = mysqli_query($conn, "SELECT * FROM counters ORDER BY display_order ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Counters</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h1>Counters</h1>
                <div class="topbar-subtitle">Edit the homepage stat counters</div>
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
                            <th>Number</th>
                            <th>Label</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($counters_result)): ?>
                            <tr>
                                <td><?php echo $row['display_order']; ?></td>
                                <td>
                                    <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
                                    <input type="text" name="number_value[]" value="<?php echo htmlspecialchars($row['number_value']); ?>" required>
                                </td>
                                <td>
                                    <input type="text" name="label[]" value="<?php echo htmlspecialchars($row['label']); ?>" required>
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