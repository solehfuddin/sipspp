<?php namespace App\Models;
use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class SettingModel extends Model {
    protected $table = 'setting_level';
    protected $primaryKey = 'inc_setting';
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request){
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)
                             ->select('*, master_menu.*')
                             ->join('master_menu', 'setting_level.kode_menu = master_menu.kode_menu');
    }

    public function getMenu($level){
        $query = $this->dt->where(['id_level' => $level, 'isactive_setting' => 1])
                          ->get();
        return $query->getResult();
    }
}