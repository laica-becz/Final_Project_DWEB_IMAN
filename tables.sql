-- ----------------------------
-- Database: 'community_portal'
-- ----------------------------

-- ----------------------------------
-- Table structure for admin
-- ----------------------------------

CREATE TABLE admins (
    'admin_id' INT PRIMARY KEY AUTO_INCREMENT,
    'username' VARCHAR(50) UNIQUE NOT NULL,
    'password' VARCHAR(255) NOT NULL,
    'email' VARCHAR(100) NOT NULL,
    'full_name' VARCHAR(100) NOT NULL,
    'created_at' TIMESTAMP DEFAULT CURRENT_TIMESTAMP
):

-- ----------------------------------
-- Table structure for announcements
-- ----------------------------------

CREATE TABLE announcements (
    'announ_id' int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    'title' varchar(255) NOT NULL,
    'content' text NOT NULL,
    'priority' varchar(50) NOT NULL,
    'class' varchar(20) NOT NULL,
    'date' timestamp DEFAULT CURRENT_TIMESTAMP
);

-- ----------------------------------
-- Table structure for trash schedule
-- ----------------------------------

CREATE TABLE trash_schedule (
    'trash_id' int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    'zone' varchar(255) NOT NULL,
    'days' varchar(255) NOT NULL,
    'time' varchar(100) NOT NULL,
    'waste_type' varchar(100) NOT NULL
);

-- ----------------------------------
-- Table structure for reports
-- ----------------------------------

CREATE TABLE reports (
    'report_id' INT AUTO_INCREMENT PRIMARY KEY,
    'report_name' VARCHAR(100) NOT NULL,
    'report_title' VARCHAR(200) NOT NULL,
    'report_tag' VARCHAR(50) NOT NULL,
    'report_content' TEXT NOT NULL,
    'report_submitted' TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    'status' VARCHAR(20) DEFAULT 'Pending',
    'admin_note' TEXT NULL,
    'admin_resolved' TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `report_name`, `report_title`, `report_tag`, `report_content`, `report_submitted`, `status`, `admin_note`, `admin_resolved`) VALUES
(1, 'John Doe', 'Broken Street Light on Sto. Rosario Street', 'Infrastructure', 'The street light in front of House #123 along Sto. Rosario Street, Barangay Sto. Rosario, Angeles City has not been functioning since January 18, 2026. The area becomes very dark at night, especially near the intersection going towards Holy Angel University. Residents and motorists have raised concerns about visibility and safety.', '2026-01-25 08:00:00', 'In Progress', 'Thank you for reporting this concern. Our Electrical Maintenance Unit has coordinated with Angeles Electric Corporation (AEC) to inspect the street light. Replacement of the bulb and wiring repair is scheduled within 2-3 working days.', '2026-01-26 10:30:00'),
(2, 'Sarah Johnson', 'Missed Trash Collection', 'Waste Management', 'Garbage collection for Barangay Pampang (Zone B) was scheduled on Thursday, January 22, 2026. However, Block 5 along Maple Drive was not serviced. The trash bins are starting to overflow, and stray animals are scattering the waste.', '2026-01-22 09:15:00', 'Resolved', 'We sincerely apologize for the inconvenience. The garbage truck assigned to Zone B experienced mechanical trouble that morning. A special pickup has been arranged for January 23, 2026, at 7:00 AM.', '2026-01-23 07:45:00');

-- --------------------------------------------------------
