<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;

class CronJob extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper('global');
    }

    public function index()
    {
        echo "CronJob Controller";
    }

    public function updateVoucher()
    {
        // set expired voucher //    
        $M_voucher = model('M_voucher');
        $today = date('Y-m-d');
        $update = $M_voucher->setExpiredVoucher($today);
        if ($update) {
            echo "Update Voucher : OK<br>";
        };
    }


    public function updatePOSafetyStock()
    {
        $today                  = date('Y-m-d');
        $M_cronjob              = model('M_cronjob');
        $M_admin_notification   = model('M_admin_notification');
        $M_product              = model('M_product');

        $getMinStockProduct = $M_product->getReportMinStockProduct()->getResultArray();

        $orderData = [];
        foreach ($getMinStockProduct as $row) {
            $product_id         = $row['product_id'];
            $stock_total        = floatval($row['stock_total']);
            $min_stock          = floatval($row['min_stock']);
            $percent_stock      = $min_stock == 0 ? 0 : (($stock_total / $min_stock) * 100);
            $order_stock        = $percent_stock >= 50 ? ceil($min_stock * 0.5) : $min_stock;

            $orderData[] = [
                'product_id'    => $product_id,
                'min_stock'     => $min_stock,
                'stock'         => $stock_total,
                'order_stock'   => $order_stock,
                'update_date'   => $today
            ];
        }

        $countProduct = count($orderData);
        $insertOrder = $M_cronjob->insertListPurchaseOrder($orderData, $today);

        if ($insertOrder) {
            echo "Update Order:OK";
            // set notification //
            $notifData = [
                'notification_date' => date('Y-m-d'),
                'notification_text' => "Terdapat <b>$countProduct</b> produk dibawah safety stok",
                'notification_view_url' => base_url('webmin/purchase-order/auto-po?update_date=' . $today),
            ];
            $M_admin_notification->insertNotification($notifData);
        } else {
            echo "Update Order:NO";
        }
    }

    public function safetyStock()
    {
        $agent          = $this->request->getUserAgent();
        $isDownload     = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType       = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $M_product          = model('M_product');
        $M_warehouse        = model('M_warehouse');
        $getWarehouse       = $M_warehouse->getWarehouse()->getResultArray();
        $getMinStockProduct = $M_product->getReportMinStockProduct()->getResultArray();

        $templateWarehouseStock = [];

        foreach ($getWarehouse as $warehouse) {
            $wid = 'W' . $warehouse['warehouse_id'];
            $templateWarehouseStock[$wid] = 0;
        }


        $sampleProductData = [
            'P1' => [
                'product_id'        => '1',
                'product_code'      => '',
                'product_name'      => '',
                'min_stock'         => 10,
                'total_stock'       => 10,
                'W1'                => 2,
                'W2'                => 8,
                'three_month_sales' => 0
            ]
        ];

        $productData = [];
        $product_ids = [];
        foreach ($getMinStockProduct as $row) {
            $pid = 'P' . $row['product_id'];
            $product = array_merge($row, $templateWarehouseStock);
            $product['three_month_sales'] = 0;

            $product_ids[] = $row['product_id'];

            $warehouse_stock = $product['warehouse_stock'];
            if ($warehouse_stock != null) {
                //format 1=2;2=8
                //explode by ;

                $expGroupStock = explode(';', $warehouse_stock);
                foreach ($expGroupStock as $str) {
                    $expWarehouseStock = explode('=', $str);
                    $wid = 'W' . $expWarehouseStock[0];
                    $product[$wid] = $expWarehouseStock[1];
                }
            }

            unset($product['warehouse_stock']);

            $productData[$pid] = $product;
        }
        $countData = count($product_ids);

        //limit file pdf max 3000 data
        if ($countData > 3000 && $fileType == 'pdf') {
            die("<h1>Terlalu berat untuk generate file pdf, Harap export via excel</h1>");
        }

        if ($countData > 0) {
            $start_date     = date("Y-m-d", strtotime("-3 months"));
            $end_date       = date('Y-m-d'); //today
            $getSalesStock  = $M_product->getSalesStockByProduct($product_ids, $start_date, $end_date);
            foreach ($getSalesStock as $row) {
                $pid = 'P' . $row['product_id'];
                $productData[$pid]['three_month_sales'] = floatval($row['sales_stock']);
            }
        }


        if (count($product_ids) == 0) {
            die('<h1>Tidak ada produk yg dibawah stok minimum</h1>');
        } else {
            if ($fileType == 'pdf') {
                $max_report_size        = 17;
                $pages                  = array_chunk($productData, $max_report_size);

                $data['pages']          = $pages;
                $data['max_page']       = count($pages);
                $data['warehouse_data'] = $getWarehouse;
                $data['userLogin']      = $this->userLogin;


                $htmlView = view('webmin/report/inventory/safety_stock', $data);
                if ($agent->isMobile() && !$isDownload) {
                    return $htmlView;
                } else {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('safety_stock.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            } else {
                $alpha = range('A', 'Z');

                $header_format = [
                    'fill' => [
                        'fillType' =>  \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'A5A5A5'
                        ]
                    ],
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

                $border_top = [
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $template = WRITEPATH . '/template/report/template_report.xlsx';
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

                $sheet = $spreadsheet->setActiveSheetIndex(0);
                // init iRow //
                $iRow = 6;


                // make header //
                $sheet->getCell('A' . $iRow)->setValue('KODE PRODUK');
                $sheet->getStyle('A' . $iRow)->applyFromArray($header_format);
                $sheet->getCell('B' . $iRow)->setValue('NAMA PRODUK');
                $sheet->getStyle('B' . $iRow)->applyFromArray($header_format);
                $sheet->getCell('C' . $iRow)->setValue('PENJUALAN SELAMA 3 BLN');
                $sheet->getStyle('C' . $iRow)->applyFromArray($header_format);
                $sheet->getCell('D' . $iRow)->setValue('SAFETY STOK');
                $sheet->getStyle('D' . $iRow)->applyFromArray($header_format);

                $iCol = 4; //4=E
                foreach ($getWarehouse as $warehouse) {
                    $col = $alpha[$iCol]; //get excel index A-Z
                    $sheet->getCell($col . $iRow)->setValue($warehouse['warehouse_code'] . ' - ' . $warehouse['warehouse_name']);
                    $sheet->getStyle($col . $iRow)->applyFromArray($header_format);
                    $iCol++;
                }


                $col = $alpha[$iCol];
                $sheet->getCell($col . $iRow)->setValue('SISA STOK');
                $sheet->getStyle($col . $iRow)->applyFromArray($header_format);
                $iCol++;

                $col = $alpha[$iCol];
                $sheet->getCell($col . $iRow)->setValue('KETERANGAN');
                $sheet->getStyle($col . $iRow)->applyFromArray($header_format);
                $maxCol = $col; //set max col//
                $iRow++;

                foreach ($productData as $product) {
                    $sheet->getCell('A' . $iRow)->setValue($product['product_code']);
                    $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);

                    $sheet->getCell('B' . $iRow)->setValue($product['product_name']);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);

                    $sheet->getCell('C' . $iRow)->setValue($product['three_month_sales']);
                    $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);

                    $sheet->getCell('D' . $iRow)->setValue($product['min_stock']);
                    $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);

                    $iCol = 4; //4=E
                    foreach ($getWarehouse as $warehouse) {
                        $col = $alpha[$iCol]; //get excel index A-Z
                        $wid = 'W' . $warehouse['warehouse_id'];
                        $sheet->getCell($col . $iRow)->setValue($product[$wid]);
                        $sheet->getStyle($col . $iRow)->applyFromArray($border_left_right);
                        $iCol++;
                    }

                    $col = $alpha[$iCol];
                    $sheet->getCell($col . $iRow)->setValue($product['stock_total']);
                    $sheet->getStyle($col . $iRow)->applyFromArray($border_left_right);
                    $iCol++;

                    $col = $alpha[$iCol];
                    $sheet->getCell($col . $iRow)->setValue('');
                    $sheet->getStyle($col . $iRow)->applyFromArray($border_left_right);
                    $iRow++;
                }


                $sheet->getStyle('A' . $iRow . ':' . $maxCol . $iRow)->applyFromArray($border_top);
                $iRow++;


                //setting excel header//
                // A4-G4 = Store Phone
                // A3-G3 = Store Address
                // A2-G2 = Store Name
                // A1-G1 = Print By
                $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_date(date('Y-m-d H:i:s'), FALSE);
                $sheet->getCell('A4')->setValue(COMPANY_PHONE);
                $sheet->getCell('A3')->setValue(COMPANY_ADDRESS);
                $sheet->getCell('A2')->setValue(COMPANY_NAME);
                $sheet->getCell('A1')->setValue($reportInfo);

                $sheet->mergeCells('A4:' . $maxCol . '4');
                $sheet->mergeCells('A3:' . $maxCol . '3');
                $sheet->mergeCells('A2:' . $maxCol . '2');
                $sheet->mergeCells('A1:' . $maxCol . '1');

                $sheet->getStyle('A4:' . $maxCol . '4')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A3:' . $maxCol . '3')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2:' . $maxCol . '2')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A1:' . $maxCol . '1')->getAlignment()->setHorizontal('right');

                $sheet->getStyle('A4:' . $maxCol . '4')->applyFromArray($font_bold);
                $sheet->getStyle('A3:' . $maxCol . '3')->applyFromArray($font_bold);
                $sheet->getStyle('A2:' . $maxCol . '2')->applyFromArray($font_bold);


                $iCol = array_search($maxCol, $alpha);
                for ($i = 0; $i <= $iCol; $i++) {
                    $sheet->getColumnDimension($alpha[$i])->setAutoSize(true);
                }

                $filename = 'safety_stock';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
                exit();
            }
        }
    }
}
