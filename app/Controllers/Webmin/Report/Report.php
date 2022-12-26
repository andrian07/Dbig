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
        $item_id            = $this->request->getGet('item_id') != NULL ? $this->request->getGet('item_id') : '';
        $print_count        = $this->request->getGet('print_count') != NULL ? intval($this->request->getGet('print_count')) : 1;
        $barcode_type       = $this->request->getGet('barcode_type') != NULL ? $this->request->getGet('barcode_type') : 'auto';
        $barcode_type_list  = $this->myConfig->barcodeType;


        $M_product  = model('M_product');
        $item_id    = explode(',', $item_id);
        $getProductUnit = $M_product->getListProductUnit($item_id)->getRowArray();

        if ($item_id == '') {
            die('<h1>Harap Pilih Item Yang Akan Dicetak</h1>');
        } else {
            if ($getProductUnit == NULL) {
                die("<h1>Item tidak ditemukan</h1>");
            } else {
                helper('barcode');
                $item_code = $getProductUnit['item_code'];
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
        $item_id                = $this->request->getGet('item_id') != NULL ? $this->request->getGet('item_id') : '';
        $print_version          = $this->request->getGet('print_version') != NULL ? intval($this->request->getGet('print_version')) : 1;

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE; // param export
        $fileType   = $this->request->getGet('file'); // jenis file pdf|xlsx 

        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }

        if ($item_id == '') {
            die('<h1>Harap Pilih Item Yang Akan Dicetak</h1>');
        } else {
            $M_product  = model('M_product');
            $item_id    = explode(',', $item_id);
            $getProductUnit = $M_product->getListProductUnit($item_id)->getResultArray();

            if (count($getProductUnit) == 0) {
                die("<h1>Item tidak ditemukan</h1>");
            } else {
                $list_product   = array_chunk($getProductUnit, 5);
                $max_page       = count($list_product);
                $data = [
                    'title'             => 'Price Tag',
                    'list_product'      => $list_product,
                    'max_page'          => $max_page,
                    'print_version'      => $print_version,
                ];
                $htmlView   = $this->renderView('report/utility/price_tag', $data);


                if ($agent->isMobile() && !$isDownload) {
                    return $htmlView;
                } else {
                    if ($fileType == 'pdf') {
                        $dompdf = new Dompdf();
                        $dompdf->loadHtml($htmlView);
                        $dompdf->setPaper('A4', 'landscape');
                        $dompdf->render();
                        $dompdf->stream('price-tags.pdf', array("Attachment" => $isDownload));
                        exit();
                    }
                }
            }
        }
    }
    //--------------------------------------------------------------------

}
