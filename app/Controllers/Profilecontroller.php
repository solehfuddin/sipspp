<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use App\Models\LoginModel;
use App\Models\Master\AgamaModel;
use Config\Services;

class Profilecontroller extends BaseController
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

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
                'submenu' => $submenuModel->submenu(),
                'agamacode' => $masterAgama->getkodeagama(1),
            ];

            return view('view_profile', $data);
        }
    }

    function compressImg($filename) {
        $thumbnail = \Config\Services::image()
        ->withFile('public/assets/img/profile/' . $filename)
		//->withFile(WRITEPATH.'uploads/' . $filename)
        ->fit(350, 350, 'center')
		->save('public/assets/img/profile/thumbs/' . $filename, 75);
        //->save(WRITEPATH.'uploads/thumbs/' . $filename, 75);
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
                if ( $_FILES AND $_FILES['profile_photo']['name'] ) 
                {
                    $check = $this->validate([
                        'profile_fname' => [
                            'label' => 'Nama lengkap',
                            'rules' => 'required',
                            'errors' => [
                                'required' 		=> '{field} wajib terisi'
                            ],
                        ],
    
                        'profile_photo' => [
                            'label' => 'Gambar',
                            'rules' => [
                                'uploaded[profile_photo]',
                                'mime_in[profile_photo,image/jpg,image/jpeg,image/gif,image/png]',
                                'is_image[profile_photo]',
                                'max_size[profile_photo,4096]',
                            ],
                            'errors' => [
                                'uploaded'      => '{field} wajib diisi',
                                'mime_in' 		=> '{field} tidak sesuai format standar',
                                'is_image'      => '{field} tidak sesuai',
                                'max-size'      => '{field} melebihi ukuran yang ditentukan',
                            ],
                        ],
                    ]);
                }
                else
                {
                    $check = $this->validate([
                        'profile_fname' => [
                            'label' => 'Nama lengkap',
                            'rules' => 'required',
                            'errors' => [
                                'required' 		=> '{field} wajib terisi'
                            ],
                        ],
                    ]);
                }

                if (!$check) {
                    $msg = [
                        'error' => [
                            "profile_fname" => $this->validation->getError('profile_fname'),
                            "profile_photo" => $this->validation->getError('profile_photo'),
                        ]
                    ];
                }
                else
                {
                    if ( $_FILES AND $_FILES['profile_photo']['name'] ) 
                    {   
                        $kode = $this->request->getVar('profile_kode');
                        $gambar = $this->request->getFile('profile_photo');
                        $filename = $kode . '.' . $gambar->getExtension();
        
                        $gambar->move('public/assets/img/profile/', $filename);
                        $location = base_url() . '/public/assets/img/profile/thumbs/' . $filename;
                        $this->compressImg($filename);
                     
                        $data = [
                            'email' => $this->request->getVar('profile_email'),
                            'nama_lengkap' => $this->request->getVar('profile_fname'),
                            'no_hp' => $this->request->getVar('profile_phone'),
                            'alamat' => $this->request->getVar('profile_address'),
                            'foto' => $gambar->getName(),
                        ];

                        $kode = $this->request->getVar('profile_kode');
    
                        $request = Services::request();
                        $m_user = new UserModel($request);
                        $m_user->update($kode, $data);

                        // $this->session->destroy();
                        $mailCheck = $this->loginModel->loginbyuserid($kode);

                        $saveSession = [
                            'islogin' => true,
                            'kodeuser' => $mailCheck[0]['id_user'],
                            'username' => $mailCheck[0]['username'],
                            'namalengkap' => $mailCheck[0]['nama_lengkap'],
                            'alamatemail' => $mailCheck[0]['email'],
                            'idlevel'	=> $mailCheck[0]['id_level'],
                            'namalevel' => $mailCheck[0]['nama_level'],
                            'jeniskelamin' => $mailCheck[0]['jenis_kelamin'],
                            'idagama'	=> $mailCheck[0]['id_agama'],
                            'alamat' => $mailCheck[0]['alamat'],
                            'nohp' => $mailCheck[0]['no_hp'],
                            'foto' => $mailCheck[0]['foto'],
                        ];

                        $this->session->set($saveSession);
        
                        $msg = [
                            'success' => [
                                // 'data' => 'Berhasil memperbarui data, harap logout aplikasi anda untuk melihat perubahan data profil',
                                'data' => 'Berhasil memperbarui data',
                                'link' => base_url() . '/admprofile'
                            ]
                        ];
                    }
                    else
                    {
                        $data = [
                            'email' => $this->request->getVar('profile_email'),
                            'nama_lengkap' => $this->request->getVar('profile_fname'),
                            'no_hp' => $this->request->getVar('profile_phone'),
                            'alamat' => $this->request->getVar('profile_address'),
                        ];

                        $kode = $this->request->getVar('profile_kode');
    
                        $request = Services::request();
                        $m_user = new UserModel($request);
    
                        $m_user->update($kode, $data);
        
                        $msg = [
                            'success' => [
                                'data' => 'Berhasil memperbarui data',
                                'link' => '/admcattype'
                            ]
                        ];
                    }
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