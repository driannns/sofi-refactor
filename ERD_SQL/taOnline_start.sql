-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: taonline
-- ------------------------------------------------------
-- Server version	8.0.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendances` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_sidang` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`,`schedule_id`,`user_id`),
  KEY `fk_attendances_jadwals1_idx` (`schedule_id`),
  KEY `fk_attendances_user_idx` (`user_id`),
  CONSTRAINT `fk_attendances_jadwals1` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_attendances_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clos`
--

DROP TABLE IF EXISTS `clos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clos` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `precentage` float DEFAULT NULL,
  `description` text,
  `period_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`period_id`),
  KEY `fk_clos_periods1_idx` (`period_id`),
  CONSTRAINT `fk_clos_periods1` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `components`
--

DROP TABLE IF EXISTS `components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `components` (
  `id` int(11) NOT NULL,
  `code` varchar(45) DEFAULT NULL,
  `description` text,
  `percentage` float DEFAULT NULL,
  `unsur_penilaian` text,
  `pembimbing` tinyint(4) DEFAULT NULL,
  `penguji` tinyint(4) DEFAULT NULL,
  `clo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`clo_id`),
  KEY `fk_components_clos1_idx` (`clo_id`),
  CONSTRAINT `fk_components_clos1` FOREIGN KEY (`clo_id`) REFERENCES `clos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dokumen_logs`
--

DROP TABLE IF EXISTS `dokumen_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dokumen_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sidang_id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jenis` varchar(45) DEFAULT NULL COMMENT 'jenis dokumen:\n1. draft\n2. makalah\n3. revisi',
  `file_url` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`sidang_id`),
  KEY `fk_dokumen_uploads_sidangs1_idx` (`sidang_id`),
  CONSTRAINT `fk_dokumen_uploads_sidangs1` FOREIGN KEY (`sidang_id`) REFERENCES `sidangs` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `intervals`
--

DROP TABLE IF EXISTS `intervals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `intervals` (
  `id` int(11) NOT NULL,
  `value` int(11) DEFAULT NULL,
  `ekuivalensi` int(11) DEFAULT NULL,
  `unsur_penilaian` varchar(45) DEFAULT NULL,
  `component_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`component_id`),
  KEY `fk_intervals_components1_idx` (`component_id`),
  CONSTRAINT `fk_intervals_components1` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecturers`
--

DROP TABLE IF EXISTS `lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecturers` (
  `id` int(11) NOT NULL,
  `nip` varchar(45) DEFAULT NULL,
  `code` varchar(3) DEFAULT NULL,
  `jfa` varchar(45) DEFAULT NULL,
  `kk` varchar(45) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`user_id`),
  KEY `fk_lecturers_users1_idx` (`user_id`),
  CONSTRAINT `fk_lecturers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `periods`
--

DROP TABLE IF EXISTS `periods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `periods` (
  `id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `revisions`
--

DROP TABLE IF EXISTS `revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `revisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) NOT NULL,
  `deskripsi` text,
  `hal` varchar(5) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL COMMENT 'status revisi:\n1. on work\n2. on submit\n3. approved\n4. return',
  `dokumen_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`schedule_id`,`dokumen_id`),
  KEY `fk_revisions_jadwals1_idx` (`schedule_id`),
  KEY `fk_revisions_dokumen_idx` (`dokumen_id`),
  CONSTRAINT `fk_revisions_dokumen` FOREIGN KEY (`dokumen_id`) REFERENCES `dokumen_logs` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_revisions_jadwals1` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `role_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sidang_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `ruang` text,
  `penguji1` int(11) NOT NULL,
  `penguji2` int(11) NOT NULL,
  `presentasi_file` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL COMMENT 'status jadwal sidang sudah dilakukan atau belum',
  `keputusan` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`penguji1`,`penguji2`),
  KEY `fk_jadwals_sidang_idx` (`sidang_id`),
  KEY `fk_jadwals_penguji2_idx` (`penguji1`),
  KEY `fk_jadwals_penguji2` (`penguji2`),
  CONSTRAINT `fk_jadwals_penguji1` FOREIGN KEY (`penguji1`) REFERENCES `lecturers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_jadwals_penguji2` FOREIGN KEY (`penguji2`) REFERENCES `lecturers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_jadwals_sidang` FOREIGN KEY (`sidang_id`) REFERENCES `sidangs` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `value` float DEFAULT NULL,
  `percentage` float DEFAULT NULL,
  `component_id` int(11) NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`component_id`,`jadwal_id`),
  KEY `fk_scores_components1_idx` (`component_id`),
  KEY `fk_jadwal_scores_idx` (`jadwal_id`),
  CONSTRAINT `fk_jadwal_scores` FOREIGN KEY (`jadwal_id`) REFERENCES `schedules` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_scores_components1` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sidangs`
