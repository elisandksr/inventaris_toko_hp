-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Jan 2026 pada 03.08
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
-- Database: `uas_web_2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `nama_admin`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$mjMz.aF/JAGtGVw4vEv3VOYOdenrLL61nMUFhOBcSG/nAnnyErV4C', 'Administrator', '2026-01-07 06:48:34', NULL);

--
-- Dumping data untuk tabel `suppliers`
--

INSERT INTO `suppliers` (`id`, `nama_supplier`, `alamat`, `telepon`, `email`, `created_at`, `updated_at`) VALUES
(1, 'PT. Apple Indonesia', 'Jl. Sudirman No. 123, Jakarta', '021-12345678', 'contact@apple.co.id', '2026-01-07 07:00:00', NULL),
(2, 'Samsung Distributor', 'Jl. Thamrin No. 456, Jakarta', '021-87654321', 'sales@samsung-id.com', '2026-01-07 07:15:00', NULL),
(3, 'Xiaomi Official Store', 'Jl. Malioboro No. 789, Yogyakarta', '0274-123456', 'store@xiaomi.co.id', '2026-01-07 07:30:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_hp` varchar(100) NOT NULL,
  `merek` varchar(50) NOT NULL,
  `imei` varchar(100) DEFAULT NULL,
  `harga_beli` decimal(15,2) NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `lokasi_rak` varchar(50) DEFAULT NULL,
  `status` enum('Ready','Kosong','Rusak') NOT NULL DEFAULT 'Ready',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_hp`, `merek`, `imei`, `harga_beli`, `harga_jual`, `stok`, `lokasi_rak`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BRG 01', 'Iphone 17 Pro Max', 'Apple', '35263171372', 45000000.00, 48000000.00, 8, 'Rak A1', 'Ready', '2026-01-07 07:34:58', '2026-01-12 09:00:00'),
(2, 'BRG 02', 'Samsung Galaxy S25', 'Samsung', '98765432101', 12000000.00, 13500000.00, 8, 'Rak A2', 'Ready', '2026-01-07 08:00:00', '2026-01-10 15:00:00'),
(3, 'BRG 03', 'Xiaomi 15 Pro', 'Xiaomi', '11223344556', 8000000.00, 9500000.00, 3, 'Rak B1', 'Menipis', '2026-01-07 08:15:00', '2026-01-11 11:00:00'),
(4, 'BRG 04', 'Oppo Reno 12', 'Oppo', '55667788990', 5000000.00, 6200000.00, 12, 'Rak B2', 'Ready', '2026-01-07 08:30:00', '2026-01-12 16:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-01-07-064407', 'App\\Database\\Migrations\\Admins', 'default', 'App', 1767768511, 1),
(2, '2026-01-07-064409', 'App\\Database\\Migrations\\Suppliers', 'default', 'App', 1767768511, 1),
(3, '2026-01-07-064412', 'App\\Database\\Migrations\\Barang', 'default', 'App', 1767768511, 1),
(4, '2026-01-07-064414', 'App\\Database\\Migrations\\Transaksi', 'default', 'App', 1767768511, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_supplier` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) UNSIGNED NOT NULL,
  `jenis` enum('Masuk','Keluar') NOT NULL,
  `barang_id` int(11) UNSIGNED NOT NULL,
  `supplier_id` int(11) UNSIGNED DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_barang_id_foreign` (`barang_id`),
  ADD KEY `transaksi_supplier_id_foreign` (`supplier_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE ON UPDATE SET NULL;
--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `jenis`, `barang_id`, `supplier_id`, `jumlah`, `tanggal`, `keterangan`, `created_at`) VALUES
(1, 'Masuk', 1, 1, 10, '2026-01-08', 'Barang baru dari Apple Indonesia', '2026-01-08 09:00:00'),
(2, 'Masuk', 2, 2, 15, '2026-01-08', 'Stock awal Samsung Galaxy S25', '2026-01-08 09:15:00'),
(3, 'Masuk', 3, 3, 8, '2026-01-09', 'Xiaomi 15 Pro batch pertama', '2026-01-09 10:00:00'),
(4, 'Masuk', 4, NULL, 20, '2026-01-09', 'Oppo Reno 12 stock awal', '2026-01-09 10:30:00'),
(5, 'Keluar', 1, NULL, 5, '2026-01-10', 'Penjualan ke customer retail', '2026-01-10 14:00:00'),
(6, 'Keluar', 2, NULL, 7, '2026-01-10', 'Penjualan grosir 5 unit + 2 unit retail', '2026-01-10 15:00:00'),
(7, 'Keluar', 3, NULL, 5, '2026-01-11', 'Penjualan Xiaomi ke distributor', '2026-01-11 11:00:00'),
(8, 'Masuk', 1, 1, 3, '2026-01-12', 'Restock iPhone dari Apple', '2026-01-12 09:00:00'),
(9, 'Keluar', 4, NULL, 8, '2026-01-12', 'Penjualan Oppo ke marketplace', '2026-01-12 16:00:00');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
