-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for almiradb
CREATE DATABASE IF NOT EXISTS `almiradb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `almiradb`;

-- Dumping structure for table almiradb.bookings
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `room_id` bigint unsigned NOT NULL,
  `agenda` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_peserta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `list_kebutuhan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_room_id_foreign` (`room_id`),
  CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.bookings: ~7 rows (approximately)
DELETE FROM `bookings`;
INSERT INTO `bookings` (`id`, `tanggal`, `user_id`, `room_id`, `agenda`, `jumlah_peserta`, `jam`, `jam_selesai`, `list_kebutuhan`, `status`, `created_at`, `updated_at`) VALUES
	(64, '2025-11-15', 3, 1, 'Pelatihan di hari rabu', '100', '07:00:00', '08:00:00', '-', 'approved', '2025-11-14 13:41:41', '2025-11-14 13:42:19'),
	(65, '2025-11-15', 3, 1, 'Pelatihan', '12', '10:00:00', '12:00:00', 'ga ada', 'approved', '2025-11-14 18:37:12', '2025-11-14 18:44:02'),
	(66, '2025-11-15', 3, 1, 'Pelatihan', '12', '12:00:00', '13:00:00', NULL, 'approved', '2025-11-14 18:39:08', '2025-11-14 18:43:58'),
	(67, '2025-11-16', 3, 1, 'tes', '124', '10:00:00', '12:00:00', NULL, 'pending', '2025-11-14 18:46:05', '2025-11-14 18:46:05'),
	(68, '2025-11-17', 3, 3, 'tes', '21', '07:00:00', '08:00:00', NULL, 'approved', '2025-11-14 18:47:41', '2025-11-14 18:48:00'),
	(69, '2025-11-18', 10, 34, 'Rapat Almira', '100', '10:00:00', '11:00:00', 'Pulpen', 'approved', '2025-11-17 05:13:26', '2025-11-17 05:14:05'),
	(70, '2025-11-18', 3, 34, 'Pelatihan', '10', '11:00:00', '13:00:00', NULL, 'approved', '2025-11-17 05:15:46', '2025-11-17 05:15:58');

-- Dumping structure for table almiradb.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.cache: ~8 rows (approximately)
DELETE FROM `cache`;
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('almira-cache-admin@gmail.com|127.0.0.1', 'i:2;', 1762848911),
	('almira-cache-admin@gmail.com|127.0.0.1:timer', 'i:1762848911;', 1762848911),
	('almira-cache-fadhil@gmail.com|127.0.0.1', 'i:2;', 1762851250),
	('almira-cache-fadhil@gmail.com|127.0.0.1:timer', 'i:1762851250;', 1762851250),
	('almira-cache-superuser2@example.com|127.0.0.1', 'i:1;', 1758177555),
	('almira-cache-superuser2@example.com|127.0.0.1:timer', 'i:1758177555;', 1758177555),
	('almira-cache-superuser2@gmail.com|127.0.0.1', 'i:3;', 1758177568),
	('almira-cache-superuser2@gmail.com|127.0.0.1:timer', 'i:1758177568;', 1758177568);

-- Dumping structure for table almiradb.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.cache_locks: ~0 rows (approximately)
DELETE FROM `cache_locks`;

-- Dumping structure for table almiradb.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping structure for table almiradb.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.jobs: ~0 rows (approximately)
DELETE FROM `jobs`;

-- Dumping structure for table almiradb.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.job_batches: ~0 rows (approximately)
DELETE FROM `job_batches`;

-- Dumping structure for table almiradb.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.migrations: ~7 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_08_24_100643_create_rooms_table', 1),
	(5, '2025_08_24_100644_create_bookings_table', 1),
	(6, '2025_08_28_034022_add_tanggal_to_bookings_table', 2),
	(7, '2025_09_15_153825_create_notifications_table', 3);

-- Dumping structure for table almiradb.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.notifications: ~88 rows (approximately)
DELETE FROM `notifications`;
INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `read_at`, `created_at`, `updated_at`) VALUES
	(42, 1, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 1 pada 2025-09-19 (11:01 - 11:11)', '2025-09-18 17:32:40', '2025-09-18 17:09:29', '2025-09-18 17:32:40'),
	(43, 2, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 1 pada 2025-09-19 (11:01 - 11:11)', '2025-09-18 17:34:33', '2025-09-18 17:09:29', '2025-09-18 17:34:33'),
	(44, 1, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 3 pada 2025-09-19 (11:11 - 11:11)', '2025-09-18 17:33:24', '2025-09-18 17:33:12', '2025-09-18 17:33:24'),
	(45, 2, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 3 pada 2025-09-19 (11:11 - 11:11)', '2025-09-18 17:34:33', '2025-09-18 17:33:12', '2025-09-18 17:34:33'),
	(46, 1, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 1 pada 2025-09-19 (08:00 - 09:00)', '2025-09-18 17:41:07', '2025-09-18 17:40:41', '2025-09-18 17:41:07'),
	(47, 2, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 1 pada 2025-09-19 (08:00 - 09:00)', NULL, '2025-09-18 17:40:41', '2025-09-18 17:40:41'),
	(50, 1, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 9 pada 2025-09-19 (01:22 - 22:22)', '2025-09-18 18:02:31', '2025-09-18 18:02:25', '2025-09-18 18:02:31'),
	(51, 2, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 9 pada 2025-09-19 (01:22 - 22:22)', NULL, '2025-09-18 18:02:25', '2025-09-18 18:02:25'),
	(53, 1, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 1 pada 2025-09-26 (12:22 - 23:33)', '2025-09-18 18:57:41', '2025-09-18 18:35:20', '2025-09-18 18:57:41'),
	(54, 2, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 1 pada 2025-09-26 (12:22 - 23:33)', NULL, '2025-09-18 18:35:20', '2025-09-18 18:35:20'),
	(55, 1, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 3 pada 2025-09-20 (11:01 - 11:01)', '2025-09-18 18:57:41', '2025-09-18 18:36:56', '2025-09-18 18:57:41'),
	(56, 2, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 3 pada 2025-09-20 (11:01 - 11:01)', NULL, '2025-09-18 18:36:56', '2025-09-18 18:36:56'),
	(57, 1, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 8 pada 2025-09-26 (12:22 - 03:22)', '2025-09-18 18:57:41', '2025-09-18 18:37:16', '2025-09-18 18:57:41'),
	(58, 2, NULL, 'Pengajuan pinjaman baru oleh OkiAspro untuk ruangan Ruang Rapat 8 pada 2025-09-26 (12:22 - 03:22)', NULL, '2025-09-18 18:37:16', '2025-09-18 18:37:16'),
	(59, 1, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 10 pada 2025-09-30 (23:44 - 04:43)', '2025-09-18 18:57:41', '2025-09-18 18:38:24', '2025-09-18 18:57:41'),
	(60, 2, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 10 pada 2025-09-30 (23:44 - 04:43)', NULL, '2025-09-18 18:38:24', '2025-09-18 18:38:24'),
	(61, 1, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 8 pada 2025-09-23 (23:45 - 03:02)', '2025-09-18 18:57:41', '2025-09-18 18:38:44', '2025-09-18 18:57:41'),
	(62, 2, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 8 pada 2025-09-23 (23:45 - 03:02)', NULL, '2025-09-18 18:38:44', '2025-09-18 18:38:44'),
	(63, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat 10 telah disetujui.', NULL, '2025-09-18 19:06:08', '2025-09-18 19:06:08'),
	(64, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat 8 telah disetujui.', NULL, '2025-09-18 19:06:11', '2025-09-18 19:06:11'),
	(66, 1, NULL, 'Pengajuan pinjaman baru oleh Oki untuk ruangan Ruang Rapat 10 pada 2025-09-19 (14:00 - 15:00)', '2025-09-19 06:42:34', '2025-09-19 06:41:38', '2025-09-19 06:42:34'),
	(67, 2, NULL, 'Pengajuan pinjaman baru oleh Oki untuk ruangan Ruang Rapat 10 pada 2025-09-19 (14:00 - 15:00)', NULL, '2025-09-19 06:41:38', '2025-09-19 06:41:38'),
	(69, 1, NULL, 'Pengajuan pinjaman baru oleh contoh123 untuk ruangan Ruang Rapat 8 pada 2025-09-19 (17:00 - 18:00)', '2025-09-19 07:47:06', '2025-09-19 07:46:27', '2025-09-19 07:47:06'),
	(70, 2, NULL, 'Pengajuan pinjaman baru oleh contoh123 untuk ruangan Ruang Rapat 8 pada 2025-09-19 (17:00 - 18:00)', NULL, '2025-09-19 07:46:27', '2025-09-19 07:46:27'),
	(71, 19, NULL, 'Booking kamu untuk ruangan Ruang Rapat 8 ditolak.', NULL, '2025-09-19 07:48:21', '2025-09-19 07:48:21'),
	(72, 19, NULL, 'Booking kamu untuk ruangan Ruang Rapat 8 telah disetujui.', NULL, '2025-09-19 07:49:05', '2025-09-19 07:49:05'),
	(73, 1, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 1 pada 2025-11-12 (10:00 - 11:00)', '2025-11-11 08:15:48', '2025-11-11 08:13:18', '2025-11-11 08:15:48'),
	(74, 2, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 1 pada 2025-11-12 (10:00 - 11:00)', NULL, '2025-11-11 08:13:18', '2025-11-11 08:13:18'),
	(75, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 1 telah disetujui.', NULL, '2025-11-11 08:16:03', '2025-11-11 08:16:03'),
	(76, 1, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 3 pada 2025-11-13 (12:00 - 13:00)', '2025-11-11 10:08:10', '2025-11-11 08:55:41', '2025-11-11 10:08:10'),
	(77, 2, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 3 pada 2025-11-13 (12:00 - 13:00)', NULL, '2025-11-11 08:55:42', '2025-11-11 08:55:42'),
	(78, 1, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 9 pada 2025-11-11 (11:11 - 11:12)', '2025-11-11 10:08:10', '2025-11-11 09:15:29', '2025-11-11 10:08:10'),
	(79, 2, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 9 pada 2025-11-11 (11:11 - 11:12)', NULL, '2025-11-11 09:15:29', '2025-11-11 09:15:29'),
	(80, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat 9 telah disetujui.', NULL, '2025-11-11 09:16:14', '2025-11-11 09:16:14'),
	(81, 1, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 7 pada 2025-11-11 (22:22 - 22:23)', '2025-11-11 10:08:10', '2025-11-11 09:16:51', '2025-11-11 10:08:10'),
	(82, 2, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 7 pada 2025-11-11 (22:22 - 22:23)', NULL, '2025-11-11 09:16:51', '2025-11-11 09:16:51'),
	(83, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat 7 telah disetujui.', NULL, '2025-11-11 09:17:02', '2025-11-11 09:17:02'),
	(84, 1, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 5 pada 2025-11-11 (03:03 - 03:34)', '2025-11-11 10:08:10', '2025-11-11 09:17:44', '2025-11-11 10:08:10'),
	(85, 2, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat 5 pada 2025-11-11 (03:03 - 03:34)', NULL, '2025-11-11 09:17:44', '2025-11-11 09:17:44'),
	(86, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat 5 telah disetujui.', NULL, '2025-11-11 09:17:53', '2025-11-11 09:17:53'),
	(87, 1, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat Special pada 2025-11-13 (16:00 - 18:00)', '2025-11-11 10:08:10', '2025-11-11 10:07:58', '2025-11-11 10:08:10'),
	(88, 2, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat Special pada 2025-11-13 (16:00 - 18:00)', NULL, '2025-11-11 10:07:58', '2025-11-11 10:07:58'),
	(89, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat Special telah disetujui.', NULL, '2025-11-11 10:08:23', '2025-11-11 10:08:23'),
	(90, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat Special telah disetujui.', NULL, '2025-11-11 18:37:27', '2025-11-11 18:37:27'),
	(91, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat 3 telah disetujui.', NULL, '2025-11-11 18:37:34', '2025-11-11 18:37:34'),
	(92, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 1 telah disetujui.', NULL, '2025-11-11 18:45:56', '2025-11-11 18:45:56'),
	(93, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 1 telah disetujui.', NULL, '2025-11-11 18:51:23', '2025-11-11 18:51:23'),
	(94, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 1 telah disetujui.', NULL, '2025-11-11 18:58:15', '2025-11-11 18:58:15'),
	(95, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 1 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-11 19:13:19', '2025-11-11 19:13:19'),
	(96, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 1 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-11 19:26:05', '2025-11-11 19:26:05'),
	(97, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 1 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-11 19:31:43', '2025-11-11 19:31:43'),
	(98, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat 5 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-11 19:32:57', '2025-11-11 19:32:57'),
	(99, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat 7 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-11 19:33:02', '2025-11-11 19:33:02'),
	(100, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat 9 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-11 19:33:06', '2025-11-11 19:33:06'),
	(101, 1, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 8 pada 2025-11-15 (10:10 - 12:12)', '2025-11-14 10:00:19', '2025-11-14 09:59:58', '2025-11-14 10:00:19'),
	(102, 2, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 8 pada 2025-11-15 (10:10 - 12:12)', NULL, '2025-11-14 09:59:58', '2025-11-14 09:59:58'),
	(103, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 8 ditolak.', NULL, '2025-11-14 10:00:50', '2025-11-14 10:00:50'),
	(104, 1, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 3 pada 2025-11-16 (22:22 - 23:23)', '2025-11-14 10:02:09', '2025-11-14 10:02:00', '2025-11-14 10:02:09'),
	(105, 2, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 3 pada 2025-11-16 (22:22 - 23:23)', NULL, '2025-11-14 10:02:00', '2025-11-14 10:02:00'),
	(106, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 3 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-14 10:02:21', '2025-11-14 10:02:21'),
	(107, 1, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat Special pada 2025-11-15 (10:00 - 11:11)', '2025-11-14 10:08:40', '2025-11-14 10:06:28', '2025-11-14 10:08:40'),
	(108, 2, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat Special pada 2025-11-15 (10:00 - 11:11)', NULL, '2025-11-14 10:06:28', '2025-11-14 10:06:28'),
	(109, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat Special telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-14 10:07:25', '2025-11-14 10:07:25'),
	(110, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat Special telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-14 10:07:54', '2025-11-14 10:07:54'),
	(111, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat 3 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-14 10:08:03', '2025-11-14 10:08:03'),
	(112, 19, NULL, 'Booking kamu untuk ruangan Ruang Rapat 8 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-14 10:08:09', '2025-11-14 10:08:09'),
	(113, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat 8 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-14 10:08:15', '2025-11-14 10:08:15'),
	(114, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat Special telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-14 10:08:19', '2025-11-14 10:08:19'),
	(115, 1, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 1 pada 2025-11-15 (07:00 - 08:00)', '2025-11-14 13:41:49', '2025-11-14 13:41:41', '2025-11-14 13:41:49'),
	(116, 2, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 1 pada 2025-11-15 (07:00 - 08:00)', NULL, '2025-11-14 13:41:41', '2025-11-14 13:41:41'),
	(117, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 1 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-14 13:42:19', '2025-11-14 13:42:19'),
	(118, 1, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 1 pada 2025-11-15 (10:00 - 12:00)', '2025-11-14 18:42:56', '2025-11-14 18:37:12', '2025-11-14 18:42:56'),
	(119, 2, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 1 pada 2025-11-15 (10:00 - 12:00)', NULL, '2025-11-14 18:37:12', '2025-11-14 18:37:12'),
	(120, 1, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 1 pada 2025-11-15 (12:00 - 13:00)', '2025-11-14 18:42:56', '2025-11-14 18:39:08', '2025-11-14 18:42:56'),
	(121, 2, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 1 pada 2025-11-15 (12:00 - 13:00)', NULL, '2025-11-14 18:39:08', '2025-11-14 18:39:08'),
	(122, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 1 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-14 18:43:58', '2025-11-14 18:43:58'),
	(123, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 1 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-14 18:44:02', '2025-11-14 18:44:02'),
	(124, 1, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 1 pada 2025-11-16 (10:00 - 12:00)', '2025-11-14 18:54:11', '2025-11-14 18:46:05', '2025-11-14 18:54:11'),
	(125, 2, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 1 pada 2025-11-16 (10:00 - 12:00)', NULL, '2025-11-14 18:46:05', '2025-11-14 18:46:05'),
	(126, 1, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 2 pada 2025-11-17 (07:00 - 08:00)', '2025-11-14 18:54:11', '2025-11-14 18:47:41', '2025-11-14 18:54:11'),
	(127, 2, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat 2 pada 2025-11-17 (07:00 - 08:00)', NULL, '2025-11-14 18:47:41', '2025-11-14 18:47:41'),
	(128, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat 2 telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-14 18:48:00', '2025-11-14 18:48:00'),
	(129, 1, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat Special pada 2025-11-18 (10:00 - 11:00)', '2025-11-17 05:13:37', '2025-11-17 05:13:26', '2025-11-17 05:13:37'),
	(130, 2, NULL, 'Pengajuan pinjaman baru oleh Fadhil Teguh Amara untuk ruangan Ruang Rapat Special pada 2025-11-18 (10:00 - 11:00)', NULL, '2025-11-17 05:13:26', '2025-11-17 05:13:26'),
	(131, 10, NULL, 'Booking kamu untuk ruangan Ruang Rapat Special telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-17 05:14:05', '2025-11-17 05:14:05'),
	(132, 1, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat Special pada 2025-11-18 (11:00 - 13:00)', '2025-11-17 05:16:01', '2025-11-17 05:15:46', '2025-11-17 05:16:01'),
	(133, 2, NULL, 'Pengajuan pinjaman baru oleh Test User untuk ruangan Ruang Rapat Special pada 2025-11-18 (11:00 - 13:00)', NULL, '2025-11-17 05:15:46', '2025-11-17 05:15:46'),
	(134, 3, NULL, 'Booking kamu untuk ruangan Ruang Rapat Special telah disetujui dan ruangan kini berstatus \'booked\'.', NULL, '2025-11-17 05:15:58', '2025-11-17 05:15:58');

-- Dumping structure for table almiradb.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping structure for table almiradb.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lantai` int DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('tersedia','booked') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'tersedia',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.rooms: ~10 rows (approximately)
DELETE FROM `rooms`;
INSERT INTO `rooms` (`id`, `nama`, `lantai`, `deskripsi`, `created_at`, `updated_at`, `status`) VALUES
	(1, 'Ruang Rapat 1', 1, 'Ac,TV 32",Meja kursi 40 org', '2025-09-02 15:01:38', '2025-11-17 05:10:03', 'tersedia'),
	(3, 'Ruang Rapat 2', 2, 'Kapasitas 40 orang, whiteboard dan AC', '2025-08-26 21:16:14', '2025-11-17 05:10:03', 'tersedia'),
	(4, 'Ruang Rapat 3', 3, 'Kapasitas 20 orang, dilengkapi proyektor dan AC', '2025-08-27 19:31:46', '2025-11-14 12:45:02', 'tersedia'),
	(5, 'Ruang Rapat 4', 4, 'Kapasitas 100 orang, dilengkapi sound system dan kursi lipat', '2025-08-27 19:31:46', '2025-09-02 22:51:26', 'tersedia'),
	(6, 'Ruang Rapat 5', 55, 'Kapasitas 40 orang, whiteboard dan AC', '2025-08-27 19:31:46', '2025-11-11 19:40:01', 'tersedia'),
	(24, 'Ruang Rapat 6', 6, '100 orang kapasitas', '2025-09-02 22:30:39', '2025-09-02 22:52:16', 'tersedia'),
	(29, 'Ruang Rapat 7', 777, 'Deskripsi ke 777', '2025-09-14 10:48:01', '2025-11-11 19:33:02', 'tersedia'),
	(30, 'Ruang Rapat 8', 8, 'tes', '2025-09-17 17:53:00', '2025-11-14 12:45:02', 'tersedia'),
	(33, 'Ruang Rapat 9', 9, '99', '2025-09-17 17:53:56', '2025-11-12 04:15:02', 'tersedia'),
	(34, 'Ruang Rapat Special', 10, '10', '2025-09-17 17:54:08', '2025-11-17 05:14:05', 'booked');

