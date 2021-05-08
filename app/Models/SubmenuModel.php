<?php namespace App\Models;
use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class SubmenuModel extends Model {
    protected $table = 'master_submenu';
    protected $primaryKey = 'kode_submenu';
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request){
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);
    }

    public function submenu(){
        $query = $this->dt->get();
        return $query->getResult();
    }
}