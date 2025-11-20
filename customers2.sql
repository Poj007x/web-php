-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2025 at 11:26 AM
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
-- Database: `cns68-2`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers2`
--

CREATE TABLE `customers2` (
  `custid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `status` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers2`
--

INSERT INTO `customers2` (`custid`, `username`, `password`, `fullname`, `phone`, `status`) VALUES
(1, 'john123', 'pass1234', 'Johnathan Miller', '0912345678', 'user'),
(2, 'mai_chan', 'abc98765', 'Mai Chanwong', '0898765432', 'user'),
(3, 'tony_dev', 'devpass22', 'Tony Davidson', '0821122334', 'user'),
(4, 'somchai99', '12345abcde', 'Somchai Rattanakul', '0954433221', 'user'),
(5, 'lilyrose', 'rose2025', 'Lily Rosetta', '0815556677', 'user'),
(6, 'john', '$2y$10$8GDPzcTKIl2mw', 'jane jane', '', 'user'),
(8, 'jdoe', '$2y$10$mvxMWP5gDiYOU', 'poj aaassdd', '', 'user'),
(9, 'banthat', '$2y$10$I9Y53jzJeSG3x', 'adadad', '', 'user'),
(10, '68319080024', '$2y$10$Jqg.sosj0LjoZ', 'po', '', 'user'),
(11, 'asdasdasd', '$2y$10$jQv8gZAK9EbKW', 'asdasdasd', '', 'user'),
(12, 'fasdqw', '$2y$10$E5EIaXg.EwkVrepM4Htn2.4VEeTcUkp2cnzSjOzbseCsO1JDDdn5K', 'fasdqw', '', 'user'),
(13, 'admin', '$2y$10$SrOi.d6iX/EjjAwV1uxonu/iQ17SaR2ams8C2hzN87G95QAGwl7Sq', 'Administrator', '0000000000', 'admin'),
(14, 'exampleuser', '$2y$10$YjhqIBcq94yLvqrSNHjdo.NOE5XAGGlkt7GXUDgMxGhxvZzrNHP3K', 'John Doe', '09123456789', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers2`
--
ALTER TABLE `customers2`
  ADD PRIMARY KEY (`custid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers2`
--
ALTER TABLE `customers2`
  MODIFY `custid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
