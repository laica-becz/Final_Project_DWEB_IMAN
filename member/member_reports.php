<?php 
include "includes/member_header.php";

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
        <div class="content-wrapper"> <!--details are not final. Informations to be updated-->
            <div class="container">    
                <div class="page-header">
                    <div class="header-content">
                        <div class="title-row">
                            <h1>Reports & Concerns</h1> 
                    </div>
                        <p class="subtitle">Submit your concerns and track their resolution</p>
                </div>
                    <button class="btn-submit" onclick="alert('Form opening...')">+ Submit New Report</button> <!--SUBMIT BUTTON HERE -to be improved-->
            </div>
            
            <main class="report-list">
                <!--ARTICLE REPORT CARD #1-->
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
                        <p>TThank you for reporting this concern. Our Electrical Maintenance Unit has coordinated with Angeles Electric Corporation (AEC) to inspect the street light. Replacement of the bulb and wiring repair is scheduled within 2–3 working days.</p>
                        <time class="reply-date">Responded on January 26, 2026</time>
                    </section>
                </article>

                <!--ARTICLE REPORT CARD #2-->
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

                <!--ARTICLE REPORT CARD #3-->
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