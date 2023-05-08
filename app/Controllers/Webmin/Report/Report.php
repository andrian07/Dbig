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

    public function viewPriceTagV2()
    {
        $data = [
            'title'                 => 'Label Harga'
        ];
        return $this->renderView('report/utility/view_price_tag_v2', $data);
    }

    public function priceTagV2()
    {
        $item_id                = $this->request->getGet('item_id') != NULL ? $this->request->getGet('item_id') : '';
        $print_version          = $this->request->getGet('print_version') != NULL ? intval($this->request->getGet('print_version')) : 1;
        $print_count            = $this->request->getGet('print_count') != NULL ? intval($this->request->getGet('print_count')) : 1;
        $print_group            = $this->request->getGet('print_group') != NULL ? explode(',', $this->request->getGet('print_group')) : ['G1', 'G2', 'G3', 'G4'];

        $list_sales_price = [
            'G1'    => 'G1_sales_price',
            'G2'    => 'G2_sales_price',
            'G3'    => 'G3_sales_price',
            'G4'    => 'G4_sales_price'
        ];

        $list_promo_price = [
            'G1'    => 'G1_promo_price',
            'G2'    => 'G2_promo_price',
            'G3'    => 'G3_promo_price',
            'G4'    => 'G4_promo_price'
        ];

        $list_group_label = [
            'G1'    => 'Harga Umum',
            'G2'    => 'Member Silver',
            'G3'    => 'Member Gold',
            'G4'    => 'Member Platinum'
        ];
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
                $table_item = [];
                foreach ($getProductUnit as $row) {
                    $item_code      = $row['item_code'];
                    $product_name   = $row['product_name'];
                    $unit_name      = $row['unit_name'];
                    for ($i = 1; $i <= $print_count; $i++) {
                        if ($print_version == 1) {
                            // no disc //
                            foreach ($print_group as $group) {
                                $label_text = $list_group_label[$group];
                                $sp         = isset($list_sales_price[$group]) ? $row[$list_sales_price[$group]] : 0;

                                $itemData = '<table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="bg-blue tag-header" colspan="4" height="50px">' . $product_name . '</td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" colspan="2">' . numberFormat($sp) . '</td>
                                        <td class="text-left label-unit">Per ' . $unit_name . '</td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-' . $group . '" colspan="2" height="15px" colspan="2">' . $label_text . '</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2">' . $item_code . '</td>
                                    </tr>
                                    <tr>
                                        <td class="label-info text-center font-primary" style="border-bottom: black solid 1px;" colspan="4" height="15px">&nbsp;</td>
                                    </tr>
                                </tbody>
                                </table>';

                                $table_item[] = $itemData;
                            }
                        } else {
                            // disc //
                            foreach ($print_group as $group) {
                                $label_text = $list_group_label[$group];
                                $sp         = isset($list_sales_price[$group]) ? $row[$list_sales_price[$group]] : 0;
                                $pp         = isset($list_promo_price[$group]) ? $row[$list_promo_price[$group]] : 0;
                                $itemData = '<table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="bg-blue tag-header" colspan="4" height="50px">' . $product_name . '</td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">Harga Normal&nbsp;&nbsp;<del class="disc-price fs-15">Rp ' . numberFormat($sp) . '</del></td>
                                    </tr>
                                    <tr class="">
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" style="color:red;" colspan="2">' . numberFormat($pp) . '</td>
                                        <td class="text-left label-unit">Per ' . $unit_name . '</td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-' . $group . '" colspan="2" height="15px" colspan="2">' . $label_text . '</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2">' . $item_code . '</td>
                                    </tr>
                                    <tr>
                                        <td class="label-info text-center font-primary" style="border-bottom: black solid 1px;" colspan="4" height="15px">s.d ' . indo_date($row['disc_end_date']) . '</td>
                                    </tr>
                                </tbody>
                                </table>';

                                $table_item[] = $itemData;
                            }
                        }
                    }
                }

                $table_rows     = array_chunk($table_item, 4);
                $pages          = array_chunk($table_rows, 5);
                $max_page       = count($pages);
                $data = [
                    'title'             => 'Price Tag',
                    'pages'             => $pages,
                    'max_page'          => $max_page,
                    'print_version'     => $print_version,
                ];
                //dd($data);
                $htmlView   = $this->renderView('report/utility/price_tag_v2', $data);


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

    public function viewPriceTagV3()
    {
        $data = [
            'title'                 => 'Label Harga'
        ];
        return $this->renderView('report/utility/view_price_tag_v3', $data);
    }

    public function priceTagV3()
    {
        $item_id                = $this->request->getGet('item_id') != NULL ? $this->request->getGet('item_id') : '';
        $print_version          = $this->request->getGet('print_version') != NULL ? intval($this->request->getGet('print_version')) : 1;
        $print_count            = $this->request->getGet('print_count') != NULL ? intval($this->request->getGet('print_count')) : 1;
        $print_group            = $this->request->getGet('print_group') != NULL ? explode(',', $this->request->getGet('print_group')) : ['G1', 'G2', 'G3', 'G4'];

        $list_sales_price = [
            'G1'    => 'G1_sales_price',
            'G2'    => 'G2_sales_price',
            'G3'    => 'G3_sales_price',
            'G4'    => 'G4_sales_price'
        ];

        $list_promo_price = [
            'G1'    => 'G1_promo_price',
            'G2'    => 'G2_promo_price',
            'G3'    => 'G3_promo_price',
            'G4'    => 'G4_promo_price'
        ];

        $list_group_label = [
            'G1'    => 'Harga Umum',
            'G2'    => 'Member Silver',
            'G3'    => 'Member Gold',
            'G4'    => 'Member Platinum'
        ];
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
                $table_item = [];
                foreach ($getProductUnit as $row) {
                    $item_code      = $row['item_code'];
                    $product_name   = $row['product_name'];
                    $unit_name      = $row['unit_name'];
                    for ($i = 1; $i <= $print_count; $i++) {
                        if ($print_version == 1) {
                            // no disc //
                            foreach ($print_group as $group) {
                                $label_text = $list_group_label[$group];
                                $sp         = isset($list_sales_price[$group]) ? $row[$list_sales_price[$group]] : 0;

                                $itemData = '<table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="bg-blue tag-header" colspan="4" height="50px">' . $product_name . '</td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" colspan="2">' . numberFormat($sp) . '</td>
                                        <td class="text-left label-unit">Per ' . $unit_name . '</td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-' . $group . '" colspan="2" height="15px" colspan="2">' . $label_text . '</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2">' . $item_code . '</td>
                                    </tr>
                                    <tr>
                                        <td class="label-info text-center font-primary" style="border-bottom: black solid 1px;" colspan="4" height="15px">&nbsp;</td>
                                    </tr>
                                </tbody>
                                </table>';

                                $table_item[] = $itemData;
                            }
                        } else {
                            // disc //
                            foreach ($print_group as $group) {
                                $label_text = $list_group_label[$group];
                                $sp         = isset($list_sales_price[$group]) ? $row[$list_sales_price[$group]] : 0;
                                $pp         = isset($list_promo_price[$group]) ? $row[$list_promo_price[$group]] : 0;
                                $itemData = '<table class="price-tag" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        <td class="bg-blue tag-header" colspan="4" height="60px">' . $product_name . '</td>
                                    </tr>
                                    <tr>
                                        <td class="label-info" colspan="4" height="12px">Harga Normal&nbsp;&nbsp;<del class="disc-price fs-15">Rp ' . numberFormat($sp) . '</del></td>
                                    </tr>
                                    <tr class="">
                                        <td class="label-currency" height="18px">Rp.</td>
                                        <td class="text-right label-price" style="color:red;" colspan="2">' . numberFormat($pp) . '</td>
                                        <td class="text-left label-unit">Per ' . $unit_name . '</td>
                                    </tr>
                                    <tr>
                                        <td class="label-group group-' . $group . '" colspan="2" height="15px" colspan="2">' . $label_text . '</td>
                                        <td class="label-group" colspan="2" height="15px" colspan="2">' . $item_code . '</td>
                                    </tr>
                                    <tr> 
                                        <td colspan="4" height="5px">&nbsp;</td>   
                                    </tr>
                                </tbody>
                                </table>';

                                $table_item[] = $itemData;
                            }
                        }
                    }
                }

                $table_rows     = array_chunk($table_item, 3);
                $pages          = array_chunk($table_rows, 4);
                $max_page       = count($pages);
                $data = [
                    'title'             => 'Price Tag',
                    'pages'             => $pages,
                    'max_page'          => $max_page,
                    'print_version'     => $print_version,
                ];
                //dd($data);
                $htmlView   = $this->renderView('report/utility/price_tag_v3', $data);


                if ($agent->isMobile() && !$isDownload) {
                    return $htmlView;
                } else {
                    if ($fileType == 'pdf') {
                        $dompdf = new Dompdf();
                        $dompdf->loadHtml($htmlView);
                        $dompdf->setPaper('A4', 'portrait');
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
