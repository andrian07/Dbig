<?php

namespace App\Controllers\Pos;

use App\Controllers\Base\PosController;

class Pos extends PosController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        die('POS');
    }

    public function dashboard()
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

    public function viewSalesReceipt()
    {
        $data = [
            'title'     => 'Sample Struk Penjualan',
        ];

        return $this->renderView('receipt/view_sales_receipt', $data);
    }

    public function salesReceipt($show_disc)
    {
        $data = [
            'title'     => 'Sample Struk Penjualan',
        ];

        if ($show_disc == 'alocation') {
            return $this->renderView('receipt/sales_alocation_receipt', $data);
        } else {
            if ($show_disc == 'Y') {
                return $this->renderView('receipt/sales_receipt', $data);
            } else {
                return $this->renderView('receipt/sales_receipt_no_disc', $data);
            }
        }
    }


    public function viewSalesReturnReceipt()
    {
        $data = [
            'title'     => 'Sample Struk Retur Penjualan',
        ];

        return $this->renderView('receipt/view_sales_return_receipt', $data);
    }

    public function salesReturnReceipt()
    {
        $data = [
            'title'     => 'Sample Struk Retur Penjualan',
        ];

        return $this->renderView('receipt/sales_return_receipt', $data);
    }


    //--------------------------------------------------------------------
}
