<?php
include "../includes/member_header.php";
include "../includes/db_conn.php";

// Members always see the most up-to-date schedule the admin has set
$stmt = $pdo->query("SELECT * FROM trash_schedule ORDER BY zone, waste_type");
$schedules = $stmt->fetchAll();

// Guidelines array (static — same as admin view)
$guidelines = [
    [
        'title' => 'Biodegradable',
        'color' => 'green',
        'bag'   => 'Green Bag/Container',
        'items' => ['Food scraps and leftovers','Fruit and vegetable peels','Garden waste (leaves, grass)','Paper towels and tissues','Coffee grounds and tea bags']
    ],
    [
        'title' => 'Non-Biodegradable',
        'color' => 'black',
        'bag'   => 'Black Bag/Container',
        'items' => ['Plastic bags and wrappers','Styrofoam containers','Rubber and synthetic materials','Ceramics and broken glass','Diapers and sanitary items']
    ],
    [
        'title' => 'Recyclable',
        'color' => 'blue',
        'bag'   => 'Blue Bag/Container',
        'items' => ['Clean plastic bottles','Cardboard and paper','Metal cans (aluminum, tin)','Glass bottles and jars','Clean packaging materials']
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Collection Schedule - Community Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/member_trashschedule.css">
</head>
<body>

<div class="container">
    <header>
        <h1><i class="fa-regular fa-calendar-check"></i> Trash Collection Schedule</h1>
        <p>Know when to put out your trash and learn proper waste segregation</p>
    </header>

    <section class="card-section">
        <h2>Collection Schedule by Zone</h2>

        <?php if (count($schedules) === 0): ?>
        <div class="empty-hint">
            <p>No schedules available yet. Please check back later.</p>
        </div>
        <?php else: ?>
        <div class="schedule-grid">
            <?php foreach ($schedules as $row): ?>
            <div class="schedule-item">

                <div class="schedule-header">
                    <div class="sched-left">
                        <strong><?= htmlspecialchars($row['zone']) ?></strong>
                        <span class="badge <?= $row['waste_type'] === 'Biodegradable' ? 'bio' : 'non-bio' ?>">
                            <?= htmlspecialchars($row['waste_type']) ?>
                        </span>
                    </div>
                </div>

                <div class="schedule-details">
                    <?= htmlspecialchars($row['days']) ?> • <?= htmlspecialchars($row['time']) ?>
                </div>

                <!-- Last updated timestamp — pulled from DB, auto-updates when admin edits -->
                <div class="last-updated">
                    <i class="fa-regular fa-clock"></i>
                    Last updated: <?= date("M j, Y g:i A", strtotime($row['last_updated'])) ?>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </section>

    <section class="card-section">
        <h2><i class="fa-solid fa-recycle"></i> Waste Segregation Guidelines</h2>
        <div class="guidelines-grid">
            <?php foreach ($guidelines as $guide): ?>
            <div class="guide-card <?= $guide['color'] ?>">
                <div class="guide-header">
                    <div class="icon-circle">
                        <i class="fa-solid fa-trash-can"></i>
                    </div>
                    <h3><?= $guide['title'] ?></h3>
                </div>
                <div class="guide-content">
                    <p class="bag-type"><strong><?= $guide['bag'] ?></strong></p>
                    <ul>
                        <?php foreach ($guide['items'] as $li): ?>
                        <li><?= $li ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="important-note">
            <strong>Important:</strong> Please rinse all recyclable containers before disposal.
            Contaminated recyclables cannot be processed and will be rejected.
        </div>
    </section>
</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>
