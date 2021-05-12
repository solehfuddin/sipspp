<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use App\Models\Master\AgamaModel;
use App\Models\Master\LevelModel;
use Config\Services;

class Usercontroller extends BaseController
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
            $masterAgama = new AgamaModel($request);
            $settingModel = new SettingModel($request);
		    $session = \Config\Services::session();

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
                'submenu' => $submenuModel->submenu(),
                'levelcode' => $masterLevel->getkodelevel(1),
                'agamacode' => $masterAgama->getkodeagama(1),
            ];

            return view('datauser/view_user', $data);
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
                $m_user  = new UserModel($request);

                if($request->getMethod(true)=='POST'){
                    $lists = $m_user->get_datatables();
                        $data = [];
                        $no = $request->getPost("start");

                        foreach ($lists as $list) {
                                $no++;
                                $row = [];

                                $tomboledit = "<button type=\"button\" class=\"btn btn-warning btn-sm btneditinfocategory\"
                                                onclick=\"edituser('" .$list->id_user. "')\">
                                                <i class=\"fa fa-edit\"></i></button>";

                                $changepass  = "<button type=\"button\" class=\"btn btn-info btn-sm\"
                                                onclick=\"changepassuser('" .$list->id_user. "')\">
                                                <i class=\"fa fa-lock\"></i></button>";

                                $tombolhapus = "<button type=\"button\" class=\"btn btn-danger btn-sm\" 
                                                onclick=\"deleteuser('" .$list->id_user. "')\"> 
                                                <i class=\"fa fa-trash\"></i></button>";

                                $row[] = $no;
                                if ($list->isactive_user == 1)
                                {
                                    $isactive = "<span style='color:#2dce89;'>Aktif</span";
                                }
                                else
                                {
                                    $isactive = "<span style='color:#f5365c;'>Tidak Aktif</span";
                                }
                                
                                $row[] = $list->nama_lengkap;
                                $row[] = $list->email;
                                $row[] = $list->username;
                                $row[] = $list->nama_level;
                                $row[] = $list->jenis_kelamin;
                                $row[] = $list->no_hp;
                                $row[] = $list->nama_agama;
                                $row[] = $list->alamat;
                                $row[] = $isactive;
                                $row[] = $tomboledit .' ' . $changepass . ' ' . $tombolhapus;
                                $data[] = $row;
                        }
                    
                        $output = [
                            "draw" => $request->getPost('draw'),
                            "recordsTotal" => $m_user->count_all(),
                            "recordsFiltered" => $m_user->count_filtered(),
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
                $m_user = new UserModel($request);

                $getdata = $m_user->getLastData();
                $max  = substr($getdata->id_user, 3) + 1;
                $gen  = "USR" . str_pad($max, 3, 0, STR_PAD_LEFT);

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

    public function simpandata() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX())
            {
                if ( $_FILES AND $_FILES['user_photo']['name'] ) 
                {
                    $validationCheck = $this->validate([
                        'user_kode' => [
                            'label' => 'Kode user',
                            'rules' => [
                                'required',
                                'is_unique[tb_user.id_user]',
                            ],
                            'errors' => [
                                'required' 		=> '{field} wajib terisi',
                                'is_unique'	    => '{field} tidak boleh sama, coba dengan kode yang lain'
                            ],
                        ],
    
                        'user_fname' => [
                            'label' => 'Nama lengkap',
                            'rules' => 'required',
                            'errors' => [
                                'required' 		=> '{field} wajib terisi'
                            ],
                        ],
    
                        'user_uname' => [
                            'label' => 'Username',
                            'rules' => [
                                'required',
                                'is_unique[tb_user.username]',
                            ],
                            'errors' => [
                                'required' 		=> '{field} wajib terisi',
                                'is_unique'	    => '{field} tidak boleh sama, coba dengan username yang unik'
                            ],
                        ],
    
                        'user_pass' => [
                            'label' => 'Password',
                            'rules' => 'required',
                            'errors' => [
                                'required' 		=> '{field} wajib terisi'
                            ],
                        ],
        
                        'user_email' => [
                            'label' => 'Alamat email',
                            'rules' => [
                                'required',
                                'is_unique[tb_user.email]',
                            ],
                            'errors' => [
                                'required' 		=> '{field} wajib terisi',
                                'is_unique'	    => '{field} tidak boleh sama, masukkan nama agama yang lain'
                            ],
                        ],
    
                        'user_photo' => [
                            'label' => 'Gambar',
                            'rules' => [
                                'uploaded[user_photo]',
                                'mime_in[user_photo,image/jpg,image/jpeg,image/gif,image/png]',
                                'is_image[user_photo]',
                                'max_size[user_photo,4096]',
                            ],
                            'errors' => [
                                'uploaded'      => '{field} wajib diisi',
                                'mime_in' 		=> '{field} tidak sesuai format standar',
                                'is_image'      => '{field} tidak sesuai',
                                'max-size'      => '{field} melebihi ukuran yang ditentukan',
                            ],
                        ]
                    ]);
                }
                else
                {
                    $validationCheck = $this->validate([
                        'user_kode' => [
                            'label' => 'Kode user',
                            'rules' => [
                                'required',
                                'is_unique[tb_user.id_user]',
                            ],
                            'errors' => [
                                'required' 		=> '{field} wajib terisi',
                                'is_unique'	    => '{field} tidak boleh sama, coba dengan kode yang lain'
                            ],
                        ],
    
                        'user_fname' => [
                            'label' => 'Nama lengkap',
                            'rules' => 'required',
                            'errors' => [
                                'required' 		=> '{field} wajib terisi'
                            ],
                        ],
    
                        'user_uname' => [
                            'label' => 'Username',
                            'rules' => [
                                'required',
                                'is_unique[tb_user.username]',
                            ],
                            'errors' => [
                                'required' 		=> '{field} wajib terisi',
                                'is_unique'	    => '{field} tidak boleh sama, coba dengan username yang unik'
                            ],
                        ],
    
                        'user_pass' => [
                            'label' => 'Password',
                            'rules' => 'required',
                            'errors' => [
                                'required' 		=> '{field} wajib terisi'
                            ],
                        ],
        
                        'user_email' => [
                            'label' => 'Alamat email',
                            'rules' => [
                                'required',
                                'is_unique[tb_user.email]',
                            ],
                            'errors' => [
                                'required' 		=> '{field} wajib terisi',
                                'is_unique'	    => '{field} tidak boleh sama, masukkan nama agama yang lain'
                            ],
                        ],
                    ]);
                }
            }
            else
            {
                return view('errors/html/error_404');
            }

            if (!$validationCheck) {
				$msg = [
					'error' => [
						"user_kode" => $this->validation->getError('user_kode'),
                        "user_fname" => $this->validation->getError('user_fname'),
						"user_uname" => $this->validation->getError('user_uname'),
                        "user_pass" => $this->validation->getError('user_pass'),
                        "user_email" => $this->validation->getError('user_email'),
                        "user_photo" => $this->validation->getError('user_photo'),
					]
				];
			}
			else
			{
                // if ($this->request->getFile('user_photo') != null)
                // {
                if ( $_FILES AND $_FILES['user_photo']['name'] ) 
                {      
                    $kode = $this->request->getVar('user_kode');
                    $gambar = $this->request->getFile('user_photo');
                    $filename = $kode . '.' . $gambar->getExtension();
    
                    $gambar->move('public/assets/img/profile/', $filename);
                    $location = base_url() . '/public/assets/img/profile/thumbs/' . $filename;
                    $this->compressImg($filename);

                    $data = [
                        'id_user' => $this->request->getVar('user_kode'),
                        'email' => $this->request->getVar('user_email'),
                        'username' => $this->request->getVar('user_uname'),
                        'password' => md5($this->request->getVar('user_pass')),
                        'id_level' => $this->request->getVar('user_level'),
                        'nama_lengkap' => $this->request->getVar('user_fname'),
                        'jenis_kelamin' => $this->request->getVar('user_gender'),
                        'no_hp' => $this->request->getVar('user_phone'),
                        'id_agama' => $this->request->getVar('user_religion'),
                        'alamat' => $this->request->getVar('user_address'),
                        'foto' => $gambar->getName(),
                        'isactive_user' => $this->request->getVar('user_isactive'),
                    ];
                }
                else
                {
                    $data = [
                        'id_user' => $this->request->getVar('user_kode'),
                        'email' => $this->request->getVar('user_email'),
                        'username' => $this->request->getVar('user_uname'),
                        'password' => md5($this->request->getVar('user_pass')),
                        'id_level' => $this->request->getVar('user_level'),
                        'nama_lengkap' => $this->request->getVar('user_fname'),
                        'jenis_kelamin' => $this->request->getVar('user_gender'),
                        'no_hp' => $this->request->getVar('user_phone'),
                        'id_agama' => $this->request->getVar('user_religion'),
                        'alamat' => $this->request->getVar('user_address'),
                        'isactive_user' => $this->request->getVar('user_isactive'),
                    ];
                }
                
                $request = Services::request();
                $m_user = new UserModel($request);

                $m_user->insert($data);

                $msg = [
                    'success' => [
                       'data' => 'Berhasil menambahkan data',
                       'link' => '/admcattype'
                    ]
                ];
            }

            echo json_encode($msg);
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
                $m_user = new UserModel($request);

                $item = $m_user->find($kode);
    
                $data = [
                    'success' => [
                        'kode' => $item['id_user'],
                        'fname' => $item['nama_lengkap'],
                        'email' => $item['email'],
                        'uname' => $item['username'],
                        'pass' => $item['password'],
                        'level' => $item['id_level'],
                        'gender' => $item['jenis_kelamin'],
                        'hp' => $item['no_hp'],
                        'agama' => $item['id_agama'],
                        'alamat' => $item['alamat'],
                        'foto' => $item['foto'],
                        'is_active' => $item['isactive_user'],
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
                if ( $_FILES AND $_FILES['user_photoubah']['name'] ) 
                {
                    $check = $this->validate([
                        'user_fnameubah' => [
                            'label' => 'Nama lengkap',
                            'rules' => 'required',
                            'errors' => [
                                'required' 		=> '{field} wajib terisi'
                            ],
                        ],
    
                        'user_photoubah' => [
                            'label' => 'Gambar',
                            'rules' => [
                                'uploaded[user_photoubah]',
                                'mime_in[user_photoubah,image/jpg,image/jpeg,image/gif,image/png]',
                                'is_image[user_photoubah]',
                                'max_size[user_photoubah,4096]',
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
                        'user_fnameubah' => [
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
                            "user_fnameubah" => $this->validation->getError('user_fnameubah'),
                            "user_unameubah" => $this->validation->getError('user_unameubah'),
                            "user_emailubah" => $this->validation->getError('user_emailubah'),
                            "user_photoubah" => $this->validation->getError('user_photoubah'),
                        ]
                    ];
                }
                else
                {
                    if ( $_FILES AND $_FILES['user_photoubah']['name'] ) 
                    {   
                        $kode = $this->request->getVar('user_kodeubah');
                        $gambar = $this->request->getFile('user_photoubah');
                        $filename = $kode . '.' . $gambar->getExtension();
        
                        $gambar->move('public/assets/img/profile/', $filename);
                        $location = base_url() . '/public/assets/img/profile/thumbs/' . $filename;
                        $this->compressImg($filename);
                     
                        $data = [
                            'email' => $this->request->getVar('user_emailubah'),
                            'username' => $this->request->getVar('user_unameubah'),
                            'id_level' => $this->request->getVar('user_levelubah'),
                            'nama_lengkap' => $this->request->getVar('user_fnameubah'),
                            'jenis_kelamin' => $this->request->getVar('user_genderubah'),
                            'no_hp' => $this->request->getVar('user_phoneubah'),
                            'id_agama' => $this->request->getVar('user_religionubah'),
                            'alamat' => $this->request->getVar('user_addressubah'),
                            'foto' => $gambar->getName(),
                            'isactive_user' => $this->request->getVar('user_isactiveubah'),
                        ];

                        $kode = $this->request->getVar('user_kodeubah');
    
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
                    else
                    {
                        $data = [
                            'email' => $this->request->getVar('user_emailubah'),
                            'username' => $this->request->getVar('user_unameubah'),
                            'id_level' => $this->request->getVar('user_levelubah'),
                            'nama_lengkap' => $this->request->getVar('user_fnameubah'),
                            'jenis_kelamin' => $this->request->getVar('user_genderubah'),
                            'no_hp' => $this->request->getVar('user_phoneubah'),
                            'id_agama' => $this->request->getVar('user_religionubah'),
                            'alamat' => $this->request->getVar('user_addressubah'),
                            'isactive_user' => $this->request->getVar('user_isactiveubah'),
                        ];

                        $kode = $this->request->getVar('user_kodeubah');
    
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

    public function ubahpassword() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX())
            {
                $check = $this->validate([
                    'user_changepass' => [
                        'label' => 'Password baru',
                        'rules' => 'required',
                        'errors' => [
                            'required' 		=> '{field} wajib terisi'
                        ],
                    ],

                    'user_confirmchangepass' => [
                        'label' => 'Ulangi Password',
                        'rules' => 'required',
                        'errors' => [
                            'required' 		=> '{field} wajib terisi'
                        ],
                    ],
                ]);

                if (!$check) {
                    $msg = [
                        'error' => [
                            "user_changepass" => $this->validation->getError('user_changepass'),
                            "user_confirmchangepass" => $this->validation->getError('user_confirmchangepass'),
                        ]
                    ];
                }
                else
                { 
                    $newpass = $this->request->getVar('user_changepass');
                    $repass  = $this->request->getVar('user_confirmchangepass'); 

                    if ($newpass == $repass)
                    {
                        $data = [
                            'password' => md5($newpass),
                        ];

                        $kode = $this->request->getVar('user_kodechangepass');
    
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
                    else
                    {
                        
                        $msg = [
                            'notmatch' => [
                                'data' => 'Uppss, sepertinya passwordmu tidak sesuai',
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
                $m_user = new UserModel($request);
    
                $m_user->delete($kode);
    
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