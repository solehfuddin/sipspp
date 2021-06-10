<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\SmsModel;
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
            $submenuModel = new SubmenuModel($request);
		    $session = \Config\Services::session();

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
                'submenu' => $submenuModel->submenu(),
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

                                $tombolsms = "<button type=\"button\" class=\"btn btn-info btn-sm btneditinfocategory\"
                                                onclick=\"kirimSms('" .$list->kode_pembayaran. "')\">
                                                <i class=\"fa fa-paper-plane\"></i></button>";

                                $tomboledit = "<a href=" . site_url('pembayarancontroller/cetakResi/') . $list->kode_pembayaran .
                                                " class=\"btn btn-warning btn-sm\" target=\"_blank\">
                                                <i class=\"fa fa-print\"></i></button></a>";

                                $row[] = $no;
                                
                                $row[] = $list->nis;
                                $row[] = $list->nama_siswa;
                                $row[] = $list->nama_kelas;
                                $row[] = "<span style='color:#f5365c;'> Rp " . number_format($list->jumlah_bayar, 0, ',', '.') . "</span";
                                $row[] = date("d-m-Y h:m:s", strtotime($list->insert_date));
                                $row[] = $this->getMonth($list->tagihan_bulan);
                                $row[] = $list->tagihan_tahun;
                                $row[] = $list->nama_lengkap;
                                $row[] = $tombolsms .' ' . $tomboledit;
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
                $validationCheck = $this->validate([
                    'pembayaran_nis' => [
                        'label' => 'Nomor induk siswa',
                        'rules' => 'required',
                        'errors' => [
                            'required' 		=> '{field} wajib terisi'
                        ],
                    ],

                    'pembayaran_biaya' => [
                        'label' => 'Jumlah bayar',
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
						"pembayaran_nis" => $this->validation->getError('pembayaran_nis'),
                        "pembayaran_biaya" => $this->validation->getError('pembayaran_biaya'),
					]
				];
			}
			else
			{
                $data = [
                    'kode_pembayaran' => $this->request->getVar('pembayaran_kode'),
                    'jumlah_bayar' => $this->request->getVar('pembayaran_biayatmp'),
                    'nis' => $this->request->getVar('pembayaran_nis'),
                    'id_user' => $this->session->get('kodeuser'),
                    'tagihan_bulan' => $this->request->getVar('pembayaran_month'),
                    'tagihan_tahun' => $this->request->getVar('pembayaran_year'),
                ];
                
                $request = Services::request();
                $m_spp = new PembayaranModel($request);

                $m_spp->insert($data);

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

    public function cetakResi($no)
    {
        $mpdf = new \Mpdf\Mpdf();
        $request = Services::request();
        $m_spp  = new PembayaranModel($request);

        $dt = $m_spp->checkbykode($no);

        $data = array('data' => $dt);

        $html = view('datapembayaran/view_kwitansi', $data);
        $nama = "kwitansi-" . $no . ".pdf";
        
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $mpdf->Output($nama,'I'); // opens in browser
        //$mpdf->Output('arjun.pdf','D'); // it downloads the file into the user system, with give name
        //return view('welcome_message');
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

    public function reviewsms() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX()) {
                $kode = $this->request->getVar('kode');
                $request = Services::request();
                $m_spp = new PembayaranModel($request);

                $item = $m_spp->checkNoHp($kode);
    
                $data = [
                    'success' => [
                        'kode' => $item['kode_pembayaran'],
                        'nohp' => $item['tlp_hp'],
                        'pesan' => "Pembayaran SPP Bulan " . $this->getMonth($item['tagihan_bulan']) . " a/n " 
                                    . $item['nama_siswa'] . " telah dilunasi pada tanggal " . 
                                    date("d/m/Y", strtotime($item['insert_date'])) . " sebesar Rp. " .
                                    number_format($item['jumlah_bayar'], 0, ',', '.'),
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

    public function antriansms() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX())
            {
                $validationCheck = $this->validate([
                    'antriansms_nohpubah' => [
                        'label' => 'Nomor Hp',
                        'rules' => [
                            'required',
                        ],
                        'errors' => [
                            'required' 		=> '{field} wajib terisi',
                        ],
                    ],
    
                    'antriansms_pesanubah' => [
                        'label' => 'Isi pesan',
                        'rules' => [
                            'required',
                        ],
                        'errors' => [
                            'required' 		=> '{field} wajib terisi', 
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
						"antriansms_nohpubah" => $this->validation->getError('antriansms_nohpubah'),
                        "antriansms_pesanubah" => $this->validation->getError('antriansms_pesanubah'),
					]
				];
			}
			else
			{
                $data = [
                    'kode_pembayaran' => $this->request->getVar('antriansms_kodeubah'),
                    'phone_number' => $this->request->getVar('antriansms_nohpubah'),
                    'message' => $this->request->getVar('antriansms_pesanubah'),
                    'status' => 0,
                    'response' => "Pending",
                ];

                $stdate = date("m/01/Y");
			    $eddate = date("m/d/Y");

                $request = Services::request();
                $m_sms = new SmsModel($request, date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate)));

                $m_sms->insert($data);

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
}