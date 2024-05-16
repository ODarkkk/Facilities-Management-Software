-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 11:40 AM
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
-- Database: `company`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `bookmark_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `people_id` int(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_hour` time NOT NULL,
  `end_hour` time NOT NULL,
  `selected_date` date NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`bookmark_id`, `room_id`, `people_id`, `date`, `start_hour`, `end_hour`, `selected_date`, `active`) VALUES
(6, 1, 3, '2024-06-13 23:00:00', '00:00:00', '00:00:00', '2024-06-14', 0),
(7, 1, 3, '2024-05-06 23:00:00', '00:00:00', '00:00:00', '2024-05-07', 0),
(8, 1, 3, '2024-05-06 23:00:00', '00:00:00', '00:00:00', '2024-05-07', 0),
(9, 1, 3, '2024-05-05 23:00:00', '00:00:00', '00:00:00', '2024-05-06', 1),
(10, 1, 3, '2024-05-05 23:00:00', '00:00:00', '00:00:00', '2024-05-06', 1),
(11, 1, 3, '2024-05-06 13:57:13', '14:47:00', '14:50:00', '2024-05-06', 1),
(12, 1, 3, '2024-05-06 13:57:51', '17:57:00', '19:57:00', '2024-05-06', 1),
(13, 1, 3, '2024-05-06 13:58:11', '16:58:00', '18:58:00', '2024-05-06', 1),
(14, 1, 3, '2024-05-06 14:18:32', '15:18:00', '15:19:00', '2024-05-06', 1),
(15, 1, 3, '2024-05-06 14:21:02', '16:20:00', '18:20:00', '2024-05-06', 1),
(16, 1, 3, '2024-05-06 14:21:17', '21:21:00', '22:21:00', '2024-05-06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `building_id` int(11) NOT NULL,
  `building_name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`building_id`, `building_name`, `description`) VALUES
(1, 'Building 1', 'Main building'),
(2, 'Head Office', 'Principal Building');

-- --------------------------------------------------------

--
-- Table structure for table `building_offices`
--

CREATE TABLE `building_offices` (
  `building_id` int(11) NOT NULL,
  `office_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `building_offices`
--

INSERT INTO `building_offices` (`building_id`, `office_id`) VALUES
(1, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department`) VALUES
(1, 'IT'),
(2, 'HR');

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `office_id` int(11) NOT NULL,
  `office_image` longblob NOT NULL,
  `office_name` varchar(55) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`office_id`, `office_image`, `office_name`, `description`) VALUES
(1, '', 'Office A', 'Main office'),
(2, '', 'Office B', 'Secondary office');

-- --------------------------------------------------------

--
-- Table structure for table `offices_room`
--

CREATE TABLE `offices_room` (
  `office_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices_room`
--

INSERT INTO `offices_room` (`office_id`, `room_id`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `people_id` int(11) NOT NULL,
  `user` varchar(55) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date of birth` date NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `photo` longblob DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `nationality` varchar(55) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `password_status` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`people_id`, `user`, `name`, `date of birth`, `department_id`, `photo`, `password`, `email`, `phone`, `nationality`, `admin`, `password_status`, `active`) VALUES
(3, 'DAnastacio', 'Diogo Ferreira Anastácio', '0000-00-00', 1, NULL, '123456789', 'diogo.anastacio.30473@esgc.pt', '962187271', '', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `recover`
--

CREATE TABLE `recover` (
  `recover_id` int(11) NOT NULL,
  `user` varchar(55) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recover`
--

INSERT INTO `recover` (`recover_id`, `user`, `email`, `phone`, `Description`, `status`) VALUES
(1, 'john_doe', 'john.doe@example.com', '1234567890', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role`) VALUES
(1, 'Admin'),
(2, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `roles_department`
--

CREATE TABLE `roles_department` (
  `department_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles_department`
--

INSERT INTO `roles_department` (`department_id`, `role_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(55) NOT NULL,
  `space` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `space`, `description`) VALUES
(1, 'Meeting Room 1', 20, 'Conference room for team meetings'),
(5, 'Meeting Room 2', 30, 'Large conference room');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`bookmark_id`),
  ADD KEY `user` (`people_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`building_id`);

--
-- Indexes for table `building_offices`
--
ALTER TABLE `building_offices`
  ADD PRIMARY KEY (`building_id`,`office_id`),
  ADD KEY `building_id` (`building_id`),
  ADD KEY `office_id` (`office_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`office_id`);

--
-- Indexes for table `offices_room`
--
ALTER TABLE `offices_room`
  ADD PRIMARY KEY (`office_id`,`room_id`),
  ADD KEY `office_id` (`office_id`,`room_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`people_id`),
  ADD UNIQUE KEY `user` (`user`),
  ADD UNIQUE KEY `user_2` (`user`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `recover`
--
ALTER TABLE `recover`
  ADD PRIMARY KEY (`recover_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `roles_department`
--
ALTER TABLE `roles_department`
  ADD PRIMARY KEY (`department_id`,`role_id`),
  ADD KEY `department_id` (`department_id`,`role_id`),
  ADD KEY `roles_department_roles__FK_1` (`role_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `bookmark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `people_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `recover`
--
ALTER TABLE `recover`
  MODIFY `recover_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `Bookmark_Offices_room_FK` FOREIGN KEY (`room_id`) REFERENCES `offices_room` (`room_id`),
  ADD CONSTRAINT `Bookmark_People_FK` FOREIGN KEY (`people_id`) REFERENCES `people` (`people_id`);

--
-- Constraints for table `building_offices`
--
ALTER TABLE `building_offices`
  ADD CONSTRAINT `Building_offices_Building_FK` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`),
  ADD CONSTRAINT `Building_offices_Offices_FK` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`);

--
-- Constraints for table `offices_room`
--
ALTER TABLE `offices_room`
  ADD CONSTRAINT `Offices_room_Oficces_FK` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`),
  ADD CONSTRAINT `Offices_room_Room_FK` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

--
-- Constraints for table `people`
--
ALTER TABLE `people`
  ADD CONSTRAINT `people_department_FK_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `roles_department`
--
ALTER TABLE `roles_department`
  ADD CONSTRAINT `roles_department_department__FK_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `roles_department_roles__FK_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`company_exacthair`@`rpx.h.filess.io` EVENT `inactive_expired_bookmarks` ON SCHEDULE EVERY 1 DAY STARTS '2024-03-05 15:03:59' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Inactive expired bookmarks every day' DO UPDATE bookmark 
    SET active = 0 
    WHERE selected_date < CURDATE() AND end_hour < CURTIME()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
