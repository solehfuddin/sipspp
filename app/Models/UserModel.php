<?php 
namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['inc_user', 'id_user', 'email', 'username', 'password', 'id_level', 'nama_lengkap',
                                'jenis_kelamin', 'no_hp', 'id_agama', 'alamat', 'foto', 'isactive_user'];
    protected $column_order = array('', 'nama_lengkap', 'email', 'username', 'nama_level',
                                        'jenis_kelamin', 'no_hp', 'nama_agama', 'alamat', 'isactive_user', '');
    protected $column_search = array('nama_lengkap', 'email', 'username', 'nama_level', 
                                     'jenis_kelamin', 'no_hp', 'nama_agama', 'alamat', 'isactive_user');
    protected $order = array('nama_lengkap' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request){
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)
                             ->select('*, master_level.nama_level, master_agama.nama_agama')
                             ->join('master_level', 'tb_user.id_level = master_level.id_level')
                             ->join('master_agama', 'tb_user.id_agama = master_agama.id_agama');
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

    function count_filtered(){
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }

    public function count_all(){
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
}