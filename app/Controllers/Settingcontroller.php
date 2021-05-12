<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use App\Models\SettingLvlModel;
use App\Models\Master\LevelModel;
use Config\Services;

class Settingcontroller extends BaseController
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
            $masterLevel = new LevelModel($request);
            $masterMenu = new MenuModel($request);
            $settingModel = new SettingModel($request);
		    $session = \Config\Services::session();

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
                'submenu' => $submenuModel->submenu(),
                'levelcode' => $masterLevel->getkodelevel(1),
                'menucode' => $masterMenu->menu(),
            ];

            return view('datasetting/view_setting', $data);
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
                $m_setting  = new SettingLvlModel($request);

                if($request->getMethod(true)=='POST'){
                    $lists = $m_setting->get_datatables();
                        $data = [];
                        $no = $request->getPost("start");

                        foreach ($lists as $list) {
                                $no++;
                                $row = [];

                                $tomboledit = "<button type=\"button\" class=\"btn btn-warning btn-sm btneditinfocategory\"
                                                onclick=\"editsetting('" .$list->inc_setting. "')\">
                                                <i class=\"fa fa-edit\"></i></button>";

                                $tombolhapus = "<button type=\"button\" class=\"btn btn-danger btn-sm\" 
                                                onclick=\"deletesetting('" .$list->inc_setting. "')\"> 
                                                <i class=\"fa fa-trash\"></i></button>";

                                $row[] = $no;
                                if ($list->isactive_setting == 1)
                                {
                                    $isactive = "<span style='color:#2dce89;'>Aktif</span";
                                }
                                else
                                {
                                    $isactive = "<span style='color:#f5365c;'>Tidak Aktif</span";
                                }
                                
                                $row[] = $list->nama_level;
                                $row[] = $list->nama_menu;
                                $row[] = $isactive;
                                $row[] = $tomboledit .' ' . $tombolhapus;
                                $data[] = $row;
                        }
                    
                        $output = [
                            "draw" => $request->getPost('draw'),
                            "recordsTotal" => $m_setting->count_all(),
                            "recordsFiltered" => $m_setting->count_filtered(),
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

    public function simpandata() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX())
            {
                $request = Services::request();
                $m_setting = new SettingLvlModel($request);

                $data = [
                    'id_level' => $this->request->getVar('setting_level'),
                    'kode_menu' => $this->request->getVar('setting_menu'),
                    'isactive_setting' => $this->request->getVar('setting_isactive'),
                ];

                $m_setting->insert($data);

                $msg = [
                    'success' => [
                       'data' => 'Berhasil menambahkan data',
                       'link' => '/admcattype'
                    ]
                ];
            }
            else
            {
                return view('errors/html/error_404');
            }

            echo json_encode($msg);
        }
    }

    public function pilihdata() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX()) {
                $kode = $this->request->getVar('kode');
                $request = Services::request();
                $m_setting = new SettingLvlModel($request);

                $item = $m_setting->find($kode);
    
                $data = [
                    'success' => [
                        'inc' => $item['inc_setting'],
                        'kode' => $item['id_level'],
                        'menu' => $item['kode_menu'],
                        'status' => $item['isactive_setting'],
                    ]
                ];
    
                echo json_encode($data);
            }
            else
            {
                return view('errors/html/error_404');
            }
        }
    }

    public function perbaruidata() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX())
            {
                $data = [
                    'id_level' => $this->request->getVar('setting_levelubah'),
                    'kode_menu' => $this->request->getVar('setting_menuubah'),
                    'isactive_setting' => $this->request->getVar('setting_isactiveubah'),
                ];

                $kode = $this->request->getVar('setting_kodeubah');

                $request = Services::request();
                $m_setting = new SettingLvlModel($request);

                $m_setting->update($kode, $data);

                $msg = [
                    'success' => [
                        'data' => 'Berhasil memperbarui data',
                        'link' => '/admcattype'
                    ]
                ];
    
                echo json_encode($msg);
            }
            else
            {
                return view('errors/html/error_404');
            }
        }
    }

    public function hapusdata() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX()) {
                $kode = $this->request->getVar('kode');
                $request = Services::request();
                $m_setting = new SettingLvlModel($request);
    
                $m_setting->delete($kode);
    
                $msg = [
                    'success' => [
                        'data' => 'Berhasil menghapus data dengan kode ' . $kode,
                        'link' => '/admcattype'
                     ]
                ];
            }
            else
            {
                return view('errors/html/error_404');
            }
    
            echo json_encode($msg);
        }
    }    
}