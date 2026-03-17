--
-- Database: 'community_portal'
-- 
-- --------------------------------------------------------

-- ----------------------------------
-- Table structure for admins
-- ----------------------------------

CREATE TABLE admins (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ----------------------------------
-- Table structure for announcements
-- ----------------------------------

CREATE TABLE announcements (
    announ_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    priority VARCHAR(50) NOT NULL,
    class VARCHAR(20) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ----------------------------------
-- Table structure for trash schedule
-- ----------------------------------

CREATE TABLE trash_schedule (
    trash_id INT AUTO_INCREMENT PRIMARY KEY,
    zone VARCHAR(255) NOT NULL,
    days VARCHAR(255) NOT NULL,
    time VARCHAR(100) NOT NULL,
    waste_type VARCHAR(100) NOT NULL
);

-- ----------------------------------
-- Table structure for reports
-- ----------------------------------

CREATE TABLE reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    report_name VARCHAR(100) NOT NULL,
    report_title VARCHAR(200) NOT NULL,
    report_tag VARCHAR(50) NOT NULL,
    report_content TEXT NOT NULL,
    report_submitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Pending',
    admin_note TEXT NULL,
    admin_resolved TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` 
(`report_id`, `report_name`, `report_title`, `report_tag`, `report_content`, `report_submitted`, `status`, `admin_note`, `admin_resolved`) 
VALUES
(1, 'Michael Chen', 'Community Park Playground Equipment Needs Repair', 'Parks & Recreation', 'The swing set at Bayanihan Park along Fil-Am Friendship Highway has a broken chain, and the slide has exposed sharp metal edges.', '2026-01-28 14:20:00', 'Pending', NULL, NULL),
(2, 'John Doe', 'Broken Street Light on Sto. Rosario Street', 'Infrastructure', 'The street light in front of House #123 along Sto. Rosario Street has not been functioning since January 18, 2026.', '2026-01-25 08:00:00', 'In Progress', 'Thank you for reporting this concern. Our Electrical Maintenance Unit has coordinated with AEC.', '2026-01-26 10:30:00'),
(3, 'Sarah Johnson', 'Missed Trash Collection', 'Waste Management', 'Garbage collection for Barangay Pampang (Zone B) was scheduled on Thursday, January 22, 2026.', '2026-01-22 09:15:00', 'Resolved', 'We sincerely apologize. A special pickup has been arranged.', '2026-01-23 07:45:00');
