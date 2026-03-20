<?php
require_once '../includes/auth_check.php';
include "../includes/db_conn.php";

$message      = '';
$message_type = '';
$edit_row     = null;

/* Check if schedule_history table exists */
$check_table    = $pdo->query("SHOW TABLES LIKE 'schedule_history'");
$history_exists = ($check_table && $check_table->rowCount() > 0);

/* ADD */
if (isset($_POST['add'])) {
    $zone = $_POST['zone'];
    $days = $_POST['days'];
    $time = $_POST['time'];
    $type = $_POST['type'];

    try {
        // Insert into main table (last_updated is handled automatically by MySQL)
        $stmt = $pdo->prepare("INSERT INTO trash_schedule (zone, days, time, waste_type)
                VALUES (?, ?, ?, ?)");
        $stmt->execute([$zone, $days, $time, $type]);

        // LOG: record Add action into history table
        if ($history_exists) {
            $log_stmt = $pdo->prepare("INSERT INTO schedule_history (action, zone, waste_type, days, time, acted_at)
                    VALUES ('Added', ?, ?, ?, ?, NOW())");
            $log_stmt->execute([$zone, $type, $days, $time]);
        }
        
        header("Location: /admin/admin_trashschedule.php");
        exit();
    } catch (PDOException $e) {
        $message = "Failed to add: " . $e->getMessage();
        $message_type = "error";
    }
}

/* UPDATE */
if (isset($_POST['update'])) {
    $id   = (int)$_POST['id'];
    $zone = $_POST['zone'];
    $days = $_POST['days'];
    $time = $_POST['time'];
    $type = $_POST['type'];

    try {
        // Update main table (last_updated auto-updates via ON UPDATE trigger)
        $stmt = $pdo->prepare("UPDATE trash_schedule
                SET zone=?, days=?, time=?, waste_type=?
                WHERE id=?");
        $stmt->execute([$zone, $days, $time, $type, $id]);

        // LOG: record Update action into history table
        if ($history_exists) {
            $log_stmt = $pdo->prepare("INSERT INTO schedule_history (action, zone, waste_type, days, time, acted_at)
                    VALUES ('Updated', ?, ?, ?, ?, NOW())");
            $log_stmt->execute([$zone, $type, $days, $time]);
        }
        
        header("Location: /admin/admin_trashschedule.php");
        exit();
    } catch (PDOException $e) {
        $message = "Failed to update: " . $e->getMessage();
        $message_type = "error";
    }
}

/* DELETE */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    try {
        // SELECT the row FIRST — data is gone after delete, so we save it
        $fetch_stmt = $pdo->prepare("SELECT * FROM trash_schedule WHERE id=?");
        $fetch_stmt->execute([$id]);
        $old = $fetch_stmt->fetch();

        if ($old) {
            // Now safe to delete
            $delete_stmt = $pdo->prepare("DELETE FROM trash_schedule WHERE id=?");
            $delete_stmt->execute([$id]);

            // LOG: record Delete action using the saved $old data
            if ($history_exists) {
                $log_stmt = $pdo->prepare("INSERT INTO schedule_history (action, zone, waste_type, days, time, acted_at)
                        VALUES ('Deleted', ?, ?, ?, ?, NOW())");
                $log_stmt->execute([$old['zone'], $old['waste_type'], $old['days'], $old['time']]);
            }
        }

        header("Location: /admin/admin_trashschedule.php");
        exit();
    } catch (PDOException $e) {
        $message = "Failed to delete: " . $e->getMessage();
        $message_type = "error";
    }
}

/* LOAD ROW FOR EDITING */
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM trash_schedule WHERE id=?");
    $stmt->execute([$id]);
    $edit_row = $stmt->fetch();
}

/* SUCCESS MESSAGES */
if (isset($_GET['success'])) {
    $msgs = [
        'added'   => 'Schedule added successfully!',
        'updated' => 'Schedule updated successfully!',
        'deleted' => 'Schedule deleted successfully!',
    ];
    if (isset($msgs[$_GET['success']])) {
        $message      = $msgs[$_GET['success']];
        $message_type = "success";
    }
}

/* FETCH ALL SCHEDULES */
$result = $pdo->query("SELECT * FROM trash_schedule ORDER BY zone, waste_type");
$schedules = $result->fetchAll();

/* FETCH HISTORY LOG + COUNT TOTALS */
$history_rows  = [];
$count_added   = 0;
$count_updated = 0;
$count_deleted = 0;

if ($history_exists) {
    $hstmt = $pdo->query("SELECT * FROM schedule_history ORDER BY acted_at DESC");
    while ($h = $hstmt->fetch()) {
        if ($h['action'] === 'Added')   $count_added++;
        if ($h['action'] === 'Updated') $count_updated++;
        if ($h['action'] === 'Deleted') $count_deleted++;
        $history_rows[] = $h;
    }
}
$total_changes = $count_added + $count_updated + $count_deleted;

/* STATIC GUIDELINES (shared with member view) */
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

include "../includes/admin_header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Collection Schedule – Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/member_trashschedule.css">
    <link rel="stylesheet" href="../css/admin_trashschedule.css">
</head>
<body>

<div class="container">

    <!-- Page Header -->
    <div class="admin-header-row">
        <header>
            <h1><i class="fa-regular fa-calendar-check"></i> Trash Collection Schedule</h1>
            <p>Know when to put out your trash and learn proper waste segregation</p>
        </header>
        <?php if (!isset($_GET['add'])): ?>
            <a href="?add=1" class="btn-add-schedule">
                <i class="fa-solid fa-plus"></i> Add Schedule
            </a>
        <?php else: ?>
            <a href="admin_trashschedule.php" class="btn-done">
                <i class="fa-solid fa-check"></i> Done
            </a>
        <?php endif; ?>
    </div>

    <!-- Flash message (success or error) -->
    <?php if ($message): ?>
    <div class="flash-alert <?= $message_type ?>">
        <i class="fa-solid <?= $message_type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation' ?>"></i>
        <?= htmlspecialchars($message) ?>
    </div>
    <?php endif; ?>

    <!-- SCHEDULE SECTION -->
    <section class="card-section">
        <h2>Collection Schedule by Zone</h2>

        <!-- ADD FORM -->
        <?php if (isset($_GET['add']) && !$edit_row): ?>
        <div class="add-form-container">
            <h3 style="margin-bottom:14px;font-size:16px;color:#374151;">Add New Schedule</h3>
            <form method="POST" action="">
                <div class="form-row-two">
                    <div class="form-field">
                        <label>Zone</label>
                        <input type="text" name="zone" placeholder="e.g., Zone A (North District)" required>
                    </div>
                    <div class="form-field">
                        <label>Day(s)</label>
                        <input type="text" name="days" placeholder="e.g., Monday & Thursday" required>
                    </div>
                </div>
                <div class="form-row-two">
                    <div class="form-field">
                        <label>Time</label>
                        <input type="text" name="time" placeholder="e.g., 6:00 AM - 10:00 AM" required>
                    </div>
                    <div class="form-field">
                        <label>Waste Type</label>
                        <select name="type">
                            <option value="Biodegradable">Biodegradable</option>
                            <option value="Non-Biodegradable">Non-Biodegradable</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions-row">
                    <button type="submit" name="add" class="btn-save">
                        <i class="fa-solid fa-check"></i> Add Schedule
                    </button>
                    <a href="admin_trashschedule.php" class="btn-cancel">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <!-- EDIT FORM -->
        <?php if ($edit_row): ?>
        <div class="edit-form-container">
            <h3 style="margin-bottom:14px;font-size:16px;color:#374151;">Edit Schedule</h3>
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?= $edit_row['id'] ?>">
                <div class="form-row-two">
                    <div class="form-field">
                        <label>Zone</label>
                        <input type="text" name="zone" value="<?= htmlspecialchars($edit_row['zone']) ?>" required>
                    </div>
                    <div class="form-field">
                        <label>Day(s)</label>
                        <input type="text" name="days" value="<?= htmlspecialchars($edit_row['days']) ?>" required>
                    </div>
                </div>
                <div class="form-row-two">
                    <div class="form-field">
                        <label>Time</label>
                        <input type="text" name="time" value="<?= htmlspecialchars($edit_row['time']) ?>" required>
                    </div>
                    <div class="form-field">
                        <label>Waste Type</label>
                        <select name="type">
                            <option value="Biodegradable" <?= $edit_row['waste_type']==='Biodegradable' ? 'selected':'' ?>>Biodegradable</option>
                            <option value="Non-Biodegradable" <?= $edit_row['waste_type']==='Non-Biodegradable' ? 'selected':'' ?>>Non-Biodegradable</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions-row">
                    <button type="submit" name="update" class="btn-save">
                        <i class="fa-solid fa-check"></i> Save Changes
                    </button>
                    <a href="admin_trashschedule.php?add=1" class="btn-cancel">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <!-- EMPTY STATE -->
        <?php if (count($schedules) === 0): ?>
        <div class="empty-hint">
            <i class="fa-solid fa-trash-can" style="font-size:30px;opacity:0.3;margin-bottom:10px;"></i>
            <p>No schedules yet. Click <strong>+ Add Schedule</strong> to get started.</p>
        </div>
        <?php endif; ?>

        <!-- SCHEDULE LIST -->
        <?php foreach ($schedules as $row): ?>
        <div class="schedule-item">
            <div class="schedule-header">
                <!-- Zone name left, badge right — matches member view -->
                <div class="sched-left">
                    <strong><?= htmlspecialchars($row['zone']) ?></strong>
                    <span class="badge <?= $row['waste_type']==='Biodegradable' ? 'bio':'non-bio' ?>">
                        <?= htmlspecialchars($row['waste_type']) ?>
                    </span>
                </div>
                <?php if (isset($_GET['add']) && !$edit_row): ?>
                <div class="schedule-actions">
                    <a href="?edit=<?= $row['id'] ?>&add=1" class="action-btn edit-btn" title="Edit">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="?delete=<?= $row['id'] ?>&add=1" class="action-btn delete-btn" title="Delete"
                       onclick="return confirm('Delete this schedule?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <div class="schedule-details">
                <?= htmlspecialchars($row['days']) ?> • <?= htmlspecialchars($row['time']) ?>
            </div>
            <div class="last-updated">
                <i class="fa-regular fa-clock"></i>
                Last updated: <?= date("M j, Y g:i A", strtotime($row['last_updated'])) ?>
            </div>
        </div>
        <?php endforeach; ?>
    </section>

    <!-- COLLECTION HISTORY TRACKER -->
    <section class="card-section">
        <h2><i class="fa-solid fa-clock-rotate-left"></i> Collection History Tracker</h2>

        <?php if (!$history_exists): ?>
        <div class="empty-hint">
            <p>Create the <code>schedule_history</code> table first using the SQL shown above.</p>
        </div>
        <?php else: ?>

        <!-- Stat cards -->
        <div class="history-stats">
            <div class="stat-card">
                <div class="stat-label">Total changes</div>
                <div class="stat-value"><?= $total_changes ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Added</div>
                <div class="stat-value added"><?= $count_added ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Updated</div>
                <div class="stat-value updated"><?= $count_updated ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Deleted</div>
                <div class="stat-value deleted"><?= $count_deleted ?></div>
            </div>
        </div>

        <!-- History log table -->
        <?php if (empty($history_rows)): ?>
        <div class="empty-hint">
            <i class="fa-solid fa-clock-rotate-left" style="font-size:28px;opacity:0.3;margin-bottom:10px;"></i>
            <p>No history yet. Add, edit, or delete a schedule to see the log here.</p>
        </div>
        <?php else: ?>
        <div class="history-table-wrapper">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Zone</th>
                        <th>Waste type</th>
                        <th>Day(s)</th>
                        <th>Time</th>
                        <th>Date &amp; time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history_rows as $h): ?>
                    <tr>
                        <td>
                            <span class="history-badge <?= strtolower($h['action']) ?>">
                                <?= htmlspecialchars($h['action']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($h['zone']) ?></td>
                        <td><?= htmlspecialchars($h['waste_type']) ?></td>
                        <td><?= htmlspecialchars($h['days']) ?></td>
                        <td><?= htmlspecialchars($h['time']) ?></td>
                        <td class="history-date">
                            <?= date("M j, Y g:i A", strtotime($h['acted_at'])) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </section>

    <!-- GUIDELINES SECTION (same data as member view) -->
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
