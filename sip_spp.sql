/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.4.8-MariaDB : Database - sip_spp
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sip_spp` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `sip_spp`;

/*Table structure for table `master_agama` */

DROP TABLE IF EXISTS `master_agama`;

CREATE TABLE `master_agama` (
  `inc_agama` int(3) NOT NULL,
  `id_agama` varchar(10) NOT NULL,
  `nama_agama` varchar(20) NOT NULL,
  `deskripsi_agama` varchar(100) NOT NULL,
  `isactive_agama` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_agama`),
  UNIQUE KEY `inc_agama` (`inc_agama`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `master_agama` */

insert  into `master_agama`(`inc_agama`,`id_agama`,`nama_agama`,`deskripsi_agama`,`isactive_agama`) values 
(1,'MAG001','Islam','Agama islam',1),
(2,'MAG002','Kristen Protestan','Agama kristen',1),
(3,'MAG003','Kristen Katolik','Agama kristen',1),
(4,'MAG004','Hindu','Agama Hindu',1),
(5,'MAG005','Budha','Agama Budha',1),
(6,'MAG006','Khonghucu','Agama khonghucu',1),
(7,'MAG007','Atheis','Tidak memiliki keyakinan terhadap tuhan',0),
(8,'MAG008','Amimisme','Agama kepercayaan leluhur',0);

/*Table structure for table `master_kelas` */

DROP TABLE IF EXISTS `master_kelas`;

CREATE TABLE `master_kelas` (
  `inc_kelas` int(3) NOT NULL,
  `id_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(15) NOT NULL,
  `deskripsi_kelas` varchar(100) DEFAULT NULL,
  `isactive_kelas` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_kelas`),
  UNIQUE KEY `inc_kelas` (`inc_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `master_kelas` */

insert  into `master_kelas`(`inc_kelas`,`id_kelas`,`nama_kelas`,`deskripsi_kelas`,`isactive_kelas`) values 
(1,'MKLS001','7-1','Kelas 7 kelompok 1',1),
(10,'MKLS0010','7-4','Kelas 7 kelompok 4',0),
(12,'MKLS0011','7-5','Kelas 7 kelompok 5',0),
(2,'MKLS002','7-2','Kelas 7 Kelompok 2',1),
(3,'MKLS003','7-3','Kelas 7 Kelompok 3',1),
(4,'MKLS004','8-1','Kelas 8 Kelompok 1',1),
(5,'MKLS005','8-2','Kelas 8 Kelompok 2',1),
(6,'MKLS006','8-3','Kelas 8 kelompok 3',0),
(7,'MKLS007','9-1','Kelas 9 kelompok 1',1),
(8,'MKLS008','9-2','Kelas 9 kelompok 2',1),
(9,'MKLS009','9-3','Kelas 9 kelompok 3',0);

/*Table structure for table `master_level` */

DROP TABLE IF EXISTS `master_level`;

CREATE TABLE `master_level` (
  `inc_level` int(3) NOT NULL,
  `id_level` varchar(5) NOT NULL,
  `nama_level` varchar(20) NOT NULL,
  `deskripsi_level` varchar(100) NOT NULL,
  `isactive_level` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_level`),
  UNIQUE KEY `inc_level` (`inc_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `master_level` */

insert  into `master_level`(`inc_level`,`id_level`,`nama_level`,`deskripsi_level`,`isactive_level`) values 
(1,'MLV01','Kasir','Hanya dapat akses menu pembayaran dan cetak kwitansi',1),
(2,'MLV02','Kepala Sekolah','Melihat laporan spp yang sudah dibayarkan baik harian, bulanan maupun tahunan',1),
(3,'MLV03','Admin','Dapat mengakses data siswa serta mendaftarkan user baru',1),
(4,'MLV04','IT Administrator','Full akses',1),
(6,'MLV05','Guru','Guru hanya dapat mengakses data siswa',0);

/*Table structure for table `master_menu` */

DROP TABLE IF EXISTS `master_menu`;

CREATE TABLE `master_menu` (
  `kode_menu` varchar(5) NOT NULL,
  `nama_menu` varchar(15) NOT NULL,
  `deskripsi_menu` varchar(100) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `style` varchar(20) NOT NULL,
  `link_menu` varchar(20) NOT NULL,
  `exist_submenu` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`kode_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `master_menu` */

insert  into `master_menu`(`kode_menu`,`nama_menu`,`deskripsi_menu`,`icon`,`style`,`link_menu`,`exist_submenu`) values 
('MM01','Dashboard','Menu ini menampilkan statistik data secara umum','ni ni-shop','text-primary','admdashboard',0),
('MM02','Data Master','Menu ini digunakan untuk pengaturan data master dari aplikasi spp','ni ni-collection','text-orange','',1),
('MM03','Data Pembayaran','Menu ini digunakan untuk menambahkan data pembayaran spp dari siswa','ni ni-bag-17','text-green','admpembayaran',0),
('MM04','Data Siswa','Menu ini berisi informasi untuk pendataan siswa secara rinci','ni ni-single-02','text-info','admsiswa',0),
('MM05','Data User','Menu ini untuk pengaturan user yang dapat login kedalam aplikasi','ni ni-circle-08','text-orange','admuser',0),
('MM06','Data Laporan','Menu ini untuk merekapitulasi data pembayaran SPP yang telah diinput kedalam sistem','ni ni-book-bookmark','text-pink','admlaporan',0),
('MM07','Setting Account','Menu ini digunakan sebagai acuan dalam pemberian akses pada aplikasi spp','ni ni-settings-gear-65','','admsetting',0);

/*Table structure for table `master_submenu` */

DROP TABLE IF EXISTS `master_submenu`;

CREATE TABLE `master_submenu` (
  `kode_submenu` varchar(5) NOT NULL,
  `kode_menu` varchar(5) NOT NULL,
  `nama_submenu` varchar(15) NOT NULL,
  `deskripsi_submenu` varchar(100) NOT NULL,
  `link_submenu` varchar(15) NOT NULL,
  PRIMARY KEY (`kode_submenu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `master_submenu` */

insert  into `master_submenu`(`kode_submenu`,`kode_menu`,`nama_submenu`,`deskripsi_submenu`,`link_submenu`) values 
('MSB01','MM02','Agama','Submenu ini untuk pengaturan data master agama','admagama'),
('MSB02','MM02','Kelas','Submenu ini untuk pengaturan data master kelas','admkelas'),
('MSB03','MM02','Level','Submenu ini digunakan untuk pengaturan master level','admlevel');

/*Table structure for table `setting_level` */

DROP TABLE IF EXISTS `setting_level`;

CREATE TABLE `setting_level` (
  `id_level` varchar(5) NOT NULL,
  `kode_menu` varchar(5) NOT NULL,
  `kode_submenu` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `setting_level` */

/*Table structure for table `tb_pembayaran` */

DROP TABLE IF EXISTS `tb_pembayaran`;

CREATE TABLE `tb_pembayaran` (
  `inc_pembayaran` int(3) NOT NULL,
  `kode_pembayaran` varchar(15) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `insert_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `nis` int(20) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `tagihan_bulan` int(2) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1 : Belum Bayar, 2 : Lunas',
  PRIMARY KEY (`kode_pembayaran`),
  UNIQUE KEY `inc_pembayaran` (`inc_pembayaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tb_pembayaran` */

/*Table structure for table `tb_siswa` */

DROP TABLE IF EXISTS `tb_siswa`;

CREATE TABLE `tb_siswa` (
  `nis` int(20) NOT NULL,
  `id_agama` varchar(10) NOT NULL,
  `id_kelas` varchar(10) NOT NULL,
  `nama_siswa` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `tempat_lahir` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tlp_hp` varchar(13) DEFAULT NULL,
  `alamat` text NOT NULL,
  `foto` varchar(250) DEFAULT 'default.png',
  PRIMARY KEY (`nis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tb_siswa` */

insert  into `tb_siswa`(`nis`,`id_agama`,`id_kelas`,`nama_siswa`,`jenis_kelamin`,`tempat_lahir`,`tanggal_lahir`,`tlp_hp`,`alamat`,`foto`) values 
(2021586711,'MAG001','MKLS001','Desti Handayani','Perempuan','Jakarta','2007-02-05','','Jalan kamboja no 8 Jakarta','default.png'),
(2021586712,'MAG001','MKLS001','Eiza Dini Islami','Perempuan','Jakarta','2006-10-12',NULL,'Jalan anggrek no 17 Jakarta','default.png'),
(2021586713,'MAG001','MKLS001','Riki Apriadi','Laki-laki','Bogor','2007-01-02','','Kp rawa terate no 50 Jakarta','default.png'),
(2021586714,'MAG001','MKLS001','Indra Fermana','Laki-laki','Tangerang','2006-08-10','','Jalan jagakarsa no 7 Jakarta','default.png'),
(2021586715,'MAG001','MKLS001','Siti Amelia','Perempuan','Jakarta','2006-09-14','','Jalan kemakmuran no 14 Jakarta','default.png');

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `inc_user` int(3) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(250) NOT NULL,
  `id_level` varchar(5) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `no_hp` varchar(12) DEFAULT NULL,
  `id_agama` varchar(10) NOT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(250) DEFAULT 'default.png',
  `isactive_user` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email_user` (`email`),
  UNIQUE KEY `inc_user` (`inc_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tb_user` */

insert  into `tb_user`(`inc_user`,`id_user`,`email`,`username`,`password`,`id_level`,`nama_lengkap`,`jenis_kelamin`,`no_hp`,`id_agama`,`alamat`,`foto`,`isactive_user`) values 
(1,'USR001','solehfudin@trl.co.id','soleh','e10adc3949ba59abbe56e057f20f883e','MLV04','solehfuddin','Laki-laki','085710035900','MAG001','Kp Rawa Badung Jakarta Timur','default.png',1),
(4,'USR002','abdul.muis87@gmail.com','abdul_muis','e10adc3949ba59abbe56e057f20f883e','MLV03','Abdul Muis','Laki-laki','','MAG001','Jalan kesehatan no 7 Jakarta Pusat','USR002_1.jpg',1),
(0,'USR003','suparta@trl.co','suparta','a45958517604f5cd90d6ee51ad9cfdb6','MLV02','Suparta','Laki-laki','','MAG001','Test','USR003_3.jpg',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
