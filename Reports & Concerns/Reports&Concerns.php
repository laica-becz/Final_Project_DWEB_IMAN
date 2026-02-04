<?php 
//to be added
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reports & Concerns</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body> <!--details are not final. Informations to be updated-->
        <div class="container">
            <header class="page-header">
                <div class="header-content">
                    <div class="title-row">
                        <h1>Reports & Concerns</h1> 
                    </div>
                    <p class="subtitle">Submit your concerns and track their resolution</p>
                </div>
                <button class="btn-submit" onclick="alert('Form opening...')">+ Submit New Report</button> <!--SUBMIT BUTTON HERE -to be improved-->
            </header>

            <main class="report-list">
                <!--ARTICLE REPORT CARD #1-->
                <article class="report-card">
                    <div class="badge-container">
                        <span class="badge status-progress">🕒 In Progress</span> <!--status-->
                        <span class="badge tag">Infrastructure</span> <!-- type of concern-->
                    </div>

                    <!--concern-->
                    <h2>Broken Street Light on Oak Avenue</h2> 
                    <p class="report-text">The street light near house #234 on Oak Avenue has been non-functional for the past week. This creates a safety hazard for pedestrians and drivers during night time.</p>
                    <div class="author-meta">Submitted by John Doe on January 25, 2026</div>

                    <!--community admin response:-->
                    <section class="admin-reply">
                        <h3>Administrator Response</h3>
                        <p>Thank you for reporting this. Our maintenance team has been notified and will repair the light within 2-3 business days.</p>
                        <time class="reply-date">Responded on January 26, 2026</time>
                    </section>
                </article>

                <!--ARTICLE REPORT CARD #2-->
                <article class="report-card">
                    <div class="badge-container">
                        <span class="badge status-resolved">✅ Resolved</span>
                        <span class="badge tag">Waste Management</span>
                    </div>
                    <h2>Missed Trash Collection</h2>
                    <p class="report-text">Trash collection was scheduled for Zone B on Thursday but our street (Maple Drive) was not serviced. Several neighbors have the same issue.</p>
                    <div class="author-meta">Submitted by Sarah Johnson on January 22, 2026</div>

                    <section class="admin-reply">
                        <h3>Administrator Response</h3>
                        <p>We apologize for the missed collection. The truck had a mechanical issue that day. We have arranged a special pickup and your area will be serviced tomorrow morning.</p>
                        <time class="reply-date">Responded on January 23, 2026</time>
                    </section>
                </article>

                <!--ARTICLE REPORT CARD #3-->
                <article class="report-card">
                    <div class="badge-container">
                        <span class="badge status-pending">🕒 Pending</span>
                        <span class="badge tag">Parks & Recreation</span>
                    </div>
                    <h2>Community Park Playground Equipment Needs Repair</h2>
                    <p class="report-text">The swing set at Community Park has a broken chain and the slide has sharp edges. This is unsafe for children.</p>
                    <div class="author-meta">Submitted by Michael Chen on January 28, 2026</div>
                </article>
            </main>
        </div>
    </body>
</html>