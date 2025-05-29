/*
SQLyog Ultimate v8.55 
MySQL - 5.5.5-10.4.32-MariaDB : Database - proyek
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`proyek` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `proyek`;

/*Table structure for table `bphs` */

DROP TABLE IF EXISTS `bphs`;

CREATE TABLE `bphs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `position` varchar(255) NOT NULL,
  `period` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bphs_user_id_foreign` (`user_id`),
  CONSTRAINT `bphs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `local_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `bphs` */

/*Table structure for table `campus_students` */

DROP TABLE IF EXISTS `campus_students`;

CREATE TABLE `campus_students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dim_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `nim` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `prodi_id` bigint(20) unsigned DEFAULT NULL,
  `prodi_name` varchar(255) NOT NULL,
  `fakultas` varchar(255) DEFAULT NULL,
  `angkatan` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Aktif',
  `asrama` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `campus_students_nim_unique` (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `campus_students` */

/*Table structure for table `details` */

DROP TABLE IF EXISTS `details`;

CREATE TABLE `details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `financial_id` bigint(20) unsigned NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `details_financial_id_foreign` (`financial_id`),
  CONSTRAINT `details_financial_id_foreign` FOREIGN KEY (`financial_id`) REFERENCES `financial_records` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `details` */

/*Table structure for table `events` */

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `proker_id` bigint(20) unsigned NOT NULL,
  `proposal_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` enum('draft','scheduled','completed','cancelled') NOT NULL DEFAULT 'draft',
  `notes` text DEFAULT NULL,
  `banner_path` varchar(255) DEFAULT NULL,
  `angkatan_akses` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `events_proker_id_foreign` (`proker_id`),
  KEY `events_proposal_id_foreign` (`proposal_id`),
  CONSTRAINT `events_proker_id_foreign` FOREIGN KEY (`proker_id`) REFERENCES `prokers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `events_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `events` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `financial_records` */

DROP TABLE IF EXISTS `financial_records`;

CREATE TABLE `financial_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jenis` enum('Pemasukan','Pengeluaran') NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `financial_records_created_by_foreign` (`created_by`),
  CONSTRAINT `financial_records_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `local_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `financial_records` */

/*Table structure for table `galeris` */

DROP TABLE IF EXISTS `galeris`;

CREATE TABLE `galeris` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galeris_created_by_foreign` (`created_by`),
  CONSTRAINT `galeris_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `local_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `galeris` */

/*Table structure for table `local_users` */

DROP TABLE IF EXISTS `local_users`;

CREATE TABLE `local_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `angkatan` varchar(255) DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `local_users_username_unique` (`username`),
  UNIQUE KEY `local_users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `local_users` */

insert  into `local_users`(`id`,`username`,`nama`,`nim`,`angkatan`,`prodi`,`email`,`role`,`remember_token`,`password`,`created_at`,`updated_at`) values (3,'if323035','Adriano Rafaelo Lumbantoruan','11323035','2023','DIII Teknologi Informasi','if323035@students.del.ac.id','admin',NULL,'$2y$10$I/grrA9dSJfOgam9niYi8e35BW3H7WigapvIcXGksx1mjUgffeayq','2025-05-29 16:47:07','2025-05-29 16:49:08'),(4,'if323011','if323011',NULL,NULL,NULL,NULL,'admin',NULL,NULL,'2025-05-29 16:49:34','2025-05-29 16:49:34'),(5,'if323033','if323033',NULL,NULL,NULL,NULL,'admin',NULL,NULL,'2025-05-29 16:49:49','2025-05-29 16:49:49');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (18,'2014_10_11_100000_create_local_users_table',1),(19,'2014_10_12_100000_create_password_resets_table',1),(20,'2019_08_19_000000_create_failed_jobs_table',1),(21,'2019_12_14_000001_create_personal_access_tokens_table',1),(22,'2025_04_28_080627_create_payments_table',1),(23,'2025_04_29_071508_create_prokers_table',1),(24,'2025_04_29_085133_create_proposals_table',1),(25,'2025_05_02_160702_create_notifications_table',1),(26,'2025_05_05_081027_create_bphs_table',1),(27,'2025_05_06_074908_create_news_table',1),(28,'2025_05_06_125153_create_tentangs_table',1),(29,'2025_05_08_011025_create_financial_records_table',1),(30,'2025_05_08_012056_create_details_table',1),(31,'2025_05_08_020827_create_galeris_table',1),(32,'2025_05_09_013712_create_events_table',1),(33,'2025_05_10_025805_create_student_registrations_table',1),(34,'2025_05_27_040812_create_campus_students_table',1);

/*Table structure for table `news` */

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'news',
  `content` text NOT NULL,
  `published_at` timestamp NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_created_by_foreign` (`created_by`),
  CONSTRAINT `news_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `local_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `news` */

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_created_by_foreign` (`created_by`),
  CONSTRAINT `notifications_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `local_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `notifications` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nim` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `angkatan` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_nim_bulan_tahun_unique` (`nim`,`bulan`,`tahun`),
  KEY `payments_created_by_foreign` (`created_by`),
  CONSTRAINT `payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `local_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `payments` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `prokers` */

DROP TABLE IF EXISTS `prokers`;

CREATE TABLE `prokers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `objective` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `planned_date` date DEFAULT NULL,
  `actual_date` date DEFAULT NULL,
  `funding_source` varchar(255) DEFAULT NULL,
  `planned_budget` decimal(15,2) DEFAULT NULL,
  `actual_budget` decimal(15,2) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `period` varchar(255) DEFAULT NULL,
  `report_file` varchar(255) DEFAULT NULL,
  `approval_status` enum('pending','approved','rejected') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prokers_created_by_foreign` (`created_by`),
  CONSTRAINT `prokers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `local_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `prokers` */

/*Table structure for table `proposals` */

DROP TABLE IF EXISTS `proposals`;

CREATE TABLE `proposals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `proker_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `sent_at` timestamp NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proposals_proker_id_foreign` (`proker_id`),
  CONSTRAINT `proposals_proker_id_foreign` FOREIGN KEY (`proker_id`) REFERENCES `prokers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `proposals` */

/*Table structure for table `student_registrations` */

DROP TABLE IF EXISTS `student_registrations`;

CREATE TABLE `student_registrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `angkatan` varchar(255) DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL,
  `hadir` tinyint(1) NOT NULL DEFAULT 0,
  `tidak_hadir` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_registrations_event_id_foreign` (`event_id`),
  CONSTRAINT `student_registrations_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `student_registrations` */

/*Table structure for table `tentangs` */

DROP TABLE IF EXISTS `tentangs`;

CREATE TABLE `tentangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `konten` longtext NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tentangs_created_by_foreign` (`created_by`),
  CONSTRAINT `tentangs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `local_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tentangs` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
