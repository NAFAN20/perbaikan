-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2025 at 11:08 AM
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
-- Database: `pelanggaran_siswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis_hukuman`
--

CREATE TABLE `jenis_hukuman` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_hukuman`
--

INSERT INTO `jenis_hukuman` (`id`, `nama`) VALUES
(1, 'Push Up'),
(2, 'Jalan Jongkok'),
(3, 'keliling lapangan\r\n'),
(10, 'jalan kepiting');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id`, `nama`, `email`, `pesan`, `tanggal`) VALUES
(1, 'asdasda', 'asdadsa@gmail.com', 'dkajsda', '2025-03-02 00:15:45'),
(2, 'fajar', 'fajarshiddiq@gmail.com', 'kurang menarik tampilannya ', '2025-03-12 19:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `log_pelanggaran`
--

CREATE TABLE `log_pelanggaran` (
  `id` int(11) NOT NULL,
  `id_pelanggaran` int(11) NOT NULL,
  `aksi` enum('ditambah','diedit','dihapus') NOT NULL,
  `tanggal_aksi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggaran`
--

CREATE TABLE `pelanggaran` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `jenis_pelanggaran` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jenis_hukuman` varchar(255) DEFAULT NULL,
  `id_hukuman` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggaran`
--

INSERT INTO `pelanggaran` (`id`, `id_siswa`, `jenis_pelanggaran`, `tanggal`, `keterangan`, `jenis_hukuman`, `id_hukuman`) VALUES
(9, 1, 'Tawuran', '2025-02-25', NULL, '1', 1),
(10, 12, 'Bolos', '2025-10-20', NULL, '3', 2),
(12, 12, 'bolos', '2025-02-25', NULL, '1', 3),
(13, 12, 'lari', '0025-10-29', NULL, '9', 4),
(14, 12, 'lari', '2007-12-05', NULL, '3', 5),
(15, 14, 'Merokok', '5220-12-05', NULL, '2', 1),
(16, 16, 'Merokok', '2025-04-12', NULL, '10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nis` int(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` enum('10','11','12') NOT NULL,
  `jurusan` enum('RPL 1','RPL 2','AP 1','AP 2','AP 3','AP 4','AK 1','AK 2','AK 3','AK 4','PS 1','PS 2','PS 3','PS 4') NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jurusan`, `jenis_kelamin`) VALUES
(1, 781, 'Senapan', '12', 'PS 4', 'Laki-laki'),
(12, 78234266, 'fajar shiddiq', '11', 'RPL 2', 'Laki-laki'),
(13, 78241714, 'nafan', '10', 'PS 4', 'Laki-laki'),
(14, 712163, 'M Nafan Nabil.N', '12', 'AK 4', 'Laki-laki'),
(16, 71216589, 'Daud', '12', 'AK 4', 'Laki-laki');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','guru') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin12345', 'admin'),
(2, 'guru', 'guru', 'guru123', 'guru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_hukuman`
--
ALTER TABLE `jenis_hukuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_pelanggaran`
--
ALTER TABLE `log_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelanggaran` (`id_pelanggaran`);

--
-- Indexes for table `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
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
-- AUTO_INCREMENT for table `jenis_hukuman`
--
ALTER TABLE `jenis_hukuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `log_pelanggaran`
--
ALTER TABLE `log_pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelanggaran`
--
ALTER TABLE `pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log_pelanggaran`
--
ALTER TABLE `log_pelanggaran`
  ADD CONSTRAINT `log_pelanggaran_ibfk_1` FOREIGN KEY (`id_pelanggaran`) REFERENCES `pelanggaran` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD CONSTRAINT `pelanggaran_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
