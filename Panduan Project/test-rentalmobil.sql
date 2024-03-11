-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 11 Mar 2024 pada 08.42
-- Versi server: 8.0.30
-- Versi PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test-rentalmobil`
--

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_03_07_035756_create_mobils_table', 1),
(6, '2024_03_07_040224_create_peminjamans_table', 1),
(7, '2024_03_07_040232_create_pengembalians_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mobils`
--

CREATE TABLE `mobils` (
  `id` bigint UNSIGNED NOT NULL,
  `merek` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `noplat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mobils`
--

INSERT INTO `mobils` (`id`, `merek`, `model`, `noplat`, `deskripsi`, `harga`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'Toyota', 'Avanza Veloz', 'BA 1121 IT', 'Mobil keluarga tangguh', '300000', '1710144575_toyota-avanza-veloz.jpg', '2024-03-11 01:09:35', '2024-03-11 01:09:35'),
(2, 'Toyota', 'Rush Sport', 'BA 1110 AB', 'Mobil keluarga yang nyaman', '350000', '1710144649_toyota-rush.jpg', '2024-03-11 01:10:49', '2024-03-11 01:10:49'),
(3, 'Toyota', 'Pajero Sport', 'B 2471 RF', 'Mobil strobo penebas jalanan', '750000', '1710144752_toyota-pajero-sport.jpg', '2024-03-11 01:12:32', '2024-03-11 01:12:32'),
(4, 'Honda', 'HRV', 'D 3511 OV', 'Mobil keluarga minimalis dan elegan', '500000', '1710144824_honda-hrv.png', '2024-03-11 01:13:44', '2024-03-11 01:13:44'),
(5, 'Honda', 'Civic Type R', 'F 47 AR', 'Mobil balap kenceng', '1500000', '1710144889_honda-civic-type-r.png', '2024-03-11 01:14:49', '2024-03-11 01:14:49'),
(6, 'Mini Cooper', 'Mini 3 Door', 'BA 555 AB', 'Mobil mini yang tangguh dan berkelas', '700000', '1710145113_mini-cooper.jpeg', '2024-03-11 01:18:33', '2024-03-11 01:18:33'),
(7, 'Suzuki', 'Karimun Wagon R', 'D 121 ABC', 'Mobil keluarga kecil tapi luas', '400000', '1710145172_suzuki-karimun-wagon.png', '2024-03-11 01:19:32', '2024-03-11 01:19:32'),
(8, 'Honda', 'Jazz RS', 'B 1441 CC', 'Mobil kecil dan tangguh', '4500000', '1710145245_honda-jazz.jpg', '2024-03-11 01:20:46', '2024-03-11 01:20:46'),
(9, 'Toyota', 'Yaris Sport', 'D 1312 FF', 'Mobil kecil nan ulet', '330000', '1710145360_toyota-yaris.jpeg', '2024-03-11 01:22:41', '2024-03-11 01:22:41');

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
-- Struktur dari tabel `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id` bigint UNSIGNED NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `total_harga` decimal(15,6) NOT NULL,
  `mobil_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status_kembali` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data untuk tabel `peminjamans`
--

INSERT INTO `peminjamans` (`id`, `tgl_mulai`, `tgl_akhir`, `total_harga`, `mobil_id`, `user_id`, `status_kembali`, `created_at`, `updated_at`) VALUES
(1, '2024-03-11', '2024-03-12', 700000.000000, 6, 2, 0, '2024-03-11 01:27:31', '2024-03-11 01:27:31'),
(2, '2024-03-11', '2024-03-12', 500000.000000, 4, 2, 1, '2024-03-11 01:28:52', '2024-03-11 01:29:01'),
(3, '2024-03-11', '2024-03-13', 3000000.000000, 5, 3, 0, '2024-03-11 01:30:43', '2024-03-11 01:30:43'),
(4, '2024-03-11', '2024-03-14', 1050000.000000, 2, 4, 0, '2024-03-11 01:32:01', '2024-03-11 01:32:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalians`
--

CREATE TABLE `pengembalians` (
  `id` bigint UNSIGNED NOT NULL,
  `tgl_kembali` date NOT NULL,
  `peminjaman_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data untuk tabel `pengembalians`
--

INSERT INTO `pengembalians` (`id`, `tgl_kembali`, `peminjaman_id`, `created_at`, `updated_at`) VALUES
(1, '2024-03-11', 2, '2024-03-11 01:29:01', '2024-03-11 01:29:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nosim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nohp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Admin','User') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `alamat`, `nosim`, `nohp`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Fajar Admin', 'Padang', '00111', '081218173646', '$2y$12$DQlPqA.JLEq9EX40i.LwLeeiqrjChFMwAk7sYvVAFLhLX6UaDVWGW', 'Admin', NULL, '2024-03-11 00:59:13', '2024-03-11 00:59:13'),
(2, 'Fajar User', 'Bandung', '00222', '081213141516', '$2y$12$LS/e7tg.a1RfzHEpTEL2NuitRSdjnMo5R9SfAL31bT.oA75XFYigC', 'User', NULL, '2024-03-11 00:59:13', '2024-03-11 00:59:13'),
(3, 'Tony Stark', 'New York', '00333', '081254879634', '$2y$12$CI7J.NYh2jtAYi4MiZHoPuTla3GGfNFJ3N/EJMpIq.SXVJZzuVv2u', 'User', NULL, '2024-03-11 01:01:29', '2024-03-11 01:01:29'),
(4, 'Roronoa Zoro', 'Wano, Jepang', '00444', '081247896532', '$2y$12$1wjG/bGRubYjO9orDORhpu19mDOb7RRY24CNhWJhnVpmPIRyBTtzW', 'User', NULL, '2024-03-11 01:05:23', '2024-03-11 01:05:23');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mobils`
--
ALTER TABLE `mobils`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobils_noplat_unique` (`noplat`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjamans_mobil_id_foreign` (`mobil_id`),
  ADD KEY `peminjamans_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengembalians_peminjaman_id_foreign` (`peminjaman_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_nosim_unique` (`nosim`),
  ADD UNIQUE KEY `users_nohp_unique` (`nohp`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `mobils`
--
ALTER TABLE `mobils`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengembalians`
--
ALTER TABLE `pengembalians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD CONSTRAINT `peminjamans_mobil_id_foreign` FOREIGN KEY (`mobil_id`) REFERENCES `mobils` (`id`) ON DELETE SET;

--
-- Ketidakleluasaan untuk tabel `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD CONSTRAINT `pengembalians_peminjaman_id_foreign` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjamans` (`id`) ON DELETE SET;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
