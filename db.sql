-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2021 at 01:57 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sip_spp`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_agama`
--

CREATE TABLE `master_agama` (
  `inc_agama` int(3) NOT NULL,
  `id_agama` varchar(10) NOT NULL,
  `nama_agama` varchar(20) NOT NULL,
  `deskripsi_agama` varchar(100) NOT NULL,
  `isactive_agama` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_agama`
--

INSERT INTO `master_agama` (`inc_agama`, `id_agama`, `nama_agama`, `deskripsi_agama`, `isactive_agama`) VALUES
(1, 'MAG001', 'Islam', 'Agama islam', 1),
(2, 'MAG002', 'Kristen Protestan', 'Agama kristen', 1),
(3, 'MAG003', 'Kristen Katolik', 'Agama kristen', 1),
(4, 'MAG004', 'Hindu', 'Agama Hindu', 1),
(5, 'MAG005', 'Budha', 'Agama Budha', 1),
(6, 'MAG006', 'Khonghucu', 'Agama khonghucu', 1),
(7, 'MAG007', 'Atheis', 'Tidak memiliki keyakinan terhadap tuhan', 0),
(8, 'MAG008', 'Amimisme', 'Agama kepercayaan leluhur', 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_kelas`
--

CREATE TABLE `master_kelas` (
  `inc_kelas` int(3) NOT NULL,
  `id_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(15) NOT NULL,
  `deskripsi_kelas` varchar(100) DEFAULT NULL,
  `isactive_kelas` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_kelas`
--

INSERT INTO `master_kelas` (`inc_kelas`, `id_kelas`, `nama_kelas`, `deskripsi_kelas`, `isactive_kelas`) VALUES
(1, 'MKLS001', '7-1', 'Kelas 7 kelompok 1', 1),
(2, 'MKLS002', '7-2', 'Kelas 7 Kelompok 2', 1),
(3, 'MKLS003', '7-3', 'Kelas 7 Kelompok 3', 1),
(4, 'MKLS004', '8-1', 'Kelas 8 Kelompok 1', 1),
(5, 'MKLS005', '8-2', 'Kelas 8 Kelompok 2', 1),
(6, 'MKLS006', '8-3', 'Kelas 8 kelompok 3', 0),
(7, 'MKLS007', '9-1', 'Kelas 9 kelompok 1', 1),
(8, 'MKLS008', '9-2', 'Kelas 9 kelompok 2', 1),
(9, 'MKLS009', '9-3', 'Kelas 9 kelompok 3', 0),
(10, 'MKLS0010', '7-4', 'Kelas 7 kelompok 4', 0),
(12, 'MKLS0011', '7-5', 'Kelas 7 kelompok 5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_level`
--

CREATE TABLE `master_level` (
  `inc_level` int(3) NOT NULL,
  `id_level` varchar(5) NOT NULL,
  `nama_level` varchar(20) NOT NULL,
  `deskripsi_level` varchar(100) NOT NULL,
  `isactive_level` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_level`
--

INSERT INTO `master_level` (`inc_level`, `id_level`, `nama_level`, `deskripsi_level`, `isactive_level`) VALUES
(1, 'MLV01', 'Kasir', 'Hanya dapat akses menu pembayaran dan cetak kwitansi', 1),
(2, 'MLV02', 'Kepala Sekolah', 'Melihat laporan spp yang sudah dibayarkan baik harian, bulanan maupun tahunan', 1),
(3, 'MLV03', 'Admin', 'Dapat mengakses data siswa serta mendaftarkan user baru', 1),
(4, 'MLV04', 'IT Administrator', 'Full akses', 1),
(6, 'MLV05', 'Guru', 'Guru hanya dapat mengakses data siswa', 0),
(7, 'MLV06', 'Demo', 'Account demo untuk akses nya diberikan full akses', 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_menu`
--

CREATE TABLE `master_menu` (
  `kode_menu` varchar(5) NOT NULL,
  `nama_menu` varchar(15) NOT NULL,
  `deskripsi_menu` varchar(100) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `style` varchar(20) NOT NULL,
  `link_menu` varchar(20) NOT NULL,
  `exist_submenu` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_menu`
--

INSERT INTO `master_menu` (`kode_menu`, `nama_menu`, `deskripsi_menu`, `icon`, `style`, `link_menu`, `exist_submenu`) VALUES
('MM01', 'Dashboard', 'Menu ini menampilkan statistik data secara umum', 'ni ni-shop', 'text-primary', 'admdashboard', 0),
('MM02', 'Data Master', 'Menu ini digunakan untuk pengaturan data master dari aplikasi spp', 'ni ni-collection', 'text-orange', '', 1),
('MM03', 'Data Pembayaran', 'Menu ini digunakan untuk menambahkan data pembayaran spp dari siswa', 'ni ni-bag-17', 'text-green', 'admpembayaran', 0),
('MM04', 'Data Siswa', 'Menu ini berisi informasi untuk pendataan siswa secara rinci', 'ni ni-single-02', 'text-info', 'admsiswa', 0),
('MM05', 'Data User', 'Menu ini untuk pengaturan user yang dapat login kedalam aplikasi', 'ni ni-circle-08', 'text-orange', 'admuser', 0),
('MM06', 'Data Laporan', 'Menu ini untuk merekapitulasi data pembayaran SPP yang telah diinput kedalam sistem', 'ni ni-book-bookmark', 'text-pink', 'admlaporan', 0),
('MM07', 'Setting Account', 'Menu ini digunakan sebagai acuan dalam pemberian akses pada aplikasi spp', 'ni ni-settings-gear-65', '', 'admsetting', 0),
('MM08', 'Data Sms', 'Menu ini digunakan untuk melihat status sms', 'ni ni-send', 'text-red', '/admsms', 0);

-- --------------------------------------------------------

--
-- Table structure for table `master_submenu`
--

CREATE TABLE `master_submenu` (
  `kode_submenu` varchar(5) NOT NULL,
  `kode_menu` varchar(5) NOT NULL,
  `nama_submenu` varchar(15) NOT NULL,
  `deskripsi_submenu` varchar(100) NOT NULL,
  `link_submenu` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_submenu`
--

INSERT INTO `master_submenu` (`kode_submenu`, `kode_menu`, `nama_submenu`, `deskripsi_submenu`, `link_submenu`) VALUES
('MSB01', 'MM02', 'Agama', 'Submenu ini untuk pengaturan data master agama', 'admagama'),
('MSB02', 'MM02', 'Kelas', 'Submenu ini untuk pengaturan data master kelas', 'admkelas'),
('MSB03', 'MM02', 'Level', 'Submenu ini digunakan untuk pengaturan master level', 'admlevel');

-- --------------------------------------------------------

--
-- Table structure for table `setting_level`
--

CREATE TABLE `setting_level` (
  `inc_setting` int(11) NOT NULL,
  `id_level` varchar(5) NOT NULL,
  `kode_menu` varchar(5) NOT NULL,
  `isactive_setting` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting_level`
--

INSERT INTO `setting_level` (`inc_setting`, `id_level`, `kode_menu`, `isactive_setting`) VALUES
(1, 'MLV01', 'MM01', 1),
(2, 'MLV01', 'MM03', 1),
(3, 'MLV01', 'MM06', 0),
(4, 'MLV02', 'MM01', 1),
(5, 'MLV02', 'MM06', 1),
(6, 'MLV03', 'MM01', 1),
(7, 'MLV03', 'MM04', 1),
(8, 'MLV04', 'MM01', 1),
(9, 'MLV04', 'MM02', 1),
(10, 'MLV04', 'MM05', 1),
(11, 'MLV04', 'MM07', 1),
(12, 'MLV06', 'MM01', 1),
(13, 'MLV06', 'MM02', 1),
(14, 'MLV06', 'MM03', 1),
(15, 'MLV06', 'MM04', 1),
(16, 'MLV06', 'MM05', 1),
(17, 'MLV06', 'MM06', 1),
(18, 'MLV06', 'MM07', 0),
(19, 'MLV01', 'MM04', 1),
(20, 'MLV01', 'MM08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sms_service`
--

CREATE TABLE `sms_service` (
  `id_sms` int(11) NOT NULL,
  `kode_pembayaran` varchar(50) NOT NULL,
  `phone_number` varchar(13) DEFAULT NULL,
  `message` varchar(250) DEFAULT NULL,
  `status` int(1) DEFAULT '0' COMMENT '0 => waiting, 1 => processed',
  `response` varchar(20) DEFAULT NULL,
  `insert_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sms_service`
--

INSERT INTO `sms_service` (`id_sms`, `kode_pembayaran`, `phone_number`, `message`, `status`, `response`, `insert_date`) VALUES
(1, 'KWT160521092021', '085210785608', 'Pembayaran SPP Bulan Mei a/n Eiza Dini Islami telah dilunasi pada tanggal 16/05/2021 sebesar Rp. 300.000', 1, 'SMS terkirim', '2021-06-04 08:43:04'),
(2, 'KWT160521010616', '085210785608', 'Pembayaran SPP Bulan Mei a/n Siti Amelia telah dilunasi pada tanggal 16/05/2021 sebesar Rp. 350.000', 1, 'SMS gagal terkirim', '2021-06-07 09:03:18'),
(3, 'KWT210521080603', '085210785608', 'Pembayaran SPP Bulan Mei a/n Indra Fermana telah dilunasi pada tanggal 21/05/2021 sebesar Rp. 300.000', 1, 'SMS terkirim', '2021-06-10 08:33:04'),
(4, 'KWT170521115032', '089619783205', 'Pembayaran SPP Bulan April a/n Riki Apriadi telah dilunasi pada tanggal 17/05/2020 sebesar Rp. 300.000', 1, 'SMS terkirim', '2021-06-10 08:51:44'),
(5, 'Informasi Tunggakan', '085718291001', 'Dapat kami informasikan kepada wali murid a/n Siti amelia bahwasanya belum melakukan pembayaran SPP bulan Juni 2021. Mohon segera dilunasi agar tidak dikenakan denda / biaya tambahan dibulan berikutnya', 0, 'Pending', '2021-06-12 18:55:10');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `inc_pembayaran` int(3) NOT NULL,
  `kode_pembayaran` varchar(15) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nis` int(20) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `tagihan_bulan` int(2) NOT NULL,
  `tagihan_tahun` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`inc_pembayaran`, `kode_pembayaran`, `jumlah_bayar`, `insert_date`, `nis`, `id_user`, `tagihan_bulan`, `tagihan_tahun`) VALUES
(1, 'KWT160521092021', 300000, '2021-05-15 19:08:04', 2021586712, 'USR004', 5, '2021'),
(2, 'KWT160521010616', 350000, '2021-05-15 23:07:00', 2021586715, 'USR004', 5, '2021'),
(3, 'KWT170521115032', 300000, '2020-05-17 04:50:52', 2021586713, 'USR004', 4, '2020'),
(6, 'KWT210521080603', 300000, '2021-05-21 13:07:13', 2021586714, 'USR005', 5, '2021');

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

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
  `foto` varchar(250) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`nis`, `id_agama`, `id_kelas`, `nama_siswa`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `tlp_hp`, `alamat`, `foto`) VALUES
(2021586711, 'MAG001', 'MKLS001', 'Desti Handayani', 'Perempuan', 'Jakarta', '2007-02-05', '085210785608', 'Jalan kamboja no 8 Jakarta', 'default.png'),
(2021586712, 'MAG001', 'MKLS001', 'Eiza Dini Islami', 'Perempuan', 'Jakarta', '2006-10-12', '085210785608', 'Jalan anggrek no 17 Jakarta', 'default.png'),
(2021586713, 'MAG001', 'MKLS001', 'Riki Apriadi', 'Laki-laki', 'Bogor', '2007-01-02', '085210785608', 'Kp rawa terate no 50 Jakarta', 'default.png'),
(2021586714, 'MAG001', 'MKLS001', 'Indra Fermana', 'Laki-laki', 'Tangerang', '2006-08-10', '085210785608', 'Jalan jagakarsa no 7 Jakarta', 'default.png'),
(2021586715, 'MAG001', 'MKLS001', 'Siti Amelia', 'Perempuan', 'Jakarta', '2006-09-14', '085210785608', 'Jalan kemakmuran no 14 Jakarta', 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

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
  `alamat` text,
  `foto` varchar(250) DEFAULT 'default.png',
  `isactive_user` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`inc_user`, `id_user`, `email`, `username`, `password`, `id_level`, `nama_lengkap`, `jenis_kelamin`, `no_hp`, `id_agama`, `alamat`, `foto`, `isactive_user`) VALUES
(1, 'USR001', 'solehfudin@trl.co.id', 'it', 'e10adc3949ba59abbe56e057f20f883e', 'MLV04', 'Solehfuddin', 'Laki-laki', '085710035900', 'MAG001', 'Kp Rawa Badung Jakarta Timur', 'USR001_5.png', 1),
(2, 'USR002', 'abdul.muis87@gmail.com', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'MLV03', 'Abdul Muis', 'Laki-laki', '', 'MAG001', 'Jalan kesehatan no 7 Jakarta Pusat', 'USR002_1.jpg', 1),
(3, 'USR003', 'suparta@trl.co', 'kepsek', 'e10adc3949ba59abbe56e057f20f883e', 'MLV02', 'Suparta', 'Laki-laki', '', 'MAG001', 'Test', 'USR003_3.jpg', 1),
(4, 'USR004', 'ita@trl.co.id', 'kasir', 'e10adc3949ba59abbe56e057f20f883e', 'MLV01', 'Ita rosita', 'Perempuan', '', 'MAG001', 'Jalan rawa buntu no 15 Jakarta', 'default.png', 1),
(5, 'USR005', 'demo1@trl.co', 'demo', '62cc2d8b4bf2d8728120d052163a77df', 'MLV06', 'demo1', 'Laki-laki', '', 'MAG001', 'Test', 'default.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_agama`
--
ALTER TABLE `master_agama`
  ADD PRIMARY KEY (`inc_agama`,`id_agama`),
  ADD UNIQUE KEY `inc_agama` (`inc_agama`);

--
-- Indexes for table `master_kelas`
--
ALTER TABLE `master_kelas`
  ADD PRIMARY KEY (`inc_kelas`,`id_kelas`),
  ADD UNIQUE KEY `inc_kelas` (`inc_kelas`);

--
-- Indexes for table `master_level`
--
ALTER TABLE `master_level`
  ADD PRIMARY KEY (`inc_level`,`id_level`),
  ADD UNIQUE KEY `inc_level` (`inc_level`);

--
-- Indexes for table `master_menu`
--
ALTER TABLE `master_menu`
  ADD PRIMARY KEY (`kode_menu`);

--
-- Indexes for table `master_submenu`
--
ALTER TABLE `master_submenu`
  ADD PRIMARY KEY (`kode_submenu`);

--
-- Indexes for table `setting_level`
--
ALTER TABLE `setting_level`
  ADD PRIMARY KEY (`inc_setting`);

--
-- Indexes for table `sms_service`
--
ALTER TABLE `sms_service`
  ADD PRIMARY KEY (`id_sms`);

--
-- Indexes for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`inc_pembayaran`,`kode_pembayaran`),
  ADD UNIQUE KEY `inc_pembayaran` (`inc_pembayaran`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`inc_user`,`id_user`),
  ADD UNIQUE KEY `email_user` (`email`),
  ADD UNIQUE KEY `inc_user` (`inc_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_agama`
--
ALTER TABLE `master_agama`
  MODIFY `inc_agama` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `master_kelas`
--
ALTER TABLE `master_kelas`
  MODIFY `inc_kelas` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `master_level`
--
ALTER TABLE `master_level`
  MODIFY `inc_level` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `setting_level`
--
ALTER TABLE `setting_level`
  MODIFY `inc_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sms_service`
--
ALTER TABLE `sms_service`
  MODIFY `id_sms` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  MODIFY `inc_pembayaran` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `inc_user` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
