<?php

namespace App\Controllers\Webmin\Report;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;

class ReportInventory extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        die('ReportInventory');
    }

    public function viewStockList()
    {
        $data = [
            'title'         => 'Daftar Stok',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_stock_list', $data);
    }

    public function stockList()
    {
        $warehouse_id   = $this->request->getGet('warehouse_id') != null ? $this->request->getGet('warehouse_id') : '';
        $warehouse_name = $this->request->getGet('warehouse_name') != null ? $this->request->getGet('warehouse_name') : '-';
        $product_tax    = $this->request->getGet('product_tax') != null ? $this->request->getGet('product_tax') : '';


        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $data = [
            'title'             => 'Laporan Penjualan',
            'userLogin'         => $this->userLogin,
            'warehouse_id'      => $warehouse_id,
            'warehouse_name'    => $warehouse_name,
            'product_tax'       => $product_tax
        ];

        $M_product       = model('M_product');
        $getData         = $M_product->getReportWarehouseStockList($warehouse_id, $product_tax)->getResultArray();
        //dd($getData);

        if ($fileType == 'pdf') {
            $max_report_size    = 15;
            $pages              = array_chunk($getData, $max_report_size);
            $data['pages']      = $pages;
            $data['max_page']   = count($pages);

            $htmlView = $this->renderView('report/inventory/stock_list', $data);
            if ($agent->isMobile() && !$isDownload) {
                return $htmlView;
            } else {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('stock_list.pdf', array("Attachment" => $isDownload));
                exit();
            }
        } else {
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

            //make header //
            $iRow = 7;
            $sheet->getCell('A' . $iRow)->setValue('KODE PRODUK');
            $sheet->getCell('B' . $iRow)->setValue('NAMA PRODUK');
            $sheet->getCell('C' . $iRow)->setValue('KATEGORI');
            $sheet->getCell('D' . $iRow)->setValue('MEREK');
            $sheet->getCell('E' . $iRow)->setValue('PPN');
            $sheet->getCell('F' . $iRow)->setValue('KODE GUDANG');
            $sheet->getCell('G' . $iRow)->setValue('NAMA GUDANG');
            $sheet->getCell('H' . $iRow)->setValue('STOK');

            $sheet->getStyle('A' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('B' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('C' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('D' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('E' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('F' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('G' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('H' . $iRow)->applyFromArray($header_format);
            $iRow++;

            foreach ($getData as $row) {
                $sheet->getCell('A' . $iRow)->setValue($row['product_code']);
                $sheet->getCell('B' . $iRow)->setValue($row['product_name']);
                $sheet->getCell('C' . $iRow)->setValue($row['category_name']);
                $sheet->getCell('D' . $iRow)->setValue($row['brand_name']);
                $sheet->getCell('E' . $iRow)->setValue($row['has_tax']);
                $sheet->getCell('F' . $iRow)->setValue($row['warehouse_code']);
                $sheet->getCell('G' . $iRow)->setValue($row['warehouse_name']);
                $sheet->getCell('H' . $iRow)->setValue(floatval($row['stock']));


                $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);
                $iRow++;
            }

            $sheet->getStyle('A' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('B' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('C' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('D' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('E' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('F' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('G' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('H' . $iRow)->applyFromArray($border_top);

            //setting periode
            $sheet->getCell('A5')->setValue('Gudang');
            $sheet->getStyle('A5')->applyFromArray($font_bold);
            $sheet->getCell('B5')->setValue($warehouse_name);
            $sheet->mergeCells('B5:H5');

            $sheet->getCell('A6')->setValue('PPN');
            $sheet->getStyle('A6')->applyFromArray($font_bold);
            $sheet->getCell('B6')->setValue($product_tax);
            $sheet->mergeCells('B6:H6');

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

            $sheet->mergeCells('A4:H4');
            $sheet->mergeCells('A3:H3');
            $sheet->mergeCells('A2:H2');
            $sheet->mergeCells('A1:H1');

            $sheet->getStyle('A4:H4')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A4:H4')->applyFromArray($font_bold);
            $sheet->getStyle('A3:H3')->applyFromArray($font_bold);
            $sheet->getStyle('A2:H2')->applyFromArray($font_bold);

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);


            $filename = 'stock_list';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    public function viewStockListV2()
    {
        $data = [
            'title'         => 'Daftar Stok',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_stock_list_v2', $data);
    }

    public function stockListV2()
    {
        $warehouse_id   = $this->request->getGet('warehouse_id') != null ? $this->request->getGet('warehouse_id') : '';
        $warehouse_name = $this->request->getGet('warehouse_name') != null ? $this->request->getGet('warehouse_name') : 'Semua';
        $product_tax    = $this->request->getGet('product_tax') != null ? $this->request->getGet('product_tax') : '';
        $start_date     = $this->request->getGet('start_date') != null ? $this->request->getGet('start_date') : '';
        $end_date       = $this->request->getGet('end_date') != null ? $this->request->getGet('end_date') : '';

        $filter_date    = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
        $agent          = $this->request->getUserAgent();
        $isDownload     = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType       = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $data = [
            'title'             => 'Laporan Penjualan',
            'userLogin'         => $this->userLogin,
            'warehouse_id'      => $warehouse_id,
            'warehouse_name'    => $warehouse_name,
            'product_tax'       => $product_tax
        ];

        $M_warehouse        = model('M_warehouse');
        $M_product          = model('M_product');

        $getWarehouse       = $M_warehouse->getWarehouse($warehouse_id)->getResultArray();
        $getProduct         = $M_product->getReportProductList($product_tax)->getResultArray();


        /* datasource stock awal+stockinout */
        $stockData_sample = [
            'P0001' => [       // P0001 = product_id
                [
                    'W1' => [ // W1 = warehouse_id 1
                        'init'    => 0,
                        'in'      => 5,
                        'out'     => 2
                    ]
                ]
            ]
        ];
        $stockData = [];



        /* list_product_id */
        $list_product_id    = [];
        foreach ($getProduct as $product) {
            $list_product_id[] = $product['product_id'];
        }

        /* get stock per 500 id */
        $init_max_date = new \DateTime($start_date); //1 hari sebelum tgl mulai
        $init_max_date->sub(new \DateInterval('P1D'));
        $sInitMaxDate = $init_max_date->format('Y-m-d');


        $max_get_stock      = 500;
        $chunk_product_id   = array_chunk($list_product_id, $max_get_stock);
        foreach ($chunk_product_id as $product_ids) {
            $getInitStock = $M_product->getReportInitStock($product_ids, null, $sInitMaxDate);
            foreach ($getInitStock as $row) {
                $pid =  'P' . $row['product_id'];
                $wid = 'W' . $row['warehouse_id'];
                $stockData[$pid][$wid]['init'] = floatval($row['stock']);
            }
        }


        foreach ($chunk_product_id as $product_ids) {
            $getInOutStock = $M_product->getReportStockInOut($product_ids, $start_date, $end_date);
            foreach ($getInOutStock as $row) {
                $pid =  'P' . $row['product_id'];
                $wid = 'W' . $row['warehouse_id'];
                $stockData[$pid][$wid]['in'] = floatval($row['stock_in']);
                $stockData[$pid][$wid]['out'] = floatval($row['stock_out']);
            }
        }


        if ($fileType == 'pdf') {
            die('<h1>Excel Only</h1>');
            foreach ($getProduct as $product) {
                $pid = 'P' . $product['product_id'];
                foreach ($getWarehouse as $warehouse) {
                    $wid = 'W' . $warehouse['warehouse_id'];
                }
            }
            $getData = [];

            $max_report_size    = 15;
            $pages              = array_chunk($getData, $max_report_size);
            $data['pages']      = $pages;
            $data['max_page']   = count($pages);

            $htmlView = $this->renderView('report/inventory/stock_list_v2', $data);
            if ($agent->isMobile() && !$isDownload) {
                return $htmlView;
            } else {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('stock_list.pdf', array("Attachment" => $isDownload));
                exit();
            }
        } else {
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

            //make header //
            $iRow = 7;
            $sheet->getCell('A' . $iRow)->setValue('KODE PRODUK');
            $sheet->getCell('B' . $iRow)->setValue('NAMA PRODUK');
            $sheet->getCell('C' . $iRow)->setValue('Supplier');
            $sheet->getCell('D' . $iRow)->setValue('KATEGORI');
            $sheet->getCell('E' . $iRow)->setValue('MEREK');
            $sheet->getCell('F' . $iRow)->setValue('PPN');
            $sheet->getCell('G' . $iRow)->setValue('KODE GUDANG');
            $sheet->getCell('H' . $iRow)->setValue('NAMA GUDANG');
            $sheet->getCell('I' . $iRow)->setValue('SAFETY STOK');
            $sheet->getCell('J' . $iRow)->setValue('STOK AWAL');
            $sheet->getCell('K' . $iRow)->setValue('STOK MASUK');
            $sheet->getCell('L' . $iRow)->setValue('STOK KELUAR');
            $sheet->getCell('M' . $iRow)->setValue('STOK AKHIR');

            $sheet->getStyle('A' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('B' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('C' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('D' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('E' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('F' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('G' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('H' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('I' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('J' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('K' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('L' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('M' . $iRow)->applyFromArray($header_format);
            $iRow++;

            foreach ($getProduct as $product) {
                $pid = 'P' . $product['product_id'];
                foreach ($getWarehouse as $warehouse) {
                    $wid = 'W' . $warehouse['warehouse_id'];
                    $stock_init = isset($stockData[$pid][$wid]['init']) ? $stockData[$pid][$wid]['init'] : 0;
                    $stock_in = isset($stockData[$pid][$wid]['in']) ? $stockData[$pid][$wid]['in'] : 0;
                    $stock_out = isset($stockData[$pid][$wid]['out']) ? $stockData[$pid][$wid]['out'] : 0;
                    $stock_final = $stock_init + $stock_in + $stock_out;


                    //paste to excel
                    $sheet->getCell('A' . $iRow)->setValue($product['product_code']);
                    $sheet->getCell('B' . $iRow)->setValue($product['product_name']);
                    $sheet->getCell('C' . $iRow)->setValue($product['supplier_code'].'-'.$product['supplier_name']);
                    $sheet->getCell('D' . $iRow)->setValue($product['category_name']);
                    $sheet->getCell('E' . $iRow)->setValue($product['brand_name']);
                    $sheet->getCell('F' . $iRow)->setValue($product['has_tax']);
                    $sheet->getCell('G' . $iRow)->setValue($warehouse['warehouse_code']);
                    $sheet->getCell('H' . $iRow)->setValue($warehouse['warehouse_name']);
                    $sheet->getCell('I' . $iRow)->setValue($product['min_stock']);
                    $sheet->getCell('J' . $iRow)->setValue($stock_init);
                    $sheet->getCell('K' . $iRow)->setValue($stock_in);
                    $sheet->getCell('L' . $iRow)->setValue($stock_out);
                    $sheet->getCell('M' . $iRow)->setValue($stock_final);


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
                    $iRow++;
                }
            }



            $sheet->getStyle('A' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('B' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('C' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('D' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('E' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('F' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('G' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('H' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('I' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('J' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('K' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('L' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('M' . $iRow)->applyFromArray($border_top);


            //setting periode
            $sheet->getCell('A5')->setValue('Gudang');
            $sheet->getStyle('A5')->applyFromArray($font_bold);
            $sheet->getCell('B5')->setValue($warehouse_name);
            $sheet->mergeCells('B5:E5');

            $sheet->getCell('F5')->setValue('Tanggal');
            $sheet->getStyle('F5')->applyFromArray($font_bold);
            $sheet->getCell('G5')->setValue($filter_date);
            $sheet->mergeCells('G5:L5');

            $sheet->getCell('A6')->setValue('PPN');
            $sheet->getStyle('A6')->applyFromArray($font_bold);
            $sheet->getCell('B6')->setValue($product_tax);
            $sheet->mergeCells('B6:E6');

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

            $sheet->mergeCells('A4:M4');
            $sheet->mergeCells('A3:M3');
            $sheet->mergeCells('A2:M2');
            $sheet->mergeCells('A1:M1');

            $sheet->getStyle('A4:L4')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3:L3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:L2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A4:M4')->applyFromArray($font_bold);
            $sheet->getStyle('A3:M3')->applyFromArray($font_bold);
            $sheet->getStyle('A2:M2')->applyFromArray($font_bold);

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
            $sheet->getColumnDimension('I')->setAutoSize(true);
            $sheet->getColumnDimension('J')->setAutoSize(true);
            $sheet->getColumnDimension('K')->setAutoSize(true);
            $sheet->getColumnDimension('L')->setAutoSize(true);
            $sheet->getColumnDimension('M')->setAutoSize(true);


            $filename = 'stock_list_v2';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    public function viewStockOpnameList()
    {
        $data = [
            'title'         => 'Daftar Stok Opname',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_stock_opname_list', $data);
    }

    public function stockOpnameList()
    {
        $warehouse_id   = $this->request->getGet('warehouse_id') != null ? $this->request->getGet('warehouse_id') : '';
        $warehouse_name = $this->request->getGet('warehouse_name') != null ? $this->request->getGet('warehouse_name') : '-';
        $start_date     = $this->request->getGet('start_date') != null ? $this->request->getGet('start_date') : date('Y-m-d');
        $end_date       = $this->request->getGet('end_date') != null ? $this->request->getGet('end_date') : date('Y-m-d');


        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $data = [
            'title'             => 'Stok Opname',
            'userLogin'         => $this->userLogin,
            'warehouse_id'      => $warehouse_id,
            'warehouse_name'    => $warehouse_name,
            'start_date'        => $start_date,
            'end_date'          => $end_date
        ];

        $M_stock_opname     = model('M_stock_opname');
        $reportData         = [];
        $getData            = $M_stock_opname->getReportOpnameList($start_date, $end_date, $warehouse_id)->getResultArray();
        //dd($getData);





        if ($fileType == 'pdf') {
            $table_rows = [];
            $sample_table_rows = [
                [
                    ['colspan' => '8', 'text' => '<b>OPNAME CODE</b>', 'class' => 'text-left'],
                ],
                [
                    ['text' => 'TGL', 'class' => 'text-left'],
                    ['text' => 'KODE GUDANG', 'class' => 'text-left col-fixed'],
                    ['text' => 'KODE PRODUK', 'class' => 'text-left'],
                    ['text' => 'NAMA PRODUK', 'class' => 'text-left col-fixed'],
                    ['text' => 'HPP', 'class' => 'text-right'],
                    ['text' => 'SELISIH UNIT', 'class' => 'text-right'],
                    ['text' => 'KET', 'class' => 'text-left col-fixed'],
                    ['text' => 'SELISIH RP', 'class' => 'text-right'],
                ],
                [
                    ['colspan' => '7', 'text' => '<b>TOTAL</b>', 'class' => 'text-right'],
                    ['text' => '<b>TOTAL SELISIH RP</b>', 'class' => 'text-right'],
                ],
            ];

            $last_opname_code   = '';
            $total_opname       = 0;
            foreach ($getData as $row) {
                if ($last_opname_code != $row['opname_code']) {
                    if ($last_opname_code != '') {
                        // buat footer
                        $table_rows[] = [
                            ['colspan' => '7', 'text' => '<b>TOTAL</b>', 'class' => 'text-right'],
                            ['text' => '<b>' . numberFormat($total_opname, true) . '</b>', 'class' => 'text-right'],
                        ];
                        $total_opname = 0;
                    }


                    // buat header
                    $table_rows[] = [
                        ['colspan' => '8', 'text' => '<b>' . $row['opname_code'] . '</b>', 'class' => 'text-left'],
                    ];
                }

                $opname_stock_difference    = floatval($row['opname_stock_difference']);
                $warehouse_stock            = floatval($row['warehouse_stock']);
                $system_stock               = floatval($row['system_stock']);
                $eBaseCogs                  = explode(',', $row['base_cogs']);
                $base_cogs                  = floatval($eBaseCogs[0]);
                $diff_stock                 = $warehouse_stock - $system_stock;

                $table_rows[] = [
                    ['text' => indo_short_date($row['opname_date']), 'class' => 'text-left'],
                    ['text' => $row['warehouse_code'], 'class' => 'text-left col-fixed'],
                    ['text' => $row['product_code'], 'class' => 'text-left'],
                    ['text' => $row['product_name'], 'class' => 'text-left col-fixed'],
                    ['text' => numberFormat($base_cogs, true), 'class' => 'text-right'],
                    ['text' => numberFormat($diff_stock, true), 'class' => 'text-right'],
                    ['text' => $row['detail_remark'], 'class' => 'text-left col-fixed'],
                    ['text' => numberFormat($opname_stock_difference, true), 'class' => 'text-right'],
                ];

                $total_opname += $opname_stock_difference;
                $last_opname_code = $row['opname_code'];
            }

            if ($last_opname_code != '') {
                // buat footer
                $table_rows[] = [
                    ['colspan' => '7', 'text' => '<b>TOTAL</b>', 'class' => 'text-right'],
                    ['text' => '<b>' . numberFormat($total_opname, true) . '</b>', 'class' => 'text-right'],
                ];
            }


            $max_report_size    = 15;
            $pages              = array_chunk($table_rows, $max_report_size);
            $data['pages']      = $pages;
            $data['max_page']   = count($pages);

            $htmlView = $this->renderView('report/inventory/stock_opname_list_detail', $data);
            if ($agent->isMobile() && !$isDownload) {
                return $htmlView;
            } else {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('stock_opname_list.pdf', array("Attachment" => $isDownload));
                exit();
            }
        } else {
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

            $full_border = [
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

            $template = WRITEPATH . '/template/report/template_report.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);

            //make header //
            $iRow = 7;
            $sheet->getCell('A' . $iRow)->setValue('TANGGAL');
            $sheet->getCell('B' . $iRow)->setValue('KODE GUDANG');
            $sheet->getCell('C' . $iRow)->setValue('NAMA GUDANG');
            $sheet->getCell('D' . $iRow)->setValue('KODE PRODUK');
            $sheet->getCell('E' . $iRow)->setValue('NAMA PRODUK');
            $sheet->getCell('F' . $iRow)->setValue('HPP');
            $sheet->getCell('G' . $iRow)->setValue('STOK FISIK');
            $sheet->getCell('H' . $iRow)->setValue('STOK GUDANG');
            $sheet->getCell('I' . $iRow)->setValue('SELISIH STOK');
            $sheet->getCell('J' . $iRow)->setValue('KETERANGAN');
            $sheet->getCell('K' . $iRow)->setValue('DIINPUT OLEH');
            $sheet->getCell('L' . $iRow)->setValue('SELISIH (Rp)');


            $sheet->getStyle('A' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('B' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('C' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('D' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('E' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('F' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('G' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('H' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('I' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('J' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('K' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('L' . $iRow)->applyFromArray($header_format);
            $iRow++;


            $last_opname_code   = '';
            $total_opname       = 0;
            foreach ($getData as $row) {
                if ($last_opname_code != $row['opname_code']) {
                    if ($last_opname_code != '') {
                        // buat footer
                        $sheet->getCell('A' . $iRow)->setValue('TOTAL');
                        $sheet->getCell('L' . $iRow)->setValue($total_opname);
                        $sheet->mergeCells('A' . $iRow . ':K' . $iRow);
                        $sheet->getStyle('A' . $iRow . ':K' . $iRow)->getAlignment()->setHorizontal('right');
                        $sheet->getStyle('A' . $iRow . ':K' . $iRow)->applyFromArray($total_format);
                        $sheet->getStyle('L' . $iRow)->applyFromArray($total_format);
                        $iRow++;
                        $total_opname = 0;
                    }


                    // buat header
                    $sheet->getCell('A' . $iRow)->setValue($row['opname_code']);
                    $sheet->mergeCells('A' . $iRow . ':L' . $iRow);
                    $sheet->getStyle('A' . $iRow . ':L' . $iRow)->applyFromArray($font_bold);
                    $sheet->getStyle('A' . $iRow . ':L' . $iRow)->applyFromArray($full_border);
                    $iRow++;
                }

                $opname_stock_difference    = floatval($row['opname_stock_difference']);
                $warehouse_stock            = floatval($row['warehouse_stock']);
                $system_stock               = floatval($row['system_stock']);
                $eBaseCogs                  = explode(',', $row['base_cogs']);
                $base_cogs                  = floatval($eBaseCogs[0]);
                $diff_stock                 = $warehouse_stock - $system_stock;



                $sheet->getCell('A' . $iRow)->setValue(indo_short_date($row['opname_date']));
                $sheet->getCell('B' . $iRow)->setValue($row['warehouse_code']);
                $sheet->getCell('C' . $iRow)->setValue($row['warehouse_name']);
                $sheet->getCell('D' . $iRow)->setValue($row['product_code']);
                $sheet->getCell('E' . $iRow)->setValue($row['product_name']);
                $sheet->getCell('F' . $iRow)->setValue($base_cogs);
                $sheet->getCell('G' . $iRow)->setValue($warehouse_stock);
                $sheet->getCell('H' . $iRow)->setValue($system_stock);
                $sheet->getCell('I' . $iRow)->setValue($diff_stock);
                $sheet->getCell('J' . $iRow)->setValue($row['detail_remark']);
                $sheet->getCell('K' . $iRow)->setValue($row['user_realname']);
                $sheet->getCell('L' . $iRow)->setValue($opname_stock_difference);

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
                $iRow++;

                $total_opname += $opname_stock_difference;
                $last_opname_code = $row['opname_code'];
            }

            if ($last_opname_code != '') {
                // buat footer
                $sheet->getCell('A' . $iRow)->setValue('TOTAL');
                $sheet->getCell('L' . $iRow)->setValue($total_opname);
                $sheet->mergeCells('A' . $iRow . ':K' . $iRow);
                $sheet->getStyle('A' . $iRow . ':K' . $iRow)->getAlignment()->setHorizontal('right');
                $sheet->getStyle('A' . $iRow . ':K' . $iRow)->applyFromArray($total_format);
                $sheet->getStyle('L' . $iRow)->applyFromArray($total_format);
                $iRow++;
            }



            //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('A5')->setValue('Periode');
            $sheet->getStyle('A5')->applyFromArray($font_bold);
            $sheet->getCell('B5')->setValue($periode_text);
            $sheet->mergeCells('B5:L5');

            $sheet->getCell('A6')->setValue('Gudang');
            $sheet->getStyle('A6')->applyFromArray($font_bold);
            $sheet->getCell('B6')->setValue($warehouse_name);
            $sheet->mergeCells('B6:L6');

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

            $sheet->mergeCells('A4:L4');
            $sheet->mergeCells('A3:L3');
            $sheet->mergeCells('A2:L2');
            $sheet->mergeCells('A1:L1');

            $sheet->getStyle('A4:L4')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3:L3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:L2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A4:L4')->applyFromArray($font_bold);
            $sheet->getStyle('A3:L3')->applyFromArray($font_bold);
            $sheet->getStyle('A2:L2')->applyFromArray($font_bold);

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
            $sheet->getColumnDimension('I')->setAutoSize(true);
            $sheet->getColumnDimension('J')->setAutoSize(true);
            $sheet->getColumnDimension('K')->setAutoSize(true);
            $sheet->getColumnDimension('L')->setAutoSize(true);


            $filename = 'stock_opname_list';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    public function viewExpStockList()
    {
        $data = [
            'title'         => 'Daftar Stok Kedaluwarsa',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_exp_stock_list', $data);
    }

    public function expStockList()
    {
        $warehouse_id   = $this->request->getGet('warehouse_id') != null ? $this->request->getGet('warehouse_id') : '';
        $warehouse_name = $this->request->getGet('warehouse_name') != null ? $this->request->getGet('warehouse_name') : '-';



        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $data = [
            'title'             => 'Daftar Produk Kadaluwarsa',
            'userLogin'         => $this->userLogin,
            'warehouse_id'      => $warehouse_id,
            'warehouse_name'    => $warehouse_name,
        ];

        $M_product       = model('M_product');
        $getData         = $M_product->getReportExpStockList($warehouse_id)->getResultArray();


        if ($fileType == 'pdf') {
            $max_report_size    = 15;
            $pages              = array_chunk($getData, $max_report_size);
            $data['pages']      = $pages;
            $data['max_page']   = count($pages);

            $htmlView = $this->renderView('report/inventory/exp_stock_list', $data);
            if ($agent->isMobile() && !$isDownload) {
                return $htmlView;
            } else {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('stock_kadaluwarsa.pdf', array("Attachment" => $isDownload));
                exit();
            }
        } else {
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

            //make header //
            $iRow = 7;
            $sheet->getCell('A' . $iRow)->setValue('KODE PRODUK');
            $sheet->getCell('B' . $iRow)->setValue('NAMA PRODUK');
            $sheet->getCell('C' . $iRow)->setValue('KATEGORI');
            $sheet->getCell('D' . $iRow)->setValue('MEREK');
            $sheet->getCell('E' . $iRow)->setValue('PPN');
            $sheet->getCell('F' . $iRow)->setValue('KODE GUDANG');
            $sheet->getCell('G' . $iRow)->setValue('NAMA GUDANG');
            $sheet->getCell('H' . $iRow)->setValue('EXP DATE');
            $sheet->getCell('I' . $iRow)->setValue('STOK');

            $sheet->getStyle('A' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('B' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('C' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('D' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('E' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('F' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('G' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('H' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('I' . $iRow)->applyFromArray($header_format);
            $iRow++;

            foreach ($getData as $row) {
                $sheet->getCell('A' . $iRow)->setValue($row['product_code']);
                $sheet->getCell('B' . $iRow)->setValue($row['product_name']);
                $sheet->getCell('C' . $iRow)->setValue($row['category_name']);
                $sheet->getCell('D' . $iRow)->setValue($row['brand_name']);
                $sheet->getCell('E' . $iRow)->setValue($row['has_tax']);
                $sheet->getCell('F' . $iRow)->setValue($row['warehouse_code']);
                $sheet->getCell('G' . $iRow)->setValue($row['warehouse_name']);
                $sheet->getCell('H' . $iRow)->setValue(indo_short_date($row['exp_date']));
                $sheet->getCell('I' . $iRow)->setValue(floatval($row['stock']));


                $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('I' . $iRow)->applyFromArray($border_left_right);
                $iRow++;
            }

            $sheet->getStyle('A' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('B' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('C' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('D' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('E' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('F' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('G' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('H' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('I' . $iRow)->applyFromArray($border_top);

            //setting periode
            $sheet->getCell('A5')->setValue('Gudang');
            $sheet->getStyle('A5')->applyFromArray($font_bold);
            $sheet->getCell('B5')->setValue($warehouse_name);
            $sheet->mergeCells('B5:H5');


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

            $sheet->mergeCells('A4:I4');
            $sheet->mergeCells('A3:I3');
            $sheet->mergeCells('A2:I2');
            $sheet->mergeCells('A1:I1');

            $sheet->getStyle('A4:I4')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:I2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A4:I4')->applyFromArray($font_bold);
            $sheet->getStyle('A3:I3')->applyFromArray($font_bold);
            $sheet->getStyle('A2:I2')->applyFromArray($font_bold);

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
            $sheet->getColumnDimension('I')->setAutoSize(true);

            $filename = 'daftar_produk_kadaluwarsa';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }


    public function viewStockCard()
    {
        $data = [
            'title'         => 'Kartu Stok',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_stock_card', $data);
    }

    public function stockCard()
    {
        $start_date     = $this->request->getGet('start_date') != null ? $this->request->getGet('start_date') : date('Y-m') . '-01';
        $end_date       = $this->request->getGet('end_date') != null ? $this->request->getGet('end_date') : date('Y-m-d');
        $warehouse_id   = $this->request->getGet('warehouse_id') != null ? $this->request->getGet('warehouse_id') : '';
        $warehouse_name = $this->request->getGet('warehouse_name') != null ? $this->request->getGet('warehouse_name') : 'Semua';
        $product_id     = $this->request->getGet('product_id') != null ? $this->request->getGet('product_id') : '';

        $agent          = $this->request->getUserAgent();
        $isDownload     = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType       = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }


        if ($product_id == null) {
            die('<h1>Harap pilih produk terlebih dahulu</h1>');
        } else {
            $product_ids = [];
            if ($product_id != null) {
                $product_ids = explode(',', $product_id);
            }

            $M_warehouse        = model('M_warehouse');
            $M_product          = model('M_product');

            $getProduct         = $M_product->getListProductByID($product_ids)->getResultArray();
            $getWarehouse       = $M_warehouse->getWarehouse($warehouse_id)->getResultArray();

            /* datasource stock */
            $stockData_sample = [
                'P0001' => [       // P0001 = product_id
                    [
                        'W1' => [ // W1 = warehouse_id 1
                            'init'    => 0,
                            'data'    => [
                                ['date' => 'mysql_date', 'remark' => '', 'stock_in' => 0, 'stock_out' => 0, 'stock_final' => 0, 'created_at' => 'mysql_datetime'],
                                ['date' => 'mysql_date', 'remark' => '', 'stock_in' => 0, 'stock_out' => 0, 'stock_final' => 0, 'created_at' => 'mysql_datetime']
                            ]
                        ]
                    ]
                ]
            ];
            $stockData = [];

            $init_max_date = new \DateTime($start_date); //1 hari sebelum tgl mulai
            $init_max_date->sub(new \DateInterval('P1D'));
            $sInitMaxDate = $init_max_date->format('Y-m-d');


            $getInitStock = $M_product->getReportInitStock($product_ids, null,  $sInitMaxDate);
            foreach ($getInitStock as $row) {
                $pid =  'P' . $row['product_id'];
                $wid = 'W' . $row['warehouse_id'];
                $stockData[$pid][$wid]['init'] = floatval($row['stock']);
            }

            $getStockLog = $M_product->getReportStockLog($product_ids, $start_date, $end_date);
            foreach ($getStockLog as $row) {
                $pid =  'P' . $row['product_id'];
                $wid = 'W' . $row['warehouse_id'];
                $stockData[$pid][$wid]['data'][] = $row;
            }

            if ($fileType == 'pdf') {
                die('<h1>Excel Only</h1>');
                $getData = [];

                $max_report_size    = 15;
                $pages              = array_chunk($getData, $max_report_size);
                $data['pages']      = $pages;
                $data['max_page']   = count($pages);

                $htmlView = $this->renderView('report/inventory/stock_list_v2', $data);
                if ($agent->isMobile() && !$isDownload) {
                    return $htmlView;
                } else {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('stock_list.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            } else {
                //dd($getProduct, $stockData);
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
                $iRow = 7;


                foreach ($getProduct as $product) {
                    $pid = 'P' . $product['product_id'];
                    $product_title = $product['product_code'] . ' - ' . $product['product_name'];
                    foreach ($getWarehouse as $warehouse) {
                        $warehouse_title = $warehouse['warehouse_code'] . ' - ' . $warehouse['warehouse_name'];
                        $wid = 'W' . $warehouse['warehouse_id'];

                        //make group title by product and warehouse
                        $sheet->getCell('A' . $iRow)->setValue('PRODUK');
                        $sheet->getStyle('A' . $iRow)->applyFromArray($font_bold);
                        $sheet->getCell('B' . $iRow)->setValue($product_title);
                        $iRow++;

                        $sheet->getCell('A' . $iRow)->setValue('GUDANG');
                        $sheet->getStyle('A' . $iRow)->applyFromArray($font_bold);
                        $sheet->getCell('B' . $iRow)->setValue($warehouse_title);
                        $iRow++;

                        //make header //
                        $sheet->getCell('A' . $iRow)->setValue('TANGGAL');
                        $sheet->getCell('B' . $iRow)->setValue('KETERANGAN');
                        $sheet->getCell('C' . $iRow)->setValue('STOK MASUK');
                        $sheet->getCell('D' . $iRow)->setValue('STOK KELUAR');
                        $sheet->getCell('E' . $iRow)->setValue('STOK AKHIR');

                        $sheet->getStyle('A' . $iRow)->applyFromArray($header_format);
                        $sheet->getStyle('B' . $iRow)->applyFromArray($header_format);
                        $sheet->getStyle('C' . $iRow)->applyFromArray($header_format);
                        $sheet->getStyle('D' . $iRow)->applyFromArray($header_format);
                        $sheet->getStyle('E' . $iRow)->applyFromArray($header_format);
                        $iRow++;


                        // SET INIT STOCK //
                        $stock = isset($stockData[$pid][$wid]['init']) ? $stockData[$pid][$wid]['init'] : 0;
                        $sheet->getCell('A' . $iRow)->setValue('');
                        $sheet->getCell('B' . $iRow)->setValue('Saldo Awal');
                        $sheet->getCell('C' . $iRow)->setValue(0);
                        $sheet->getCell('D' . $iRow)->setValue(0);
                        $sheet->getCell('E' . $iRow)->setValue($stock);

                        $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                        $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                        $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                        $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                        $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                        $iRow++;


                        $stockLog = isset($stockData[$pid][$wid]['data']) ? $stockData[$pid][$wid]['data'] : [];
                        foreach ($stockLog as $row) {
                            $stock_in   = floatval($row['stock_in']);
                            $stock_out  = floatval($row['stock_out']);
                            $stock      = $stock + $stock_in + $stock_out;
                            $sheet->getCell('A' . $iRow)->setValue(indo_short_date($row['stock_date']));
                            $sheet->getCell('B' . $iRow)->setValue($row['stock_remark']);
                            $sheet->getCell('C' . $iRow)->setValue($stock_in);
                            $sheet->getCell('D' . $iRow)->setValue($stock_out);
                            $sheet->getCell('E' . $iRow)->setValue($stock);

                            $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                            $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                            $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                            $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                            $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                            $iRow++;
                        }

                        $sheet->getStyle('A' . $iRow)->applyFromArray($border_top);
                        $sheet->getStyle('B' . $iRow)->applyFromArray($border_top);
                        $sheet->getStyle('C' . $iRow)->applyFromArray($border_top);
                        $sheet->getStyle('D' . $iRow)->applyFromArray($border_top);
                        $sheet->getStyle('E' . $iRow)->applyFromArray($border_top);
                        $iRow++;
                        $iRow++;
                    }
                }


                //setting periode
                $filter_date = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
                $sheet->getCell('A5')->setValue('TANGGAL');
                $sheet->getStyle('A5')->applyFromArray($font_bold);
                $sheet->getCell('B5')->setValue($filter_date);
                $sheet->mergeCells('B5:E5');

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

                $sheet->mergeCells('A4:E4');
                $sheet->mergeCells('A3:E3');
                $sheet->mergeCells('A2:E2');
                $sheet->mergeCells('A1:E1');

                $sheet->getStyle('A4:E4')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A3:E3')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2:E2')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal('right');

                $sheet->getStyle('A4:E4')->applyFromArray($font_bold);
                $sheet->getStyle('A3:E3')->applyFromArray($font_bold);
                $sheet->getStyle('A2:E2')->applyFromArray($font_bold);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);


                $filename = 'stock_card';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
                exit();
            }
        }
    }

    public function viewSafetyStock()
    {
        $data = [
            'title'         => 'Laporan Safety Stock',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_safety_stock', $data);
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

    public function viewPriceChangeList()
    {
        $data = [
            'title'         => 'Laporan Perubahan Harga Beli & Jual',
            'customerGroup' => $this->appConfig->get('default', 'customer_group'),
        ];

        return $this->renderView('report/inventory/view_price_change_list', $data);
    }


    public function priceChangeList_v1()
    {
        $start_date             = $this->request->getGet('start_date') != null ? $this->request->getGet('start_date') : date('Y-m') . '-01';
        $end_date               = $this->request->getGet('end_date') != null ? $this->request->getGet('end_date') : date('Y-m-d');
        $product_id             = $this->request->getGet('product_id') != null ? $this->request->getGet('product_id') : '';

        $agent                  = $this->request->getUserAgent();
        $isDownload             = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType               = $this->request->getGet('file');


        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }


        if ($product_id == null) {
            die('<h1>Harap pilih produk terlebih dahulu</h1>');
        } else {
            $M_product          = model('M_product');

            $getProduct = $M_product->getProduct($product_id, true)->getRowArray();
            if ($getProduct == null) {
                die("<h1>Produk tidak ditemukan</h1>");
            }

            $cGroup = [];
            $getConfig = $this->appConfig->get('default', 'customer_group');
            foreach ($getConfig as $key => $val) {
                $cGroup[$key] = preg_replace('/<[^>]*>/', '', $val);
            }

            $getHistorySalesPrice       = $M_product->getHistorySalesPrice($product_id, $start_date, $end_date);
            $getHistoryPurchasePrice    = $M_product->getHistoryPurchasePrice($product_id, $start_date, $end_date);






            if ($fileType == 'pdf') {
                die('<h1>Excel Only</h1>');
                $getData = [];

                $max_report_size    = 15;
                $pages              = array_chunk($getData, $max_report_size);
                $data['pages']      = $pages;
                $data['max_page']   = count($pages);

                $htmlView = $this->renderView('report/inventory/stock_list_v2', $data);
                if ($agent->isMobile() && !$isDownload) {
                    return $htmlView;
                } else {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('stock_list.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            } else {
                //dd($getProduct, $stockData);
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
                $iRow = 8;

                $last_customer_group    = '';
                $last_price             = 0;
                foreach ($getHistorySalesPrice as $row) {
                    if ($row['customer_group'] != $last_customer_group) {
                        if ($last_customer_group != '') {
                            $last_price = 0;
                            // close table //
                            $sheet->getStyle('A' . $iRow)->applyFromArray($border_top);
                            $sheet->getStyle('B' . $iRow)->applyFromArray($border_top);
                            $iRow++;
                        }

                        // MAKE HEADER // 
                        $title_group = isset($cGroup[$row['customer_group']]) ? $cGroup[$row['customer_group']] : $row['customer_group'];
                        $sheet->getCell('A' . $iRow)->setValue('Harga Jual ' . $title_group);
                        $sheet->getStyle('A' . $iRow)->applyFromArray($font_bold);
                        $sheet->mergeCells('A' . $iRow . ':E' . $iRow);
                        $iRow++;

                        $sheet->getCell('A' . $iRow)->setValue('TANGGAL');
                        $sheet->getCell('B' . $iRow)->setValue('HARGA JUAL');
                        $sheet->getStyle('A' . $iRow)->applyFromArray($header_format);
                        $sheet->getStyle('B' . $iRow)->applyFromArray($header_format);
                        $iRow++;
                        // END MAKE HEADER //
                    }

                    $sales_price = floatval($row['sales_price']);
                    if ($sales_price != $last_price) {
                        // print //
                        $sheet->getCell('A' . $iRow)->setValue(indo_short_date($row['sales_date']));
                        $sheet->getCell('B' . $iRow)->setValue(numberFormat($sales_price, true));

                        $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                        $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                        $iRow++;
                    }

                    $last_price = $sales_price;
                    $last_customer_group = $row['customer_group'];
                }

                if ($last_customer_group != '') {
                    // close table //
                    $sheet->getStyle('A' . $iRow)->applyFromArray($border_top);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($border_top);
                    $iRow++;
                }

                if (count($getHistoryPurchasePrice) > 0) {
                    $sheet->getCell('A' . $iRow)->setValue('Harga Beli');
                    $sheet->getStyle('A' . $iRow)->applyFromArray($font_bold);
                    $sheet->mergeCells('A' . $iRow . ':E' . $iRow);
                    $iRow++;

                    $sheet->getCell('A' . $iRow)->setValue('TANGGAL');
                    $sheet->getCell('B' . $iRow)->setValue('HARGA BELI');
                    $sheet->getStyle('A' . $iRow)->applyFromArray($header_format);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($header_format);
                    $iRow++;

                    $last_price             = 0;
                    foreach ($getHistoryPurchasePrice as $row) {
                        $purchase_price = floatval($row['purchase_price']);
                        if ($purchase_price != $last_price) {
                            $sheet->getCell('A' . $iRow)->setValue(indo_short_date($row['purchase_date']));
                            $sheet->getCell('B' . $iRow)->setValue(numberFormat($purchase_price, true));

                            $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                            $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                            $iRow++;
                        }
                        $last_price = $purchase_price;
                    }

                    // close table //
                    $sheet->getStyle('A' . $iRow)->applyFromArray($border_top);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($border_top);
                    $iRow++;
                }

                //setting periode
                $sheet->getCell('A5')->setValue('PRODUK');
                $sheet->getStyle('A5')->applyFromArray($font_bold);
                $sheet->getCell('B5')->setValue($getProduct['product_code'] . ' - ' . $getProduct['product_name']);
                $sheet->mergeCells('B5:E5');

                $filter_date = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
                $sheet->getCell('A6')->setValue('TANGGAL');
                $sheet->getStyle('A6')->applyFromArray($font_bold);
                $sheet->getCell('B6')->setValue($filter_date);
                $sheet->mergeCells('B6:E6');

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

                $sheet->mergeCells('A4:E4');
                $sheet->mergeCells('A3:E3');
                $sheet->mergeCells('A2:E2');
                $sheet->mergeCells('A1:E1');

                $sheet->getStyle('A4:E4')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A3:E3')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2:E2')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal('right');

                $sheet->getStyle('A4:E4')->applyFromArray($font_bold);
                $sheet->getStyle('A3:E3')->applyFromArray($font_bold);
                $sheet->getStyle('A2:E2')->applyFromArray($font_bold);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);


                $filename = 'laporan_perubahan_harga_jual_beli';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
                exit();
            }
        }
    }

    public function priceChangeList()
    {
        $start_date             = $this->request->getGet('start_date') != null ? $this->request->getGet('start_date') : date('Y-m') . '-01';
        $end_date               = $this->request->getGet('end_date') != null ? $this->request->getGet('end_date') : date('Y-m-d');
        $product_id             = $this->request->getGet('product_id') != null ? $this->request->getGet('product_id') : '';

        $agent                  = $this->request->getUserAgent();
        $isDownload             = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType               = $this->request->getGet('file');


        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }


        if ($product_id == null) {
            die('<h1>Harap pilih produk terlebih dahulu</h1>');
        } else {
            $M_product          = model('M_product');

            $getProduct = $M_product->getProduct($product_id, true)->getRowArray();
            if ($getProduct == null) {
                die("<h1>Produk tidak ditemukan</h1>");
            }

            $cGroup = [];
            $getConfig = $this->appConfig->get('default', 'customer_group');
            foreach ($getConfig as $key => $val) {
                $cGroup[$key] = preg_replace('/<[^>]*>/', '', $val);
            }

            //$getHistorySalesPrice       = $M_product->getHistorySalesPrice($product_id, $start_date, $end_date);

            $getHistoryChangePrice      = $M_product->getLogChangePrice($product_id, $start_date, $end_date);


            $getHistoryPurchasePrice    = $M_product->getHistoryPurchasePrice($product_id, $start_date, $end_date);

            if ($fileType == 'pdf') {
                die('<h1>Excel Only</h1>');
                $getData = [];

                $max_report_size    = 15;
                $pages              = array_chunk($getData, $max_report_size);
                $data['pages']      = $pages;
                $data['max_page']   = count($pages);

                $htmlView = $this->renderView('report/inventory/stock_list_v2', $data);
                if ($agent->isMobile() && !$isDownload) {
                    return $htmlView;
                } else {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('stock_list.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            } else {
                //dd($getProduct, $stockData);
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
                $iRow = 8;

                $last_customer_group    = '';
                foreach ($getHistoryChangePrice as $row) {
                    if ($row['customer_group'] != $last_customer_group) {
                        if ($last_customer_group != '') {
                            // close table //
                            $sheet->getStyle('A' . $iRow)->applyFromArray($border_top);
                            $sheet->getStyle('B' . $iRow)->applyFromArray($border_top);
                            $sheet->getStyle('C' . $iRow)->applyFromArray($border_top);
                            $sheet->getStyle('D' . $iRow)->applyFromArray($border_top);
                            $sheet->getStyle('E' . $iRow)->applyFromArray($border_top);
                            $iRow++;
                        }

                        // MAKE HEADER // 
                        $title_group = isset($cGroup[$row['customer_group']]) ? $cGroup[$row['customer_group']] : $row['customer_group'];
                        $sheet->getCell('A' . $iRow)->setValue('Harga Jual ' . $title_group);
                        $sheet->getStyle('A' . $iRow)->applyFromArray($font_bold);
                        $sheet->mergeCells('A' . $iRow . ':E' . $iRow);
                        $iRow++;

                        $sheet->getCell('A' . $iRow)->setValue('TANGGAL');
                        $sheet->getCell('B' . $iRow)->setValue('HARGA LAMA');
                        $sheet->getCell('C' . $iRow)->setValue('HARGA BARU');
                        $sheet->getCell('D' . $iRow)->setValue('KETERANGAN');
                        $sheet->getCell('E' . $iRow)->setValue('OLEH USER');
                        $sheet->getStyle('A' . $iRow)->applyFromArray($header_format);
                        $sheet->getStyle('B' . $iRow)->applyFromArray($header_format);
                        $sheet->getStyle('C' . $iRow)->applyFromArray($header_format);
                        $sheet->getStyle('D' . $iRow)->applyFromArray($header_format);
                        $sheet->getStyle('E' . $iRow)->applyFromArray($header_format);
                        $iRow++;
                        // END MAKE HEADER //


                    }

                    // print //


                    $sheet->getCell('A' . $iRow)->setValue(indo_short_date($row['update_date']));
                    $sheet->getCell('B' . $iRow)->setValue(numberFormat($row['old_sales_price'], true));
                    $sheet->getCell('C' . $iRow)->setValue(numberFormat($row['new_sales_price'], true));
                    $sheet->getCell('D' . $iRow)->setValue($row['update_remark']);
                    $sheet->getCell('E' . $iRow)->setValue($row['user_name']);

                    $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                    $iRow++;

                    $last_customer_group = $row['customer_group'];
                }

                if ($last_customer_group != '') {
                    // close table //
                    $sheet->getStyle('A' . $iRow)->applyFromArray($border_top);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($border_top);
                    $sheet->getStyle('C' . $iRow)->applyFromArray($border_top);
                    $sheet->getStyle('D' . $iRow)->applyFromArray($border_top);
                    $sheet->getStyle('E' . $iRow)->applyFromArray($border_top);
                    $iRow++;
                }

                if (count($getHistoryPurchasePrice) > 0) {
                    $sheet->getCell('A' . $iRow)->setValue('Harga Beli');
                    $sheet->getStyle('A' . $iRow)->applyFromArray($font_bold);
                    $sheet->mergeCells('A' . $iRow . ':E' . $iRow);
                    $iRow++;

                    $sheet->getCell('A' . $iRow)->setValue('TANGGAL');
                    $sheet->getCell('B' . $iRow)->setValue('HARGA BELI');
                    $sheet->getStyle('A' . $iRow)->applyFromArray($header_format);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($header_format);
                    $iRow++;

                    $last_price             = 0;
                    foreach ($getHistoryPurchasePrice as $row) {
                        $purchase_price = floatval($row['purchase_price']);
                        if ($purchase_price != $last_price) {
                            $sheet->getCell('A' . $iRow)->setValue(indo_short_date($row['purchase_date']));
                            $sheet->getCell('B' . $iRow)->setValue(numberFormat($purchase_price, true));

                            $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                            $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                            $iRow++;
                        }
                        $last_price = $purchase_price;
                    }

                    // close table //
                    $sheet->getStyle('A' . $iRow)->applyFromArray($border_top);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($border_top);
                    $iRow++;
                }

                //setting periode
                $sheet->getCell('A5')->setValue('PRODUK');
                $sheet->getStyle('A5')->applyFromArray($font_bold);
                $sheet->getCell('B5')->setValue($getProduct['product_code'] . ' - ' . $getProduct['product_name']);
                $sheet->mergeCells('B5:E5');

                $filter_date = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
                $sheet->getCell('A6')->setValue('TANGGAL');
                $sheet->getStyle('A6')->applyFromArray($font_bold);
                $sheet->getCell('B6')->setValue($filter_date);
                $sheet->mergeCells('B6:E6');

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

                $sheet->mergeCells('A4:E4');
                $sheet->mergeCells('A3:E3');
                $sheet->mergeCells('A2:E2');
                $sheet->mergeCells('A1:E1');

                $sheet->getStyle('A4:E4')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A3:E3')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A2:E2')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal('right');

                $sheet->getStyle('A4:E4')->applyFromArray($font_bold);
                $sheet->getStyle('A3:E3')->applyFromArray($font_bold);
                $sheet->getStyle('A2:E2')->applyFromArray($font_bold);

                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);


                $filename = 'laporan_perubahan_harga_jual_beli';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
                exit();
            }
        }
    }

    public function stockOpnameList_old()
    {
        $data = [
            'title'         => 'Daftar Stok Opname',
            'userLogin'     => $this->userLogin
        ];


        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $detail     = $this->request->getGet('detail') == NULL ? 'N' : $this->request->getGet('detail');
        $agent      = $this->request->getUserAgent();

        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }

        $detail = 'Y';
        if ($detail == 'Y') {
            $htmlView   = view('webmin/report/inventory/stock_opname_list_detail', $data);
        } else {
            $htmlView   = view('webmin/report/inventory/stock_opname_list', $data);
        }

        if ($agent->isMobile()  && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('stock_opname.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }

    public function viewStockTransferList()
    {
        $data = [
            'title'         => 'Daftar Stok Transfer',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_stock_transfer_list', $data);
    }

    public function stockTransferList()
    {
        if ($this->role->hasRole('report.stock_transfer')) {

            $M_stock_transfer = model('M_stock_transfer');

            $start_date          = $this->request->getGet('start_date') != NULL ? $this->request->getGet('start_date') : date('Y-m') . '-01';
            $end_date            = $this->request->getGet('end_date') != NULL ? $this->request->getGet('end_date') : date('Y-m-d');
            $source_warehouse_id = $this->request->getGet('source_warehouse_id');
            $dest_warehouse_id   = $this->request->getGet('dest_warehouse_id');
            $isDownload          = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType            = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent               = $this->request->getUserAgent();

            if (!in_array($fileType, ['pdf', 'xls'])) {
                $fileType = 'pdf';
            }

            $getReportData = $M_stock_transfer->getTransfer($start_date, $end_date, $source_warehouse_id, $dest_warehouse_id)->getResultArray();

            if ($getReportData != null) {
                $warehouse_from_name = $getReportData[0]['warehouse_from_name'];
                $warehouse_to_name = $getReportData[0]['warehouse_to_name'];
            } else {
                $warehouse_from_name = '-';
                $warehouse_to_name = '-';
            }

            if ($fileType == 'pdf') {
                $cRow           = count($getReportData);
                if ($cRow % 16 == 0) {
                    $max_page_item  = 15;
                } else {
                    $max_page_item  = 16;
                }
                $transferstock    = array_chunk($getReportData, $max_page_item);
                $data = [
                    'title'                 => 'Laporan Transfer Stock',
                    'start_date'            => $start_date,
                    'end_date'              => $end_date,
                    'warehouse_from_name'   => $warehouse_from_name,
                    'warehouse_to_name'     => $warehouse_to_name,
                    'pages'                 => $transferstock,
                    'maxPage'               => count($transferstock),
                    'userLogin'             => $this->userLogin
                ];


                $htmlView   = view('webmin/report/inventory/stock_transfer_list_detail', $data);

                if ($agent->isMobile()  && !$isDownload) {
                    return $htmlView;
                } else {
                    if ($fileType == 'pdf') {
                        $dompdf = new Dompdf();
                        $dompdf->loadHtml($htmlView);
                        $dompdf->setPaper('A4', 'landscape');
                        $dompdf->render();
                        $dompdf->stream('Stoktransfer.pdf', array("Attachment" => $isDownload));
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

                $template = WRITEPATH . '/template/template_export_transfer_stock.xlsx';
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

                $sheet = $spreadsheet->setActiveSheetIndex(0);
                $iRow = 8;

                foreach ($getReportData as $row) {


                    $hd_transfer_stock_date = indo_short_date($row['hd_transfer_stock_date'], FALSE);

                    $sheet->getCell('A' . $iRow)->setValue($row['hd_transfer_stock_no']);
                    $sheet->getCell('B' . $iRow)->setValue($hd_transfer_stock_date);
                    $sheet->getCell('C' . $iRow)->setValue($row['warehouse_from_code']);
                    $sheet->getCell('D' . $iRow)->setValue($row['warehouse_to_code']);
                    $sheet->getCell('E' . $iRow)->setValue($row['product_code']);
                    $sheet->getCell('F' . $iRow)->setValue($row['product_name']);
                    $sheet->getCell('G' . $iRow)->setValue($row['unit_name']);
                    $sheet->getCell('H' . $iRow)->setValue(numberFormat($row['item_qty'], FALSE));

                    $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);

                    $iRow++;
                }

                //setting periode
                $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
                $sheet->getCell('B5')->setValue($periode_text);
                $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_date(date('Y-m-d H:i:s'), FALSE);
                $sheet->getCell('A1')->setValue($reportInfo);

                $sheet->mergeCells('A1:H1');

                $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal('right');

                $sheet->getStyle('A2:H2')->applyFromArray($font_bold);


                $filename = 'Laporan Pembayaran Hutang';
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

    public function viewDeadStockList()
    {
        $data = [
            'title'         => 'Daftar Dead Stok',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/inventory/view_dead_stock_list', $data);
    }

    public function deadStockList()
    {
        $percent_sales      = $this->request->getGet('percent_sales') != null ? floatval($this->request->getGet('percent_sales')) : 20;
        $cutoff_date        = $this->request->getGet('cutoff_date') != null ? $this->request->getGet('cutoff_date') : date('Y-m') . '-01';
        $three_months_ago   = date('Y-m-d', strtotime('-3 months', strtotime($cutoff_date)));
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();


        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }


        $M_product = model('M_product');

        $getProduct = $M_product->getReportStockProduct()->getResultArray();

        $list_product_id    = []; //list array product_id 1,2,3
        $stockData          = [];
        $sampleStockData = [
            'P1' => [
                'purchase'  => 10,
                'sales'     => 10,
            ]
        ];


        foreach ($getProduct as $row) {
            $list_product_id[] = $row['product_id'];
        }


        $max_get_product = 500;
        $batchProductIds = array_chunk($list_product_id, $max_get_product);
        foreach ($batchProductIds as $product_ids) {
            $getSalesStock      = $M_product->getSalesStockByProduct($product_ids, null, $cutoff_date);
            $getPurchaseStock   = $M_product->getPurchaseStockByProduct($product_ids, null,  $three_months_ago);

            foreach ($getSalesStock as $row) {
                $pid = 'P' . $row['product_id'];
                $stockData[$pid]['sales'] = floatval($row['sales_stock']);
            }


            foreach ($getPurchaseStock as $row) {
                $pid = 'P' . $row['product_id'];
                $stockData[$pid]['purchase'] = floatval($row['purchase_stock']);
            }
        }

        if ($fileType == 'pdf') {
            die('Export Excel Only');
            $data = [
                'title'         => 'Daftar Dead Stok',
                'userLogin'     => $this->userLogin
            ];
            $htmlView   = view('webmin/report/inventory/dead_stock_list', $data);
            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('daftar_dead_stock.pdf', array("Attachment" => $isDownload));
                exit();
            }
        } else {

            // dd($getProduct, $stockData);
            // die('Export Excel Script');
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
            $iRow = 8;

            // MAKE HEADER // 
            $sheet->getCell('A' . $iRow)->setValue('KODE PRODUK');
            $sheet->getCell('B' . $iRow)->setValue('NAMA PRODUK');
            $sheet->getCell('C' . $iRow)->setValue('BRAND');
            $sheet->getCell('D' . $iRow)->setValue('KATEGORI');
            $sheet->getCell('E' . $iRow)->setValue('PERSENTASE (%)');
            $sheet->getCell('F' . $iRow)->setValue('HISTORI BARANG MASUK');
            $sheet->getCell('G' . $iRow)->setValue('HISTORI QTY JUAL');
            $sheet->getCell('H' . $iRow)->setValue('SISA STOK');
            $sheet->getCell('I' . $iRow)->setValue('KETERANGAN');

            $sheet->getStyle('A' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('B' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('C' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('D' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('E' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('F' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('G' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('H' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('I' . $iRow)->applyFromArray($header_format);
            $iRow++;
            // END MAKE HEADER //


            foreach ($getProduct as $row) {
                $pid = 'P' . $row['product_id'];

                $sales_stock        = isset($stockData[$pid]['sales']) ? $stockData[$pid]['sales'] : 0;
                $purchase_stock     = isset($stockData[$pid]['purchase']) ? $stockData[$pid]['purchase'] : 0;
                $product_percent    = $purchase_stock == 0 ? 100 : (($sales_stock / $purchase_stock) * 100);
                $stock              = $purchase_stock - $sales_stock;
                $product_status     = 'Stock Aman';
                if ($product_percent <= $percent_sales) {
                    $product_status     = 'Dead Stock';
                }
                $sheet->getCell('A' . $iRow)->setValue($row['product_code']);
                $sheet->getCell('B' . $iRow)->setValue($row['product_name']);
                $sheet->getCell('C' . $iRow)->setValue($row['brand_name']);
                $sheet->getCell('D' . $iRow)->setValue($row['category_name']);
                $sheet->getCell('E' . $iRow)->setValue(numberFormat($percent_sales, true));
                $sheet->getCell('F' . $iRow)->setValue(numberFormat($purchase_stock, true));
                $sheet->getCell('G' . $iRow)->setValue(numberFormat($sales_stock, true));
                $sheet->getCell('H' . $iRow)->setValue(numberFormat($stock, true));
                $sheet->getCell('I' . $iRow)->setValue($product_status);


                $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('I' . $iRow)->applyFromArray($border_left_right);
                $iRow++;
            }


            // close table //
            $sheet->getStyle('A' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('B' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('C' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('D' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('E' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('F' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('G' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('H' . $iRow)->applyFromArray($border_top);
            $sheet->getStyle('I' . $iRow)->applyFromArray($border_top);
            $iRow++;

            //setting periode

            $sheet->getCell('A5')->setValue('TANGGAL CUTOFF');
            $sheet->getStyle('A5')->applyFromArray($font_bold);
            $sheet->getCell('B5')->setValue(indo_short_date($cutoff_date));
            $sheet->mergeCells('B5:I5');

            $sheet->getCell('A6')->setValue('BATAS PEMBELIAN');
            $sheet->getStyle('A6')->applyFromArray($font_bold);
            $sheet->getCell('B6')->setValue(indo_short_date($three_months_ago));
            $sheet->mergeCells('B6:I6');

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

            $sheet->mergeCells('A4:I4');
            $sheet->mergeCells('A3:I3');
            $sheet->mergeCells('A2:I2');
            $sheet->mergeCells('A1:I1');

            $sheet->getStyle('A4:I4')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:I2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A4:I4')->applyFromArray($font_bold);
            $sheet->getStyle('A3:I3')->applyFromArray($font_bold);
            $sheet->getStyle('A2:I2')->applyFromArray($font_bold);

            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
            $sheet->getColumnDimension('I')->setAutoSize(true);


            $filename = 'laporan_dead_stock';
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
