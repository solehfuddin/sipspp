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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
            $tunggakan = new TunggakanModel();
		    $session = \Config\Services::session();

            $stdate = date("m/01/Y");
			$eddate = date("m/d/Y");

            $stExp = explode('/', $stdate);
            $edExp = explode('/', $eddate);

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
                'submenu' => $submenuModel->submenu(),
                'data' => $tunggakan->getData($stExp[0], $edExp[0], $edExp[2]),
                'start_date' => $stdate,
				'end_date' => $eddate,
            ];

            return view('datatunggakan/view_tunggakan', $data);
        }
    }

    public function filterdata() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            $request = Services::request();
            $settingModel = new SettingModel($request);
            $submenuModel = new SubmenuModel($request);
            $tunggakan = new TunggakanModel();
		    $session = \Config\Services::session();

            $stdate = $this->request->getVar('tunggakan_filterstdate');
			$eddate = $this->request->getVar('tunggakan_filtereddate');

            $stExp = explode('/', $stdate);
            $edExp = explode('/', $eddate);

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
                'submenu' => $submenuModel->submenu(),
                'data' => $tunggakan->getData($stExp[0], $edExp[0], $edExp[2]),
                'start_date' => $stdate,
				'end_date' => $eddate,
            ];

            return view('datatunggakan/view_tunggakan', $data);
        }
    }

    public function proses() {
        $stdate = $this->request->getVar('tunggakan_exportstdate');
		$eddate = $this->request->getVar('tunggakan_exporteddate');

        $stExp = explode('/', $stdate);
        $edExp = explode('/', $eddate);

        $tunggakan = new TunggakanModel();
        $filter = $tunggakan->getData($stExp[0], $edExp[0], $edExp[2]);

        $styleJudul = [
            'font' => [
                'color' => [
                    'rgb' => 'FFFFFF'
                ],
                'bold'=>true,
                'size'=>11
            ],
            'fill'=>[
                'fillType' =>  fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'ff9800'
                ]
            ],
            'alignment'=>[
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
         
        ];

        $spreadsheet = new Spreadsheet();
        // style lebar kolom
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('A')
                    ->setWidth(5);
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('B')
                    ->setWidth(12);
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('C')
                    ->setWidth(17);
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('D')
                    ->setWidth(15);
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('E')
                    ->setWidth(8);
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('F')
                    ->setWidth(8);
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('G')
                    ->setWidth(15);

        // tulis header/nama kolom 
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Nis')
                    ->setCellValue('C1', 'Nama Siswa')
                    ->setCellValue('D1', 'Kelas')
                    ->setCellValue('E1', 'Bulan')
                    ->setCellValue('F1', 'Tahun')
                    ->setCellValue('G1', 'Keterangan');

        // STYLE judul table
        $spreadsheet->getActiveSheet()
                    ->getStyle('A1:G1')
                    ->applyFromArray($styleJudul);
        
        $no = 1;
        $column = 2;
        // tulis data ke cell
        foreach($filter as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $column, $no)
                        ->setCellValue('B' . $column, $data->nis)
                        ->setCellValue('C' . $column, $data->nama_siswa)
                        ->setCellValue('D' . $column, $data->nama_kelas)
                        ->setCellValue('E' . $column, $data->nama_bulan)
                        ->setCellValue('F' . $column, $data->kode_tahun)
                        ->setCellValue('G' . $column, $data->keterangan);
            $column++;
            $no++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Tunggakan';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');

        // $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
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