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

        dd($this->userLogin);
        $warehouse_id   = $this->request->getGet('warehouse_id') != null ? $this->request->getGet('warehouse_id') : '';
        $warehouse_name = $this->request->getGet('warehouse_name') != null ? $this->request->getGet('warehouse_name') : '-';
        $product_tax    = $this->request->getGet('product_tax') != null ? $this->request->getGet('product_tax') : '';
        $start_date     = $this->request->getGet('start_date') != null ? $this->request->getGet('start_date') : '';
        $end_date       = $this->request->getGet('end_date') != null ? $this->request->getGet('end_date') : '';

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

        $M_warehouse        = model('M_warehouse');
        $M_product          = model('M_product');

        $getWarehouse       = $M_warehouse->getWarehouse($warehouse_id)->getResultArray();
        $getProduct         = $M_product->getReportProductList($product_tax)->getResultArray();

        /* test */
        $start_date         = '2023-06-01';
        //$start_date         = null;
        $end_date           = '2023-06-30';
        $ids                = ['36029', '36030'];


        $M_product->getReportInitStock($ids, $start_date, $end_date);

        die();

        /* list_product_id */
        $list_product_id    = [];
        foreach ($getProduct as $product) {
            $list_product_id[] = $product['product_id'];
        }

        /* get stock per 500 id */
        $max_get_stock      = 500;
        $chunk_product_id   = array_chunk($list_product_id, $max_get_stock);
        foreach ($chunk_product_id as $product_ids) {
            //d($product_ids);
        }






        //$getData            = $M_product->getReportWarehouseStockList($warehouse_id, $product_tax)->getResultArray();
        //dd($getWarehouse,  $getProduct);

        if ($fileType == 'pdf') {
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



    // ok //


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
        $warehouse_id   = $this->request->getGet('warehouse_id') != null ? $this->request->getGet('warehouse_id') : null;
        $product_id     = $this->request->getGet('product_id') != null ? $this->request->getGet('product_id') : null;

        if ($product_id == null) {
            die('<h1>Harap pilih produk terlebih dahulu</h1>');
        } else {

            if ($product_id != null) {
                $product_id = explode(',', $product_id);
            }

            $M_product = model('M_product');
            // foreach($product_id as $pid){
            //     $getStock = $M_product
            // }



            dd($start_date, $end_date);
        }

        exit();
        $data = [
            'title'         => 'Kartu Stok',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/inventory/stock_card', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }

        if ($agent->isMobile()  && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                set_time_limit(0);
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('kartu_stok.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
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
        $data = [
            'title'         => 'Daftar Stok Transfer',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/inventory/stock_transfer_list_detail', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }

        if ($agent->isMobile()  && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('stock_transfer.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
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
        $data = [
            'title'         => 'Daftar Dead Stok',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/inventory/dead_stock_list', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }

        if ($agent->isMobile()  && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('daftar_dead_stock.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }





    //--------------------------------------------------------------------

}