-- Dumping structure for table almiradb.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.sessions: ~3 rows (approximately)
DELETE FROM `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('1xoctWvOWCumpffhx34TOZMHsbmoCkxmbAE277rn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM3EwT2JPSFZLSzBTTHhqcWNqbjFWVHk0UDY5UHZmVndSWVRvS1k0RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9ub3RpZmljYXRpb25zL2xhdGVzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1763357143),
	('8IJjqefxAgI309BjllQpCD5r4aTnXnpPZd6HUeLt', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS01ZY3I0dXNTZXJxVlpZeGRyUGFSVWZwVjlsNjlDZTE2Q2t2U0JDSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1763356946),
	('9kdPwnn7fZ2Nlt0HohNPeUJcFEo4uv2CKAI3ZAIW', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSGJxSUVTckhGWW1DMzYzN2x2b1VtZHRMNmQ5WVpFU2Zhd2xiaE41RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMDt9', 1763356617);

-- Dumping structure for table almiradb.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Pertamina Call Center 135','IBC Telkomsel','Ecare','Prodia','Prodia CC','CES','C4','CC 184 Fixed','SSO Trainer','Grapari','OBC','QC IBC','CC OPS 1','BYU','Garuda','Tenesa','BJB','admin','user','Telkomsel','Pertamina','ITCC','FAM') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table almiradb.users: ~8 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin User', 'admin@example.com', '$2y$12$e97ePSqhfoTZ3rArmUeHUuN7evmXotEgHL.jd5iLGhhjjGkrTcUKW', 'admin', NULL, NULL, '2025-08-26 21:16:13', '2025-08-26 21:16:13'),
	(2, 'Admin1', 'admin1@example.com', '$2y$12$Inb6Zz8WIEF.CXfYu2eGJuMYdkcX2GUPMQnEF6AuQLOAsYtNuQIWy', 'admin', NULL, NULL, '2025-08-29 13:33:57', '2025-08-28 23:46:18'),
	(3, 'Test User', 'test@example.com', '$2y$12$z87H9d2SZL.kP4jzl0WFU.hCfd1gGLR9G3r/p.nAL6VQbvpAFBTd6', 'ITCC', NULL, NULL, '2025-08-26 21:16:14', '2025-08-26 21:16:14'),
	(4, 'User1', 'User1@example.com', '$2y$12$tAMaPExo/uylkzYytPD3TeEIak.O9qxsTinm3mg21a1UhViBi0O4.', 'Telkomsel', NULL, NULL, '2025-08-27 19:31:46', '2025-08-27 19:31:46'),
	(10, 'Fadhil Teguh Amara', 'Fadhildj.ta@gmail.com', '$2y$12$hsEeydFBV3JSOrA/8.6rQ.kd8olRi3OVUEAEPp5YVpXV6erlCmfXS', 'Telkomsel', NULL, NULL, '2025-09-18 06:40:32', '2025-09-18 07:37:34'),
	(16, 'TES ROLE', '1233333@gmail.com', '$2y$12$F2JcQmBfwIwnOqZZONIepOvsMNVpuJnXOODdY/27ASjdIqPHgZyn2', 'Pertamina', NULL, NULL, '2025-09-19 03:52:29', '2025-09-19 03:52:29'),
	(17, 'Fadhil', 'fadhil@gmail.com', '$2y$12$kXIjECILi8JKVyEdaASpSur3trvgUDwxQPhDz5wEBBZCnnVzTQbM6', 'user', NULL, NULL, '2025-09-19 05:22:40', '2025-09-19 06:16:00'),
	(19, 'contoh123', 'contoh@gmail.com', '$2y$12$Uy2npmah4gr...utq/qGaesHpSD0jsCMfu3cXt3Kr9pZ6kyPfRaPi', 'C4', NULL, NULL, '2025-09-19 07:43:08', '2025-09-19 07:43:38');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
