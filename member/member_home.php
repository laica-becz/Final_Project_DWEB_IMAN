<?php
// --- SETUP ---
// This is the MEMBER/USER side — view only, no editing allowed
include "../includes/member_header.php";
include "../includes/db_conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Community Announcements</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/member_home.css">
    <link rel="stylesheet" href="../css/member_announcements.css">
</head>
<body>
    <main class="container">

        <!-- ===== PAGE HEADER ===== -->
        <section class="announcements-header">
            <div class="title-wrapper">
                <span class="material-symbols-outlined main-megaphone">campaign</span>
                <h1>Community Announcements</h1>
            </div>
        </section>

        <!-- ===== ANNOUNCEMENTS LIST ===== -->
        <?php
        // Only fetch posts that are NOT soft-deleted (deleted_at is NULL)
        $stmt = $pdo->query("SELECT * FROM announcements WHERE deleted_at IS NULL ORDER BY date DESC");
        $announcements = $stmt->fetchAll();

        if (count($announcements) === 0): ?>
            <div class="empty-state">
                <span class="material-symbols-outlined empty-icon">campaign</span>
                <p>No announcements at the moment. Check back soon!</p>
            </div>

        <?php else: ?>
            <?php foreach ($announcements as $item): ?>
                <div class="card">
                    <span class="badge <?php echo htmlspecialchars($item['class']); ?>">
                        <?php echo htmlspecialchars($item['priority']); ?>
                    </span>
                    <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                    <p><?php echo htmlspecialchars($item['content']); ?></p>
                    <div class="date">
                        <span class="material-symbols-outlined">calendar_month</span>
                        <?php echo date("F j, Y", strtotime($item['date'])); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </main>
</body>
    <?php include "../includes/footer.php"; ?>
</html>
