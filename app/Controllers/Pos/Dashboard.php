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

    public function salesRecap()
    {
        $data = [
            'title'     => 'Rekap Penjualan',
        ];
        $show_detail = $this->request->getGet('detail') == NULL ? 'N' : $this->request->getGet('detail');

        if ($show_detail == 'Y') {
            return $this->renderView('sales_recap_detail', $data);
        } else {
            return $this->renderView('sales_recap', $data);
        }
    }


    public function viewSalesRecap()
    {
        $data = [
            'title'     => 'Rekap Penjualan',
        ];

        return $this->renderView('view_sales_recap', $data);
    }
    //--------------------------------------------------------------------
}
