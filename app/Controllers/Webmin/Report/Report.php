<?php

namespace App\Controllers\Webmin\Report;

use App\Controllers\Base\WebminController;

class Report extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'     => 'Daftar & Laporan',
        ];
        return $this->renderView('report/report', $data);
    }

    public function barcodeGenerator()
    {
        die('Barcode');
        $data = [
            'title'     => 'Daftar & Laporan',
        ];
        return $this->renderView('auth/profile', $data);
    }

    public function priceTag()
    {
        die('Label Harga');
        $data = [
            'title'     => 'Daftar & Laporan',
        ];
        return $this->renderView('auth/profile', $data);
    }
    //--------------------------------------------------------------------

}
