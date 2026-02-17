<?php
include "includes/header.php";

// Data arrays for easy maintenance
$collection_schedule = [
    ['zone' => 'Zone A (North District)', 'type' => 'Biodegradable', 'days' => 'Monday & Thursday', 'time' => '6:00 AM - 10:00 AM', 'class' => 'bio'],
    ['zone' => 'Zone A (North District)', 'type' => 'Non-Biodegradable', 'days' => 'Tuesday & Friday', 'time' => '6:00 AM - 10:00 AM', 'class' => 'non-bio'],
    ['zone' => 'Zone B (South District)', 'type' => 'Non-Biodegradable', 'days' => 'Monday & Thursday', 'time' => '7:00 AM - 11:00 AM', 'class' => 'non-bio'],
    ['zone' => 'Zone B (South District)', 'type' => 'Biodegradable', 'days' => 'Tuesday & Friday', 'time' => '7:00 AM - 11:00 AM', 'class' => 'bio'],
    ['zone' => 'Zone C (East District)', 'type' => 'Biodegradable', 'days' => 'Wednesday & Saturday', 'time' => '6:00 AM - 10:00 AM', 'class' => 'bio'],
    ['zone' => 'Zone C (East District)', 'type' => 'Non-Biodegradable', 'days' => 'Wednesday & Saturday', 'time' => '2:00 PM - 5:00 PM', 'class' => 'non-bio'],
];

// Array for waste segregation guidelines
$guidelines = [
    [
        'title' => 'Biodegradable',
        'color' => 'green',
        'bag' => 'Green Bag/Container',
        'items' => ['Food scraps and leftovers', 'Fruit and vegetable peels', 'Garden waste (leaves, grass)', 'Paper towels and tissues', 'Coffee grounds and tea bags']
    ],
    [
        'title' => 'Non-Biodegradable',
        'color' => 'black',
        'bag' => 'Black Bag/Container',
        'items' => ['Plastic bags and wrappers', 'Styrofoam containers', 'Rubber and synthetic materials', 'Ceramics and broken glass', 'Diapers and sanitary items']
    ],
    [
        'title' => 'Recyclable',
        'color' => 'blue',
        'bag' => 'Blue Bag/Container',
        'items' => ['Clean plastic bottles', 'Cardboard and paper', 'Metal cans (aluminum, tin)', 'Glass bottles and jars', 'Clean packaging materials']
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash Collection Schedule</title>
    <link rel="stylesheet" href="trashsched.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="container">
    <header>
        <h1><i class="fa-regular fa-calendar-check"></i> Trash Collection Schedule</h1>
        <p>Know when to put out your trash and learn proper waste segregation</p>
    </header>

    <section class="card-section">
        <h2>Collection Schedule by Zone</h2>
        <div class="schedule-grid">
            <?php foreach ($collection_schedule as $item): ?>
            <div class="schedule-item">
                
                <div class="schedule-header">
                    <strong><?php echo $item['zone']; ?></strong>
                    <span class="badge <?php echo $item['class']; ?>"><?php echo $item['type']; ?></span>
                </div>
                
                <div class="schedule-details">
                    <?php echo $item['days']; ?> • <?php echo $item['time']; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="card-section">
        <h2><i class="fa-solid fa-recycle"></i> Waste Segregation Guidelines</h2>
        <div class="guidelines-grid">
            <?php foreach ($guidelines as $guide): ?>
            <div class="guide-card <?php echo $guide['color']; ?>">
                <div class="guide-header">
                    
                    <div class="icon-circle">
                        <i class="fa-solid fa-trash-can"></i>
                    </div>
                    <h3><?php echo $guide['title']; ?></h3>
                </div>
                
                <div class="guide-content">
                    <p class="bag-type"><strong><?php echo $guide['bag']; ?></strong></p>
                    <ul>
                        <?php foreach ($guide['items'] as $li): ?>
                        <li><?php echo $li; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="important-note">
            <strong>Important:</strong> Please rinse all recyclable containers before disposal. Contaminated recyclables cannot be processed and will be rejected.
        </div>
    </section>
</div>

<?php include "includes/footer.php"; ?>

</body>
</html>

