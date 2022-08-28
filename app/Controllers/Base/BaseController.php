<?php

namespace App\Controllers\Base;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{
	public $myConfig;
	public $appConfig;

	public function validationRequest($ajax = FALSE, $blocking = TRUE, $host = TRUE)
	{
		$isValid = TRUE;
		if ($ajax) {
			if (!$this->request->isAJAX()) {
				if ($blocking) {
					exit('No direct script access allowed (1)');
				} else {
					$isValid = FALSE;
				}
			}
		}

		if ($host) {
			if (count($this->myConfig->allowedHosts) > 0) {
				$allowed_hosts = $this->myConfig->allowedHosts;
				$requestHost = '';
				$requestFrom = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
				$requestFromExplode = parse_url($requestFrom);
				if (!empty($requestFrom)) {
					$requestHost = $requestFromExplode['host'];
				}

				if (!in_array($requestHost, $allowed_hosts)) {
					if ($blocking) {
						exit('No direct script access allowed (2)');
					} else {
						$isValid = FALSE;
					}
				}
			}
		}
		return $isValid;
	}

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		$this->myConfig = config('MyApp');


		helper(['global']);
		// $appConfig = new \App\Libraries\ConfigReader();
		// $M_config = model('M_config');
		// $getConfig = $M_config->getConfig();

		// foreach ($getConfig->getResultArray() as $cfg) {
		// 	$appConfig->set($cfg['config_group'], $cfg['config_name'], $cfg['config_value']);
		// }
		// $this->appConfig = $appConfig;


		date_default_timezone_set("Asia/Jakarta");
	}
}
