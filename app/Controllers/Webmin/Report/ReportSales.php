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

        $htmlView = $this->renderView('report/sales/sales_list', $data);
        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE; // param export
        $fileType   = $this->request->getGet('file'); // jenis file pdf|xlsx 

        if (!in_array($fileType, ['pdf', 'xlsx'])) {
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
                $dompdf->stream('laporan_penjualan_ddmmyyyyy_hhiiss.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }

    //--------------------------------------------------------------------

}
