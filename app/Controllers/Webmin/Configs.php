<?php


namespace App\Controllers\Webmin;

use App\Controllers\Base\WebminController;

class Configs extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'         => 'Pengaturan',
            'alert'         => session()->getFlashdata('alert')
        ];

        return $this->renderView('configs', $data, 'configs.view');
    }
}
