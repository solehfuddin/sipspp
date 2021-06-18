<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use App\Models\LoginModel;
use App\Models\SettingWaModel;
use App\Models\Master\AgamaModel;
use Config\Services;

class SettingWacontroller extends BaseController
{
    public function __construct()
	{
		$this->loginModel = new LoginModel();
	}

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
            $masterAgama = new AgamaModel($request);
            $settingModel = new SettingModel($request);
		    $session = \Config\Services::session();

            $waconf = new SettingWaModel();
            $setting = $waconf->where("id", 1)
                          ->first();

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
                'submenu' => $submenuModel->submenu(),
                'setting' => $setting,
            ];

            return view('view_waconfig', $data);
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
                $check = $this->validate([
                    'settingwa_instance' => [
                        'label' => 'Instance Id',
                        'rules' => 'required',
                        'errors' => [
                            'required' 		=> '{field} wajib terisi'
                        ],
                    ],
                    'settingwa_token' => [
                        'label' => 'Token Id',
                        'rules' => 'required',
                        'errors' => [
                            'required' 		=> '{field} wajib terisi'
                        ],
                    ],
                ]);

                if (!$check) {
                    $msg = [
                        'error' => [
                            "settingwa_instance" => $this->validation->getError('settingwa_instance'),
                            "settingwa_token" => $this->validation->getError('settingwa_token'),
                        ]
                    ];
                }
                else
                {
                    $data = [
                        'token' => $this->request->getVar('settingwa_token'),
                        'instance_id' => $this->request->getVar('settingwa_instance'),
                    ];

                    $kode = 1;
                    $settingwa = new SettingWaModel();

                    $settingwa->update($kode, $data);
    
                    $msg = [
                        'success' => [
                            'data' => 'Berhasil memperbarui data',
                            'link' => base_url() . '/admwasetting'
                        ]
                    ];
                }
    
                echo json_encode($msg);
            }
            else
            {
                return view('errors/html/error_404');
            }
        }
    }
}