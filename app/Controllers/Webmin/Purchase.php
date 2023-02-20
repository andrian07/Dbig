<?php


namespace App\Controllers\Webmin;

use Dompdf\Dompdf;
use App\Models\M_purchase;
use App\Controllers\Base\WebminController;

class Purchase extends WebminController
{

    protected $M_purchase;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_purchase = new M_purchase;
    }

    public function index()
    {
        $data = [
            'title'         => 'Purchase' 
        ];
        return $this->renderView('purchase/purchase', $data);
    }

    public function returpurchase()
    {
        return $this->renderView('purchase/returpurchase');
    }

    public function tblpurchase()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('purchase.view')) {
            helper('datatable');

            $table = new \App\Libraries\Datatables('hd_purchase');
            $table->db->select('purchase_id,purchase_invoice,purchase_date,supplier_name,purchase_suplier_no,purchase_total_ongkir,purchase_total_ppn,purchase_remaining_debt,purchase_total');
            $table->db->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase.purchase_supplier_id');
            $table->db->orderBy('hd_purchase.created_at', 'desc');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['purchase_invoice']);
                $column[] = indo_short_date($row['purchase_date']);
                if($row['purchase_total_ppn'] > 0){
                    $column[] = '<span class="badge badge-warning">BKP</span>';
                }else{
                    $column[] = '<span class="badge badge-primary">Non BKP</span>';
                }
                if($row['purchase_remaining_debt'] > 0){
                    $column[] = '<span class="badge badge-danger">Belum Lunas</span>';
                }else{
                    $column[] = '<span class="badge badge-success">Lunas</span>';
                }
                $column[] = esc($row['supplier_name']);
                $column[] = esc($row['purchase_suplier_no']);
                $column[] = 'Rp. '.esc(number_format($row['purchase_total']));
                $btns = [];
                $prop =  'data-id="' . $row['purchase_id'] . '" data-name="' . esc($row['purchase_invoice']) . '"';
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/purchase/get-purchase-detail/'.$row['purchase_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'purchase_invoice', 'purchase_date','',''];
            $table->searchColumn = ['purchase_invoice', 'purchase_date'];
            $table->generate();
        }
    }

    public function copyPurchaseOrder($purchase_order_id = '')
    {

        $this->validationRequest(TRUE, 'GET');

        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah transaksi pesanan pembelian'];

        if ($this->role->hasRole('purchase.add')) {

            $M_purchase_order = model('M_purchase_order');

            $getOrder = $M_purchase_order->getOrder($purchase_order_id)->getRowArray();
           // print_r($getOrder);die();

            if ($getOrder == NULL) {

                $result = ['success' => FALSE, 'message' => 'Transaksi dengan id invoice <b>' . $purchase_order_id . '</b> tidak ditemukan'];

            } else {

                $find_result = [];

                $user_id = $this->userLogin['user_id'];

                if ($getOrder['purchase_order_status'] == 'Pending') {

                    $datacopy = [
                        'user_id'                           => $getOrder['purchase_order_user_id'],
                        'supplier_id'                       => $getOrder['purchase_order_supplier_id'],
                        'supplier_name'                     => $getOrder['supplier_name'],
                        'purchase_order_id'                 => $getOrder['purchase_order_id'],
                        'purchase_order_invoice'            => $getOrder['purchase_order_invoice'],

                    ];

                    $getTemp = $this->M_purchase->copyDtOrderToTemp($datacopy)->getResultArray();

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

    }

    public function getPurchaseDetail($purchase_id = ''){
        if ($purchase_id == '') {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $getOrder =  $this->M_purchase->getPurchase($purchase_id)->getRowArray();

            if ($getOrder == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $invoice_num = $getOrder['purchase_invoice'];

                $data = [

                    'hdPurchase' => $getOrder,

                    'dtPurchase' => $this->M_purchase->getDtPurchase($invoice_num)->getResultArray(),

                ];

                return view('webmin/purchase/purchase_detail', $data);

            }

        }

    }

    public function tempadd(){

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'temp_purchase_id'                      => $this->request->getPost('temp_purchase_id'),
            'temp_purchase_po_id'                   => $this->request->getPost('temp_po_submission_id'),
            'temp_purchase_po_invoice'              => $this->request->getPost('temp_po_submission_id'),
            'temp_purchase_item_id'                 => $this->request->getPost('item_id'),
            'temp_purchase_qty'                     => $this->request->getPost('temp_qty'),
            'temp_purchase_ppn'                     => $this->request->getPost('temp_tax'),
            'temp_purchase_dpp'                     => $this->request->getPost('temp_dpp'),
            'temp_purchase_price'                   => $this->request->getPost('temp_price'),
            'temp_purchase_discount1'               => $this->request->getPost('temp_discount1'),
            'temp_purchase_discount1_percentage'    => $this->request->getPost('temp_discount_percentage1'),
            'temp_purchase_discount2'               => $this->request->getPost('temp_discount2'),
            'temp_purchase_discount2_percentage'    => $this->request->getPost('temp_discount_percentage2'),
            'temp_purchase_discount3'               => $this->request->getPost('temp_discount3'),
            'temp_purchase_discount3_percentage'    => $this->request->getPost('temp_discount_percentage3'),
            'temp_purchase_discount_total'          => $this->request->getPost('total_temp_discount'),
            'temp_purchase_ongkir'                  => $this->request->getPost('temp_ongkir'),
            'temp_purchase_expire_date'             => $this->request->getPost('temp_ed_date'),
            'temp_purchase_total'                   => $this->request->getPost('temp_total'),
            'temp_purchase_supplier_id'             => $this->request->getPost('temp_purchase_suplier_id'),
            'temp_purchase_supplier_name'           => $this->request->getPost('temp_purchase_suplier_name')
        ];

        $validation->setRules([
            'temp_purchase_item_id'       => ['rules' => 'required'],
            'temp_purchase_qty'           => ['rules' => 'required|greater_than[0]'],
            'temp_purchase_price'         => ['rules' => 'required|greater_than[0]'],
            'temp_purchase_ppn'           => ['rules' => 'required'],
            'temp_purchase_dpp'           => ['rules' => 'required'],
            'temp_purchase_price'         => ['rules' => 'required'],
            'temp_purchase_ongkir'        => ['rules' => 'required'],
            'temp_purchase_total'         => ['rules' => 'required'],
        ]);


        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            $input['temp_purchase_user_id'] = $this->userLogin['user_id'];


            $save = $this->M_purchase->insertTemp($input);

            if ($save) {

                if($this->request->getPost('temp_purchase_id') == null){

                    $result = ['success' => TRUE, 'message' => 'Data item berhasil ditambahkan'];

                }else{

                    $result = ['success' => TRUE, 'message' => 'Data item berhasil Diubah'];

                }

            } else {

                $result = ['success' => FALSE, 'message' => 'Data item gagal ditambahkan'];

            }

        }

        $getTemp = $this->M_purchase->getTemp($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);
    }

    public function save($type)
    {

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'purchase_po_invoice'                       => $this->request->getPost('purchase_po_invoice'),
            'purchase_suplier_no'                       => $this->request->getPost('purchase_suplier_no'),
            'purchase_date'                             => $this->request->getPost('purchase_date'),
            'purchase_faktur_date'                      => $this->request->getPost('purchase_faktur_date'),
            'purchase_supplier_id'                      => $this->request->getPost('purchase_supplier_id'),
            'purchase_warehouse_id'                     => $this->request->getPost('purchase_warehouse_id'),
            'purchase_remark'                           => $this->request->getPost('purchase_remark'),
            'purchase_sub_total'                        => $this->request->getPost('purchase_sub_total'),
            'purchase_discount1'                        => $this->request->getPost('purchase_discount1'),
            'purchase_discount1_percentage'             => $this->request->getPost('purchase_discount1_percentage'),
            'purchase_discount2'                        => $this->request->getPost('purchase_discount2'),
            'purchase_discount2_percentage'             => $this->request->getPost('purchase_discount2_percentage'),
            'purchase_discount3'                        => $this->request->getPost('purchase_discount3'),
            'purchase_discount3_percentage'             => $this->request->getPost('purchase_discount3_percentage'),
            'purchase_total_discount'                   => $this->request->getPost('purchase_total_discount'),
            'purchase_total_dpp'                        => $this->request->getPost('purchase_total_dpp'),
            'purchase_total_ppn'                        => $this->request->getPost('purchase_total_ppn'),
            'purchase_total_ongkir'                     => $this->request->getPost('purchase_total_ongkir'),
            'purchase_total'                            => $this->request->getPost('purchase_total'),
            'purchase_due_date'                         => $this->request->getPost('purchase_due_date'),
            'purchase_payment_method_id'                => $this->request->getPost('purchase_payment_method_id'),
            'purchase_down_payment'                     => $this->request->getPost('purchase_down_payment'),
            'purchase_remaining_debt'                   => $this->request->getPost('purchase_remaining_debt'),
        ];

        $validation->setRules([
            'purchase_faktur_date'            => ['rules' => 'required'],
            'purchase_supplier_id'            => ['rules' => 'required'],
            'purchase_warehouse_id'           => ['rules' => 'required'],
            'purchase_remark'                 => ['rules' => 'max_length[500]']
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Silahkan Input Semua Data Terlebih Dahulu'];

        } else {

            if ($this->role->hasRole('purchase.add')) {

                $input['purchase_user_id']= $this->userLogin['user_id'];

                //$checkEd = $this->M_purchase->checkEd($this->userLogin['user_id'])->getResultArray();


                $save = $this->M_purchase->insertPurchase($input);

                if ($save['success']) {

                    $result = ['success' => TRUE, 'message' => 'Data Pembelian berhasil disimpan', 'purchase_id ' => $save['purchase_id']];

                } else {

                    $result = ['success' => FALSE, 'message' => 'Data Pembelian gagal disimpan'];

                }

            } else {

                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah pembelian'];

            }

        }

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);

    }


    public function deleteTemp($temp_purchase_id = '')
    {
        //$this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        if ($this->role->hasRole('purchase.delete')) {

            if ($temp_purchase_id != '') {

                $delete = $this->M_purchase->deletetemp($temp_purchase_id);

                if ($delete) {

                    $getTemp = $this->M_purchase->getTemp($this->userLogin['user_id'])->getResultArray();

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

    public function clearTemp()
    {
        $this->M_purchase->clearTemp($this->userLogin['user_id']);

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);
    }

    public function getPurchaseTemp(){

        $getTemp = $this->M_purchase->getTemp($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);

    }

    public function getPurchaseFooter(){

        $getFooter = $this->M_purchase->getFooter($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getFooter as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);

    }

    public function getTax(){

        $getTax = $this->M_purchase->getTax($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTax as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);

    }

    public function searchPurchaseBysuplier()
    {

        $this->validationRequest(TRUE, 'GET');

        $supplier = $this->request->getGet('sup');

        $keyword = $this->request->getGet('term');

        if($supplier == 'null'){

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Isi Nama Supplier Terlebih Dahulu'];

        }else{

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];

            if (!($keyword == '' || $keyword == NULL)) {

                $find = $this->M_purchase->searchPurchaseBysuplier($keyword, $supplier)->getResultArray(); 

                $find_result = [];

                foreach ($find as $row) {

                    $diplay_text = $row['purchase_id'];

                    $find_result[] = [

                        'id'                  => $diplay_text,

                        'value'               => $row['purchase_invoice']

                    ];

                }

                $result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];

            }
        }

        resultJSON($result);
    }

    public function searchProductByInvoice()
    {

        $this->validationRequest(TRUE, 'GET');

        $purchaseno = $this->request->getGet('purchase_no');

        $keyword = $this->request->getGet('term');

        if($purchaseno == 'null'){

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Isi No Invoice Pembelian Terlebih Dahulu'];

        }else{

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];

            if (!($keyword == '' || $keyword == NULL)) {

                $find = $this->M_purchase->searchProductByInvoice($keyword, $purchaseno)->getResultArray(); 

                $find_result = [];

                foreach ($find as $row) {

                    $diplay_text = $row['product_name'];

                    $find_result[] = [

                        'id'                  => $diplay_text,

                        'value'               => $diplay_text.'('.$row['unit_name'].')',

                        'item_id'             => $row['item_id'],

                        'purchase_qty'        => $row['dt_purchase_qty'],

                        'purchase_price'      => $row['dt_purchase_price'],

                        'purchase_total'      => $row['dt_purchase_total'],

                        'purchase_ppn'        => $row['dt_purchase_ppn'],

                        'dt_purchase_qty'     => $row['dt_purchase_qty'],

                        'warehouse_id'        => $row['warehouse_id'],

                        'warehouse_name'      => $row['warehouse_name'],

                    ];

                }

                $result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];

            }
        }

        resultJSON($result);
    }


    //--------------------------------------------------------------------

}
