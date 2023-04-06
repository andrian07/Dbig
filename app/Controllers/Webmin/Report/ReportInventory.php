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
        $data = [
            'title'         => 'Daftar Stok Kedaluwarsa',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/inventory/exp_stock_list', $data);
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
                $dompdf->stream('daftar_stok_kedaluwarsa.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }



    //--------------------------------------------------------------------

}
