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

                    $input['user_id']            = $this->userLogin['user_id'];

                    $input['sales_admin_id']     = $this->request->getPost('sales_admin_id');

                    $save = $this->M_salesmanadmin->updatesalesmanadmin($input);

                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data pesanan berhasil diperbarui', 'purchase_order_id' => $save['purchase_order_id']];

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

            if ($getOrder == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $data = [

                    'hdSales' => $getOrder,

                    'dtSales' => $this->M_salesmanadmin->getDtSalesmanOrder($sales_admin_id)->getResultArray(),

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
        if (isset($_FILES["excell"]["name"])) {
            $path = $_FILES["excell"]["tmp_name"];
            $object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
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
    //--------------------------------------------------------------------

}
