<?php 
namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class SettingLvlModel extends Model {
    protected $table = 'setting_level';
    protected $primaryKey = 'inc_setting';
    protected $allowedFields = ['id_level', 'kode_menu', 'isactive_setting'];
    protected $column_order = array('', 'nama_level', 'nama_menu', 'isactive_setting', '');
    protected $column_search = array('nama_level', 'nama_menu', 'isactive_setting');
    protected $order = array('inc_setting' => 'asc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request){
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)
                             ->select('*, master_menu.nama_menu, master_level.nama_level')
                             ->join('master_menu', 'setting_level.kode_menu = master_menu.kode_menu')
                             ->join('master_level', 'setting_level.id_level = master_level.id_level');
    }

    public function getLastData() {
        $query = $this->dt->orderBy('inc_setting', 'DESC')->limit(1)->get();

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