<?php 
// --- SETUP ---
require_once '../includes/auth_check.php';
include "../includes/db_conn.php"; 

// --- 1. HANDLE SAVE (New or Edit) ---
if (isset($_POST['btn_save_announcement'])) {
    
    $title      = $_POST['txt_title'];
    $content    = $_POST['txt_content'];
    $priority   = $_POST['txt_priority'];
    $event_date = $_POST['txt_date']; 
    $class      = ($priority == 'High Priority') ? 'high' : 'normal';

    try {
        if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $stmt = $pdo->prepare("UPDATE announcements SET title=?, content=?, priority=?, class=?, date=? WHERE announ_id=?");
            $stmt->execute([$title, $content, $priority, $class, $event_date, $edit_id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO announcements (title, content, priority, class, date) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $content, $priority, $class, $event_date]);
        }
        header("Location: /admin/admin_home.php?mode=edit");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


// --- 2. HANDLE SOFT DELETE ---
if (isset($_GET['soft_delete_id'])) {
    $soft_delete_id = $_GET['soft_delete_id'];
    try {
        $stmt = $pdo->prepare("UPDATE announcements SET deleted_at = NOW() WHERE announ_id=?");
        $stmt->execute([$soft_delete_id]);
        header("Location: /admin/admin_home.php?mode=edit");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


// --- 3. HANDLE RESTORE ---
if (isset($_GET['restore_id'])) {
    $restore_id = $_GET['restore_id'];
    try {
        $stmt = $pdo->prepare("UPDATE announcements SET deleted_at = NULL WHERE announ_id=?");
        $stmt->execute([$restore_id]);
        header("Location: /admin/admin_home.php?mode=edit");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


// --- 4. HANDLE PERMANENT DELETE ---
if (isset($_GET['perm_delete_id'])) {
    $perm_delete_id = $_GET['perm_delete_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM announcements WHERE announ_id=?");
        $stmt->execute([$perm_delete_id]);
        header("Location: /admin/admin_home.php?mode=edit");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


// --- 5. MODE LOGIC ---
$is_edit_mode = (isset($_GET['mode']) && $_GET['mode'] == 'edit') 
                || isset($_GET['edit_id']) 
                || isset($_GET['show_add']);

$form_mode = isset($_GET['edit_id']) ? "edit" : "add";
$edit_data = null;

if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $pdo->prepare("SELECT * FROM announcements WHERE announ_id=?");
    $stmt->execute([$edit_id]);
    $edit_data = $stmt->fetch();
}

include "../includes/admin_header.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_home.css">

</head>
<body>
    <main class="container">

        <!-- ===== PAGE HEADER ===== -->
        <section class="announcements-header">
            <div class="title-wrapper">
                <span class="material-symbols-outlined main-megaphone">campaign</span>
                <h1>Community Announcements</h1>
            </div>

            <div class="admin-controls">
                <?php if ($is_edit_mode && !isset($_GET['show_add']) && !isset($_GET['edit_id'])): ?>
                    <a href="?mode=edit&show_add=true" class="btn-post-new">
                        <span class="material-symbols-outlined">add</span>
                        New Post
                    </a>
                <?php endif; ?>

                <a href="?mode=<?php echo $is_edit_mode ? 'view' : 'edit'; ?>"
                   class="btn-mode-toggle <?php echo $is_edit_mode ? 'mode-on' : 'mode-off'; ?>">
                    <span class="material-symbols-outlined">
                        <?php echo $is_edit_mode ? 'edit_off' : 'edit'; ?>
                    </span>
                    <?php echo $is_edit_mode ? 'Exit Edit Mode' : 'Edit Mode'; ?>
                </a>
            </div>
        </section>


        <!-- ===== ADD / EDIT FORM ===== -->
        <?php if ($is_edit_mode && (isset($_GET['show_add']) || isset($_GET['edit_id']))): ?>
            <div class="admin-form-card">
                <div class="form-title">
                    <?php echo ($form_mode == "edit") ? "Edit Announcement" : "New Announcement"; ?>
                </div>
                <form method="POST">
                    <input type="hidden" name="edit_id" value="<?php echo $edit_data['announ_id'] ?? ''; ?>">

                    <div class="admin-form-group">
                        <label>Title</label>
                        <input type="text" name="txt_title" required class="admin-input"
                               value="<?php echo htmlspecialchars($edit_data['title'] ?? ''); ?>">
                    </div>

                    <div class="admin-form-group">
                        <label>Date of Event / Notice</label>
                        <input type="date" name="txt_date" required class="admin-input"
                               value="<?php echo isset($edit_data['date']) ? date('Y-m-d', strtotime($edit_data['date'])) : ''; ?>">
                    </div>

                    <div class="admin-form-group">
                        <label>Content</label>
                        <textarea name="txt_content" required class="admin-input admin-textarea"><?php echo htmlspecialchars($edit_data['content'] ?? ''); ?></textarea>
                    </div>

                    <div class="admin-form-group">
                        <label>Priority</label>
                        <select name="txt_priority" class="admin-input">
                            <option value="Normal"
                                <?php echo (isset($edit_data['priority']) && $edit_data['priority'] == 'Normal') ? 'selected' : ''; ?>>
                                Normal
                            </option>
                            <option value="High Priority"
                                <?php echo (isset($edit_data['priority']) && $edit_data['priority'] == 'High Priority') ? 'selected' : ''; ?>>
                                High Priority
                            </option>
                        </select>
                    </div>

                    <div class="btn-group">
                        <button type="submit" name="btn_save_announcement" class="btn-save">
                            <span class="material-symbols-outlined">check</span>
                            Save
                        </button>
                        <a href="admin_home.php?mode=edit" class="btn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        <?php endif; ?>


        <!-- ===== ACTIVE ANNOUNCEMENTS ===== -->
        <?php 
        $stmt = $pdo->query("SELECT * FROM announcements WHERE deleted_at IS NULL ORDER BY date DESC");
        while ($item = $stmt->fetch()) { 
        ?>
            <div class="card">

                <?php if ($is_edit_mode): ?>
                    <div class="card-actions">
                        <a href="?mode=edit&edit_id=<?php echo $item['announ_id']; ?>"
                           class="edit-link" title="Edit">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <a href="?mode=edit&soft_delete_id=<?php echo $item['announ_id']; ?>"
                           class="delete-link" title="Move to Trash"
                           onclick="return confirm('Move this post to trash?')">
                            <span class="material-symbols-outlined">delete</span>
                        </a>
                    </div>
                <?php endif; ?>

                <span class="badge <?php echo $item['class']; ?>">
                    <?php echo htmlspecialchars($item['priority']); ?>
                </span>
                <h3 <?php echo $is_edit_mode ? 'class="card-title-edit"' : ''; ?>>
                    <?php echo htmlspecialchars($item['title']); ?>
                </h3>
                <p><?php echo htmlspecialchars($item['content']); ?></p>
                <div class="date">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <?php echo date("F j, Y", strtotime($item['date'])); ?>
                </div>

            </div>
        <?php } ?>


        <!-- ===== RECENTLY DELETED (Edit Mode Only) ===== -->
        <?php if ($is_edit_mode): ?>
            <div class="trash-section">

                <div class="trash-divider">
                    <div class="trash-divider-label">
                        <span class="material-symbols-outlined">history</span>
                        Recently Deleted
                    </div>
                    <div class="trash-divider-line"></div>
                </div>

                <?php 
                $trash_stmt = $pdo->query("SELECT * FROM announcements WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC");
                $trash_items = $trash_stmt->fetchAll();

                if (count($trash_items) === 0): ?>
                    <div class="trash-empty">
                        <span class="material-symbols-outlined">inbox</span>
                        Archive is empty.
                    </div>
                <?php else: ?>
                    <?php foreach ($trash_items as $trash_item): ?>
                        <div class="trash-card">
                            <div class="trash-card-inner">

                                <div class="trash-card-body">
                                    <span class="badge <?php echo $trash_item['class']; ?>">
                                        <?php echo htmlspecialchars($trash_item['priority']); ?>
                                    </span>
                                    <h3><?php echo htmlspecialchars($trash_item['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($trash_item['content']); ?></p>
                                    <div class="deleted-date">
                                        <span class="material-symbols-outlined">delete</span>
                                        Deleted on: <?php echo date("F j, Y g:i A", strtotime($trash_item['deleted_at'])); ?>
                                    </div>
                                </div>

                                <div class="trash-actions">
                                    <a href="?mode=edit&restore_id=<?php echo $trash_item['announ_id']; ?>"
                                       class="btn-restore">
                                        <span class="material-symbols-outlined">restore</span>
                                        Restore
                                    </a>
                                    <a href="?mode=edit&perm_delete_id=<?php echo $trash_item['announ_id']; ?>"
                                       class="btn-perm-delete"
                                       onclick="return confirm('Permanently delete this? It cannot be undone.')">
                                        <span class="material-symbols-outlined">delete_forever</span>
                                        Delete Forever
                                    </a>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    </main>
</body>
    <?php include "../includes/footer.php"; ?>
</html>
