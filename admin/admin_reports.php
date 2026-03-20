<?php 
require_once '../includes/auth_check.php';
include "../includes/db_conn.php";

// ADD ANNOUNCEMENT 
if (isset($_POST['btn_save'])) {
    $title   = $_POST['txt_title'];
    $content = $_POST['txt_content'];
    $name    = "Administrator"; 
    $tag     = "Announcement";

    try {
        $stmt = $pdo->prepare("INSERT INTO reports (report_name, report_title, report_tag, report_content, status) 
                               VALUES (?, ?, ?, ?, 'Resolved')");
        $stmt->execute([$name, $title, $tag, $content]);
        header("Location: /admin/admin_reports.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// HANDLE RESPOND TO REPORT & ADD NEW ANNOUNCEMENT LOGIC
if (isset($_POST['btn_send_response'])) {
    $report_id  = $_POST['report_id'];
    $admin_note = $_POST['txt_admin_response'];
    $current_date = date("Y-m-d H:i:s");

    try {
        if (isset($_POST['txt_status'])) {
            $new_status = $_POST['txt_status'];
            $stmt = $pdo->prepare("UPDATE reports SET 
                                   admin_note = ?, 
                                   admin_resolved = ?,
                                   status = ?
                                   WHERE report_id = ?");
            $stmt->execute([$admin_note, $current_date, $new_status, $report_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE reports SET 
                                   admin_note = ?, 
                                   admin_resolved = ?
                                   WHERE report_id = ?");
            $stmt->execute([$admin_note, $current_date, $report_id]);
        }
        header("Location: /admin/admin_reports.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// HANDLE DELETE
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM reports WHERE report_id = ?");
        $stmt->execute([$id]);
        header("Location: /admin/admin_reports.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

include "../includes/admin_header.php"; 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>(ADMIN) Reports & Concerns</title>
        <link rel="stylesheet" href="../css/member_reports.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>
    <body>
        <div class="content-wrapper"> 
            <div class="container">    

                <div class="page-header">
                    <div class="header-content">
                        <h1>Reports & Concerns</h1> 
                        <p class="subtitle">Monitor concerns and post announcements</p>
                    </div>

                    <?php if (!isset($_GET['show_form'])): ?> 
                        <a href="?show_form=true" class="btn-submit">Add New Notice</a> 
                    <?php endif; ?>
                </div>
                
                <?php if (isset($_GET['show_form'])): ?> 
                    <div class="report-card">
                        <h2>ADMIN ANNOUNCEMENT</h2>
                        <form method="POST" action="">
                            <input type="text" name="txt_title" placeholder="Announcement Title" required class="_title">
                            <textarea name="txt_content" placeholder="Provide details..." required class="_content"></textarea>
                            <button type="submit" name="btn_save" class="btn-submit">Submit Now</button>
                            <a href="?" class="back-option">Back</a>
                        </form>
                    </div>
                <?php endif; ?>

                <main class="report-list">
                    <?php 
                        $stmt = $pdo->query("SELECT * FROM reports ORDER BY report_submitted DESC");
                        while($report = $stmt->fetch()) {
                            $isAnnouncement = ($report['report_tag'] == 'Announcement');
                    ?>
                    
                    <article class="report-card">
                        <div class="badge-container">
                            <?php if(!$isAnnouncement): ?>
                                <span class="badge status-pending"><?php echo $report['status']; ?></span>
                            <?php endif; ?>
                            <span class="badge tag"><?php echo $report['report_tag']; ?></span>
                        </div>

                        <a href="?delete_id=<?php echo $report['report_id']; ?>" onclick="return confirm('Remove this item?')" class="remove-option">&times; Remove</a>

                        <h2><?php echo htmlspecialchars($report['report_title']); ?></h2> 
                        <p class="report-text"><?php echo htmlspecialchars($report['report_content']); ?></p>

                        <div class="author-meta">
                            Submitted by <?php echo htmlspecialchars($report['report_name']); ?> on <?php echo date("F j, Y", strtotime($report['report_submitted'])); ?>
                        </div>

                        <div class="response-container">
                            <?php 
                            if( (empty($report['admin_note']) && isset($_GET['reply_to']) && $_GET['reply_to'] == $report['report_id']) || 
                                (!empty($report['admin_note']) && isset($_GET['edit_id']) && $_GET['edit_id'] == $report['report_id']) ): 
                            ?>
                                <form method="POST">
                                    <input type="hidden" name="report_id" value="<?php echo $report['report_id']; ?>">
                                    
                                    <?php if(!$isAnnouncement): ?>
                                        <label>Set Status: </label>
                                        <select name="txt_status" class="status-select">
                                            <option value="Pending" <?php if($report['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                            <option value="In Progress" <?php if($report['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                                            <option value="Resolved" <?php if($report['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
                                        </select>
                                    <?php endif; ?>

                                    <textarea name="txt_admin_response" class="response-textarea" 
                                              placeholder="<?php echo $isAnnouncement ? 'Add more to announcement...' : 'Type your response here...'; ?>" 
                                              rows="3" required><?php echo htmlspecialchars($report['admin_note']); ?></textarea>
                                    
                                    <div class="admin-actions">
                                        <button type="submit" name="btn_send_response" class="btn-send">
                                            <?php echo $isAnnouncement ? 'Update Announcement' : 'Send Response'; ?>
                                        </button>
                                        <a href="admin_reports.php" class="btn-cancel">Cancel</a>
                                    </div>
                                </form>
                            
                            <?php elseif(empty($report['admin_note'])): ?>
                                <a href="?reply_to=<?php echo $report['report_id']; ?>" class="btn-respond-trigger">
                                    <?php echo $isAnnouncement ? 'Add more announcement' : 'Respond to Report'; ?>
                                </a>
                            
                            <?php else: ?>
                                <section class="admin-reply">
                                    <hr>
                                    <h3><?php echo $isAnnouncement ? 'Additional Information' : 'Administrator Response'; ?></h3>
                                    <p><?php echo htmlspecialchars($report['admin_note']); ?></p>
                                    <div>
                                        <a href="?edit_id=<?php echo $report['report_id']; ?>" class="btn-respond-trigger">
                                            <?php echo $isAnnouncement ? 'Continue announcement' : 'Edit Response'; ?>
                                        </a>
                                    </div>
                                </section>
                            <?php endif; ?>
                        </div>
                    </article>
                    <?php } ?>
                </main>
            </div> 
        </div>
    </body>
</html>

<?php include "../includes/footer.php"; ?>
