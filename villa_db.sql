-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 08:34 AM
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
-- Database: `villa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL,
  `villa_id` int(11) DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nama_user` varchar(111) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id_booking`, `villa_id`, `check_in`, `check_out`, `total_harga`, `status`, `created_at`, `nama_user`) VALUES
(13, 3, '2024-12-04', '2024-12-05', 5000000.00, 'pending', '2024-12-04 05:25:17', 'gading'),
(14, 4, '2024-12-06', '2024-12-07', 10000000.00, 'pending', '2024-12-04 05:25:36', 'fajri'),
(15, 5, '2024-12-08', '2024-12-09', 1200000.00, 'pending', '2024-12-04 05:25:59', 'halo');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(3, 'admin', '$2y$10$5YCmhfFF9Nq1ZtU5KugXCuJyzZBdXLLRhshd/T82XqqSLq0gseJJu', 'fajripratamapku767@gmail.com', '2024-11-17 13:59:58'),
(5, 'fajri', '$2y$10$ZxUtY9nN/jHcAIA8fPmSVe.Fq5tz9xGvjtYdVBVcG8DQ/QXTrRM6K', 'dsdsibsi@gmail.com', '2024-12-13 08:34:37');

-- --------------------------------------------------------

--
-- Table structure for table `villas`
--

CREATE TABLE `villas` (
  `id_villa` int(11) NOT NULL,
  `nama_villa` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_per_malam` decimal(10,2) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `kamar_tidur` int(11) DEFAULT NULL,
  `foto_utama` varchar(255) DEFAULT NULL,
  `status` enum('available','booked') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `villas`
--

INSERT INTO `villas` (`id_villa`, `nama_villa`, `deskripsi`, `harga_per_malam`, `kapasitas`, `kamar_tidur`, `foto_utama`, `status`, `created_at`) VALUES
(3, 'ubud', 'pemandangan yang indah', 5000000.00, 2, 2, '../assets/imgvilla1.png', 'available', '2024-11-19 07:27:56'),
(4, 'surya', 'waterppool', 10000000.00, 3, 3, '../assets/img/villa2.jpg', 'available', '2024-11-20 08:05:30'),
(5, 'Kmangi', 'Enjoy You sleep', 1200000.00, 2, 3, '../assets/img/673ec309c40cb_villa4.jpeg', 'available', '2024-11-21 05:20:09'),
(6, 'bocsahdn', 'zxcvxdvxc', 1323243.00, 1, 1, '../assets/img/675be31aaa436_HD-wallpaper-military-soldier-firearm-spetsnaz-russian-special-force.jpg', 'available', '2024-12-13 07:32:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `villas`
--
ALTER TABLE `villas`
  ADD PRIMARY KEY (`id_villa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `villas`
--
ALTER TABLE `villas`
  MODIFY `id_villa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`villa_id`) REFERENCES `villas` (`id_villa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
