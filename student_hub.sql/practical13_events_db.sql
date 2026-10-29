-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2026 at 02:48 PM
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
-- Database: `practical13_events_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `event_date` date NOT NULL,
  `venue` varchar(150) NOT NULL,
  `category` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `event_date`, `venue`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Hackathon 2026', '2026-10-07', 'CSPIT Auditorium', 'Hackathon', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(2, 'Web Development Workshop', '2026-10-12', 'A7 Building', 'Workshop', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(3, 'Sports Meet 2026', '2026-10-15', 'University Ground', 'Sports', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(4, 'AI and Machine Learning Seminar', '2026-10-18', 'CSPIT Seminar Hall', 'Seminar', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(5, 'Cyber Security Awareness', '2026-10-20', 'A3 Building', 'Seminar', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(6, 'Coding Contest', '2026-10-22', 'Computer Lab 3', 'Competition', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(7, 'C++ Programming Workshop', '2026-10-25', 'Computer Lab 1', 'Workshop', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(8, 'Entrepreneurship Talk', '2026-10-27', 'Main Auditorium', 'Seminar', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(9, 'Photography Competition', '2026-10-29', 'Student Activity Center', 'Competition', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(10, 'Tech Quiz', '2026-11-02', 'A5 Building', 'Competition', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(11, 'Cloud Computing Workshop', '2026-11-05', 'Computer Lab 2', 'Workshop', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(12, 'Annual Cultural Fest', '2026-11-10', 'University Ground', 'Cultural', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(13, 'Cyber Security Hackathon', '2026-11-15', 'CSPIT Auditorium', 'Hackathon', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(14, 'Career Guidance Session', '2026-11-18', 'Seminar Hall', 'Career', '2026-10-24 13:45:19', '2026-10-24 13:45:19'),
(15, 'Git and GitHub Workshop', '2026-11-22', 'Computer Lab 4', 'Workshop', '2026-10-24 13:45:19', '2026-10-24 13:45:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_events_date` (`event_date`),
  ADD KEY `idx_events_category` (`category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
