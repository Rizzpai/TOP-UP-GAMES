-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2025 at 04:50 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `topup_game`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int NOT NULL,
  `nama_game` varchar(100) NOT NULL,
  `developer` varchar(100) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `nama_game`, `developer`, `gambar`) VALUES
(1, 'Mobile Legends', 'Moonton', 'mobile-legends.jpg'),
(2, 'Free Fire', 'Garena', 'free-fire.jpg'),
(3, 'PUBG Mobile', 'Tencent Games', 'pubg-mobile.jpg'),
(4, 'Genshin Impact', 'miHoYo', 'genshin-impact.jpg'),
(5, 'Valorant', 'Riot Games', 'valorant.jpg'),
(6, 'Mobile Legends', 'Moonton', 'mobile-legends.jpg'),
(7, 'Free Fire', 'Garena', 'free-fire.jpg'),
(8, 'PUBG Mobile', 'Tencent Games', 'pubg-mobile.jpg'),
(9, 'Genshin Impact', 'miHoYo', 'genshin-impact.jpg'),
(10, 'Valorant', 'Riot Games', 'valorant.jpg'),
(11, 'Mobile Legends', 'Moonton', 'mobile-legends.jpg'),
(12, 'Free Fire', 'Garena', 'free-fire.jpg'),
(13, 'PUBG Mobile', 'Tencent Games', 'pubg-mobile.jpg'),
(14, 'Genshin Impact', 'miHoYo', 'genshin-impact.jpg'),
(15, 'Valorant', 'Riot Games', 'valorant.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `game_id` int DEFAULT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `game_id`, `nama_produk`, `harga`, `deskripsi`) VALUES
(1, 1, '86 Diamond', 20000.00, 'Diamond untuk Mobile Legends'),
(2, 1, '172 Diamond', 40000.00, 'Diamond untuk Mobile Legends'),
(3, 1, '344 Diamond', 80000.00, 'Diamond untuk Mobile Legends'),
(4, 2, '50 Diamond', 15000.00, 'Diamond untuk Free Fire'),
(5, 2, '100 Diamond', 30000.00, 'Diamond untuk Free Fire'),
(6, 3, '60 UC', 25000.00, 'UC untuk PUBG Mobile'),
(7, 3, '325 UC', 100000.00, 'UC untuk PUBG Mobile');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `produk_id` int DEFAULT NULL,
  `jumlah` int DEFAULT '1',
  `total_harga` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','success','failed') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `user_id`, `produk_id`, `jumlah`, `total_harga`, `status`, `created_at`) VALUES
(1, 2, 1, 1, 20000.00, 'success', '2025-11-01 20:01:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `saldo` decimal(10,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `saldo`, `created_at`) VALUES
(1, 'testuser', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 100000.00, '2025-11-01 19:45:16'),
(2, 'admin', 'admin@example.com', '$2y$10$BQ5YsRv3E258rshHxX3faev89aTlIqCaBdmfq0imQ0ztM9hUU5agK', 480000.00, '2025-11-01 19:59:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
