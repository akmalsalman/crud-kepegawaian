-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2025 at 08:04 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kepegawaian`
--

-- --------------------------------------------------------

--
-- Table structure for table `departemen`
--

CREATE TABLE `departemen` (
  `id` int(11) NOT NULL,
  `nama_departemen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departemen`
--

INSERT INTO `departemen` (`id`, `nama_departemen`) VALUES
(8, ' Layanan Mahasiswa'),
(3, 'Akademik'),
(9, 'Kesehatan dan Keselamatan'),
(5, 'Keuangan'),
(6, 'Pemasaran dan Hubungan Masyarakat'),
(10, 'Penelitian dan Pengembangan'),
(4, 'Sumber Daya Manusia'),
(7, 'Teknologi Informasi');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `gaji` decimal(10,2) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `jabatan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nama`, `jabatan`, `gaji`, `alamat`, `email`, `jenis_kelamin`, `jabatan_id`) VALUES
(1, 'Salman Hamza', 'Dosen', '3500000.00', 'Jl. Nihmat No. 17,  RT 01 RW 06,Desa Cigugur Girang, Kecamatan Pasir Baru, Kabupaten. Bandung Barat', 'salmanhamza@gmail.com', 'L', 0),
(3, 'Gaby Azra', 'Dosen', '3000000.00', 'Jl.Kamari No.81, RT 03 RW 07 Kelurahan Ujung Barung, Kecamatan Cisarua, Bandung', 'gabyazra@gmail.com', 'P', 0),
(7, 'Hadim Ramdan', 'Dosen', '3000000.00', 'Jl. Padang No.55, RT 02 RW 07, Kelurahan Ciamas, Kota Bandung', 'hadimramdan@gmail.com', 'L', 0),
(8, 'Ayu Lestari', 'Manajer Keuangan', '4000000.00', 'Jl. Padasuka No.09, RT 03 RW 06, Desa Sangkar, Kecamatan Gorong, Kabupaten Bandung Barat', 'ayulestari@gmail.com', 'P', 0),
(9, 'Samsul Jaiz', 'Akuntan', '6000000.00', 'Jl. Mekar Asih No.14, RT 04 RW 01, Desa Ciabu, Kecamatan Gorong, Kabupaten Bandung Barat', 'samsuljaiz@gmail.com', 'L', 0),
(10, 'Andin Wahidar', 'IT Manager', '5000000.00', 'Jl. Cijerah No.13, RT 03 RW 05, Desa Dakar, Kecamatan Gorong, Kabupaten Bandung Barat', 'andinwahidar@gmail.com', 'P', 0),
(11, 'Rama Fauzi', 'Staf Pemasaran', '2500000.00', 'Jl. Gegerkalong Girang No.17, RT 05 RW 08, Kelurahan Sukasari, Kota Bandung', 'ramafauzi@gmail.com', 'L', 0),
(12, 'Nabila Zahra', 'Marketing Manager', '4000000.00', 'Jl. Harum No.16, RT 04 RW 04, Kelurahan Banjar Raya, Kota Bandung', 'nabilazahra@gmail.com', 'P', 0),
(13, 'Salsa Afra', 'Dekan', '4000000.00', 'Jl. Raya Badung No. 55, RT 01 RW 02, Kelurahan Ciberem, Kota Medan', 'salsaafra@gmail.com', 'P', 0),
(14, 'Wahidan Reya', 'Staf Pemasaran', '3000000.00', 'Jl. Samaru No. 12, RT 04 RW 02, Kelurahan Badung, Kota Bandung', 'wahidanreya@gmail.com', 'L', 0),
(15, 'Jaki Arya Muttaqin', 'Kepala SDM', '5000000.00', 'Jl. Giri Indah No.16, RT 02 RW 06, Kecamatan Parongpong, Kabupaten Bojong Bager, Bandung Barat', 'jakiarya@gmail.com', 'L', 0),
(16, 'Damar Azra', 'Dosen', '4000000.00', 'Jl. Hamura No.01, RT 01 RW 01, Kelurahan Raya, Kota Bandung ', 'damarazra@gmail.com', 'L', 0),
(17, 'Fran Deka', 'Staf Kesehatan ', '3000000.00', 'Jl. Kiri No.20, RT 03 RW 03, Kelurahan Cibiru, Kota Bandung', 'frandeka@gmail.com', 'P', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_departemen`
--

CREATE TABLE `pegawai_departemen` (
  `id` int(11) NOT NULL,
  `pegawai_id` int(11) NOT NULL,
  `departemen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(71, 'admin', '$2y$10$p.RgL9Jl1N6RHC7G5CbYy.padm/XsqssUFIvzIso2YZtx/0PqV1Y2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departemen`
--
ALTER TABLE `departemen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_departemen` (`nama_departemen`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pegawai_departemen`
--
ALTER TABLE `pegawai_departemen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_id` (`pegawai_id`),
  ADD KEY `departemen_id` (`departemen_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departemen`
--
ALTER TABLE `departemen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pegawai_departemen`
--
ALTER TABLE `pegawai_departemen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pegawai_departemen`
--
ALTER TABLE `pegawai_departemen`
  ADD CONSTRAINT `pegawai_departemen_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pegawai_departemen_ibfk_2` FOREIGN KEY (`departemen_id`) REFERENCES `departemen` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
