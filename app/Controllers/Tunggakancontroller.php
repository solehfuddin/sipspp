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

    public function broadcast(){
        $from = $this->request->getVar('from');
        $until = $this->request->getVar('until');

        $stExp = explode('/', $from);
        $edExp = explode('/', $until);

        $tunggakan = new TunggakanModel();
        $filter = $tunggakan->getData($stExp[0], $edExp[0], $edExp[2]);

        foreach($filter as $data) {
            $this->sentWA(substr_replace($data->tlp_hp, "+62", 0, 1), 
                            "Kepada wali murid dapat kami informasikan bahwa ananda " . $data->nama_siswa . 
                            " belum melakukan pembayaran SPP bulan " . $data->nama_bulan . " " . $data->kode_tahun . 
                            ". Mohon kiranya untuk segera melunasi tagihan tersebut");
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