<?php

namespace App\Controllers\Webmin\Report;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;

class Report extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'     => 'Daftar & Laporan',
        ];
        return $this->renderView('report/report', $data);
    }

    public function viewBarcodeGenerate()
    {
        $data = [
            'title'                 => 'Cetak Barcode',
            'barcode_type_list'     => $this->myConfig->barcodeType
        ];
        return $this->renderView('report/utility/view_barcode_generate', $data);
    }

    public function barcodeGenerate()
    {
        $item_code          = $this->request->getGet('item_code') != NULL ? $this->request->getGet('item_code') : '';
        $print_count        = $this->request->getGet('print_count') != NULL ? intval($this->request->getGet('print_count')) : 1;
        $barcode_type       = $this->request->getGet('barcode_type') != NULL ? $this->request->getGet('barcode_type') : 'auto';
        $barcode_type_list  = $this->myConfig->barcodeType;

        $demo_product = [
            '480528304523' => ['item_code' => '480528304523', 'product_name' => 'Kopin Gelas Coffee Mug Kukuruyuk (KPM-03CM)', 'unit_name' => 'PCS', 'sales_price' => '15000'],
            '480528304525' => ['item_code' => '480528304525', 'product_name' => ' Amstad Wastafel Studio 45 Wall Hung Lavatory White - paket', 'unit_name' => 'PCS', 'sales_price' => '18000'],
        ];
        $getProductUnit = isset($demo_product[$item_code]) ? $demo_product[$item_code] : NULL;

        if ($item_code == '') {
            die('<h1>Harap Pilih Item Yang Akan Dicetak</h1>');
        } else {
            if ($getProductUnit == NULL) {
                die("<h1>Item dengan barcode \" $item_code \" tidak ditemukan</h1>");
            } else {
                helper('barcode');
                $barcode = generate_barcode($item_code, $barcode_type);
                if ($barcode == FALSE) {
                    $bname =  $barcode_type_list[$barcode_type];
                    die("<h1>Jenis barcode '$bname' tidak mendukung barcode \"$item_code\"</h1>");
                } else {
                    $data = [
                        'title'         => 'Cetak Barcode',
                        'product'       => $getProductUnit,
                        'barcode'       => $barcode,
                        'printCount'    => $print_count,
                    ];
                    $htmlView = $this->renderView('report/utility/barcode_generate', $data);

                    $agent = $this->request->getUserAgent();
                    $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE; // param export
                    $fileType   = $this->request->getGet('file'); // jenis file pdf|xlsx 

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
                            $dompdf->stream('barcode.pdf', array("Attachment" => $isDownload));
                            exit();
                        } else {
                            die('Export Excel Script');
                        }
                    }
                }
            }
        }
    }

    public function viewPriceTag()
    {
        $data = [
            'title'                 => 'Label Harga'
        ];
        return $this->renderView('report/utility/view_price_tag', $data);
    }

    public function priceTag()
    {
        $item_code          = $this->request->getGet('item_code') != NULL ? $this->request->getGet('item_code') : '';
        $print_count        = $this->request->getGet('print_count') != NULL ? intval($this->request->getGet('print_count')) : 1;

        $demo_product = [
            '480528304523' => ['item_code' => '480528304523', 'product_name' => 'Kopin Gelas Coffee Mug Kukuruyuk (KPM-03CM)', 'unit_name' => 'PCS', 'sales_price' => '15000'],
            '480528304525' => ['item_code' => '480528304525', 'product_name' => ' Amstad Wastafel Studio 45 Wall Hung Lavatory White - paket', 'unit_name' => 'PCS', 'sales_price' => '18000'],
        ];
        $getProductUnit = isset($demo_product[$item_code]) ? $demo_product[$item_code] : NULL;

        if ($item_code == '') {
            die('<h1>Harap Pilih Item Yang Akan Dicetak</h1>');
        } else {
            if ($getProductUnit == NULL) {
                die("<h1>Item dengan barcode \" $item_code \" tidak ditemukan</h1>");
            } else {
                $data = [
                    'title'         => 'Cetak Barcode',
                    'product'       => $getProductUnit,
                    'printCount'    => $print_count,
                ];
                return  $this->renderView('report/utility/price_tag', $data);
            }
        }
    }
    //--------------------------------------------------------------------

}
