-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2025 at 12:40 AM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klanten`
--

INSERT INTO `klanten` (`klantid`, `klant_naam`, `klant_email`, `klant_telefoon`, `created_at`) VALUES
(1, 'Jan Jansen', 'jan@example.com', '0612345678', '2025-03-03 23:37:32'),
(2, 'Petra de Vries', 'petra@example.com', '0687654321', '2025-03-03 23:37:32'),
(3, 'Mark Bakker', 'mark@example.com', '0655555555', '2025-03-03 23:37:32'),
(4, 'Anna Pieters', 'anna@example.com', '0611111111', '2025-03-03 23:37:32'),
(5, 'Sebastian Walker', 'kyjazy@mailinator.com', NULL, '2025-03-03 23:38:00');

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
(1, 1, 25000.00, 60, 4.50, 'In behandeling', '2023-01-15'),
(2, 2, 10000.00, 36, 3.20, 'Goedgekeurd', '2023-02-10'),
(3, 3, 50000.00, 120, 5.00, 'Afgekeurd', '2023-03-05'),
(4, 4, 15000.00, 48, 4.00, 'Afgesloten', '2023-04-20'),
(5, 5, 412.00, 409, 32.00, 'In behandeling', '2025-03-03');

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
  MODIFY `klantid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leningen`
--
ALTER TABLE `leningen`
  MODIFY `leningid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
