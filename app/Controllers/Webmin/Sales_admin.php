<?php


namespace App\Controllers\Webmin;


use App\Controllers\Base\WebminController;


class Sales_admin extends WebminController
{


    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'         => 'Penjualan Admin' 
        ];
        return $this->renderView('sales/salesadmin', $data);
    }

    public function printinvoice()
    {
        return $this->renderView('sales/salesadmin_invoice');
    }

    public function printdispatch()
    {
        return $this->renderView('sales/salesadmin_dispatch');
    }
    //--------------------------------------------------------------------

}
