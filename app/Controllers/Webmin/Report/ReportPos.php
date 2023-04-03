<?php

namespace App\Controllers\Webmin\Report;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;

class ReportPos extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        $data = [
            'title'     => 'Laporan Penjualan Retail',
        ];

        return $this->renderView('report/pos/view_sales_list', $data, 'report.pos_sales_list');
    }

    public function salesList()
    {
        $user_id        = $this->request->getGet('user_id') != null ? $this->request->getGet('user_id') : '';
        $user_realname  = $this->request->getGet('user_realname') != null ? $this->request->getGet('user_realname') : '-';
        $store_id       = $this->request->getGet('store_id') != null ? $this->request->getGet('store_id') : '';
        $store_name     = $this->request->getGet('store_name') != null ? $this->request->getGet('store_name') : '-';
        $start_date     = $this->request->getGet('start_date') != null ? $this->request->getGet('start_date') : date('Y-m-d');
        $end_date       = $this->request->getGet('end_date') != null ? $this->request->getGet('end_date') : date('Y-m-d');
        $product_tax    = $this->request->getGet('product_tax') != null ? $this->request->getGet('product_tax') : '';


        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $data = [
            'title'         => 'Laporan Penjualan',
            'userLogin'     => $this->userLogin,
            'user_id'       => $user_id,
            'user_realname' => $user_realname,
            'store_id'      => $store_id,
            'store_name'    => $store_name,
            'start_date'    => $start_date,
            'end_date'      => $end_date,
            'product_tax'   => $product_tax
        ];

        $M_sales_pos        = model('M_sales_pos');
        $getData            = $M_sales_pos->getReportSalesList($start_date, $end_date, $store_id, $user_id, $product_tax);
        // dd($getData);

        if ($fileType == 'pdf') {
            $max_report_size    = 14;
            $pages              = array_chunk($getData, $max_report_size);
            $data['pages']      = $pages;
            $data['max_page']   = count($pages);

            $htmlView = $this->renderView('report/pos/sales_list', $data);
            if ($agent->isMobile() && !$isDownload) {
                return $htmlView;
            } else {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_retail.pdf', array("Attachment" => $isDownload));
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

            $template = WRITEPATH . '/template/report/template_report.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);

            //make header //
            $iRow = 7;
            $sheet->getCell('A' . $iRow)->setValue('CABANG');
            $sheet->getCell('B' . $iRow)->setValue('KASIR');
            $sheet->getCell('C' . $iRow)->setValue('NO INVOICE');
            $sheet->getCell('D' . $iRow)->setValue('TANGGAL TRANSAKSI');
            $sheet->getCell('E' . $iRow)->setValue('METODE PEMBAYARAN');
            $sheet->getCell('F' . $iRow)->setValue('DPP');
            $sheet->getCell('G' . $iRow)->setValue('PPN');
            $sheet->getCell('H' . $iRow)->setValue('TOTAL');
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

            $sum_dpp_total      = 0;
            $sum_ppn_total      = 0;
            $sum_sales_total    = 0;
            foreach ($getData as $row) {
                $dpp        = floatval($row['sales_dpp']);
                $ppn        = floatval($row['sales_ppn']);
                $total      =  $dpp + $ppn;

                $sheet->getCell('A' . $iRow)->setValue($row['store_code']);
                $sheet->getCell('B' . $iRow)->setValue($row['user_realname']);
                $sheet->getCell('C' . $iRow)->setValue($row['pos_sales_invoice']);
                $sheet->getCell('D' . $iRow)->setValue(indo_short_date($row['pos_sales_date']));
                $sheet->getCell('E' . $iRow)->setValue($row['payment_list']);
                $sheet->getCell('F' . $iRow)->setValue($dpp);
                $sheet->getCell('G' . $iRow)->setValue($ppn);
                $sheet->getCell('H' . $iRow)->setValue($total);
                $sheet->getCell('I' . $iRow)->setValue($row['payment_remark']);

                $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('I' . $iRow)->applyFromArray($border_left_right);

                $sum_dpp_total      += $dpp;
                $sum_ppn_total      += $ppn;
                $sum_sales_total    += $total;
                $iRow++;
            }

            $sheet->getCell('A' . $iRow)->setValue('TOTAL');
            $sheet->getCell('F' . $iRow)->setValue($sum_dpp_total);
            $sheet->getCell('G' . $iRow)->setValue($sum_ppn_total);
            $sheet->getCell('H' . $iRow)->setValue($sum_sales_total);
            $sheet->mergeCells('A' . $iRow . ':E' . $iRow);
            $sheet->getStyle('A' . $iRow . ':E' . $iRow)->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A' . $iRow . ':E' . $iRow)->applyFromArray($total_format);
            $sheet->getStyle('F' . $iRow)->applyFromArray($total_format);
            $sheet->getStyle('G' . $iRow)->applyFromArray($total_format);
            $sheet->getStyle('H' . $iRow)->applyFromArray($total_format);
            $sheet->getStyle('I' . $iRow)->applyFromArray($total_format);

            //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('A5')->setValue('Periode');
            $sheet->getStyle('A5')->applyFromArray($font_bold);
            $sheet->getCell('B5')->setValue($periode_text);

            $sheet->getCell('A6')->setValue('Filter');
            $sheet->getStyle('A6')->applyFromArray($font_bold);
            $filterText = "TOKO = $store_name;USER = $user_realname;PPN = $product_tax";
            $sheet->getCell('B6')->setValue($filterText);
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


            $filename = 'laporan_penjualan_retail';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    public function detailSalesList()
    {
        $user_id        = $this->request->getGet('user_id') != null ? $this->request->getGet('user_id') : '';
        $user_realname  = $this->request->getGet('user_realname') != null ? $this->request->getGet('user_realname') : '-';
        $store_id       = $this->request->getGet('store_id') != null ? $this->request->getGet('store_id') : '';
        $store_name     = $this->request->getGet('store_name') != null ? $this->request->getGet('store_name') : '-';
        $start_date     = $this->request->getGet('start_date') != null ? $this->request->getGet('start_date') : date('Y-m-d');
        $end_date       = $this->request->getGet('end_date') != null ? $this->request->getGet('end_date') : date('Y-m-d');
        $product_tax    = $this->request->getGet('product_tax') != null ? $this->request->getGet('product_tax') : '';


        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $data = [
            'title'         => 'Laporan Penjualan',
            'userLogin'     => $this->userLogin,
            'user_id'       => $user_id,
            'user_realname' => $user_realname,
            'store_id'      => $store_id,
            'store_name'    => $store_name,
            'start_date'    => $start_date,
            'end_date'      => $end_date,
            'product_tax'   => $product_tax
        ];

        $M_sales_pos        = model('M_sales_pos');
        $getData            = $M_sales_pos->getReportDetailSalesList($start_date, $end_date, $store_id, $user_id, $product_tax);


        if ($fileType == 'pdf') {
            $max_report_size    = 14;
            $pages              = array_chunk($getData, $max_report_size);
            $data['pages']      = $pages;
            $data['max_page']   = count($pages);

            $htmlView = $this->renderView('report/pos/sales_list_detail', $data);
            if ($agent->isMobile() && !$isDownload) {
                return $htmlView;
            } else {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_detail_penjualan_retail.pdf', array("Attachment" => $isDownload));
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

            $template = WRITEPATH . '/template/report/template_report.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);

            //make header //
            $iRow = 7;
            $sheet->getCell('A' . $iRow)->setValue('CABANG');
            $sheet->getCell('B' . $iRow)->setValue('KASIR');
            $sheet->getCell('C' . $iRow)->setValue('TANGGAL');
            $sheet->getCell('D' . $iRow)->setValue('NO INVOICE');
            $sheet->getCell('E' . $iRow)->setValue('METODE PEMBAYARAN');
            $sheet->getCell('F' . $iRow)->setValue('KODE BARANG');
            $sheet->getCell('G' . $iRow)->setValue('NAMA BARANG');
            $sheet->getCell('H' . $iRow)->setValue('MEREK');
            $sheet->getCell('I' . $iRow)->setValue('KATEGORI');
            $sheet->getCell('J' . $iRow)->setValue('QTY');
            $sheet->getCell('K' . $iRow)->setValue('SATUAN');
            $sheet->getCell('L' . $iRow)->setValue('DPP');
            $sheet->getCell('M' . $iRow)->setValue('PPN');
            $sheet->getCell('N' . $iRow)->setValue('TOTAL');
            $sheet->getCell('O' . $iRow)->setValue('SALESMAN');

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
            $sheet->getStyle('N' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('O' . $iRow)->applyFromArray($header_format);
            $iRow++;

            $sum_dpp_total      = 0;
            $sum_ppn_total      = 0;
            $sum_sales_total    = 0;
            foreach ($getData as $row) {
                $qty        = floatval($row['sales_qty']);
                $dpp        = floatval($row['sales_dpp']);
                $ppn        = floatval($row['sales_ppn']);
                $total      = ($dpp + $ppn) *  $qty;
                $salesman   = '-';
                if (!empty($row['salesman_code'])) {
                    $salesman   = $row['salesman_code'] . ' - ' . $row['salesman_name'];
                }

                $sheet->getCell('A' . $iRow)->setValue($row['store_code']);
                $sheet->getCell('B' . $iRow)->setValue($row['user_realname']);
                $sheet->getCell('C' . $iRow)->setValue(indo_short_date($row['pos_sales_date']));
                $sheet->getCell('D' . $iRow)->setValue($row['pos_sales_invoice']);
                $sheet->getCell('E' . $iRow)->setValue($row['payment_list']);
                $sheet->getCell('F' . $iRow)->setValue($row['item_code']);
                $sheet->getCell('G' . $iRow)->setValue($row['product_name']);
                $sheet->getCell('H' . $iRow)->setValue($row['brand_name']);
                $sheet->getCell('I' . $iRow)->setValue($row['category_name']);
                $sheet->getCell('J' . $iRow)->setValue($qty);
                $sheet->getCell('K' . $iRow)->setValue($row['unit_name']);
                $sheet->getCell('L' . $iRow)->setValue($dpp);
                $sheet->getCell('M' . $iRow)->setValue($ppn);
                $sheet->getCell('N' . $iRow)->setValue($total);
                $sheet->getCell('O' . $iRow)->setValue($salesman);

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

                $sum_dpp_total      += ($dpp * $qty);
                $sum_ppn_total      += ($ppn * $qty);
                $sum_sales_total    += $total;
                $iRow++;
            }

            $sheet->getCell('A' . $iRow)->setValue('TOTAL');
            $sheet->getCell('L' . $iRow)->setValue($sum_dpp_total);
            $sheet->getCell('M' . $iRow)->setValue($sum_ppn_total);
            $sheet->getCell('N' . $iRow)->setValue($sum_sales_total);
            $sheet->mergeCells('A' . $iRow . ':K' . $iRow);
            $sheet->getStyle('A' . $iRow . ':K' . $iRow)->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A' . $iRow . ':K' . $iRow)->applyFromArray($total_format);
            $sheet->getStyle('L' . $iRow)->applyFromArray($total_format);
            $sheet->getStyle('M' . $iRow)->applyFromArray($total_format);
            $sheet->getStyle('N' . $iRow)->applyFromArray($total_format);
            $sheet->getStyle('O' . $iRow)->applyFromArray($total_format);

            //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('A5')->setValue('Periode');
            $sheet->getStyle('A5')->applyFromArray($font_bold);
            $sheet->getCell('B5')->setValue($periode_text);

            $sheet->getCell('A6')->setValue('Filter');
            $sheet->getStyle('A6')->applyFromArray($font_bold);
            $filterText = "TOKO = $store_name;USER = $user_realname;PPN = $product_tax";
            $sheet->getCell('B6')->setValue($filterText);
            $sheet->mergeCells('B6:O6');

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

            $sheet->mergeCells('A4:O4');
            $sheet->mergeCells('A3:O3');
            $sheet->mergeCells('A2:O2');
            $sheet->mergeCells('A1:O1');

            $sheet->getStyle('A4:O4')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3:O3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:O2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1:O1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A4:O4')->applyFromArray($font_bold);
            $sheet->getStyle('A3:O3')->applyFromArray($font_bold);
            $sheet->getStyle('A2:O2')->applyFromArray($font_bold);

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
            $sheet->getColumnDimension('N')->setAutoSize(true);
            $sheet->getColumnDimension('O')->setAutoSize(true);


            $filename = 'laporan_detail_penjualan_retail';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    public function viewSalesListGroupSalesman()
    {
        $data = [
            'title'     => 'Laporan Penjualan Per Salesman',
        ];
        return $this->renderView('report/pos/view_sales_list_group_salesman', $data, 'report.pos_sales_list');
    }

    public function salesListGroupSalesman()
    {
        $salesman_id    = $this->request->getGet('salesman_id') != null ? $this->request->getGet('salesman_id') : '';
        $salesman_name  = $this->request->getGet('salesman_name') != null ? $this->request->getGet('salesman_name') : '-';
        $store_id       = $this->request->getGet('store_id') != null ? $this->request->getGet('store_id') : '';
        $store_name     = $this->request->getGet('store_name') != null ? $this->request->getGet('store_name') : '-';
        $start_date     = $this->request->getGet('start_date') != null ? $this->request->getGet('start_date') : date('Y-m-d');
        $end_date       = $this->request->getGet('end_date') != null ? $this->request->getGet('end_date') : date('Y-m-d');
        $product_tax    = $this->request->getGet('product_tax') != null ? $this->request->getGet('product_tax') : '';


        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $data = [
            'title'         => 'Laporan Penjualan',
            'userLogin'     => $this->userLogin,
            'salesman_id'   => $salesman_id,
            'salesman_name' => $salesman_name,
            'store_id'      => $store_id,
            'store_name'    => $store_name,
            'start_date'    => $start_date,
            'end_date'      => $end_date,
            'product_tax'   => $product_tax
        ];

        $M_sales_pos        = model('M_sales_pos');
        $getData            = $M_sales_pos->getReportSalesListBySalesman($start_date, $end_date, $store_id, $salesman_id, $product_tax);
        //dd($getData);


        if ($fileType == 'pdf') {
            $tables_rows = [];
            $sample_tables_rows = [
                [
                    ['text' => 'header', 'colspan' => '9', 'class' => 'text-left']
                ],
                [
                    ['text' => '#', 'class' => 'text-right'],
                    ['text' => 'CABANG', 'class' => 'text-left'],
                    ['text' => 'KASIR',  'class' => 'text-left'],
                    ['text' => 'INVOICE', 'class' => 'text-left'],
                    ['text' => 'TGL',  'class' => 'text-left'],
                    ['text' => 'METODE PEMBAYARAN', 'class' => 'col-fixed text-left'],
                    ['text' => 'DPP', 'class' => 'text-right'],
                    ['text' => 'PPN',  'class' => 'text-right'],
                    ['text' => 'TOTAL', 'class' => 'text-right'],
                ],
                [
                    ['text' => 'total', 'colspan' => '6', 'class' => 'text-left'],
                    ['text' => 'DPP', 'class' => 'text-right'],
                    ['text' => 'PPN',  'class' => 'text-right'],
                    ['text' => 'TOTAL', 'class' => 'text-right'],
                ],
            ];

            $last_salesman_id = '';
            $num_row = 1;
            $total_dpp = 0;
            $total_ppn = 0;
            $total_sales = 0;

            foreach ($getData as $row) {
                $sales_dpp = floatval($row['sales_dpp']);
                $sales_ppn = floatval($row['sales_ppn']);
                $total     = $sales_dpp + $sales_ppn;

                $class_dpp = $sales_dpp < 0 ? 'text-red' : '';
                $class_ppn = $sales_ppn < 0 ? 'text-red' : '';
                $class_total = $total < 0 ? 'text-red' : '';

                if ($row['salesman_id'] != $last_salesman_id) {
                    if ($last_salesman_id != '') {
                        // buat summary total //
                        $tables_rows[] = [
                            ['text' => '<b>TOTAL</b>', 'colspan' => '6', 'class' => 'text-right'],
                            ['text' => numberFormat($total_dpp), 'class' => 'text-right'],
                            ['text' => numberFormat($total_ppn),  'class' => 'text-right'],
                            ['text' => numberFormat($total_sales), 'class' => 'text-right'],
                        ];
                    }

                    // buat header group //
                    $header = !empty($row['salesman_code']) ? $row['salesman_code'] . ' - ' . $row['salesman_name'] : 'NO SALESMAN';
                    $tables_rows[] = [
                        ['text' => '<b>' . $header . '</b>', 'colspan' => '9', 'class' => 'text-left']
                    ];

                    // reset total //
                    $num_row = 1;
                    $total_dpp = 0;
                    $total_ppn = 0;
                    $total_sales = 0;
                }

                $tables_rows[] = [
                    ['text' => $num_row, 'class' => 'text-right'],
                    ['text' => $row['store_code'], 'class' => 'text-left'],
                    ['text' => $row['user_realname'],  'class' => 'text-left'],
                    ['text' => $row['pos_sales_invoice'], 'class' => 'text-left'],
                    ['text' => indo_short_date($row['pos_sales_date']),  'class' => 'text-left'],
                    ['text' => $row['payment_list'], 'class' => 'col-fixed text-left'],
                    ['text' => numberFormat($sales_dpp), 'class' => 'text-right ' . $class_dpp],
                    ['text' => numberFormat($sales_ppn),  'class' => 'text-right ' . $class_ppn],
                    ['text' => numberFormat($total), 'class' => 'text-right ' . $class_total],
                ];

                $total_dpp      += $sales_dpp;
                $total_ppn      += $sales_ppn;
                $total_sales    += $total;
                $last_salesman_id = $row['salesman_id'];
                $num_row++;
            }

            if ($last_salesman_id != '') {
                // buat summary total //
                $tables_rows[] = [
                    ['text' => '<b>TOTAL</b>', 'colspan' => '6', 'class' => 'text-right'],
                    ['text' => numberFormat($total_dpp), 'class' => 'text-right'],
                    ['text' => numberFormat($total_ppn),  'class' => 'text-right'],
                    ['text' => numberFormat($total_sales), 'class' => 'text-right'],
                ];
            }

            $max_report_size    = 14;
            $pages              = array_chunk($tables_rows, $max_report_size);
            $data['pages']      = $pages;
            $data['max_page']   = count($pages);

            $htmlView = $this->renderView('report/pos/sales_list_group_salesman', $data);
            if ($agent->isMobile() && !$isDownload) {
                return $htmlView;
            } else {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_retail_per_salesman.pdf', array("Attachment" => $isDownload));
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

            $border_full = [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'top' => [
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
            $sheet->getCell('A' . $iRow)->setValue('CABANG');
            $sheet->getCell('B' . $iRow)->setValue('KASIR');
            $sheet->getCell('C' . $iRow)->setValue('NO INVOICE');
            $sheet->getCell('D' . $iRow)->setValue('TANGGAL TRANSAKSI');
            $sheet->getCell('E' . $iRow)->setValue('METODE PEMBAYARAN');
            $sheet->getCell('F' . $iRow)->setValue('DPP');
            $sheet->getCell('G' . $iRow)->setValue('PPN');
            $sheet->getCell('H' . $iRow)->setValue('TOTAL');
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


            $last_salesman_id = '';
            $total_dpp = 0;
            $total_ppn = 0;
            $total_sales = 0;

            foreach ($getData as $row) {
                $sales_dpp = floatval($row['sales_dpp']);
                $sales_ppn = floatval($row['sales_ppn']);
                $total     = $sales_dpp + $sales_ppn;

                $class_dpp = $sales_dpp < 0 ? 'text-red' : '';
                $class_ppn = $sales_ppn < 0 ? 'text-red' : '';
                $class_total = $total < 0 ? 'text-red' : '';

                if ($row['salesman_id'] != $last_salesman_id) {
                    if ($last_salesman_id != '') {
                        // buat summary total //
                        $sheet->getCell('A' . $iRow)->setValue('TOTAL');
                        $sheet->getCell('F' . $iRow)->setValue($total_dpp);
                        $sheet->getCell('G' . $iRow)->setValue($total_ppn);
                        $sheet->getCell('H' . $iRow)->setValue($total_sales);
                        $sheet->mergeCells('A' . $iRow . ':E' . $iRow);
                        $sheet->getStyle('A' . $iRow . ':E' . $iRow)->getAlignment()->setHorizontal('right');

                        $sheet->getStyle('A' . $iRow . ':E' . $iRow)->applyFromArray($total_format);
                        $sheet->getStyle('F' . $iRow)->applyFromArray($total_format);
                        $sheet->getStyle('G' . $iRow)->applyFromArray($total_format);
                        $sheet->getStyle('H' . $iRow)->applyFromArray($total_format);
                        $sheet->getStyle('I' . $iRow)->applyFromArray($total_format);
                        $iRow++;
                    }

                    // buat header group //
                    $header = !empty($row['salesman_code']) ? $row['salesman_code'] . ' - ' . $row['salesman_name'] : 'NO SALESMAN';
                    $sheet->getCell('A' . $iRow)->setValue($header);
                    $sheet->mergeCells('A' . $iRow . ':I' . $iRow);
                    $sheet->getStyle('A' . $iRow . ':I' . $iRow)->applyFromArray($font_bold);
                    $sheet->getStyle('A' . $iRow . ':I' . $iRow)->applyFromArray($border_full);
                    $iRow++;


                    // reset total //
                    $total_dpp = 0;
                    $total_ppn = 0;
                    $total_sales = 0;
                }


                $sheet->getCell('A' . $iRow)->setValue($row['store_code']);
                $sheet->getCell('B' . $iRow)->setValue($row['user_realname']);
                $sheet->getCell('C' . $iRow)->setValue($row['pos_sales_invoice']);
                $sheet->getCell('D' . $iRow)->setValue(indo_short_date($row['pos_sales_date']));
                $sheet->getCell('E' . $iRow)->setValue($row['payment_list']);
                $sheet->getCell('F' . $iRow)->setValue($sales_dpp);
                $sheet->getCell('G' . $iRow)->setValue($sales_ppn);
                $sheet->getCell('H' . $iRow)->setValue($total);
                $sheet->getCell('I' . $iRow)->setValue($row['payment_remark']);

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

                $total_dpp      += $sales_dpp;
                $total_ppn      += $sales_ppn;
                $total_sales    += $total;
                $last_salesman_id = $row['salesman_id'];
            }

            if ($last_salesman_id != '') {
                // buat summary total //
                $sheet->getCell('A' . $iRow)->setValue('TOTAL');
                $sheet->getCell('F' . $iRow)->setValue($total_dpp);
                $sheet->getCell('G' . $iRow)->setValue($total_ppn);
                $sheet->getCell('H' . $iRow)->setValue($total_sales);
                $sheet->mergeCells('A' . $iRow . ':E' . $iRow);
                $sheet->getStyle('A' . $iRow . ':E' . $iRow)->getAlignment()->setHorizontal('right');

                $sheet->getStyle('A' . $iRow . ':E' . $iRow)->applyFromArray($total_format);
                $sheet->getStyle('F' . $iRow)->applyFromArray($total_format);
                $sheet->getStyle('G' . $iRow)->applyFromArray($total_format);
                $sheet->getStyle('H' . $iRow)->applyFromArray($total_format);
                $sheet->getStyle('I' . $iRow)->applyFromArray($total_format);
                $iRow++;
            }


            //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('A5')->setValue('Periode');
            $sheet->getStyle('A5')->applyFromArray($font_bold);
            $sheet->getCell('B5')->setValue($periode_text);

            $sheet->getCell('A6')->setValue('Filter');
            $sheet->getStyle('A6')->applyFromArray($font_bold);
            $filterText = "TOKO = $store_name;Salesman = $salesman_name;PPN = $product_tax";
            $sheet->getCell('B6')->setValue($filterText);
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


            $filename = 'laporan_penjualan_retail_per_salesman';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    public function detailSalesListGroupSalesman()
    {
        $salesman_id    = $this->request->getGet('salesman_id') != null ? $this->request->getGet('salesman_id') : '';
        $salesman_name  = $this->request->getGet('salesman_name') != null ? $this->request->getGet('salesman_name') : '-';
        $store_id       = $this->request->getGet('store_id') != null ? $this->request->getGet('store_id') : '';
        $store_name     = $this->request->getGet('store_name') != null ? $this->request->getGet('store_name') : '-';
        $start_date     = $this->request->getGet('start_date') != null ? $this->request->getGet('start_date') : date('Y-m-d');
        $end_date       = $this->request->getGet('end_date') != null ? $this->request->getGet('end_date') : date('Y-m-d');
        $product_tax    = $this->request->getGet('product_tax') != null ? $this->request->getGet('product_tax') : '';


        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $data = [
            'title'         => 'Laporan Penjualan',
            'userLogin'     => $this->userLogin,
            'salesman_id'   => $salesman_id,
            'salesman_name' => $salesman_name,
            'store_id'      => $store_id,
            'store_name'    => $store_name,
            'start_date'    => $start_date,
            'end_date'      => $end_date,
            'product_tax'   => $product_tax
        ];

        $M_sales_pos        = model('M_sales_pos');
        $getData            = $M_sales_pos->getReportDetailSalesListBySalesman($start_date, $end_date, $store_id, $salesman_id, $product_tax);
        //dd($getData);


        if ($fileType == 'pdf') {
            $tables_rows = [];
            $sample_tables_rows = [
                [
                    ['text' => 'header', 'colspan' => '9', 'class' => 'text-left']
                ],
                [
                    ['text' => '#', 'class' => 'text-right'],
                    ['text' => 'INVOICE', 'class' => 'text-left'],
                    ['text' => 'TGL',  'class' => 'text-left'],
                    ['text' => 'Kode Barang',  'class' => 'text-left'],
                    ['text' => 'Nama Barang',  'class' => 'text-left'],
                    ['text' => 'QTY', 'class' => 'col-fixed text-left'],
                    ['text' => 'DPP', 'class' => 'text-right'],
                    ['text' => 'PPN',  'class' => 'text-right'],
                    ['text' => 'TOTAL', 'class' => 'text-right'],
                ],
                [
                    ['text' => 'total', 'colspan' => '6', 'class' => 'text-left'],
                    ['text' => 'DPP', 'class' => 'text-right'],
                    ['text' => 'PPN',  'class' => 'text-right'],
                    ['text' => 'TOTAL', 'class' => 'text-right'],
                ],
            ];

            $last_salesman_id = '';
            $num_row = 1;
            $total_dpp = 0;
            $total_ppn = 0;
            $total_sales = 0;
            foreach ($getData as $row) {
                $sales_qty = floatval($row['sales_qty']);
                $sales_dpp = floatval($row['sales_dpp']);
                $sales_ppn = floatval($row['sales_ppn']);
                $total     = ($sales_dpp + $sales_ppn) * $sales_qty;

                $class_dpp      = $sales_dpp < 0 ? 'text-red' : '';
                $class_ppn      = $sales_ppn < 0 ? 'text-red' : '';
                $class_total    = $total < 0 ? 'text-red' : '';
                $class_qty      = $sales_qty < 0 ? 'text-red' : '';

                if ($row['salesman_id'] != $last_salesman_id) {
                    if ($last_salesman_id != '') {
                        // buat summary total //
                        $tables_rows[] = [
                            ['text' => '<b>TOTAL</b>', 'colspan' => '6', 'class' => 'text-right'],
                            ['text' => numberFormat($total_dpp), 'class' => 'text-right'],
                            ['text' => numberFormat($total_ppn),  'class' => 'text-right'],
                            ['text' => numberFormat($total_sales), 'class' => 'text-right'],
                        ];
                    }

                    // buat header group //
                    $header = !empty($row['salesman_code']) ? $row['salesman_code'] . ' - ' . $row['salesman_name'] : 'NO SALESMAN';
                    $tables_rows[] = [
                        ['text' => '<b>' . $header . '</b>', 'colspan' => '9', 'class' => 'text-left']
                    ];

                    // reset total //
                    $num_row = 1;
                    $total_dpp = 0;
                    $total_ppn = 0;
                    $total_sales = 0;
                }

                $tables_rows[] = [
                    ['text' => $num_row, 'class' => 'text-right'],
                    ['text' => $row['pos_sales_invoice'], 'class' => 'text-left'],
                    ['text' => indo_short_date($row['pos_sales_date']),  'class' => 'text-left'],
                    ['text' => $row['item_code'], 'class' => 'col-fixed text-left'],
                    ['text' => $row['product_name'], 'class' => 'col-fixed text-left'],
                    ['text' => numberFormat($sales_qty), 'class' => 'text-right ' . $class_qty],
                    ['text' => numberFormat($sales_dpp), 'class' => 'text-right ' . $class_dpp],
                    ['text' => numberFormat($sales_ppn),  'class' => 'text-right ' . $class_ppn],
                    ['text' => numberFormat($total), 'class' => 'text-right ' . $class_total],
                ];

                $total_dpp      += ($sales_dpp * $sales_qty);
                $total_ppn      += ($sales_ppn * $sales_qty);
                $total_sales    += $total;
                $last_salesman_id = $row['salesman_id'];
                $num_row++;
            }

            if ($last_salesman_id != '') {
                // buat summary total //
                $tables_rows[] = [
                    ['text' => '<b>TOTAL</b>', 'colspan' => '6', 'class' => 'text-right'],
                    ['text' => numberFormat($total_dpp), 'class' => 'text-right'],
                    ['text' => numberFormat($total_ppn),  'class' => 'text-right'],
                    ['text' => numberFormat($total_sales), 'class' => 'text-right'],
                ];
            }

            $max_report_size    = 14;
            $pages              = array_chunk($tables_rows, $max_report_size);
            $data['pages']      = $pages;
            $data['max_page']   = count($pages);

            $htmlView = $this->renderView('report/pos/sales_list_group_salesman_detail', $data);
            if ($agent->isMobile() && !$isDownload) {
                return $htmlView;
            } else {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_retail_per_salesman.pdf', array("Attachment" => $isDownload));
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

            $border_full = [
                'borders' => [
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'top' => [
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
            $sheet->getCell('A' . $iRow)->setValue('CABANG');
            $sheet->getCell('B' . $iRow)->setValue('KASIR');
            $sheet->getCell('C' . $iRow)->setValue('TANGGAL');
            $sheet->getCell('D' . $iRow)->setValue('NO INVOICE');
            $sheet->getCell('E' . $iRow)->setValue('METODE PEMBAYARAN');
            $sheet->getCell('F' . $iRow)->setValue('KODE BARANG');
            $sheet->getCell('G' . $iRow)->setValue('NAMA BARANG');
            $sheet->getCell('H' . $iRow)->setValue('MEREK');
            $sheet->getCell('I' . $iRow)->setValue('KATEGORI');
            $sheet->getCell('J' . $iRow)->setValue('QTY');
            $sheet->getCell('K' . $iRow)->setValue('SATUAN');
            $sheet->getCell('L' . $iRow)->setValue('DPP');
            $sheet->getCell('M' . $iRow)->setValue('PPN');
            $sheet->getCell('N' . $iRow)->setValue('TOTAL');

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
            $sheet->getStyle('N' . $iRow)->applyFromArray($header_format);

            $iRow++;


            $last_salesman_id = '';
            $total_dpp = 0;
            $total_ppn = 0;
            $total_sales = 0;

            foreach ($getData as $row) {
                $sales_qty = floatval($row['sales_qty']);
                $sales_dpp = floatval($row['sales_dpp']);
                $sales_ppn = floatval($row['sales_ppn']);
                $total     = ($sales_dpp + $sales_ppn) * $sales_qty;

                $class_dpp = $sales_dpp < 0 ? 'text-red' : '';
                $class_ppn = $sales_ppn < 0 ? 'text-red' : '';
                $class_total = $total < 0 ? 'text-red' : '';

                if ($row['salesman_id'] != $last_salesman_id) {
                    if ($last_salesman_id != '') {
                        // buat summary total //
                        $sheet->getCell('A' . $iRow)->setValue('TOTAL');
                        $sheet->getCell('L' . $iRow)->setValue($total_dpp);
                        $sheet->getCell('M' . $iRow)->setValue($total_ppn);
                        $sheet->getCell('N' . $iRow)->setValue($total_sales);
                        $sheet->mergeCells('A' . $iRow . ':K' . $iRow);
                        $sheet->getStyle('A' . $iRow . ':K' . $iRow)->getAlignment()->setHorizontal('right');

                        $sheet->getStyle('A' . $iRow . ':K' . $iRow)->applyFromArray($total_format);
                        $sheet->getStyle('L' . $iRow)->applyFromArray($total_format);
                        $sheet->getStyle('M' . $iRow)->applyFromArray($total_format);
                        $sheet->getStyle('N' . $iRow)->applyFromArray($total_format);
                        $iRow++;
                    }

                    // buat header group //
                    $header = !empty($row['salesman_code']) ? $row['salesman_code'] . ' - ' . $row['salesman_name'] : 'NO SALESMAN';
                    $sheet->getCell('A' . $iRow)->setValue($header);
                    $sheet->mergeCells('A' . $iRow . ':N' . $iRow);
                    $sheet->getStyle('A' . $iRow . ':N' . $iRow)->applyFromArray($font_bold);
                    $sheet->getStyle('A' . $iRow . ':N' . $iRow)->applyFromArray($border_full);
                    $iRow++;


                    // reset total //
                    $total_dpp = 0;
                    $total_ppn = 0;
                    $total_sales = 0;
                }


                $sheet->getCell('A' . $iRow)->setValue($row['store_code']);
                $sheet->getCell('B' . $iRow)->setValue($row['user_realname']);
                $sheet->getCell('C' . $iRow)->setValue(indo_short_date($row['pos_sales_date']));
                $sheet->getCell('D' . $iRow)->setValue($row['pos_sales_invoice']);
                $sheet->getCell('E' . $iRow)->setValue($row['payment_list']);
                $sheet->getCell('F' . $iRow)->setValue($row['item_code']);
                $sheet->getCell('G' . $iRow)->setValue($row['product_name']);
                $sheet->getCell('H' . $iRow)->setValue($row['brand_name']);
                $sheet->getCell('I' . $iRow)->setValue($row['category_name']);
                $sheet->getCell('J' . $iRow)->setValue($sales_qty);
                $sheet->getCell('K' . $iRow)->setValue($row['unit_name']);
                $sheet->getCell('L' . $iRow)->setValue($sales_dpp);
                $sheet->getCell('M' . $iRow)->setValue($sales_ppn);
                $sheet->getCell('N' . $iRow)->setValue($total);

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
                $iRow++;

                $total_dpp      += ($sales_dpp * $sales_qty);
                $total_ppn      += ($sales_ppn * $sales_qty);
                $total_sales    += $total;
                $last_salesman_id = $row['salesman_id'];
            }

            if ($last_salesman_id != '') {
                // buat summary total //
                $sheet->getCell('A' . $iRow)->setValue('TOTAL');
                $sheet->getCell('L' . $iRow)->setValue($total_dpp);
                $sheet->getCell('M' . $iRow)->setValue($total_ppn);
                $sheet->getCell('N' . $iRow)->setValue($total_sales);
                $sheet->mergeCells('A' . $iRow . ':K' . $iRow);
                $sheet->getStyle('A' . $iRow . ':K' . $iRow)->getAlignment()->setHorizontal('right');

                $sheet->getStyle('A' . $iRow . ':K' . $iRow)->applyFromArray($total_format);
                $sheet->getStyle('L' . $iRow)->applyFromArray($total_format);
                $sheet->getStyle('M' . $iRow)->applyFromArray($total_format);
                $sheet->getStyle('N' . $iRow)->applyFromArray($total_format);
                $iRow++;
            }


            //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('A5')->setValue('Periode');
            $sheet->getStyle('A5')->applyFromArray($font_bold);
            $sheet->getCell('B5')->setValue($periode_text);

            $sheet->getCell('A6')->setValue('Filter');
            $sheet->getStyle('A6')->applyFromArray($font_bold);
            $filterText = "TOKO = $store_name;Salesman = $salesman_name;PPN = $product_tax";
            $sheet->getCell('B6')->setValue($filterText);
            $sheet->mergeCells('B6:N6');

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

            $sheet->mergeCells('A4:N4');
            $sheet->mergeCells('A3:N3');
            $sheet->mergeCells('A2:N2');
            $sheet->mergeCells('A1:N1');

            $sheet->getStyle('A4:N4')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3:N3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:N2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A4:N4')->applyFromArray($font_bold);
            $sheet->getStyle('A3:N3')->applyFromArray($font_bold);
            $sheet->getStyle('A2:N2')->applyFromArray($font_bold);

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
            $sheet->getColumnDimension('N')->setAutoSize(true);


            $filename = 'laporan_penjualan_retail_per_salesman';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }



    public function viewSalesListGroupPayment()
    {
        $data = [
            'title'     => 'Laporan Penjualan Per Jenis Pembayaran',
        ];
        return $this->renderView('report/sales/view_sales_list_group_payment', $data);
    }

    public function salesListGroupPayment()
    {
        $data = [
            'title'         => 'Laporan Penjualan Per Jenis Pembayaran',
            'userLogin'     => $this->userLogin
        ];

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xlsx'])) {
            $fileType = 'pdf';
        }

        $htmlView = $this->renderView('report/sales/sales_list_group_payment', $data);

        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_ddmmyyyyy_hhiiss.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }


    public function viewProjectSalesList()
    {
        $data = [
            'title'     => 'Laporan Penjualan Proyek',
        ];
        return $this->renderView('report/sales/view_project_sales_list', $data);
    }

    public function projectSalesList()
    {
        $data = [
            'title'         => 'Laporan Penjualan Proyek',
            'userLogin'     => $this->userLogin
        ];

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $detail     = $this->request->getGet('detail') == NULL ? 'N' : $this->request->getGet('detail');

        if (!in_array($fileType, ['pdf', 'xlsx'])) {
            $fileType = 'pdf';
        }

        //$detail = 'Y';
        if ($detail == 'Y') {
            $htmlView = $this->renderView('report/sales/project_sales_list_detail', $data);
        } else {
            $htmlView = $this->renderView('report/sales/project_sales_list', $data);
        }

        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_ddmmyyyyy_hhiiss.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }


    public function viewProjectSalesListGroupCustomer()
    {
        $data = [
            'title'     => 'Laporan Penjualan Proyek Per Customer',
        ];
        return $this->renderView('report/sales/view_project_sales_list_group_customer', $data);
    }

    public function projectSalesListGroupCustomer()
    {
        $data = [
            'title'         => 'Laporan Penjualan Proyek Per Customer',
            'userLogin'     => $this->userLogin
        ];

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $detail     = $this->request->getGet('detail') == NULL ? 'N' : $this->request->getGet('detail');

        if (!in_array($fileType, ['pdf', 'xlsx'])) {
            $fileType = 'pdf';
        }
        //$detail = 'Y';
        if ($detail == 'Y') {
            $htmlView = $this->renderView('report/sales/project_sales_list_group_customer_detail', $data);
        } else {
            $htmlView = $this->renderView('report/sales/project_sales_list_group_customer', $data);
        }

        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_ddmmyyyyy_hhiiss.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }

    public function viewProjectSalesListGroupSalesman()
    {
        $data = [
            'title'     => 'Laporan Penjualan Proyek Per Salesman',
        ];
        return $this->renderView('report/sales/view_project_sales_list_group_salesman', $data);
    }

    public function projectSalesListGroupSalesman()
    {
        $data = [
            'title'         => 'Laporan Penjualan Proyek Per Salesman',
            'userLogin'     => $this->userLogin
        ];

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $detail     = $this->request->getGet('detail') == NULL ? 'N' : $this->request->getGet('detail');

        if (!in_array($fileType, ['pdf', 'xlsx'])) {
            $fileType = 'pdf';
        }
        //$detail = 'Y';
        if ($detail == 'Y') {
            $htmlView = $this->renderView('report/sales/project_sales_list_group_salesman_detail', $data);
        } else {
            $htmlView = $this->renderView('report/sales/project_sales_list_group_salesman', $data);
        }

        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('laporan_penjualan_ddmmyyyyy_hhiiss.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }





    //--------------------------------------------------------------------

}
