<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use App\Models\UserModel;
use App\Models\SiswaModel;
use App\Models\PembayaranModel;
use App\Models\PembayaranMonthModel;
use Config\Services;

class Dashboard extends BaseController
{	
	public function index()
	{
		if(!$this->session->get('islogin'))
		{
			return view('view_login');
		}

		$request = Services::request();
		$menuModel = new MenuModel($request);
		$submenuModel = new SubmenuModel($request);
		$settingModel = new SettingModel($request);
		$userModel = new UserModel($request);
		$siswaModel = new SiswaModel($request);
		$sppModel = new PembayaranModel($request);
		$sumtotal = $sppModel->sumPaymentTotal();
		$summonth = $sppModel->sumPaymentThisMonth(date("m"), date("Y"));
		$session = \Config\Services::session();

		$data = [
			'custommenu' => $settingModel->getMenu($session->get('idlevel')),
			'submenu' => $submenuModel->submenu(),
			'totaluser' => $userModel->count_all(),
			'totalsiswa' => $siswaModel->count_all(),
			'sumtotal' => $sumtotal->jumlah_bayar,
			'summonth' => $summonth->jumlah_bayar,
			'datayear'  => $sppModel->sumYear(),
		];
		return view('view_dashboard', $data);
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
                $m_spp  = new PembayaranMonthModel($request, date("m"), date("Y"));

                if($request->getMethod(true)=='POST'){
                    $lists = $m_spp->get_datatables();
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
                            "recordsTotal" => $m_spp->count_all(date("m"), date("Y")),
                            "recordsFiltered" => $m_spp->count_filtered(date("m"), date("Y")),
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
