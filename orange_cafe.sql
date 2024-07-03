-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Jul 2024 pada 14.55
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orange_cafe`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_detail_transaksi`
--

CREATE TABLE `tabel_detail_transaksi` (
  `Id_Invoice` char(5) NOT NULL,
  `Id_Menu` char(4) NOT NULL,
  `Jumlah` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_detail_transaksi`
--

INSERT INTO `tabel_detail_transaksi` (`Id_Invoice`, `Id_Menu`, `Jumlah`, `id`) VALUES
('INV01', 'MK1', 3, 51),
('INV02', 'MK2', 1, 52),
('INV02', 'MK3', 4, 53),
('INV03', 'MK4', 2, 54),
('INV03', 'MK5', 1, 55),
('INV03', 'MK6', 7, 56),
('INV04', 'MK1', 10, 57),
('INV04', 'MK2', 9, 58),
('INV07', 'MN2', 12, 62),
('INV08', 'MNR3', 5, 63),
('INV09', 'MNR4', 5, 64),
('INV10', 'MNR5', 5, 65),
('INV05', 'MN2', 12, 66),
('INV06', 'MNR2', 5, 67);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_header_transaksi`
--

CREATE TABLE `tabel_header_transaksi` (
  `Id_Invoice` char(5) NOT NULL,
  `Date_Inv` date DEFAULT NULL,
  `Id_Pelanggan` char(3) DEFAULT NULL,
  `Id_Kasir` char(3) DEFAULT NULL,
  `Total_Harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_header_transaksi`
--

INSERT INTO `tabel_header_transaksi` (`Id_Invoice`, `Date_Inv`, `Id_Pelanggan`, `Id_Kasir`, `Total_Harga`) VALUES
('INV01', '2024-07-02', '001', 'KS1', 30000.00),
('INV02', '2024-07-02', '002', 'KS1', 62000.00),
('INV03', '2024-07-02', '003', 'KS1', 110000.00),
('INV04', '2024-07-02', '004', 'KS1', 190000.00),
('INV05', '2024-07-03', '005', 'KS1', 96000.00),
('INV06', '2024-07-03', '006', 'KS1', 35000.00),
('INV07', '2024-07-03', '007', 'KS2', 96000.00),
('INV08', '2024-07-03', '008', 'KS2', 35000.00),
('INV09', '2024-07-03', '009', 'KS2', 35000.00),
('INV10', '2024-07-03', '010', 'KS2', 35000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_kasir`
--

CREATE TABLE `tabel_kasir` (
  `Id_Kasir` char(3) NOT NULL,
  `Nama_Kasir` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_kasir`
--

INSERT INTO `tabel_kasir` (`Id_Kasir`, `Nama_Kasir`) VALUES
('KS1', 'Toni'),
('KS2', 'Wati');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_kategori`
--

CREATE TABLE `tabel_kategori` (
  `Id_Kategori` char(3) NOT NULL,
  `Kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_kategori`
--

INSERT INTO `tabel_kategori` (`Id_Kategori`, `Kategori`) VALUES
('MK', 'Makanan'),
('MN', 'Minuman'),
('MNR', 'Minuman Renteng');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_menu`
--

CREATE TABLE `tabel_menu` (
  `Id_Menu` char(4) NOT NULL,
  `Id_Kategori` char(3) DEFAULT NULL,
  `Nama_Menu` varchar(50) DEFAULT NULL,
  `Harga_Satuan` int(11) DEFAULT NULL,
  `Gambar_Menu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_menu`
--

INSERT INTO `tabel_menu` (`Id_Menu`, `Id_Kategori`, `Nama_Menu`, `Harga_Satuan`, `Gambar_Menu`) VALUES
('MK1', 'MK', 'Nasi Goreng', 10000, 'Nasi Goreng.jpg'),
('MK2', 'MK', 'Mie Goreng', 10000, 'Mie Goreng.jpg'),
('MK3', 'MK', 'Minas', 13000, 'Mienas.jpg'),
('MK4', 'MK', 'Pecel Ayam', 14000, 'Pecel Ayam.jpeg'),
('MK5', 'MK', 'Pecel Lele', 12000, 'Pecel Lele.jpg'),
('MK6', 'MK', 'Mie Rebus', 10000, 'Mie Rebus.jpg'),
('MN1', 'MN', 'Teh Telur', 6000, 'Teh Telur.jpg'),
('MN2', 'MN', 'Kelapa Muda', 8000, 'Kelapa Muda.jpg'),
('MNR1', 'MNR', 'Nutrisari', 5000, 'Nutrisari.jpg'),
('MNR2', 'MNR', 'Good Day Cappuccino', 7000, 'Good Day Cappuccino.jpg'),
('MNR3', 'MNR', 'Drink Beng-beng', 7000, 'Drink Beng-beng.jpeg'),
('MNR4', 'MNR', 'Chocolatos', 7000, 'Chocolatos.jpg'),
('MNR5', 'MNR', 'Pop Ice', 7000, 'Pop Ice.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_pelanggan`
--

CREATE TABLE `tabel_pelanggan` (
  `Id_Pelanggan` char(3) NOT NULL,
  `Pelanggan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_pelanggan`
--

INSERT INTO `tabel_pelanggan` (`Id_Pelanggan`, `Pelanggan`) VALUES
('001', 'Ichwan'),
('002', 'Fikra'),
('003', 'Fajri'),
('004', 'Ikhsan'),
('005', 'Faiz'),
('006', 'Haykal'),
('007', 'Fadli'),
('008', 'Iman'),
('009', 'Imam'),
('010', 'Austin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tabel_detail_transaksi`
--
ALTER TABLE `tabel_detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_Menu` (`Id_Menu`) USING BTREE,
  ADD KEY `Id_Invoice` (`Id_Invoice`) USING BTREE;

--
-- Indeks untuk tabel `tabel_header_transaksi`
--
ALTER TABLE `tabel_header_transaksi`
  ADD PRIMARY KEY (`Id_Invoice`),
  ADD KEY `Id_Pelanggan` (`Id_Pelanggan`),
  ADD KEY `Id_Kasir` (`Id_Kasir`);

--
-- Indeks untuk tabel `tabel_kasir`
--
ALTER TABLE `tabel_kasir`
  ADD PRIMARY KEY (`Id_Kasir`);

--
-- Indeks untuk tabel `tabel_kategori`
--
ALTER TABLE `tabel_kategori`
  ADD PRIMARY KEY (`Id_Kategori`);

--
-- Indeks untuk tabel `tabel_menu`
--
ALTER TABLE `tabel_menu`
  ADD PRIMARY KEY (`Id_Menu`),
  ADD KEY `Id_Kategori` (`Id_Kategori`);

--
-- Indeks untuk tabel `tabel_pelanggan`
--
ALTER TABLE `tabel_pelanggan`
  ADD PRIMARY KEY (`Id_Pelanggan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tabel_detail_transaksi`
--
ALTER TABLE `tabel_detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tabel_detail_transaksi`
--
ALTER TABLE `tabel_detail_transaksi`
  ADD CONSTRAINT `tabel_detail_transaksi_ibfk_1` FOREIGN KEY (`Id_Menu`) REFERENCES `tabel_menu` (`Id_Menu`),
  ADD CONSTRAINT `tabel_detail_transaksi_ibfk_2` FOREIGN KEY (`Id_Invoice`) REFERENCES `tabel_header_transaksi` (`Id_Invoice`);

--
-- Ketidakleluasaan untuk tabel `tabel_header_transaksi`
--
ALTER TABLE `tabel_header_transaksi`
  ADD CONSTRAINT `tabel_header_transaksi_ibfk_1` FOREIGN KEY (`Id_Pelanggan`) REFERENCES `tabel_pelanggan` (`Id_Pelanggan`),
  ADD CONSTRAINT `tabel_header_transaksi_ibfk_2` FOREIGN KEY (`Id_Kasir`) REFERENCES `tabel_kasir` (`Id_Kasir`);

--
-- Ketidakleluasaan untuk tabel `tabel_menu`
--
ALTER TABLE `tabel_menu`
  ADD CONSTRAINT `tabel_menu_ibfk_1` FOREIGN KEY (`Id_Kategori`) REFERENCES `tabel_kategori` (`Id_Kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
