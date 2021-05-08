<?php 
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\AgamaModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use Config\Services;

class Agamacontroller extends BaseController
{
	public function index() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            $request = Services::request();
            $menuModel = new MenuModel($request);
            $submenuModel = new SubmenuModel($request);

            $data = [
                'menu' => $menuModel->menu(),
                'submenu' => $submenuModel->submenu(),
            ];

            return view('menumaster/view_masteragama', $data);
        }
    }

    public function ajax_list() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX())
            {
                $request = Services::request();
                $m_agama  = new AgamaModel($request);

                if($request->getMethod(true)=='POST'){
                    $lists = $m_agama->get_datatables();
                        $data = [];
                        $no = $request->getPost("start");

                        foreach ($lists as $list) {
                                $no++;
                                $row = [];

                                $tomboledit = "<button type=\"button\" class=\"btn btn-warning btn-sm btneditinfocategory\"
                                                onclick=\"editmasteragama('" .$list->id_agama. "')\">
                                                <i class=\"fa fa-edit\"></i></button>";

                                $row[] = $no;
                                if ($list->isactive_agama == 1)
                                {
                                    $isactive = "<span style='color:#2dce89;'>Aktif</span";
                                }
                                else
                                {
                                    $isactive = "<span style='color:#f5365c;'>Tidak Aktif</span";
                                }
                                
                                $row[] = $isactive;
                                $row[] = $list->nama_agama;
                                $row[] = $list->deskripsi_agama;
                                $row[] = $tomboledit;
                                $data[] = $row;
                        }
                    
                        $output = [
                            "draw" => $request->getPost('draw'),
                            "recordsTotal" => $m_agama->count_all(),
                            "recordsFiltered" => $m_agama->count_filtered(),
                            "data" => $data
                        ];

                    echo json_encode($output);
                }
            }
            else
            {
                return view('errors/html/error_404');
            }
        }
    }

    public function getdata() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX())
            {
                $request = Services::request();
                $m_agama = new AgamaModel($request);

                $getdata = $m_agama->findAll();
                $max  = count($getdata) + 1;
                $gen  = "MAG" . str_pad($max, 3, 0, STR_PAD_LEFT);

                $data = [
                    'kodegen' => $gen
                ];

                echo json_encode($data);
            }
            else
            {
                return view('errors/html/error_404');
            }
        }
    }
}