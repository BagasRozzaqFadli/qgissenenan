-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2024 at 06:39 AM
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
-- Database: `dbsenenfood`
--

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `ID_Pengguna` int(11) NOT NULL,
  `Nama_Pengguna` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Tanggal_Bergabung` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`ID_Pengguna`, `Nama_Pengguna`, `Email`, `Password`, `Tanggal_Bergabung`, `role`) VALUES
(3, 'admin', 'admin@senenfood.com', '$2y$10$JB4BTBhTDNBVSyTggwfUhO4RMdK0Zp5ubEMVcddaSciHPo54RV/pe', '2024-12-18 07:42:17', 'admin'),
(4, 'pisang', 'gorengan@gmail.com', '$2y$10$dy8GQsMQTi6QTKfEapjmVO7gcsZWVQm4YLHXzRXd.JanN45XvyFZy', '2024-12-18 07:46:16', 'admin'),
(9, 'gorengan', 'pisang@gmail.com', '$2y$10$qIHUOXvu41ONJsgObtwPAOW6469hEt85mfQnoiuYrQ4J5N6phfKrS', '2024-12-18 07:57:14', 'user'),
(10, 'roti', 'roti@gmail.com', '$2y$10$YXnyRe2nws2IhKojSrcCl.vazIhnE1WKsdFIp2vac/8qAr8nutHPa', '2024-12-18 08:00:14', 'user'),
(11, 'lip', 'lip@gmail.com', '$2y$10$xKxskv/nFk/bwo65PRLtkOEgQbSAjFDaxc1l3MiyJVgpoU80W4jaC', '2024-12-18 08:04:44', 'user'),
(12, 'roti', 'pisangroti@gmail.com', '$2y$10$8Fuws39qkKhJzgpdqGUxG.XeuZWJIf34nRluZJZQ6ZEIbJdRgYjpi', '2024-12-21 05:16:14', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `penjual`
--

CREATE TABLE `penjual` (
  `id` int(11) NOT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kontak` varchar(20) DEFAULT NULL,
  `waktu_buka` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjual`
--

INSERT INTO `penjual` (`id`, `nama_toko`, `alamat`, `latitude`, `longitude`, `deskripsi`, `kontak`, `waktu_buka`, `created_at`, `updated_at`, `kategori`) VALUES
(1, 'rejo cake ', 'JL. KP Jl. Citrosomo, RT.17/RW.06, Senenan, Tahunan, Jepara Regency, Central Java 59426', -6.61247282, 110.69340813, 'toko snack yang memberikan makanan enak', '082313777807', '08:00 - 22:00', '2024-12-20 07:38:26', '2024-12-20 09:50:57', 'Warung Makan'),
(2, 'ARASKAZ Food Corner', '9MQP+WCV, Senenan, Kec. Tahunan, Kabupaten Jepara, Jawa Tengah 59426', -6.61010654, 110.68601491, 'ARAZKAZ Food Corner', '082221242692', '08:00 - 22:00', '2024-12-20 08:12:43', '2024-12-20 09:51:38', 'Warung Makan'),
(3, 'Bakso & Mie Ayam Mas Yanto', '9MQP+WGM, Jl. Citra Soma, Senenan, Kec. Tahunan, Kabupaten Jepara, Jawa Tengah 59426', -6.61015530, 110.68629324, 'Warung Baso dan Mie Ayam yang cukup Khas dan sangat dikenal di Jl. Citra Soma', '', '07:30 - 21.00', '2024-12-20 08:32:45', '2024-12-20 10:16:57', 'Restoran'),
(4, 'bubur seroja', 'Jl. Citrosomo No.005, RT.015 RW, Senenan, Kec. Tahunan, Kabupaten Jepara, Jawa Tengah 59426', -6.61037477, 110.68605351, 'penjual bubur di jalan citra soma', '085328735017', 'Sabtu 07.30-13.00', '2024-12-20 10:00:07', '2024-12-20 10:00:07', 'Warkop'),
(5, 'KV Dgan Jepara', 'Jl. Soekarno Hatta, Senenan, Kec. Tahunan, Kabupaten Jepara, Jawa Tengah 59426', -6.61053897, 110.68495686, 'Kafe di jalan citrosomo', '', '09:00-17:00', '2024-12-20 10:14:44', '2024-12-20 10:14:44', 'Kafe'),
(6, 'Ikan Bakar Dan Ayam Mbak Santi', '9MRM+J6H, Jl. Soekarno Hatta, Senenan, Kec. Tahunan, Kabupaten Jepara, Jawa Tengah 59426', -6.60842966, 110.68310656, 'wes pokoe wenak tenan', '081225644418', '17:00-22.00', '2024-12-21 05:14:31', '2024-12-21 05:14:31', 'Restoran');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`ID_Pengguna`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `penjual`
--
ALTER TABLE `penjual`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `ID_Pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `penjual`
--
ALTER TABLE `penjual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
