<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\SiswaModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use App\Models\Master\AgamaModel;
use App\Models\Master\KelasModel;
use Config\Services;

class Siswacontroller extends BaseController
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
            $masterKelas = new KelasModel($request);
            $masterAgama = new AgamaModel($request);
            $settingModel = new SettingModel($request);
		    $session = \Config\Services::session();

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
                'kelascode' => $masterKelas->getkodekelas(1),
                'submenu' => $submenuModel->submenu(),
                'agamacode' => $masterAgama->getkodeagama(1),
            ];

            return view('datasiswa/view_siswa', $data);
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
                $m_siswa  = new SiswaModel($request);

                if($request->getMethod(true)=='POST'){
                    $lists = $m_siswa->get_datatables();
                        $data = [];
                        $no = $request->getPost("start");

                        foreach ($lists as $list) {
                                $no++;
                                $row = [];

                                $tomboledit = "<button type=\"button\" class=\"btn btn-warning btn-sm btneditinfocategory\"
                                                onclick=\"editsiswa('" .$list->nis. "')\">
                                                <i class=\"fa fa-edit\"></i></button>";

                                $tombolhapus = "<button type=\"button\" class=\"btn btn-danger btn-sm\" 
                                                onclick=\"deletesiswa('" .$list->nis. "')\"> 
                                                <i class=\"fa fa-trash\"></i></button>";

                                $row[] = $no;

                                $tgl = date("d-m-Y", strtotime($list->tanggal_lahir));

                                $row[] = $list->nis;
                                $row[] = $list->nama_siswa;
                                $row[] = $list->nama_kelas;
                                $row[] = $list->jenis_kelamin;
                                $row[] = $list->tempat_lahir;
                                $row[] = $tgl;
                                $row[] = $list->nama_agama;
                                $row[] = $list->tlp_hp;
                                $row[] = $list->alamat;
                                $row[] = $tomboledit .' ' . $tombolhapus;
                                $data[] = $row;
                        }
                    
                        $output = [
                            "draw" => $request->getPost('draw'),
                            "recordsTotal" => $m_siswa->count_all(),
                            "recordsFiltered" => $m_siswa->count_filtered(),
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
                if ( $_FILES AND $_FILES['siswa_photo']['name'] ) 
                {
                    $validationCheck = $this->validate([
                        'siswa_nis' => [
                            'label' => 'Nomor Induk Siswa',
                            'rules' => [
                                'required',
                                'is_unique[tb_siswa.nis]',
                            ],
                            'errors' => [
                                'required' 		=> '{field} wajib terisi',
                                'is_unique'	    => '{field} tidak boleh sama, coba dengan kode yang lain'
                            ],
                        ],
    
                        'siswa_name' => [
                            'label' => 'Nama siswa',
                            'rules' => 'required',
                            'errors' => [
                                'required' 		=> '{field} wajib terisi'
                            ],
                        ],
    
                        'siswa_photo' => [
                            'label' => 'Gambar',
                            'rules' => [
                                'uploaded[siswa_photo]',
                                'mime_in[siswa_photo,image/jpg,image/jpeg,image/gif,image/png]',
                                'is_image[siswa_photo]',
                                'max_size[siswa_photo,4096]',
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
                        'siswa_nis' => [
                            'label' => 'Nomor Induk Siswa',
                            'rules' => [
                                'required',
                                'is_unique[tb_siswa.nis]',
                            ],
                            'errors' => [
                                'required' 		=> '{field} wajib terisi',
                                'is_unique'	    => '{field} tidak boleh sama, coba dengan kode yang lain'
                            ],
                        ],
    
                        'siswa_name' => [
                            'label' => 'Nama siswa',
                            'rules' => 'required',
                            'errors' => [
                                'required' 		=> '{field} wajib terisi'
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
						"siswa_nis" => $this->validation->getError('siswa_nis'),
                        "siswa_name" => $this->validation->getError('siswa_name'),
						"siswa_photo" => $this->validation->getError('siswa_photo'),
					]
				];
			}
			else
			{
                if ( $_FILES AND $_FILES['siswa_photo']['name'] ) 
                {      
                    $kode = $this->request->getVar('siswa_nis');
                    $gambar = $this->request->getFile('siswa_photo');
                    $filename = $kode . '.' . $gambar->getExtension();
    
                    $gambar->move('public/assets/img/siswa/', $filename);
                    $location = base_url() . '/public/assets/img/siswa/thumbs/' . $filename;
                    $this->compressImg($filename);

                    $data = [
                        'nis' => $this->request->getVar('siswa_nis'),
                        'nama_siswa' => $this->request->getVar('siswa_name'),
                        'tempat_lahir' => $this->request->getVar('siswa_place'),
                        'tanggal_lahir' => date("Y-m-d", strtotime($this->request->getVar('siswa_born'))),
                        'id_kelas' => $this->request->getVar('siswa_class'),
                        'jenis_kelamin' => $this->request->getVar('siswa_gender'),
                        'tlp_hp' => $this->request->getVar('siswa_phone'),
                        'id_agama' => $this->request->getVar('siswa_religion'),
                        'alamat' => $this->request->getVar('siswa_address'),
                        'foto' => $gambar->getName(),
                    ];
                }
                else
                {
                    $data = [
                        'nis' => $this->request->getVar('siswa_nis'),
                        'nama_siswa' => $this->request->getVar('siswa_name'),
                        'tempat_lahir' => $this->request->getVar('siswa_place'),
                        'tanggal_lahir' => date("Y-m-d", strtotime($this->request->getVar('siswa_born'))),
                        'id_kelas' => $this->request->getVar('siswa_class'),
                        'jenis_kelamin' => $this->request->getVar('siswa_gender'),
                        'tlp_hp' => $this->request->getVar('siswa_phone'),
                        'id_agama' => $this->request->getVar('siswa_religion'),
                        'alamat' => $this->request->getVar('siswa_address'),
                    ];
                }
                
                $request = Services::request();
                $m_siswa = new SiswaModel($request);

                $m_siswa->insert($data);

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
        ->withFile('public/assets/img/siswa/' . $filename)
		//->withFile(WRITEPATH.'uploads/' . $filename)
        ->fit(350, 350, 'center')
		->save('public/assets/img/siswa/thumbs/' . $filename, 75);
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
                $m_siswa = new SiswaModel($request);

                $item = $m_siswa->find($kode);
    
                $data = [
                    'success' => [
                        'kode' => $item['nis'],
                        'name' => $item['nama_siswa'],
                        'place' => $item['tempat_lahir'],
                        'born' => date("m/d/Y", strtotime($item['tanggal_lahir'])),
                        'class' => $item['id_kelas'],
                        'gender' => $item['jenis_kelamin'],
                        'hp' => $item['tlp_hp'],
                        'agama' => $item['id_agama'],
                        'alamat' => $item['alamat'],
                        'foto' => $item['foto'],
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
                if ( $_FILES AND $_FILES['siswa_photoubah']['name'] ) 
                {
                    $check = $this->validate([
                        'siswa_nameubah' => [
                            'label' => 'Nama lengkap',
                            'rules' => 'required',
                            'errors' => [
                                'required' 		=> '{field} wajib terisi'
                            ],
                        ],
    
                        'siswa_photoubah' => [
                            'label' => 'Gambar',
                            'rules' => [
                                'uploaded[siswa_photoubah]',
                                'mime_in[siswa_photoubah,image/jpg,image/jpeg,image/gif,image/png]',
                                'is_image[siswa_photoubah]',
                                'max_size[siswa_photoubah,4096]',
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
                        'siswa_nameubah' => [
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
                            "siswa_nameubah" => $this->validation->getError('siswa_nameubah'),
                            "siswa_photoubah" => $this->validation->getError('siswa_photoubah'),
                        ]
                    ];
                }
                else
                {
                    if ( $_FILES AND $_FILES['siswa_photoubah']['name'] ) 
                    {   
                        $kode = $this->request->getVar('siswa_nisubah');
                        $gambar = $this->request->getFile('siswa_photoubah');
                        $filename = $kode . '.' . $gambar->getExtension();
        
                        $gambar->move('public/assets/img/siswa/', $filename);
                        $location = base_url() . '/public/assets/img/siswa/thumbs/' . $filename;
                        $this->compressImg($filename);
                     
                        $data = [
                            'nama_siswa' => $this->request->getVar('siswa_nameubah'),
                            'tempat_lahir' => $this->request->getVar('siswa_placeubah'),
                            'tanggal_lahir' => date("Y-m-d", strtotime($this->request->getVar('siswa_bornubah'))),
                            'id_kelas' => $this->request->getVar('siswa_classubah'),
                            'jenis_kelamin' => $this->request->getVar('siswa_genderubah'),
                            'tlp_hp' => $this->request->getVar('siswa_phoneubah'),
                            'id_agama' => $this->request->getVar('siswa_religionubah'),
                            'alamat' => $this->request->getVar('siswa_addressubah'),
                            'foto' => $gambar->getName(),
                        ];

                        $kode = $this->request->getVar('siswa_nisubah');
    
                        $request = Services::request();
                        $m_siswa = new SiswaModel($request);
    
                        $m_siswa->update($kode, $data);
        
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
                            'nama_siswa' => $this->request->getVar('siswa_nameubah'),
                            'tempat_lahir' => $this->request->getVar('siswa_placeubah'),
                            'tanggal_lahir' => date("Y-m-d", strtotime($this->request->getVar('siswa_bornubah'))),
                            'id_kelas' => $this->request->getVar('siswa_classubah'),
                            'jenis_kelamin' => $this->request->getVar('siswa_genderubah'),
                            'tlp_hp' => $this->request->getVar('siswa_phoneubah'),
                            'id_agama' => $this->request->getVar('siswa_religionubah'),
                            'alamat' => $this->request->getVar('siswa_addressubah'),
                        ];

                        $kode = $this->request->getVar('siswa_nisubah');
    
                        $request = Services::request();
                        $m_siswa = new SiswaModel($request);
    
                        $m_siswa->update($kode, $data);
        
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
                $m_siswa = new SiswaModel($request);
    
                $m_siswa->delete($kode);
    
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
    
    function alphabet_to_number($string) {
        $string = strtoupper($string);
        $length = strlen($string);
        $number = 0;
        $level = 1;
        while ($length >= $level ) {
            $char = $string[$length - $level];
            $c = ord($char) - 64;        
            $number += $c * (26 ** ($level-1));
            $level++;
        }
        return $number;
    }

    public function proses() {
        try
        {
            $request = Services::request();
            $m_siswa = new SiswaModel($request);
            $file = $this->request->getFile('mastersiswa_file');

            $ext  = $file->getClientExtension();
            // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            // $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($ext);

            if ($ext == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }
            else
            {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($file);
            $actsheet = $spreadsheet->getActiveSheet();
            $sheet = $spreadsheet->getActiveSheet()->toArray();

            $highestColumn = $actsheet->getHighestColumn();
            $totalColumn   = $this->alphabet_to_number($highestColumn);

            // echo $totalColumn;

            if ($totalColumn != 4)
            {
                // echo "Format file tidak sesuai";
                session()->setFlashdata('error', "Excel yang dimasukkan tidak sesuai");
                return redirect()->to(base_url('admmasterreferal'));
            }
            else
            {
                if (!empty($sheet)) {
                    foreach ($sheet as $x => $excel) {
                        if ($x == 0){
                            continue;
                        }
        
                        // $cek = $m_siswa->cekData($excel['0']);
                        // if ($excel['0'] == $cek['kode_referal']){
                        //     continue;
                        // }
        
                        $data = [
                            'nis' => $excel['0'],
                            'id_agama' => $excel['1'],
                            'id_kelas' => $excel['2'],
                            'nama_siswa' => $excel['3'],
                            'jenis_kelamin' => $excel['4'],
                            'tampat_lahir' => $excel['5'],
                            'tanggal_lahir' => $excel['6'],
                            'tlp_hp' => $excel['7'],
                            'alamat' => $excel['8'],
                        ];
        
                        $m_siswa->insert($data);
                    }
                }
                
                session()->setFlashdata('message', 'Import success');
                return redirect()->to(base_url('admsiswa'));
            }
        }
        catch(\Exception $e)
        {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to(base_url('admsiswa'));
        }
    }
}