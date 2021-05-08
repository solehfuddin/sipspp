-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 08 Bulan Mei 2021 pada 01.19
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
  `id_agama` varchar(10) NOT NULL,
  `nama_agama` varchar(20) NOT NULL,
  `deskripsi_agama` varchar(100) NOT NULL,
  `isactive_agama` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `master_agama`
--

INSERT INTO `master_agama` (`id_agama`, `nama_agama`, `deskripsi_agama`, `isactive_agama`) VALUES
('MAG001', 'Islam', 'Agama islam', 1),
('MAG002', 'Kristen Protestan', 'Agama kristen', 1),
('MAG003', 'Kristen Katolik', 'Agama kristen', 1),
('MAG004', 'Hindu', 'Agama Hindu', 1),
('MAG005', 'Budha', 'Agama Budha', 1),
('MAG006', 'Khonghucu', 'Agama khonghucu', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_kelas`
--

CREATE TABLE `master_kelas` (
  `id_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(15) NOT NULL,
  `deskripsi_kelas` varchar(100) DEFAULT NULL,
  `isactive_kelas` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `master_kelas`
--

INSERT INTO `master_kelas` (`id_kelas`, `nama_kelas`, `deskripsi_kelas`, `isactive_kelas`) VALUES
('MKLS001', '7-1', 'Kelas 7 kelompok 1', 1),
('MKLS002', '7-2', 'Kelas 7 Kelompok 2', 1),
('MKLS003', '7-3', 'Kelas 7 Kelompok 3', 1),
('MKLS004', '8-1', 'Kelas 8 Kelompok 1', 1),
('MKLS005', '8-2', 'Kelas 8 Kelompok 2', 1),
('MKLS006', '8-3', 'Kelas 8 kelompok 3', 0),
('MKLS007', '9-1', 'Kelas 9 kelompok 1', 1),
('MKLS008', '9-2', 'Kelas 9 kelompok 2', 1),
('MKLS009', '9-3', 'Kelas 9 kelompok 3', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_level`
--

CREATE TABLE `master_level` (
  `id_level` varchar(5) NOT NULL,
  `nama_level` varchar(20) NOT NULL,
  `deskripsi_level` varchar(100) NOT NULL,
  `isactive_level` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `master_level`
--

INSERT INTO `master_level` (`id_level`, `nama_level`, `deskripsi_level`, `isactive_level`) VALUES
('MLV01', 'Kasir', 'Hanya dapat akses menu pembayaran dan cetak kwitansi', 1),
('MLV02', 'Kepala Sekolah', 'Melihat laporan spp yang sudah dibayarkan baik harian, bulanan maupun tahunan', 1),
('MLV03', 'Admin', 'Dapat mengakses data siswa serta mendaftarkan user baru', 1),
('MLV04', 'IT Administrator', 'Full akses', 1);

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
  `id_level` varchar(5) NOT NULL,
  `kode_menu` varchar(5) NOT NULL,
  `kode_submenu` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `kode_pembayaran` varchar(15) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nis` int(11) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `tagihan_bulan` int(2) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1 : Belum Bayar, 2 : Lunas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nis` int(11) NOT NULL,
  `id_agama` varchar(10) NOT NULL,
  `id_kelas` varchar(10) NOT NULL,
  `nama_siswa` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `tempat_lahir` varchar(20) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `tlp_hp` varchar(13) DEFAULT NULL,
  `alamat` text NOT NULL,
  `foto` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
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
  `foto` text,
  `isactive_user` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `email`, `username`, `password`, `id_level`, `nama_lengkap`, `jenis_kelamin`, `no_hp`, `id_agama`, `alamat`, `foto`, `isactive_user`) VALUES
('USR001', 'solehfudin@trl.co.id', 'soleh', 'e10adc3949ba59abbe56e057f20f883e', 'MLV04', 'solehfuddin', 'Laki-laki', NULL, 'MAG001', NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `master_agama`
--
ALTER TABLE `master_agama`
  ADD PRIMARY KEY (`id_agama`);

--
-- Indeks untuk tabel `master_kelas`
--
ALTER TABLE `master_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `master_level`
--
ALTER TABLE `master_level`
  ADD PRIMARY KEY (`id_level`);

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
-- Indeks untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`kode_pembayaran`);

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
  ADD UNIQUE KEY `email_user` (`email`);
