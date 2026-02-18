<?php 
include "../includes/member_header.php";
include "../includes/db_conn.php";

if (isset($_POST['btn_save'])) 
{ 
    $name = mysqli_real_escape_string($conn, $_POST['txt_name']);
    $title = mysqli_real_escape_string($conn, $_POST['txt_title']);
    $tag = mysqli_real_escape_string($conn, $_POST['txt_tag']);
    $content = mysqli_real_escape_string($conn, $_POST['txt_content']);

    $sql = "INSERT INTO reports (report_name, report_title, report_tag, report_content) 
            VALUES ('$name', '$title', '$tag', '$content')";

    if (mysqli_query($conn, $sql)) 
    {
        header("Location: " . $_SERVER['PHP_SELF']); 
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
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
        <title>Reports & Concerns - Community Portal</title>
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
                        <a href="?show_form=true" class="btn-submit">+ Submit New Report</a>
                    <?php endif; ?>
            </div>
            
            <!--WHEN SUBMIT NEW REPORT BUTTON IS CLICKED -->
            <?php if (isset($_GET['show_form'])): ?> 
                <div class="report-card">
                    <h2>Submit New Report</h2>
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
                <!--ARTICLE REPORT CARD FETCHING REAL-TIME DATA FROM MARIADB TABLE STRUCTURE -->
                <?php 
                    $query = "SELECT * FROM reports ORDER BY report_submitted DESC";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0)
                    {
                        while($report = mysqli_fetch_assoc($result)) //MODIFIED: for every row in database it repeats the html codes below 
                        {
                    ?>
                        <article class="report-card">
                            <div class="badge-container">
                                <span class="badge status-pending"><?php echo $report['status']; ?></span>
                                <span class="badge tag"><?php echo $report['report_tag']; ?></span>
                            </div>

                            <a href="?delete_id=<?php echo $report['report_id']; ?>" onclick="return confirm('Remove this report?')" class="remove-option">&times; Remove</a>

                            <h2>
                                <?php echo htmlspecialchars($report['report_title']); //htmlspecialchars ->> all displayed in plain text ?>
                            </h2> 

                            <p class="report-text">
                                <?php echo htmlspecialchars($report['report_content']); ?>
                            </p>

                            <div class="author-meta">
                                Submitted by <?php echo htmlspecialchars($report['report_name']); ?> on <?php echo date("F j, Y", strtotime($report['report_submitted'])); ?>
                            </div>
                            
                            <?php if(!empty($report['admin_note'])): ?>
                                <section class="admin-reply">
                                    <h3>Administrator Response</h3>
                                    <p><?php echo htmlspecialchars($report['admin_note']); ?></p>
                                    <time class="reply-date">Responded on <?php echo date("F j, Y", strtotime($report['admin_resolved'])); ?></time>
                                </section>
                            <?php else: ?>
                                <section class="admin-reply">
                                    <p><em>Awaiting administrative review...</em></p>
                                </section>
                            <?php endif; ?>

                        </article>
                    <?php 
                        }
                    } 
                    ?>

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
