<?php

namespace App\Controllers\Pos;

use App\Controllers\Base\PosController;

class Dashboard extends PosController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'     => 'Dashboard',
        ];
        return $this->renderView('dashboard', $data);
    }


    public function customerDisplay()
    {
        $data = [
            'title'     => 'Customer Display',
        ];
        return $this->renderView('customer_display', $data);
    }

    //--------------------------------------------------------------------
}
