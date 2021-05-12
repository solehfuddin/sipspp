<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use App\Models\SettingModel;
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
		$session = \Config\Services::session();

		$data = [
			'custommenu' => $settingModel->getMenu($session->get('idlevel')),
			'submenu' => $submenuModel->submenu(),
		];
		return view('view_dashboard', $data);
	}
	
	//--------------------------------------------------------------------

}
