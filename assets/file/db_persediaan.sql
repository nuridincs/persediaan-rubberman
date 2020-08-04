# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.27)
# Database: db_inv_doni
# Generation Time: 2020-07-13 13:42:56 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table app_barang
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_barang`;

CREATE TABLE `app_barang` (
  `kode_jenis_barang` char(20) NOT NULL DEFAULT '',
  `minimum_stok` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`kode_jenis_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_barang` WRITE;
/*!40000 ALTER TABLE `app_barang` DISABLE KEYS */;

INSERT INTO `app_barang` (`kode_jenis_barang`, `minimum_stok`, `created_at`)
VALUES
	('dino123',213,'2020-07-13 20:33:55'),
	('RAB11LL',99,'2020-07-13 16:05:52'),
	('RAB140BB',70,'2020-07-13 16:05:39'),
	('RAB150CC',20,'2020-07-13 16:06:09'),
	('RAB160BB',29,'2020-07-13 16:06:21'),
	('RAB160CL',10,'2020-07-13 16:06:36'),
	('RAR193CR',100,'2020-07-13 20:05:48');

/*!40000 ALTER TABLE `app_barang` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_barang_keluar
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_barang_keluar`;

CREATE TABLE `app_barang_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_jenis_barang` char(20) DEFAULT NULL,
  `jumlah_barang_keluar` int(11) DEFAULT NULL,
  `tanggal_keluar` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kode barang keluar` (`kode_jenis_barang`),
  CONSTRAINT `kode barang keluar` FOREIGN KEY (`kode_jenis_barang`) REFERENCES `app_barang` (`kode_jenis_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_barang_keluar` WRITE;
/*!40000 ALTER TABLE `app_barang_keluar` DISABLE KEYS */;

INSERT INTO `app_barang_keluar` (`id`, `kode_jenis_barang`, `jumlah_barang_keluar`, `tanggal_keluar`)
VALUES
	(16,'RAB11LL',120,'2020-07-13'),
	(17,'RAR193CR',20,'2020-07-13');

/*!40000 ALTER TABLE `app_barang_keluar` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_barang_masuk
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_barang_masuk`;

CREATE TABLE `app_barang_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_jenis_barang` char(20) DEFAULT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `status_permintaan` varchar(20) DEFAULT NULL,
  `jumlah_barang` int(11) DEFAULT NULL,
  `status_barang` int(11) DEFAULT NULL COMMENT '1=tersedia, 2= pending, 0 = tidak tersedia, 3 = tersedia pp',
  `keterangan` varchar(50) DEFAULT NULL,
  `tanggal_masuk` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kode barang` (`kode_jenis_barang`),
  KEY `cabang barang keluar` (`id_cabang`),
  CONSTRAINT `cabang barang keluar` FOREIGN KEY (`id_cabang`) REFERENCES `app_cabang` (`id`),
  CONSTRAINT `kode barang` FOREIGN KEY (`kode_jenis_barang`) REFERENCES `app_barang` (`kode_jenis_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_barang_masuk` WRITE;
/*!40000 ALTER TABLE `app_barang_masuk` DISABLE KEYS */;

INSERT INTO `app_barang_masuk` (`id`, `kode_jenis_barang`, `id_cabang`, `status_permintaan`, `jumlah_barang`, `status_barang`, `keterangan`, `tanggal_masuk`)
VALUES
	(5,'RAB140BB',1,'verifikasi',1000,2,'','2020-07-13 16:05:39'),
	(6,'RAB11LL',3,'tersedia',880,1,'urgen','2020-07-13 16:05:52'),
	(8,'RAB160BB',1,'verifikasi',111,2,'','2020-07-13 16:06:21'),
	(9,'RAB160CL',6,'tidak_tersedia',0,0,NULL,'2020-07-13 16:06:36'),
	(10,'RAR193CR',1,'tersedia',100,1,'','2020-07-13 20:05:48'),
	(11,'dino123',6,'tidak_tersedia',0,0,NULL,'2020-07-13 20:33:55');

/*!40000 ALTER TABLE `app_barang_masuk` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_cabang
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_cabang`;

CREATE TABLE `app_cabang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_cabang` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_cabang` WRITE;
/*!40000 ALTER TABLE `app_cabang` DISABLE KEYS */;

INSERT INTO `app_cabang` (`id`, `nama_cabang`)
VALUES
	(1,'Bekasi'),
	(2,'Bandung'),
	(3,'Cilacap'),
	(4,'Tegal'),
	(5,'Medan'),
	(6,'Belum ditentukan');

/*!40000 ALTER TABLE `app_cabang` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_role`;

CREATE TABLE `app_role` (
  `id_users_role` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_users_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_role` WRITE;
/*!40000 ALTER TABLE `app_role` DISABLE KEYS */;

INSERT INTO `app_role` (`id_users_role`, `kategori`)
VALUES
	(1,'Admin Gudang'),
	(2,'Produksi'),
	(3,'Manager'),
	(4,'IT Staff');

/*!40000 ALTER TABLE `app_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table app_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_status`;

CREATE TABLE `app_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table app_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_users`;

CREATE TABLE `app_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_users_role` int(11) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_role` (`id_users_role`),
  CONSTRAINT `users_role` FOREIGN KEY (`id_users_role`) REFERENCES `app_role` (`id_users_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `app_users` WRITE;
/*!40000 ALTER TABLE `app_users` DISABLE KEYS */;

INSERT INTO `app_users` (`id`, `id_users_role`, `nama`, `email`, `password`)
VALUES
	(1,1,'Admin test','admin@gmail.com','c06db68e819be6ec3d26c6038d8e8d1f'),
	(3,3,'Manager','manager@gmail.com','202cb962ac59075b964b07152d234b70'),
	(4,4,'IT Staff','it.staff@gmail.com','202cb962ac59075b964b07152d234b70'),
	(5,1,'Admin test','admin.test@gmail.com','202cb962ac59075b964b07152d234b70');

/*!40000 ALTER TABLE `app_users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
