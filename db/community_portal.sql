-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 26, 2026 at 04:29 AM
-- Server version: 8.0.45
-- PHP Version: 8.3.26

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
  `admin_id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `email`, `full_name`, `role`, `created_at`) VALUES
(2, 'admin1', '$2y$10$UvR0rLnvbwWZO/GNkSlgl.btSoFrauw3ZISIF0tPcF4Jpx1C/ifrG', 'admin1@barangay.gov', 'Admin 1', 'admin', '2026-03-24 08:41:58'),
(3, 'admin2', '$2y$10$3rILwsxzuNtdr.a2OHAj7eMNb9eyayrjICQhAv3ElX6v6SHXOKH9W', 'admin2@barangay.gov', 'Admin 2', 'admin', '2026-03-24 08:42:39');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announ_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `priority` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `admin_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announ_id`, `title`, `content`, `priority`, `class`, `date`, `deleted_at`, `admin_id`) VALUES
(1, 'Community Clean-Up Drive This Saturday', 'Join us for our monthly community clean-up drive this Saturday at 8:00 AM. Meeting point at the Community Center. Bring your own gloves and bags. Light refreshments will be provided.', 'High Priority', 'high', '2026-01-27 00:00:00', NULL, 2),
(2, 'New Trash Segregation Guidelines', 'Please note the updated trash segregation guidelines effective February 1st. Check the Trash Schedule page for detailed information on proper waste separation.', 'High Priority', 'high', '2026-01-24 00:00:00', NULL, 3),
(3, 'Community Center Renovation Update', 'The community center renovation is progressing well. We expect completion by mid-February. Thank you for your patience during this improvement project.', 'Normal', 'normal', '2026-01-19 00:00:00', NULL, 2),
(4, 'Street Lighting Maintenance Scheduled', 'Street lighting maintenance will be conducted in Zones A and B next week. Some areas may experience temporary outages during evening hours.', 'Normal', 'normal', '2026-01-17 00:00:00', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int NOT NULL,
  `report_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_tag` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `admin_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `admin_resolved` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `report_name`, `report_title`, `report_tag`, `report_content`, `report_submitted`, `status`, `admin_note`, `admin_resolved`) VALUES
(1, 'Michael Chen', 'Community Park Playground Equipment Needs Repair', 'Parks & Recreation', 'The swing set at Bayanihan Park along Fil-Am Friendship Highway has a broken chain, and the slide has exposed sharp metal edges.', '2026-01-28 06:20:00', 'Pending', 'Thank you for your concern. We\'ll send workers immediately.', '2026-03-26 04:28:55'),
(2, 'John Doe', 'Broken Street Light on Sto. Rosario Street', 'Infrastructure', 'The street light in front of House #123 along Sto. Rosario Street has not been functioning since January 18, 2026.', '2026-01-25 00:00:00', 'In Progress', 'Thank you for reporting this concern. Our Electrical Maintenance Unit has coordinated with AEC.', '2026-01-26 02:30:00'),
(3, 'Sarah Johnson', 'Missed Trash Collection', 'Waste Management', 'Garbage collection for Barangay Pampang (Zone B) was scheduled on Thursday, January 22, 2026.', '2026-01-22 01:15:00', 'Resolved', 'We sincerely apologize. A special pickup has been arranged.', '2026-01-22 23:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_history`
--

CREATE TABLE `schedule_history` (
  `id` int NOT NULL,
  `action` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `zone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `waste_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `days` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `acted_at` datetime NOT NULL,
  `admin_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_history`
--

INSERT INTO `schedule_history` (`id`, `action`, `zone`, `waste_type`, `days`, `time`, `acted_at`, `admin_id`) VALUES
(1, 'Added', 'Zone E', 'Biodegradable', 'Saturday', '7:00 AM - 8:00 AM', '2026-03-24 09:45:40', 2),
(2, 'Deleted', 'Zone E', 'Biodegradable', 'Saturday', '7:00 AM - 8:00 AM', '2026-03-24 09:50:34', 2),
(3, 'Added', 'Zone B (North District)', 'Non-Biodegradable', 'Thursday', '7:00 AM - 8:00 AM', '2026-03-24 09:51:17', 3),
(4, 'Deleted', 'Zone B (North District)', 'Non-Biodegradable', 'Thursday', '7:00 AM - 8:00 AM', '2026-03-24 09:51:24', 3),
(5, 'Updated', 'Fiesta Community 1', 'Biodegradable', 'Monday & Thursday', '6:00 AM - 10:00 AM', '2026-03-26 04:24:38', 2),
(6, 'Updated', 'Fiesta Community 2', 'Non-Biodegradable', 'Wednesday & Saturday', '2:00 PM - 5:00 PM', '2026-03-26 04:24:59', 2),
(7, 'Updated', 'Doña Adela Phase 1', 'Non-Biodegradable', 'Tuesday & Friday', '6:00 AM - 10:00 AM', '2026-03-26 04:27:04', 2),
(8, 'Updated', 'Señora', 'Biodegradable', 'Tuesday & Friday', '7:00 AM - 11:00 AM', '2026-03-26 04:27:34', 2),
(9, 'Updated', 'Pabalan, Paralaya', 'Non-Biodegradable', 'Monday & Thursday', '7:00 AM - 11:00 AM', '2026-03-26 04:28:02', 2),
(10, 'Updated', 'Emilians', 'Biodegradable', 'Wednesday & Saturday', '6:00 AM - 10:00 AM', '2026-03-26 04:28:14', 2);

-- --------------------------------------------------------

--
-- Table structure for table `trash_schedule`
--

CREATE TABLE `trash_schedule` (
  `id` int NOT NULL,
  `zone` varchar(100) NOT NULL,
  `days` varchar(100) NOT NULL,
  `time` varchar(100) NOT NULL,
  `waste_type` varchar(50) NOT NULL,
  `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `admin_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `trash_schedule`
--

INSERT INTO `trash_schedule` (`id`, `zone`, `days`, `time`, `waste_type`, `last_updated`, `admin_id`) VALUES
(2, 'Fiesta Community 1', 'Monday & Thursday', '6:00 AM - 10:00 AM', 'Biodegradable', '2026-03-26 04:24:38', 2),
(3, 'Doña Adela Phase 1', 'Tuesday & Friday', '6:00 AM - 10:00 AM', 'Non-Biodegradable', '2026-03-26 04:27:04', 2),
(4, 'Pabalan, Paralaya', 'Monday & Thursday', '7:00 AM - 11:00 AM', 'Non-Biodegradable', '2026-03-26 04:28:02', 2),
(5, 'Señora', 'Tuesday & Friday', '7:00 AM - 11:00 AM', 'Biodegradable', '2026-03-26 04:27:34', 2),
(6, 'Emilians', 'Wednesday & Saturday', '6:00 AM - 10:00 AM', 'Biodegradable', '2026-03-26 04:28:14', 2),
(7, 'Fiesta Community 2', 'Wednesday & Saturday', '2:00 PM - 5:00 PM', 'Non-Biodegradable', '2026-03-26 04:24:59', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announ_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `schedule_history`
--
ALTER TABLE `schedule_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trash_schedule`
--
ALTER TABLE `trash_schedule`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announ_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule_history`
--
ALTER TABLE `schedule_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `trash_schedule`
--
ALTER TABLE `trash_schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
