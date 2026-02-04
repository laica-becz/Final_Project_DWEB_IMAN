<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Our Community - Community Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Navigation Bar */
        .navbar {
            background: #fff;
            padding: 15px 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            color: #1a1a1a;
            font-size: 1.5rem;
        }

        .back-btn {
            padding: 10px 20px;
            background: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: #1976D2;
        }

        /* Page Header */
        .page-header {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .page-header-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .header-icon {
            width: 40px;
            height: 40px;
            background: #e3f2fd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-icon svg {
            width: 24px;
            height: 24px;
            stroke: #2196F3;
        }

        .page-header h1 {
            color: #1a1a1a;
            font-size: 2rem;
            font-weight: 700;
        }

        .page-header p {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* Mission Section */
        .mission-section {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: #ede7f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-icon svg {
            width: 24px;
            height: 24px;
            stroke: #5e35b1;
        }

        .section-title h2 {
            color: #1a1a1a;
            font-size: 1.75rem;
            font-weight: 600;
        }

        .mission-section p {
            color: #444;
            font-size: 1rem;
            line-height: 1.8;
        }

        /* What System Offers Section */
        .offers-section {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .offers-section .section-icon {
            background: #e1f5fe;
        }

        .offers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .offer-card {
            border-left: 4px solid #2196F3;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .offer-card.admin {
            border-left-color: #4caf50;
        }

        .offer-card h3 {
            color: #1a1a1a;
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .offer-card ul {
            list-style: none;
        }

        .offer-card li {
            color: #444;
            padding: 10px 0;
            line-height: 1.6;
            position: relative;
            padding-left: 10px;
        }

        .offer-card li:before {
            content: "•";
            position: absolute;
            left: 0;
            font-weight: bold;
            color: #2196F3;
        }

        .offer-card.admin li:before {
            color: #4caf50;
        }

        /* Guidelines Section */
        .guidelines-section {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .guidelines-section .section-icon {
            background: #fff3e0;
        }

        .guidelines-section .section-icon svg {
            stroke: #f57c00;
        }

        .guidelines-content {
            margin-top: 30px;
        }

        .guideline-subsection {
            margin-bottom: 35px;
        }

        .guideline-subsection h3 {
            color: #1a1a1a;
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .guideline-item {
            margin-bottom: 15px;
        }

        .guideline-item strong {
            color: #1a1a1a;
        }

        .guideline-item p {
            color: #444;
            line-height: 1.6;
            margin-top: 5px;
        }

        /* How to Use Section */
        .usage-cards {
            display: grid;
            gap: 20px;
            margin-top: 25px;
        }

        .usage-card {
            padding: 20px 25px;
            border-radius: 10px;
            display: flex;
            gap: 15px;
        }

        .usage-card.pink {
            background: #fce4ec;
        }

        .usage-card.green {
            background: #e8f5e9;
        }

        .usage-card.purple {
            background: #f3e5f5;
        }

        .usage-card.orange {
            background: #fff3e0;
        }

        .usage-card-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .usage-card-content h4 {
            color: #1a1a1a;
            font-size: 1.1rem;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .usage-card-content p {
            color: #444;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        /* Response Times Section */
        .response-times {
            margin-top: 30px;
        }

        .response-times h3 {
            color: #1a1a1a;
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .response-times ul {
            list-style: none;
        }

        .response-times li {
            color: #444;
            padding: 10px 0;
            line-height: 1.6;
            position: relative;
            padding-left: 10px;
        }

        .response-times li:before {
            content: "•";
            position: absolute;
            left: 0;
            font-weight: bold;
            color: #f57c00;
        }

        .response-times strong {
            color: #1a1a1a;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .page-header {
                padding: 25px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .mission-section,
            .offers-section,
            .guidelines-section {
                padding: 25px;
            }

            .offers-grid {
                grid-template-columns: 1fr;
            }

            .usage-card {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigation Bar -->
        <nav class="navbar">
            <h1>Community Management System</h1>
            <a href="member-dashboard.html" class="back-btn">Back to Dashboard</a>
        </nav>

        <!-- Page Header -->
        <section class="page-header">
            <div class="page-header-title">
                <div class="header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                </div>
                <h1>About Our Community</h1>
            </div>
            <p>Learn more about our community management system and guidelines</p>
        </section>

        <!-- Mission Section -->
        <section class="mission-section">
            <div class="section-title">
                <div class="section-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="12" r="6"></circle>
                        <circle cx="12" cy="12" r="2"></circle>
                    </svg>
                </div>
                <h2>Our Mission</h2>
            </div>
            <p>
                Our Community Management System is designed to foster better communication, transparency, and collaboration between community members and 
                local administrators. We aim to create a more organized, responsive, and engaged community where every voice is heard and every concern is 
                addressed promptly.
            </p>
        </section>

        <!-- What System Offers Section -->
        <section class="offers-section">
            <div class="section-title">
                <div class="section-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h2>What This System Offers</h2>
            </div>

            <div class="offers-grid">
                <!-- For Community Members -->
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

                <!-- For Administrators -->
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
            <div class="section-title">
                <div class="section-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </div>
                <h2>Community Guidelines & Usage</h2>
            </div>

            <div class="guidelines-content">
                <!-- General Guidelines -->
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
                        <p>Use the appropriate section for your needs (Reports for non-urgent matters, Contact for urgent issues).</p>
                    </div>
                </div>

                <!-- How to Use the System -->
                <div class="guideline-subsection">
                    <h3>How to Use the System</h3>
                    
                    <div class="usage-cards">
                        <div class="usage-card pink">
                            <div class="usage-card-icon">📢</div>
                            <div class="usage-card-content">
                                <h4>Home Page</h4>
                                <p>Check regularly for announcements about community events, updates, and important notices.</p>
                            </div>
                        </div>

                        <div class="usage-card green">
                            <div class="usage-card-icon">🗑️</div>
                            <div class="usage-card-content">
                                <h4>Trash Schedule</h4>
                                <p>Review collection schedules and learn proper waste segregation to help keep our community clean.</p>
                            </div>
                        </div>

                        <div class="usage-card purple">
                            <div class="usage-card-icon">📝</div>
                            <div class="usage-card-content">
                                <h4>Reports & Concerns</h4>
                                <p>Submit non-urgent community issues, suggestions, or concerns. Administrators will review and respond.</p>
                            </div>
                        </div>

                        <div class="usage-card orange">
                            <div class="usage-card-icon">📞</div>
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
    </div>
</body>
</html>
