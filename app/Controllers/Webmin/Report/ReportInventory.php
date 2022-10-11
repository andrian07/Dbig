<?php

namespace App\Controllers\Webmin\Report;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;

class ReportInventory extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        die('ReportInventory');
    }

    public function viewStockList()
    {
        $data = [
            'title'         => 'Daftar Stok',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_stock_list', $data);
    }

    public function stockList()
    {
        $data = [
            'title'         => 'Daftar Stok',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/inventory/stock_list', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }

        if ($agent->isMobile()  && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                set_time_limit(0);
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('daftar_stok.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }


    public function viewStockCard()
    {
        $data = [
            'title'         => 'Kartu Stok',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_stock_card', $data);
    }

    public function stockCard()
    {
        $data = [
            'title'         => 'Kartu Stok',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/inventory/stock_card', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }

        if ($agent->isMobile()  && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                set_time_limit(0);
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('kartu_stok.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }


    public function viewStockOpnameList()
    {
        $data = [
            'title'         => 'Daftar Stok Opname',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_stock_opname_list', $data);
    }

    public function stockOpnameList()
    {
        $data = [
            'title'         => 'Daftar Stok Opname',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/inventory/stock_opname_list', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }

        if ($agent->isMobile()  && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('stock_opname.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }

    public function viewStockTransferList()
    {
        $data = [
            'title'         => 'Daftar Stok Transfer',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_stock_transfer_list', $data);
    }

    public function stockTransferList()
    {
        $data = [
            'title'         => 'Daftar Stok Transfer',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/inventory/stock_transfer_list', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }

        if ($agent->isMobile()  && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('stock_transfer.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }

    public function viewDeadStockList()
    {
        $data = [
            'title'         => 'Daftar Dead Stok',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_dead_stock_list', $data);
    }

    public function deadStockList()
    {
        $data = [
            'title'         => 'Daftar Dead Stok',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/inventory/dead_stock_list', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }

        if ($agent->isMobile()  && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('daftar_dead_stock.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }

    public function viewExpStockList()
    {
        $data = [
            'title'         => 'Daftar Stok Kedaluwarsa',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_exp_stock_list', $data);
    }

    public function expStockList()
    {
        $data = [
            'title'         => 'Daftar Stok Kedaluwarsa',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/inventory/exp_stock_list', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }

        if ($agent->isMobile()  && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('daftar_stok_kedaluwarsa.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }



    //--------------------------------------------------------------------

}
