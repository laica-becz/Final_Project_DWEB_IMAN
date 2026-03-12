<?php
include "../includes/db_conn.php";

$message      = '';
$message_type = '';
$edit_row     = null;

/* Here will add the trash schedule entry */
if (isset($_POST['add'])) {
    $zone = mysqli_real_escape_string($conn, $_POST['zone']);
    $days = mysqli_real_escape_string($conn, $_POST['days']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    $sql = "INSERT INTO trash_schedule (zone, days, time, waste_type)
            VALUES ('$zone','$days','$time','$type')";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_trashschedule.php");
        exit();
    } else {
        $message      = "Failed to add: " . mysqli_error($conn);
        $message_type = "error";
    }
}

/* Update the trash schedule entry */
if (isset($_POST['update'])) {
    $id   = (int)$_POST['id'];
    $zone = mysqli_real_escape_string($conn, $_POST['zone']);
    $days = mysqli_real_escape_string($conn, $_POST['days']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    $sql = "UPDATE trash_schedule
            SET zone='$zone', days='$days', time='$time', waste_type='$type'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_trashschedule.php");
        exit();
    } else {
        $message      = "Failed to update: " . mysqli_error($conn);
        $message_type = "error";
    }
}

/* Delete the trash schedule entry */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM trash_schedule WHERE id=$id");
    header("Location: admin_trashschedule.php");
    exit();
}

/* Load for editing */
if (isset($_GET['edit'])) {
    $id       = (int)$_GET['edit'];
    $res      = mysqli_query($conn, "SELECT * FROM trash_schedule WHERE id=$id");
    $edit_row = mysqli_fetch_assoc($res);
}

/* ── FETCH ALL ────────────────────────────────────────────────── */
$result = mysqli_query($conn, "SELECT * FROM trash_schedule ORDER BY zone, waste_type");

/* Static guidelines for admin (also to be displayed to members view) */
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
    <title>Trash Collection Schedule – Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/header.css"> <!-- Reuse header CSS for admin header -->
    <link rel="stylesheet" href="../css/member_trashschedule.css"> <!-- Reuse member CSS for guidelines section -->
    <link rel="stylesheet" href="../css/admin_trashschedule.css">
</head>
<body>

<?php include "../includes/admin_header.php"; ?>

<div class="container">

    <!-- Admin Header class -->
    <div class="admin-header-row">
        <header>
            <h1><i class="fa-regular fa-calendar-check"></i> Trash Collection Schedule</h1>
            <p>Know when to put out your trash and learn proper waste segregation</p>
        </header>
        <?php if (!$edit_row && !isset($_GET['add'])): ?>
        <a href="?add=1" class="btn-add-schedule">
            <i class="fa-solid fa-plus"></i> Add Schedule
        </a>
        <?php endif; ?>
    </div>

    <!-- Flash message for user feedback and code to be locate easier -->
    <?php if ($message): ?>
    <div class="flash-alert <?= $message_type ?>">
        <i class="fa-solid <?= $message_type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation' ?>"></i>
        <?= htmlspecialchars($message) ?>
    </div>
    <?php endif; ?>

    <!-- Collection Schedule by Zone -->
    <section class="card-section">
        <h2>Collection Schedule by Zone</h2>

        <!-- ADD FORM (shows when ?add=1) -->
        <?php if (isset($_GET['add']) && !$edit_row): ?>
        <div class="inline-form-box">
            <h3 style="margin-bottom:14px; font-size:15px; color:#374151;">Add New Schedule</h3>
            <form method="POST" action="">
                <div class="form-row-two">
                    <div class="form-field">
                        <label>Zone</label>
                        <input type="text" name="zone"
                               placeholder="e.g., Zone A (North District)" required>
                    </div>
                    <div class="form-field">
                        <label>Day(s)</label>
                        <input type="text" name="days"
                               placeholder="e.g., Monday & Thursday" required>
                    </div>
                </div>
                <div class="form-row-two">
                    <div class="form-field">
                        <label>Time</label>
                        <input type="text" name="time"
                               placeholder="e.g., 6:00 AM - 10:00 AM" required>
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
                        <i class="fa-solid fa-check"></i> Add
                    </button>
                    <a href="admin_trashschedule.php" class="btn-cancel">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <!-- EDIT FORM (shows when ?edit=ID) -->
        <?php if ($edit_row): ?>
        <div class="inline-form-box">
            <h3 style="margin-bottom:14px; font-size:15px; color:#374151;">Edit Schedule</h3>
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?= $edit_row['id'] ?>">
                <div class="form-row-two">
                    <div class="form-field">
                        <label>Zone</label>
                        <input type="text" name="zone"
                               value="<?= htmlspecialchars($edit_row['zone']) ?>" required>
                    </div>
                    <div class="form-field">
                        <label>Day(s)</label>
                        <input type="text" name="days"
                               value="<?= htmlspecialchars($edit_row['days']) ?>" required>
                    </div>
                </div>
                <div class="form-row-two">
                    <div class="form-field">
                        <label>Time</label>
                        <input type="text" name="time"
                               value="<?= htmlspecialchars($edit_row['time']) ?>" required>
                    </div>
                    <div class="form-field">
                        <label>Waste Type</label>
                        <select name="type">
                            <option value="Biodegradable"
                                <?= $edit_row['waste_type'] === 'Biodegradable' ? 'selected' : '' ?>>
                                Biodegradable
                            </option>
                            <option value="Non-Biodegradable"
                                <?= $edit_row['waste_type'] === 'Non-Biodegradable' ? 'selected' : '' ?>>
                                Non-Biodegradable
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-actions-row">
                    <button type="submit" name="update" class="btn-save">
                        <i class="fa-solid fa-check"></i> Save
                    </button>
                    <a href="admin_trashschedule.php" class="btn-cancel">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <!-- SCHEDULE LIST -->
        <?php if (mysqli_num_rows($result) === 0): ?>
        <div class="empty-hint">
            No schedules yet. Click <strong>+ Add Schedule</strong> to get started.
        </div>
        <?php endif; ?>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="schedule-item">
            <div class="schedule-header">
                <div class="sched-left">
                    <strong><?= htmlspecialchars($row['zone']) ?></strong>
                    <span class="badge <?= ($row['waste_type'] === 'Biodegradable') ? 'bio' : 'non-bio' ?>">
                        <?= htmlspecialchars($row['waste_type']) ?>
                    </span>
                </div>
                <div class="sched-actions">
                    <a href="?edit=<?= $row['id'] ?>" class="icon-btn icon-edit" title="Edit">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="?delete=<?= $row['id'] ?>"
                       class="icon-btn icon-delete" title="Delete"
                       onclick="return confirm('Delete this schedule?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </div>
            </div>
            <div class="schedule-details">
                <?= htmlspecialchars($row['days']) ?> • <?= htmlspecialchars($row['time']) ?>
            </div>
        </div>
        <?php endwhile; ?>

    </section>

    <!-- Waste Segregation Guidelines -->
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

<?php include "../includes/member_footer.php"; ?>
</body>
</html>