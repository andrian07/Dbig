<?php


namespace App\Controllers\Webmin;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;


class Purchase_order extends WebminController
{


    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }


    public function index()
    {
        $data = [
            'title'         => 'Purchase Order'
        ];
        return $this->renderView('purchase/purchaseorder', $data);
    }


    public function searchProductBysuplier()
    {

        $this->validationRequest(TRUE, 'GET');

        $keyword = $this->request->getGet('term');

        $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];

        if (!($keyword == '' || $keyword == NULL)) {

            $M_product = model('M_product');

            $find = $M_product->searchProductUnitByName($keyword)->getResultArray();

            $find_result = [];

            foreach ($find as $row) {

                $diplay_text = $row['product_name'];

                $find_result[] = [

                    'id'                => $diplay_text,

                    'value'             => $diplay_text,

                    'item_id'           => $row['item_id'],

                    'product_id'        => $row['product_id']

                ];

            }

            $result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];

        }

        resultJSON($result);

    }


    public function printinvoice()
    {
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
            return $this->renderView('purchase/purchaseorder_invoice');
        }
    }

    //--------------------------------------------------------------------

}
