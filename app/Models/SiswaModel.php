<?php 
namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class SiswaModel extends Model {
    protected $table = 'tb_siswa';
    protected $primaryKey = 'nis';
    protected $allowedFields = ['nis', 'nama_siswa', 'tempat_lahir', 'tanggal_lahir', 'id_kelas', 
                                'jenis_kelamin', 'tlp_hp', 'id_agama', 'alamat', 'foto'];
    protected $column_order = array('', 'nis', 'foto', 'nama_siswa', 'nama_kelas', 'jenis_kelamin', 'tempat_lahir',
                                        'tanggal_lahir', 'nama_agama', 'tlp_hp', 'alamat', '');
    protected $column_search = array('foto', 'nis', 'nama_siswa', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 
                                        'tlp_hp', 'alamat');
    protected $order = array('nis' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request){
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)
                             ->select('*, master_kelas.nama_kelas, master_agama.nama_agama')
                             ->join('master_kelas', 'tb_siswa.id_kelas = master_kelas.id_kelas')
                             ->join('master_agama', 'tb_siswa.id_agama = master_agama.id_agama');
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

    function count_filtered(){
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }

    public function count_all(){
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
}