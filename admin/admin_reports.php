<?php 
include "../includes/admin_header.php"; 
include "../includes/db_conn.php";

//ADD ANNOUNCEMENT 
if (isset($_POST['btn_save'])) { //When admin submit/post an announcemrnt
    $title = mysqli_real_escape_string($conn, $_POST['txt_title']);
    $content = mysqli_real_escape_string($conn, $_POST['txt_content']);
    $name = "Administrator"; 
    $tag = "Announcement";

    $sql = "INSERT INTO reports (report_name, report_title, report_tag, report_content, status) 
            VALUES ('$name', '$title', '$tag', '$content', 'Resolved')";

    if (mysqli_query($conn, $sql)) { //prevents duplicate submissions when refreshing
        header("Location: admin_reports.php"); 
        exit();
    }
}

//HANDLE RESPOND TO REPORT & ADD NEW ANNOUNCEMENT LOGIC
if (isset($_POST['btn_send_response'])) {
    $report_id = mysqli_real_escape_string($conn, $_POST['report_id']);
    $admin_note = mysqli_real_escape_string($conn, $_POST['txt_admin_response']);
    
    // Only update status if it's NOT an announcement
    $status_update = "";
    if (isset($_POST['txt_status'])) {
        $new_status = mysqli_real_escape_string($conn, $_POST['txt_status']);
        $status_update = ", status = '$new_status'";
    }

    //Updates the sql reports table
    $current_date = date("Y-m-d H:i:s");
    $sql = "UPDATE reports SET 
            admin_note = '$admin_note', 
            admin_resolved = '$current_date'
            $status_update 
            WHERE report_id = '$report_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_reports.php");
        exit();
    }
}

// HANDLE DELETE
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $sql = "DELETE FROM reports WHERE report_id = '$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin_reports.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>(ADMIN) Reports & Concerns</title>
        <!---The page uses the same css of member_reports.php--->
        <link rel="stylesheet" href="../css/member_reports.css"> 
    </head>
    <body>
        <div class="content-wrapper"> 
            <div class="container">    

                <!--|| HEADER SECTION OF THE PAGE ||-->
                <div class="page-header">
                    <div class="header-content">
                        <h1>Admin - Reports & Concerns</h1> 
                        <p class="subtitle">Monitor concerns and post announcements</p>
                    </div>

                    <!---Edit Button of the Admin (Where the Admin can post announcements)--->
                    <?php if (!isset($_GET['show_form'])): ?> 
                        <a href="?show_form=true" class="btn-submit">Add New Notice</a> 
                    <?php endif; ?>
                </div>
                
                <!---The form structure shows, once the above codes are confirmed or was confirmed that the button "Add New Notice" was clicked once--->
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

                <!---Below the Header of the Page the REPORTS are DISPLAYED (Same reports that are from member_reports.php--->
                <main class="report-list">
                    <?php 
                        $query = "SELECT * FROM reports ORDER BY report_submitted DESC";
                        $result = mysqli_query($conn, $query);
                        
                        while($report = mysqli_fetch_assoc($result)) {
                            $isAnnouncement = ($report['report_tag'] == 'Announcement');
                    ?>
                    
                    <!--|| REPORT CARDS STRUCTURE ||-->
                    <article class="report-card">
                        <div class="badge-container">
                            <?php if(!$isAnnouncement): ?>
                                <span class="badge status-pending"><?php echo $report['status']; ?></span>
                            <?php endif; ?>
                            
                            <span class="badge tag"><?php echo $report['report_tag']; ?></span>
                        </div>

                            <a href="?delete_id=<?php echo $report['report_id']; ?>" onclick="return confirm('Remove this item?')" class="remove-option" >&times; Remove</a>

                                <h2><?php echo htmlspecialchars($report['report_title']); ?></h2> 
                                <p class="report-text"><?php echo htmlspecialchars($report['report_content']); ?></p>

                        <div class="author-meta">
                            Submitted by <?php echo htmlspecialchars($report['report_name']); ?> on <?php echo date("F j, Y", strtotime($report['report_submitted'])); ?>
                        </div>

                        <!--|| RESPOND TO REPORT or ADD MORE ANNOUNCEMENT BUTTON STRUCTURES ||-->
                        <div class="response-container">
                            <?php 
                            if( (empty($report['admin_note']) && isset($_GET['reply_to']) && $_GET['reply_to'] == $report['report_id']) || 
                                (!empty($report['admin_note']) && isset($_GET['edit_id']) && $_GET['edit_id'] == $report['report_id']) ): 
                            ?>
                                <!--- Shows Respond Textbox once the "Respond to Report" or "Add More Annoucement" is clicked--->
                                <form method="POST">
                                    <input type="hidden" name="report_id" value="<?php echo $report['report_id']; ?>">
                                    
                                    
                                    <?php if(!$isAnnouncement): ?><!---Status are only visible to "Repond to report" button--->
                                        <label>Set Status: </label>
                                        <select name="txt_status" class="status-select">
                                            <option value="Pending" <?php if($report['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                            <option value="In Progress" <?php if($report['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                                            <option value="Resolved" <?php if($report['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
                                        </select>
                                    <?php endif; ?>

                                    <textarea name="txt_admin_response" class="response-textarea" placeholder="<?php echo $isAnnouncement ? 'Add more to announcement...' : 'Type your response here...'; ?>" rows="3" required><?php echo htmlspecialchars($report['admin_note']); ?></textarea>
                                    
                                    <div class="admin-actions">
                                        <button type="submit" name="btn_send_response" class="btn-send">
                                            <?php echo $isAnnouncement ? 'Update Announcement' : 'Send Response'; ?>
                                        </button>
                                        <a href="admin_reports.php" class="btn-cancel">Cancel</a>
                                    </div>
                                </form>
                            
                            <!--- Response Buttons --->
                            <?php elseif(empty($report['admin_note'])): ?>
                                <a href="?reply_to=<?php echo $report['report_id']; ?>" class="btn-respond-trigger">
                                    <?php if($isAnnouncement): ?>
                                        Add more announcement
                                    <?php else: ?>
                                        Respond to Report
                                    <?php endif; ?>
                                </a>
                            
                            <!--- After Responding Buttons --->
                            <?php else: ?>
                                <section class="admin-reply">
                                    <hr>
                                    <h3>
                                        <?php echo $isAnnouncement ? 'Additional Information' : 'Administrator Response'; ?> 
                                    </h3>
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

<?php 
include "../includes/member_footer.php"; 
?>
