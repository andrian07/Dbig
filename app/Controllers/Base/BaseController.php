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
	public $maxUploadSize;

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

		// settings max upload size // 
		$get_config_upload = min(ini_get('post_max_size'), ini_get('upload_max_filesize'));
		$unit = preg_replace('/[^bkmgtpezy]/i', '', $get_config_upload); // Remove the non-unit characters from the size.
		$size = preg_replace('/[^0-9\.]/', '', $get_config_upload); // Remove the non-numeric characters from the size.

		if ($unit) {
			// Find the position of the unit in the ordered string which is the power of magnitude to multiply a bite by.
			$bit_size = round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
		} else {
			$bit_size = round($size);
		}

		// convert bit to kb and mb // 
		$kb_size = $bit_size / 1024;
		$mb_size = $kb_size / 1024;

		$this->maxUploadSize = [
			'b' 	=> $bit_size,
			'kb' 	=> $kb_size,
			'mb'	=> $mb_size
		];

		date_default_timezone_set("Asia/Jakarta");
	}
}
