-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: snpos
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,1,'SURABAYA',1,'2025-07-28 08:05:35','2025-07-28 13:49:11'),(2,1,'SIDOARJO',1,'2025-07-28 08:11:46','2025-07-28 08:11:46'),(3,1,'GRESIK',1,'2025-07-28 08:11:54','2025-07-28 08:11:54');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `check_in_time` timestamp NULL DEFAULT NULL,
  `check_out_time` timestamp NULL DEFAULT NULL,
  `check_in_picture` varchar(255) DEFAULT NULL,
  `check_out_picture` varchar(255) DEFAULT NULL,
  `check_in_latitude` double DEFAULT NULL,
  `check_out_latitude` double DEFAULT NULL,
  `check_in_longitude` double DEFAULT NULL,
  `check_out_longitude` double DEFAULT NULL,
  `kwh_start` double DEFAULT NULL,
  `kwh_end` double DEFAULT NULL,
  `check_in_location` text DEFAULT NULL,
  `check_out_location` text DEFAULT NULL,
  `overtime_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
INSERT INTO `attendances` VALUES (1,3,1,'2025-08-09 04:03:02',NULL,'attendance_photos/1_20250809_110301.jpg',NULL,37.4219983,NULL,-122.084,NULL,NULL,NULL,'Google Building 43, Mountain View, California, United States',NULL,NULL,'2025-08-09 04:03:01','2025-08-09 04:03:02'),(2,3,3,'2025-08-10 06:24:16',NULL,'attendance_photos/2_20250810_132415.jpg',NULL,37.4219983,NULL,-122.084,NULL,NULL,NULL,'Google Building 43, Mountain View, California, United States',NULL,NULL,'2025-08-10 06:24:15','2025-08-10 06:24:16'),(3,3,5,'2025-08-11 08:05:54','2025-08-11 08:05:54','attendance_photos/3_20250811_081638.jpg','attendance_photos/3_20250811_150554.jpg',37.4219983,37.4219983,-122.084,-122.084,NULL,NULL,'Google Building 43, Mountain View, California, United States','Google Building 43, Mountain View, California, United States',NULL,'2025-08-11 01:16:38','2025-08-11 08:05:54'),(4,3,7,'2025-08-12 07:44:08','2025-08-12 12:46:50','attendance_photos/4_20250812_072754.jpg','attendance_photos/4_20250812_194650.jpg',37.4219983,37.4219983,-122.084,-122.084,NULL,NULL,'Google Building 43, Mountain View, California, United States','Google Building 43, Mountain View, California, United States',NULL,'2025-08-12 00:27:54','2025-08-12 12:46:50'),(5,3,9,'2025-08-13 15:18:42',NULL,'attendance_photos/5_20250813_221842.jpg',NULL,-7.3639912,NULL,112.7392208,NULL,NULL,NULL,'JPPQ+CRM, Kecamatan Gedangan, Jawa Timur, Indonesia',NULL,NULL,'2025-08-13 15:18:42','2025-08-13 15:18:42'),(6,3,11,'2025-08-14 08:20:47',NULL,'attendance_photos/6_20250814_152047.jpg',NULL,37.4219983,NULL,-122.084,NULL,NULL,NULL,'Google Building 43, Mountain View, California, United States',NULL,NULL,'2025-08-14 08:20:47','2025-08-14 08:20:48');
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cash_units`
--

DROP TABLE IF EXISTS `cash_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cash_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cash_units`
--

