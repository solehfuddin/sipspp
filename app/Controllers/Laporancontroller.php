<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\SiswaModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use Config\Services;

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

            $data = [
                'custommenu' => $settingModel->getMenu($session->get('idlevel')),
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
                $request = Services::request();
                $m_report  = new LaporanModel($request);

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
                            "recordsTotal" => $m_report->count_all(),
                            "recordsFiltered" => $m_report->count_filtered(),
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
}