<?php
include 'auth-check.php';
include '../db.php';

$success = "";
$error = "";

// DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = mysqli_prepare($conn, "DELETE FROM projects WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    header("Location: projects.php");
    exit();
}

// ADD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project'])) {
    $image = trim($_POST['image']);
    $category = trim($_POST['category']);
    $tag_label = trim($_POST['tag_label']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $display_order = trim($_POST['display_order']);

    if (empty($image) || empty($category) || empty($tag_label) || empty($title) || empty($description) || $display_order === '') {
        $error = "All fields are required to add a project.";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO projects (image, category, tag_label, title, description, display_order) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssi", $image, $category, $tag_label, $title, $description, $display_order);
        mysqli_stmt_execute($stmt);
        header("Location: projects.php");
        exit();
    }
}

// UPDATE 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_project'])) {
    $id = intval($_POST['id']);
    $image = trim($_POST['image']);
    $category = trim($_POST['category']);
    $tag_label = trim($_POST['tag_label']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $display_order = trim($_POST['display_order']);

    if (empty($image) || empty($category) || empty($tag_label) || empty($title) || empty($description) || $display_order === '') {
        $error = "All fields are required to update a project.";
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE projects SET image = ?, category = ?, tag_label = ?, title = ?, description = ?, display_order = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssssii", $image, $category, $tag_label, $title, $description, $display_order, $id);
        mysqli_stmt_execute($stmt);
        header("Location: projects.php");
        exit();
    }
}

$projects_result = mysqli_query($conn, "SELECT * FROM projects ORDER BY display_order ASC");
$editing_id = isset($_GET['edit']) ? intval($_GET['edit']) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Projects</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="topbar">
            <div>
                <h1>Projects</h1>
                <div class="topbar-subtitle">Add, edit, or remove portfolio projects</div>
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

            <!-- ADD NEW PROJECT -->
            <div class="edit-row-form">
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Image Path</label>
                            <input type="text" name="image" placeholder="images/project-x.jpg" required>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" required>
                                <option value="residential">Residential</option>
                                <option value="commercial">Commercial</option>
                                <option value="infrastructure">Infrastructure</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Tag Label</label>
                            <input type="text" name="tag_label" placeholder="RESIDENTIAL" required>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" placeholder="Project name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" placeholder="Short description" required>
                    </div>
                    <div class="form-group" style="max-width:120px;">
                        <label>Order</label>
                        <input type="number" name="display_order" placeholder="7" required>
                    </div>
                    <button type="submit" name="add_project" class="btn-add">+ Add Project</button>
                </form>
            </div>

            <table class="crud-table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($projects_result)): ?>
                        <?php if ($editing_id === (int)$row['id']): ?>
                            <tr>
                                <td colspan="4">
                                    <form method="POST" class="edit-row-form" style="margin-bottom:0;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Image Path</label>
                                                <input type="text" name="image" value="<?php echo htmlspecialchars($row['image']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select name="category" required>
                                                    <option value="residential" <?php if ($row['category']=='residential') echo 'selected'; ?>>Residential</option>
                                                    <option value="commercial" <?php if ($row['category']=='commercial') echo 'selected'; ?>>Commercial</option>
                                                    <option value="infrastructure" <?php if ($row['category']=='infrastructure') echo 'selected'; ?>>Infrastructure</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Tag Label</label>
                                                <input type="text" name="tag_label" value="<?php echo htmlspecialchars($row['tag_label']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" name="description" value="<?php echo htmlspecialchars($row['description']); ?>" required>
                                        </div>
                                        <div class="form-group" style="max-width:120px;">
                                            <label>Order</label>
                                            <input type="number" name="display_order" value="<?php echo $row['display_order']; ?>" required>
                                        </div>
                                        <div style="display:flex; gap:12px; margin-top:10px;">
                                            <button type="submit" name="update_project" class="btn-save">Save</button>
                                            <a href="projects.php" class="btn-cancel">Cancel</a>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td><?php echo $row['display_order']; ?></td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars(ucfirst($row['category'])); ?></td>
                                <td class="crud-actions">
                                    <a href="projects.php?edit=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                                    <a href="projects.php?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Delete this project?');">Delete</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
