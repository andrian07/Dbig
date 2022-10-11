<?php

namespace App\Controllers\Webmin\Report;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;

class ReportCustomer extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        die('ReportCustomer');
    }

    public function viewCustomerList()
    {
        $data = [
            'title'         => 'Daftar Customer',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/customer/view_customer_list', $data);
    }

    public function customerList()
    {
        $data = [
            'title'         => 'Daftar Customer',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/customer/customer_list', $data);
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
                $dompdf->stream('daftar_customer.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }

    public function viewPointExchangeList()
    {
        $data = [
            'title'         => 'Daftar Penukaran Poin',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/customer/view_point_exchange_list', $data);
    }

    public function pointExchangeList()
    {
        $data = [
            'title'         => 'Daftar Penukaran Poin',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/customer/point_exchange_list', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();
        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }
        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('daftar_penukaran_poin.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }


    public function viewCustomerReceivableList()
    {
        $data = [
            'title'         => 'Daftar Piutang Customer',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/customer/view_customer_receivable_list', $data);
    }

    public function customerReceivableList()
    {
        $data = [
            'title'         => 'Daftar Penukaran Poin',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/customer/customer_receivable_list', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();
        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }
        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('daftar_piutang_customer.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }


    public function viewCustomerReceivableReceipt()
    {
        $data = [
            'title'         => 'Cetak Kwitansi Tagihan',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/customer/view_customer_receivable_receipt', $data);
    }

    public function customerReceivableReceipt()
    {
        $data = [
            'title'         => 'Kwitansi Tagihan',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/customer/customer_receivable_receipt', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();
        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }
        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'portait');
                $dompdf->render();
                $dompdf->stream('kwitansi_tagihan_customer.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }



    //




    //--------------------------------------------------------------------

}
