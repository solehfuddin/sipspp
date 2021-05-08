<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
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

		$data = [
			'menu' => $menuModel->menu(),
			'submenu' => $submenuModel->submenu(),
		];
		return view('view_dashboard', $data);
	}
	
	//--------------------------------------------------------------------

}
