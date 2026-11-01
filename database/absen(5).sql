-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2026 at 06:04 AM
-- Server version: 8.0.43-0ubuntu0.24.04.2
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absen`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` bigint UNSIGNED NOT NULL,
  `id_siswa` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_tahun_ajaran` bigint UNSIGNED DEFAULT NULL,
  `tgl_absen` date NOT NULL,
  `status` enum('H','S','I','A') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `sesi` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_siswa`, `id_user`, `id_tahun_ajaran`, `tgl_absen`, `status`, `keterangan`, `sesi`, `created_at`, `updated_at`) VALUES
(1, 101, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(2, 109, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(3, 120, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(4, 119, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(5, 117, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(6, 111, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(7, 116, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(8, 105, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(9, 110, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(10, 115, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(11, 102, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(12, 107, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(13, 104, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(14, 108, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(15, 113, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(16, 118, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(17, 106, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(18, 114, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(19, 103, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(20, 112, 8, 2, '2026-07-06', 'H', NULL, 1, '2026-07-06 06:01:00', '2026-07-06 06:01:00'),
(21, 101, 8, 2, '2026-07-06', 'I', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:26:15'),
(22, 109, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(23, 120, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(24, 119, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(25, 117, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(26, 111, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(27, 116, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(28, 105, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(29, 110, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(30, 115, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(31, 102, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(32, 107, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(33, 104, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(34, 108, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(35, 113, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(36, 118, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(37, 106, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(38, 114, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:12', '2026-07-06 06:25:12'),
(39, 103, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:13', '2026-07-06 06:25:13'),
(40, 112, 8, 2, '2026-07-06', 'H', NULL, 2, '2026-07-06 06:25:13', '2026-07-06 06:25:13'),
(41, 101, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(42, 109, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(43, 120, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(44, 119, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(45, 117, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(46, 111, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(47, 116, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(48, 105, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(49, 110, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(50, 115, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(51, 102, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(52, 107, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(53, 104, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(54, 108, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(55, 113, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(56, 118, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(57, 106, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(58, 114, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(59, 103, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38'),
(60, 112, 8, 2, '2026-07-06', 'H', NULL, 3, '2026-07-06 07:04:38', '2026-07-06 07:04:38');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-bagus3|127.0.0.1', 'i:1;', 1783318939),
('laravel-cache-bagus3|127.0.0.1:timer', 'i:1783318939;', 1783318939);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `hari_libur`
--

CREATE TABLE `hari_libur` (
  `id_libur` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hari_libur`
--

INSERT INTO `hari_libur` (`id_libur`, `tanggal`, `keterangan`, `created_at`, `updated_at`) VALUES
(3, '2026-07-08', 'test', '2026-07-08 04:12:20', '2026-07-08 04:12:20'),
(4, '2026-07-09', 'test123', '2026-07-08 04:26:24', '2026-07-08 04:26:24');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` bigint UNSIGNED NOT NULL,
  `nama_kelas` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` int NOT NULL,
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `tingkat`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'kelas 1', 1, 3, '2026-07-01 02:38:30', '2026-07-01 02:38:30'),
(2, 'kelas 2', 2, 4, '2026-07-01 02:39:25', '2026-07-01 02:39:25'),
(3, 'kelas 3', 3, 5, '2026-07-01 02:39:37', '2026-07-01 02:39:37'),
(4, 'kelas 4', 4, 6, '2026-07-01 02:40:23', '2026-07-01 02:40:23'),
(5, 'kelas 5', 5, 7, '2026-07-01 02:40:34', '2026-07-01 02:40:34'),
(6, 'kelas 6', 6, 8, '2026-07-01 02:40:44', '2026-07-01 02:40:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_16_052230_create_tahun_ajaran_table', 1),
(5, '2026_04_27_052226_create_kelas_table', 1),
(7, '2026_04_27_052245_create_absensis_table', 1),
(8, '2026_06_22_210721_create_riwayat_akademik_table', 1),
(9, '2026_06_24_200520_create_hari_libur_table', 1),
(11, '2026_06_26_092140_create_tb_pengumuman', 2),
(12, '2026_04_27_052235_create_siswas_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_akademik`
--

CREATE TABLE `riwayat_akademik` (
  `id_riwayat` bigint UNSIGNED NOT NULL,
  `id_siswa` bigint UNSIGNED DEFAULT NULL,
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_siswa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_kelas` bigint UNSIGNED NOT NULL,
  `id_tahun_ajaran` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3fPuTYW01oZ5iIIv580E9vR3kC75Yat65DgbLjGw', 8, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:152.0) Gecko/20100101 Firefox/152.0', 'eyJfdG9rZW4iOiJmUDVXRkltQmFxVDFSMVVYUndTOEk4MzR0SFlGZjNIZVk4Yk5PM3dLIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2d1cnVcL2Rhc2hib2FyZCIsInJvdXRlIjoiZ3VydS5kYXNoYm9hcmQifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjh9', 1783321535),
('3hacGBxFd6DefKm1MHXSLcW9sjGC328HflO3al8N', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:152.0) Gecko/20100101 Firefox/152.0', 'eyJfdG9rZW4iOiJpV1BDVXlZUEVCTGRWVjNwcm9zVTZQOUpOdnhkUTVIcGNHYUxnb21HIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvaGFyaS1saWJ1ciIsInJvdXRlIjoiYWRtaW4ubGlidXIuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1783484785);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` bigint UNSIGNED NOT NULL,
  `id_kelas` bigint UNSIGNED DEFAULT NULL,
  `id_tahun_ajaran` bigint UNSIGNED DEFAULT NULL,
  `nis` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_siswa` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('aktif','lulus') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `id_kelas`, `id_tahun_ajaran`, `nis`, `nama_siswa`, `jenis_kelamin`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '260101', 'Abizar Al Ghifari', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(2, 1, 2, '260102', 'Adinda Lestari', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(3, 1, 2, '260103', 'Ahmad Fauzi', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(4, 1, 2, '260104', 'Aisyah Putri', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(5, 1, 2, '260105', 'Andika Pratama', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(6, 1, 2, '260106', 'Anisa Rahmawati', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(7, 1, 2, '260107', 'Bagas Saputra', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(8, 1, 2, '260108', 'Bunga Citra', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(9, 1, 2, '260109', 'Candra Kirana', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(10, 1, 2, '260110', 'Dafa Ramadhan', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(11, 1, 2, '260111', 'Dinda Permata', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(12, 1, 2, '260112', 'Eka Putra', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(13, 1, 2, '260113', 'Fadel Muhammad', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(14, 1, 2, '260114', 'Farah Dibha', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(15, 1, 2, '260115', 'Galih Wijaya', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(16, 1, 2, '260116', 'Gita Gutawa', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(17, 1, 2, '260117', 'Hafiz Ansari', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(18, 1, 2, '260118', 'Indah Permatasari', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(19, 1, 2, '260119', 'Joko Susilo', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(20, 1, 2, '260120', 'Kania Dewi', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(21, 2, 2, '250201', 'Luthfi Hakim', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(22, 2, 2, '250202', 'Mutiara Sani', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(23, 2, 2, '250203', 'Nabil Ahmad', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(24, 2, 2, '250204', 'Nabila Syakieb', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(25, 2, 2, '250205', 'Oki Setiana', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(26, 2, 2, '250206', 'Putri Ayu', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(27, 2, 2, '250207', 'Rafi Ahmad', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(28, 2, 2, '250208', 'Rania Khalida', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(29, 2, 2, '250209', 'Rian Dwi', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(30, 2, 2, '250210', 'Salsabila Putri', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(31, 2, 2, '250211', 'Taufik Hidayat', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(32, 2, 2, '250212', 'Tiara Andini', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(33, 2, 2, '250213', 'Vino G Bastian', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(34, 2, 2, '250214', 'Wulan Guritno', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(35, 2, 2, '250215', 'Yuda Pratama', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(36, 2, 2, '250216', 'Zahra Amalia', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(37, 2, 2, '250217', 'Zidan Alamsyah', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(38, 2, 2, '250218', 'Siti Aminah', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(39, 2, 2, '250219', 'Bambang Pamungkas', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(40, 2, 2, '250220', 'Dewi Persik', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(41, 3, 2, '240301', 'Abdurrahman Wahid', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(42, 3, 2, '240302', 'Achmad Zaky', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(43, 3, 2, '240303', 'Adinda Larasati', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(44, 3, 2, '240304', 'Agung Prasetyo', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(45, 3, 2, '240305', 'Aisyah Fitriani', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(46, 3, 2, '240306', 'Andika Kangen', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(47, 3, 2, '240307', 'Angga Wijaya', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(48, 3, 2, '240308', 'Anisa Rahma', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(49, 3, 2, '240309', 'Bayu Segara', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(50, 3, 2, '240310', 'Bunga Lestari', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(51, 3, 2, '240311', 'Candra Wijaya', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(52, 3, 2, '240312', 'Citra Kirana', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(53, 3, 2, '240313', 'Dandi Maulana', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(54, 3, 2, '240314', 'Dhea Ananda', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(55, 3, 2, '240315', 'Eko Patrio', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(56, 3, 2, '240316', 'Elsa Mayori', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(57, 3, 2, '240317', 'Fahri Hamzah', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(58, 3, 2, '240318', 'Fitri Carlina', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(59, 3, 2, '240319', 'Gading Marten', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(60, 3, 2, '240320', 'Gisella Anastasia', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(61, 4, 2, '230401', 'Hendra Setiawan', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(62, 4, 2, '230402', 'Iis Dahlia', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(63, 4, 2, '230403', 'Irfan Hakim', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(64, 4, 2, '230404', 'Isyana Sarasvati', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(65, 4, 2, '230405', 'Jefri Nichol', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(66, 4, 2, '230406', 'Jessica Mila', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(67, 4, 2, '230407', 'Kevin Sanjaya', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(68, 4, 2, '230408', 'Luna Maya', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(69, 4, 2, '230409', 'Marcus Fernaldi', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(70, 4, 2, '230410', 'Maudy Ayunda', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(71, 4, 2, '230411', 'Nadiem Makarim', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(72, 4, 2, '230412', 'Najwa Shihab', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(73, 4, 2, '230413', 'Onadio Leonardo', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(74, 4, 2, '230414', 'Prilly Latuconsina', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(75, 4, 2, '230415', 'Raditya Dika', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(76, 4, 2, '230416', 'Raline Shah', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(77, 4, 2, '230417', 'Sule Sutisna', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(78, 4, 2, '230418', 'Titi Kamal', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(79, 4, 2, '230419', 'Uus Rizky', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(80, 4, 2, '230420', 'Via Vallen', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(81, 5, 2, '220501', 'Wendra Kusuma', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(82, 5, 2, '220502', 'Xena Princess', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(83, 5, 2, '220503', 'Yayan Ruhian', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(84, 5, 2, '220504', 'Yuni Shara', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(85, 5, 2, '220505', 'Zainudin Amali', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(86, 5, 2, '220506', 'Zaskia Gotik', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(87, 5, 2, '220507', 'Ari Lasso', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(88, 5, 2, '220508', 'Bunga Citra Lestari', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(89, 5, 2, '220509', 'Chrisye Rahadi', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(90, 5, 2, '220510', 'Didi Kempot', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(91, 5, 2, '220511', 'Ebit G Ade', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(92, 5, 2, '220512', 'Fatin Shidqia', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(93, 5, 2, '220513', 'Glenn Fredly', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(94, 5, 2, '220514', 'Isyana Elma', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(95, 5, 2, '220515', 'Judika Sihotang', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(96, 5, 2, '220516', 'Krisdayanti Lemos', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(97, 5, 2, '220517', 'Once Mekel', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(98, 5, 2, '220518', 'Rossi Roslaina', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(99, 5, 2, '220519', 'Sandhy Sondoro', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(100, 5, 2, '220520', 'Tulus Rusydi', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(101, 6, 2, '210601', 'Agus Harimurti', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(102, 6, 2, '210602', 'Megawati Soekarno', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(103, 6, 2, '210603', 'Susilo Bambang', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(104, 6, 2, '210604', 'Puan Maharani', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(105, 6, 2, '210605', 'Joko Widodo', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(106, 6, 2, '210606', 'Sri Mulyani', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(107, 6, 2, '210607', 'Prabowo Subianto', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(108, 6, 2, '210608', 'Retno Marsudi', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(109, 6, 2, '210609', 'Anies Baswedan', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(110, 6, 2, '210610', 'Khofifah Indar', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(111, 6, 2, '210611', 'Ganjar Pranowo', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(112, 6, 2, '210612', 'Tri Rismaharini', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(113, 6, 2, '210613', 'Ridwan Kamil', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(114, 6, 2, '210614', 'Susi Pudjiastuti', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(115, 6, 2, '210615', 'Mahfud MD', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(116, 6, 2, '210616', 'Ida Fauziyah', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(117, 6, 2, '210617', 'Erick Thohir', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(118, 6, 2, '210618', 'Siti Nurbaya', 'P', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(119, 6, 2, '210619', 'Budi Gunadi', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01'),
(120, 6, 2, '210620', 'Basuki Hadimuljono', 'L', 'aktif', '2026-06-22 19:18:32', '2026-06-22 19:56:01');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `id_tahun_ajaran` bigint UNSIGNED NOT NULL,
  `tahun` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`id_tahun_ajaran`, `tahun`, `is_aktif`, `created_at`, `updated_at`) VALUES
(1, '2025/2026', 0, '2026-07-06 05:55:02', '2026-07-06 05:55:02'),
(2, '2026/2027', 1, '2026-07-06 05:56:15', '2026-07-06 05:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengumuman`
--

CREATE TABLE `tb_pengumuman` (
  `id_pengumuman` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('penting','info','agenda') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `tgl_tampil` date NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nonaktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_pengumuman`
--

INSERT INTO `tb_pengumuman` (`id_pengumuman`, `judul`, `isi`, `kategori`, `tgl_tampil`, `status`, `created_at`, `updated_at`) VALUES
(1, 'tes', 'feg', 'info', '2026-07-06', 'nonaktif', NULL, NULL),
(2, 'tes43', 'feg', 'info', '2026-07-06', 'nonaktif', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','guru') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'guru',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama_lengkap`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin_pusat', '$2y$12$80pw.eW07C2haJk5Odx2Pu268b9NasXPzXzCI0COnDcRBSK/ssy8u', 'Administrator Utama', 'admin', '2026-07-01 02:25:50', '2026-07-01 02:25:50'),
(3, 'adilah', '$2y$12$RpqbEWc7S1xQ2Kacg.cdP./dMsjcHxTiruy25zyZWacRKSNPbMbHW', 'Adilah Hania, S.Pd', 'guru', '2026-07-01 02:28:25', '2026-07-01 02:28:25'),
(4, 'april', '$2y$12$Iwy6esxLI6/U6tmf7s375uIV6cFCfn8zTR/Q0tip/6t7nKlz6YK4a', 'Apriliani, S.Pd', 'guru', '2026-07-01 02:28:50', '2026-07-01 02:28:50'),
(5, 'bagus', '$2y$12$5YqU.f0aQcPmw2J4vxNroOhUO/Q96lasWdoNofYxfLC9H.lQhtXhW', 'Bagus Santoso, S.Pd', 'guru', '2026-07-01 02:29:06', '2026-07-01 02:29:06'),
(6, 'ikhwan', '$2y$12$ySDyJWHP/A6olRPKryR2YOT10r90jzragm0imXs4tHexxRGBZVpA6', 'Ikhwan Anugrah, S.Pd', 'guru', '2026-07-01 02:29:18', '2026-07-01 02:29:18'),
(7, 'yudi', '$2y$12$ZL/rUVz2rwpQKYd2Fe72c./S2kI5RwkQUCeU4Wr6qwU32O39w5dxK', 'Januar Yudi, S.Pd', 'guru', '2026-07-01 02:29:33', '2026-07-01 02:29:33'),
(8, 'zahra', '$2y$12$SMkGPLFSj6E.ZYnTuC8AmuVOK3UWKvUV7aghr4yJASEgIwI.GW/Q2', 'Zahra Aulia, S.Pd', 'guru', '2026-07-01 02:30:07', '2026-07-01 02:30:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD UNIQUE KEY `unik_absen` (`id_siswa`,`tgl_absen`,`sesi`),
  ADD KEY `absensi_id_user_foreign` (`id_user`),
  ADD KEY `absensi_id_tahun_ajaran_foreign` (`id_tahun_ajaran`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hari_libur`
--
ALTER TABLE `hari_libur`
  ADD PRIMARY KEY (`id_libur`),
  ADD UNIQUE KEY `hari_libur_tanggal_unique` (`tanggal`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD UNIQUE KEY `kelas_id_user_unique` (`id_user`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `riwayat_akademik`
--
ALTER TABLE `riwayat_akademik`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `riwayat_akademik_id_siswa_foreign` (`id_siswa`),
  ADD KEY `riwayat_akademik_id_kelas_foreign` (`id_kelas`),
  ADD KEY `riwayat_akademik_id_tahun_ajaran_foreign` (`id_tahun_ajaran`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `siswa_nis_unique` (`nis`),
  ADD KEY `siswa_id_tahun_ajaran_foreign` (`id_tahun_ajaran`),
  ADD KEY `siswa_id_kelas_foreign` (`id_kelas`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`id_tahun_ajaran`);

--
-- Indexes for table `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hari_libur`
--
ALTER TABLE `hari_libur`
  MODIFY `id_libur` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `riwayat_akademik`
--
ALTER TABLE `riwayat_akademik`
  MODIFY `id_riwayat` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  MODIFY `id_tahun_ajaran` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  MODIFY `id_pengumuman` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_id_tahun_ajaran_foreign` FOREIGN KEY (`id_tahun_ajaran`) REFERENCES `tahun_ajaran` (`id_tahun_ajaran`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `riwayat_akademik`
--
ALTER TABLE `riwayat_akademik`
  ADD CONSTRAINT `riwayat_akademik_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `riwayat_akademik_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE SET NULL,
  ADD CONSTRAINT `riwayat_akademik_id_tahun_ajaran_foreign` FOREIGN KEY (`id_tahun_ajaran`) REFERENCES `tahun_ajaran` (`id_tahun_ajaran`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `siswa_id_tahun_ajaran_foreign` FOREIGN KEY (`id_tahun_ajaran`) REFERENCES `tahun_ajaran` (`id_tahun_ajaran`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
