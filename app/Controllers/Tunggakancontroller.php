<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PembayaranModel;
use App\Models\TunggakanModel;
use App\Models\SmsModel;
use App\Models\SiswaModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use App\Models\SettingWaModel;
use App\Models\Master\KelasModel;
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

    public function pilihdata() {
        if(!$this->session->get('islogin'))
		{
			return view('view_login');
        }
        else
        {
            if ($this->request->isAJAX()) {
                $kode = $this->request->getVar('kode');
                $bulan = $this->request->getVar('bulan');
                $tahun = $this->request->getVar('tahun');

                $request = Services::request();
                $m_siswa = new SiswaModel($request);
                $gen  = "KWT" . date('dmyhis');

                $item = $m_siswa->find($kode);
    
                $data = [
                    'success' => [
                        'kode' => $item['nis'],
                        'nama' => $item['nama_siswa'],
                        'bln' => $bulan,
                        'thn' => $tahun,
                        'kodegen' => $gen
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

                $m_siswa = new SiswaModel($request);
                $item = $m_siswa->find($this->request->getVar('pembayaran_nis'));

                $m_kelas = new KelasModel($request);
                $kls = $m_kelas->find($item['id_kelas']);

                $mobNumber = $item['tlp_hp'];
                $msg = "Pembayaran SPP bulan *"
                        . $this->getMonth($this->request->getVar('pembayaran_month')) . 
                        "* a/n *" . $item['nama_siswa'] . "* kelas *"
                        . $kls['nama_kelas'] . 
                        "* telah dilunasi pada tanggal " . date('d/m/y') .
                        " sebesar *" . $this->request->getVar('pembayaran_biaya') .
                        ",-* \n \n _Bendahara SMP PGRI 32_";

                $data1 = [
                    'kode_pembayaran' => $this->request->getVar('pembayaran_kode'),
                    'phone_number' => $mobNumber,
                    'message' => $msg,
                    'status' => 2,
                    'response' => "Notifikasi via WA",
                ];

                $stdate = date("m/01/Y");
			    $eddate = date("m/d/Y");

                $request = Services::request();
                $m_sms = new SmsModel($request, date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate)));

                $m_sms->insert($data1);
                $this->sentWA(substr_replace($mobNumber, "+62", 0, 1), $msg);

                $msg = [
                    'success' => [
                       'data' => 'Berhasil menambahkan data',
                       'link' => base_url() . '/admtunggakan'
                    ]
                ];
            }

            echo json_encode($msg);
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

    public function broadcast(){
        $from = $this->request->getVar('from');
        $until = $this->request->getVar('until');

        $stExp = explode('/', $from);
        $edExp = explode('/', $until);

        $tunggakan = new TunggakanModel();
        $filter = $tunggakan->getData($stExp[0], $edExp[0], $edExp[2]);

        foreach($filter as $data) {
            $this->sentWA(substr_replace($data->tlp_hp, "+62", 0, 1), 
                            "Kepada orang tua / wali murid, kami informasikan peserta didik atas nama *"
                            . $data->nama_siswa . 
                            "* belum melakukan pembayaran SPP bulan *" . $data->nama_bulan . "* tahun *" 
                            . $data->kode_tahun . 
                            "*. Mohon kiranya segera melunasi tagihan pembayaran tersebut." .
                            "\nTerima Kasih \n \n \n _Bendahara SMP PGRI 32_");
        }

        $msg = [
            'success' => [
               'data' => "Broadcast notifikasi berhasil dikirim",
               'link' => '/admcattype'
            ]
        ];

        echo json_encode($msg);
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