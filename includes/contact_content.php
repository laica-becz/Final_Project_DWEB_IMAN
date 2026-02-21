<?php
// 1. DATA SECTION: Define your departments here
$departments = [
    [
        "title"   => "Waste Management",
        "desc"    => "For trash collection issues, missed pickups, and recycling questions",
        "phone"   => "(555) 123-4570",
        "email"   => "waste@community.gov",
        "bg_class" => "waste-bg"
    ],
    [
        "title"   => "Public Works",
        "desc"    => "For road maintenance, street lighting, and infrastructure concerns",
        "phone"   => "(555) 123-4571",
        "email"   => "publicworks@community.gov",
        "bg_class" => "public-bg"
    ],
    [
        "title"   => "Community Services",
        "desc"    => "For community programs, events, and general inquiries",
        "phone"   => "(555) 123-4572",
        "email"   => "services@community.gov",
        "bg_class" => "services-bg"
    ],
    [
        "title"   => "Emergency Response",
        "desc"    => "For urgent safety issues and immediate municipal emergencies",
        "phone"   => "(555) 123-4568 (24/7)",
        "email"   => "emergency@community.gov",
        "bg_class" => "emergency-bg"
    ],
    [
        "title"   => "Mayor's Office",
        "desc"    => "For important community matters requiring executive attention",
        "phone"   => "(555) 123-4573",
        "email"   => "mayor@community.gov",
        "bg_class" => "mayor-bg"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Community Portal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../css/contact.css">
</head>
<body>
    <main class="container">
        <section class="page-header">
            <div class="title-wrapper">
                <span class="material-symbols-outlined icon-red">call</span>
                <h1>Contact Us</h1>
            </div>
            <p class="subtitle">For urgent matters requiring immediate attention</p>
        </section>

        <div class="emergency-box">
            <span class="material-symbols-outlined error-icon">error_outline</span>
            <div class="emergency-text">
                <h3>For Emergency Situations</h3>
                <p>If you have a life-threatening emergency, please call emergency services immediately at <strong>911</strong>.</p>
                <p>This contact page is for urgent municipal matters that require prompt attention but are not life-threatening emergencies.</p>
            </div>
        </div>

        <div class="contact-grid">
            <div class="white-card">
                <h2>Municipal Office</h2>
                
                <div class="info-item">
                    <div class="icon-circle blue-bg"><span class="material-symbols-outlined">call</span></div>
                    <div>
                        <strong>Phone Numbers</strong>
                        <p>Main Office: (555) 123-4567</p>
                        <p>24/7 Hotline: (555) 123-4568</p>
                        <p>Fax: (555) 123-4569</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon-circle green-bg"><span class="material-symbols-outlined">mail</span></div>
                    <div>
                        <strong>Email Addresses</strong>
                        <p>General: info@community.gov</p>
                        <p>Urgent: urgent@community.gov</p>
                        <p>Mayor's Office: mayor@community.gov</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon-circle purple-bg"><span class="material-symbols-outlined">location_on</span></div>
                    <div>
                        <strong>Address</strong>
                        <p>123 Municipal Drive, Community Center, 2nd Floor</p>
                        <p>Cityville, State 12345</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="icon-circle orange-bg"><span class="material-symbols-outlined">schedule</span></div>
                    <div>
                        <strong>Office Hours</strong>
                        <p>Monday - Friday: 8:00 AM - 5:00 PM</p>
                        <p>Saturday: 9:00 AM - 1:00 PM</p>
                        <p>Sunday: Closed</p>
                        <p class="hotline-text">24/7 Hotline available for emergencies</p>
                    </div>
                </div>
            </div>

            <div class="white-card">
                <h2>Department Contacts</h2>
                
                <?php foreach ($departments as $dept): ?>
                    <div class="dept-card <?php echo $dept['bg_class']; ?>">
                        <h3><?php echo $dept['title']; ?></h3>
                        <p><?php echo $dept['desc']; ?></p>
                        <p class="contact-link"> <?php echo $dept['phone']; ?></p>
                        <p class="contact-link"> <?php echo $dept['email']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="usage-card">
            <h2>When to Use This Contact Page</h2>
            <div class="usage-grid">
                <div class="usage-col">
                    <h4 class="green-text"><span class="material-symbols-outlined">check_box</span> Use Contact Page For:</h4>
                    <ul>
                        <li>Immediate safety hazards (downed power lines, gas leaks)</li>
                        <li>Water main breaks or sewage issues</li>
                        <li>Major road damage or traffic light malfunctions</li>
                        <li>Urgent facility problems affecting public access</li>
                        <li>Time-sensitive matters requiring same-day response</li>
                    </ul>
                </div>
                <div class="usage-col">
                    <h4 class="orange-text"><span class="material-symbols-outlined">edit_square</span> Use Reports & Concerns Page For:</h4>
                    <ul>
                        <li>General community improvements or suggestions</li>
                        <li>Minor maintenance issues</li>
                        <li>Non-urgent complaints or feedback</li>
                        <li>Questions about community programs</li>
                        <li>Matters that can wait 2-3 business days</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    <!-- PHP: Show last updated date so residents know the info is current -->
    <p class="last-updated">Last updated: <?php echo date('F j, Y'); ?></p>
</body>
</html>

