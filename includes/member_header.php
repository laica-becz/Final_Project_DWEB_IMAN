<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="navbar">
        <div class="logo">Community Portal</div>
        <div class="nav-links">
            <a href="../member/member_home.php" class="nav-item"><i class="fa-solid fa-house"></i> Home</a>
            <a href="../member/about.php" class="nav-item"><i class="fa-solid fa-circle-info"></i> About</a>
            <a href="../member/member_trashschedule.php" class="nav-item"><i class="fa-solid fa-calendar-days"></i> Trash Schedule</a>
            <a href="../member/member_reports.php" class="nav-item"><i class="fa-solid fa-comment-dots"></i> Reports</a>
            <a href="../member/contact.php" class="nav-item"><i class="fa-solid fa-phone"></i> Contact</a>
        </div>
        <div class="user-actions">
            <button class="btn-user"><i class="fa-solid fa-user"></i> User</button>
            <button class="btn-logout" onclick="window.location.href='../includes/logout.php'">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </div>
</nav>
</body>
</html>
