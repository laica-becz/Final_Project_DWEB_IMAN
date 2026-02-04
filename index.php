<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Main container for the entire page -->
    <div class="container">
        <!-- Header section with title and subtitle -->
        <header class="header">
            <h1>Community Management System</h1>
            <p class="subtitle">Select your role to continue</p>
        </header>

        <!-- Role selection cards container -->
        <div class="role-cards">
            <!-- Community Member Card -->
            <a href="member_portal.php" class="card">
                <!-- Icon container with user icon -->
                <div class="icon-circle icon-blue">
                    <!-- SVG icon for community member (users icon) -->
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <!-- Card title -->
                <h2 class="card-title">Community Member</h2>
                <!-- Card description -->
                <p class="card-description">Access community announcements, trash schedules, guidelines, and submit reports or concerns</p>
            </a>

            <!-- Administrator Card -->
            <a href="admin_login.php" class="card">
                <!-- Icon container with shield icon -->
                <div class="icon-circle icon-purple">
                    <!-- SVG icon for administrator (shield icon) -->
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <!-- Card title -->
                <h2 class="card-title">Administrator</h2>
                <!-- Card description -->
                <p class="card-description">Manage announcements, respond to reports, update schedules, and oversee community operations</p>
            </a>
        </div>
    </div>
</body>
</html>