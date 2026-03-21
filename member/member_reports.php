<?php 
include "../includes/db_conn.php";

if (isset($_POST['btn_save'])) 
{ 
    $name    = trim($_POST['txt_name']);
    $title   = trim($_POST['txt_title']);
    $tag     = $_POST['txt_tag'];
    $content = trim($_POST['txt_content']);

    try {
        $stmt = $pdo->prepare("INSERT INTO reports (report_name, report_title, report_tag, report_content, status) 
                VALUES (?, ?, ?, ?, 'Pending')");  // ← ADD status here
        
        if ($stmt->execute([$name, $title, $tag, $content])) {
            header("Location: " . $_SERVER['PHP_SELF']); 
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
include "../includes/member_header.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reports & Concerns - Community Portal</title>
        <link rel="stylesheet" href="../css/member_reports.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>
    <body>
        
        <div class="content-wrapper"> 
            <div class="container">    
                <div class="page-header">
                    <div class="header-content">
                        <div class="title-row">
                            <h1>Reports & Concerns</h1> 
                        </div>
                        <p class="subtitle">Submit your concerns and track their resolution</p>
                    </div>
                    <?php if (!isset($_GET['show_form'])): ?> 
                        <a href="?show_form=true" class="btn-submit">+ Submit New Report</a>
                    <?php endif; ?>
                </div>
            
            <?php if (isset($_GET['show_form'])): ?> 
                <div class="report-card">
                    <h2>Submit New Report</h2>
                    <form method="POST" action="" onsubmit="return confirm('Are you sure you want to submit this concern? Once submitted, it cannot be edited or deleted.');">
                        <select name="txt_tag" class="_tag">
                            <option value="Infrastructure">Infrastructure</option>
                            <option value="Waste Management">Waste Management</option>
                            <option value="Safety">Safety</option>
                        </select>
                        <input type="text" name="txt_name" placeholder="Full Name" required class="_name">
                        <input type="text" name="txt_title" placeholder="What is the issue?" required class="_title">
                        <textarea name="txt_content" placeholder="Provide details..." required class="_content"></textarea>
                        <button type="submit" name="btn_save" class="btn-submit">Submit Now</button>
                        <a href="?" class="back-option">Back</a>
                    </form>
                </div>
            <?php endif; ?>

            <main class="report-list">
                <?php 
                    $stmt = $pdo->query("SELECT * FROM reports ORDER BY report_submitted DESC");
                    
                    if ($stmt->rowCount() > 0) {
                        while($report = $stmt->fetch()) {
                            // CHECK IF POST IS AN ANNOUNCEMENT
                            $isAnnouncement = ($report['report_tag'] == 'Announcement');
                    ?>
                        <article class="report-card">
                            <div class="badge-container">
                                <?php if(!$isAnnouncement): ?>
                                    <span class="badge status-pending"><?php echo htmlspecialchars($report['status'] ?? ''); ?></span>
                                <?php endif; ?>
                                <span class="badge tag"><?php echo htmlspecialchars($report['report_tag'] ?? ''); ?></span>
                            </div>

                            <h2><?php echo htmlspecialchars($report['report_title'] ?? ''); ?></h2>

                            <p class="report-text"><?php echo htmlspecialchars($report['report_content'] ?? ''); ?></p>

                            <div class="author-meta">
                                Submitted by <?php echo htmlspecialchars($report['report_name'] ?? ''); ?> on <?php echo date("F j, Y", strtotime($report['report_submitted'] ?? '')); ?>
                            </div>
                            
                            <?php if(!empty($report['admin_note'])): ?>
                                <section class="admin-reply">
                                    <h3><?php echo $isAnnouncement ? 'Additional Information' : 'Administrator Response'; ?></h3>
                                    <p><?php echo htmlspecialchars($report['admin_note'] ?? ''); ?></p>
                                    <time class="reply-date">Updated on <?php echo date("F j, Y", strtotime($report['admin_resolved'])); ?></time>
                                </section>
                            <?php elseif(!$isAnnouncement): ?>
                                <section class="admin-reply">
                                    <p><em>Awaiting administrative review...</em></p>
                                </section>
                            <?php endif; ?>

                        </article>
                    <?php 
                        }
                    } 
                    ?>
            </main>
        </div> 
    </body>
</html>

<?php 
include "../includes/footer.php"; 
?>
