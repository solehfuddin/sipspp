<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
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

            $data = [
                'menu' => $menuModel->menu(),
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
                                $row[] = $tomboledit . ' ' . $tombolhapus;
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
                $m_agama = new AgamaModel($request);

                $item = $m_agama->find($kode);
    
                $data = [
                    'success' => [
                        'kode' => $item['id_agama'],
                        'nama' => $item['nama_agama'],
                        'deskripsi' => $item['deskripsi_agama'],
                        'is_active' => $item['isactive_agama'],
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
                $check = $this->validate([
                    'masteragama_descubah' => [
                        'label' => 'Ubah deskripsi agama',
                        'rules' => 'required',
                        'errors' => [
                            'required' 		=> '{field} wajib terisi'
                        ],
                    ],
                ]);

                if (!$check) {
                    $msg = [
                        'error' => [
                            "masteragama_namaubah" => $this->validation->getError('masteragama_namaubah'),
                            "masteragama_descubah" => $this->validation->getError('masteragama_descubah'),
                        ]
                    ];
                }
                else
                {
                    $request = Services::request();
                    $m_agama = new AgamaModel($request);

                    $kode  = $this->request->getVar('masteragama_kodeubah');
                    $tmp   = $m_agama->checkalias($kode);
                    $tmpCheck = $tmp[0]['nama_agama'];
                    $alias = $this->request->getVar('masteragama_namaubah');

                    if ($tmpCheck == $alias)
                    {
                        $data = [
                            'nama_agama' => $this->request->getVar('masteragama_namaubah'),
                            'deskripsi_agama' => $this->request->getVar('masteragama_descubah'),
                            'isactive_agama' => $this->request->getVar('masteragama_isactiveubah'),
                        ];
        
                        $kode = $this->request->getVar('masteragama_kodeubah');
        
                        $request = Services::request();
                        $m_agama = new AgamaModel($request);
    
                        $m_agama->update($kode, $data);
        
                        $msg = [
                            'success' => [
                               'data' => 'Berhasil memperbarui data',
                               'link' => '/admcattype'
                            ]
                        ];
                    }
                    else
                    {
                        $checkalias = $this->validate([
                            'masteragama_namaubah' => [
                                'label' => 'Ubah nama agama',
                                'rules' => [
                                    'required',
                                    'is_unique[master_agama.nama_agama]',
                                ],
                                'errors' => [
                                    'required' 		=> '{field} wajib terisi',
                                    'is_unique'	    => '{field} tidak boleh sama, masukkan nama agama yang lain'
                                ],
                            ],
                        ]);
    
                        if (!$checkalias) {
                            $msg = [
                                'error' => [
                                    "masteragama_namaubah" => $this->validation->getError('masteragama_namaubah'),
                                ]
                            ];
                        }
                        else
                        {
                            $data = [
                                'nama_agama' => $this->request->getVar('masteragama_namaubah'),
                                'deskripsi_agama' => $this->request->getVar('masteragama_descubah'),
                                'isactive_agama' => $this->request->getVar('masteragama_isactiveubah'),
                            ];
            
                            $kode = $this->request->getVar('masteragama_kodeubah');
            
                            $request = Services::request();
                            $m_agama = new AgamaModel($request);
        
                            $m_agama->update($kode, $data);
            
                            $msg = [
                                'success' => [
                                   'data' => 'Berhasil memperbarui data',
                                   'link' => '/admaccountuserlevel'
                                ]
                            ];
                        }
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