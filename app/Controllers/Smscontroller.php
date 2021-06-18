<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\SmsModel;
use App\Models\SiswaModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
use Config\Services;

class Smscontroller extends BaseController
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

            return view('datasms/view_sms', $data);
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
                $m_sms  = new SmsModel($request, date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate)));

                if($request->getMethod(true)=='POST'){
                    $lists = $m_sms->get_datatables();
                        $data = [];
                        $no = $request->getPost("start");

                        foreach ($lists as $list) {
                                $no++;
                                $row = [];

                                $row[] = $no;

                                if ($list->status == 0)
                                {
                                    $status = "<span style='color:#fb6340;'>Menunggu</span";
                                }
                                else
                                {
                                    $status = "<span style='color:#2dce89;'>Berhasil</span";
                                }

                                if ($list->response == "SMS terkirim" || $list->response == "Notifikasi via WA")
                                {
                                    $isactive = "<span style='color:#2dce89;'>$list->response</span";
                                }
                                else
                                {
                                    $isactive = "<span style='color:#f5365c;'>$list->response</span";
                                }
                                
                                $row[] = date("d-m-Y h:m:s", strtotime($list->insert_date));
                                $row[] = $list->kode_pembayaran;
                                $row[] = $list->phone_number;
                                $row[] = $list->message;
                                $row[] = $status;
                                $row[] = $isactive;
                            
                                $data[] = $row;
                        }
                    
                        $output = [
                            "draw" => $request->getPost('draw'),
                            "recordsTotal" => $m_sms->count_all(date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate))),
                            "recordsFiltered" => $m_sms->count_filtered(date("Y-m-d", strtotime($stdate)), date("Y-m-d", strtotime($eddate))),
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
}