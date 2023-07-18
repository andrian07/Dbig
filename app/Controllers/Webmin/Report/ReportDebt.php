<?php

namespace App\Controllers\Webmin\Report;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;

class ReportDebt extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        die('ReportDebt');
    }

    /*public function viewDebtBalanceList()
    {
        $data = [
            'title'         => 'Laporan PO',
        ];

        return $this->renderView('report/debt/view_debt_balance_list', $data, 'report.debt_list');
    }*/

    public function viewDebtCardList()
    {
        $data = [
            'title'         => 'Laporan Kartu Hutang',
        ];

        return $this->renderView('report/debt/view_cart_balance_list', $data, 'report.debt_list');
    }

    public function cartDebtList()
    {
        if ($this->role->hasRole('report.debt_list')) {

            $M_debt_repayment = model('M_debt_repayment');

            $start_date      = $this->request->getGet('start_date') != NULL ? $this->request->getGet('start_date') : date('Y-m') . '-01';
            $end_date        = $this->request->getGet('end_date') != NULL ? $this->request->getGet('end_date') : date('Y-m-d');
            $supplier_id     = $this->request->getGet('supplier_id');
            $isDownload      = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType        = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent           = $this->request->getUserAgent();


            if (!in_array($fileType, ['pdf', 'xls'])) {
                $fileType = 'pdf';
            }

            $getReportData = $M_debt_repayment->getReportData($start_date, $end_date, $supplier_id)->getResultArray();


            if($getReportData != null){
                if($supplier_id != null){
                    $supplier_name = $getReportData[0]['supplier_name'];
                }else{
                    $supplier_name = '-';
                }
            }else{
                $supplier_name = '-';
            }


            if ($fileType == 'pdf') {
                $cRow           = count($getReportData);
                if ($cRow % 16 == 0) {
                    $max_page_item  = 15;
                } else {
                    $max_page_item  = 16;
                }
                $debtData    = array_chunk($getReportData, $max_page_item);
                $data = [
                    'title'                 => 'Laporan Kartu Hutang',
                    'start_date'            => $start_date,
                    'end_date'              => $end_date,
                    'supplier_name'         => $supplier_name,
                    'pages'                 => $debtData,
                    'maxPage'               => count($debtData),
                    'userLogin'             => $this->userLogin
                ];


                $htmlView   = view('webmin/report/debt/cart_debt_list', $data);

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

                $template = WRITEPATH . '/template/template_export_debt_cart.xlsx';
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

                $sheet = $spreadsheet->setActiveSheetIndex(0);
                $iRow = 8;

                foreach ($getReportData as $row) {
                    $debet  = floatval($row['debit']);
                    $credit = floatval($row['credit']);
                    $date_inv = indo_short_date($row['date_inv'], FALSE);

                    $sheet->getCell('A' . $iRow)->setValue($date_inv);
                    $sheet->getCell('B' . $iRow)->setValue($row['invoice']);
                    $sheet->getCell('C' . $iRow)->setValue($row['supplier_name']);
                    $sheet->getCell('D' . $iRow)->setValue($row['supplier_code']);
                    $sheet->getCell('E' . $iRow)->setValue($row['ket']);
                    $sheet->getCell('F' . $iRow)->setValue(numberFormat($debet, TRUE));
                    $sheet->getCell('G' . $iRow)->setValue(numberFormat($credit, TRUE));

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

                $sheet->mergeCells('A1:E1');

                $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal('right');

                $sheet->getStyle('A2:E2')->applyFromArray($font_bold);


                $filename = 'Kartu Hutang';
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

    public function viewDebtPendingList()
    {
        $data = [
            'title'         => 'Laporan Hutang Belum Lunas',
        ];

        return $this->renderView('report/debt/view_debt_pending_list', $data, 'report.debt_list');
    }

    public function debtPendingList()
    {
        if ($this->role->hasRole('report.debt_list')) {

            $M_purchase = model('M_purchase');

            $start_date      = $this->request->getGet('start_date') != NULL ? $this->request->getGet('start_date') : date('Y-m') . '-01';
            $end_date        = $this->request->getGet('end_date') != NULL ? $this->request->getGet('end_date') : date('Y-m-d');
            $supplier_id     = $this->request->getGet('supplier_id');
            $isDownload      = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType        = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent           = $this->request->getUserAgent();


            if (!in_array($fileType, ['pdf', 'xls'])) {
                $fileType = 'pdf';
            }

            $getReportData = $M_purchase->getDebtPending($start_date, $end_date, $supplier_id)->getResultArray();
            
            if($getReportData != null){
                if($supplier_id != null){
                    $supplier_name = $getReportData[0]['supplier_name'];
                }else{
                    $supplier_name = '-';
                }
            }else{
                $supplier_name = '-';
            }

            if ($fileType == 'pdf') {
                $cRow           = count($getReportData);
                if ($cRow % 16 == 0) {
                    $max_page_item  = 15;
                } else {
                    $max_page_item  = 16;
                }
                $remainingDebtData    = array_chunk($getReportData, $max_page_item);
                $data = [
                    'title'                 => 'Laporan Sisa Faktur Belum Lunas',
                    'start_date'            => $start_date,
                    'end_date'              => $end_date,
                    'supplier_name'         => $supplier_name,
                    'pages'                 => $remainingDebtData,
                    'maxPage'               => count($remainingDebtData),
                    'userLogin'             => $this->userLogin
                ];


                $htmlView   = view('webmin/report/debt/pending_debt_list', $data);

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

                $template = WRITEPATH . '/template/template_export_pending_debt.xlsx';
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

                $sheet = $spreadsheet->setActiveSheetIndex(0);
                $iRow = 8;

                foreach ($getReportData as $row) {
                    $purchase_total  = floatval($row['purchase_total']);
                    $purchase_down_payment = floatval($row['purchase_down_payment']);
                    $purchase_remaining_debt = floatval($row['purchase_remaining_debt']);
                    $total_bayar_cal = $purchase_remaining_debt - $purchase_remaining_debt;
                    $purchase_date = indo_short_date($row['purchase_date'], FALSE);
                    $purchase_due_date = indo_short_date($row['purchase_date'], FALSE);


                    $sheet->getCell('A' . $iRow)->setValue($purchase_date); 
                    $sheet->getCell('B' . $iRow)->setValue($row['purchase_invoice']);
                    $sheet->getCell('C' . $iRow)->setValue($row['supplier_code']);
                    $sheet->getCell('D' . $iRow)->setValue($row['supplier_name']);
                    $sheet->getCell('E' . $iRow)->setValue($purchase_due_date);
                    $sheet->getCell('F' . $iRow)->setValue(numberFormat($purchase_total, TRUE));
                    $sheet->getCell('G' . $iRow)->setValue(numberFormat($purchase_down_payment, TRUE));
                    $sheet->getCell('H' . $iRow)->setValue(numberFormat($total_bayar_cal, TRUE));
                    $sheet->getCell('I' . $iRow)->setValue(numberFormat($purchase_remaining_debt, TRUE));

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


                $filename = 'Sisa Faktur Belum Lunas';
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

    public function viewDebtDuedateList()
    {
        $data = [
            'title'         => 'Laporan Hutang Jatuh Tempo',
        ];

        return $this->renderView('report/debt/view_debt_duedate_list', $data, 'report.debt_list');
    }

    public function debtDuedateList()
    {
        if ($this->role->hasRole('report.debt_list')) {

            $M_purchase = model('M_purchase');

            $start_date      = $this->request->getGet('start_date') != NULL ? $this->request->getGet('start_date') : date('Y-m') . '-01';
            $end_date        = $this->request->getGet('end_date') != NULL ? $this->request->getGet('end_date') : date('Y-m-d');
            $supplier_id     = $this->request->getGet('supplier_id');
            $show_detail     = $this->request->getGet('show_detail');
            $isDownload      = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType        = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent           = $this->request->getUserAgent();
            
            $data = [
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'supplier_id'           => $supplier_id,
                'isDownload'            => $isDownload,
                'fileType'              => $fileType,
                'agent'                 => $agent
            ];

            if($show_detail == 'on'){
                $this->debtDuedateListDetail($data);
            }else{
                $this->debtDuedateListHeader($data);
            }
        } else {
            echo "<h1>Anda tidak memiliki akses ke laman ini</h1>";
        }
    }


    public function debtDuedateListHeader($data)
    {
        $M_purchase  = model('M_purchase');
        $start_date  = $data['start_date'];
        $end_date    = $data['end_date'];
        $supplier_id = $data['supplier_id'];
        $isDownload  = $data['isDownload'];
        $fileType    = $data['fileType'];
        $agent       = $data['agent'];
        
        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_purchase->getDebtDueDate($start_date, $end_date, $supplier_id)->getResultArray();

        if($getReportData != null){
            if($supplier_id != null){
                $supplier_name = $getReportData[0]['supplier_name'];
            }else{
                $supplier_name = '-';
            }
        }else{
            $supplier_name = '-';
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }
            $remainingDebtData    = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Laporan Hutang Jatuh Tempo',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'supplier_name'         => $supplier_name,
                'pages'                 => $remainingDebtData,
                'maxPage'               => count($remainingDebtData),
                'userLogin'             => $this->userLogin
            ];


            $htmlView   = view('webmin/report/debt/debt_duedate_list', $data);

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

            $template = WRITEPATH . '/template/template_export_pending_debt.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;

            foreach ($getReportData as $row) {
                $purchase_total  = floatval($row['purchase_total']);
                $purchase_down_payment = floatval($row['purchase_down_payment']);
                $purchase_remaining_debt = floatval($row['purchase_remaining_debt']);
                $total_bayar_cal = $purchase_remaining_debt - $purchase_remaining_debt;
                $purchase_date = indo_short_date($row['purchase_date'], FALSE);
                $purchase_due_date = indo_short_date($row['purchase_date'], FALSE);

                $sheet->getCell('A' . $iRow)->setValue($purchase_date);
                $sheet->getCell('B' . $iRow)->setValue($row['purchase_invoice']);
                $sheet->getCell('C' . $iRow)->setValue($row['supplier_code']);
                $sheet->getCell('D' . $iRow)->setValue($row['supplier_name']);
                $sheet->getCell('E' . $iRow)->setValue($purchase_due_date);
                $sheet->getCell('F' . $iRow)->setValue(numberFormat($purchase_total, TRUE));
                $sheet->getCell('G' . $iRow)->setValue(numberFormat($purchase_down_payment, TRUE));
                $sheet->getCell('H' . $iRow)->setValue(numberFormat($total_bayar_cal, TRUE));
                $sheet->getCell('I' . $iRow)->setValue(numberFormat($purchase_remaining_debt, TRUE));

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


            $filename = 'Laporan Hutang Jatuh Tempo';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    public function debtDuedateListDetail($data)
    {
        $M_purchase  = model('M_purchase');
        $start_date  = $data['start_date'];
        $end_date    = $data['end_date'];
        $supplier_id = $data['supplier_id'];
        $isDownload  = $data['isDownload'];
        $fileType    = $data['fileType'];
        $agent       = $data['agent'];

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_purchase->getDebtDueDateDetail($start_date, $end_date, $supplier_id)->getResultArray();

        if($getReportData != null){
            if($supplier_id != null){
                $supplier_name = $getReportData[0]['supplier_name'];
            }else{
                $supplier_name = '-';
            }
        }else{
            $supplier_name = '-';
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }
            $remainingDebtData    = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Laporan Hutang Jatuh Tempo',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'supplier_name'         => $supplier_name,
                'pages'                 => $remainingDebtData,
                'maxPage'               => count($remainingDebtData),
                'userLogin'             => $this->userLogin
            ];


            $htmlView   = view('webmin/report/debt/debt_duedate_list', $data);

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

            $template = WRITEPATH . '/template/template_export_pending_debt_detial.xlsx';
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

            $sheet->mergeCells('A1:G1');

            $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A2:G2')->applyFromArray($font_bold);


            $filename = 'Laporan Hutang Jatuh Tempo Detial';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    public function viewDebtList()
    {
        $data = [
            'title'         => 'Laporan Pembayaran Hutang',
        ];

        return $this->renderView('report/debt/view_debt_list', $data, 'report.debt_list');
    }

    public function debtList()
    {

        if ($this->role->hasRole('report.debt_list')) {

            $M_debt_repayment = model('M_debt_repayment');

            $start_date       = $this->request->getGet('start_date') != NULL ? $this->request->getGet('start_date') : date('Y-m') . '-01';
            $end_date         = $this->request->getGet('end_date') != NULL ? $this->request->getGet('end_date') : date('Y-m-d');
            $supplier_id      = $this->request->getGet('supplier_id');
            $purchase_invoice = $this->request->getGet('purchase_invoice');
            $show_detail      = $this->request->getGet('show_detail');
            $isDownload       = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType         = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent            = $this->request->getUserAgent();
            
            $data = [
                'start_date'         => $start_date,
                'end_date'           => $end_date,
                'supplier_id'        => $supplier_id,
                'purchase_invoice'   => $purchase_invoice,
                'isDownload'         => $isDownload,
                'fileType'           => $fileType,
                'agent'              => $agent
            ];

            if($show_detail == 'on'){
                $this->debtListDetail($data);
            }else{
                $this->debtListHeader($data);
            }
        }else {
            echo "<h1>Anda tidak memiliki akses ke laman ini</h1>";
        }
    }

    public function debtListHeader($data)
    {
        $M_debt_repayment   = model('M_debt_repayment');
        $start_date         = $data['start_date'];
        $end_date           = $data['end_date'];
        $supplier_id        = $data['supplier_id'];
        $purchase_invoice   = $data['purchase_invoice'];
        $isDownload         = $data['isDownload'];
        $fileType           = $data['fileType'];
        $agent              = $data['agent'];

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_debt_repayment->getDebt($purchase_invoice, $start_date, $end_date, $supplier_id)->getResultArray();

        if($getReportData != null){
            if($supplier_id != null){
                $supplier_name = $getReportData[0]['supplier_name'];
            }else{
                $supplier_name = '-';
            }
        }else{
            $supplier_name = '-';
        }

        if($getReportData != null){
            if($purchase_invoice != null){
                $purchase_invoice = $getReportData[0]['purchase_invoice'];
            }else{
                $purchase_invoice = '-';
            }
        }else{
            $purchase_invoice = '-';
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }
            $remainingDebtData    = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Laporan Hutang Jatuh Tempo',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'supplier_name'         => $supplier_name,
                'purchase_invoice'      => $purchase_invoice,
                'pages'                 => $remainingDebtData,
                'maxPage'               => count($remainingDebtData),
                'userLogin'             => $this->userLogin
            ];

            $htmlView   = view('webmin/report/debt/debt_list', $data);

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

            $template = WRITEPATH . '/template/template_export_debt_list.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;
            
            foreach ($getReportData as $row) {

               $purchase_total  = floatval($row['purchase_total']);
               $discount = floatval($row['dt_payment_debt_discount']);
               $total_pay = floatval($row['dt_payment_debt_nominal']);
               $pay = $total_pay + $discount;
               $payment_debt_date = indo_short_date($row['payment_debt_date'], FALSE);

               $sheet->getCell('A' . $iRow)->setValue($row['purchase_invoice']);
               $sheet->getCell('B' . $iRow)->setValue($row['payment_debt_invoice']);
               $sheet->getCell('C' . $iRow)->setValue($payment_debt_date);
               $sheet->getCell('D' . $iRow)->setValue($row['supplier_code']);
               $sheet->getCell('E' . $iRow)->setValue($row['supplier_name']);
               $sheet->getCell('F' . $iRow)->setValue(numberFormat($purchase_total, TRUE));
               $sheet->getCell('G' . $iRow)->setValue(numberFormat($pay, TRUE));
               $sheet->getCell('H' . $iRow)->setValue(numberFormat($discount, TRUE));
               $sheet->getCell('I' . $iRow)->setValue(numberFormat($total_pay, TRUE));

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


           $filename = 'Laporan Pembayaran Hutang';
           header('Content-Type: application/vnd.ms-excel');
           header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
           header('Cache-Control: max-age=0');
           $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
           $writer->save('php://output');
           exit();
       }
    }


    public function debtListDetail($data)
    {
        $M_debt_repayment   = model('M_debt_repayment');
        $start_date         = $data['start_date'];
        $end_date           = $data['end_date'];
        $supplier_id        = $data['supplier_id'];
        $purchase_invoice   = $data['purchase_invoice'];
        $isDownload         = $data['isDownload'];
        $fileType           = $data['fileType'];
        $agent              = $data['agent'];

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_debt_repayment->getDebtDetail($purchase_invoice, $start_date, $end_date, $supplier_id)->getResultArray();

        if($getReportData != null){
            if($supplier_id != null){
                $supplier_name = $getReportData[0]['supplier_name'];
            }else{
                $supplier_name = '-';
            }
        }else{
            $supplier_name = '-';
        }

        if($getReportData != null){
            if($purchase_invoice != null){
                $purchase_invoice = $getReportData[0]['purchase_invoice'];
            }else{
                $purchase_invoice = '-';
            }
        }else{
            $purchase_invoice = '-';
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }
            $remainingDebtData    = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Laporan Hutang Jatuh Tempo',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'supplier_name'         => $supplier_name,
                'purchase_invoice'      => $purchase_invoice,
                'pages'                 => $remainingDebtData,
                'maxPage'               => count($remainingDebtData),
                'userLogin'             => $this->userLogin
            ];

            $htmlView   = view('webmin/report/debt/debt_list', $data);

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

            $template = WRITEPATH . '/template/template_export_debt_list_detail.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;

            foreach ($getReportData as $row) {

               $purchase_total  = floatval($row['purchase_total']);
               $discount = floatval($row['dt_payment_debt_discount']);
               $total_pay = floatval($row['dt_payment_debt_nominal']);
               $pay = $total_pay + $discount;
               $payment_debt_date = indo_short_date($row['payment_debt_date'], FALSE);
               $qty = floatval($row['dt_purchase_qty']);

               $sheet->getCell('A' . $iRow)->setValue($row['purchase_invoice']);
               $sheet->getCell('B' . $iRow)->setValue($row['payment_debt_invoice']);
               $sheet->getCell('C' . $iRow)->setValue($payment_debt_date);
               $sheet->getCell('D' . $iRow)->setValue($row['supplier_code']);
               $sheet->getCell('E' . $iRow)->setValue($row['supplier_name']);
               $sheet->getCell('F' . $iRow)->setValue(numberFormat($purchase_total, TRUE));
               $sheet->getCell('G' . $iRow)->setValue(numberFormat($pay, TRUE));
               $sheet->getCell('H' . $iRow)->setValue(numberFormat($discount, TRUE));
               $sheet->getCell('I' . $iRow)->setValue(numberFormat($total_pay, TRUE));
               $sheet->getCell('J' . $iRow)->setValue($row['item_code']);
               $sheet->getCell('K' . $iRow)->setValue($row['product_name']);
               $sheet->getCell('L' . $iRow)->setValue($row['brand_name']);
               $sheet->getCell('M' . $iRow)->setValue($row['category_name']);
               $sheet->getCell('N' . $iRow)->setValue($qty);
               $sheet->getCell('O' . $iRow)->setValue($row['unit_name']);

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


           $filename = 'Laporan Pembayaran Hutang';
           header('Content-Type: application/vnd.ms-excel');
           header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
           header('Cache-Control: max-age=0');
           $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
           $writer->save('php://output');
           exit();
       }
    }

}
