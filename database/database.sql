-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: digital_psychotest
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
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
-- Table structure for table `disc_answers`
--

DROP TABLE IF EXISTS `disc_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disc_answers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` bigint unsigned NOT NULL,
  `disc_question_id` bigint unsigned NOT NULL,
  `most_item_id` bigint unsigned NOT NULL,
  `least_item_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `disc_answers_participant_id_foreign` (`participant_id`),
  KEY `disc_answers_disc_question_id_foreign` (`disc_question_id`),
  KEY `disc_answers_most_item_id_foreign` (`most_item_id`),
  KEY `disc_answers_least_item_id_foreign` (`least_item_id`),
  CONSTRAINT `disc_answers_disc_question_id_foreign` FOREIGN KEY (`disc_question_id`) REFERENCES `disc_questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `disc_answers_least_item_id_foreign` FOREIGN KEY (`least_item_id`) REFERENCES `disc_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `disc_answers_most_item_id_foreign` FOREIGN KEY (`most_item_id`) REFERENCES `disc_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `disc_answers_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disc_answers`
--

LOCK TABLES `disc_answers` WRITE;
/*!40000 ALTER TABLE `disc_answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `disc_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disc_items`
--

DROP TABLE IF EXISTS `disc_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disc_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `disc_question_id` bigint unsigned NOT NULL,
  `statement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `most_value` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `least_value` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `disc_items_disc_question_id_foreign` (`disc_question_id`),
  CONSTRAINT `disc_items_disc_question_id_foreign` FOREIGN KEY (`disc_question_id`) REFERENCES `disc_questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disc_items`
--

LOCK TABLES `disc_items` WRITE;
/*!40000 ALTER TABLE `disc_items` DISABLE KEYS */;
INSERT INTO `disc_items` VALUES (1,1,'Mudah bergaul, ramah','S','S','2026-07-02 06:44:42','2026-07-02 06:44:42'),(2,1,'Penuh kepercayaan, Percaya kepada orang lain','I','I','2026-07-02 06:44:42','2026-07-02 06:44:42'),(3,1,'Petualang, pengambil risiko','N','D','2026-07-02 06:44:42','2026-07-02 06:44:42'),(4,1,'Toleran, Penuh hormat','C','C','2026-07-02 06:44:42','2026-07-02 06:44:42'),(5,2,'Yang penting adalah hasil','D','D','2026-07-02 06:44:42','2026-07-02 06:44:42'),(6,2,'Melakukan dengan benar, Ketepatan dihitung','C','C','2026-07-02 06:44:42','2026-07-02 06:44:42'),(7,2,'Buat menjadi menyenangkan','N','I','2026-07-02 06:44:42','2026-07-02 06:44:42'),(8,2,'Mari melakukan bersama','N','S','2026-07-02 06:44:42','2026-07-02 06:44:42'),(9,3,'Pendidikan, Kebudayaan','N','C','2026-07-02 06:44:42','2026-07-02 06:44:42'),(10,3,'Pencapaian, Penghargaan','D','D','2026-07-02 06:44:42','2026-07-02 06:44:42'),(11,3,'Keselamatan, Keamanan','S','S','2026-07-02 06:44:42','2026-07-02 06:44:42'),(12,3,'Sosial, Pertemuan kelompok','I','N','2026-07-02 06:44:42','2026-07-02 06:44:42'),(13,4,'Lembut, Pendiam','C','N','2026-07-02 06:44:42','2026-07-02 06:44:42'),(14,4,'Optimis, Pengkhayal','D','D','2026-07-02 06:44:42','2026-07-02 06:44:42'),(15,4,'Pusat perhatian, Mudah bersosialisasi','N','I','2026-07-02 06:44:42','2026-07-02 06:44:42'),(16,4,'Pembuat perdamaian, Membawa ketenangan','S','S','2026-07-02 06:44:42','2026-07-02 06:44:42'),(17,5,'Akan melakukan tanpa, Kontrol diri','N','C','2026-07-02 06:44:42','2026-07-02 06:44:42'),(18,5,'Akan membeli berdasarkan hasrat','D','D','2026-07-02 06:44:42','2026-07-02 06:44:42'),(19,5,'Akan menunggu, Tidak ada tekanan','S','S','2026-07-02 06:44:42','2026-07-02 06:44:42'),(20,5,'Akan membelanjakan apa yang saya inginkan','I','N','2026-07-02 06:44:42','2026-07-02 06:44:42'),(21,6,'Bertanggung jawab, Pendekatan langsung','D','D','2026-07-02 06:44:42','2026-07-02 06:44:42'),(22,6,'Mudah bergaul, Antusias','N','I','2026-07-02 06:44:42','2026-07-02 06:44:42'),(23,6,'Mudah ditebak, Konsisten','N','S','2026-07-02 06:44:42','2026-07-02 06:44:42'),(24,6,'Waspada, Berhati-hati','C','N','2026-07-02 06:44:42','2026-07-02 06:44:42'),(25,7,'Mendorong orang lain','I','I','2026-07-02 06:44:42','2026-07-02 06:44:42'),(26,7,'Berjuang demi kesempurnaan','N','C','2026-07-02 06:44:42','2026-07-02 06:44:42'),(27,7,'Menjadi bagian tim','N','S','2026-07-02 06:44:42','2026-07-02 06:44:42'),(28,7,'Ingin mencapai tujuan','D','N','2026-07-02 06:44:42','2026-07-02 06:44:42'),(29,8,'Ramah, Mudah berteman','S','N','2026-07-02 06:44:42','2026-07-02 06:44:42'),(30,8,'Unik, Bosan dengan rutinitas','N','I','2026-07-02 06:44:42','2026-07-02 06:44:42'),(31,8,'Aktif merubah hal-hal','D','D','2026-07-02 06:44:42','2026-07-02 06:44:42'),(32,8,'Menginginkan sesuatu yang pasti','C','C','2026-07-02 06:44:42','2026-07-02 06:44:42'),(33,9,'Tidak mudah dikalahkan','D','D','2026-07-02 06:44:42','2026-07-02 06:44:42'),(34,9,'Akan melakukan sesuai perintah, Mengikuti pimpinan','S','N','2026-07-02 06:44:42','2026-07-02 06:44:42'),(35,9,'Riang, Ceria','I','I','2026-07-02 06:44:42','2026-07-02 06:44:42'),(36,9,'Ingin segalanya teratur, Rapi','N','C','2026-07-02 06:44:42','2026-07-02 06:44:42'),(37,10,'Pendekatan langsung, Tanpa basa-basi','D','D','2026-07-02 06:44:42','2026-07-02 06:44:42'),(38,10,'Suka bergaul, Antusias','I','I','2026-07-02 06:44:42','2026-07-02 06:44:42'),(39,10,'Terukur, Dapat diandalkan','S','S','2026-07-02 06:44:42','2026-07-02 06:44:42'),(40,10,'Berhati-hati, Teliti','C','C','2026-07-02 06:44:42','2026-07-02 06:44:42'),(41,11,'Berani, Pengambil risiko','D','D','2026-07-02 06:44:42','2026-07-02 06:44:42'),(42,11,'Ekspresif, Banyak bicara','I','I','2026-07-02 06:44:42','2026-07-02 06:44:42'),(43,11,'Stabil, Sabar','S','S','2026-07-02 06:44:42','2026-07-02 06:44:42'),(44,11,'Tepat, Detail','C','C','2026-07-02 06:44:42','2026-07-02 06:44:42'),(45,12,'Menyukai tantangan, Kompetitif','D','D','2026-07-02 06:44:42','2026-07-02 06:44:42'),(46,12,'Optimis, Positif','I','I','2026-07-02 06:44:42','2026-07-02 06:44:42'),(47,12,'Akomodatif, Membantu','S','S','2026-07-02 06:44:42','2026-07-02 06:44:42'),(48,12,'Logis, Analitis','C','C','2026-07-02 06:44:42','2026-07-02 06:44:42'),(49,13,'Hidup, Cerewet','I','N','2026-07-02 06:44:42','2026-07-02 06:44:42'),(50,13,'Bekerja dengan cepat, Tekun','D','D','2026-07-02 06:44:43','2026-07-02 06:44:43'),(51,13,'Mencoba mempertahankan keseimbangan','S','S','2026-07-02 06:44:43','2026-07-02 06:44:43'),(52,13,'Mencoba mengikuti aturan','N','C','2026-07-02 06:44:43','2026-07-02 06:44:43'),(53,14,'Menginginkan kemajuan','D','D','2026-07-02 06:44:43','2026-07-02 06:44:43'),(54,14,'Puas dengan beberapa hal, Mudah puas','S','N','2026-07-02 06:44:43','2026-07-02 06:44:43'),(55,14,'Menggambarkan perasaan secara terbuka','I','N','2026-07-02 06:44:43','2026-07-02 06:44:43'),(56,14,'Rendah hati, sederhana','N','C','2026-07-02 06:44:43','2026-07-02 06:44:43'),(57,15,'Memikirkan orang lain dahulu','S','S','2026-07-02 06:44:43','2026-07-02 06:44:43'),(58,15,'Kompetitif, Menyukai tantangan','N','I','2026-07-02 06:44:43','2026-07-02 06:44:43'),(59,15,'Optimis, Positif','D','D','2026-07-02 06:44:43','2026-07-02 06:44:43'),(60,15,'Berpikir logis, Sistematis','C','C','2026-07-02 06:44:43','2026-07-02 06:44:43'),(61,16,'Mengatur waktu secara efisien','C','N','2026-07-02 06:44:43','2026-07-02 06:44:43'),(62,16,'Sering terburu-buru, Merasa tertekan','D','D','2026-07-02 06:44:43','2026-07-02 06:44:43'),(63,16,'Hal-hal sosial merupakan hal yang penting','I','I','2026-07-02 06:44:43','2026-07-02 06:44:43'),(64,16,'Menyelesaikan apa yang telah dimulai','S','S','2026-07-02 06:44:43','2026-07-02 06:44:43'),(65,17,'Tenang, Pendiam','C','C','2026-07-02 06:44:43','2026-07-02 06:44:43'),(66,17,'Bahagia, Riang','I','I','2026-07-02 06:44:43','2026-07-02 06:44:43'),(67,17,'Menyenangkan, Baik','S','N','2026-07-02 06:44:43','2026-07-02 06:44:43'),(68,17,'Tegas, Berani','D','D','2026-07-02 06:44:43','2026-07-02 06:44:43'),(69,18,'Menyenangkan orang, Ramah','S','S','2026-07-02 06:44:43','2026-07-02 06:44:43'),(70,18,'Tertawa keras, hidup','N','I','2026-07-02 06:44:43','2026-07-02 06:44:43'),(71,18,'Berani, tegas','D','D','2026-07-02 06:44:43','2026-07-02 06:44:43'),(72,18,'Tenang, Pendiam','C','C','2026-07-02 06:44:43','2026-07-02 06:44:43'),(73,19,'Menolak perubahan mendadak','S','N','2026-07-02 06:44:43','2026-07-02 06:44:43'),(74,19,'Cenderung sering berjanji','I','I','2026-07-02 06:44:43','2026-07-02 06:44:43'),(75,19,'Menyendiri jika dibawah tekanan','N','C','2026-07-02 06:44:43','2026-07-02 06:44:43'),(76,19,'Tidak takut berkelahi','N','D','2026-07-02 06:44:43','2026-07-02 06:44:43'),(77,20,'Menghabiskan waktu berharga dengan orang lain','S','S','2026-07-02 06:44:43','2026-07-02 06:44:43'),(78,20,'Merencanakan masa depan, Menyiapkan diri','C','N','2026-07-02 06:44:43','2026-07-02 06:44:43'),(79,20,'Perjalanan menuju petualangan baru','I','I','2026-07-02 06:44:43','2026-07-02 06:44:43'),(80,20,'Mendapat penghargaan jika mencapai tujuan','D','D','2026-07-02 06:44:43','2026-07-02 06:44:43'),(81,21,'Menginginkan kekuasaan lebih','N','D','2026-07-02 06:44:43','2026-07-02 06:44:43'),(82,21,'Menginginkan kesempatan baru','I','N','2026-07-02 06:44:43','2026-07-02 06:44:43'),(83,21,'Menghindari konflik apapun','S','S','2026-07-02 06:44:43','2026-07-02 06:44:43'),(84,21,'Menginginkan arah yang jelas','N','C','2026-07-02 06:44:43','2026-07-02 06:44:43'),(85,22,'Seorang pendukung yang baik','I','I','2026-07-02 06:44:43','2026-07-02 06:44:43'),(86,22,'Seorang pendengar yang baik','S','S','2026-07-02 06:44:43','2026-07-02 06:44:43'),(87,22,'Seorang penganalisa yang baik','C','C','2026-07-02 06:44:43','2026-07-02 06:44:43'),(88,22,'Seorang delegasi yang baik','D','D','2026-07-02 06:44:43','2026-07-02 06:44:43'),(89,23,'Peraturan perlu ditolak','N','D','2026-07-02 06:44:43','2026-07-02 06:44:43'),(90,23,'Peraturan membuat adil','C','N','2026-07-02 06:44:43','2026-07-02 06:44:43'),(91,23,'Peraturan membuat bosan','I','I','2026-07-02 06:44:43','2026-07-02 06:44:43'),(92,23,'Peraturan membuat aman','S','S','2026-07-02 06:44:43','2026-07-02 06:44:43'),(93,24,'Bisa diandalkan, Bisa digantungkan','N','S','2026-07-02 06:44:43','2026-07-02 06:44:43'),(94,24,'Kreatif, Unik','I','I','2026-07-02 06:44:43','2026-07-02 06:44:43'),(95,24,'Berorientasi kepada hasil, Inti','D','N','2026-07-02 06:44:43','2026-07-02 06:44:43'),(96,24,'Memegang teguh standar tinggi, Akurat','C','N','2026-07-02 06:44:43','2026-07-02 06:44:43');
/*!40000 ALTER TABLE `disc_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disc_questions`
--

DROP TABLE IF EXISTS `disc_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disc_questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disc_questions`
--

LOCK TABLES `disc_questions` WRITE;
/*!40000 ALTER TABLE `disc_questions` DISABLE KEYS */;
INSERT INTO `disc_questions` VALUES (1,1,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(2,2,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(3,3,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(4,4,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(5,5,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(6,6,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(7,7,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(8,8,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(9,9,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(10,10,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(11,11,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(12,12,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(13,13,'2026-07-02 06:44:42','2026-07-02 06:44:42'),(14,14,'2026-07-02 06:44:43','2026-07-02 06:44:43'),(15,15,'2026-07-02 06:44:43','2026-07-02 06:44:43'),(16,16,'2026-07-02 06:44:43','2026-07-02 06:44:43'),(17,17,'2026-07-02 06:44:43','2026-07-02 06:44:43'),(18,18,'2026-07-02 06:44:43','2026-07-02 06:44:43'),(19,19,'2026-07-02 06:44:43','2026-07-02 06:44:43'),(20,20,'2026-07-02 06:44:43','2026-07-02 06:44:43'),(21,21,'2026-07-02 06:44:43','2026-07-02 06:44:43'),(22,22,'2026-07-02 06:44:43','2026-07-02 06:44:43'),(23,23,'2026-07-02 06:44:43','2026-07-02 06:44:43'),(24,24,'2026-07-02 06:44:43','2026-07-02 06:44:43');
/*!40000 ALTER TABLE `disc_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
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
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int DEFAULT NULL,
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_06_24_114435_create_participants_table',1),(5,'2026_06_24_114436_create_disc_questions_table',1),(6,'2026_06_24_114437_create_disc_items_table',1),(7,'2026_06_24_114438_create_disc_answers_table',1),(8,'2026_06_24_152720_create_tokens_table',1),(9,'2026_06_24_154215_add_username_to_users_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participants`
--

DROP TABLE IF EXISTS `participants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `participants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usia` int DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `pendidikan_terakhir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `positions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `participants`
--

LOCK TABLES `participants` WRITE;
/*!40000 ALTER TABLE `participants` DISABLE KEYS */;
/*!40000 ALTER TABLE `participants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('NydVo0DPnaphrYnUoWIVi3hEZN1bD0Lap9VBl2fz',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUEkwUWZOQ1JoRUtTT0syUXd4MlBBbW9QTlRwWXIzS2Y3aThmeEdDUSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7czo1OiJyb3V0ZSI7czoxMToiYWRtaW4ubG9naW4iO319',1783002717);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disc',
  `status` enum('available','used') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `participant_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tokens_code_unique` (`code`),
  KEY `tokens_participant_id_foreign` (`participant_id`),
  CONSTRAINT `tokens_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tokens`
--

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Master Admin','rei','rei@admin.com',NULL,'$2y$12$377z5YtmeR1C8KhZ1wlSzuDZ8DcBe68DiK8cn0iyvsRK70LTJsDFG',NULL,'2026-07-02 06:44:42','2026-07-02 06:52:16'),(2,'Sungut Admin','sungut','sungut@admin.com',NULL,'$2y$12$NH256J6aMyLbSXfWfxsPf.v/0.NOicRqcaAVJGE9A/ncrk9BS7zRW',NULL,'2026-07-02 06:52:17','2026-07-02 06:52:17');
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

-- Dump completed on 2026-07-02 21:33:00
