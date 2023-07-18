<?php


namespace App\Controllers\Webmin;

use Dompdf\Dompdf;
use Config\App as AppConfig;
use App\Models\M_salesmanadmin;
use App\Controllers\Base\WebminController;


class Sales_admin extends WebminController
{

    protected $M_salesmanadmin;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_salesmanadmin = new M_salesmanadmin;
    }

    public function index()
    {
        $data = [
            'title'         => 'Penjualan Admin'
        ];
        return $this->renderView('sales/salesadmin', $data);
    }

    public function tblsalesadmin()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('sales_admin.view')) {
            helper('datatable');

            $table = new \App\Libraries\Datatables('hd_sales_admin');
            $table->db->select('*');
            $table->db->join('ms_customer', 'ms_customer.customer_id  = hd_sales_admin.sales_customer_id');
            $table->db->join('ms_salesman', 'ms_salesman.salesman_id  = hd_sales_admin.sales_salesman_id');
            $table->db->orderBy('hd_sales_admin.created_at', 'desc');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['sales_admin_invoice']);
                $column[] = indo_short_date($row['sales_date']);
                $column[] = esc($row['salesman_name']);
                $column[] = esc($row['customer_name']);
                $column[] = 'Rp. '.esc(number_format($row['sales_admin_grand_total']));
                if($row['sales_admin_remaining_payment'] < 0){
                 $column[] = '<span class="badge badge-success">Lunas</span>';
             }else{
                 $column[] = '<span class="badge badge-danger">Belum Lunas</span>';
             }
             $column[] = 'Rp. '.esc(number_format($row['sales_admin_remaining_payment']));
             $btns = [];
             $prop =  'data-id="' . $row['sales_admin_id'] . '" data-name="' . esc($row['sales_admin_id']) . '"';
             $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/sales-admin/get-sales-admin-detail/'.$row['sales_admin_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';

             $btns[] = button_print($prop);
             $btns[] = button_edit($prop);
             $btns[] = '<button data-id="'.$row['sales_admin_id'].'" class="btn btn-sm btn-success btndownloadfaktur" data-toggle="tooltip" data-placement="top" data-title="Download E-Faktur"><i class="fas fa-file-invoice"></i></button>';
             $column[] = implode('&nbsp;', $btns);
             return $column;
         });

            $table->orderColumn  = ['', 'sales_admin_invoice', 'sales_date','',''];
            $table->searchColumn = ['sales_admin_invoice', ''];
            $table->generate();
        }
    }

    public function searchProduct()
    {

        $this->validationRequest(TRUE, 'GET');

        $keyword = $this->request->getGet('term');

        if (!($keyword == '' || $keyword == NULL)) {

            $M_product = model('M_product');

            $find = $M_product->searchProductUnitByName($keyword)->getResultArray();

            $find_result = [];

            foreach ($find as $row) {

                $diplay_text = $row['product_name'];

                $find_result[] = [

                    'id'                  => $diplay_text,

                    'value'               => $diplay_text.'('.$row['unit_name'].')',

                    'item_id'             => $row['item_id'],

                    'price'               => $row['G5_sales_price'],

                    'purchase_price'      => $row['base_purchase_price'],

                    'tax'                 => $row['base_purchase_tax'],

                    'cogs'                => $row['base_cogs'],


                ];

            }

            $result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];

        }

        resultJSON($result);
    }


    public function tempadd(){

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'temp_sales_admin_id'              => $this->request->getPost('temp_sales_admin_id'),
            'item_id'                          => $this->request->getPost('item_id'),
            'temp_qty'                         => $this->request->getPost('temp_qty'),
            'temp_purchase_price'              => $this->request->getPost('temp_purchase_price'),
            'temp_purchase_tax'                => $this->request->getPost('temp_purchase_tax'),
            'temp_purchase_cogs'               => $this->request->getPost('temp_purchase_cogs'),
            'temp_product_price'               => $this->request->getPost('temp_price'),
            'temp_disc1'                       => $this->request->getPost('temp_discount1'),
            'temp_price_disc1_percentage'      => $this->request->getPost('temp_discount_percentage1'),
            'temp_disc2'                       => $this->request->getPost('temp_discount2'),
            'temp_price_disc2_percentage'      => $this->request->getPost('temp_discount_percentage2'),
            'temp_disc3'                       => $this->request->getPost('temp_discount3'),
            'temp_price_disc3_percentage'      => $this->request->getPost('temp_discount_percentage3'),
            'temp_sales_price'                 => $this->request->getPost('temp_total'),
        ];



        $validation->setRules([
            'temp_sales_price' => ['rules' => 'required|greater_than[0]'],
            'temp_qty'         => ['rules' => 'required|greater_than[0]'],
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            $input['user_id'] = $this->userLogin['user_id'];

            $save = $this->M_salesmanadmin->insertTemp($input);

            if ($save) {

                if($this->request->getPost('temp_po_id') == null){

                    $result = ['success' => TRUE, 'message' => 'Data item berhasil ditambahkan'];

                }else{

                    $result = ['success' => TRUE, 'message' => 'Data item berhasil Diubah'];

                }

            } else {

                $result = ['success' => FALSE, 'message' => 'Data item gagal ditambahkan'];

            }

        }

        $getTemp = $this->M_salesmanadmin->getTemp($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);
    }

    public function deleteTemp($temp_sales_admin_id  = '')
    {
    //$this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('sales_admin.delete')) {
            if ($temp_sales_admin_id != '') {
                $delete = $this->M_salesmanadmin->deletetemp($temp_sales_admin_id );
                if ($delete) {
                    $getTemp = $this->M_salesmanadmin->getTemp($this->userLogin['user_id'])->getResultArray();
                    $find_result = [];
                    foreach ($getTemp as $k => $v) {
                        $find_result[$k] = esc($v);
                    }
                    $result['data'] = $find_result;
                    $result['csrfHash'] = csrf_hash();
                    $result['success'] = 'TRUE';
                    $result['message'] = 'Data Berhasil Di Hapus';
                } else {
                    $result = ['success' => FALSE, 'message' => 'Data Gagal Di Hapus'];
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus data ini'];
        }
        resultJSON($result);
    }

    public function getSalesadminTemp()
    {

        $getTemp = $this->M_salesmanadmin->getTemp($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);

    }

    public function getSalesadminFooter()
    {
        $getTemp = $this->M_salesmanadmin->getSalesadminFooter($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);
    }

    public function save($type = '')
    {
        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'sales_customer_id'               => $this->request->getPost('sales_customer_id'),
            'sales_salesman_id'               => $this->request->getPost('sales_salesman_id'),
            'sales_payment_type'              => $this->request->getPost('sales_payment_type'),
            'sales_due_date'                  => $this->request->getPost('sales_due_date'),
            'sales_date'                      => $this->request->getPost('sales_date'),
            'sales_store_id'                  => $this->request->getPost('sales_store_id'),
            'sales_admin_remark'              => $this->request->getPost('sales_admin_remark'),
            'sales_admin_subtotal'            => $this->request->getPost('sales_admin_sub_total'),
            'sales_admin_discount1'           => $this->request->getPost('sales_admin_discount1'),
            'sales_admin_discount2'           => $this->request->getPost('sales_admin_discount2'),
            'sales_admin_discount3'           => $this->request->getPost('sales_admin_discount3'),
            'sales_admin_discount1_percentage'=> $this->request->getPost('sales_admin_discount1_percentage'),
            'sales_admin_discount2_percentage'=> $this->request->getPost('sales_admin_discount2_percentage'),
            'sales_admin_discount3_percentage'=> $this->request->getPost('sales_admin_discount3_percentage'),
            'sales_admin_total_discount'      => $this->request->getPost('sales_admin_total_discount'),
            'sales_admin_ppn'                 => $this->request->getPost('sales_admin_ppn'),
            'sales_admin_down_payment'        => $this->request->getPost('sales_admin_down_payment'),
            'sales_admin_remaining_payment'   => $this->request->getPost('sales_admin_remaining_payment'),
            'sales_admin_grand_total'         => $this->request->getPost('sales_admin_total')
        ];

        $validation->setRules([
            'sales_admin_remark'          => ['rules' => 'max_length[500]']
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            if ($type == 'add') {

                if ($this->role->hasRole('sales_admin.add')) {

                    $input['user_id']= $this->userLogin['user_id'];

                    $save = $this->M_salesmanadmin->insertsalesadmin($input);

                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data Penjualan berhasil disimpan', 'sales_admin_id ' => $save['sales_admin_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data Penjualan gagal disimpan'];

                    }

                } else {

                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah Penjualan'];

                }

            }else if ($type == 'edit') {

                if ($this->role->hasRole('sales_admin.edit')) {

                    $input['user_id']                 = $this->userLogin['user_id'];
                    $input['sales_admin_id']          = $this->request->getPost('sales_admin_id');
                    $input['sales_admin_invoice']     = $this->request->getPost('sales_admin_invoice');
                    $input['created_at']              = $this->request->getPost('sales_date');
                    $input['updated_at']              = date("Y/m/d");

                    $save = $this->M_salesmanadmin->updatesalesmanadmin($input);
              
                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data pesanan berhasil diperbarui', 'sales_admin' => $save['sales_admin_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data pesanan gagal diperbarui'];

                    }

                } else {

                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah pesanan pembelian'];

                }

            }
        }

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);
    }

    public function getSalesAdminDetail($sales_admin_id)
    {
        if ($sales_admin_id == '') {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $getOrder =  $this->M_salesmanadmin->getOrder($sales_admin_id)->getRowArray();

            if ($getOrder == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $data = [

                    'hdSales' => $getOrder,

                    'dtSales' => $this->M_salesmanadmin->getDtSalesmanOrder($sales_admin_id)->getResultArray(),

                ]; 

                return view('webmin/sales/salesmanadmin_detail', $data);

            }

        }
    }

    public function printinvoice($sales_admin_id)
    {
        $export = $this->request->getGet('export');
        if ($export == 'pdf') {
            $htmlView   = $this->renderView('sales/salesadmin_invoice');
            $dompdf = new Dompdf();
            $dompdf->loadHtml($htmlView);
            $dompdf->setPaper('half-letter', 'landscape');
            $dompdf->render();
            $dompdf->stream('invoice.pdf', array("Attachment" => false));
            exit();
        } else {
            if ($sales_admin_id == '') {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $getOrder =  $this->M_salesmanadmin->getOrder($sales_admin_id)->getRowArray();

                if ($getOrder == NULL) {

                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

                } else {

                    $data = [

                        'hdSales' => $getOrder,

                        'dtSales' => $this->M_salesmanadmin->getDtSalesmanOrder($sales_admin_id)->getResultArray(),

                    ]; 

                    return view('webmin/sales/salesadmin_invoice', $data);

                }

            }
        }
    }

    public function printdispatch($sales_admin_id)
    {
        if ($sales_admin_id == '') {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $getOrder =  $this->M_salesmanadmin->getOrder($sales_admin_id)->getRowArray();
            $detail   = $this->M_salesmanadmin->getDtSalesmanOrder($sales_admin_id)->getResultArray();
            $max_item   = 6;
            $pages      = array_chunk($detail, $max_item);

            if ($getOrder == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $data = [
                    'title'     => 'Surat Jalan',
                    'header'    => $getOrder,
                    'pages'     => $pages,
                    'agent'     => $this->request->getUserAgent()
                ]; 

                return view('webmin/sales/salesadmin_dispatch', $data);

            }

        }
    }

    public function editSalesadmin($sales_admin_id = '')
    {
        $this->validationRequest(TRUE, 'GET');

        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah penjualan'];

        if ($this->role->hasRole('sales_admin.edit')) {

            $getOrder = $this->M_salesmanadmin->getOrder($sales_admin_id)->getRowArray();

            if ($getOrder == NULL) {

                $result = ['success' => FALSE, 'message' => 'Transaksi tidak ditemukan'];

            } else {

                $sales_admin_invoice = $getOrder['sales_admin_invoice'];

                $datacopy = [
                    'user_id'                       => $this->userLogin['user_id'],
                    'sales_admin_id'                => $sales_admin_id
                ];

                $getTemp = $this->M_salesmanadmin->copyDtSalesToTemp($datacopy)->getResultArray();


                $find_result = [];

                foreach ($getTemp as $k => $v) {

                    $find_result[$k] = esc($v);

                }

                $result = ['success' => TRUE, 'header' => $getOrder, 'data' => $find_result, 'message' => ''];


            }

        }
        $result['csrfHash'] = csrf_hash();
        
        resultJSON($result);
    }

    public function import_excell()
    {  
        if (isset($_FILES["fileExcel"]["name"])) {
            $path = $_FILES["fileExcel"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach($object->getWorksheetIterator() as $worksheet)
            {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();    
                for($row=2; $row<=$highestRow; $row++)
                {
                    $nama = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $jurusan = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $angkatan = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $temp_data[] = array(
                        'nama'  => $nama,
                        'jurusan'   => $jurusan,
                        'angkatan'  => $angkatan
                    );  

                    print_r($temp_data);die();
                }
            }
            $this->load->model('ImportModel');
            $insert = $this->ImportModel->insert($temp_data);
            if($insert){
                $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-ok"></span> Data Berhasil di Import ke Database');
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            echo "Tidak ada file yang masuk";
        }
    }


    public function downloadEFaktur()
    {

        $id = $this->request->getGet('id');

        $getHdData = $this->M_salesmanadmin->getOrderEfaktur($id)->getRowArray();
        $getDtData = $this->M_salesmanadmin->getDtSalesmanOrder($id)->getResultArray();

        if($getHdData != null){
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

            $template = WRITEPATH . '/template/template_e_faktur.csv';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template);

            $sheet = $spreadsheet->setActiveSheetIndex(0);
            $iRow = 6;

            $total_dpp = floatval($getHdData['sales_admin_grand_total'] - $getHdData['sales_admin_ppn']);
            $total_ppn = floatval($getHdData['sales_admin_ppn']);
            $dp = floatval($getHdData['sales_admin_down_payment']);
            $dp_ppn = floatval($getHdData['sales_admin_down_payment'] * 0.11);
            $dp_dpp = floatval($getHdData['sales_admin_down_payment'] - $dp_ppn);
            $trx_date = indo_short_date($getHdData['sales_date']);

            $sheet->getCell('A4')->setValue('FK');
            $sheet->getCell('B4')->setValue('1');
            $sheet->getCell('C4')->setValue('0');
            $sheet->getCell('D4')->setValue('72237067201');
            $sheet->getCell('E4')->setValue('9');
            $sheet->getCell('F4')->setValue('2022');
            $sheet->getCell('G4')->setValue('FK');
            $sheet->getCell('H4')->setValue($trx_date);
            $sheet->getCell('I4')->setValue(esc($getHdData['customer_npwp']));
            $sheet->getCell('J4')->setValue($getHdData['customer_name']);
            $sheet->getCell('K4')->setValue($getHdData['customer_address']);
            $sheet->getCell('L4')->setValue($total_dpp);
            $sheet->getCell('M4')->setValue($total_ppn);
            $sheet->getCell('N4')->setValue('0');
            $sheet->getCell('O4')->setValue('');
            $sheet->getCell('P4')->setValue($total_dpp);
            $sheet->getCell('Q4')->setValue($total_ppn);
            $sheet->getCell('R4')->setValue('0');
            $sheet->getCell('S4')->setValue('');

            $sheet->getCell('A5')->setValue('LT');
            $sheet->getCell('B5')->setValue($getHdData['customer_npwp']);
            $sheet->getCell('C5')->setValue($getHdData['customer_name']);
            $sheet->getCell('D5')->setValue($getHdData['customer_address']);
            $sheet->getCell('E5')->setValue($getHdData['customer_address_block']);
            $sheet->getCell('F5')->setValue($getHdData['customer_address_number']);
            $sheet->getCell('G5')->setValue($getHdData['customer_address_rt']);
            $sheet->getCell('H5')->setValue($getHdData['customer_address_rw']);
            $sheet->getCell('I5')->setValue($getHdData['dis_name']);
            $sheet->getCell('J5')->setValue($getHdData['subdis_name']);
            $sheet->getCell('K5')->setValue($getHdData['city_name']);
            $sheet->getCell('L5')->setValue($getHdData['prov_name']);
            $sheet->getCell('M5')->setValue($getHdData['postal_code']);
            $sheet->getCell('N5')->setValue($getHdData['customer_phone']);

            foreach ($getDtData as $row) {
                $base_price  = floatval($row['dt_sales_price'] / $row['dt_temp_qty']);
                $qty = floatval($row['dt_temp_qty']);
                $sales_price = floatval($row['dt_sales_price']);
                $discount = floatval($row['dt_total_discount']);
                $dpp = floatval($row['dt_total_dpp']);
                $ppn = floatval($row['dt_total_dpp']);
                $tarif_ppnbm = floatval(0);
                $ppnbm = floatval(0);
                $sheet->getCell('A' . $iRow)->setValue('OF');
                $sheet->getCell('B' . $iRow)->setValue($row['item_code']);
                $sheet->getCell('C' . $iRow)->setValue($row['product_name'].'-'.$row['unit_name']);
                $sheet->getCell('D' . $iRow)->setValue($base_price, TRUE);
                $sheet->getCell('E' . $iRow)->setValue($qty, TRUE);
                $sheet->getCell('F' . $iRow)->setValue($sales_price, TRUE);
                $sheet->getCell('G' . $iRow)->setValue($discount, TRUE);
                $sheet->getCell('H' . $iRow)->setValue($dpp, TRUE);
                $sheet->getCell('I' . $iRow)->setValue($ppn, TRUE);
                $sheet->getCell('J' . $iRow)->setValue($tarif_ppnbm, TRUE);
                $sheet->getCell('K' . $iRow)->setValue($ppnbm, TRUE);

                $iRow++;
            }
                //setting periode

            $filename = 'E-Faktur Pajak';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Csv');
            $writer->save('php://output');
            exit();
        }else{
            $result = ['success' => FALSE, 'message' => 'Silahkan Isi Data Maping Terleih Dahulu Di Customer'];
            print_r($result);die();
        }
    }
    //--------------------------------------------------------------------

}
