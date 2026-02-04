<?php
$zones = [
    [
        'name' => 'Zone A (North District)',
        'biodegradable' => true,
        'schedule' => 'Monday & Thursday • 6:00 AM - 10:00 AM'
    ],
    [
        'name' => 'Zone A (North District)',
        'biodegradable' => false,
        'schedule' => 'Tuesday & Friday • 6:00 AM - 10:00 AM'
    ],
    [
        'name' => 'Zone B (South District)',
        'biodegradable' => false,
        'schedule' => 'Monday & Thursday • 7:00 AM - 11:00 AM'
    ],
    [
        'name' => 'Zone B (South District)',
        'biodegradable' => true,
        'schedule' => 'Tuesday & Friday • 7:00 AM - 11:00 AM'
    ],
    [
        'name' => 'Zone C (East District)',
        'biodegradable' => true,
        'schedule' => 'Wednesday & Saturday • 6:00 AM - 10:00 AM'
    ],
    [
        'name' => 'Zone C (East District)',
        'biodegradable' => false,
        'schedule' => 'Wednesday & Saturday • 2:00 PM - 6:00 PM'
    ]
];

$wasteTypes = [
    'biodegradable' => [
        'title' => 'Biodegradable',
        'icon' => '(ala)',
        'color' => '#10b981',
        'container' => 'Green Bag/Container',
        'items' => [
            'Food scraps and leftovers',
            'Fruit and vegetable peels',
            'Garden waste (leaves, grass)',
            'Paper towels and tissues',
            'Coffee grounds and tea bags'
        ]
    ],
    'non_biodegradable' => [
        'title' => 'Non-Biodegradable',
        'icon' => '(ala)',
        'color' => '#6b7280',
        'container' => 'Black Bag/Container',
        'items' => [
            'Plastic bags and wrappers',
            'Styrofoam containers',
            'Rubber and synthetic materials',
            'Ceramics and broken glass',
            'Diapers and sanitary items'
        ]
    ],
    'recyclable' => [
        'title' => 'Recyclable',
        'icon' => '(ala)',
        'color' => '#3b82f6',
        'container' => 'Blue Bag/Container',
        'items' => [
            'Clear plastic bottles',
            'Cardboard and paper',
            'Metal cans (aluminum, tin)',
            'Glass bottles and jars',
            'Clean packaging materials'
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Collection Schedule - Community Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Main Content -->
    <main class="container">
        <div class="page-header">
            <div class="header-icon">(tbc)</div>
            <div>
                <h1>Trash Collection Schedule</h1>
                <p class="subtitle">Know when to put out your trash and learn proper waste segregation</p>
            </div>
        </div>

        <!-- Collection Schedule by Zone -->
        <section class="schedule-section">
            <h2>Collection Schedule by Zone</h2>

            <div class="schedule-list">
                <?php foreach ($zones as $zone): ?>  <!-- use foreach as the efficient way -->
                <div class="schedule-item">
                    <div class="schedule-header">
                         <span class="zone-name"><?= $zone['name'] ?></span> <!-- htmlspecialchars converts special characters to HTML entities -->
                        <span class="badge <?php echo $zone['biodegradable'] ? 'badge-green' : 'badge-gray'; ?>">
                            <?php echo $zone['biodegradable'] ? 'Biodegradable' : 'Non-Biodegradable'; ?>
                        </span>
                    </div>

                    <div class="schedule-time">
                       <div class="schedule-time"><?= $zone['schedule'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

    <script src="script.js"></script>
</body>
</html>