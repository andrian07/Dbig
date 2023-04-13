<?php

namespace App\Controllers\Webmin\Report;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;

class ReportSales extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'     => 'Laporan Penjualan',
        ];
        return $this->renderView('report/sales/view_sales_list', $data);
    }

    public function salesList()
    {
        $data = [
            'title'         => 'Laporan Penjualan',
            'userLogin'     => $this->userLogin
        ];

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $detail     = $this->request->getGet('detail') == NULL ? 'N' : $this->request->getGet('detail');

        if (!in_array($fileType, ['pdf', 'xlsx'])) {
            $fileType = 'pdf';
        }

        if ($detail == 'Y') {
            $htmlView = $this->renderView('report/sales/sales_list_detail', $data);
        } else {
            $htmlView = $this->renderView('report/sales/sales_list', $data);
        }

        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_ddmmyyyyy_hhiiss.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }

    public function viewSalesListGroupSalesman()
    {
        $data = [
            'title'     => 'Laporan Penjualan Per Salesman',
        ];
        return $this->renderView('report/sales/view_sales_list_group_salesman', $data);
    }

    public function salesListGroupSalesman()
    {
        $data = [
            'title'         => 'Laporan Penjualan Per Salesman',
            'userLogin'     => $this->userLogin
        ];

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $detail     = $this->request->getGet('detail') == NULL ? 'N' : $this->request->getGet('detail');
        //$detail = 'Y';
        if (!in_array($fileType, ['pdf', 'xlsx'])) {
            $fileType = 'pdf';
        }

        if ($detail == 'Y') {
            $htmlView = $this->renderView('report/sales/sales_list_group_salesman_detail', $data);
        } else {
            $htmlView = $this->renderView('report/sales/sales_list_group_salesman', $data);
        }


        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_ddmmyyyyy_hhiiss.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }

    public function viewSalesListGroupPayment()
    {
        $data = [
            'title'     => 'Laporan Penjualan Per Jenis Pembayaran',
        ];
        return $this->renderView('report/sales/view_sales_list_group_payment', $data);
    }

    public function salesListGroupPayment()
    {
        $data = [
            'title'         => 'Laporan Penjualan Per Jenis Pembayaran',
            'userLogin'     => $this->userLogin
        ];

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xlsx'])) {
            $fileType = 'pdf';
        }

        $htmlView = $this->renderView('report/sales/sales_list_group_payment', $data);

        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_ddmmyyyyy_hhiiss.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }


    public function viewProjectSalesList()
    {
        $data = [
            'title'     => 'Laporan Penjualan Proyek',
        ];
        return $this->renderView('report/sales/view_project_sales_list', $data);
    }

    public function projectSalesList()
    {
        $data = [
            'title'         => 'Laporan Penjualan Proyek',
            'userLogin'     => $this->userLogin
        ];

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $detail     = $this->request->getGet('detail') == NULL ? 'N' : $this->request->getGet('detail');

        if (!in_array($fileType, ['pdf', 'xlsx'])) {
            $fileType = 'pdf';
        }

        //$detail = 'Y';
        if ($detail == 'Y') {
            $htmlView = $this->renderView('report/sales/project_sales_list_detail', $data);
        } else {
            $htmlView = $this->renderView('report/sales/project_sales_list', $data);
        }

        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_ddmmyyyyy_hhiiss.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }


    public function viewProjectSalesListGroupCustomer()
    {
        $data = [
            'title'     => 'Laporan Penjualan Proyek Per Customer',
        ];
        return $this->renderView('report/sales/view_project_sales_list_group_customer', $data);
    }

    public function projectSalesListGroupCustomer()
    {
        $data = [
            'title'         => 'Laporan Penjualan Proyek Per Customer',
            'userLogin'     => $this->userLogin
        ];

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $detail     = $this->request->getGet('detail') == NULL ? 'N' : $this->request->getGet('detail');

        if (!in_array($fileType, ['pdf', 'xlsx'])) {
            $fileType = 'pdf';
        }
        //$detail = 'Y';
        if ($detail == 'Y') {
            $htmlView = $this->renderView('report/sales/project_sales_list_group_customer_detail', $data);
        } else {
            $htmlView = $this->renderView('report/sales/project_sales_list_group_customer', $data);
        }

        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_ddmmyyyyy_hhiiss.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }

    public function viewProjectSalesListGroupSalesman()
    {
        $data = [
            'title'     => 'Laporan Penjualan Proyek Per Salesman',
        ];
        return $this->renderView('report/sales/view_project_sales_list_group_salesman', $data);
    }

    public function projectSalesListGroupSalesman()
    {
        $data = [
            'title'         => 'Laporan Penjualan Proyek Per Salesman',
            'userLogin'     => $this->userLogin
        ];

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $detail     = $this->request->getGet('detail') == NULL ? 'N' : $this->request->getGet('detail');

        if (!in_array($fileType, ['pdf', 'xlsx'])) {
            $fileType = 'pdf';
        }
        //$detail = 'Y';
        if ($detail == 'Y') {
            $htmlView = $this->renderView('report/sales/project_sales_list_group_salesman_detail', $data);
        } else {
            $htmlView = $this->renderView('report/sales/project_sales_list_group_salesman', $data);
        }

        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_ddmmyyyyy_hhiiss.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }





    //--------------------------------------------------------------------

}
