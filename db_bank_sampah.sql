-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 03 Bulan Mei 2026 pada 14.24
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `db_bank_sampah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank_sampahs`
--

CREATE TABLE `bank_sampahs` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bank_sampahs`
--

INSERT INTO `bank_sampahs` (`id`, `nama_bank`, `alamat`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'Bank Sampah Purwokerto Pusat', 'Jl. Sudirman No. 1, Purwokerto', '-7.4244', '109.2302', '2026-04-28 09:37:31', '2026-04-28 09:37:31'),
(2, 'Bank Sampah Unit 1', 'Tenda Surya Intan Purwokerto, Jalan Hos. Notosuwiryo, Teluk, Purwokerto, Banyumas, Jawa Tengah, Jawa, 53145, Indonesia', '-7.445727087542395', '109.24983322620393', '2026-04-29 14:11:22', '2026-04-29 14:11:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_sampahs`
--

CREATE TABLE `jenis_sampahs` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_sampah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_per_kg` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jenis_sampahs`
--

INSERT INTO `jenis_sampahs` (`id`, `nama_sampah`, `harga_per_kg`, `created_at`, `updated_at`) VALUES
(2, 'Kardus / Kertas', 2000.00, '2026-04-28 09:37:32', '2026-04-28 09:37:32'),
(3, 'Besi / Logam', 5000.00, '2026-04-28 09:37:32', '2026-04-28 09:37:32'),
(4, 'Plastik PET (Botol Bening)', 2500.00, '2026-05-03 08:09:22', '2026-05-03 08:09:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_23_141717_create_bank_sampahs_table', 1),
(5, '2026_04_23_142021_create_jenis_sampahs_table', 1),
(6, '2026_04_23_142331_create_transaksis_table', 1),
(7, '2026_04_23_142701_create_mutasi_saldos_table', 1),
(8, '2026_04_23_142858_create_request_jemputs_table', 1),
(9, '2026_04_23_143028_create_penarikans_table', 1),
(10, '2026_04_26_104659_add_otp_columns_to_users_table', 1),
(11, '2026_04_28_151802_add_profile_columns_to_users_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mutasi_saldos`
--

CREATE TABLE `mutasi_saldos` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tipe` enum('kredit','debit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo_akhir` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mutasi_saldos`
--

INSERT INTO `mutasi_saldos` (`id`, `user_id`, `tipe`, `nominal`, `keterangan`, `saldo_akhir`, `created_at`, `updated_at`) VALUES
(1, 3, 'kredit', 89700.00, 'Setor Plastik PET (Botol Bening) (29.9 Kg)', 89700.00, '2026-04-29 03:39:07', '2026-04-29 03:39:07'),
(2, 4, 'kredit', 40000.00, 'Setor Kardus / Kertas (20 Kg)', 40000.00, '2026-04-29 12:15:20', '2026-04-29 12:15:20'),
(3, 4, 'kredit', 40000.00, 'Setor Kardus / Kertas (20 Kg)', 80000.00, '2026-04-29 12:21:49', '2026-04-29 12:21:49'),
(4, 4, 'debit', 50000.00, 'Pencairan Saldo (Transfer) - Disetujui', 30000.00, '2026-04-29 12:28:05', '2026-04-29 12:28:05'),
(5, 6, 'kredit', 15000.00, 'Setor Plastik PET (Botol Bening) (5 Kg)', 15000.00, '2026-05-01 12:37:42', '2026-05-01 12:37:42'),
(6, 6, 'debit', 10000.00, 'Pencairan Saldo (Transfer) - Disetujui', 5000.00, '2026-05-01 12:44:28', '2026-05-01 12:44:28'),
(7, 4, 'debit', 10000.00, 'Pencairan Saldo (Transfer) - Disetujui', 20000.00, '2026-05-03 06:52:10', '2026-05-03 06:52:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penarikans`
--

CREATE TABLE `penarikans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `metode` enum('transfer','sembako') COLLATE utf8mb4_unicode_ci NOT NULL,
  `detail_tujuan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penarikans`
--

INSERT INTO `penarikans` (`id`, `user_id`, `nominal`, `metode`, `detail_tujuan`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 50000.00, 'transfer', 'Transfer ke: dana - 085656216607 (a.n fatahul qorib)', 'disetujui', '2026-04-29 12:26:37', '2026-04-29 12:28:05'),
(2, 6, 10000.00, 'transfer', 'Transfer ke: BCA - 0461683681 (a.n QUROTUL AENI NUR AZMI)', 'disetujui', '2026-05-01 12:41:36', '2026-05-01 12:44:27'),
(3, 4, 10000.00, 'transfer', 'Transfer ke: dana - 086544676 (a.n jimbun)', 'disetujui', '2026-05-01 12:48:18', '2026-05-03 06:52:09'),
(4, 4, 15000.00, 'transfer', 'Transfer ke: dana - 08779674 (a.n jimbun)', 'ditolak', '2026-05-03 06:59:47', '2026-05-03 07:06:08'),
(5, 4, 20000.00, 'transfer', 'Transfer ke: dana - 0812763842 (a.n jimbun)', 'ditolak', '2026-05-03 07:27:07', '2026-05-03 07:33:25'),
(6, 4, 18000.00, 'transfer', 'Transfer ke: dana - 0832735611 (a.n fatahul qorib)', 'ditolak', '2026-05-03 07:41:32', '2026-05-03 07:43:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `request_jemputs`
--

CREATE TABLE `request_jemputs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `bank_sampah_id` bigint UNSIGNED DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_lengkap` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_jemput` date NOT NULL,
  `jam_jemput` time NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('menunggu','dijadwalkan','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `request_jemputs`
--

INSERT INTO `request_jemputs` (`id`, `user_id`, `bank_sampah_id`, `latitude`, `longitude`, `alamat_lengkap`, `tanggal_jemput`, `jam_jemput`, `catatan`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '-7.413140547166186', '109.24534013134736', 'Wijayakusuma Golf Course, Golf Course Way, Jatiwinangun, Bancarkembar, Banyumas, Jawa Tengah, Jawa, 53121, Indonesia', '2026-04-30', '12:37:00', 'sampah kardus dan kaca', 'selesai', '2026-04-29 11:37:21', '2026-04-29 12:22:35'),
(2, 4, 1, '-7.4245', '109.2302', 'Wijayakusuma Golf Course, Golf Course Way, Jatiwinangun, Bancarkembar, Banyumas, Jawa Tengah, Jawa, 53121, Indonesia', '2026-04-30', '12:37:00', 'sampah kardus dan kaca', 'selesai', '2026-04-29 11:45:13', '2026-04-29 12:23:46'),
(3, 7, 1, '-7.397848445305771', '109.24931655469423', 'Dukuhwaluh, Grendeng, Banyumas, Jawa Tengah, Jawa, 53124, Indonesia', '2026-05-03', '08:35:00', 'botol plastik', 'selesai', '2026-05-01 12:31:32', '2026-05-01 12:39:23'),
(4, 6, 1, '-7.4245', '109.2302', 'Jalan Pengadilan, Kedungwuluh, Banyumas, Jawa Tengah, Jawa, 53116, Indonesia', '2026-05-14', '09:00:00', NULL, 'menunggu', '2026-05-01 14:07:45', '2026-05-01 14:07:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('UCC1QwGLZkg3FQyMIEwDcSCO70FQVk9E9vek84ro', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI4cDl4b0JHS0hBZDlwOExCZTNseVlja3NtVUpQSDV1clBNQ1dudUdMIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImFkbWluLmRhc2hib2FyZCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1777798961);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `petugas_id` bigint UNSIGNED DEFAULT NULL,
  `jenis_sampah_id` bigint UNSIGNED DEFAULT NULL,
  `berat` double NOT NULL DEFAULT '0',
  `total_harga` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksis`
--

INSERT INTO `transaksis` (`id`, `user_id`, `petugas_id`, `jenis_sampah_id`, `berat`, `total_harga`, `created_at`, `updated_at`) VALUES
(1, 3, 2, NULL, 29.9, 89700, '2026-04-29 03:39:07', '2026-04-29 03:39:07'),
(2, 4, 2, 2, 20, 40000, '2026-04-29 12:15:20', '2026-04-29 12:15:20'),
(3, 4, 2, 2, 20, 40000, '2026-04-29 12:21:48', '2026-04-29 12:21:48'),
(4, 6, 2, NULL, 5, 15000, '2026-05-01 12:37:42', '2026-05-01 12:37:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','petugas','nasabah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nasabah',
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `bank_sampah_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `otp`, `otp_expires_at`, `role`, `no_hp`, `alamat`, `bank_sampah_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', NULL, '$2y$12$CjG37cKOgNaXAoyphC082evOat5i4yZBe1d0oYkXuU/.zW3m7x3He', NULL, NULL, 'admin', NULL, NULL, NULL, NULL, '2026-04-28 09:37:31', '2026-04-28 09:37:31'),
(2, 'Petugas Jaga', 'petugas@gmail.com', NULL, '$2y$12$pv9Z2q8UdtYzvPj/rNXOZ.n3ZF/jxJOMhx39FYDN5jaEv.Yssez8S', NULL, NULL, 'petugas', NULL, NULL, 1, NULL, '2026-04-28 09:37:32', '2026-04-28 09:37:32'),
(3, 'Jim Bun', 'nasabah@gmail.com', NULL, '$2y$12$Jl68fRyItOPlEP34eBV7gevUQYMhxO2Pj.HDpAsxQMxUtBGhCTUyC', NULL, NULL, 'nasabah', '081234567890', 'Jl. Pahlawan, Purwokerto', NULL, NULL, '2026-04-28 09:37:32', '2026-04-28 09:37:32'),
(4, 'fatahul', 'qfatahul@gmail.com', NULL, '$2y$12$mgGgyjadAgVc2y.71BpumeicZvvgznIx.Ds/cspNNw3aOxKbBw8h2', NULL, NULL, 'nasabah', '085656216607', NULL, NULL, NULL, '2026-04-29 11:34:59', '2026-04-29 11:35:35'),
(5, 'BSU1', 'petugasbsu1@gmail.com', NULL, '$2y$12$wGexWGXaFYfeXRFWbkyI.ed73ZJ6ac7E4BwkZr1SbLscpw2KpRZhS', NULL, NULL, 'petugas', NULL, NULL, 2, NULL, '2026-04-29 14:28:35', '2026-04-29 14:28:35'),
(6, 'azmi', 'qurotulaeniazmi234@gmail.com', NULL, '$2y$12$nJgVFo4W9mlRgnt0hq1WsOWPbc8HRU/Te/4xSQ9KmaRl6aRet14w2', '981526', '2026-05-01 12:21:33', 'nasabah', '081234512341', NULL, NULL, NULL, '2026-05-01 12:16:36', '2026-05-01 12:16:36'),
(7, 'azmi', 'qurotulaeninurazmi234@gmail.com', NULL, '$2y$12$cBWZvtoqJGr1SIcNb4jeuuA6fl4dkAlP94u1WmJ7lFxQhzh.Di1Gq', NULL, NULL, 'nasabah', '081234512341', NULL, NULL, NULL, '2026-05-01 12:17:05', '2026-05-01 12:17:46');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `bank_sampahs`
--
ALTER TABLE `bank_sampahs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jenis_sampahs`
--
ALTER TABLE `jenis_sampahs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mutasi_saldos`
--
ALTER TABLE `mutasi_saldos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mutasi_saldos_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `penarikans`
--
ALTER TABLE `penarikans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penarikans_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `request_jemputs`
--
ALTER TABLE `request_jemputs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `request_jemputs_user_id_foreign` (`user_id`),
  ADD KEY `request_jemputs_bank_sampah_id_foreign` (`bank_sampah_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksis_user_id_foreign` (`user_id`),
  ADD KEY `transaksis_petugas_id_foreign` (`petugas_id`),
  ADD KEY `transaksis_jenis_sampah_id_foreign` (`jenis_sampah_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bank_sampahs`
--
ALTER TABLE `bank_sampahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_sampahs`
--
ALTER TABLE `jenis_sampahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `mutasi_saldos`
--
ALTER TABLE `mutasi_saldos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `penarikans`
--
ALTER TABLE `penarikans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `request_jemputs`
--
ALTER TABLE `request_jemputs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `mutasi_saldos`
--
ALTER TABLE `mutasi_saldos`
  ADD CONSTRAINT `mutasi_saldos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penarikans`
--
ALTER TABLE `penarikans`
  ADD CONSTRAINT `penarikans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `request_jemputs`
--
ALTER TABLE `request_jemputs`
  ADD CONSTRAINT `request_jemputs_bank_sampah_id_foreign` FOREIGN KEY (`bank_sampah_id`) REFERENCES `bank_sampahs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `request_jemputs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_jenis_sampah_id_foreign` FOREIGN KEY (`jenis_sampah_id`) REFERENCES `jenis_sampahs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaksis_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaksis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
