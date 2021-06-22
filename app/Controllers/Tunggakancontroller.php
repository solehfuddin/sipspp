<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\TunggakanModel;
use App\Models\SmsModel;
use App\Models\SiswaModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use App\Models\SettingWaModel;
use Config\Services;

class Tunggakancontroller extends BaseController
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

            $stdate = date("m/01/Y");
			$eddate = date("m/d/Y");

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
                'submenu' => $submenuModel->submenu(),
                'start_date' => $stdate,
				'end_date' => $eddate,
            ];

            return view('datatunggakan/view_tunggakan', $data);
        }
    }

    public function showData(){
        $tunggakan = new TunggakanModel();
        $data = $tunggakan->testData();

        dd($data);
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
                $mobNumber = $this->request->getVar('antriansms_nohpubah');
                $msg = $this->request->getVar('antriansms_pesanubah');

                $data = [
                    'kode_pembayaran' => $this->request->getVar('antriansms_kodeubah'),
                    'phone_number' => $mobNumber,
                    'message' => $msg,
                    'status' => 2,
                    'response' => "Notifikasi via WA",
                ];

                $stdate = date("m/01/Y");
			    $eddate = date("m/d/Y");

                $request = Services::request();
                $m_sms = new SmsModel($request, date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate)));

                $m_sms->insert($data);
                $this->sentWA(substr_replace($mobNumber, "+62", 0, 1), $msg);


                $msg = [
                    'success' => [
                       'data' => 'Berhasil menambahkan data',
                       'link' => '/admcattype',
                    ]
                ];
            }

            echo json_encode($msg);
        }
    }

    public function tunggakansms() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX())
            {
                $validationCheck = $this->validate([
                    'tunggakansms_perihal' => [
                        'label' => 'Perihal informasi',
                        'rules' => [
                            'required',
                        ],
                        'errors' => [
                            'required' 		=> '{field} wajib terisi',
                        ],
                    ],

                    'tunggakansms_nohpubah' => [
                        'label' => 'Nomor Hp',
                        'rules' => [
                            'required',
                        ],
                        'errors' => [
                            'required' 		=> '{field} wajib terisi',
                        ],
                    ],
    
                    'tunggakansms_pesanubah' => [
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
                        "tunggakansms_perihal" => $this->validation->getError('tunggakansms_perihal'),
						"tunggakansms_nohpubah" => $this->validation->getError('tunggakansms_nohpubah'),
                        "tunggakansms_pesanubah" => $this->validation->getError('tunggakansms_pesanubah'),
					]
				];
			}
			else
			{
                $mobNumber = $this->request->getVar('tunggakansms_nohpubah');
                $msg = $this->request->getVar('tunggakansms_pesanubah');

                $data = [
                    'kode_pembayaran' => $this->request->getVar('tunggakansms_perihal'),
                    'phone_number' => $mobNumber,
                    'message' => $msg,
                    'status' => 2,
                    'response' => "Notifikasi via WA",
                ];

                $stdate = date("m/01/Y");
			    $eddate = date("m/d/Y");

                $request = Services::request();
                $m_sms = new SmsModel($request, date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate)));

                $m_sms->insert($data);
                $this->sentWA(substr_replace($mobNumber, "+62", 0, 1), $msg);

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

    public function sentWA($mobNumber, $msg)
    {
        $waconf = new SettingWaModel();
        $setting = $waconf->where("id", 1)
                          ->first();

        $data = [
            'phone' => $mobNumber, // Receivers phone
            'body' => $msg, // Message
        ];

        // URL for request POST /message
        $token = $setting['token'];
        $instanceId = $setting['instance_id'];

        $url = 'https://api.chat-api.com/instance'.$instanceId.'/message?token='.$token;

        $ch = curl_init($url);

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10000,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
        ));

        $response = curl_exec( $ch );

        curl_close($ch);

        // echo $response;
    }
}