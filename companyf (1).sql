-- --------------------------------------------------------
-- Host:                         rpx.h.filess.io
-- Server version:               10.7.4-MariaDB-1:10.7.4+maria~focal - mariadb.org binary distribution
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for company_exacthair
SET FOREIGN_KEY_CHECKS = 0;

-- Dumping structure for table company_exacthair.bookmark
CREATE TABLE IF NOT EXISTS `bookmark` (
  `bookmark_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `people_id` int(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_hour` time NOT NULL,
  `end_hour` time NOT NULL,
  `selected_date` date NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`bookmark_id`),
  KEY `user` (`people_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `Bookmark_Offices_room_FK_1` FOREIGN KEY (`room_id`) REFERENCES `offices_room` (`room_id`),
  CONSTRAINT `Bookmark_People_FK_2` FOREIGN KEY (`people_id`) REFERENCES `people` (`people_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table company_exacthair.bookmark: ~0 rows (approximately)

-- Dumping structure for table company_exacthair.buildings
CREATE TABLE IF NOT EXISTS `buildings` (
  `building_id` int(11) NOT NULL AUTO_INCREMENT,
  `building_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table company_exacthair.buildings: ~2 rows (approximately)
INSERT INTO `buildings` (`building_id`, `building_name`, `description`) VALUES
	(1, 'Building 1', 'Main building'),
	(2, 'Head Office', 'Principal Building');

-- Dumping structure for table company_exacthair.building_offices
CREATE TABLE IF NOT EXISTS `building_offices` (
  `building_id` int(11) NOT NULL,
  `office_id` int(11) NOT NULL,
  PRIMARY KEY (`building_id`,`office_id`),
  KEY `building_id` (`building_id`),
  KEY `office_id` (`office_id`),
  CONSTRAINT `Building_offices_Building_FK` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`),
  CONSTRAINT `Building_offices_Offices_FK` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table company_exacthair.building_offices: ~3 rows (approximately)
INSERT INTO `building_offices` (`building_id`, `office_id`) VALUES
	(1, 1),
	(1, 2),
	(2, 2);

-- Dumping structure for event company_exacthair.delete_expired_people
DELIMITER //
CREATE DEFINER=`company_exacthair`@`%` EVENT `delete_expired_people` ON SCHEDULE EVERY 1 DAY STARTS '2024-05-22 15:12:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'delete desactive people after 30 days' DO update people 
	SET active = 0
	WHERE desactive_date <= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)//
DELIMITER ;

-- Dumping structure for table company_exacthair.department
CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(75) NOT NULL,
  PRIMARY KEY (`department_id`),
  UNIQUE KEY `department` (`department`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table company_exacthair.department: ~0 rows (approximately)

-- Dumping structure for event company_exacthair.inactive_expired_bookmarks
DELIMITER //
CREATE DEFINER=`company_exacthair`@`%` EVENT `inactive_expired_bookmarks` ON SCHEDULE EVERY 1 DAY STARTS '2024-05-22 13:34:58' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Inactive expired bookmarks every day' DO UPDATE bookmark 
    SET active = 0 
    WHERE selected_date < CURDATE() AND end_hour < CURTIME()//
DELIMITER ;

-- Dumping structure for table company_exacthair.offices
CREATE TABLE IF NOT EXISTS `offices` (
  `office_id` int(11) NOT NULL AUTO_INCREMENT,
  `office_image` longblob NOT NULL,
  `office_name` varchar(55) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`office_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table company_exacthair.offices: ~2 rows (approximately)
INSERT INTO `offices` (`office_id`, `office_image`, `office_name`, `description`) VALUES
	(1, _binary '', 'Office A', 'Main office'),
	(2, _binary '', 'Office B', 'Secondary office');

-- Dumping structure for table company_exacthair.offices_room
CREATE TABLE IF NOT EXISTS `offices_room` (
  `office_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  PRIMARY KEY (`office_id`,`room_id`),
  KEY `office_id` (`office_id`,`room_id`),
  KEY `room_id` (`room_id`),
  CONSTRAINT `Offices_room_Oficces_FK` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`),
  CONSTRAINT `Offices_room_Room_FK` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table company_exacthair.offices_room: ~2 rows (approximately)
INSERT INTO `offices_room` (`office_id`, `room_id`) VALUES
	(1, 1),
	(2, 1);

-- Dumping structure for table company_exacthair.people
CREATE TABLE IF NOT EXISTS `people` (
  `people_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(55) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `role_department_id` int(11) DEFAULT NULL,
  `photo` longblob DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `nationality` varchar(55) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `password_status` tinyint(1) NOT NULL DEFAULT 0,
  `desactive_date` date DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`people_id`),
  UNIQUE KEY `user` (`user`),
  UNIQUE KEY `user_2` (`user`),
  KEY `department_id` (`role_department_id`),
  CONSTRAINT `people_Role_department_FK_1` FOREIGN KEY (`role_department_id`) REFERENCES `roles_department` (`roles_department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table company_exacthair.people: ~2 rows (approximately)
INSERT INTO `people` (`people_id`, `user`, `name`, `date_of_birth`, `role_department_id`, `photo`, `password`, `email`, `phone`, `nationality`, `admin`, `password_status`, `desactive_date`, `active`) VALUES
	(19, 'admintest', ' admin', '2024-05-20', NULL, _binary '', '$2y$10$DCfsxIL.obfLy/CPRdnPjuGOJ7DieQCpOQBVGrx5x4mvMb2q./YXy', 'admin@gmail.com', '1234567890', '0', 1, 0, NULL, 1),
	(22, 'usertest', ' user', '2024-05-20', NULL, _binary '', '$2y$10$AIl5z6lRPGhRioHnc6i4yOh1Psx4H31Qr02J6k2HyuCQu8Gx9TwDi', 'user@gmail.com', '0987654321', '0', 0, 0, NULL, 1);

-- Dumping structure for table company_exacthair.recover
CREATE TABLE IF NOT EXISTS `recover` (
  `recover_id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(55) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`recover_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table company_exacthair.recover: ~1 rows (approximately)
INSERT INTO `recover` (`recover_id`, `user`, `email`, `phone`, `Description`, `status`) VALUES
	(1, 'john_doe', 'john.doe@example.com', '1234567890', '', 0);

-- Dumping structure for table company_exacthair.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(55) NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_2` (`role`),
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table company_exacthair.roles: ~0 rows (approximately)

-- Dumping structure for table company_exacthair.roles_department
CREATE TABLE IF NOT EXISTS `roles_department` (
  `roles_department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`roles_department_id`),
  UNIQUE KEY `department_id` (`department_id`,`role_id`),
  KEY `roles_department_Roles_FK_1` (`role_id`),
  CONSTRAINT `roles_department_Department_FK_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  CONSTRAINT `roles_department_Roles_FK_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table company_exacthair.roles_department: ~0 rows (approximately)

-- Dumping structure for table company_exacthair.room
CREATE TABLE IF NOT EXISTS `room` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(55) NOT NULL,
  `space` int(11) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table company_exacthair.room: ~3 rows (approximately)
INSERT INTO `room` (`room_id`, `room_name`, `space`, `description`) VALUES
	(1, 'Meeting Room 1', 20, 'Conference room for team meetings'),
	(5, 'Meeting Room 2', 30, 'Large conference room'),
	(21, 'meeting', 2, 'sadas');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
