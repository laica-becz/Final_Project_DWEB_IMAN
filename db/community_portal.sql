-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 22, 2026 at 12:39 PM
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
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `email`, `full_name`, `role`, `created_at`) VALUES
(0, 'admin1', '$2y$10$8K1p/a0dR1xqM4MCi5nyrejAECXvzNRCGFHoJEAhOkkVQjkGGCXoS', 'admin1@barangay.gov', 'Administrator One', 'admin', '2026-03-22 12:37:39'),
(0, 'admin2', '$2y$10$3O2qN5vZ4mX1pB8kYjdRweWz1LMqT5nK9hF6sJcPxDyGvIuQaELGy', 'admin2@barangay.gov', 'Administrator Two', 'admin', '2026-03-22 12:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announ_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `priority` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `admin_id` int DEFAULT NULL
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
  `report_id` int NOT NULL,
  `report_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_tag` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `admin_note` text COLLATE utf8mb4_unicode_ci,
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
  `id` int NOT NULL,
  `action` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `zone` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `waste_type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `days` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `acted_at` datetime NOT NULL,
  `admin_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trash_schedule`
--

CREATE TABLE `trash_schedule` (
  `id` int NOT NULL,
  `zone` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `days` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `time` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `waste_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `admin_id` int DEFAULT NULL
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
