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
            $dompdf = new Dompdf();
            $viewHtml = $this->renderView('sales/salesadmin_invoice');
            $dompdf->loadHtml($viewHtml);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('half-letter', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream('invoice');
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
