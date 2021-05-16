-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 16 Bulan Mei 2021 pada 13.51
-- Versi server: 5.7.32
-- Versi PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sip_spp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_agama`
--

CREATE TABLE `master_agama` (
  `inc_agama` int(3) NOT NULL,
  `id_agama` varchar(10) NOT NULL,
  `nama_agama` varchar(20) NOT NULL,
  `deskripsi_agama` varchar(100) NOT NULL,
  `isactive_agama` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `master_agama`
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
-- Struktur dari tabel `master_kelas`
--

CREATE TABLE `master_kelas` (
  `inc_kelas` int(3) NOT NULL,
  `id_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(15) NOT NULL,
  `deskripsi_kelas` varchar(100) DEFAULT NULL,
  `isactive_kelas` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `master_kelas`
--

INSERT INTO `master_kelas` (`inc_kelas`, `id_kelas`, `nama_kelas`, `deskripsi_kelas`, `isactive_kelas`) VALUES
(1, 'MKLS001', '7-1', 'Kelas 7 kelompok 1', 1),
(10, 'MKLS0010', '7-4', 'Kelas 7 kelompok 4', 0),
(12, 'MKLS0011', '7-5', 'Kelas 7 kelompok 5', 0),
(2, 'MKLS002', '7-2', 'Kelas 7 Kelompok 2', 1),
(3, 'MKLS003', '7-3', 'Kelas 7 Kelompok 3', 1),
(4, 'MKLS004', '8-1', 'Kelas 8 Kelompok 1', 1),
(5, 'MKLS005', '8-2', 'Kelas 8 Kelompok 2', 1),
(6, 'MKLS006', '8-3', 'Kelas 8 kelompok 3', 0),
(7, 'MKLS007', '9-1', 'Kelas 9 kelompok 1', 1),
(8, 'MKLS008', '9-2', 'Kelas 9 kelompok 2', 1),
(9, 'MKLS009', '9-3', 'Kelas 9 kelompok 3', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_level`
--

CREATE TABLE `master_level` (
  `inc_level` int(3) NOT NULL,
  `id_level` varchar(5) NOT NULL,
  `nama_level` varchar(20) NOT NULL,
  `deskripsi_level` varchar(100) NOT NULL,
  `isactive_level` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `master_level`
--

INSERT INTO `master_level` (`inc_level`, `id_level`, `nama_level`, `deskripsi_level`, `isactive_level`) VALUES
(1, 'MLV01', 'Kasir', 'Hanya dapat akses menu pembayaran dan cetak kwitansi', 1),
(2, 'MLV02', 'Kepala Sekolah', 'Melihat laporan spp yang sudah dibayarkan baik harian, bulanan maupun tahunan', 1),
(3, 'MLV03', 'Admin', 'Dapat mengakses data siswa serta mendaftarkan user baru', 1),
(4, 'MLV04', 'IT Administrator', 'Full akses', 1),
(6, 'MLV05', 'Guru', 'Guru hanya dapat mengakses data siswa', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_menu`
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
-- Dumping data untuk tabel `master_menu`
--

INSERT INTO `master_menu` (`kode_menu`, `nama_menu`, `deskripsi_menu`, `icon`, `style`, `link_menu`, `exist_submenu`) VALUES
('MM01', 'Dashboard', 'Menu ini menampilkan statistik data secara umum', 'ni ni-shop', 'text-primary', 'admdashboard', 0),
('MM02', 'Data Master', 'Menu ini digunakan untuk pengaturan data master dari aplikasi spp', 'ni ni-collection', 'text-orange', '', 1),
('MM03', 'Data Pembayaran', 'Menu ini digunakan untuk menambahkan data pembayaran spp dari siswa', 'ni ni-bag-17', 'text-green', 'admpembayaran', 0),
('MM04', 'Data Siswa', 'Menu ini berisi informasi untuk pendataan siswa secara rinci', 'ni ni-single-02', 'text-info', 'admsiswa', 0),
('MM05', 'Data User', 'Menu ini untuk pengaturan user yang dapat login kedalam aplikasi', 'ni ni-circle-08', 'text-orange', 'admuser', 0),
('MM06', 'Data Laporan', 'Menu ini untuk merekapitulasi data pembayaran SPP yang telah diinput kedalam sistem', 'ni ni-book-bookmark', 'text-pink', 'admlaporan', 0),
('MM07', 'Setting Account', 'Menu ini digunakan sebagai acuan dalam pemberian akses pada aplikasi spp', 'ni ni-settings-gear-65', '', 'admsetting', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_submenu`
--

CREATE TABLE `master_submenu` (
  `kode_submenu` varchar(5) NOT NULL,
  `kode_menu` varchar(5) NOT NULL,
  `nama_submenu` varchar(15) NOT NULL,
  `deskripsi_submenu` varchar(100) NOT NULL,
  `link_submenu` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `master_submenu`
--

INSERT INTO `master_submenu` (`kode_submenu`, `kode_menu`, `nama_submenu`, `deskripsi_submenu`, `link_submenu`) VALUES
('MSB01', 'MM02', 'Agama', 'Submenu ini untuk pengaturan data master agama', 'admagama'),
('MSB02', 'MM02', 'Kelas', 'Submenu ini untuk pengaturan data master kelas', 'admkelas'),
('MSB03', 'MM02', 'Level', 'Submenu ini digunakan untuk pengaturan master level', 'admlevel');

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting_level`
--

CREATE TABLE `setting_level` (
  `inc_setting` int(11) NOT NULL,
  `id_level` varchar(5) NOT NULL,
  `kode_menu` varchar(5) NOT NULL,
  `isactive_setting` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `setting_level`
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
(11, 'MLV04', 'MM07', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pembayaran`
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
-- Dumping data untuk tabel `tb_pembayaran`
--

INSERT INTO `tb_pembayaran` (`inc_pembayaran`, `kode_pembayaran`, `jumlah_bayar`, `insert_date`, `nis`, `id_user`, `tagihan_bulan`, `tagihan_tahun`) VALUES
(2, 'KWT160521010616', 350000, '2021-05-16 06:07:00', 2021586715, 'USR004', 5, '2021'),
(1, 'KWT160521092021', 300000, '2021-05-16 02:08:04', 2021586712, 'USR004', 5, '2021');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
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
-- Dumping data untuk tabel `tb_siswa`
--

INSERT INTO `tb_siswa` (`nis`, `id_agama`, `id_kelas`, `nama_siswa`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `tlp_hp`, `alamat`, `foto`) VALUES
(2021586711, 'MAG001', 'MKLS001', 'Desti Handayani', 'Perempuan', 'Jakarta', '2007-02-05', '', 'Jalan kamboja no 8 Jakarta', 'default.png'),
(2021586712, 'MAG001', 'MKLS001', 'Eiza Dini Islami', 'Perempuan', 'Jakarta', '2006-10-12', NULL, 'Jalan anggrek no 17 Jakarta', 'default.png'),
(2021586713, 'MAG001', 'MKLS001', 'Riki Apriadi', 'Laki-laki', 'Bogor', '2007-01-02', '', 'Kp rawa terate no 50 Jakarta', 'default.png'),
(2021586714, 'MAG001', 'MKLS001', 'Indra Fermana', 'Laki-laki', 'Tangerang', '2006-08-10', '', 'Jalan jagakarsa no 7 Jakarta', 'default.png'),
(2021586715, 'MAG001', 'MKLS001', 'Siti Amelia', 'Perempuan', 'Jakarta', '2006-09-14', '', 'Jalan kemakmuran no 14 Jakarta', 'default.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
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
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`inc_user`, `id_user`, `email`, `username`, `password`, `id_level`, `nama_lengkap`, `jenis_kelamin`, `no_hp`, `id_agama`, `alamat`, `foto`, `isactive_user`) VALUES
(1, 'USR001', 'solehfudin@trl.co.id', 'soleh', 'e10adc3949ba59abbe56e057f20f883e', 'MLV04', 'Solehfuddin', 'Laki-laki', '085710035900', 'MAG001', 'Kp Rawa Badung Jakarta Timur', 'USR001_4.png', 1),
(2, 'USR002', 'abdul.muis87@gmail.com', 'abdul_muis', 'e10adc3949ba59abbe56e057f20f883e', 'MLV03', 'Abdul Muis', 'Laki-laki', '', 'MAG001', 'Jalan kesehatan no 7 Jakarta Pusat', 'USR002_1.jpg', 1),
(3, 'USR003', 'suparta@trl.co', 'suparta', 'a45958517604f5cd90d6ee51ad9cfdb6', 'MLV02', 'Suparta', 'Laki-laki', '', 'MAG001', 'Test', 'USR003_3.jpg', 1),
(4, 'USR004', 'ita@trl.co.id', 'ita', 'e10adc3949ba59abbe56e057f20f883e', 'MLV01', 'Ita rosita', 'Perempuan', '', 'MAG001', 'Jalan rawa buntu no 15 Jakarta', 'default.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `master_agama`
--
ALTER TABLE `master_agama`
  ADD PRIMARY KEY (`id_agama`),
  ADD UNIQUE KEY `inc_agama` (`inc_agama`);

--
-- Indeks untuk tabel `master_kelas`
--
ALTER TABLE `master_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD UNIQUE KEY `inc_kelas` (`inc_kelas`);

--
-- Indeks untuk tabel `master_level`
--
ALTER TABLE `master_level`
  ADD PRIMARY KEY (`id_level`),
  ADD UNIQUE KEY `inc_level` (`inc_level`);

--
-- Indeks untuk tabel `master_menu`
--
ALTER TABLE `master_menu`
  ADD PRIMARY KEY (`kode_menu`);

--
-- Indeks untuk tabel `master_submenu`
--
ALTER TABLE `master_submenu`
  ADD PRIMARY KEY (`kode_submenu`);

--
-- Indeks untuk tabel `setting_level`
--
ALTER TABLE `setting_level`
  ADD PRIMARY KEY (`inc_setting`);

--
-- Indeks untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`kode_pembayaran`),
  ADD UNIQUE KEY `inc_pembayaran` (`inc_pembayaran`);

--
-- Indeks untuk tabel `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email_user` (`email`),
  ADD UNIQUE KEY `inc_user` (`inc_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `setting_level`
--
ALTER TABLE `setting_level`
  MODIFY `inc_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  MODIFY `inc_pembayaran` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
