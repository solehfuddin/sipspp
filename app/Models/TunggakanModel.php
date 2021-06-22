<?php
//Query Untuk mendapatkan data tunggakan
/* SELECT b.nama_bulan, b.kode_tahun, c.nis, c.nama_siswa, IFNULL(p.kode_pembayaran, "Belum Bayar") as keterangan
FROM master_ajaranspp b CROSS JOIN tb_siswa c
left join tb_pembayaran p on p.nis = c.nis and p.tagihan_bulan = b.kode_bulan and p.tagihan_tahun = b.kode_tahun
WHERE p.inc_pembayaran is null and b.kode_bulan BETWEEN 1 and 5 and b.kode_tahun = 2020
ORDER BY b.kode_bulan, c.nis 

SELECT b.nama_bulan, b.kode_tahun, c.nis, c.nama_siswa, k.nama_kelas, IFNULL(p.kode_pembayaran, "Belum Bayar") as keterangan
FROM tb_siswa c CROSS JOIN master_ajaranspp b
left join tb_pembayaran p on p.nis = c.nis and p.tagihan_bulan = b.kode_bulan and p.tagihan_tahun = b.kode_tahun
left join master_kelas k on c.id_kelas = k.id_kelas
WHERE p.inc_pembayaran is null and b.kode_bulan BETWEEN 1 and 5 and b.kode_tahun = 2020

Gunakan datatable clientside : 
https://jaranguda.com/menampilkan-data-codeigniter-dengan-datatables/
*/
namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class TunggakanModel extends Model {
    protected $table = 'tb_siswa';
    protected $primaryKey = 'nis';
    protected $allowedFields = ['nis', 'nama_siswa', 'jenis_kelamin', 'tlp_hp'];

    function getData($monthStart, $monthEnd, $year){
        $db = \Config\Database::connect();

        $query = $db->query("SELECT b.`nama_bulan`, b.`kode_tahun`, c.`nis`, c.`nama_siswa`, k.`nama_kelas`, IFNULL(p.`kode_pembayaran`, 'Belum Bayar') as keterangan
        FROM tb_siswa c CROSS JOIN master_ajaranspp b
        left join tb_pembayaran p on p.`nis` = c.`nis` and p.`tagihan_bulan` = b.`kode_bulan` and p.`tagihan_tahun` = b.`kode_tahun`
        left join master_kelas k on c.`id_kelas` = k.`id_kelas`
        WHERE p.`inc_pembayaran` is null and b.`kode_bulan` BETWEEN $monthStart  and $monthEnd and b.`kode_tahun` = $year");

        return $results = $query->getResult();
    }
}