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
                    $sheet->getCell('C' . $iRow)->setValue($row['ket']);
                    $sheet->getCell('D' . $iRow)->setValue(numberFormat($debet, TRUE));
                    $sheet->getCell('E' . $iRow)->setValue(numberFormat($credit, TRUE));

                    $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);

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

                    $sheet->getCell('A' . $iRow)->setValue($row['purchase_invoice']);
                    $sheet->getCell('B' . $iRow)->setValue($purchase_date);
                    $sheet->getCell('C' . $iRow)->setValue($purchase_due_date);
                    $sheet->getCell('D' . $iRow)->setValue(numberFormat($purchase_total, TRUE));
                    $sheet->getCell('E' . $iRow)->setValue(numberFormat($purchase_down_payment, TRUE));
                    $sheet->getCell('F' . $iRow)->setValue(numberFormat($total_bayar_cal, TRUE));
                    $sheet->getCell('G' . $iRow)->setValue(numberFormat($purchase_remaining_debt, TRUE));

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
            $isDownload      = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType        = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent           = $this->request->getUserAgent();


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

                    $sheet->getCell('A' . $iRow)->setValue($row['purchase_invoice']);
                    $sheet->getCell('B' . $iRow)->setValue($purchase_date);
                    $sheet->getCell('C' . $iRow)->setValue($purchase_due_date);
                    $sheet->getCell('D' . $iRow)->setValue(numberFormat($purchase_total, TRUE));
                    $sheet->getCell('E' . $iRow)->setValue(numberFormat($purchase_down_payment, TRUE));
                    $sheet->getCell('F' . $iRow)->setValue(numberFormat($total_bayar_cal, TRUE));
                    $sheet->getCell('G' . $iRow)->setValue(numberFormat($purchase_remaining_debt, TRUE));

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


                $filename = 'Laporan Hutang Jatuh Tempo';
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
            $isDownload       = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType         = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent            = $this->request->getUserAgent();


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
                   $sheet->getCell('D' . $iRow)->setValue($row['supplier_name']);
                   $sheet->getCell('E' . $iRow)->setValue(numberFormat($purchase_total, TRUE));
                   $sheet->getCell('F' . $iRow)->setValue(numberFormat($pay, TRUE));
                   $sheet->getCell('G' . $iRow)->setValue(numberFormat($discount, TRUE));
                   $sheet->getCell('H' . $iRow)->setValue(numberFormat($total_pay, TRUE));

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
       } else {
        echo "<h1>Anda tidak memiliki akses ke laman ini</h1>";
    }
}

}
