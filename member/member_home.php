<?php include "../includes/member_header.php"; ?>
<?php
$announcements = [
    [
        "title"    => "Community Clean-Up Drive This Saturday",
        "priority" => "High Priority",
        "class"    => "high", // This matches your CSS .high badge
        "content"  => "Join us for our monthly community clean-up drive this Saturday at 8:00 AM. Meeting point at the Community Center. Bring your own gloves and bags. Light refreshments will be provided.",
        "date"     => "January 28, 2026"
    ],
    [
        "title"    => "New Trash Segregation Guidelines",
        "priority" => "High Priority",
        "class"    => "high",
        "content"  => "Please note the updated trash segregation guidelines effective February 1st. Check the Trash Schedule page for detailed information on proper waste separation.",
        "date"     => "January 25, 2026"
    ],
    [
        "title"    => "Community Center Renovation Update",
        "priority" => "Normal",
        "class"    => "normal", // This matches your CSS .normal badge
        "content"  => "The community center renovation is progressing well. We expect completion by mid-February. Thank you for your patience during this improvement project.",
        "date"     => "January 20, 2026"
    ],
    [
        "title"    => "Street Lighting Maintenance Scheduled",
        "priority" => "Normal",
        "class"    => "normal",
        "content"  => "Street lighting maintenance will be conducted in Zones A and B next week. Some areas may experience temporary outages during evening hours.",
        "date"     => "January 18, 2026"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Community Portal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/member_home.css">
</head>
<body>
    <main class="container">
        <section class="announcements-header">
            <div class="title-wrapper">
                <span class="material-symbols-outlined main-megaphone">campaign</span>
                <h1>Community Announcements</h1>
            </div>
            <p class="subtitle">Stay updated with the latest news and events in our community</p>
        </section>

        <?php foreach ($announcements as $item): ?>
            <div class="card">
                <span class="badge <?php echo $item['class']; ?>">
                    <?php echo $item['priority']; ?>
                </span>
                
                <h3><?php echo $item['title']; ?></h3>
                <p><?php echo $item['content']; ?></p>
                
                <div class="date">
                    <span class="material-symbols-outlined">calendar_month</span> 
                    <?php echo $item['date']; ?>
                </div>
            </div>
        <?php endforeach; ?>
        
    </main>

    <?php include "../includes/member_footer.php"; ?>
</body>
</html>

