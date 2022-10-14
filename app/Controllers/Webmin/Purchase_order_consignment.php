<?php


namespace App\Controllers\Webmin;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;


class Purchase_order_consignment extends WebminController
{


    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'         => 'Purchase Order Konsinyasi'
        ];
        return $this->renderView('consignment/purchaseorder_consignment', $data);
    }

    public function printinvoice(){
         $export = $this->request->getGet('export');
        if ($export == 'pdf') {
            $dompdf = new Dompdf();
            $viewHtml = $this->renderView('purchase/purchaseorder_invoice');
            $dompdf->loadHtml($viewHtml);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('a4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream('invoice');
        } else {
            return $this->renderView('consignment/purchaseorder_consignment_invoice');
        }
    }

    //--------------------------------------------------------------------

}
