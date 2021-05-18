<?php 
namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class PembayaranMonthModel extends Model {
    protected $table = 'tb_pembayaran';
    protected $primaryKey = 'kode_pembayaran';
    protected $allowedFields = ['kode_pembayaran', 'jumlah_bayar', 'nis', 'insert_date', 'id_user', 'tagihan_bulan', 
                                'tagihan_tahun'];
    protected $column_order = array('', 'nis', 'nama_siswa', 'nama_kelas', 'jumlah_bayar', 'insert_date',
                                        'tagihan_bulan', 'tagihan_tahun', 'nama_lengkap', '');
    protected $column_search = array('tb_pembayaran.nis', 'jumlah_bayar', 'insert_date', 'tagihan_bulan', 'tagihan_tahun');
    protected $order = array('insert_date' => 'desc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request, $month, $year){
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)
                             ->select('*, tb_siswa.nama_siswa, master_kelas.nama_kelas, tb_user.nama_lengkap')
                             ->join('tb_siswa', 'tb_pembayaran.nis = tb_siswa.nis')
                             ->join('master_kelas', 'tb_siswa.id_kelas = master_kelas.id_kelas')
                             ->join('tb_user', 'tb_pembayaran.id_user = tb_user.id_user')
                             ->where(['tagihan_bulan' => $month])
                             ->where(['tagihan_tahun' => $year]);
    }

    public function checkusername($kode){
        return $this->where(['username' => $kode])->find();
    }

    public function checkemail($kode){
        return $this->where(['email' => $kode])->find();
    }

    public function getLastData() {
        $query = $this->dt->orderBy('inc_user', 'DESC')->limit(1)->get();

        return $query->getRow();
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

    function count_filtered($month, $year){
        $this->_get_datatables_query();
        return $this->dt->where(['tagihan_bulan' => $month])
                        ->where(['tagihan_tahun' => $year])
                        ->countAllResults();
    }

    public function count_all($month, $year){
        $tbl_storage = $this->db->table($this->table)
                                ->where(['tagihan_bulan' => $month])
                                ->where(['tagihan_tahun' => $year]);
        return $tbl_storage->countAllResults();
    }
}