<?php 
// --- SETUP ---
// We pull in the header (navigation) and the database connection file
include "../includes/admin_header.php"; 
include "../includes/db_conn.php"; 

// --- 1. HANDLE POSTS (Saving New or Updated Data) ---
// This triggers when the admin clicks the "Save" button in the form
if (isset($_POST['btn_save_announcement'])) {
    
    // Get the input data (PDO handles escaping automatically with prepared statements)
    $title = $_POST['txt_title'];
    $content = $_POST['txt_content'];
    $priority = $_POST['txt_priority'];
    $event_date = $_POST['txt_date']; 
    
    // Choose a CSS class based on priority so High Priority looks different (usually red)
    $class = ($priority == 'High Priority') ? 'high' : 'normal';

    try {
        // CHECK: Are we updating an old post or making a brand new one?
        if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
            // UPDATE: Change existing data where the ID matches
            $edit_id = $_POST['edit_id'];
            $stmt = $pdo->prepare("UPDATE announcements SET title=?, content=?, priority=?, class=?, date=? WHERE id=?");
            $stmt->execute([$title, $content, $priority, $class, $event_date, $edit_id]);
        } else {
            // INSERT: Create a completely new row in the database
            $stmt = $pdo->prepare("INSERT INTO announcements (title, content, priority, class, date) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $content, $priority, $class, $event_date]);
        }

        // If it works, refresh the page to show the changes
        header("Location: admin_home.php?mode=edit");
        exit();
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// --- 2. HANDLE DELETE (Removing Data) ---
// This triggers if "delete_id" is found in the URL (e.g., admin_home.php?delete_id=5)
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    try {
        $stmt = $pdo->prepare("DELETE FROM announcements WHERE id=?");
        $stmt->execute([$delete_id]);
        header("Location: admin_home.php?mode=edit");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// --- 3. LOGIC FOR MODES (Switching between View and Edit) ---
// We check the URL to see if the admin clicked "Edit Mode" or the "Edit Icon"
$is_edit_mode = (isset($_GET['mode']) && $_GET['mode'] == 'edit') || isset($_GET['edit_id']) || isset($_GET['show_add']);

// Determine if the form should say "Edit" or "New"
$form_mode = isset($_GET['edit_id']) ? "edit" : "add";
$edit_data = null;

// If we are editing, go fetch that specific post's current data from the database to fill the form
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $pdo->prepare("SELECT * FROM announcements WHERE id=?");
    $stmt->execute([$edit_id]);
    $edit_data = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/member_home.css">
    
    <style>
        /* This CSS handles the look of the "Edit Mode" toggle switch at the top */
        .admin-controls { display: flex; align-items: center; gap: 15px; }
        .btn-mode-toggle {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 16px; border-radius: 50px;
            text-decoration: none; font-weight: 600;
            transition: 0.3s; border: 2px solid #4f46e5;
        }
        .mode-off { color: #4f46e5; background: transparent; }
        .mode-on { color: white; background: #4f46e5; }
        label { display: block; font-weight: 600; margin-bottom: 5px; }
    </style>
</head>
<body>
    <main class="container">
        <section class="announcements-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="title-wrapper">
                <span class="material-symbols-outlined main-megaphone">campaign</span>
                <h1>Community Announcements</h1>
            </div>

            <div class="admin-controls">
                <?php if ($is_edit_mode && !isset($_GET['show_add']) && !isset($_GET['edit_id'])): ?>
                    <a href="?mode=edit&show_add=true" class="btn-submit" style="background-color: #10b981; text-decoration: none; padding: 10px 20px; color: white; border-radius: 8px;">+ New Post</a>
                <?php endif; ?>

                <a href="?mode=<?php echo $is_edit_mode ? 'view' : 'edit'; ?>" 
                   class="btn-mode-toggle <?php echo $is_edit_mode ? 'mode-on' : 'mode-off'; ?>">
                    <span class="material-symbols-outlined"><?php echo $is_edit_mode ? 'edit_off' : 'edit'; ?></span>
                    <?php echo $is_edit_mode ? 'Exit Edit Mode' : 'Edit Mode'; ?>
                </a>
            </div>
        </section>

        <?php if ($is_edit_mode && (isset($_GET['show_add']) || isset($_GET['edit_id']))): ?>
            <div class="card" style="border: 2px solid #4f46e5; padding: 30px; border-radius: 12px; margin-bottom: 25px;">
                <h2><?php echo ($form_mode == "edit") ? "Edit Announcement" : "New Announcement"; ?></h2>
                <form method="POST">
                    <input type="hidden" name="edit_id" value="<?php echo $edit_data['id'] ?? ''; ?>">
                    
                    <div style="margin-bottom: 15px;">
                        <label>Title</label>
                        <input type="text" name="txt_title" required value="<?php echo htmlspecialchars($edit_data['title'] ?? ''); ?>" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Date of Event/Notice</label>
                        <input type="date" name="txt_date" required value="<?php echo $edit_data['date'] ?? ''; ?>" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Content</label>
                        <textarea name="txt_content" required style="width: 100%; height: 100px; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;"><?php echo htmlspecialchars($edit_data['content'] ?? ''); ?></textarea>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label>Priority</label>
                        <select name="txt_priority" style="padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">
                            <option value="Normal" <?php echo (isset($edit_data['priority']) && $edit_data['priority'] == 'Normal') ? 'selected' : ''; ?>>Normal</option>
                            <option value="High Priority" <?php echo (isset($edit_data['priority']) && $edit_data['priority'] == 'High Priority') ? 'selected' : ''; ?>>High Priority</option>
                        </select>
                    </div>

                    <button type="submit" name="btn_save_announcement" style="background: #10b981; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer;">Save</button>
                    <a href="admin_home.php?mode=edit" style="margin-left: 10px; color: #6b7280; text-decoration: none;">Cancel</a>
                </form>
            </div>
        <?php endif; ?>

        <?php 
        $stmt = $pdo->query("SELECT * FROM announcements ORDER BY date DESC");
        while ($item = $stmt->fetch()) { 
        ?>
            <div class="card" style="position: relative;">
                <?php if ($is_edit_mode): ?>
                    <div style="position: absolute; top: 25px; right: 25px; display: flex; gap: 12px;">
                        <a href="?mode=edit&edit_id=<?php echo $item['id']; ?>" style="color: #6366f1;"><span class="material-symbols-outlined">edit</span></a>
                        <a href="?mode=edit&delete_id=<?php echo $item['id']; ?>" onclick="return confirm('Delete?')" style="color: #ef4444;"><span class="material-symbols-outlined">delete</span></a>
                    </div>
                <?php endif; ?>

                <span class="badge <?php echo $item['class']; ?>"><?php echo $item['priority']; ?></span>
                <h3 style="<?php echo $is_edit_mode ? 'margin-right: 80px;' : ''; ?>"><?php echo htmlspecialchars($item['title']); ?></h3>
                <p><?php echo htmlspecialchars($item['content']); ?></p>
                <div class="date"><span class="material-symbols-outlined">calendar_month</span> <?php echo date("F j, Y", strtotime($item['date'])); ?></div>
            </div>
        <?php } ?>
    </main>
</body>
    <?php include "../includes/member_footer.php"; ?>
</html>
