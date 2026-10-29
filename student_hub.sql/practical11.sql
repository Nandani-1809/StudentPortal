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
-- Database: `practical11`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `enrollment` varchar(30) NOT NULL,
  `email` varchar(150) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(30) DEFAULT NULL,
  `course` varchar(100) NOT NULL,
  `year` tinyint(3) UNSIGNED NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name`, `enrollment`, `email`, `dob`, `gender`, `course`, `year`, `status`, `created_at`) VALUES
(1, 'Aarav', 'Shah', 'P11CS001', 'aarav.shah01@example.com', '2006-01-14', 'Male', 'Computer Science', 2, 'active', '2026-10-17 09:29:11'),
(2, 'Asha', 'Patel', 'P11CS002', 'asha.patel02@example.com', '2005-08-22', 'Female', 'Computer Science', 2, 'active', '2026-10-17 09:29:11'),
(3, 'Vivaan', 'Mehta', 'P11IT003', 'vivaan.mehta03@example.com', '2006-03-10', 'Male', 'Information Technology', 1, 'active', '2026-10-17 09:29:11'),
(4, 'Diya', 'Desai', 'P11CE004', 'diya.desai04@example.com', '2005-12-01', 'Female', 'Computer Engineering', 2, 'active', '2026-10-17 09:29:11'),
(5, 'Arjun', 'Trivedi', 'P11ME005', 'arjun.trivedi05@example.com', '2004-09-18', 'Male', 'Mechanical Engineering', 3, 'active', '2026-10-17 09:29:11'),
(6, 'Anaya', 'Joshi', 'P11EE006', 'anaya.joshi06@example.com', '2005-05-16', 'Female', 'Electrical Engineering', 2, 'active', '2026-10-17 09:29:11'),
(7, 'Reyansh', 'Dave', 'P11CS007', 'reyansh.dave07@example.com', '2006-02-07', 'Male', 'Computer Science', 1, 'active', '2026-10-17 09:29:11'),
(8, 'Ira', 'Pandya', 'P11IT008', 'ira.pandya08@example.com', '2005-11-28', 'Female', 'Information Technology', 2, 'active', '2026-10-17 09:29:11'),
(9, 'Kabir', 'Rao', 'P11CE009', 'kabir.rao09@example.com', '2004-07-19', 'Male', 'Computer Engineering', 3, 'active', '2026-10-17 09:29:11'),
(10, 'Myra', 'Kapoor', 'P11ME010', 'myra.kapoor10@example.com', '2006-04-25', 'Female', 'Mechanical Engineering', 1, 'active', '2026-10-17 09:29:11'),
(11, 'Advik', 'Nair', 'P11EE011', 'advik.nair11@example.com', '2005-06-30', 'Male', 'Electrical Engineering', 2, 'active', '2026-10-17 09:29:11'),
(12, 'Sara', 'Mistry', 'P11CS012', 'sara.mistry12@example.com', '2004-10-11', 'Female', 'Computer Science', 3, 'active', '2026-10-17 09:29:11'),
(13, 'Krish', 'Solanki', 'P11IT013', 'krish.solanki13@example.com', '2006-01-09', 'Male', 'Information Technology', 1, 'active', '2026-10-17 09:29:11'),
(14, 'Kiara', 'Bhatt', 'P11CE014', 'kiara.bhatt14@example.com', '2005-02-20', 'Female', 'Computer Engineering', 2, 'active', '2026-10-17 09:29:11'),
(15, 'Dhruv', 'Gandhi', 'P11ME015', 'dhruv.gandhi15@example.com', '2004-12-15', 'Male', 'Mechanical Engineering', 3, 'active', '2026-10-17 09:29:11'),
(16, 'Navya', 'Thakkar', 'P11EE016', 'navya.thakkar16@example.com', '2006-07-06', 'Female', 'Electrical Engineering', 1, 'active', '2026-10-17 09:29:11'),
(17, 'Rudra', 'Parekh', 'P11CS017', 'rudra.parekh17@example.com', '2005-04-02', 'Male', 'Computer Science', 2, 'active', '2026-10-17 09:29:11'),
(18, 'Pari', 'Shukla', 'P11IT018', 'pari.shukla18@example.com', '2004-08-13', 'Female', 'Information Technology', 3, 'active', '2026-10-17 09:29:11'),
(19, 'Yuvaan', 'Soni', 'P11CE019', 'yuvaan.soni19@example.com', '2006-09-21', 'Male', 'Computer Engineering', 1, 'active', '2026-10-17 09:29:11'),
(20, 'Saanvi', 'Pathak', 'P11CS020', 'saanvi.pathak20@example.com', '2005-03-27', 'Female', 'Computer Science', 2, 'active', '2026-10-17 09:29:11'),
(21, 'Nandani', 'Patel', '26cs009', 'nandanipatel1312@gmail.com', '2006-11-13', 'Female', 'Computer Engineering', 2, 'active', '2026-10-17 14:31:05'),
(22, 'Aarav', 'Parekh', '240018', 'aaravparekh11@gmail.com', '2004-12-13', 'Male', 'Electrical Engineering', 3, 'inactive', '2026-10-17 15:35:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollment` (`enrollment`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
