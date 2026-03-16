<?php 
include "../includes/admin_header.php"; 
include "../includes/db_conn.php";

// 1. DATABASE UPDATE LOGIC: Handles the response sent by the admin
if (isset($_POST['btn_send_response'])) {
    $report_id = mysqli_real_escape_string($conn, $_POST['report_id']);
    $admin_note = mysqli_real_escape_string($conn, $_POST['txt_admin_response']);
    $current_date = date("Y-m-d H:i:s");

    // We update the record and change status to 'In Progress' automatically
    $sql = "UPDATE reports SET 
            admin_note = '$admin_note', 
            admin_resolved = '$current_date',
            status = 'In Progress' 
            WHERE report_id = '$report_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_reports.php");
        exit();
    }
}

if (isset($_GET['delete_id'])) 
{
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $sql = "DELETE FROM reports WHERE report_id = '$id'";
    
    if (mysqli_query($conn, $sql)) 
    {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>(ADMIN) Reports & Concerns - Community Portal</title>
        <link rel="stylesheet" href="../member/member_reports.css">
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
                    <!--SUBMIT NEW REPORT BUTTON-->
                    <?php if (!isset($_GET['show_form'])): //_GET ->> if the html has this specific special tag "?show_form=true" it hides the button once clicked and it shows the input fields ?> 
                        <a href="?show_form=true" class="btn-submit">POST</a>
                    <?php endif; ?>
            </div>
            
            <!--POST STRUCTURE LAYOUT -->
            <?php if (isset($_GET['show_form'])): ?> 
                <div class="report-card">
                    <h2>ADMIN POST</h2>
                    <form method="POST" action="">
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
                <!-- -->
                <?php // 2. REAL-TIME FETCH: This ensures new user concerns appear here immediately
                    $query = "SELECT * FROM reports ORDER BY report_submitted DESC";
                    $result = mysqli_query($conn, $query);
                    
                    while($report = mysqli_fetch_assoc($result)) {
                ?>
                <article class="report-card">
                    <div class="badge-container">
                        <span class="badge status-pending"><?php echo $report['status']; ?></span>
                        <span class="badge tag"><?php echo $report['report_tag']; ?></span>
                    </div>

                    <a href="?delete_id=<?php echo $report['report_id']; ?>" onclick="return confirm('Remove this report?')" class="remove-option">&times; Remove</a>

                    <h2><?php echo htmlspecialchars($report['report_title']); ?></h2> 
                    <p class="report-text"><?php echo htmlspecialchars($report['report_content']); ?></p>

                    <div class="author-meta">
                        Submitted by <?php echo htmlspecialchars($report['report_name']); ?> on <?php echo date("F j, Y", strtotime($report['report_submitted'])); ?>
                    </div>

                    <div class="response-container">
                        <?php if(empty($report['admin_note'])): ?>
                            
                            <?php if(!isset($_GET['reply_to']) || $_GET['reply_to'] != $report['report_id']): ?>
                                <a href="?reply_to=<?php echo $report['report_id']; ?>" class="btn-respond-trigger">
                                    <span>💬</span> Respond to Report
                                </a>
                            <?php else: ?>
                                <form method="POST">
                                    <input type="hidden" name="report_id" value="<?php echo $report['report_id']; ?>">
                                    <textarea name="txt_admin_response" class="response-textarea" placeholder="Type your response here..." rows="3" required></textarea>
                                    <div class="admin-actions">
                                        <button type="submit" name="btn_send_response" class="btn-send">➤ Send Response</button>
                                        <a href="admin_reports.php" class="btn-cancel">Cancel</a>
                                    </div>
                                </form>
                            <?php endif; ?>

                        <?php else: ?>
                            <section class="admin-reply">
                                <h3>Administrator Response</h3>
                                <p><?php echo htmlspecialchars($report['admin_note']); ?></p>
                                <time class="reply-date">Responded on <?php echo date("F j, Y", strtotime($report['admin_resolved'])); ?></time>
                            </section>
                        <?php endif; ?>
                    </div>
                </article>
                <?php } ?>

                <!--SAMPLE ARTICLE REPORT CARD FORMAT -->
                <article class="report-card">
                    <div class="badge-container">
                        <span class="badge status-progress">In Progress</span> <!--status-->
                        <span class="badge tag">Infrastructure</span> <!-- type of concern-->
                    </div>

                    <!--concern-->
                    <h2>Broken Street Light on Sto. Rosario Street</h2> 
                    <p class="report-text">The street light in front of House #123 along Sto. Rosario Street, Barangay Sto. Rosario, Angeles City has not been functioning since January 18, 2026. The area becomes very dark at night, especially near the intersection going towards Holy Angel University. Residents and motorists have raised concerns about visibility and safety, particularly for students and tricycle drivers passing through the area.</p>
                    <div class="author-meta">Submitted by John Doe on January 25, 2026</div>

                    <!--community admin response:-->
                    <section class="admin-reply">
                        <h3>Administrator Response</h3>
                        <p>Thank you for reporting this concern. Our Electrical Maintenance Unit has coordinated with Angeles Electric Corporation (AEC) to inspect the street light. Replacement of the bulb and wiring repair is scheduled within 2–3 working days.</p>
                        <time class="reply-date">Responded on January 26, 2026</time>
                    </section>
                </article>

                <!--SAMPLE ARTICLE REPORT CARD FORMAT -->
                <article class="report-card">
                    <div class="badge-container">
                        <span class="badge status-resolved">Resolved</span>
                        <span class="badge tag">Waste Management</span>
                    </div>

                    <h2>Missed Trash Collection</h2>
                    <p class="report-text">Garbage collection for Barangay Pampang (Zone B) was scheduled on Thursday, January 22, 2026. However, Block 5 along Maple Drive was not serviced. Several households in the area have uncollected waste, which is starting to produce foul odor and attract stray animals.</p>
                    <div class="author-meta">Submitted by Sarah Johnson on January 22, 2026</div>

                    <section class="admin-reply">
                        <h3>Administrator Response</h3>
                        <p>We sincerely apologize for the inconvenience. The garbage truck assigned to Zone B experienced mechanical trouble that morning. A special pickup has been arranged for January 23, 2026, at 7:00 AM. Please ensure your trash bins are placed outside before the scheduled time.</p>
                        <time class="reply-date">Responded on January 23, 2026</time>
                    </section>
                </article>

                <!--SAMPLE ARTICLE REPORT CARD FORMAT -->
                <article class="report-card">
                    <div class="badge-container">
                        <span class="badge status-pending">Pending</span>
                        <span class="badge tag">Parks & Recreation</span>
                    </div>
                    
                    <h2>Community Park Playground Equipment Needs Repair</h2>
                    <p class="report-text">The swing set at Bayanihan Park along Fil-Am Friendship Highway, Barangay Anunas, has a broken chain, and the slide has exposed sharp metal edges. Several parents have expressed concern as children continue to use the playground despite the hazard.</p>
                    <div class="author-meta">Submitted by Michael Chen on January 28, 2026</div>
                </article>
            </main>
        </div> 
    </body>
</html>

<?php 
include "../includes/member_footer.php"; 
?>
