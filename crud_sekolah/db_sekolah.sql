-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2026 at 03:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `judul`, `nama_file`, `keterangan`, `created_at`) VALUES
(1, 'Gedung Sekolah', 'gedung.jpg', 'Gedung utama sekolah', '2026-07-27 22:37:33'),
(2, 'Upacara Bendera', 'upacara.jpg', 'Kegiatan upacara setiap Senin', '2026-07-27 22:37:33'),
(3, 'Laboratorium Komputer', 'lab.jpg', 'Laboratorium komputer', '2026-07-27 22:37:33'),
(4, 'Perpustakaan', 'perpustakaan.jpg', 'Ruang perpustakaan', '2026-07-27 22:37:33'),
(5, 'Kegiatan Belajar', 'kelas.jpg', 'Suasana belajar di kelas', '2026-07-27 22:37:33');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `id_mapel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nip`, `nama`, `jenis_kelamin`, `alamat`, `no_hp`, `id_mapel`) VALUES
(1, '19880001', 'Budi Santoso', 'L', 'Ponorogo', '081234567891', 1),
(2, '19880002', 'Siti Aminah', 'P', 'Ponorogo', '081234567892', 2),
(3, '19880003', 'Andi Pratama', 'L', 'Ponorogo', '081234567893', 3),
(4, '19880004', 'Rina Lestari', 'P', 'Ponorogo', '081234567894', 4),
(5, '19880005', 'Agus Setiawan', 'L', 'Ponorogo', '081234567895', 5),
(6, '19880006', 'Nur Aini', 'P', 'Ponorogo', '081234567896', 6),
(7, '19880007', 'Dedi Saputra', 'L', 'Ponorogo', '081234567897', 7),
(8, '19880008', 'Lilis Handayani', 'P', 'Ponorogo', '081234567898', 8),
(9, '19880009', 'Yusuf Hidayat', 'L', 'Ponorogo', '081234567899', 9),
(10, '19880010', 'Ratna Dewi', 'P', 'Ponorogo', '081234567890', 10);

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id_mapel` int(11) NOT NULL,
  `kode_mapel` varchar(10) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `jam_pelajaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id_mapel`, `kode_mapel`, `nama_mapel`, `jam_pelajaran`) VALUES
(1, 'MTK', 'Matematika', 4),
(2, 'BIN', 'Bahasa Indonesia', 4),
(3, 'BIG', 'Bahasa Inggris', 3),
(4, 'IPA', 'Ilmu Pengetahuan Alam', 4),
(5, 'IPS', 'Ilmu Pengetahuan Sosial', 3),
(6, 'PKN', 'Pendidikan Kewarganegaraan', 2),
(7, 'PAI', 'Pendidikan Agama Islam', 2),
(8, 'SBD', 'Seni Budaya', 2),
(9, 'PJK', 'Pendidikan Jasmani', 2),
(10, 'INF', 'Informatika', 3);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `tahun_ajaran` varchar(9) NOT NULL,
  `nilai_tugas` decimal(5,2) NOT NULL,
  `nilai_uts` decimal(5,2) NOT NULL,
  `nilai_uas` decimal(5,2) NOT NULL,
  `nilai_akhir` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `id_siswa`, `id_mapel`, `semester`, `tahun_ajaran`, `nilai_tugas`, `nilai_uts`, `nilai_uas`, `nilai_akhir`) VALUES
(3, 2, 1, 'Ganjil', '2026/2027', 88.00, 87.00, 90.00, 88.50),
(4, 2, 3, 'Ganjil', '2026/2027', 80.00, 84.00, 86.00, 83.60),
(5, 3, 1, 'Ganjil', '2026/2027', 75.00, 80.00, 82.00, 79.30),
(6, 3, 4, 'Ganjil', '2026/2027', 92.00, 90.00, 94.00, 92.20),
(7, 4, 2, 'Ganjil', '2026/2027', 89.00, 91.00, 90.00, 90.00),
(8, 4, 5, 'Ganjil', '2026/2027', 86.00, 85.00, 88.00, 86.50),
(9, 5, 1, 'Ganjil', '2026/2027', 78.00, 82.00, 80.00, 80.00),
(10, 5, 6, 'Ganjil', '2026/2027', 95.00, 93.00, 96.00, 94.80),
(11, 6, 3, 'Ganjil', '2026/2027', 84.00, 88.00, 90.00, 87.60),
(12, 7, 7, 'Ganjil', '2026/2027', 90.00, 92.00, 94.00, 92.20),
(13, 8, 8, 'Ganjil', '2026/2027', 87.00, 85.00, 89.00, 87.10),
(14, 9, 9, 'Ganjil', '2026/2027', 93.00, 91.00, 95.00, 93.10);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `kelas` varchar(20) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nama`, `jenis_kelamin`, `alamat`, `no_hp`, `kelas`, `tanggal_lahir`) VALUES
(2, '230002', 'Aisyah Putri', 'P', 'Ponorogo', '081111111112', 'X RPL 1', '2008-03-21'),
(3, '230003', 'Bagas Prakoso', 'L', 'Ponorogo', '081111111113', 'X RPL 1', '2008-05-17'),
(4, '230004', 'Citra Lestari', 'P', 'Ponorogo', '081111111114', 'X RPL 1', '2008-08-01'),
(5, '230005', 'Dimas Saputra', 'L', 'Ponorogo', '081111111115', 'X RPL 2', '2008-02-10'),
(6, '230006', 'Erika Putri', 'P', 'Ponorogo', '081111111116', 'X RPL 2', '2008-09-09'),
(7, '230007', 'Fajar Nugroho', 'L', 'Ponorogo', '081111111117', 'XI RPL 1', '2007-04-25'),
(8, '230008', 'Gita Maharani', 'P', 'Ponorogo', '081111111118', 'XI RPL 1', '2007-06-30'),
(9, '230009', 'Hendra Wijaya', 'L', 'Ponorogo', '081111111119', 'XI RPL 2', '2007-11-14');

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
(1, 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `fk_guru_mapel` (`id_mapel`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id_mapel`),
  ADD UNIQUE KEY `kode_mapel` (`kode_mapel`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `fk_nilai_siswa` (`id_siswa`),
  ADD KEY `fk_nilai_mapel` (`id_mapel`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nis` (`nis`);

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
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `fk_guru_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id_mapel`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `fk_nilai_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mata_pelajaran` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nilai_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
