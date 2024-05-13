-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Maio-2024 às 10:06
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `company`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bookmark`
--

CREATE TABLE `bookmark` (
  `bookmark_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user` varchar(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_hour` int(11) NOT NULL,
  `end_hour` int(11) NOT NULL,
  `selected_date` date NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `bookmark`
--

INSERT INTO `bookmark` (`bookmark_id`, `room_id`, `user`, `date`, `start_hour`, `end_hour`, `selected_date`, `active`) VALUES
(1, 1, 'john_doe', '2024-01-02 01:49:18', 9, 11, '2024-03-10', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `buildings`
--

CREATE TABLE `buildings` (
  `building_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `buildings`
--

INSERT INTO `buildings` (`building_id`, `name`, `description`) VALUES
(1, 'Building 1', 'Main building'),
(2, 'Head Office', 'Principal Building');

-- --------------------------------------------------------

--
-- Estrutura da tabela `building_offices`
--

CREATE TABLE `building_offices` (
  `building_id` int(11) NOT NULL,
  `office_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `building_offices`
--

INSERT INTO `building_offices` (`building_id`, `office_id`) VALUES
(1, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `department`
--

CREATE TABLE `department` (
  `id_department` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `department`
--

INSERT INTO `department` (`id_department`, `department`, `role_id`) VALUES
(1, 'IT', 1),
(2, 'HR', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `offices`
--

CREATE TABLE `offices` (
  `office_id` int(11) NOT NULL,
  `office_image` longblob NOT NULL,
  `office_name` varchar(55) NOT NULL,
  `description` text NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `offices`
--

INSERT INTO `offices` (`office_id`, `office_image`, `office_name`, `description`, `room_id`) VALUES
(1, '', 'Office A', 'Main office', 1),
(2, '', 'Office B', 'Secondary office', 1),
(4, '', 'Office C', 'Third office', 1),
(5, '', 'Office D', 'Fourth office', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
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
-- Extraindo dados da tabela `people`
--

INSERT INTO `people` (`id`, `user`, `name`, `date of birth`, `department_id`, `photo`, `password`, `email`, `phone`, `nationality`, `admin`, `password_status`, `active`) VALUES
(1, 'john_doe', 'John Doe', '0000-00-00', 1, NULL, '123', 'john.doe@example.com', '1234567890', '', 1, 0, 0),
(2, 'jane_smith', 'Jane Smith', '0000-00-00', 2, NULL, 'hashed_password', 'jane.smith@example.com', '9876543210', '', 0, 0, 0),
(3, 'DAnastacio', 'Diogo Ferreira Anastácio', '0000-00-00', 1, NULL, '123456789', 'diogo.anastacio.30473@esgc.pt', '962187271', '', 1, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `recover`
--

CREATE TABLE `recover` (
  `id_recover` int(11) NOT NULL,
  `user` varchar(55) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `recover`
--

INSERT INTO `recover` (`id_recover`, `user`, `email`, `phone`, `Description`, `status`) VALUES
(1, 'john_doe', 'john.doe@example.com', '1234567890', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`role_id`, `role`) VALUES
(1, 'Admin'),
(2, 'Employee');

-- --------------------------------------------------------

--
-- Estrutura da tabela `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(55) NOT NULL,
  `space` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `space`, `description`) VALUES
(1, 'Meeting Room 1', 20, 'Conference room for team meetings');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`bookmark_id`),
  ADD KEY `user` (`user`),
  ADD KEY `room_id` (`room_id`);

--
-- Índices para tabela `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`building_id`);

--
-- Índices para tabela `building_offices`
--
ALTER TABLE `building_offices`
  ADD PRIMARY KEY (`building_id`,`office_id`),
  ADD KEY `building_id` (`building_id`),
  ADD KEY `office_id` (`office_id`);

--
-- Índices para tabela `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id_department`),
  ADD KEY `role_id` (`role_id`);

--
-- Índices para tabela `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`office_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Índices para tabela `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`),
  ADD KEY `department_id` (`department_id`);

--
-- Índices para tabela `recover`
--
ALTER TABLE `recover`
  ADD PRIMARY KEY (`id_recover`);

--
-- Índices para tabela `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `role` (`role`);

--
-- Índices para tabela `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `bookmark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `buildings`
--
ALTER TABLE `buildings`
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `department`
--
ALTER TABLE `department`
  MODIFY `id_department` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `offices`
--
ALTER TABLE `offices`
  MODIFY `office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `recover`
--
ALTER TABLE `recover`
  MODIFY `id_recover` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`user`) REFERENCES `people` (`user`);

--
-- Limitadores para a tabela `building_offices`
--
ALTER TABLE `building_offices`
  ADD CONSTRAINT `building_offices_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`),
  ADD CONSTRAINT `building_offices_ibfk_2` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`);

--
-- Limitadores para a tabela `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Limitadores para a tabela `offices`
--
ALTER TABLE `offices`
  ADD CONSTRAINT `offices_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

--
-- Limitadores para a tabela `people`
--
ALTER TABLE `people`
  ADD CONSTRAINT `people_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id_department`);

--
-- Limitadores para a tabela `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `bookmark` (`room_id`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `delete_expired_bookmarks` ON SCHEDULE EVERY 1 DAY STARTS '2024-03-05 15:03:59' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Delete expired bookmarks every day' DO UPDATE bookmark 
    SET active = 0 
    WHERE selected_date < CURDATE() AND end_hour < CURTIME()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
