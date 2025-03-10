-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 12:24 PM
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
-- Database: `loanmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `klanten`
--

CREATE TABLE `klanten` (
  `klantid` int(11) NOT NULL,
  `klant_naam` varchar(255) NOT NULL,
  `klant_email` varchar(255) NOT NULL,
  `klant_telefoon` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `klant_address` varchar(255) DEFAULT NULL,
  `geboorte_datum` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klanten`
--

INSERT INTO `klanten` (`klantid`, `klant_naam`, `klant_email`, `klant_telefoon`, `created_at`, `klant_address`, `geboorte_datum`) VALUES
(1, 'Jan Jansen', 'jan@example.com', '0612345678', '2025-03-03 23:37:32', NULL, NULL),
(2, 'Petra de Vries', 'petra@example.com', '0687654321', '2025-03-03 23:37:32', NULL, NULL),
(3, 'Mark Bakker', 'mark@example.com', '0655555555', '2025-03-03 23:37:32', NULL, NULL),
(4, 'Anna Pieters', 'anna@example.com', '0611111111', '2025-03-03 23:37:32', NULL, NULL),
(5, 'Sebastian Walker', 'kyjazy@mailinator.com', NULL, '2025-03-03 23:38:00', NULL, NULL),
(22, 'Ryan Bhaggoe', 'ryan@gmail.com', NULL, '2025-03-04 10:43:38', NULL, NULL),
(23, 'ggghj', 'hkhkh@gmail.com', NULL, '2025-03-04 10:51:43', NULL, NULL),
(26, 'Rico Somopawiro', 'Ricosomo@gmail.com', '8884507', '2025-03-05 09:41:35', NULL, NULL),
(27, 'Leonardo Ranoesendjojo', 'lranoesendjojo@gmail.com', '12345678', '2025-03-05 09:44:07', NULL, NULL),
(28, 'Fay Soetoardjo', 'faysoetoardjo@gmail.com', '8667644', '2025-03-10 09:29:52', NULL, NULL),
(29, 'Neal Soempeno', 'nealsoempeno@gmail.com', '8693610', '2025-03-10 11:22:36', 'Nealstraat 1', '2006-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `leningen`
--

CREATE TABLE `leningen` (
  `leningid` int(11) NOT NULL,
  `klantid` int(11) NOT NULL,
  `lening_bedrag` decimal(10,2) NOT NULL,
  `lening_duur` int(11) NOT NULL,
  `rente` decimal(5,2) NOT NULL,
  `lening_status` enum('In behandeling','Goedgekeurd','Afgekeurd','Afgesloten') DEFAULT 'In behandeling',
  `datum_aanvraag` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leningen`
--

INSERT INTO `leningen` (`leningid`, `klantid`, `lening_bedrag`, `lening_duur`, `rente`, `lening_status`, `datum_aanvraag`) VALUES
(2, 2, 10000.00, 36, 3.20, 'Goedgekeurd', '2023-02-10'),
(3, 3, 50000.00, 120, 5.00, 'Goedgekeurd', '2023-03-05'),
(14, 28, 50000.00, 2, 15.00, 'In behandeling', '2025-03-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `klanten`
--
ALTER TABLE `klanten`
  ADD PRIMARY KEY (`klantid`),
  ADD UNIQUE KEY `klant_email` (`klant_email`);

--
-- Indexes for table `leningen`
--
ALTER TABLE `leningen`
  ADD PRIMARY KEY (`leningid`),
  ADD KEY `klantid` (`klantid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klanten`
--
ALTER TABLE `klanten`
  MODIFY `klantid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `leningen`
--
ALTER TABLE `leningen`
  MODIFY `leningid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leningen`
--
ALTER TABLE `leningen`
  ADD CONSTRAINT `leningen_ibfk_1` FOREIGN KEY (`klantid`) REFERENCES `klanten` (`klantid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
