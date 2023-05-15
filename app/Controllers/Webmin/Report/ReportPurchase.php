<?php

namespace App\Controllers\Webmin\Report;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;

class ReportPurchase extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        die('ReportPurchase');
    }

    public function viewPOList()
    {
        $data = [
            'title'         => 'Laporan PO',
        ];

        return $this->renderView('report/purchase/view_po_list', $data, 'report.po_list');
    }

    public function POList()
    {
        if ($this->role->hasRole('report.po_list')) {

            $M_purchase_order = model('M_purchase_order');

            $start_date = $this->request->getGet('start_date') != NULL ? $this->request->getGet('start_date') : date('Y-m') . '-01';
            $end_date   = $this->request->getGet('end_date') != NULL ? $this->request->getGet('end_date') : date('Y-m-d');
            $warehouse = $this->request->getGet('warehouse');
            $product_tax = $this->request->getGet('product_tax');
            $supplier_id = $this->request->getGet('supplier_id');
            $status_po = $this->request->getGet('status_po');
            $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType   = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent      = $this->request->getUserAgent();


            if (!in_array($fileType, ['pdf', 'xls'])) {
                $fileType = 'pdf';
            }

            $getReportData = $M_purchase_order->getReportData($start_date, $end_date, $warehouse, $product_tax, $supplier_id, $status_po)->getResultArray();

            if($getReportData != null){
                if($warehouse != null){
                    $warehouse_name = $getReportData[0]['warehouse_name'];
                }else{
                    $warehouse_name = '-';
                }
            }else{
                $warehouse_name = '-';
            }

            if($product_tax == null){
                $product_tax = 'SEMUA';
            }else if($product_tax == 'Y'){
                $product_tax = 'BKP' ;
            }else{
                $product_tax = 'NON BKP' ;
            }

            if ($fileType == 'pdf') {
                $cRow           = count($getReportData);
                if ($cRow % 16 == 0) {
                    $max_page_item  = 15;
                } else {
                    $max_page_item  = 16;
                }
                $poData    = array_chunk($getReportData, $max_page_item);
                $data = [
                    'title'                 => 'PO List',
                    'start_date'            => $start_date,
                    'end_date'              => $end_date,
                    'warehouse_name'        => $warehouse_name,
                    'product_tax'           => $product_tax,
                    'pages'                 => $poData,
                    'maxPage'               => count($poData),
                    'userLogin'             => $this->userLogin
                ];


                $htmlView   = view('webmin/report/purchase/po_list', $data);

                if ($agent->isMobile()  && !$isDownload) {
                    return $htmlView;
                } else {
                    if ($fileType == 'pdf') {
                        $dompdf = new Dompdf();
                        $dompdf->loadHtml($htmlView);
                        $dompdf->setPaper('A4', 'landscape');
                        $dompdf->render();
                        $dompdf->stream('po.pdf', array("Attachment" => $isDownload));
                        exit();
                    }
                }
            } else {
                $total_format = [
                    'font' => [
                        'bold' => true,
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'left' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $font_bold = [
                    'font' => [
                        'bold' => true,
                    ],
                ];

                $border_left_right = [
                    'borders' => [
                        'right' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                        'left' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $template = WRITEPATH . '/template/template_export_po.xlsx';
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

                $sheet = $spreadsheet->setActiveSheetIndex(0);
                $iRow = 8;
                $last_po_date = '';
                $last_po_invoice = '';
                foreach ($getReportData as $row) {
                    $detail_purchase_po_base_price  = floatval($row['detail_purchase_po_price'] / $row['detail_purchase_po_qty']);
                    $detail_purchase_po_dpp  = floatval($row['detail_purchase_po_dpp']);
                    $detail_purchase_po_ppn  = floatval($row['detail_purchase_po_ppn']);
                    $detail_purchase_po_price  = floatval($row['detail_purchase_po_price']);
                    $detail_purchase_po_qty = floatval($row['detail_purchase_po_qty']);
                    $detail_purchase_po_ongkir = floatval($row['detail_purchase_po_ongkir']);
                    $detail_purchase_po_tatao_plus_ongkir = floatval($row['detail_purchase_po_price'] + $row['detail_purchase_po_ongkir']);
                    $detail_purchase_po_qty  = floatval($row['detail_purchase_po_qty']);
                    $detail_purchase_po_recive  = floatval($row['detail_purchase_po_recive']);
                    $detail_purchase_po_qty_min = floatval($row['detail_purchase_po_qty'] - $row['detail_purchase_po_recive']);
                    

                    $cdate = $last_po_date == $row['purchase_order_date'] ? '' : indo_short_date($row['purchase_order_date'], FALSE);
                    $ccode = $last_po_invoice == $row['purchase_order_invoice'] ? '' : esc($row['purchase_order_invoice']);

                    $sheet->getCell('A' . $iRow)->setValue($cdate);
                    $sheet->getCell('B' . $iRow)->setValue($ccode);
                    $sheet->getCell('C' . $iRow)->setValue($row['item_code']);
                    $sheet->getCell('D' . $iRow)->setValue($row['product_name']);
                    $sheet->getCell('E' . $iRow)->setValue($product_tax);
                    $sheet->getCell('F' . $iRow)->setValue($row['supplier_code']);
                    $sheet->getCell('G' . $iRow)->setValue($row['supplier_name']);
                    $sheet->getCell('H' . $iRow)->setValue();
                    $sheet->getCell('I' . $iRow)->setValue(number_format($detail_purchase_po_base_price, TRUE));
                    $sheet->getCell('J' . $iRow)->setValue(number_format($detail_purchase_po_dpp, TRUE));
                    $sheet->getCell('K' . $iRow)->setValue(number_format($detail_purchase_po_ppn, TRUE));
                    $sheet->getCell('L' . $iRow)->setValue(number_format($detail_purchase_po_price, TRUE));
                    $sheet->getCell('M' . $iRow)->setValue(number_format($detail_purchase_po_ongkir, TRUE));
                    $sheet->getCell('N' . $iRow)->setValue(number_format($detail_purchase_po_tatao_plus_ongkir, TRUE));
                    $sheet->getCell('O' . $iRow)->setValue($detail_purchase_po_qty);
                    $sheet->getCell('P' . $iRow)->setValue($detail_purchase_po_recive);
                    $sheet->getCell('Q' . $iRow)->setValue($detail_purchase_po_qty - $detail_purchase_po_recive);

                    $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('I' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('J' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('K' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('L' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('M' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('N' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('O' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('P' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('Q' . $iRow)->applyFromArray($border_left_right);


                    $last_po_date = $row['purchase_order_date'];
                    $last_po_invoice = $row['purchase_order_invoice'];
                    $iRow++;
                }




                //setting periode
                $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
                $sheet->getCell('B5')->setValue($periode_text);
                //setting excel header//
                // A4-G4 = Store Phone
                // A3-G3 = Store Address
                // A2-G2 = Store Name
                // A1-G1 = Print By
                $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_date(date('Y-m-d H:i:s'), FALSE);
                $sheet->getCell('A1')->setValue($reportInfo);

                $sheet->mergeCells('A1:G1');

                $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('right');

                $sheet->getStyle('A2:G2')->applyFromArray($font_bold);


                $filename = 'PO';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
                exit();
            }
        } else {
            echo "<h1>Anda tidak memiliki akses ke laman ini</h1>";
        }
    }


    //


    public function viewPurchaseList()
    {
        $data = [
            'title'         => 'Laporan Pembelian',
        ];

        return $this->renderView('report/purchase/view_purchase_list', $data, 'report.purchase_list');
    }

    public function PurchaseList()
    {   

        if ($this->role->hasRole('report.purchase_list')) {

            $M_purchase = model('M_purchase');

            $start_date  = $this->request->getGet('start_date') != NULL ? $this->request->getGet('start_date') : date('Y-m') . '-01';
            $end_date    = $this->request->getGet('end_date') != NULL ? $this->request->getGet('end_date') : date('Y-m-d');
            $warehouse   = $this->request->getGet('warehouse');
            $product_tax = $this->request->getGet('product_tax');
            $supplier_id = $this->request->getGet('supplier_id');
            $category_id = $this->request->getGet('category_id');
            $brand_id    = $this->request->getGet('brand_id');
            $show_detail = $this->request->getGet('show_detail');

            $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType   = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent      = $this->request->getUserAgent();

            $data = [
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'warehouse'             => $warehouse,
                'product_tax'           => $product_tax,
                'supplier_id'           => $supplier_id,
                'category_id'           => $category_id,
                'brand_id'              => $brand_id,
                'isDownload'            => $isDownload,
                'fileType'              => $fileType,
                'agent'                 => $agent
            ];

            if($show_detail == 'on'){
                $this->PurchaseListDetail($data);
            }else{
                $this->PurchaseListHeader($data);
            }


            
        } else {
            echo "<h1>Anda tidak memiliki akses ke laman ini</h1>";
        }
    }


    public function PurchaseListHeader($data)
    {
        $M_purchase  = model('M_purchase');
        $start_date  = $data['start_date'];
        $end_date    = $data['end_date'];
        $warehouse   = $data['warehouse'];
        $product_tax = $data['product_tax'];
        $supplier_id = $data['supplier_id'];
        $isDownload  = $data['isDownload'];
        $fileType    = $data['fileType'];
        $agent       = $data['agent'];

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_purchase->getReportDataPurchaseHeader($start_date, $end_date, $warehouse, $product_tax, $supplier_id)->getResultArray();

        if($getReportData != null){
            if($warehouse != null){
                $warehouse_name = $getReportData[0]['warehouse_name'];
                $supplier_name = $getReportData[0]['supplier_name'];
            }else{
                $warehouse_name = '-';
                $supplier_name = '-';
            }
        }else{
            $warehouse_name = '-';
            $supplier_name = '-';
        }

        if($product_tax == null){
            $product_tax = 'SEMUA';
        }else if($product_tax == 'Y'){
            $product_tax = 'BKP' ;
        }else{
            $product_tax = 'NON BKP' ;
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }

            $purchaseData        = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Pembelian',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'warehouse_name'        => $warehouse_name,
                'product_tax'           => $product_tax,
                'supplier_name'         => $supplier_name,
                'category_id'           => '-',
                'brand_id'              => '-',
                'pages'                 => $purchaseData,
                'maxPage'               => count($purchaseData),
                'userLogin'             => $this->userLogin
            ];

            $htmlView   = view('webmin/report/purchase/purchase_header_list', $data);

            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('po.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            }
        } else {
            $total_format = [
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $font_bold = [
                'font' => [
                    'bold' => true,
                ],
            ];

            $border_left_right = [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $template = WRITEPATH . '/template/template_export_purchase_header.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;
            $last_po_date = '';
            $last_po_invoice = '';
            foreach ($getReportData as $row) {
                $purchase_date = indo_short_date($row['purchase_date']);
                $purchase_due_date = indo_short_date($row['purchase_due_date']);
                $dpp   = floatval($row['purchase_total_dpp']);
                $ppn   = floatval($row['purchase_total_ppn']);
                $total = floatval($row['purchase_total']);

                $sheet->getCell('A' . $iRow)->setValue($row['supplier_code']);
                $sheet->getCell('B' . $iRow)->setValue($row['supplier_name']);
                $sheet->getCell('C' . $iRow)->setValue($row['purchase_invoice']);
                $sheet->getCell('D' . $iRow)->setValue($purchase_date);
                $sheet->getCell('E' . $iRow)->setValue($purchase_due_date);
                $sheet->getCell('F' . $iRow)->setValue(numberFormat($dpp, TRUE));
                $sheet->getCell('G' . $iRow)->setValue(number_format($ppn, TRUE));
                $sheet->getCell('H' . $iRow)->setValue(number_format($total, TRUE));

                $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);
            }




                //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('B5')->setValue($periode_text);
                //setting excel header//
                // A4-G4 = Store Phone
                // A3-G3 = Store Address
                // A2-G2 = Store Name
                // A1-G1 = Print By
            $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_date(date('Y-m-d H:i:s'), FALSE);
            $sheet->getCell('A1')->setValue($reportInfo);

            $sheet->mergeCells('A1:H1');

            $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A2:H2')->applyFromArray($font_bold);


            $filename = 'Pembelian';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }


    public function PurchaseListDetail($data)
    {
        $M_purchase = model('M_purchase');
        $start_date  = $data['start_date'];
        $end_date    = $data['end_date'];
        $warehouse   = $data['warehouse'];
        $product_tax = $data['product_tax'];
        $supplier_id = $data['supplier_id'];
        $category_id = $data['category_id'];
        $brand_id    = $data['brand_id'];
        $isDownload  = $data['isDownload'];
        $fileType    = $data['fileType'];
        $agent       = $data['agent'];

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_purchase->getReportData($start_date, $end_date, $warehouse, $product_tax, $supplier_id, $category_id, $brand_id)->getResultArray();

        if($getReportData != null){
            if($warehouse != null){
                $warehouse_name = $getReportData[0]['warehouse_name'];
                $supplier_name = $getReportData[0]['supplier_name'];
            }else{
                $warehouse_name = '-';
                $supplier_name = '-';
            }
        }else{
            $warehouse_name = '-';
            $supplier_name = '-';
        }

        if($product_tax == null){
            $product_tax = 'SEMUA';
        }else if($product_tax == 'Y'){
            $product_tax = 'BKP' ;
        }else{
            $product_tax = 'NON BKP' ;
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }

            $purchaseData        = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Purchase List Detail',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'warehouse_name'        => $warehouse_name,
                'product_tax'           => $product_tax,
                'supplier_id'           => $supplier_name,
                'category_id'           => '-',
                'brand_id'              => '-',
                'pages'                 => $purchaseData,
                'maxPage'               => count($purchaseData),
                'userLogin'             => $this->userLogin
            ];

            $htmlView   = view('webmin/report/purchase/purchase_detail_list', $data);

            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('po.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            }
        } else {
            $total_format = [
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $font_bold = [
                'font' => [
                    'bold' => true,
                ],
            ];

            $border_left_right = [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $template = WRITEPATH . '/template/template_export_purchase_detail.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;
            $last_purchase_date = '';
            $last_purchase_invoice = '';
            foreach ($getReportData as $row) {

                $purchase_due_date = indo_short_date($row['purchase_due_date']);
                $qty          = floatval($row['dt_purchase_qty']);
                $dpp          = floatval($row['purchase_total_dpp']);
                $ppn          = floatval($row['purchase_total_ppn']);
                $total        = floatval($row['purchase_total']);
                $base_price   = floatval($total / $qty);


                $cdate = $last_purchase_date == $row['purchase_date'] ? '' : indo_short_date($row['purchase_date'], FALSE);
                $ccode = $last_purchase_invoice == $row['purchase_invoice'] ? '' : esc($row['purchase_invoice']);

                $sheet->getCell('A' . $iRow)->setValue($cdate);
                $sheet->getCell('B' . $iRow)->setValue($ccode);
                $sheet->getCell('C' . $iRow)->setValue($row['supplier_code']);
                $sheet->getCell('D' . $iRow)->setValue($row['supplier_name']);
                $sheet->getCell('E' . $iRow)->setValue($purchase_due_date);
                $sheet->getCell('F' . $iRow)->setValue($row['item_code']);
                $sheet->getCell('G' . $iRow)->setValue($row['product_name']);
                $sheet->getCell('H' . $iRow)->setValue($row['brand_name']);
                $sheet->getCell('I' . $iRow)->setValue($row['category_name']);
                $sheet->getCell('J' . $iRow)->setValue($qty);
                $sheet->getCell('K' . $iRow)->setValue($row['unit_name']);
                $sheet->getCell('L' . $iRow)->setValue(numberFormat($base_price, TRUE));
                $sheet->getCell('M' . $iRow)->setValue(numberFormat($dpp, TRUE));
                $sheet->getCell('N' . $iRow)->setValue(number_format($ppn, TRUE));
                $sheet->getCell('O' . $iRow)->setValue(number_format($total, TRUE));

                $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('I' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('J' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('K' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('L' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('M' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('N' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('N' . $iRow)->applyFromArray($border_left_right);


                $last_purchase_date = $row['purchase_date'];
                $last_purchase_invoice = $row['purchase_invoice'];
                $iRow++;
            }
                //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('B5')->setValue($periode_text);
                //setting excel header//
                // A4-G4 = Store Phone
                // A3-G3 = Store Address
                // A2-G2 = Store Name
                // A1-G1 = Print By
            $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_date(date('Y-m-d H:i:s'), FALSE);
            $sheet->getCell('A1')->setValue($reportInfo);

            $sheet->mergeCells('A1:H1');

            $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A2:H2')->applyFromArray($font_bold);


            $filename = 'Pembelian';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }


    public function viewPOConsignmentList()
    {
        $data = [
            'title'         => 'Laporan PO',
        ];

        return $this->renderView('report/purchase/view_po_consignment_list', $data, 'report.po_list');
    }


    public function POConsignmentList()
    {
        $M_consignment = model('M_consignment');

        $start_date  = $this->request->getGet('start_date');
        $end_date    = $this->request->getGet('end_date');
        $supplier_id = $this->request->getGet('supplier_id');
        $category_id = $this->request->getGet('category_id');
        $brand_id    = $this->request->getGet('brand_id');
        $status_po    = $this->request->getGet('status_po');
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_consignment->getReportData($start_date, $end_date, $supplier_id, $category_id, $brand_id, $status_po)->getResultArray();

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }

            $POConsignmentData        = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'PO Konsinyasi List',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'category_id'           => '-',
                'brand_id'              => '-',
                'pages'                 => $POConsignmentData,
                'maxPage'               => count($POConsignmentData),
                'userLogin'             => $this->userLogin
            ];

            $htmlView   = view('webmin/report/purchase/po_consignment_list', $data);

            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('PoKonsinyasi.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            }
        } else {
            $total_format = [
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $font_bold = [
                'font' => [
                    'bold' => true,
                ],
            ];

            $border_left_right = [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $template = WRITEPATH . '/template/template_export_purchase_consignment.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;
            $last_po_consignment_date = '';
            $last_po_consignment_invoice = '';
            foreach ($getReportData as $row) {

                //$purchase_due_date = indo_short_date($row['purchase_due_date']);
                $qty          = floatval($row['dt_po_consignment_qty']);


                $cdate = $last_po_consignment_date == $row['purchase_order_consignment_date'] ? '' : indo_short_date($row['purchase_order_consignment_date'], FALSE);
                $ccode = $last_po_consignment_invoice == $row['purchase_order_consignment_invoice'] ? '' : esc($row['purchase_order_consignment_invoice']);

                $sheet->getCell('A' . $iRow)->setValue($cdate);
                $sheet->getCell('B' . $iRow)->setValue($ccode);
                $sheet->getCell('C' . $iRow)->setValue($row['supplier_code']);
                $sheet->getCell('D' . $iRow)->setValue($row['supplier_name']);
                $sheet->getCell('E' . $iRow)->setValue($row['item_code']);
                $sheet->getCell('F' . $iRow)->setValue($row['product_name']);
                $sheet->getCell('G' . $iRow)->setValue($row['brand_name']);
                $sheet->getCell('H' . $iRow)->setValue($row['category_name']);
                $sheet->getCell('I' . $iRow)->setValue($qty);
                $sheet->getCell('J' . $iRow)->setValue($row['unit_name']);

                $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('I' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('J' . $iRow)->applyFromArray($border_left_right);


                $last_po_consignment_date = $row['purchase_order_consignment_date'];
                $last_po_consignment_invoice = $row['purchase_order_consignment_invoice'];
                $iRow++;
            }
                //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('B5')->setValue($periode_text);
                //setting excel header//
                // A4-G4 = Store Phone
                // A3-G3 = Store Address
                // A2-G2 = Store Name
                // A1-G1 = Print By
            $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_date(date('Y-m-d H:i:s'), FALSE);
            $sheet->getCell('A1')->setValue($reportInfo);

            $sheet->mergeCells('A1:H1');

            $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A2:H2')->applyFromArray($font_bold);


            $filename = 'PO Konsinyasi';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }


    public function viewReturPurchaseList()
    {
        $data = [
            'title'         => 'Retur Pembelian',
        ];

        return $this->renderView('report/purchase/view_retur_purchase_list', $data, 'report.retur_purchase_list');
    }


    public function returPurchaseList()
    {   

        if ($this->role->hasRole('report.retur_purchase_list')) {

            $M_retur = model('M_retur');

            $start_date  = $this->request->getGet('start_date');
            $end_date    = $this->request->getGet('end_date');
            $supplier_id = $this->request->getGet('supplier_id');
            $show_detail = $this->request->getGet('show_detail');
            $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType   = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent      = $this->request->getUserAgent();

            $data = [
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'supplier_id'           => $supplier_id,
                'isDownload'            => $isDownload,
                'fileType'              => $fileType,
                'agent'                 => $agent
            ];

            if($show_detail == 'on'){
                $this->ReturListDetail($data);
            }else{
                $this->ReturListHeader($data);
            }

        } else {
            echo "<h1>Anda tidak memiliki akses ke laman ini</h1>";
        }
    }

    public function ReturListHeader($data)
    {   

        $M_retur     = model('M_retur');
        $start_date  = $data['start_date'];
        $end_date    = $data['end_date'];
        $supplier_id = $data['supplier_id'];
        $isDownload  = $data['isDownload'];
        $fileType    = $data['fileType'];
        $agent       = $data['agent'];

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_retur->getReportHeaderData($start_date, $end_date, $supplier_id)->getResultArray();

        if($getReportData != null){
            if($supplier_id != null){
                $supplier_name = $getReportData[0]['supplier_name'];
            }else{
                $supplier_name = '-';
            }
        }else{
            $warehouse_name = '-';
            $supplier_name = '-';
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }

            $returPurchaseData        = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Retur Pembelian List',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'supplier_name'         => $supplier_name,
                'pages'                 => $returPurchaseData,
                'maxPage'               => count($returPurchaseData),
                'userLogin'             => $this->userLogin
            ];

            $htmlView   = view('webmin/report/purchase/retur_purchase_header_list', $data);

            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('ReturPembelian.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            }
        } else {
            $total_format = [
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $font_bold = [
                'font' => [
                    'bold' => true,
                ],
            ];

            $border_left_right = [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $template = WRITEPATH . '/template/template_export_retur_purchase_header.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;
            foreach ($getReportData as $row) {
                $dpp   = floatval($row['hd_retur_total_dpp']);
                $ppn   = floatval($row['hd_retur_total_ppn']);
                $total = floatval($row['hd_retur_total_transaction']);
                $retur_date  = indo_short_date($row['hd_retur_date']);

                $sheet->getCell('A' . $iRow)->setValue($row['supplier_code']);
                $sheet->getCell('B' . $iRow)->setValue($row['supplier_name']);
                $sheet->getCell('C' . $iRow)->setValue($row['hd_retur_purchase_invoice']);
                $sheet->getCell('D' . $iRow)->setValue($retur_date);
                $sheet->getCell('E' . $iRow)->setValue(numberFormat($dpp, TRUE));
                $sheet->getCell('F' . $iRow)->setValue(numberFormat($ppn, TRUE));
                $sheet->getCell('G' . $iRow)->setValue(numberFormat($total, TRUE));

                $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);

                $iRow++;
            }
                //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('B5')->setValue($periode_text);
                //setting excel header//
                // A4-G4 = Store Phone
                // A3-G3 = Store Address
                // A2-G2 = Store Name
                // A1-G1 = Print By
            $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_date(date('Y-m-d H:i:s'), FALSE);
            $sheet->getCell('A1')->setValue($reportInfo);

            $sheet->mergeCells('A1:G1');

            $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A2:G2')->applyFromArray($font_bold);


            $filename = 'Retur Pembelian';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    public function ReturListDetail($data)
    {   

        $M_retur     = model('M_retur');
        $start_date  = $data['start_date'];
        $end_date    = $data['end_date'];
        $supplier_id = $data['supplier_id'];
        $isDownload  = $data['isDownload'];
        $fileType    = $data['fileType'];
        $agent       = $data['agent'];

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_retur->getReportData($start_date, $end_date, $supplier_id)->getResultArray();

        if($getReportData != null){
            if($supplier_id != null){
                $supplier_name = $getReportData[0]['supplier_name'];
            }else{
                $supplier_name = '-';
            }
        }else{
            $warehouse_name = '-';
            $supplier_name = '-';
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }

            $returPurchaseData        = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Retur Pembelian Detail List',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'supplier_name'         => $supplier_name,
                'pages'                 => $returPurchaseData,
                'maxPage'               => count($returPurchaseData),
                'userLogin'             => $this->userLogin
            ];

            $htmlView   = view('webmin/report/purchase/retur_purchase_detail_list', $data);

            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('ReturPembelianDetail.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            }
        } else {
            $total_format = [
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $font_bold = [
                'font' => [
                    'bold' => true,
                ],
            ];

            $border_left_right = [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];

            $template = WRITEPATH . '/template/template_export_retur_purchase_detail.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;
            $last_retur_invoice = '';

            foreach ($getReportData as $row) {
                $dpp   = floatval($row['dt_retur_dpp'] + $row['dt_retur_disc'] + $row['dt_retur_disc_nota'] + $row['dt_retur_ongkir']);
                $ppn   = floatval($row['dt_retur_ppn']);
                $total = floatval($row['dt_retur_total']);
                $qty   = floatval($row['dt_retur_qty']);
                $price = $total / $qty;
                $retur_date  = indo_short_date($row['hd_retur_date']);

                $ccode = $last_retur_invoice == $row['hd_retur_purchase_invoice'] ? '' : esc($row['hd_retur_purchase_invoice']);

                $sheet->getCell('A' . $iRow)->setValue($ccode);
                $sheet->getCell('B' . $iRow)->setValue($row['supplier_code']);
                $sheet->getCell('C' . $iRow)->setValue($row['supplier_name']);
                $sheet->getCell('D' . $iRow)->setValue($row['dt_retur_purchase_invoice']);
                $sheet->getCell('E' . $iRow)->setValue($retur_date);
                $sheet->getCell('F' . $iRow)->setValue($row['item_code']);
                $sheet->getCell('G' . $iRow)->setValue($row['product_name']);
                $sheet->getCell('H' . $iRow)->setValue($row['brand_name']);
                $sheet->getCell('I' . $iRow)->setValue($row['category_name']);
                $sheet->getCell('J' . $iRow)->setValue($qty);
                $sheet->getCell('K' . $iRow)->setValue($row['unit_name']);
                $sheet->getCell('L' . $iRow)->setValue(numberFormat($price, TRUE));
                $sheet->getCell('M' . $iRow)->setValue(numberFormat($dpp, TRUE));
                $sheet->getCell('N' . $iRow)->setValue(numberFormat($ppn, TRUE));
                $sheet->getCell('O' . $iRow)->setValue(numberFormat($total, TRUE));

                $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('I' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('J' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('K' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('L' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('M' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('N' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('O' . $iRow)->applyFromArray($border_left_right);


                $last_retur_invoice = $row['hd_retur_purchase_invoice'];
                $iRow++;
            }
                //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('B5')->setValue($periode_text);
                //setting excel header//
                // A4-G4 = Store Phone
                // A3-G3 = Store Address
                // A2-G2 = Store Name
                // A1-G1 = Print By
            $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_date(date('Y-m-d H:i:s'), FALSE);
            $sheet->getCell('A1')->setValue($reportInfo);

            $sheet->mergeCells('A1:G1');

            $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A2:G2')->applyFromArray($font_bold);


            $filename = 'Retur Pembelian Detail';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    //--------------------------------------------------------------------

}
