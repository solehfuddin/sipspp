<?php 
namespace App\Controllers\Master;
use App\Controllers\BaseController;
use App\Models\Master\LevelModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use Config\Services;

class Levelcontroller extends BaseController
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

            return view('menumaster/view_masterlevel', $data);
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
                $m_level  = new LevelModel($request);

                if($request->getMethod(true)=='POST'){
                    $lists = $m_level->get_datatables();
                        $data = [];
                        $no = $request->getPost("start");

                        foreach ($lists as $list) {
                                $no++;
                                $row = [];

                                $tomboledit = "<button type=\"button\" class=\"btn btn-warning btn-sm btneditinfocategory\"
                                                onclick=\"editmasterlevel('" .$list->id_level. "')\">
                                                <i class=\"fa fa-edit\"></i></button>";

                                $tombolhapus = "<button type=\"button\" class=\"btn btn-danger btn-sm\" 
                                                onclick=\"deletemasterlevel('" .$list->id_level. "')\"> 
                                                <i class=\"fa fa-trash\"></i></button>";

                                $row[] = $no;
                                if ($list->isactive_level == 1)
                                {
                                    $isactive = "<span style='color:#2dce89;'>Aktif</span";
                                }
                                else
                                {
                                    $isactive = "<span style='color:#f5365c;'>Tidak Aktif</span";
                                }
                                
                                $row[] = $isactive;
                                $row[] = $list->nama_level;
                                $row[] = $list->deskripsi_level;
                                $row[] = $tomboledit . ' ' . $tombolhapus;
                                $data[] = $row;
                        }
                    
                        $output = [
                            "draw" => $request->getPost('draw'),
                            "recordsTotal" => $m_level->count_all(),
                            "recordsFiltered" => $m_level->count_filtered(),
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
                $m_level = new LevelModel($request);

                $getdata = $m_level->getLastData();
                $max  = substr($getdata->id_level, 3) + 1;
                $gen  = "MLV" . str_pad($max, 2, 0, STR_PAD_LEFT);

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
                    'masterlevel_kode' => [
                        'label' => 'Kode level',
                        'rules' => [
                            'required',
                            'is_unique[master_level.id_level]',
                        ],
                        'errors' => [
                            'required' 		=> '{field} wajib terisi',
                            'is_unique'	    => '{field} tidak boleh sama, coba dengan kode yang lain'
                        ],
                    ],
    
                    'masterlevel_nama' => [
                        'label' => 'Nama level',
                        'rules' => [
                            'required',
                            'is_unique[master_level.nama_level]',
                        ],
                        'errors' => [
                            'required' 		=> '{field} wajib terisi',
                            'is_unique'	    => '{field} tidak boleh sama, masukkan nama level yang lain'
                        ],
                    ],

                    'masterlevel_desc' => [
                        'label' => 'Deskripsi level',
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
						"masterlevel_kode" => $this->validation->getError('masterlevel_kode'),
                        "masterlevel_nama" => $this->validation->getError('masterlevel_nama'),
						"masterlevel_desc" => $this->validation->getError('masterlevel_desc'),
					]
				];
			}
			else
			{
                $data = [
                    'id_level' => $this->request->getVar('masterlevel_kode'),
                    'nama_level' => $this->request->getVar('masterlevel_nama'),
                    'deskripsi_level' => $this->request->getVar('masterlevel_desc'),
                    'isactive_level' => $this->request->getVar('masterlevel_isactive'),
                ];

                $request = Services::request();
                $m_level = new LevelModel($request);

                $m_level->insert($data);

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
                $m_level = new LevelModel($request);

                $item = $m_level->find($kode);
    
                $data = [
                    'success' => [
                        'kode' => $item['id_level'],
                        'nama' => $item['nama_level'],
                        'deskripsi' => $item['deskripsi_level'],
                        'is_active' => $item['isactive_level'],
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
                    'masterlevel_descubah' => [
                        'label' => 'Ubah deskripsi level',
                        'rules' => 'required',
                        'errors' => [
                            'required' 		=> '{field} wajib terisi'
                        ],
                    ],
                ]);

                if (!$check) {
                    $msg = [
                        'error' => [
                            "masterlevel_namaubah" => $this->validation->getError('masterlevel_namaubah'),
                            "masterlevel_descubah" => $this->validation->getError('masterlevel_descubah'),
                        ]
                    ];
                }
                else
                {
                    $request = Services::request();
                    $m_level = new LevelModel($request);

                    $kode  = $this->request->getVar('masterlevel_kodeubah');
                    $tmp   = $m_level->checkalias($kode);
                    $tmpCheck = $tmp[0]['nama_level'];
                    $alias = $this->request->getVar('masterlevel_namaubah');

                    if ($tmpCheck == $alias)
                    {
                        $data = [
                            'nama_level' => $this->request->getVar('masterlevel_namaubah'),
                            'deskripsi_level' => $this->request->getVar('masterlevel_descubah'),
                            'isactive_level' => $this->request->getVar('masterlevel_isactiveubah'),
                        ];
        
                        $kode = $this->request->getVar('masterlevel_kodeubah');
        
                        $request = Services::request();
                        $m_level = new LevelModel($request);
    
                        $m_level->update($kode, $data);
        
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
                            'masterlevel_namaubah' => [
                                'label' => 'Ubah nama level',
                                'rules' => [
                                    'required',
                                    'is_unique[master_level.nama_level]',
                                ],
                                'errors' => [
                                    'required' 		=> '{field} wajib terisi',
                                    'is_unique'	    => '{field} tidak boleh sama, masukkan nama level yang lain'
                                ],
                            ],
                        ]);
    
                        if (!$checkalias) {
                            $msg = [
                                'error' => [
                                    "masterlevel_namaubah" => $this->validation->getError('masterlevel_namaubah'),
                                ]
                            ];
                        }
                        else
                        {
                            $data = [
                                'nama_level' => $this->request->getVar('masterlevel_namaubah'),
                                'deskripsi_level' => $this->request->getVar('masterlevel_descubah'),
                                'isactive_level' => $this->request->getVar('masterlevel_isactiveubah'),
                            ];
            
                            $kode = $this->request->getVar('masterlevel_kodeubah');
            
                            $request = Services::request();
                            $m_level = new LevelModel($request);
        
                            $m_level->update($kode, $data);
            
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
                $m_level = new LevelModel($request);
    
                $m_level->delete($kode);
    
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