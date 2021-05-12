<?php 
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\AgamaModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
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
            $settingModel = new SettingModel($request);
		    $session = \Config\Services::session();

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
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

                                $tombolhapus = "<button type=\"button\" class=\"btn btn-danger btn-sm\" 
                                                onclick=\"deletemasteragama('" .$list->id_agama. "')\"> 
                                                <i class=\"fa fa-trash\"></i></button>";

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
                                $row[] = $tomboledit . ' ' . $tombolhapus;
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

                $getdata = $m_agama->getLastData();
                $max  = substr($getdata->id_agama, 3) + 1;
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

    public function simpandata() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX())
            {
                $validationCheck = $this->validate([
                    'masteragama_kode' => [
                        'label' => 'Kode agama',
                        'rules' => [
                            'required',
                            'is_unique[master_agama.id_agama]',
                        ],
                        'errors' => [
                            'required' 		=> '{field} wajib terisi',
                            'is_unique'	    => '{field} tidak boleh sama, coba dengan kode yang lain'
                        ],
                    ],
    
                    'masteragama_nama' => [
                        'label' => 'Nama Agama',
                        'rules' => [
                            'required',
                            'is_unique[master_agama.nama_agama]',
                        ],
                        'errors' => [
                            'required' 		=> '{field} wajib terisi',
                            'is_unique'	    => '{field} tidak boleh sama, masukkan nama agama yang lain'
                        ],
                    ],

                    'masteragama_desc' => [
                        'label' => 'Deskripsi agama',
                        'rules' => 'required',
                        'errors' => [
                            'required' 		=> '{field} wajib terisi'
                        ],
                    ],
                ]);
            }
            else
            {
                return view('errors/html/error_404');
            }

            if (!$validationCheck) {
				$msg = [
					'error' => [
						"masteragama_kode" => $this->validation->getError('masteragama_kode'),
                        "masteragama_nama" => $this->validation->getError('masteragama_nama'),
						"masteragama_desc" => $this->validation->getError('masteragama_desc'),
					]
				];
			}
			else
			{
                $data = [
                    'id_agama' => $this->request->getVar('masteragama_kode'),
                    'nama_agama' => $this->request->getVar('masteragama_nama'),
                    'deskripsi_agama' => $this->request->getVar('masteragama_desc'),
                    'isactive_agama' => $this->request->getVar('masteragama_isactive'),
                ];

                $request = Services::request();
                $m_agama = new AgamaModel($request);

                $m_agama->insert($data);

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
                $m_agama = new AgamaModel($request);
    
                $m_agama->delete($kode);
    
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