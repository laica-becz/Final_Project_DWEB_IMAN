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
);