-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2024 at 11:46 AM
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
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(45) NOT NULL,
  `penulis` varchar(45) NOT NULL,
  `penerbit` varchar(45) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `cover` blob DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `sinopsis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `cover`, `jumlah`, `sinopsis`) VALUES
(22, 'Hujan', 'tere liye', 'gramedia', '2020', 0x363634303566353637313330665f636f7665722048556a616e2e6a7067, 6, 'Novel ini menceritakan tentang Esok dan Lail sebagai salah satu tokoh utama, keduanya dipertemukan setelah gunung meletus pada tahun 2042. Efek letusan gunung yang dahsyat membuat seisi bumi menyisihkan manusia dan tersisa sekitar 10% manusia.\r\n\r\nEsok yang memiliki nama panjang Soke Bahtera merupakan sosok anak muda yang pintar dan jenius, saat 16 tahun ia berpindah ke ibu kota untuk meneruskan sekolahnya dan ia berhasil membuat mobil terbang untuk pertama kalinya.\r\n\r\nSedangkan Lail sosok wanita sederhana yang tinggal di panti social sebagai relawan kemanusiaan dan mendapatkan pendidikan di sekolah perawat. Ia ternyata memiliki perasaan untuk Esok namun tidak dapat mengungkapkannya.'),
(31, 'Bumi', 'tere liye', 'gramedia', '2020', 0x363636643166323962343764665f62756d692e6a7067, 2, 'buku tere');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `alamat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `nama`, `email`, `no_telp`, `alamat`) VALUES
(8, 'iqbal', 'deisyaja2829@gmail.com', '081287940769', 'wasdwasd'),
(10, 'Tyson', 'iqbalmaulana@gmail.com', '081287940711', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `kode_peminjaman` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `denda` int(20) NOT NULL DEFAULT 0,
  `waktu_peminjaman` timestamp NULL DEFAULT NULL,
  `tenggat_pengembalian` timestamp NULL DEFAULT NULL,
  `waktu_pengembalian` timestamp NULL DEFAULT NULL,
  `status_pengembalian` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`kode_peminjaman`, `id_member`, `id_buku`, `denda`, `waktu_peminjaman`, `tenggat_pengembalian`, `waktu_pengembalian`, `status_pengembalian`) VALUES
(28, 8, 22, 1700000, '2024-05-30 06:23:46', '2024-05-28 06:23:00', '2024-06-14 14:34:25', 1),
(29, 10, 31, 200000, '2024-06-15 04:58:36', '2024-06-13 04:57:00', '2024-06-15 00:04:48', 1),
(30, 8, 22, 0, '2024-06-15 05:03:32', '2024-06-15 05:00:00', '2024-06-15 00:05:16', 1),
(31, 8, 22, 800000, '2024-06-15 05:02:55', '2024-06-07 05:02:00', NULL, 0),
(32, 8, 22, 0, '2024-06-15 05:07:24', '2024-06-16 05:07:00', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gambar` blob NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `gambar`, `level`) VALUES
(1, 'iqbal', 'Milkyway', '$2y$10$D3kV23LNvTD3ihwHmUdOYuVjQUKppKylG9A6tyZEStTcbMtNKpT1G', 0x363634343635646464323433345f697162616c2e6a7067, 1),
(2, 'iqbal', 'iqbal', '$2y$10$WHLNCp40FRmLcRSY/xBROurDNdZtO0PE7quOc0WQujdsNz0Ml1Lpa', 0x363636643232343635623266655f697162616c2e6a7067, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`kode_peminjaman`),
  ADD KEY `peminjaman_to_buku` (`id_buku`),
  ADD KEY `peminjaman_to_member` (`id_member`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `kode_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_to_buku` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id`),
  ADD CONSTRAINT `peminjaman_to_member` FOREIGN KEY (`id_member`) REFERENCES `member` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
