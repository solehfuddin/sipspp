<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\SmsModel;
use Config\Services;

class Smsservice extends BaseController
{
	public function index() {
        $request = Services::request();
        $m_sms   = new SmsModel($request, date("Y-m-d", strtotime(date("m/01/Y"))), date("Y-m-d", strtotime(date("m/d/Y"))));

        $queue = $m_sms->getQueue();
        
        if (count($queue) > 0)
		{
			foreach ($queue as $d) {
				$json[] = array(
						"id_sms" 	    => $d['id_sms'],
						"phone_number"	=> $d['phone_number'],
						"insert_date"	=> date('d/m/Y', strtotime($d['insert_date'])),
						"message"		=> $d['message'],
						"status"        => $d['status'],
						"response" 		=> $d['response'],
					);
			}

			echo json_encode($json);
		}
		else
		{
			$invalid = "invalid";
			$msg = "Data not found";

			$json[] = array(
					$invalid => $msg
				);
			echo json_encode($json);
		}
    }

	public function edit($kode = null) {
		$data = $this->request->getRawInput();
		$respon = $data['response'];

		$request = Services::request();
        $m_sms   = new SmsModel($request, date("Y-m-d", strtotime(date("m/01/Y"))), date("Y-m-d", strtotime(date("m/d/Y"))));

		$data = array(
			'status' => 1,
			'response' => $respon,
		);

        $update  = $m_sms->update($kode, $data);

		$invalid = "success";
		$msg = "Data has update";

		$json[] = array(
				$invalid => $msg
			);

		echo json_encode($json);
	}
}