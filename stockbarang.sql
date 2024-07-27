-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 27, 2024 at 04:05 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockbarang`
--

-- --------------------------------------------------------

--
-- Table structure for table `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int NOT NULL,
  `idbarang` int DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `penerima` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `qty` int NOT NULL,
  `notification` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `keluar`
--

INSERT INTO `keluar` (`idkeluar`, `idbarang`, `tanggal`, `penerima`, `qty`, `notification`) VALUES
(19, 10, '2024-07-17 15:17:56', 'kopet', 4, 1),
(20, 10, '2024-07-17 15:18:01', 'kopettt', 5, 1),
(21, 10, '2024-07-17 15:18:06', 'kopet', 2, 1),
(22, 10, '2024-07-17 15:18:11', 'kopet', 6, 1),
(23, 10, '2024-07-17 15:18:15', 'kopet', 6, 1),
(24, 10, '2024-07-18 07:11:40', 'kopet', 5, 1),
(25, 10, '2024-07-18 07:14:11', 'kopet', 4, 1),
(26, 10, '2024-07-18 07:14:17', 'kopet', 6, 1),
(27, 10, '2024-07-18 07:14:36', 'kopet', 4, 1),
(28, 10, '2024-07-18 07:18:46', 'kopet', 3, 1),
(29, 10, '2024-07-18 07:33:13', 'kopet', 4, 1),
(30, 10, '2024-07-20 07:27:17', 'mamen', 30, 1),
(31, 10, '2024-07-24 04:25:05', 'ttj', 6, 1),
(32, 10, '2024-07-24 11:54:12', 'mamen', 232, 1),
(33, 10, '2024-07-25 15:39:12', 'mamen24', 50, 0);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `iduser` int NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `last_activity` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_online` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`iduser`, `email`, `password`, `role`, `last_activity`, `is_online`) VALUES
(1, 'admin@gmail.com', '1234', 'admin', '2024-07-23 15:26:32', 1),
(2, 'barangmasuk@gmail.com', '1234', 'karyawan_barang_masuk', '2024-07-23 15:22:43', 0),
(3, 'barangkeluar@gmail.com', '1234', 'karyawan_barang_keluar', '2024-07-23 14:55:19', 0),
(4, 'stockbarang@gmail.com', '1234', 'karyawan_stock_barang', '2024-07-23 14:55:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int NOT NULL,
  `idbarang` int DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pengirim` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `qty` int NOT NULL,
  `notification` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `masuk`
--

INSERT INTO `masuk` (`idmasuk`, `idbarang`, `tanggal`, `pengirim`, `qty`, `notification`) VALUES
(12, 10, '2024-07-16 20:12:17', 'mamen', 100, 1),
(13, 10, '2024-07-17 16:33:32', 'kopet', 50, 1),
(14, 10, '2024-07-17 16:33:35', 'kopet', 2, 1),
(15, 10, '2024-07-17 16:33:46', 'kopet', 5, 1),
(16, 10, '2024-07-17 16:33:51', 'kopet', 52, 1),
(17, 12, '2024-07-17 16:33:55', 'kopet', 4, 1),
(18, 10, '2024-07-18 07:10:53', 'sdasd', 5, 1),
(19, 10, '2024-07-18 07:15:57', 'kopet', 6, 1),
(20, 10, '2024-07-18 07:30:10', 'kopet', 5, 1),
(21, 11, '2024-07-24 03:43:10', 'moamen', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `idbarang` int NOT NULL,
  `namabarang` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `deskripsi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `stock` int NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`idbarang`, `namabarang`, `deskripsi`, `stock`, `deleted`) VALUES
(10, 'Martabak Coklat Susu', 'Ini adalah Super Kopet yang Wahhhh', 50, 0),
(11, 'Kopet Supersdsd2eweqe', 'Ini adalah Super Kopet yang Wahhhhhhh', 55, 0),
(12, 'Martabak Coklat Susuuuuuu', 'Ini adalah Super Kopet yang Wahhhhhhh', 19, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`),
  ADD KEY `idbarang` (`idbarang`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`),
  ADD KEY `idbarang` (`idbarang`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `iduser` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keluar`
--
ALTER TABLE `keluar`
  ADD CONSTRAINT `keluar_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `stock` (`idbarang`);

--
-- Constraints for table `masuk`
--
ALTER TABLE `masuk`
  ADD CONSTRAINT `masuk_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `stock` (`idbarang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
