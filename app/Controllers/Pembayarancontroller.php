<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\SiswaModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use Config\Services;

class Pembayarancontroller extends BaseController
{
	public function index() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            $request = Services::request();
            $settingModel = new SettingModel($request);
		    $session = \Config\Services::session();

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
            ];

            return view('datapembayaran/view_pembayaran', $data);
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
                $m_spp  = new PembayaranModel($request);

                if($request->getMethod(true)=='POST'){
                    $lists = $m_spp->get_datatables();
                        $data = [];
                        $no = $request->getPost("start");

                        foreach ($lists as $list) {
                                $no++;
                                $row = [];

                                $tomboledit = "<button type=\"button\" class=\"btn btn-warning btn-sm btneditinfocategory\"
                                                onclick=\"edituser('" .$list->kode_pembayaran. "')\">
                                                <i class=\"fa fa-print\"></i></button>";

                                $row[] = $no;
                                
                                $row[] = $list->nis;
                                $row[] = $list->nama_siswa;
                                $row[] = $list->nama_kelas;
                                $row[] = "<span style='color:#f5365c;'> Rp " . number_format($list->jumlah_bayar, 0, ',', '.') . "</span";
                                $row[] = date("d-m-Y h:m:s", strtotime($list->insert_date));
                                $row[] = $list->tagihan_bulan;
                                $row[] = $list->tagihan_tahun;
                                $row[] = $list->nama_lengkap;
                                $row[] = $tomboledit;
                                $data[] = $row;
                        }
                    
                        $output = [
                            "draw" => $request->getPost('draw'),
                            "recordsTotal" => $m_spp->count_all(),
                            "recordsFiltered" => $m_spp->count_filtered(),
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
                $m_spp = new PembayaranModel($request);
                $gen  = "KWT" . date('dmyhis');

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

    public function listSiswa()
	{
        $request = Services::request();
		$model = new SiswaModel($request);
		$id = $request->getVar('term');
		$siswa = $model->like('nama_siswa', $id)->findAll();
		$w = array();
		foreach($siswa as $rt):
			$w[] = [
				"label" => $rt['nis'],
				"value" => $rt['nama_siswa']
			];
			
		endforeach; 
		echo json_encode($w);		
	}	

    public function getSiswa(){

        $request = Services::request();
        $postData = $request->getPost();
  
        $response = array();

        $data = array();
  
        if(isset($postData['search'])){
  
           $search = $postData['search'];
  
           // Fetch record
           $users = new SiswaModel($request);
           $userlist = $users->select('*')
                  ->like('nama_siswa',$search)
                  ->orderBy('nama_siswa')
                  ->findAll(5);
           foreach($userlist as $user){
               $data[] = array(
                  "value" => $user['nis'],
                  "label" => $user['nama_siswa'],
               );
           }
        }
  
        $response['data'] = $data;
  
        return $this->response->setJSON($response);
  
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
}