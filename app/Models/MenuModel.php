<?php namespace App\Models;
use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class MenuModel extends Model {
    protected $table = 'master_menu';
    protected $primaryKey = 'kode_menu';
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request){
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);
    }

    public function menu(){
        $query = $this->dt->get();
        return $query->getResult();
    }
}