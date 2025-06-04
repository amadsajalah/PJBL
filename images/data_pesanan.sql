-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Jun 2025 pada 15.22
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pjbl_6`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pesanan`
--

CREATE TABLE `data_pesanan` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `nama_produk` text DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_pesanan`
--

INSERT INTO `data_pesanan` (`id`, `order_id`, `nama_produk`, `jumlah`, `harga`, `total`, `tanggal`, `user_id`) VALUES
(7, 'ORDER-683d3e5778d85', 'Garam Cap Udang', 4, 5500, 22000, '2025-06-02 13:02:50', NULL),
(8, 'ORDER-683e73a1899e8', 'Garam Cap Udang', 4, 5500, 22000, '2025-06-03 11:02:27', 1),
(9, 'ORDER-683ec8f25fc5b', 'Garam Cap Udang', 2, 5500, 11000, '2025-06-03 17:06:04', 1),
(10, 'ORDER-683ec934e6255', 'Garam Cap Udang', 5, 5500, 27500, '2025-06-03 17:07:13', 1),
(11, 'ORDER-683ec934e6255', 'Beras Ramos', 3, 78000, 234000, '2025-06-03 17:07:13', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_pesanan`
--
ALTER TABLE `data_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_pesanan` (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_pesanan`
--
ALTER TABLE `data_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_pesanan`
--
ALTER TABLE `data_pesanan`
  ADD CONSTRAINT `fk_user_pesanan` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
