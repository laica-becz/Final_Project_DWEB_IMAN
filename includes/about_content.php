<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Community Management System</title>
    <link rel="stylesheet" href="../member/about.css">
</head>
<body>
<div class="container">

    <!-- Header -->
     <div class="about-header">
        <h1><i class="fas fa-info-circle"></i> About our Community</h1>
        <p>Learn more about our community management system and guidelines</p>
    </div>

    <!-- Mission Section -->
    <section class="mission-section">
        <h2>Our Mission</h2>
        <p>
            Our Community Management System is designed to foster better communication, 
            transparency, and collaboration between community members and local administrators. 
            We aim to create a more organized, responsive, and engaged community where every 
            voice is heard and every concern is addressed promptly.
        </p>
    </section>

    <!-- What This System Offers -->
    <section class="offers-section">
        <h2>What This System Offers</h2>
        <div class="offers-grid">

            <div class="offer-card">
                <h3>For Community Members</h3>
                <ul>
                    <li>Access to latest community announcements</li>
                    <li>View trash collection schedules and segregation guidelines</li>
                    <li>Submit reports and concerns directly to administrators</li>
                    <li>Contact information for urgent matters</li>
                    <li>Transparent communication with local government</li>
                </ul>
            </div>

            <div class="offer-card admin">
                <h3>For Administrators</h3>
                <ul>
                    <li>Post and manage community announcements</li>
                    <li>Update trash schedules and environmental guidelines</li>
                    <li>Review and respond to community reports</li>
                    <li>Track and resolve community concerns efficiently</li>
                    <li>Maintain up-to-date community information</li>
                </ul>
            </div>

        </div>
    </section>

    <!-- Guidelines Section -->
    <section class="guidelines-section">
        <h2>Community Guidelines & Usage</h2>

        <div class="guidelines-content">

            <div class="guideline-subsection">
                <h3>General Guidelines</h3>

                <div class="guideline-item">
                    <strong>1. Respectful Communication:</strong>
                    <p>Always communicate respectfully and professionally when submitting reports or concerns.</p>
                </div>

                <div class="guideline-item">
                    <strong>2. Accurate Information:</strong>
                    <p>Provide accurate and truthful information in all reports and submissions.</p>
                </div>

                <div class="guideline-item">
                    <strong>3. Privacy:</strong>
                    <p>Respect the privacy of other community members. Do not share personal information without consent.</p>
                </div>

                <div class="guideline-item">
                    <strong>4. Proper Channels:</strong>
                    <p>Use the appropriate section (Reports for non-urgent matters, Contact for urgent issues).</p>
                </div>
            </div>

            <!-- How to Use the System -->
            <div class="guideline-subsection">
                <h3>How to Use the System</h3>

                <div class="usage-cards">
                    <div class="usage-card pink">
                        <div class="usage-card-content">
                            <h4>Home Page</h4>
                            <p>Check regularly for announcements about community events, updates, and important notices.</p>
                        </div>
                    </div>

                    <div class="usage-card green">
                        <div class="usage-card-content">
                            <h4>Trash Schedule</h4>
                            <p>Review collection schedules and learn proper waste segregation to help keep our community clean.</p>
                        </div>
                    </div>

                    <div class="usage-card purple">
                        <div class="usage-card-content">
                            <h4>Reports & Concerns</h4>
                            <p>Submit non-urgent community issues, suggestions, or concerns. Administrators will review and respond.</p>
                        </div>
                    </div>

                    <div class="usage-card orange">
                        <div class="usage-card-content">
                            <h4>Contact Page</h4>
                            <p>Use this for urgent matters that require immediate attention from municipal authorities.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Response Times -->
            <div class="response-times">
                <h3>Response Times</h3>
                <ul>
                    <li><strong>Reports & Concerns:</strong> Typically reviewed within 2-3 business days</li>
                    <li><strong>Urgent Matters:</strong> Contact page submissions are prioritized for same-day response</li>
                    <li><strong>Announcements:</strong> Updated regularly as events and information become available</li>
                </ul>
            </div>

        </div>
    </section>

    <!-- Show last updated date so residents know the info is current -->
    <p class="last-updated">Last updated: <?php echo date('F j, Y'); ?></p>
</div>
</body>
</html>
