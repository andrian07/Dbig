<?php


namespace App\Controllers\Webmin;

use Dompdf\Dompdf;
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
        $export = $this->request->getGet('export');
        if ($export == 'pdf') {

            
            $htmlView   = $this->renderView('sales/salesadmin_invoice');
            $dompdf = new Dompdf();
            $dompdf->loadHtml($htmlView);
            $dompdf->setPaper('half-letter', 'landscape');
            $dompdf->render();
            $dompdf->stream('invoice.pdf', array("Attachment" => false));
            exit();
        } else {
            return $this->renderView('sales/salesadmin_invoice');
        }
    }

    public function printdispatch()
    {
        return $this->renderView('sales/salesadmin_dispatch');
    }
    //--------------------------------------------------------------------

}
