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
        $data = [
            'title'         => 'Daftar Penukaran Poin',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/customer/point_exchange_list', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();
        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }
        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('daftar_penukaran_poin.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
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
        $data = [
            'title'         => 'Daftar Penukaran Poin',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/customer/customer_receivable_list', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();
        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }
        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $dompdf->stream('daftar_piutang_customer.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
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
        $data = [
            'title'         => 'Kwitansi Tagihan',
            'userLogin'     => $this->userLogin
        ];

        $htmlView   = view('webmin/report/customer/customer_receivable_receipt', $data);
        $isDownload = $this->request->getGet('download') == 'Y' ? TRUE : FALSE;
        $fileType   = $this->request->getGet('file');
        $agent      = $this->request->getUserAgent();
        if (!in_array($fileType, ['pdf'])) {
            $fileType = 'pdf';
        }
        if ($agent->isMobile() && !$isDownload) {
            return $htmlView;
        } else {
            if ($fileType == 'pdf') {
                $dompdf = new Dompdf();
                $dompdf->loadHtml($htmlView);
                $dompdf->setPaper('A4', 'portait');
                $dompdf->render();
                $dompdf->stream('kwitansi_tagihan_customer.pdf', array("Attachment" => $isDownload));
                exit();
            } else {
                die('Export Excel Script');
            }
        }
    }



    //




    //--------------------------------------------------------------------

}