--

DROP TABLE IF EXISTS `sidangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sidangs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` int(11) NOT NULL,
  `pembimbing1_id` int(11) NOT NULL,
  `pembimbing2_id` int(11) NOT NULL,
  `judul` text,
  `form_bimbingan` varchar(255) DEFAULT NULL,
  `eprt` varchar(255) DEFAULT NULL,
  `dokumen_ta` varchar(255) DEFAULT NULL,
  `makalah` varchar(255) DEFAULT NULL,
  `tak` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL COMMENT 'status log terbaru:\n1. pengajuan\n2. approved by admin\n3. approved by pembimbing dan/atau admin\n4. selesai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_english` tinyint(4) DEFAULT NULL,
  `period_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`mahasiswa_id`,`pembimbing1_id`,`pembimbing2_id`,`period_id`),
  KEY `fk_sidangs_pembimbing1_idx` (`pembimbing1_id`),
  KEY `fk_sidangs_mahasiswa_idx` (`mahasiswa_id`),
  KEY `fk_sidangs_period1_idx` (`period_id`),
  KEY `fk_sidangs_pembimbing2_idx` (`pembimbing2_id`),
  CONSTRAINT `fk_sidangs_mahasiswa` FOREIGN KEY (`mahasiswa_id`) REFERENCES `students` (`nim`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_sidangs_pembimbing1` FOREIGN KEY (`pembimbing1_id`) REFERENCES `lecturers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_sidangs_pembimbing2` FOREIGN KEY (`pembimbing2_id`) REFERENCES `lecturers` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_sidangs_period` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `status_logs`
--

DROP TABLE IF EXISTS `status_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sidang_id` int(11) DEFAULT NULL,
  `feedback` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `sidangs_id` int(11) NOT NULL,
  `workflow_type` varchar(45) DEFAULT NULL COMMENT 'contoh:\n- pengajuan\n- penjadwalan\n- sidang\n- revisi\n- lulus\n- sidang ulang\n- tidak lulus',
  PRIMARY KEY (`id`,`sidangs_id`),
  KEY `fk_status_logs_sidangs1_idx` (`sidangs_id`),
  CONSTRAINT `fk_status_logs_sidangs1` FOREIGN KEY (`sidangs_id`) REFERENCES `sidangs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `nim` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  `tak` varchar(45) DEFAULT NULL,
  `eprt` varchar(45) DEFAULT NULL,
  `studentscol` varchar(45) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  PRIMARY KEY (`nim`,`user_id`,`team_id`),
  KEY `fk_students_users1_idx` (`user_id`),
  KEY `fk_students_teams1_idx` (`team_id`),
  CONSTRAINT `fk_students_teams1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  CONSTRAINT `fk_students_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_has_role`
--

DROP TABLE IF EXISTS `user_has_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_has_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_user_has_role_role1_idx` (`role_id`),
  KEY `fk_user_has_role_user_idx` (`user_id`),
  CONSTRAINT `fk_user_has_role_role1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `fk_user_has_role_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-03 19:09:10