LOCK TABLES `cash_units` WRITE;
/*!40000 ALTER TABLE `cash_units` DISABLE KEYS */;
INSERT INTO `cash_units` VALUES (1,5000),(2,10000),(3,20000),(4,50000);
/*!40000 ALTER TABLE `cash_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deposits`
--

DROP TABLE IF EXISTS `deposits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deposits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deposits`
--

LOCK TABLES `deposits` WRITE;
/*!40000 ALTER TABLE `deposits` DISABLE KEYS */;
INSERT INTO `deposits` VALUES (5,3,69000,'anjayyy','2025-08-12 07:31:26','2025-08-12 07:31:26'),(6,3,10000,'dgdgsg','2025-08-12 16:00:01','2025-08-12 16:00:01');
/*!40000 ALTER TABLE `deposits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `levels`
--

DROP TABLE IF EXISTS `levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `levels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `levels`
--

LOCK TABLES `levels` WRITE;
/*!40000 ALTER TABLE `levels` DISABLE KEYS */;
INSERT INTO `levels` VALUES (1,'Super User',1,'2025-07-28 12:55:05','2025-07-28 12:55:05'),(2,'Owner',1,'2025-07-28 12:55:05','2025-07-28 12:55:05'),(3,'HRD',1,'2025-07-28 12:55:05','2025-07-28 12:55:05'),(4,'Finance',1,'2025-07-28 12:55:05','2025-07-28 12:55:05'),(5,'Technician',1,'2025-07-28 12:55:05','2025-07-28 12:55:05'),(6,'Operator',1,'2025-07-28 12:55:05','2025-07-28 12:55:05');
/*!40000 ALTER TABLE `levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_07_25_022135_create_levels_table',1),(5,'2025_07_25_022156_create_modules_table',1),(6,'2025_07_25_023403_create_module_levels_table',1),(7,'2025_07_26_074351_create_shifts_table',1),(8,'2025_07_28_014522_create_outlets_table',1),(9,'2025_07_28_014530_create_areas_table',1),(10,'2025_07_28_014659_create_schedules_table',1),(11,'2025_07_28_014706_create_attendances_table',1),(12,'2025_07_28_014804_create_smart_nitros_table',1),(13,'2025_07_28_014848_create_transactions_table',1),(14,'2025_07_28_014854_create_transaction_items_table',1),(15,'2025_07_28_015914_create_products_table',1),(16,'2025_07_28_021024_create_product_outlets_table',1),(17,'2025_07_28_021141_create_smart_nitro_transactions_table',1),(18,'2025_07_28_022243_create_deposits_table',1),(19,'2025_07_30_081933_create_personal_access_tokens_table',1),(20,'2025_08_09_094039_create_payments_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_levels`
--

DROP TABLE IF EXISTS `module_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_levels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_levels`
--

LOCK TABLES `module_levels` WRITE;
/*!40000 ALTER TABLE `module_levels` DISABLE KEYS */;
/*!40000 ALTER TABLE `module_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ordinal` tinyint(3) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent` int(10) unsigned NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'D',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,4,'User & Roles',0,'/userroles','fas fa-user','D','2025-07-28 06:34:32','2025-07-28 07:34:16'),(2,1,'Users',1,'/userroles/users',NULL,'D','2025-07-28 06:34:32','2025-07-28 07:34:22'),(3,2,'Levels',1,'/userroles/levels',NULL,'D','2025-07-28 06:34:32','2025-07-28 07:34:27'),(4,3,'Modules',1,'/userroles/modules',NULL,'D','2025-07-28 06:34:32','2025-07-28 07:34:34'),(5,3,'Absensi',0,'/attendances','fas fa-user-check','A','2025-07-28 06:35:17','2025-07-28 06:38:50'),(6,1,'Master',0,'/master','fas fa-database','A','2025-07-28 06:36:19','2025-07-28 07:25:31'),(7,1,'Area',6,'/master/area',NULL,'A','2025-07-28 06:36:39','2025-07-28 06:36:39'),(8,2,'Outlet',6,'/master/outlet',NULL,'A','2025-07-28 06:37:05','2025-07-28 06:37:05'),(9,3,'Smart Nitro',6,'/master/smartnitro',NULL,'A','2025-07-28 06:42:03','2025-07-28 06:42:03'),(10,4,'Shift',6,'/master/shift',NULL,'A','2025-07-28 06:42:32','2025-07-28 06:42:32'),(11,2,'Penjadwalan',0,'/schedule','fas fa-calendar-alt','A','2025-07-28 06:43:26','2025-07-28 06:43:26'),(12,5,'Produk',6,'/master/products',NULL,'A','2025-08-09 03:22:24','2025-08-09 03:22:24'),(13,6,'Payment',6,'/master/payments',NULL,'A','2025-08-09 03:29:51','2025-08-09 03:29:51'),(14,5,'Lembur',0,'/overtime','fas fa-clock','A','2025-08-15 09:07:45','2025-08-15 09:07:45');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `outlets`
--

DROP TABLE IF EXISTS `outlets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `outlets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `area_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outlets`
--

LOCK TABLES `outlets` WRITE;
/*!40000 ALTER TABLE `outlets` DISABLE KEYS */;
INSERT INTO `outlets` VALUES (1,1,'KETINTANG','Jalan Ketintang Madya',1,-7.311411,112.724059,'2025-07-28 12:57:00','2025-07-28 13:49:51'),(2,2,'TROPODO',NULL,1,-7.368702,112.763632,'2025-07-29 01:21:29','2025-07-29 01:21:29');
/*!40000 ALTER TABLE `outlets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `overtimes`
--

DROP TABLE IF EXISTS `overtimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `overtimes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_by` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `overtimes`
--

LOCK TABLES `overtimes` WRITE;
/*!40000 ALTER TABLE `overtimes` DISABLE KEYS */;
INSERT INTO `overtimes` VALUES (2,3,3,1,'2025-08-15',NULL,'A','06:00:00','14:00:00');
/*!40000 ALTER TABLE `overtimes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_fully_paid` tinyint(1) NOT NULL DEFAULT 0,
  `is_need_picture` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,'Cash/Tunai',0,0,1,'2025-08-09 03:34:24','2025-08-09 03:34:24'),(2,'QRIS',1,1,1,'2025-08-09 03:35:21','2025-08-09 03:42:38');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',3,'api-token','40e7f0c2ef9c1868fc30e67886b9560baf239f4fe4b4e383d530526fb5113c2f','[\"*\"]','2025-08-09 08:13:42',NULL,'2025-08-09 04:02:08','2025-08-09 08:13:42'),(2,'App\\Models\\User',3,'api-token','ed921536a8ddd23b2af89b68f6a4e27b9a0594efcb692a2d88389f926988b662','[\"*\"]','2025-08-09 08:14:42',NULL,'2025-08-09 08:14:41','2025-08-09 08:14:42'),(3,'App\\Models\\User',3,'api-token','4daf0ecc4dc196bf6e4928bdd39114f3c1094679a294539a5674ab4a4727ec78','[\"*\"]','2025-08-09 08:19:47',NULL,'2025-08-09 08:15:51','2025-08-09 08:19:47'),(4,'App\\Models\\User',3,'api-token','49ede1a2f9b7391d86e41b2965c3263227adf2573499a28ef3700172e5eb35e0','[\"*\"]','2025-08-11 01:17:23',NULL,'2025-08-10 06:23:53','2025-08-11 01:17:23'),(5,'App\\Models\\User',3,'api-token','cc4079788d5d9228e33e4ae33e7b51196bdea203f42c1c866383161cc9bab8fc','[\"*\"]','2025-08-11 01:18:13',NULL,'2025-08-11 01:18:13','2025-08-11 01:18:13'),(6,'App\\Models\\User',3,'api-token','07dd7183df9727dea7f11112c2ed25bb02853fc4b5d40301305d8adacc328ad6','[\"*\"]','2025-08-11 01:23:56',NULL,'2025-08-11 01:20:02','2025-08-11 01:23:56'),(7,'App\\Models\\User',3,'api-token','7024182f3ff496da3fda49c0281f8897c840362209e5a787eb4175a464f4a0d0','[\"*\"]','2025-08-11 04:41:33',NULL,'2025-08-11 01:29:13','2025-08-11 04:41:33'),(8,'App\\Models\\User',3,'api-token','93994d099774fb4694bbf4e5a56224feebb8ca956364ab5adc247421089965bc','[\"*\"]','2025-08-11 06:28:38',NULL,'2025-08-11 06:28:37','2025-08-11 06:28:38'),(9,'App\\Models\\User',3,'api-token','aaa7438ab084d6cdf6b50e9d1ee7b9355d3f0178644d44fdb0313223bc39b9bd','[\"*\"]','2025-08-11 06:29:03',NULL,'2025-08-11 06:29:03','2025-08-11 06:29:03'),(10,'App\\Models\\User',3,'api-token','df05fe112d9c48dfb9391107853f5a5fde12fb9d47cec6c1239676e907e2f39e','[\"*\"]','2025-08-11 16:48:12',NULL,'2025-08-11 06:30:02','2025-08-11 16:48:12'),(11,'App\\Models\\User',3,'api-token','e069b2110b84221b82dc03d7ad72a5bb325821ce511567bc49ef89e67c98f65e','[\"*\"]','2025-08-15 09:02:01',NULL,'2025-08-12 00:27:33','2025-08-15 09:02:01'),(12,'App\\Models\\User',3,'api-token','edbef276684b350f1ea5aa96112992a00ca6dc9b30577d2bc65f8d3a6e69cb16','[\"*\"]','2025-08-13 15:29:20',NULL,'2025-08-12 15:45:03','2025-08-13 15:29:20'),(13,'App\\Models\\User',3,'api-token','64f19f6b0c64367b43eba50c917dd0d1aea40868221e812b706fda86d5d3bcb1','[\"*\"]','2025-08-13 15:54:38',NULL,'2025-08-13 15:40:13','2025-08-13 15:54:38'),(14,'App\\Models\\User',3,'api-token','60a094c3f42681f943463c659ca223abc6ff3f3577f598ca6010e9425a388c21','[\"*\"]','2025-08-13 16:41:13',NULL,'2025-08-13 15:55:51','2025-08-13 16:41:13');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_outlets`
--

DROP TABLE IF EXISTS `product_outlets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_outlets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `outlet_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_outlets`
--

LOCK TABLES `product_outlets` WRITE;
/*!40000 ALTER TABLE `product_outlets` DISABLE KEYS */;
INSERT INTO `product_outlets` VALUES (1,1,1,3000,1,'2025-08-09 03:27:59','2025-08-09 03:27:59'),(2,1,2,5000,1,'2025-08-09 03:28:03','2025-08-09 03:28:03'),(3,1,3,5000,1,'2025-08-09 03:28:07','2025-08-09 03:28:07'),(4,1,4,10000,1,'2025-08-09 03:28:11','2025-08-09 03:28:11'),(5,1,13,15000,1,'2025-08-09 03:28:17','2025-08-09 03:28:17'),(6,1,14,30000,1,'2025-08-09 03:28:21','2025-08-09 03:28:21');
/*!40000 ALTER TABLE `product_outlets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `default_price` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `mandatory` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Tambah Angin Motor',3000,1,1,'2025-08-09 03:22:34','2025-08-09 03:22:34'),(2,'Tambah Angin Mobil',5000,1,1,'2025-08-09 03:23:20','2025-08-09 03:23:20'),(3,'Isi Baru Motor',5000,1,1,'2025-08-09 03:23:36','2025-08-09 03:23:36'),(4,'Isi Baru Mobil',10000,1,1,'2025-08-09 03:23:48','2025-08-09 03:23:48'),(5,'Kurang Angin Motor',0,1,1,'2025-08-09 03:24:14','2025-08-09 03:24:14'),(6,'Kurang Angin Mobil',0,1,1,'2025-08-09 03:24:23','2025-08-09 03:24:23'),(7,'Pas Motor',0,1,1,'2025-08-09 03:24:52','2025-08-09 03:24:52'),(8,'Pas Mobil',0,1,1,'2025-08-09 03:24:59','2025-08-09 03:24:59'),(9,'Error Motor',0,1,1,'2025-08-09 03:25:16','2025-08-09 03:25:16'),(10,'Error Mobil',0,1,1,'2025-08-09 03:25:24','2025-08-09 03:25:24'),(11,'Pause Motor',0,1,1,'2025-08-09 03:25:42','2025-08-09 03:25:42'),(12,'Pause Mobil',0,1,1,'2025-08-09 03:25:50','2025-08-09 03:25:50'),(13,'Tambal Ban Motor',15000,1,1,'2025-08-09 03:26:33','2025-08-09 03:26:33'),(14,'Tambal Ban Mobil',30000,1,1,'2025-08-09 03:26:47','2025-08-09 03:26:47');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `is_checked` tinyint(1) NOT NULL DEFAULT 0,
  `is_late` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (1,3,1,1,'2025-08-09',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(2,2,1,2,'2025-08-09',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(3,3,1,1,'2025-08-10',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(4,2,1,2,'2025-08-10',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(5,3,1,1,'2025-08-11',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(6,2,1,2,'2025-08-11',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(7,3,1,1,'2025-08-12',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(8,2,1,2,'2025-08-12',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(9,3,1,1,'2025-08-13',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(10,2,1,2,'2025-08-13',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(11,3,1,1,'2025-08-14',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(12,2,1,2,'2025-08-14',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(13,3,1,1,'2025-08-15',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20'),(14,2,1,2,'2025-08-15',0,0,'2025-08-09 04:00:20','2025-08-09 04:00:20');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('1qNziwMRMO8T97DlhlUjoC5i7K9ErpYA018StcnT',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM2g2NUFHWmdvbDhzSzM4SWo0Vm41TTJ5MGZ5c1NSV2JYbjFCZVoydyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cDovL2ZpdC12YWd1ZWx5LXNsb3RoLm5ncm9rLWZyZWUuYXBwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly9maXQtdmFndWVseS1zbG90aC5uZ3Jvay1mcmVlLmFwcC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1755135993),('ciTzcPM47MEHDBfNkfmcduojbPb0ri3SuDqsRBvf',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVHc0cUlrZ2paRks4U2Y0Qm5Balc5bkQzY2ZBalVZVEw3aXVHRGpSTiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1755312140),('Cp2QpPC2aev0gA6GKLlXrxTRFFMt66zaIpswJ81G',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT2VMeGFKRnpQS2RBYWpNNjZpRUJ0aTBiWXBFZXhnMmk3ZGVUWlFveCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1755011175),('EsqGHFeU8Uej16V25jwA8pBb8cyALf0gGt6hKVrV',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidUxEdXhGNkxXYnRhdXFVVkRrOUg2dUVHTThndjJmYjFRTFNETFpNYyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1755312130),('g8v3POCyenfAkK4CoxZbdbhJuKvKDD1AQmQuud69',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS3FlOVhYakVwbEkzbE1xWlAzNkJQZnNyQzU4NHdlYndIVkxmN2JJNSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1755011311),('hfMAizHqEv1Sw7RDo0QUP1EjiPxYnqC2LxY2Pahp',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiakhvRTh1czV4VUZCekJiUlR1ZXA1dkJxclBmMkZpMFA5YjFvYWpOZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cDovL2ZpdC12YWd1ZWx5LXNsb3RoLm5ncm9rLWZyZWUuYXBwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly9maXQtdmFndWVseS1zbG90aC5uZ3Jvay1mcmVlLmFwcC91c2Vycm9sZXMvbW9kdWxlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1755248866),('JGxj1cKKwSvEMQbCjNtBcWLGS6MYqFOAFmEyqmWt',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTVM3YWgySERESWZOM0IxV2kxcTk3N2tMSkkzY1daTFFoQlZMWjZFbiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxNjoiaHR0cDovL2xvY2FsaG9zdCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjIyOiJodHRwOi8vbG9jYWxob3N0L2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1755011423),('lo0WN67kWYfbSWgRyebCdMcOPR8jbEjCe9THsNWR',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS0txWUU1V0dkZlZQWEtlUTVJMDRKNWt0eFVYNlVzVlgyM0ZJdFZtTyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1754807015),('MpiqJndn6HifzDgTZVSrXPj59TmYOxC7Vrj1O2zc',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoidGQydXI5SHVqVDcyQWtET01YZkFteUhzV1FVWVV1a0FhNEdqZFBYUCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cDovL2ZpdC12YWd1ZWx5LXNsb3RoLm5ncm9rLWZyZWUuYXBwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9maXQtdmFndWVseS1zbG90aC5uZ3Jvay1mcmVlLmFwcCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1755312174),('p2tRU96nz6hixvxZftUPsUr1cotuBQ6V3gPVDllX',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZTRrWlBqcGtkOUZBVW9XS3RxUHh0WkU1SXZ3ZFY4V2FIUFo3cnJJMSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cDovL2ZpdC12YWd1ZWx5LXNsb3RoLm5ncm9rLWZyZWUuYXBwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly9maXQtdmFndWVseS1zbG90aC5uZ3Jvay1mcmVlLmFwcC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1755013412),('POCNLpc72xV94sfYSDsGJ1DS4yjYtCTkVygiGnfk',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOGV4OWxPdTBLVWNGU3QzZjdCbU50d3NlNkhoYURTNjh6OEdyU2hmbyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL21hc3Rlci9wcm9kdWN0cyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbWFzdGVyL3BheW1lbnRzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1754714440);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shifts`
--

DROP TABLE IF EXISTS `shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shifts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shifts`
--

LOCK TABLES `shifts` WRITE;
/*!40000 ALTER TABLE `shifts` DISABLE KEYS */;
INSERT INTO `shifts` VALUES (1,'Shift 1','06:00:00','14:00:00','2025-07-29 02:37:49','2025-07-29 02:37:49'),(2,'Shift 2','14:00:00','22:00:00','2025-07-29 02:39:48','2025-07-29 02:39:48'),(3,'Shift 3','16:00:00','22:00:00','2025-07-29 02:42:39','2025-07-29 02:45:12');
/*!40000 ALTER TABLE `shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shortcut_remarks`
--

DROP TABLE IF EXISTS `shortcut_remarks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shortcut_remarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shortcut_remarks`
--

LOCK TABLES `shortcut_remarks` WRITE;
/*!40000 ALTER TABLE `shortcut_remarks` DISABLE KEYS */;
INSERT INTO `shortcut_remarks` VALUES (1,'Ban Depan','Mobile'),(2,'Ban Belakang','Mobile'),(3,'Ban Depan & Belakang','Mobile'),(4,'Ban Depan Kanan','Mobile'),(5,'Ban Depan Kiri','Mobile'),(6,'Ban Belakang Kanan','Mobile'),(7,'Ban Belakang Kiri','Mobile'),(8,'Ban Serep','Mobile');
/*!40000 ALTER TABLE `shortcut_remarks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `smart_nitro_transactions`
--

DROP TABLE IF EXISTS `smart_nitro_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `smart_nitro_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `smart_nitro_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `type_data` int(11) NOT NULL,
  `data_1` int(11) NOT NULL,
  `data_2` int(11) NOT NULL,
  `data_3` int(11) NOT NULL,
  `data_4` int(11) NOT NULL,
  `data_5` int(11) NOT NULL,
  `data_6` int(11) NOT NULL,
  `data_7` int(11) NOT NULL,
  `data_8` int(11) NOT NULL,
  `data_9` int(11) NOT NULL,
  `data_10` int(11) NOT NULL,
  `data_11` int(11) NOT NULL,
  `data_12` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `smart_nitro_transactions`
--

LOCK TABLES `smart_nitro_transactions` WRITE;
/*!40000 ALTER TABLE `smart_nitro_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `smart_nitro_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `smart_nitros`
--

DROP TABLE IF EXISTS `smart_nitros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `smart_nitros` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `outlet_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=344 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `smart_nitros`
--

LOCK TABLES `smart_nitros` WRITE;
/*!40000 ALTER TABLE `smart_nitros` DISABLE KEYS */;
INSERT INTO `smart_nitros` VALUES (343,1,'2025-07-29 01:41:02','2025-07-29 01:49:05');
/*!40000 ALTER TABLE `smart_nitros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_items`
--

DROP TABLE IF EXISTS `transaction_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_id` varchar(255) NOT NULL,
  `ordinal` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_items`
--

LOCK TABLES `transaction_items` WRITE;
/*!40000 ALTER TABLE `transaction_items` DISABLE KEYS */;
INSERT INTO `transaction_items` VALUES (5,'TRX-20250811133237',1,1,1,3000,'2025-08-11 06:32:48','2025-08-11 06:32:48'),(6,'TRX-20250811133237',2,1,1,3000,'2025-08-11 06:32:48','2025-08-11 06:32:48'),(7,'TRX-3-20250811134429',1,1,1,3000,'2025-08-11 06:44:39','2025-08-11 06:44:39'),(8,'TRX-3-20250811134429',2,1,1,3000,'2025-08-11 06:44:39','2025-08-11 06:44:39'),(9,'TRX-3-20250811145827',1,1,1,3000,'2025-08-11 07:58:32','2025-08-11 07:58:32'),(10,'TRX-3-20250811145827',2,1,1,3000,'2025-08-11 07:58:32','2025-08-11 07:58:32'),(11,'TRX-3-20250811145850',1,2,1,5000,'2025-08-11 07:58:54','2025-08-11 07:58:54'),(12,'TRX-3-20250811145850',2,2,1,5000,'2025-08-11 07:58:54','2025-08-11 07:58:54'),(13,'TRX-3-20250812073102',1,1,1,3000,'2025-08-12 00:31:09','2025-08-12 00:31:09'),(14,'TRX-3-20250812073102',2,1,1,3000,'2025-08-12 00:31:09','2025-08-12 00:31:09'),(15,'TRX-3-20250812073114',1,2,1,5000,'2025-08-12 00:31:21','2025-08-12 00:31:21'),(16,'TRX-3-20250812073114',2,2,1,5000,'2025-08-12 00:31:21','2025-08-12 00:31:21'),(17,'TRX-3-20250812073114',3,2,1,5000,'2025-08-12 00:31:21','2025-08-12 00:31:21'),(18,'TRX-3-20250812073114',4,2,1,5000,'2025-08-12 00:31:21','2025-08-12 00:31:21'),(19,'TRX-3-20250812125818',1,13,1,15000,'2025-08-12 05:58:24','2025-08-12 05:58:24'),(20,'TRX-3-20250812194622',1,3,1,5000,'2025-08-12 12:46:29','2025-08-12 12:46:29'),(21,'TRX-3-20250812194622',2,3,1,5000,'2025-08-12 12:46:29','2025-08-12 12:46:29'),(22,'TRX-3-20250813221928',1,1,1,3000,'2025-08-13 15:19:28','2025-08-13 15:19:28'),(23,'TRX-3-20250813221928',2,1,1,3000,'2025-08-13 15:19:28','2025-08-13 15:19:28'),(24,'TRX-3-20250813221928',3,1,1,3000,'2025-08-13 15:19:28','2025-08-13 15:19:28'),(25,'TRX-3-20250813222841',1,14,1,30000,'2025-08-13 15:28:46','2025-08-13 15:28:46'),(26,'TRX-3-20250813222841',2,14,1,30000,'2025-08-13 15:28:46','2025-08-13 15:28:46'),(27,'TRX-3-20250813224104',1,1,1,3000,'2025-08-13 15:41:03','2025-08-13 15:41:03'),(28,'TRX-3-20250813224104',2,1,1,3000,'2025-08-13 15:41:03','2025-08-13 15:41:03'),(29,'TRX-3-20250813224104',3,1,1,3000,'2025-08-13 15:41:03','2025-08-13 15:41:03');
/*!40000 ALTER TABLE `transaction_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `attendance_id` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `sell` int(11) NOT NULL,
  `pay` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `payment_method` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `deposit_id` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (6,3,3,'TRX-20250811133237','2025-08-11 06:32:48',6000,6000,1,2,'transaction_photos/CAP_TRX-20250811133235.jpg',5,'','2025-08-11 06:32:48','2025-08-12 07:31:26'),(7,3,3,'TRX-3-20250811134429','2025-08-11 06:44:39',6000,10000,1,1,NULL,5,'','2025-08-11 06:44:39','2025-08-12 07:31:26'),(8,3,3,'TRX-3-20250811145827','2025-08-11 07:58:32',6000,10000,1,1,NULL,5,'','2025-08-11 07:58:32','2025-08-12 07:31:26'),(9,3,3,'TRX-3-20250811145850','2025-08-11 07:58:54',10000,10000,1,2,'transaction_photos/CAP_TRX-20250811145849.jpg',5,'','2025-08-11 07:58:54','2025-08-12 07:31:26'),(10,3,4,'TRX-3-20250812073102','2025-08-12 00:31:09',6000,10000,1,1,NULL,5,'','2025-08-12 00:31:09','2025-08-12 07:31:26'),(11,3,4,'TRX-3-20250812073114','2025-08-12 00:31:21',20000,20000,1,2,'transaction_photos/CAP_TRX-20250812073113.jpg',5,'','2025-08-12 00:31:21','2025-08-12 07:31:26'),(12,3,4,'TRX-3-20250812125818','2025-08-12 05:58:24',15000,20000,1,1,NULL,5,'','2025-08-12 05:58:24','2025-08-12 07:31:26'),(13,3,4,'TRX-3-20250812194622','2025-08-12 12:46:22',10000,10000,1,1,NULL,6,'','2025-08-12 12:46:29','2025-08-12 16:00:01'),(14,3,5,'TRX-3-20250813221928','2025-08-13 15:19:28',9000,9000,1,2,'transaction_photos/CAP_TRX-20250813221921.jpg',NULL,'Ban Belakang','2025-08-13 15:19:28','2025-08-13 15:19:28'),(15,3,5,'TRX-3-20250813222841','2025-08-13 15:28:41',60000,100000,1,1,NULL,NULL,'Ban Serep','2025-08-13 15:28:46','2025-08-13 15:28:46'),(16,3,5,'TRX-3-20250813224104','2025-08-13 15:41:04',9000,9000,1,2,'transaction_photos/CAP_TRX-20250813224038.jpg',NULL,'','2025-08-13 15:41:03','2025-08-13 15:41:03');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1,
  `responsibility` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Superuser','superuser','test@example.com',1,'2025-07-28 12:55:05','$2y$12$QyCo.RNpOGP9M0hrgFsbPuDcVcnUhBLe3/ens7Pyf5RumQaO9uw3K',1,NULL,'Mcvxyvypph','2025-07-28 12:55:05','2025-07-28 12:55:05'),(2,'Rayyan','rayyan','rayyannur5@gmail.com',6,NULL,'$2y$12$xZsOjIT.VIGl9Rp94m3Oje0Bw9o0caI9FKr7ZjKB8Z2JEZoeIhfmu',1,NULL,NULL,'2025-07-29 03:49:05','2025-07-29 03:49:05'),(3,'Reza','reza','reza@gmail.com',6,NULL,'$2y$12$4XAXmVo5UR8.9B2LHop7YOv508WUo.y1kBq2v9uPmAk83fOuIVDpe',1,NULL,NULL,'2025-07-29 03:49:21','2025-08-12 14:19:01');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-16  9:43:51
