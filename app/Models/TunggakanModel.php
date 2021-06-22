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

    function getData(){
        $db      = \Config\Database::connect();
        $builder = $db->table('tb_siswa');
        /*$builder->select("SELECT b.`nama_bulan`, b.`kode_tahun`, c.`nis`, c.`nama_siswa`, k.`nama_kelas`, IFNULL(p.`kode_pembayaran`, 'Belum Bayar') as keterangan
                            FROM tb_siswa c CROSS JOIN master_ajaranspp b
                            left join tb_pembayaran p on p.`nis` = c.`nis` and p.`tagihan_bulan` = b.`kode_bulan` and p.`tagihan_tahun` = b.`kode_tahun`
                            left join master_kelas k on c.`id_kelas` = k.`id_kelas`
                            WHERE p.`inc_pembayaran` is null and b.`kode_bulan` BETWEEN 1 and 5 and b.`kode_tahun` = 2020", false);*/

        $builder->select("SELECT b.`nama_bulan`, b.`kode_tahun`, c.`nis`, c.`nama_siswa`
                            FROM tb_siswa c CROSS JOIN master_ajaranspp b");
        $query = $builder->get();
    }

    function testData(){
        $db = \Config\Database::connect();

        $query = $db->query("SELECT b.`nama_bulan`, b.`kode_tahun`, c.`nis`, c.`nama_siswa`, k.`nama_kelas`, IFNULL(p.`kode_pembayaran`, 'Belum Bayar') as keterangan
        FROM tb_siswa c CROSS JOIN master_ajaranspp b
        left join tb_pembayaran p on p.`nis` = c.`nis` and p.`tagihan_bulan` = b.`kode_bulan` and p.`tagihan_tahun` = b.`kode_tahun`
        left join master_kelas k on c.`id_kelas` = k.`id_kelas`
        WHERE p.`inc_pembayaran` is null and b.`kode_bulan` BETWEEN 1 and 5 and b.`kode_tahun` = 2020");

        return $results = $query->getResultArray();
    }
}

/* class LaporanModel extends Model {
    protected $table = 'tb_siswa';
    protected $primaryKey = 'nis';
    protected $allowedFields = ['nis', 'nama_siswa', 'jenis_kelamin', 'tlp_hp'];
    protected $column_order = array('', 'nis', 'nama_siswa', 'master_kelas.nama_kelas', 
                                        'master_ajaranspp.nama_bulan', 'master_ajaranspp.kode_tahun',
                                        'keterangan');
    protected $column_search = array('nis', 'nama_siswa', 'master_kelas.nama_kelas', 'master_ajaranspp.nama_bulan', 
                                        'master_ajaranspp.kode_tahun','keterangan');
    protected $order = array('master_ajaranspp.nama_bulan' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request, $startdate, $enddate){
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)
                             ->select('master_ajaranspp.nama_bulan, master_ajaranspp.kode_tahun, nis, nama_siswa, master_kelas.nama_kelas, IFNULL(p.kode_pembayaran, "Belum Bayar") as keterangan')
                             ->join('master_ajaranspp', '')
                             ->join('tb_pembayaran', 'tb_pembayaran.nis = tb_siswa.nis AND tb_pembayaran.tagihan_bulan = master_ajaranspp.kode_bulan AND tb_pembayaran.tagihan_tahun = master_ajaranspp.kode_tahun')
                             ->join('master_kelas', 'tb_siswa.id_kelas = master_kelas.id_kelas')
                             ->where('insert_date > ', $startdate . ' 00:00:00')
                             ->where('insert_date < ', $enddate . ' 23:59:59');
    }

    function getDataFilter($datest, $dateed){
        return $this->db->table($this->table)
                        ->select('*, tb_siswa.nama_siswa, master_kelas.nama_kelas, tb_user.nama_lengkap')
                        ->join('tb_siswa', 'tb_pembayaran.nis = tb_siswa.nis')
                        ->join('master_kelas', 'tb_siswa.id_kelas = master_kelas.id_kelas')
                        ->join('tb_user', 'tb_pembayaran.id_user = tb_user.id_user')
                        ->WHERE('insert_date >=', $datest . ' 00:00:00')
                        ->WHERE('insert_date <=', $dateed . ' 23:59:59')->get()->getResultArray();
    }

    private function _get_datatables_query(){
        $i = 0;
        foreach ($this->column_search as $item){
            if($this->request->getPost('search')['value']){ 
                if($i===0){
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                }
                else{
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if(count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }
         
        if($this->request->getPost('order')){
                $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
            } 
        else if(isset($this->order)){
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    function get_datatables(){
        $this->_get_datatables_query();
        if($this->request->getPost('length') != -1)
        $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    function count_filtered($startdate, $enddate){
        $this->_get_datatables_query();
        return $this->dt->where('insert_date > ', $startdate . ' 00:00:00')
                        ->where('insert_date < ', $enddate . ' 23:59:59')->countAllResults();
    }

    public function count_all($startdate, $enddate){
        $tbl_storage = $this->db->table($this->table)
                                ->where('insert_date > ', $startdate . ' 00:00:00')
                                ->where('insert_date < ', $enddate . ' 23:59:59');
        return $tbl_storage->countAllResults();
    }
} */