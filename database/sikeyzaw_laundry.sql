-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2026 at 01:18 PM
-- Server version: 10.6.23-MariaDB-cll-lve
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sikeyzaw_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` char(5) NOT NULL,
  `id_pesanan` char(5) NOT NULL,
  `id_layanan` char(5) NOT NULL,
  `berat_kg` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_layanan`, `berat_kg`) VALUES
('DT001', 'PS001', 'LY001', 5.3),
('DT002', 'PS002', 'LY002', 4.5),
('DT003', 'PS003', 'LY003', 7.7),
('DT004', 'PS004', 'LY002', 6.5),
('DT005', 'PS005', 'LY001', 9.8),
('DT006', 'PS006', 'LY002', 6.8),
('DT007', 'PS007', 'LY001', 11.5),
('DT008', 'PS008', 'LY003', 9.8),
('DT009', 'PS009', 'LY001', 5.5);

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` char(5) NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `harga_per_kg` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `nama_layanan`, `harga_per_kg`) VALUES
('LY001', 'Cuci Pakaian', '10000'),
('LY002', 'Setrika', '7000'),
('LY003', 'Express Laundry', '15000');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` char(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `no_telp`, `email`, `alamat`) VALUES
('PL001', 'Pelanggan 1', '0853555291', '2406007@itg.ac.id', 'Sindangsari'),
('PL002', 'Pelanggan 2', '0853555542', 'keyzakyy.dev@gmail.com', 'Montong'),
('PL003', 'Pelanggan 3', '0853555354', 'dzaky@gmail.com', 'Lopi'),
('PL004', 'Pelanggan 4', '0853555215', '2406007@itg.ac.id', 'Lauki'),
('PL005', 'Pelanggan 5', '0853553254', '2406000@itg.ac.id', 'Lautan Api'),
('PL006', 'Pelanggan 6', '0853523654', 'polo@gmail.com', 'Kp. Liam'),
('PL007', 'Pelanggan 7', '0853555124', '52165@gmail.com', 'Kp. Lufi'),
('PL008', 'Pelanggan 8', '085172165245', '2406000@itg.ac.id', 'Sindang');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` char(5) NOT NULL,
  `id_pelanggan` char(5) NOT NULL,
  `tanggal_pesanan` varchar(20) NOT NULL,
  `status_pesanan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_pelanggan`, `tanggal_pesanan`, `status_pesanan`) VALUES
('PS001', 'PL001', '2026-06-17', 'Selesai'),
('PS002', 'PL002', '2026-06-16', 'Selesai'),
('PS003', 'PL003', '2026-06-17', 'Diproses'),
('PS004', 'PL004', '2026-06-08', 'Selesai'),
('PS005', 'PL005', '2026-06-15', 'Selesai'),
('PS006', 'PL006', '2026-06-14', 'Selesai'),
('PS007', 'PL007', '2026-06-17', 'Diproses'),
('PS008', 'PL008', '2026-06-17', 'Diproses'),
('PS009', 'PL008', '2026-06-17', 'Diproses');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
