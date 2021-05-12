<?php 
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\KelasModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use Config\Services;

class Kelascontroller extends BaseController
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

            return view('menumaster/view_masterkelas', $data);
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
                $m_kelas  = new KelasModel($request);

                if($request->getMethod(true)=='POST'){
                    $lists = $m_kelas->get_datatables();
                        $data = [];
                        $no = $request->getPost("start");

                        foreach ($lists as $list) {
                                $no++;
                                $row = [];

                                $tomboledit = "<button type=\"button\" class=\"btn btn-warning btn-sm btneditinfocategory\"
                                                onclick=\"editmasterkelas('" .$list->id_kelas. "')\">
                                                <i class=\"fa fa-edit\"></i></button>";

                                $tombolhapus = "<button type=\"button\" class=\"btn btn-danger btn-sm\" 
                                                onclick=\"deletemasterkelas('" .$list->id_kelas. "')\"> 
                                                <i class=\"fa fa-trash\"></i></button>";

                                $row[] = $no;
                                if ($list->isactive_kelas == 1)
                                {
                                    $isactive = "<span style='color:#2dce89;'>Aktif</span";
                                }
                                else
                                {
                                    $isactive = "<span style='color:#f5365c;'>Tidak Aktif</span";
                                }
                                
                                $row[] = $isactive;
                                $row[] = $list->nama_kelas;
                                $row[] = $list->deskripsi_kelas;
                                $row[] = $tomboledit . ' ' . $tombolhapus;
                                $data[] = $row;
                        }
                    
                        $output = [
                            "draw" => $request->getPost('draw'),
                            "recordsTotal" => $m_kelas->count_all(),
                            "recordsFiltered" => $m_kelas->count_filtered(),
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
                $m_kelas = new KelasModel($request);

                $getdata = $m_kelas->getLastData();
                $max  = substr($getdata->id_kelas, 4) + 1;
                $gen  = "MKLS" . str_pad($max, 4, 0, STR_PAD_LEFT);

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
                    'masterkelas_kode' => [
                        'label' => 'Kode kelas',
                        'rules' => [
                            'required',
                            'is_unique[master_kelas.id_kelas]',
                        ],
                        'errors' => [
                            'required' 		=> '{field} wajib terisi',
                            'is_unique'	    => '{field} tidak boleh sama, coba dengan kode yang lain'
                        ],
                    ],
    
                    'masterkelas_nama' => [
                        'label' => 'Nama kelas',
                        'rules' => [
                            'required',
                            'is_unique[master_kelas.nama_kelas]',
                        ],
                        'errors' => [
                            'required' 		=> '{field} wajib terisi',
                            'is_unique'	    => '{field} tidak boleh sama, masukkan nama kelas yang lain'
                        ],
                    ],

                    'masterkelas_desc' => [
                        'label' => 'Deskripsi kelas',
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
						"masterkelas_kode" => $this->validation->getError('masterkelas_kode'),
                        "masterkelas_nama" => $this->validation->getError('masterkelas_nama'),
						"masterkelas_desc" => $this->validation->getError('masterkelas_desc'),
					]
				];
			}
			else
			{
                $data = [
                    'id_kelas' => $this->request->getVar('masterkelas_kode'),
                    'nama_kelas' => $this->request->getVar('masterkelas_nama'),
                    'deskripsi_kelas' => $this->request->getVar('masterkelas_desc'),
                    'isactive_kelas' => $this->request->getVar('masterkelas_isactive'),
                ];

                $request = Services::request();
                $m_kelas = new KelasModel($request);

                $m_kelas->insert($data);

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
                $m_kelas = new KelasModel($request);

                $item = $m_kelas->find($kode);
    
                $data = [
                    'success' => [
                        'kode' => $item['id_kelas'],
                        'nama' => $item['nama_kelas'],
                        'deskripsi' => $item['deskripsi_kelas'],
                        'is_active' => $item['isactive_kelas'],
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
                    'masterkelas_descubah' => [
                        'label' => 'Ubah deskripsi kelas',
                        'rules' => 'required',
                        'errors' => [
                            'required' 		=> '{field} wajib terisi'
                        ],
                    ],
                ]);

                if (!$check) {
                    $msg = [
                        'error' => [
                            "masterkelas_descubah" => $this->validation->getError('masterkelas_descubah'),
                        ]
                    ];
                }
                else
                {
                    $request = Services::request();
                    $m_kelas = new KelasModel($request);

                    $kode  = $this->request->getVar('masterkelas_kodeubah');
                    $tmp   = $m_kelas->checkalias($kode);
                    $tmpCheck = $tmp[0]['nama_kelas'];
                    $alias = $this->request->getVar('masterkelas_namaubah');

                    if ($tmpCheck == $alias)
                    {
                        $data = [
                            'nama_kelas' => $this->request->getVar('masterkelas_namaubah'),
                            'deskripsi_kelas' => $this->request->getVar('masterkelas_descubah'),
                            'isactive_kelas' => $this->request->getVar('masterkelas_isactiveubah'),
                        ];
        
                        $kode = $this->request->getVar('masterkelas_kodeubah');
        
                        $request = Services::request();
                        $m_kelas = new KelasModel($request);
    
                        $m_kelas->update($kode, $data);
        
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
                            'masterkelas_namaubah' => [
                                'label' => 'Ubah nama kelas',
                                'rules' => [
                                    'required',
                                    'is_unique[master_kelas.nama_kelas]',
                                ],
                                'errors' => [
                                    'required' 		=> '{field} wajib terisi',
                                    'is_unique'	    => '{field} tidak boleh sama, masukkan nama kelas yang lain'
                                ],
                            ],
                        ]);
    
                        if (!$checkalias) {
                            $msg = [
                                'error' => [
                                    "masterkelas_namaubah" => $this->validation->getError('masterkelas_namaubah'),
                                ]
                            ];
                        }
                        else
                        {
                            $data = [
                                'nama_kelas' => $this->request->getVar('errormasterkelasNamaubah'),
                                'deskripsi_kelas' => $this->request->getVar('masterkelas_descubah'),
                                'isactive_kelas' => $this->request->getVar('masterkelas_isactiveubah'),
                            ];
            
                            $kode = $this->request->getVar('masterkelas_kodeubah');
            
                            $request = Services::request();
                            $m_kelas = new KelasModel($request);
        
                            $m_kelas->update($kode, $data);
            
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
                $m_kelas = new KelasModel($request);
    
                $m_kelas->delete($kode);
    
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