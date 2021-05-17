<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\SiswaModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Laporancontroller extends BaseController
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

            $stdate = date("m/01/Y");
			$eddate = date("m/d/Y");

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
                'start_date' => $stdate,
				'end_date' => $eddate,
            ];

            return view('datalaporan/view_laporan', $data);
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
                $stdate = $this->request->getVar('stdate');
			    $eddate = $this->request->getVar('eddate');

                $stdatetmp = $stdate;
                $eddatetmp = $eddate;

                $request = Services::request();
                $m_report  = new LaporanModel($request, date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate)));

                if($request->getMethod(true)=='POST'){
                    $lists = $m_report->get_datatables();
                        $data = [];
                        $no = $request->getPost("start");

                        foreach ($lists as $list) {
                                $no++;
                                $row = [];

                                $row[] = $no;
                                
                                $row[] = $list->nis;
                                $row[] = $list->nama_siswa;
                                $row[] = $list->nama_kelas;
                                $row[] = "<span style='color:#f5365c;'> Rp " . number_format($list->jumlah_bayar, 0, ',', '.') . "</span";
                                $row[] = date("d-m-Y h:m:s", strtotime($list->insert_date));
                                $row[] = $this->getMonth($list->tagihan_bulan);
                                $row[] = $list->tagihan_tahun;
                                $row[] = $list->nama_lengkap;
                                $data[] = $row;
                        }
                    
                        $output = [
                            "draw" => $request->getPost('draw'),
                            "recordsTotal" => $m_report->count_all(date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate))),
                            "recordsFiltered" => $m_report->count_filtered(date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate))),
                            "data" => $data,
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

    public function proses() {
        $stdate = $this->request->getVar('laporan_exportstdate');
		$eddate = $this->request->getVar('laporan_exporteddate');

        $request = Services::request();
        $m_report  = new LaporanModel($request, date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate)));
        $filter = $m_report->getDataFilter(date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate)));

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
                    ->setWidth(15);
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('F')
                    ->setWidth(25);
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('G')
                    ->setWidth(8);
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('H')
                    ->setWidth(8);
        $spreadsheet->getActiveSheet()
                    ->getColumnDimension('I')
                    ->setWidth(15);

        // tulis header/nama kolom 
        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Nis')
                    ->setCellValue('C1', 'Nama Siswa')
                    ->setCellValue('D1', 'Kelas')
                    ->setCellValue('E1', 'Jumlah Bayar')
                    ->setCellValue('F1', 'Tanggal Bayar')
                    ->setCellValue('G1', 'Bulan')
                    ->setCellValue('H1', 'Tahun')
                    ->setCellValue('I1', 'Kasir');

        // STYLE judul table
        $spreadsheet->getActiveSheet()
                    ->getStyle('A1:I1')
                    ->applyFromArray($styleJudul);
        
        $no = 1;
        $column = 2;
        // tulis data ke cell
        foreach($filter as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $column, $no)
                        ->setCellValue('B' . $column, $data['nis'])
                        ->setCellValue('C' . $column, $data['nama_siswa'])
                        ->setCellValue('D' . $column, $data['nama_kelas'])
                        ->setCellValue('E' . $column, $data['jumlah_bayar'])
                        ->setCellValue('F' . $column, date("d-m-Y", strtotime($data['insert_date'])))
                        ->setCellValue('G' . $column, $this->getMonth($data['tagihan_bulan']))
                        ->setCellValue('H' . $column, $data['tagihan_tahun'])
                        ->setCellValue('I' . $column, $data['nama_lengkap']);
            $column++;
            $no++;
        }
        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Laporan';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');

        // $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}