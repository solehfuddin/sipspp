<?php 
namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class SmsModel extends Model {
    protected $table = 'sms_service';
    protected $primaryKey = 'id_sms';
    protected $allowedFields = ['phone_number', 'message', 'status', 'response'];
    protected $column_order = array('', 'insert_date', 'phone_number', 'message', 'status', 'response');
    protected $column_search = array('insert_date', 'phone_number', 'message', 'status', 'response');
    protected $order = array('insert_date' => 'desc');
    protected $request;
    protected $db;
    protected $dt;

    function __construct(RequestInterface $request, $startdate, $enddate){
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)
                             ->where('insert_date > ', $startdate . ' 00:00:00')
                             ->where('insert_date < ', $enddate . ' 23:59:59');
    }

    function getQueue(){
        return $this->db->table($this->table)
                        ->WHERE('status', 0)
                        ->get()->getResultArray();
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
}