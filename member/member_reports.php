<?php //note: styles tpo be transferred sa css
include "includes/member_header.php";
session_start(); // alternate of a database, a memory. !! --> CHANGE TO DATABASE

if (isset($_POST['btn_save'])) //_POST ->> looks for the name attribute
{ // isset ->> to check if its declared and is not null
    $new_report = [
        "name"    => $_POST['txt_name'],
        "title"   => $_POST['txt_title'],
        "tag"     => $_POST['txt_tag'],
        "content" => $_POST['txt_content'],
        "date"    => date("F j, Y"), // generates  date
        "status"  => "Pending"
    ];

    // new_reports are being stored to the end of the empty list
    $_SESSION['user_reports'][] = $new_report;

    // header ->> sends a raw http header to the browser
    // _SERVER['PHP_SELF'] ->> var that holds the filename
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit(); // forcing the page to reload
}

if (isset($_GET['delete_id'])) 
{
    $id = $_GET['delete_id'];
    if (isset($_SESSION['user_reports'][$id])) 
    {
        unset($_SESSION['user_reports'][$id]); 
        $_SESSION['user_reports'] = array_values($_SESSION['user_reports']); 
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reports & Concerns - Community Portal</title>
        <link rel="stylesheet" href="reports.css">
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
                        <select name="txt_tag" style="width:100%; margin-bottom:10px; padding:8px;">
                            <option value="Infrastructure">Infrastructure</option>
                            <option value="Waste Management">Waste Management</option>
                            <option value="Safety">Safety</option>
                        </select>
                        <input type="text" name="txt_name" placeholder="Full Name" required style="width:100%; margin-bottom:10px; padding:8px;">
                        <input type="text" name="txt_title" placeholder="What is the issue?" required style="width:100%; margin-bottom:10px; padding:8px;">
                        <textarea name="txt_content" placeholder="Provide details..." required style="width:100%; margin-bottom:10px; padding:8px; height:100px;"></textarea>
                        <button type="submit" name="btn_save" class="btn-submit">Submit Now</button>
                        <a href="?" style="margin-left:10px; color:blue;">Back</a>
                    </form>
                </div>
            <?php endif; ?>

            <main class="report-list">
                <!--SAMPLE ARTICLE REPORT CARD UI STRUCTURE -->
                <?php 
                    if (isset($_SESSION['user_reports'])) 
                    {
                        $fresh_data = array_reverse($_SESSION['user_reports'], true);
                    
                        foreach ($_SESSION['user_reports'] as $key => $report) //MODIFIED. ORIGINAL CODE: foreach ($fresh_data as $report) for every fresh_data it repeats the html codes below 
                        {
                    ?>
                        <article class="report-card">
                            <div class="badge-container">
                                <span class="badge status-pending"><?php echo $report['status']; ?></span>
                                <span class="badge tag"><?php echo $report['tag']; ?></span>
                            </div>

                            <a href="?delete_id=<?php echo $key; ?>" onclick="return confirm('Remove this test report?')" style="float: right; color: red; text-decoration: none; font-weight: bold;">&times; Remove</a>

                            <h2>
                                <?php echo htmlspecialchars($report['title']); //htmlspecialchars ->> all displayed in plain text ?>
                            </h2> 

                            <p class="report-text"><?php echo htmlspecialchars($report['content']); ?></p>
                            <div class="author-meta">Submitted by <?php echo htmlspecialchars($report['name']); ?> on <?php echo $report['date']; ?></div>
                            
                            <section class="admin-reply">
                                <p><em>Awaiting administrative review...</em></p>
                            </section>
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
include "includes/member_footer.php"; 
?>

