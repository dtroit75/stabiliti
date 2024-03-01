-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2023 at 01:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `username`, `email`, `mobile`, `password`) VALUES
(1, 'Asher Millstone', 'ashermill', 'ashermillstone@gmail.com', '07432999666', 'asher');

-- --------------------------------------------------------

--
-- Table structure for table `comment_list`
--

CREATE TABLE `comment_list` (
  `comment_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE `funds` (
  `id` int(11) NOT NULL,
  `sponsor` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `funds`
--

INSERT INTO `funds` (`id`, `sponsor`, `description`, `category`, `payment_method`, `amount`) VALUES
(2, 'County Government', 'Monthly', '0', 'Stanbic', 2000),
(3, 'United Nation', 'Annually', '1', 'Family Bank', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `mytasks`
--

CREATE TABLE `mytasks` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `application_status` int(11) NOT NULL,
  `completion_status` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mytasks`
--

INSERT INTO `mytasks` (`id`, `task_id`, `user_id`, `application_status`, `completion_status`, `payment_status`) VALUES
(9, 4, 4, 1, 1, 1),
(10, 7, 4, 1, 0, 0),
(11, 4, 6, 1, 0, 0),
(12, 7, 6, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `fullname`, `username`, `email`, `password`) VALUES
(1, 'Michaela Pratt', 'michaela', 'michaelapratt@gmail.com', '$2y$10$ebCd.1gQ.mcs8xXXEiID7OYbpv62kDNwaETRj6ghDOXZiyf6I4Xqu'),
(2, 'Laurel Castillo', 'Laurel', 'castillolaurel@yahoo.com', '$2y$10$gWZZo1dtBlsD5tej1WyiDuRBGNMT9lSZk3kFCpdBlehaapmRRT.Ei');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `report_id` int(11) NOT NULL,
  `taskID` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `disability` varchar(255) NOT NULL,
  `Reward` int(11) NOT NULL,
  `field` varchar(255) NOT NULL,
  `expiry` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`report_id`, `taskID`, `description`, `date_created`, `disability`, `Reward`, `field`, `expiry`) VALUES
(4, 'T5789', 'Remote, 12hrs', '2023-12-06 16:46:31', '0', 30, 'Graphic Design', '2023-12-30'),
(5, 'T78909', 'remote', '2023-12-06 16:46:31', '1', 78, 'Software Development', '2023-12-29'),
(7, 'T443', 'On-site', '2023-12-06 16:46:31', '0', 60, 'Teaching', '2023-12-26'),
(8, 'T678', '24/7 Job', '2023-12-06 16:46:31', '1', 50, 'Graphic Design', '2023-12-30'),
(9, '8', 'Remote, 8hrs/day ', '2023-12-06 16:46:31', '1', 100, 'Graphic Design', '2023-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `task_list`
--

CREATE TABLE `task_list` (
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_report`
--

CREATE TABLE `task_report` (
  `report_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `taskID` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `disability` varchar(255) NOT NULL,
  `Reward` varchar(255) NOT NULL,
  `field` varchar(255) NOT NULL,
  `expiry` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_list`
--

CREATE TABLE `user_list` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `employment` varchar(255) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `field` varchar(255) NOT NULL,
  `education` varchar(255) NOT NULL,
  `disability` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `id_no` int(11) NOT NULL,
  `ncpwd_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_list`
--

INSERT INTO `user_list` (`user_id`, `fullname`, `username`, `password`, `type`, `status`, `date_created`, `email`, `mobile`, `employment`, `job_title`, `field`, `education`, `disability`, `experience`, `id_no`, `ncpwd_no`) VALUES
(6, 'MERCY JEPTEPKENY KIPLAGAT', 'jeptepkeny', '$2y$10$1Zy6RZ9F8DKpCOpr9ua.I.eIj9rOBG7j2b.BXIPBzZkSE668kn/0G', 0, 1, '2023-12-07 10:39:27', 'jeptepkenymercy@gmail.com', '0718909038', 'employed', 'Software Developer', 'Software Development', 'Graduate', '0', '2', 65345678, 'NCPWD4567890J'),
(7, 'MERCY  KIPLAGAT', 'jeptep', '$2y$10$eTekV9LVahOkQ46nqfZCKeGJFiB8KYCRWktAqORA7VO/FSiw/cmvy', 0, 0, '2023-12-07 12:29:08', 'mercymogotio@gmail.com', '0718909038', 'not-employed', 'Security', 'Customer Service', 'Post-Graduate', '0', '3', 2147483647, 'PWD45678');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment_list`
--
ALTER TABLE `comment_list`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mytasks`
--
ALTER TABLE `mytasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned_id` (`assigned_id`);

--
-- Indexes for table `task_report`
--
ALTER TABLE `task_report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `user_list`
--
ALTER TABLE `user_list`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comment_list`
--
ALTER TABLE `comment_list`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mytasks`
--
ALTER TABLE `mytasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_report`
--
ALTER TABLE `task_report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_list`
--
ALTER TABLE `user_list`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment_list`
--
ALTER TABLE `comment_list`
  ADD CONSTRAINT `comment_list_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task_list` (`task_id`);

--
-- Constraints for table `task_list`
--
ALTER TABLE `task_list`
  ADD CONSTRAINT `task_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_list` (`user_id`),
  ADD CONSTRAINT `task_list_ibfk_2` FOREIGN KEY (`assigned_id`) REFERENCES `user_list` (`user_id`);

--
-- Constraints for table `task_report`
--
ALTER TABLE `task_report`
  ADD CONSTRAINT `task_report_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `task_list` (`task_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
