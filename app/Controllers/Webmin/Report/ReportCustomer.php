<?php

namespace App\Controllers\Webmin\Report;

use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;

class ReportCustomer extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        die('ReportCustomer');
    }

    public function viewCustomerList()
    {
        $data = [
            'title'         => 'Daftar Customer',
            'customerGroup' => $this->appConfig->get('default', 'customer_group')
        ];

        return $this->renderView('report/customer/view_customer_list', $data);
    }

    public function customerList()
    {
        //FILTER//
        $prov_id                = $this->request->getGet('prov_id') == NULL ? '' : $this->request->getGet('prov_id');
        $prov_name              = $this->request->getGet('prov_name') == NULL ? '-' : $this->request->getGet('prov_name');
        $city_id                = $this->request->getGet('city_id') == NULL ? '' : $this->request->getGet('city_id');
        $city_name              = $this->request->getGet('city_name') == NULL ? '-' : $this->request->getGet('city_name');
        $dis_id                 = $this->request->getGet('dis_id') == NULL ? '' : $this->request->getGet('dis_id');
        $dis_name               = $this->request->getGet('dis_name') == NULL ? '-' : $this->request->getGet('dis_name');
        $subdis_id              = $this->request->getGet('subdis_id') == NULL ? '' : $this->request->getGet('subdis_id');
        $subdis_name            = $this->request->getGet('subdis_name') == NULL ? '-' : $this->request->getGet('subdis_name');
        $customer_group         = $this->request->getGet('customer_group') == NULL ? '' : $this->request->getGet('customer_group');
        $customer_group_text    = $this->request->getGet('customer_group_text') == NULL ? '' : $this->request->getGet('customer_group_text');
        $exp_date               = $this->request->getGet('exp_date') == NULL ? '' : $this->request->getGet('exp_date');
        $exp_date_text          = $this->request->getGet('exp_date_text') == NULL ? '' : $this->request->getGet('exp_date_text');

        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        $config_label_group = $this->appConfig->get('default', 'label_customer_group');
        $default_customer_id    = $this->appConfig->get('default', 'pos', 'customer_id');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        // Generate Query //
        $db = \Config\Database::connect();

        $filter_mapping_area = NULL;


        if (!($prov_id == '' && $city_id == '' && $dis_id == '' && $subdis_id == '')) {
            $subQuery = $db->table('ms_mapping_area AS ma');
            $subQuery->select('ma.mapping_id');

            if ($prov_id != '') {
                $subQuery->where('ma.prov_id', $prov_id);
            }

            if ($city_id != '') {
                $subQuery->where('ma.city_id', $city_id);
            }

            if ($dis_id != '') {
                $subQuery->where('ma.dis_id', $dis_id);
            }

            if ($subdis_id != '') {
                $subQuery->where('ma.subdis_id', $subdis_id);
            }


            $filter_mapping_area = $subQuery->getCompiledSelect();
        }

        $builder = $db->table('ms_customer');
        $builder->select('ms_customer.*,ms_mapping_area.mapping_code,ms_mapping_area.mapping_address,ms_salesman.salesman_code,ms_salesman.salesman_name,pc_provinces.prov_name,pc_cities.city_name,pc_districts.dis_name,pc_subdistricts.subdis_name');
        $builder->join('ms_mapping_area', 'ms_mapping_area.mapping_id=ms_customer.mapping_id', 'left');
        $builder->join('pc_provinces', 'pc_provinces.prov_id=ms_mapping_area.prov_id', 'left');
        $builder->join('pc_cities', 'pc_cities.city_id=ms_mapping_area.city_id', 'left');
        $builder->join('pc_districts', 'pc_districts.dis_id=ms_mapping_area.dis_id', 'left');
        $builder->join('pc_subdistricts', 'pc_subdistricts.subdis_id=ms_mapping_area.subdis_id', 'left');


        $builder->join('ms_salesman', 'ms_salesman.salesman_id=ms_customer.salesman_id', 'left');
        $builder->where('ms_customer.deleted', 'N');
        $builder->where('ms_customer.customer_id!=', $default_customer_id);
        if ($customer_group != '') {
            $builder->where('ms_customer.customer_group', $customer_group);
        }

        if ($exp_date != '') {
            $current_date = date('Y-m-d');
            //1 = masih berlaku
            //2 = Sisa Masa Berlaku 10 Hari
            //3 = Sisa Masa Berlaku 30 Hari
            //4 = Habis Masa Berlaku

            if ($exp_date == '1') {
                $builder->where('ms_customer.exp_date>=', $current_date);
            } elseif ($exp_date == '2') {
                $builder->where("(ms_customer.exp_date BETWEEN '$current_date' AND DATE_ADD('$current_date',INTERVAL 10 DAY))");
            } elseif ($exp_date == '3') {
                $builder->where("(ms_customer.exp_date BETWEEN '$current_date' AND DATE_ADD('$current_date',INTERVAL 30 DAY))");
            } else {
                $builder->where('ms_customer.exp_date<', $current_date);
            }
        }

        if ($filter_mapping_area != NULL) {
            $builder->where("ms_customer.mapping_id IN ($filter_mapping_area)");
        }

        $getCustomer = $builder->get()->getResultArray();

        if ($fileType == 'pdf') {
            $max_page_item  = 10;
            $customerData   = array_chunk($getCustomer, $max_page_item);
            $data = [
                'title'                 => 'Daftar Customer',
                'configGroup'           => $config_label_group,
                'prov_name'             => $prov_name,
                'city_name'             => $city_name,
                'dis_name'              => $dis_name,
                'subdis_name'           => $subdis_name,
                'exp_date'              => $exp_date,
                'exp_date_text'         => $exp_date_text,
                'customer_group'        => $customer_group,
                'customer_group_text'   => $customer_group_text,
                'pages'                 => $customerData,
                'maxPage'               => count($customerData),
                'userLogin'             => $this->userLogin
            ];


            $htmlView   = view('webmin/report/customer/customer_list', $data);

            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('daftar_customer.pdf', array("Attachment" => $isDownload));
                    exit();
                }
            }
        } else {
            $template = WRITEPATH . '/template/report/template_customer_list.xls';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet2 = $spreadsheet->setActiveSheetIndex(1);
            $iRow = 3;
            foreach ($getCustomer as $row) {
                $customer_group_label   = isset($config_label_group[$row['customer_group']]) ? strip_tags($config_label_group[$row['customer_group']]) : 'ERROR';
                $customer_nik   = '-';
                $customer_npwp  = '-';
                $customer_phone = '-';

                if (!($row['customer_nik'] == '' && $row['customer_nik'] == NULL)) {
                    $customer_nik = "'" . $row['customer_nik'];
                }

                if (!($row['customer_npwp'] == '' && $row['customer_npwp'] == NULL)) {
                    $customer_npwp = "'" . $row['customer_npwp'];
                }

                if (!($row['customer_phone'] == '' && $row['customer_phone'] == NULL)) {
                    $customer_phone = "'" . $row['customer_phone'];
                }



                $sheet2->getCell('A' . $iRow)->setValue($iRow - 2);
                $sheet2->getCell('B' . $iRow)->setValue($row['customer_code']);
                $sheet2->getCell('C' . $iRow)->setValue($row['customer_name']);
                $sheet2->getCell('D' . $iRow)->setValue($customer_group_label);
                $sheet2->getCell('E' . $iRow)->setValue($row['customer_gender']);
                $sheet2->getCell('F' . $iRow)->setValue(indo_short_date($row['customer_birth_date']));
                $sheet2->getCell('G' . $iRow)->setValue($row['customer_job']);

                $sheet2->getCell('H' . $iRow)->setValue($row['customer_address']);
                $sheet2->getCell('I' . $iRow)->setValue($customer_phone);
                $sheet2->getCell('J' . $iRow)->setValue($row['customer_email']);
                $sheet2->getCell('K' . $iRow)->setValue($row['customer_point']);
                $sheet2->getCell('L' . $iRow)->setValue($row['customer_delivery_address']);
                $sheet2->getCell('M' . $iRow)->setValue($customer_nik);
                $sheet2->getCell('N' . $iRow)->setValue($customer_npwp);
                $sheet2->getCell('O' . $iRow)->setValue($row['customer_tax_invoice_name']);
                $sheet2->getCell('P' . $iRow)->setValue($row['customer_tax_invoice_address']);

                $sheet2->getCell('Q' . $iRow)->setValue($row['prov_name']);
                $sheet2->getCell('R' . $iRow)->setValue($row['city_name']);
                $sheet2->getCell('S' . $iRow)->setValue($row['dis_name']);
                $sheet2->getCell('T' . $iRow)->setValue($row['subdis_name']);
                $sheet2->getCell('U' . $iRow)->setValue($row['mapping_address']);

                $sheet2->getCell('V' . $iRow)->setValue($row['salesman_code']);
                $sheet2->getCell('W' . $iRow)->setValue($row['salesman_name']);

                $sheet2->getCell('X' . $iRow)->setValue($row['customer_remark']);
                $sheet2->getCell('Y' . $iRow)->setValue(indo_short_date($row['exp_date']));
                $sheet2->getCell('Z' . $iRow)->setValue($row['active']);
                $iRow++;
            }


            $sheet1 = $spreadsheet->setActiveSheetIndex(0);
            $export_date = indo_short_date(date('Y-m-d H:i:s'));


            $sheet1->getCell('C2')->setValue($prov_name);
            $sheet1->getCell('C3')->setValue($city_name);
            $sheet1->getCell('C4')->setValue($dis_name);
            $sheet1->getCell('C5')->setValue($subdis_name);
            $sheet1->getCell('C6')->setValue($customer_group_text);
            $sheet1->getCell('C7')->setValue($exp_date_text);
            $sheet1->getCell('C8')->setValue($export_date);

            $filename = 'daftar_customer';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('php://output');
            exit();
        }
    }

    public function viewPointExchangeList()
    {
        $data = [
            'title'         => 'Daftar Penukaran Poin',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/customer/view_point_exchange_list', $data);
    }

    public function pointExchangeList()
    {
        $customer_id    = $this->request->getGet('customer_id') != null ? $this->request->getGet('customer_id') : '';
        $customer_name  = $this->request->getGet('customer_name') != null ? $this->request->getGet('customer_name') : '-';
        $status         = $this->request->getGet('status') != null ? $this->request->getGet('status') : '';
        $start_date     = $this->request->getGet('start_date') != null ? $this->request->getGet('start_date') : date('Y-m-d');
        $end_date       = $this->request->getGet('end_date') != null ? $this->request->getGet('end_date') : date('Y-m-d');

        $list_status = [
            ''          => '-',
            'success'   => 'Selesai',
            'pending'   => 'Proses',
            'cancel'    => 'Dibatalkan'
        ];

        $status_text    = isset($list_status[$status]) ? $list_status[$status] : '-';

        $agent = $this->request->getUserAgent();
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        $data = [
            'title'             => 'Laporan Penjualan',
            'userLogin'         => $this->userLogin,
            'customer_id'       => $customer_id,
            'customer_name'     => $customer_name,
            'status'            => $status,
            'status_text'       => $status_text,
            'list_status'       => $list_status,
            'start_date'        => $start_date,
            'end_date'          => $end_date,
        ];

        $M_point_exchange       = model('M_point_exchange');
        $getData                = $M_point_exchange->getReportExchangeList($start_date, $end_date, $status, $customer_id)->getResultArray();

        if ($fileType == 'pdf') {
            $max_report_size    = 14;
            $pages              = array_chunk($getData, $max_report_size);
            $data['pages']      = $pages;
            $data['max_page']   = count($pages);

            $htmlView = $this->renderView('report/customer/point_exchange_list', $data);
            if ($agent->isMobile() && !$isDownload) {
                return $htmlView;
            } else {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('penukaran_poin.pdf', array("Attachment" => $isDownload));
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
            $sheet->getCell('A' . $iRow)->setValue('KODE PENUKARAN');
            $sheet->getCell('B' . $iRow)->setValue('KODE CUSTOMER');
            $sheet->getCell('C' . $iRow)->setValue('NAMA CUSTOMER');
            $sheet->getCell('D' . $iRow)->setValue('NAMA ITEM');
            $sheet->getCell('E' . $iRow)->setValue('POIN');
            $sheet->getCell('F' . $iRow)->setValue('TGL.PENUKARAN');
            $sheet->getCell('G' . $iRow)->setValue('TGL.PENGAMBILAN');
            $sheet->getCell('H' . $iRow)->setValue('LOKASI PENGAMBILAN');
            $sheet->getCell('I' . $iRow)->setValue('OLEH USER');
            $sheet->getCell('J' . $iRow)->setValue('STATUS');

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
            $iRow++;

            foreach ($getData as $row) {
                $sheet->getCell('A' . $iRow)->setValue($row['exchange_code']);
                $sheet->getCell('B' . $iRow)->setValue($row['customer_code']);
                $sheet->getCell('C' . $iRow)->setValue($row['customer_name']);
                $sheet->getCell('D' . $iRow)->setValue($row['reward_name']);
                $sheet->getCell('E' . $iRow)->setValue(floatval($row['reward_point']));
                $sheet->getCell('F' . $iRow)->setValue(indo_short_date($row['exchange_date']));
                $completed_at = $row['completed_at'] == null ? '' : indo_short_date(substr($row['completed_at'], 0, 10));
                $sheet->getCell('G' . $iRow)->setValue($completed_at);
                $sheet->getCell('H' . $iRow)->setValue($row['store_name']);
                $sheet->getCell('I' . $iRow)->setValue($row['user_realname']);
                $sheet->getCell('J' . $iRow)->setValue($list_status[$row['exchange_status']]);

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

            //setting periode
            $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
            $sheet->getCell('A5')->setValue('Periode');
            $sheet->getStyle('A5')->applyFromArray($font_bold);
            $sheet->getCell('B5')->setValue($periode_text);
            $sheet->mergeCells('B5:J5');

            $filter_text = "CUSTOMER = $customer_name;STATUS = $status_text";
            $sheet->getCell('A6')->setValue('Filter');
            $sheet->getStyle('A6')->applyFromArray($font_bold);
            $sheet->getCell('B6')->setValue($filter_text);
            $sheet->mergeCells('B6:J6');

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

            $sheet->mergeCells('A4:J4');
            $sheet->mergeCells('A3:J3');
            $sheet->mergeCells('A2:J2');
            $sheet->mergeCells('A1:J1');

            $sheet->getStyle('A4:J4')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3:J3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:J2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A4:J4')->applyFromArray($font_bold);
            $sheet->getStyle('A3:J3')->applyFromArray($font_bold);
            $sheet->getStyle('A2:J2')->applyFromArray($font_bold);

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

            $filename = 'penukaran_poin';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }

    public function viewCustomerReceivableList()
    {
        $data = [
            'title'         => 'Daftar Piutang Customer',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/customer/view_customer_receivable_list', $data);
    }

    public function customerReceivableList()
    {
        if ($this->role->hasRole('report.receivable_list')) {

            $M_receivable_repayment = model('M_receivable_repayment');

            $start_date      = $this->request->getGet('start_date') != NULL ? $this->request->getGet('start_date') : date('Y-m') . '-01';
            $end_date        = $this->request->getGet('end_date') != NULL ? $this->request->getGet('end_date') : date('Y-m-d');
            $customer_id     = $this->request->getGet('customer_id');
            $store_id        = $this->request->getGet('store_id');
            $isDownload      = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType        = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent           = $this->request->getUserAgent();


            if (!in_array($fileType, ['pdf', 'xls'])) {
                $fileType = 'pdf';
            }

            $getReportData = $M_receivable_repayment->getReportData($start_date, $end_date, $customer_id, $store_id)->getResultArray();


            if ($getReportData != null) {
                if ($customer_id != null) {
                    $customer_name = $getReportData[0]['customer_name'];
                } else {
                    $customer_name = '-';
                }
            } else {
                $customer_name = '-';
            }


            if ($fileType == 'pdf') {
                $cRow           = count($getReportData);
                if ($cRow % 16 == 0) {
                    $max_page_item  = 15;
                } else {
                    $max_page_item  = 16;
                }
                $receivabledata    = array_chunk($getReportData, $max_page_item);
                $data = [
                    'title'                 => 'Laporan Piutang Customer',
                    'start_date'            => $start_date,
                    'end_date'              => $end_date,
                    'customer_name'         => $customer_name,
                    'pages'                 => $receivabledata,
                    'maxPage'               => count($receivabledata),
                    'userLogin'             => $this->userLogin
                ];


                $htmlView   = view('webmin/report/customer/customer_receivable_list', $data);

                if ($agent->isMobile()  && !$isDownload) {
                    return $htmlView;
                } else {
                    if ($fileType == 'pdf') {
                        $dompdf = new Dompdf();
                        $dompdf->loadHtml($htmlView);
                        $dompdf->setPaper('A4', 'landscape');
                        $dompdf->render();
                        $dompdf->stream('daftar-piutang-customer.pdf', array("Attachment" => $isDownload));
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

                $template = WRITEPATH . '/template/template_export_receivable.xlsx';
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

                $sheet = $spreadsheet->setActiveSheetIndex(0);
                $iRow = 8;

                $last_customer = '';
                foreach ($getReportData as $row) {
                    $sales_admin_grand_total  = floatval($row['sales_admin_grand_total']);
                    $sales_admin_down_payment = floatval($row['sales_admin_down_payment']);
                    $sales_admin_remaining_payment = floatval($row['sales_admin_remaining_payment']);
                    $total_pay = floatval($row['sales_admin_remaining_payment'] - $sales_admin_down_payment);
                    $sales_date = indo_short_date($row['sales_date'], TRUE);
                    $sales_due_date = indo_short_date($row['sales_due_date'], TRUE);

                    $sheet->getCell('A' . $iRow)->setValue($last_customer == $row['customer_name'] ? '' : $row['customer_name']);
                    $sheet->getCell('B' . $iRow)->setValue($row['store_code'] . '-' . $row['store_name']);
                    $sheet->getCell('C' . $iRow)->setValue($row['sales_admin_invoice']);
                    $sheet->getCell('D' . $iRow)->setValue(indo_short_date($row['sales_date'], FALSE));
                    $sheet->getCell('E' . $iRow)->setValue(indo_short_date($row['sales_due_date'], FALSE));
                    $sheet->getCell('F' . $iRow)->setValue(numberFormat($sales_admin_grand_total));
                    $sheet->getCell('G' . $iRow)->setValue(numberFormat($sales_admin_down_payment));
                    $sheet->getCell('H' . $iRow)->setValue(numberFormat($total_pay));
                    $sheet->getCell('I' . $iRow)->setValue(numberFormat($sales_admin_remaining_payment));


                    $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('I' . $iRow)->applyFromArray($border_left_right);

                    $last_customer = $row['customer_name'];
                    $iRow++;
                }
                //setting periode
                $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
                $sheet->getCell('B1')->setValue($periode_text);
                $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_date(date('Y-m-d H:i:s'), FALSE);
                $sheet->getCell('A1')->setValue($reportInfo);

                $sheet->mergeCells('A1:I1');

                $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('right');

                $sheet->getStyle('A2:I2')->applyFromArray($font_bold);


                $filename = 'Daftar Piutang Customer';
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


    public function viewCustomerReceivableReceipt()
    {
        $data = [
            'title'         => 'Cetak Kwitansi Tagihan',
            'userLogin'     => $this->userLogin
        ];

        return $this->renderView('report/customer/view_customer_receivable_receipt', $data);
    }

    public function customerReceivableReceipt()
    {
        if ($this->role->hasRole('report.receivable_list_receipt')) {

            $M_receivable_repayment = model('M_receivable_repayment');

            $start_date      = $this->request->getGet('start_date') != NULL ? $this->request->getGet('start_date') : date('Y-m') . '-01';
            $end_date        = $this->request->getGet('end_date') != NULL ? $this->request->getGet('end_date') : date('Y-m-d');
            $customer_id     = $this->request->getGet('customer_id');
            $store_id        = $this->request->getGet('store_id');
            $isDownload      = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
            $fileType        = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
            $agent           = $this->request->getUserAgent();


            if (!in_array($fileType, ['pdf', 'xls'])) {
                $fileType = 'pdf';
            }

            $getReportData = $M_receivable_repayment->getReportData($start_date, $end_date, $customer_id, $store_id)->getResultArray();


            if ($getReportData != null) {
                if ($customer_id != null) {
                    $customer_name = $getReportData[0]['customer_name'];
                    $customer_address = $getReportData[0]['customer_address'];
                    $customer_phone = $getReportData[0]['customer_phone'];
                } else {
                    $customer_name = '-';
                    $customer_address = '-';
                    $customer_phone = '-';
                }
            } else {
                $customer_name = '-';
                $customer_address = '-';
                $customer_phone = '-';
            }


            if ($fileType == 'pdf') {
                $cRow           = count($getReportData);
                if ($cRow % 16 == 0) {
                    $max_page_item  = 15;
                } else {
                    $max_page_item  = 16;
                }
                $receivabledata    = array_chunk($getReportData, $max_page_item);
                $data = [
                    'title'                 => 'Laporan Tagihan Piutang',
                    'start_date'            => $start_date,
                    'end_date'              => $end_date,
                    'customer_name'         => $customer_name,
                    'customer_address'      => $customer_address,
                    'customer_phone'        => $customer_phone,
                    'pages'                 => $receivabledata,
                    'maxPage'               => count($receivabledata),
                    'userLogin'             => $this->userLogin
                ];

                $htmlView   = view('webmin/report/customer/customer_receivable_receipt', $data);

                if ($agent->isMobile()  && !$isDownload) {
                    return $htmlView;
                } else {
                    if ($fileType == 'pdf') {
                        $dompdf = new Dompdf();
                        $dompdf->loadHtml($htmlView);
                        $dompdf->setPaper('A4', 'landscape');
                        $dompdf->render();
                        $dompdf->stream('daftar-piutang-customer.pdf', array("Attachment" => $isDownload));
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

                $template = WRITEPATH . '/template/template_export_receivable_receipt.xlsx';
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

                $sheet = $spreadsheet->setActiveSheetIndex(0);
                $iRow = 8;

                $last_customer = '';
                foreach ($getReportData as $row) {
                    $sales_admin_grand_total  = floatval($row['sales_admin_grand_total']);
                    $sales_admin_down_payment = floatval($row['sales_admin_down_payment']);
                    $sales_admin_remaining_payment = floatval($row['sales_admin_remaining_payment']);
                    $total_pay = floatval($sales_admin_grand_total - $sales_admin_remaining_payment);
                    $sales_date = indo_short_date($row['sales_date'], TRUE);
                    $sales_due_date = indo_short_date($row['sales_due_date'], TRUE);

                    $sheet->getCell('A' . $iRow)->setValue($last_customer == $row['customer_name'] ? '' : $row['customer_name']);
                    $sheet->getCell('B' . $iRow)->setValue($row['store_code'] . '-' . $row['store_name']);
                    $sheet->getCell('C' . $iRow)->setValue($row['sales_admin_invoice']);
                    $sheet->getCell('D' . $iRow)->setValue(indo_short_date($row['sales_date'], FALSE));
                    $sheet->getCell('E' . $iRow)->setValue(indo_short_date($row['sales_due_date'], FALSE));
                    $sheet->getCell('F' . $iRow)->setValue(numberFormat($sales_admin_grand_total));
                    $sheet->getCell('G' . $iRow)->setValue(numberFormat($sales_admin_down_payment));
                    $sheet->getCell('H' . $iRow)->setValue(numberFormat($total_pay));
                    $sheet->getCell('I' . $iRow)->setValue(numberFormat($sales_admin_remaining_payment));


                    $sheet->getStyle('A' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('B' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('C' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('D' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('E' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('F' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('G' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('H' . $iRow)->applyFromArray($border_left_right);
                    $sheet->getStyle('I' . $iRow)->applyFromArray($border_left_right);

                    $last_customer = $row['customer_name'];
                    $iRow++;
                }
                //setting periode
                $periode_text = indo_short_date($start_date) . ' s.d ' . indo_short_date($end_date);
                $sheet->getCell('B1')->setValue($periode_text);
                $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_date(date('Y-m-d H:i:s'), FALSE);
                $sheet->getCell('A1')->setValue($reportInfo);

                $sheet->mergeCells('A1:I1');

                $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('right');

                $sheet->getStyle('A2:I2')->applyFromArray($font_bold);


                $filename = 'Daftar Piutang Customer';
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

    public function viewCustomerMappingList()
    {
        $data = [
            'title'         => 'Daftar Mapping Customer',
            'customerGroup' => $this->appConfig->get('default', 'customer_group')
        ];

        return $this->renderView('report/customer/view_customer_mapping_list', $data);
    }

    public function customerMappingList()
    {

        //FILTER//
        $mapping_id             = $this->request->getGet('mapping_id') == NULL ? '' : $this->request->getGet('mapping_id');
        $mapping_name           = $this->request->getGet('mapping_name') == NULL ? '-' : $this->request->getGet('mapping_name');


        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file') == NULL ? 'pdf' : $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();

        $config_label_group     = $this->appConfig->get('default', 'label_customer_group');
        $default_customer_id    = $this->appConfig->get('default', 'pos', 'customer_id');

        if (!in_array($fileType, ['pdf', 'xls'])) {
            $fileType = 'pdf';
        }

        // Generate Query //
        $db = \Config\Database::connect();



        $builder = $db->table('ms_customer');
        $builder->select('ms_customer.*,ms_mapping_area.mapping_code,ms_mapping_area.mapping_address,ms_salesman.salesman_code,ms_salesman.salesman_name,pc_provinces.prov_name,pc_cities.city_name,pc_districts.dis_name,pc_subdistricts.subdis_name');
        $builder->join('ms_mapping_area', 'ms_mapping_area.mapping_id=ms_customer.mapping_id', 'left');
        $builder->join('pc_provinces', 'pc_provinces.prov_id=ms_mapping_area.prov_id', 'left');
        $builder->join('pc_cities', 'pc_cities.city_id=ms_mapping_area.city_id', 'left');
        $builder->join('pc_districts', 'pc_districts.dis_id=ms_mapping_area.dis_id', 'left');
        $builder->join('pc_subdistricts', 'pc_subdistricts.subdis_id=ms_mapping_area.subdis_id', 'left');


        $builder->join('ms_salesman', 'ms_salesman.salesman_id=ms_customer.salesman_id', 'left');
        $builder->where('ms_customer.deleted', 'N');
        $builder->where('ms_customer.customer_id!=', $default_customer_id);
        if ($mapping_id != '') {
            $builder->where('ms_customer.mapping_id', $mapping_id);
        }
        $builder->orderBy('ms_customer.mapping_id,ms_customer.customer_name', 'ASC');
        $getCustomer = $builder->get()->getResultArray();


        //dd($mapping_id, $mapping_name, $getCustomer);

        if ($fileType == 'pdf') {
            $sample_tables_rows = [
                [
                    ['text' => 'header', 'colspan' => '7', 'class' => 'text-left']
                ],
                [
                    ['text' => '#', 'class' => 'text-right'],
                    ['text' => 'KODE CUSTOMER', 'class' => 'text-left'],
                    ['text' => 'NAMA CUSTOMER',  'class' => 'text-left'],
                    ['text' => 'ALAMAT',  'class' => 'text-left'],
                    ['text' => 'NO TELP',  'class' => 'text-left'],
                    ['text' => 'GRUP', 'class' => 'text-left'],
                    ['text' => 'EXP',  'class' => 'text-left'],
                ],
                [
                    ['text' => 'total', 'colspan' => '6', 'class' => 'text-left'],
                    ['text' => 'total', 'class' => 'text-right'],
                ],
            ];

            $table_rows = [];
            $last_mapping_id = '';
            $num_row = 1;
            foreach ($getCustomer as $row) {
                if ($row['mapping_id'] != $last_mapping_id) {
                    if ($last_mapping_id != '') {
                        // create footer //
                        $table_rows[] = [
                            ['text' => '<b>TOTAL CUSTOMER</b>', 'colspan' => '6', 'class' => 'text-right'],
                            ['text' => numberFormat(($num_row - 1)), 'class' => 'text-right']
                        ];
                        $num_row = 1;
                    }

                    // create new header //
                    $header = intval($row['mapping_id']) == 0 ? '<b>NO GROUPS</b>' : '<b>' . $row['mapping_code'] . ' - ' . $row['mapping_address'] . '</b>';
                    $table_rows[] = [
                        ['text' => $header, 'colspan' => '7', 'class' => 'text-left']
                    ];
                }

                $customer_group_label   = isset($config_label_group[$row['customer_group']]) ? strip_tags($config_label_group[$row['customer_group']]) : 'ERROR';

                $table_rows[] = [
                    ['text' => $num_row, 'class' => 'text-right'],
                    ['text' => $row['customer_code'], 'class' => 'text-left'],
                    ['text' => $row['customer_name'],  'class' => 'text-left'],
                    ['text' => $row['customer_address'],  'class' => 'text-left'],
                    ['text' => $row['customer_phone'],  'class' => 'text-left'],
                    ['text' => $customer_group_label, 'class' => 'text-left'],
                    ['text' => indo_short_date($row['exp_date']),  'class' => 'text-left']
                ];


                $num_row++;
                $last_mapping_id = $row['mapping_id'];
            }

            if ($last_mapping_id != '') {
                // create footer //
                $table_rows[] = [
                    ['text' => '<b>TOTAL CUSTOMER</b>', 'colspan' => '6', 'class' => 'text-right'],
                    ['text' => numberFormat(($num_row - 1)), 'class' => 'text-right']
                ];
            }




            $max_page_item  = 10;
            $pages          = array_chunk($table_rows, $max_page_item);

            $data = [
                'title'                 => 'Daftar Mapping Customer',
                'configGroup'           => $config_label_group,
                'mapping_id'            => $mapping_id,
                'mapping_name'          => $mapping_name,
                'pages'                 => $pages,
                'maxPage'               => count($pages),
                'userLogin'             => $this->userLogin
            ];


            $htmlView   = view('webmin/report/customer/customer_mapping_list', $data);

            if ($agent->isMobile()  && !$isDownload) {
                return $htmlView;
            } else {
                if ($fileType == 'pdf') {
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($htmlView);
                    $dompdf->setPaper('A4', 'landscape');
                    $dompdf->render();
                    $dompdf->stream('daftar_mapping_customer.pdf', array("Attachment" => $isDownload));
                    exit();
                }
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
            $iRow = 6;
            $sheet->getCell('A' . $iRow)->setValue('#');
            $sheet->getCell('B' . $iRow)->setValue('KODE CUSTOMER');
            $sheet->getCell('C' . $iRow)->setValue('NAMA CUSTOMER');
            $sheet->getCell('D' . $iRow)->setValue('GRUP ');
            $sheet->getCell('E' . $iRow)->setValue('JENIS KELAMIN');
            $sheet->getCell('F' . $iRow)->setValue('TGL.LAHIR');
            $sheet->getCell('G' . $iRow)->setValue('PEKERJAAN');
            $sheet->getCell('H' . $iRow)->setValue('ALAMAT');
            $sheet->getCell('I' . $iRow)->setValue('NO.TELP');
            $sheet->getCell('J' . $iRow)->setValue('EMAIL');
            $sheet->getCell('K' . $iRow)->setValue('POIN');
            $sheet->getCell('L' . $iRow)->setValue('ALAMAT DELIVERY');
            $sheet->getCell('M' . $iRow)->setValue('NIK');
            $sheet->getCell('N' . $iRow)->setValue('NPWP');
            $sheet->getCell('O' . $iRow)->setValue('NAMA FAKTUR PAJAK');
            $sheet->getCell('P' . $iRow)->setValue('ALAMAT FAKTUR PAJAK');
            $sheet->getCell('Q' . $iRow)->setValue('PROVINSI');
            $sheet->getCell('R' . $iRow)->setValue('KOTA/KABUPATEN');
            $sheet->getCell('S' . $iRow)->setValue('KECAMATAN');
            $sheet->getCell('T' . $iRow)->setValue('KELURAHAN');
            $sheet->getCell('U' . $iRow)->setValue('NAMA JALAN');
            $sheet->getCell('V' . $iRow)->setValue('KODE SALESMAN');
            $sheet->getCell('W' . $iRow)->setValue('NAMA SALESMAN');
            $sheet->getCell('X' . $iRow)->setValue('KETERANGAN');
            $sheet->getCell('Y' . $iRow)->setValue('EXP DATE');
            $sheet->getCell('Z' . $iRow)->setValue('AKTIF');

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
            $sheet->getStyle('P' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('Q' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('R' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('S' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('T' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('U' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('V' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('W' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('X' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('Y' . $iRow)->applyFromArray($header_format);
            $sheet->getStyle('Z' . $iRow)->applyFromArray($header_format);
            $iRow++;



            $last_mapping_id = '';
            $num_row = 1;
            foreach ($getCustomer as $row) {
                if ($row['mapping_id'] != $last_mapping_id) {
                    if ($last_mapping_id != '') {
                        // create footer //
                        $sheet->getCell('A' . $iRow)->setValue('TOTAL CUSTOMER');
                        $sheet->getCell('Z' . $iRow)->setValue(($num_row - 1));
                        $sheet->mergeCells('A' . $iRow . ':Y' . $iRow);
                        $sheet->getStyle('A' . $iRow . ':Y' . $iRow)->getAlignment()->setHorizontal('right');
                        $sheet->getStyle('A' . $iRow . ':Y' . $iRow)->applyFromArray($total_format);
                        $sheet->getStyle('Z' . $iRow)->applyFromArray($total_format);
                        $iRow++;

                        $num_row = 1;
                    }

                    // create new header //
                    $header = intval($row['mapping_id']) == 0 ? 'NO GROUPS' :  $row['mapping_code'] . ' - ' . $row['mapping_address'];
                    $sheet->getCell('A' . $iRow)->setValue($header);
                    $sheet->mergeCells('A' . $iRow . ':Z' . $iRow);
                    $sheet->getStyle('A' . $iRow . ':Z' . $iRow)->applyFromArray($font_bold);
                    $sheet->getStyle('A' . $iRow . ':Z' . $iRow)->applyFromArray($border_full);
                    $iRow++;
                }


                $customer_group_label   = isset($config_label_group[$row['customer_group']]) ? strip_tags($config_label_group[$row['customer_group']]) : 'ERROR';
                $customer_nik   = '-';
                $customer_npwp  = '-';
                $customer_phone = '-';

                if (!($row['customer_nik'] == '' && $row['customer_nik'] == NULL)) {
                    $customer_nik = "'" . $row['customer_nik'];
                }

                if (!($row['customer_npwp'] == '' && $row['customer_npwp'] == NULL)) {
                    $customer_npwp = "'" . $row['customer_npwp'];
                }

                if (!($row['customer_phone'] == '' && $row['customer_phone'] == NULL)) {
                    $customer_phone = "'" . $row['customer_phone'];
                }



                $sheet->getCell('A' . $iRow)->setValue($num_row);
                $sheet->getCell('B' . $iRow)->setValue($row['customer_code']);
                $sheet->getCell('C' . $iRow)->setValue($row['customer_name']);
                $sheet->getCell('D' . $iRow)->setValue($customer_group_label);
                $sheet->getCell('E' . $iRow)->setValue($row['customer_gender']);
                $sheet->getCell('F' . $iRow)->setValue(indo_short_date($row['customer_birth_date']));
                $sheet->getCell('G' . $iRow)->setValue($row['customer_job']);

                $sheet->getCell('H' . $iRow)->setValue($row['customer_address']);
                $sheet->getCell('I' . $iRow)->setValue($customer_phone);
                $sheet->getCell('J' . $iRow)->setValue($row['customer_email']);
                $sheet->getCell('K' . $iRow)->setValue($row['customer_point']);
                $sheet->getCell('L' . $iRow)->setValue($row['customer_delivery_address']);
                $sheet->getCell('M' . $iRow)->setValue($customer_nik);
                $sheet->getCell('N' . $iRow)->setValue($customer_npwp);
                $sheet->getCell('O' . $iRow)->setValue($row['customer_tax_invoice_name']);
                $sheet->getCell('P' . $iRow)->setValue($row['customer_tax_invoice_address']);

                $sheet->getCell('Q' . $iRow)->setValue($row['prov_name']);
                $sheet->getCell('R' . $iRow)->setValue($row['city_name']);
                $sheet->getCell('S' . $iRow)->setValue($row['dis_name']);
                $sheet->getCell('T' . $iRow)->setValue($row['subdis_name']);
                $sheet->getCell('U' . $iRow)->setValue($row['mapping_address']);

                $sheet->getCell('V' . $iRow)->setValue($row['salesman_code']);
                $sheet->getCell('W' . $iRow)->setValue($row['salesman_name']);

                $sheet->getCell('X' . $iRow)->setValue($row['customer_remark']);
                $sheet->getCell('Y' . $iRow)->setValue(indo_short_date($row['exp_date']));
                $sheet->getCell('Z' . $iRow)->setValue($row['active']);


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
                $sheet->getStyle('R' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('S' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('T' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('U' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('V' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('W' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('X' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('Y' . $iRow)->applyFromArray($border_left_right);
                $sheet->getStyle('Z' . $iRow)->applyFromArray($border_left_right);
                $iRow++;


                $num_row++;
                $last_mapping_id = $row['mapping_id'];
            }

            if ($last_mapping_id != '') {
                // create footer //
                $sheet->getCell('A' . $iRow)->setValue('TOTAL CUSTOMER');
                $sheet->getCell('Z' . $iRow)->setValue(($num_row - 1));
                $sheet->mergeCells('A' . $iRow . ':Y' . $iRow);
                $sheet->getStyle('A' . $iRow . ':Y' . $iRow)->getAlignment()->setHorizontal('right');
                $sheet->getStyle('A' . $iRow . ':Y' . $iRow)->applyFromArray($total_format);
                $sheet->getStyle('Z' . $iRow)->applyFromArray($total_format);
                $iRow++;
            }


            //setting periode
            $filterText = "Mapping Area = $mapping_name";
            $sheet->getCell('A5')->setValue($filterText);
            $sheet->getStyle('A5')->applyFromArray($font_bold);
            $sheet->mergeCells('A5:Z5');

            //setting excel header//
            // A4= Store Phone
            // A3 = Store Address
            // A2 = Store Name
            // A1 = Print By
            $reportInfo = 'Dicetak oleh ' . $this->userLogin['user_realname'] . ' pada tanggal ' . indo_date(date('Y-m-d H:i:s'), FALSE);
            $sheet->getCell('A4')->setValue(COMPANY_PHONE);
            $sheet->getCell('A3')->setValue(COMPANY_ADDRESS);
            $sheet->getCell('A2')->setValue(COMPANY_NAME);
            $sheet->getCell('A1')->setValue($reportInfo);

            $sheet->mergeCells('A4:Z4');
            $sheet->mergeCells('A3:Z3');
            $sheet->mergeCells('A2:Z2');
            $sheet->mergeCells('A1:Z1');

            $sheet->getStyle('A4:Z4')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3:Z3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A2:Z2')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A1:Z1')->getAlignment()->setHorizontal('right');

            $sheet->getStyle('A4:Z4')->applyFromArray($font_bold);
            $sheet->getStyle('A3:Z3')->applyFromArray($font_bold);
            $sheet->getStyle('A2:Z2')->applyFromArray($font_bold);

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
            $sheet->getColumnDimension('P')->setAutoSize(true);
            $sheet->getColumnDimension('Q')->setAutoSize(true);
            $sheet->getColumnDimension('R')->setAutoSize(true);
            $sheet->getColumnDimension('S')->setAutoSize(true);
            $sheet->getColumnDimension('T')->setAutoSize(true);
            $sheet->getColumnDimension('U')->setAutoSize(true);
            $sheet->getColumnDimension('V')->setAutoSize(true);
            $sheet->getColumnDimension('W')->setAutoSize(true);
            $sheet->getColumnDimension('X')->setAutoSize(true);
            $sheet->getColumnDimension('Y')->setAutoSize(true);
            $sheet->getColumnDimension('Z')->setAutoSize(true);

            $filename = 'daftar_mapping_customer';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit();
        }
    }




    //




    //--------------------------------------------------------------------

}
