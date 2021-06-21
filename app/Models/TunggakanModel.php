<?php
//Query Untuk mendapatkan data tunggakan
/* SELECT b.nama_bulan, b.kode_tahun, c.nis, c.nama_siswa, IFNULL(p.kode_pembayaran, "Belum Bayar") as keterangan
FROM master_ajaranspp b CROSS JOIN tb_siswa c
left join tb_pembayaran p on p.nis = c.nis and p.tagihan_bulan = b.kode_bulan and p.tagihan_tahun = b.kode_tahun
WHERE p.inc_pembayaran is null and b.kode_bulan BETWEEN 1 and 5 and b.kode_tahun = 2020
ORDER BY b.kode_bulan, c.nis */