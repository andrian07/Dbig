<?php

namespace App\Controllers\Webmin\Report;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;

class ReportProject extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        die('ReportProject');
    }

    public function viewProjectSalesList()
    {
        $data = [
            'title'         => 'Daftar Penjualan Proyek',
            'customerGroup' => $this->appConfig->get('default', 'customer_group')
        ];

        return $this->renderView('report/project/view_project_sales_list', $data);
    }

    public function projectSalesList()
    {
        if ($this->role->hasRole('report.project_list')) {

            $M_salesmanadmin = model('M_salesmanadmin');

            $start_date = $this->request->getGet('start_date') != NULL ? $this->request->getGet('start_date') : date('Y-m') . '-01';
            $end_date   = $this->request->getGet('end_date') != NULL ? $this->request->getGet('end_date') : date('Y-m-d');
            $store_id = $this->request->getGet('store_id');
            $customer_id = $this->request->getGet('customer_id');
            $salesman_id = $this->request->getGet('salesman_id');
            $status     = $this->request->getGet('status');
            $show_detail = $this->request->getGet('show_detail');
            $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType   = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent      = $this->request->getUserAgent();

            $data = [
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'store_id'              => $store_id,
                'customer_id'           => $customer_id,
                'salesman_id'           => $salesman_id,
                'status'                => $status,
                'isDownload'            => $isDownload,
                'fileType'              => $fileType,
                'agent'                 => $agent
            ];

            if($show_detail == 'on'){
                $this->SalesListDetail($data);
            }else{
                $this->SalesListHeader($data);
            }

            
        } else {
            echo "<h1>Anda tidak memiliki akses ke laman ini</h1>";
        }
    }


    public function SalesListDetail($data)
    {
        $M_salesmanadmin = model('M_salesmanadmin');

        $start_date  = $data['start_date'];
        $end_date    = $data['end_date'];
        $store_id    = $data['store_id'];
        $customer_id = $data['customer_id'];
        $salesman_id = $data['salesman_id'];
        $status      = $data['status'];
        $isDownload  = $data['isDownload'];
        $fileType    = $data['fileType'];
        $agent       = $data['agent'];

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_salesmanadmin->getReportDataDetail($start_date, $end_date, $store_id, $customer_id, $salesman_id, $status)->getResultArray();

        if($getReportData != null){
            if($store_id != null){
                $store_name = $getReportData[0]['store_name'];
            }else{
                $store_name = '-';
            }

            if($customer_id != null){
                $customer_name = $getReportData[0]['customer_name'];
            }else{
                $customer_name = '-';
            }
            if($salesman_id != null){
                $salesman_name = $getReportData[0]['salesman_name'];
            }else{
                $salesman_name = '-';
            }
            if($status == 2){
                $status = 'Jatuh Tempo';
            }else{
                $status = 'Semua';
            }
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }

            $salesmanAdminData        = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Sales Admin List Detail',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'store_name'            => $store_name,
                'customer_name'         => $customer_name,
                'salesman_name'         => $salesman_name,
                'status'                => $status,
                'pages'                 => $salesmanAdminData,
                'maxPage'               => count($salesmanAdminData),
                'userLogin'             => $this->userLogin
            ];

            $htmlView   = view('webmin/report/project/project_sales_list', $data);

            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('penjualanproyek.pdf', array("Attachment" => $isDownload));
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

            $template = WRITEPATH . '/template/template_export_sales_admin_detail.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;
            $last_invoice = '';

            foreach ($getReportData as $row) {

                $dt_temp_qty = floatval($row['dt_temp_qty']);
                $dt_product_price = floatval($row['dt_product_price']);
                $dt_sales_price = floatval($row['dt_sales_price']);
                $dt_total_ppn = floatval($row['dt_total_ppn']);
                $dt_total_dpp = floatval($row['dt_total_dpp']);

                $invoice = $last_invoice == $row['sales_admin_invoice'] ? '' : $row['sales_admin_invoice'];

                $sales_date     = indo_short_date($row['sales_date'], FALSE);
                $sales_due_date = indo_short_date($row['sales_due_date'], FALSE);

                $sheet->getCell('A' . $iRow)->setValue($invoice);
                $sheet->getCell('B' . $iRow)->setValue($sales_date);
                $sheet->getCell('C' . $iRow)->setValue($sales_due_date);
                $sheet->getCell('D' . $iRow)->setValue($row['salesman_name']);
                $sheet->getCell('E' . $iRow)->setValue($row['item_code']);
                $sheet->getCell('F' . $iRow)->setValue($row['product_name']);
                $sheet->getCell('G' . $iRow)->setValue($row['brand_name']);
                $sheet->getCell('H' . $iRow)->setValue($row['category_name']);
                $sheet->getCell('I' . $iRow)->setValue($dt_temp_qty);
                $sheet->getCell('J' . $iRow)->setValue(numberFormat($dt_product_price, TRUE));
                $sheet->getCell('K' . $iRow)->setValue(numberFormat($dt_total_ppn * $dt_temp_qty, TRUE));
                $sheet->getCell('L' . $iRow)->setValue(numberFormat($dt_total_dpp, TRUE));
                $sheet->getCell('M' . $iRow)->setValue(numberFormat($dt_total_ppn * $dt_temp_qty + $dt_total_dpp, TRUE));

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

                $last_invoice = $row['sales_admin_invoice'];
                $iRow++;
            }
                //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('B5')->setValue($periode_text);
            $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_short_date(date('Y-m-d H:i:s'), FALSE);
            $sheet->getCell('A1')->setValue($reportInfo);

            $sheet->mergeCells('A1:M1');

            $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A2:M2')->applyFromArray($font_bold);


            $filename = 'Penjualan Detail Admin';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }


    public function SalesListHeader($data)
    {
        $M_salesmanadmin = model('M_salesmanadmin');

        $start_date  = $data['start_date'];
        $end_date    = $data['end_date'];
        $store_id    = $data['store_id'];
        $customer_id = $data['customer_id'];
        $salesman_id = $data['salesman_id'];
        $status      = $data['status'];
        $isDownload  = $data['isDownload'];
        $fileType    = $data['fileType'];
        $agent       = $data['agent'];

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_salesmanadmin->getReportDataHeader($start_date, $end_date, $store_id, $customer_id, $salesman_id, $status)->getResultArray();

        if($getReportData != null){
            if($store_id != null){
                $store_name = $getReportData[0]['store_name'];
            }else{
                $store_name = '-';
            }

            if($customer_id != null){
                $customer_name = $getReportData[0]['customer_name'];
            }else{
                $customer_name = '-';
            }
            if($salesman_id != null){
                $salesman_name = $getReportData[0]['salesman_name'];
            }else{
                $salesman_name = '-';
            }
            if($status == 2){
                $status = 'Jatuh Tempo';
            }else{
                $status = 'Semua';
            }
        }else{
            $store_name = '-';
            $customer_name = '-';
            $salesman_name = '-';
            $status = 'Semua';
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }

            $salesmanAdminData        = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Sales Admin List Header',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'store_name'            => $store_name,
                'customer_name'         => $customer_name,
                'salesman_name'         => $salesman_name,
                'status'                => $status,
                'pages'                 => $salesmanAdminData,
                'maxPage'               => count($salesmanAdminData),
                'userLogin'             => $this->userLogin
            ];

            $htmlView   = view('webmin/report/project/project_sales_header_list', $data);

            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('penjualanproyek.pdf', array("Attachment" => $isDownload));
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

            $template = WRITEPATH . '/template/template_export_sales_admin_header.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;
            foreach ($getReportData as $row) {

                $sales_admin_total_discount = floatval($row['sales_admin_total_discount']);
                $sales_admin_ppn = floatval($row['sales_admin_ppn']);
                $sales_admin_down_payment = floatval($row['sales_admin_down_payment']);
                $sales_admin_grand_total = floatval($row['sales_admin_grand_total']);

                $sales_date     = indo_short_date($row['sales_date'], FALSE);
                $sales_due_date = indo_short_date($row['sales_due_date'], FALSE);

                $sheet->getCell('A' . $iRow)->setValue($row['sales_admin_invoice'] );
                $sheet->getCell('B' . $iRow)->setValue($sales_date);
                $sheet->getCell('C' . $iRow)->setValue($sales_due_date);
                $sheet->getCell('D' . $iRow)->setValue($row['salesman_name']);
                $sheet->getCell('E' . $iRow)->setValue($row['customer_name']);
                $sheet->getCell('F' . $iRow)->setValue(numberFormat($sales_admin_total_discount, TRUE));
                $sheet->getCell('G' . $iRow)->setValue(numberFormat($sales_admin_grand_total - $sales_admin_ppn, TRUE));
                $sheet->getCell('H' . $iRow)->setValue(numberFormat($sales_admin_ppn, TRUE));
                $sheet->getCell('I' . $iRow)->setValue(numberFormat($sales_admin_down_payment, TRUE));
                $sheet->getCell('J' . $iRow)->setValue(numberFormat($sales_admin_grand_total, TRUE));

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

            $sheet->mergeCells('A1:J1');

            $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A2:J2')->applyFromArray($font_bold);


            $filename = 'Penjualan Admin';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    public function viewProjectReturSalesList()
    {
        $data = [
            'title'     => 'Laporan Retur Penjualan Admin',
        ];
        return $this->renderView('report/project/view_retur_sales_project_list', $data);
    }

    public function returProjectSalesList()
    {
        if ($this->role->hasRole('report.retur_project_list')) {

            $M_salesmanadmin = model('M_salesmanadmin');

            $start_date  = $this->request->getGet('start_date') != NULL ? $this->request->getGet('start_date') : date('Y-m') . '-01';
            $end_date    = $this->request->getGet('end_date') != NULL ? $this->request->getGet('end_date') : date('Y-m-d');
            $customer_id = $this->request->getGet('customer_id');
            $store_id    = $this->request->getGet('store_id');
            $show_detail = $this->request->getGet('show_detail');
            $isDownload  = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType    = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent       = $this->request->getUserAgent();

            $data = [
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'store_id'              => $store_id,
                'customer_id'           => $customer_id,
                'isDownload'            => $isDownload,
                'fileType'              => $fileType,
                'agent'                 => $agent
            ];

            if($show_detail == 'on'){
                $this->SalesListDetailReturProject($data);
            }else{
                
                $this->SalesListHeaderReturProject($data);
            }

            
        } else {
            echo "<h1>Anda tidak memiliki akses ke laman ini</h1>";
        }
    }



    public function SalesListDetailReturProject($data)
    {
        $M_salesmanadmin = model('M_salesmanadmin');

        $start_date  = $data['start_date'];
        $end_date    = $data['end_date'];
        $store_id    = $data['store_id'];
        $customer_id = $data['customer_id'];
        $isDownload  = $data['isDownload'];
        $fileType    = $data['fileType'];
        $agent       = $data['agent'];

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }
        $getReportData = $M_salesmanadmin->getReportReturSalesAdminDataDetail($start_date, $end_date, $store_id, $customer_id)->getResultArray();

        if($getReportData != null){
            if($store_id != null){
                $store_name = $getReportData[0]['store_name'];
            }else{
                $store_name = '-';
            }

            if($customer_id != null){
                $customer_name = $getReportData[0]['customer_name'];
            }else{
                $customer_name = '-';
            }
        }else{
            $store_name = '-';
            $customer_name = '-';
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }

            $returSalesmanAdminData        = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Retur Sales Admin List Detail',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'store_name'            => $store_name,
                'customer_name'         => $customer_name,
                'pages'                 => $returSalesmanAdminData,
                'maxPage'               => count($returSalesmanAdminData),
                'userLogin'             => $this->userLogin
            ];

            $htmlView   = view('webmin/report/project/project_sales_detail_list', $data);

            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('penjualanproyek.pdf', array("Attachment" => $isDownload));
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

            $template = WRITEPATH . '/template/template_export_retur_sales_admin_detail.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;
            $last_invoice = '';

            foreach ($getReportData as $row) {

                $retur_price = floatval($row['dt_retur_price']);
                $retur_qty = floatval($row['dt_retur_qty']);
                $retur_ppn = floatval($row['dt_retur_ppn']);
                $retur_total = floatval($row['dt_retur_total']);

                $invoice = $last_invoice == $row['sales_admin_invoice'] ? '' : $row['sales_admin_invoice'];

                $retur_sales_date     = indo_short_date($row['hd_retur_date'], FALSE);
                //$sales_due_date = indo_short_date($row['sales_due_date'], FALSE);

                $sheet->getCell('A' . $iRow)->setValue($invoice);
                $sheet->getCell('B' . $iRow)->setValue($retur_sales_date);
                $sheet->getCell('C' . $iRow)->setValue($row['salesman_name']);
                $sheet->getCell('D' . $iRow)->setValue($row['item_code']);
                $sheet->getCell('E' . $iRow)->setValue($row['product_name']);
                $sheet->getCell('F' . $iRow)->setValue($retur_qty);
                $sheet->getCell('G' . $iRow)->setValue(numberFormat($retur_price, TRUE));
                $sheet->getCell('H' . $iRow)->setValue(numberFormat($retur_total, TRUE));

                $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);


                $last_invoice = $row['sales_admin_invoice'];
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


            $filename = 'Retur Detail Penjualan Admin';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }


    public function SalesListHeaderReturProject($data)
    {

      
        $M_salesmanadmin = model('M_salesmanadmin');

        $start_date  = $data['start_date'];
        $end_date    = $data['end_date'];
        $store_id    = $data['store_id'];
        $customer_id = $data['customer_id'];
        $isDownload  = $data['isDownload'];
        $fileType    = $data['fileType'];
        $agent       = $data['agent'];

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $getReportData = $M_salesmanadmin->getReportReturSalesAdminDataHeader($start_date, $end_date, $store_id, $customer_id)->getResultArray();
        
        if($getReportData != null){
            if($store_id != null){
                $store_name = $getReportData[0]['store_name'];
            }else{
                $store_name = '-';
            }
            if($customer_id != null){
                $customer_name = $getReportData[0]['customer_name'];
            }else{
                $customer_name = '-';
            }
        }else{
            $store_name = '-';
            $customer_name = '-';
        }

        if ($fileType == 'pdf') {
            $cRow           = count($getReportData);
            if ($cRow % 16 == 0) {
                $max_page_item  = 15;
            } else {
                $max_page_item  = 16;
            }

            $RetursalesmanAdminData        = array_chunk($getReportData, $max_page_item);
            $data = [
                'title'                 => 'Retur Penjualan Admin',
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'store_name'            => $store_name,
                'customer_name'         => $customer_name,
                'pages'                 => $RetursalesmanAdminData,
                'maxPage'               => count($RetursalesmanAdminData),
                'userLogin'             => $this->userLogin
            ];

            $htmlView   = view('webmin/report/project/retur_project_sales_header_list', $data);

            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('returpenjualanproyek.pdf', array("Attachment" => $isDownload));
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

            $template = WRITEPATH . '/template/template_export_retur_sales_admin_header.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 8;
            foreach ($getReportData as $row) {

               $hd_retur_total_dpp = floatval($row['hd_retur_total_dpp']);
               $hd_retur_total_ppn = floatval($row['hd_retur_total_ppn']);
               $hd_retur_total_transaction = floatval($row['hd_retur_total_transaction']);
               $hd_retur_date     = indo_short_date($row['hd_retur_date'], FALSE);
               
               $sheet->getCell('A' . $iRow)->setValue($row['hd_retur_sales_admin_invoice']);
               $sheet->getCell('B' . $iRow)->setValue($row['customer_code']);
               $sheet->getCell('C' . $iRow)->setValue($row['salesman_name']);
               $sheet->getCell('D' . $iRow)->setValue($row['customer_name']);
               $sheet->getCell('E' . $iRow)->setValue($hd_retur_date);
               $sheet->getCell('F' . $iRow)->setValue(numberFormat($hd_retur_total_dpp, TRUE));
               $sheet->getCell('G' . $iRow)->setValue(numberFormat($hd_retur_total_ppn, TRUE));
               $sheet->getCell('H' . $iRow)->setValue(numberFormat($hd_retur_total_transaction, TRUE));

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

           $sheet->mergeCells('A1:G1');

           $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('right');

           $sheet->getStyle('A2:G2')->applyFromArray($font_bold);


           $filename = 'Retur Penjualan Admin';
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
