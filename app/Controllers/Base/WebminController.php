<?php

namespace App\Controllers\Base;

use App\Controllers\Base\BaseController;

class WebminController extends BaseController
{
	protected $helpers = [];
	public $userLogin = [];
	public $role;
	public $session;

	/*  Constructor */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
		$this->session = \Config\Services::session();
		$this->userLogin = $this->session->get('user_login');
		$this->role = new \App\Libraries\Roles($this->myConfig->userRole, $this->userLogin['user_group']);
		$M_user_role = new \App\Models\Auth\M_user_role();
		$getGroupRole = $M_user_role->getRole($this->userLogin['user_group']);
		foreach ($getGroupRole->getResultArray() as $userRole) {
			$this->role->set($userRole['module_name'], $userRole['role_name'], intval($userRole['role_value']));
		}
	}

	/* RenderView */
	public function renderView($view_name, $data = NULL, $requiredRole = '')
	{
		$isValid = TRUE;
		if (!($requiredRole == '')) {
			$isValid = $this->role->hasRole($requiredRole);
		}

		if ($isValid) {
			$viewData               = $data == NULL ? [] : $data;
			$viewData['user']       = $this->userLogin;
			$viewData['user_role']  = $this->role->get();
			$viewData['role']   	= $this->role;
			return view('webmin/' . $view_name, $viewData);
		} else {
			return redirect()->to(base_url('webmin/profile'));
		}
	}
}
