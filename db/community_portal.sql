-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2026 at 09:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `community_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announ_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `priority` varchar(50) NOT NULL,
  `class` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announ_id`, `title`, `content`, `priority`, `class`, `date`, `deleted_at`, `admin_id`) VALUES
(1, 'Community Clean-Up Drive This Saturday', 'Join us for our monthly community clean-up drive this Saturday at 8:00 AM. Meeting point at the Community Center. Bring your own gloves and bags. Light refreshments will be provided.', 'High Priority', 'high', '2026-01-27 16:00:00', NULL, NULL),
(2, 'New Trash Segregation Guidelines', 'Please note the updated trash segregation guidelines effective February 1st. Check the Trash Schedule page for detailed information on proper waste separation.', 'High Priority', 'high', '2026-01-24 16:00:00', NULL, NULL),
(3, 'Community Center Renovation Update', 'The community center renovation is progressing well. We expect completion by mid-February. Thank you for your patience during this improvement project.', 'Normal', 'normal', '2026-01-19 16:00:00', NULL, NULL),
(4, 'Street Lighting Maintenance Scheduled', 'Street lighting maintenance will be conducted in Zones A and B next week. Some areas may experience temporary outages during evening hours.', 'Normal', 'normal', '2026-01-17 16:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `report_name` varchar(100) NOT NULL,
  `report_title` varchar(200) NOT NULL,
  `report_tag` varchar(50) NOT NULL,
  `report_content` text NOT NULL,
  `report_submitted` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending',
  `admin_note` text DEFAULT NULL,
  `admin_resolved` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `report_name`, `report_title`, `report_tag`, `report_content`, `report_submitted`, `status`, `admin_note`, `admin_resolved`) VALUES
(1, 'Michael Chen', 'Community Park Playground Equipment Needs Repair', 'Parks & Recreation', 'The swing set at Bayanihan Park along Fil-Am Friendship Highway has a broken chain, and the slide has exposed sharp metal edges.', '2026-01-28 06:20:00', 'Pending', NULL, NULL),
(2, 'John Doe', 'Broken Street Light on Sto. Rosario Street', 'Infrastructure', 'The street light in front of House #123 along Sto. Rosario Street has not been functioning since January 18, 2026.', '2026-01-25 00:00:00', 'In Progress', 'Thank you for reporting this concern. Our Electrical Maintenance Unit has coordinated with AEC.', '2026-01-26 02:30:00'),
(3, 'Sarah Johnson', 'Missed Trash Collection', 'Waste Management', 'Garbage collection for Barangay Pampang (Zone B) was scheduled on Thursday, January 22, 2026.', '2026-01-22 01:15:00', 'Resolved', 'We sincerely apologize. A special pickup has been arranged.', '2026-01-22 23:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_history`
--

CREATE TABLE `schedule_history` (
  `id` int(11) NOT NULL,
  `action` varchar(20) NOT NULL,
  `zone` varchar(255) NOT NULL,
  `waste_type` varchar(100) NOT NULL,
  `days` varchar(255) NOT NULL,
  `time` varchar(100) NOT NULL,
  `acted_at` datetime NOT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trash_schedule`
--

CREATE TABLE `trash_schedule` (
  `id` int(11) NOT NULL,
  `zone` varchar(100) NOT NULL,
  `days` varchar(100) NOT NULL,
  `time` varchar(100) NOT NULL,
  `waste_type` varchar(50) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trash_schedule`
--

INSERT INTO `trash_schedule` (`id`, `zone`, `days`, `time`, `waste_type`, `last_updated`, `admin_id`) VALUES
(1, 'Zone A (North District)', 'Monday & Thursday', '6:00 AM - 10:00 AM', 'Biodegradable', '2026-03-20 00:23:45', NULL),
(2, 'Zone A (North District)', 'Tuesday & Friday', '6:00 AM - 10:00 AM', 'Non-Biodegradable', '2026-03-20 00:23:45', NULL),
(3, 'Zone B (South District)', 'Monday & Thursday', '7:00 AM - 11:00 AM', 'Non-Biodegradable', '2026-03-20 00:23:45', NULL),
(4, 'Zone B (South District)', 'Tuesday & Friday', '7:00 AM - 11:00 AM', 'Biodegradable', '2026-03-20 00:23:45', NULL),
(5, 'Zone C (East District)', 'Wednesday & Saturday', '6:00 AM - 10:00 AM', 'Biodegradable', '2026-03-20 00:23:45', NULL),
(6, 'Zone C (East District)', 'Wednesday & Saturday', '2:00 PM - 5:00 PM', 'Non-Biodegradable', '2026-03-20 00:23:45', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announ_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `schedule_history`
--
ALTER TABLE `schedule_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `trash_schedule`
--
ALTER TABLE `trash_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announ_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule_history`
--
ALTER TABLE `schedule_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trash_schedule`
--
ALTER TABLE `trash_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE SET NULL;

--
-- Constraints for table `schedule_history`
--
ALTER TABLE `schedule_history`
  ADD CONSTRAINT `schedule_history_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE SET NULL;

--
-- Constraints for table `trash_schedule`
--
ALTER TABLE `trash_schedule`
  ADD CONSTRAINT `trash_schedule_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
