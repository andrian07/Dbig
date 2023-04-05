<?php


namespace App\Controllers\Webmin\Retur;

use Dompdf\Dompdf;
use App\Models\M_retur;
use App\Controllers\Base\WebminController;


class Retur extends WebminController
{

    protected $M_retur;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_retur = new M_retur;
    }

    public function index()
    {
        return $this->renderView('purchase/returpurchase');
    }

    public function tblreturpurchase()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('retur_purchase.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('hd_retur_purchase');
            $table->db->select('hd_retur_purchase_id,hd_retur_purchase_invoice,hd_retur_date,supplier_name,hd_retur_total_transaction,hd_retur_status');
            $table->db->join('ms_supplier', 'ms_supplier.supplier_id  = hd_retur_purchase.hd_retur_supplier_id');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['hd_retur_purchase_invoice']);
                $column[] = indo_short_date($row['hd_retur_date']);
                $column[] = esc($row['supplier_name']);
                $column[] = 'Rp. '.esc(number_format($row['hd_retur_total_transaction']));
                if($row['hd_retur_status'] == 'Selesai'){
                    $column[] = '<span class="badge badge-success">Selesai</span>';
                }else if($row['hd_retur_status'] == 'Pending'){
                    $column[] = '<span class="badge badge-primary">Pending</span>';
                }else{
                    $column[] = '<span class="badge badge-danger">Batal</span>';
                }

                $btns  = [];
                $prop  =  'data-id="' . $row['hd_retur_purchase_id'] . '" data-name="' . esc($row['hd_retur_purchase_invoice']) . '"';
                $prop2 =  'data-id="' . $row['hd_retur_purchase_id'] . '" data-name="' . esc($row['hd_retur_purchase_invoice']) . '"';
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/retur/get-retur-detail/'.$row['hd_retur_purchase_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $btns[] = '<button ' . $prop2 . ' class="btn btn-sm btn-success btnrepayment" data-toggle="tooltip" data-placement="top" data-title="Payment"><i class="fas fa-money-bill-wave"></i></button>';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $btns[] = button_print($prop);
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'hd_retur_purchase_invoice', 'hd_retur_date','',''];
            $table->searchColumn = ['hd_retur_purchase_invoice', 'hd_retur_date'];
            $table->generate();
        }
    }


    public function getReturDetail($hd_retur_purchase_id = ''){
        if ($hd_retur_purchase_id == '') {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $getOrder =  $this->M_retur->getRetur($hd_retur_purchase_id)->getRowArray();

            if ($getOrder == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $data = [

                    'hdRetur' => $getOrder,

                    'dtRetur' => $this->M_retur->getDtRetur($hd_retur_purchase_id)->getResultArray(),

                ];

                return view('webmin/purchase/retur_purchase_detail', $data);

            }

        }

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

                $find = $this->M_retur->searchPurchaseBysuplier($keyword, $supplier)->getResultArray(); 

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

                $find = $this->M_retur->searchProductByInvoice($keyword, $purchaseno)->getResultArray(); 

                $find_result = [];

                foreach ($find as $row) {

                    $diplay_text                = $row['product_name'];

                    $purchase_dpp               = round(($row['dt_purchase_dpp'] / $row['dt_purchase_qty']), 2);

                    $purchase_discount          = round(($row['dt_purchase_discount_total'] / $row['dt_purchase_qty']), 2);

                    $purchase_discount_nota     = round(($row['dt_purchase_dicount_nota'] / $row['dt_purchase_qty']), 2);

                    $purchase_ppn               = round(($row['dt_purchase_ppn'] / $row['dt_purchase_qty']), 2);

                    $purchase_ongkir            = round(($row['dt_purchase_ongkir'] / $row['dt_purchase_qty']), 2);

                    $purchase_price             = round(($purchase_dpp + $purchase_ppn + $purchase_ongkir), 2);

                    $find_result[] = [

                        'id'                    => $diplay_text,

                        'value'                 => $diplay_text.'('.$row['unit_name'].')',

                        'item_id'               => $row['item_id'],

                        'purchase_qty'          => $row['dt_purchase_qty'],

                        'purchase_dpp'           => $purchase_dpp,

                        'purchase_price'        => $purchase_price,

                        'purchase_discount'     => $purchase_discount,

                        'purchase_discount_nota'=> $purchase_discount_nota,

                        'purchase_ongkir'       => $purchase_ongkir,

                        'purchase_total'        => $row['dt_purchase_total'],

                        'purchase_ppn'          => $purchase_ppn,

                        'dt_purchase_qty'       => $row['dt_purchase_qty'],

                        'warehouse_id'          => $row['warehouse_id'],

                        'warehouse_name'        => $row['warehouse_name'],

                    ];

                }

                $result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];

            }
        }

        resultJSON($result);
    }

    public function tempadd(){

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'retur_purchase_invoice'   => $this->request->getPost('retur_invoice_no'),
            'retur_supplier_id'        => $this->request->getPost('retur_supplier_id'),
            'retur_supplier_name'      => $this->request->getPost('retur_supplier_name'),
            'retur_item_id'            => $this->request->getPost('retur_item_id'),
            'retur_price'              => $this->request->getPost('retur_price'),
            'retur_ppn'                => $this->request->getPost('retur_ppn'),
            'retur_dpp'                => $this->request->getPost('retur_dpp'),
            'retur_disc'               => $this->request->getPost('retur_disc'),
            'retur_disc_nota'          => $this->request->getPost('retur_disc_nota'),
            'retur_ongkir'             => $this->request->getPost('retur_ongkir'),
            'retur_warehouse'          => $this->request->getPost('retur_warehouse'),
            'retur_qty_buy'            => $this->request->getPost('retur_qty_buy'),
            'retur_qty'                => $this->request->getPost('retur_qty'),
            'retur_total'              => $this->request->getPost('retur_total'),
        ];


        $validation->setRules([
            'retur_purchase_invoice'  => ['rules' => 'required'],
            'retur_supplier_id'       => ['rules' => 'required'],
            'retur_supplier_name'     => ['rules' => 'required'],
            'retur_item_id'           => ['rules' => 'required'],
            'retur_price'             => ['rules' => 'required'],
            'retur_ppn'               => ['rules' => 'required'],
            'retur_warehouse'         => ['rules' => 'required'],
            'retur_qty_buy'           => ['rules' => 'required|greater_than[0]'],
            'retur_qty'               => ['rules' => 'required|greater_than[0]'],
            'retur_total'             => ['rules' => 'required'],
        ]);


        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {      

            $input['retur_user_id'] = $this->userLogin['user_id'];

            $getReturCheck = $this->M_retur->getReturCheck($input['retur_purchase_invoice'], $input['retur_item_id'])->getResultArray();

            if($getReturCheck == null){
                $dt_retur_qty = 0;
            }else{
                $dt_retur_qty = floatval($getReturCheck[0]['dt_retur_qty']);
            }

            $qty_total = $dt_retur_qty + $input['retur_qty'];

            if($input['retur_qty_buy'] < $qty_total)
            {
                $result = ['success' => FALSE, 'message' => 'Item Retur Melebihi Qty Beli'];

            }else{

                $save = $this->M_retur->insertTemp($input);

                if ($save) {

                    $result = ['success' => TRUE, 'message' => 'Data item berhasil ditambahkan'];

                } else {

                    $result = ['success' => FALSE, 'message' => 'Data item gagal ditambahkan'];

                }
            }

        }

        $getTemp = $this->M_retur->getTemp($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);
    }


    public function getById($hd_retur_purchase_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data tidak ditemukan'];
        if ($this->role->hasRole('retur_purchase.view')) {
            if ($hd_retur_purchase_id != '') {
                $find = $this->M_retur->getRetur($hd_retur_purchase_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => FALSE, 'message' => 'Data Pembelian Tidak Di Temukan'];
                } else {
                    $result = ['success' => TRUE, 'data' => $find, 'message' => ''];
                }
            }
        }

        resultJSON($result);
    }

    public function save($type)
    {
        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'hd_retur_date'                       => $this->request->getPost('hd_retur_date'),
            'hd_retur_supplier_id'                => $this->request->getPost('hd_retur_supplier_id'),
            'hd_retur_total_transaction'          => $this->request->getPost('hd_retur_total_transaction'),
            'hd_retur_desc'                       => $this->request->getPost('hd_retur_desc')
        ];

        $validation->setRules([
            'hd_retur_date'                   => ['rules' => 'required'],
            'hd_retur_supplier_id'            => ['rules' => 'required'],
            'hd_retur_total_transaction'      => ['rules' => 'required'],
            'hd_retur_desc'                   => ['rules' => 'max_length[500]']
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Silahkan Input Semua Data Terlebih Dahulu'];

        } else {

            if ($type == 'add') {

                if ($this->role->hasRole('retur_purchase.add')) {

                    $input['created_by']= $this->userLogin['user_id'];

                    $save = $this->M_retur->insertRetur($input);

                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data Retur berhasil disimpan', 'hd_retur_purchase_id ' => $save['hd_retur_purchase_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data Retur gagal disimpan'];

                    }

                } else {

                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah retur'];

                }

            } else if ($type == 'edit') {

                if ($this->role->hasRole('retur_purchase.edit')) {

                    $input['created_by']       = $this->userLogin['user_id'];

                    $getOrder = $this->M_retur->getRetur($hd_retur_purchase_id)->getRowArray();

                    $save = $this->M_retur->updateOrder($input);

                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data Retur berhasil diperbarui', 'hd_retur_purchase_id' => $save['hd_retur_purchase_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data Retur gagal diperbarui'];

                    }

                } else {

                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah retur'];

                }

            }

            $result['csrfHash'] = csrf_hash();

            resultJSON($result);
        }

    }

    public function savepayment()
    {

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'hd_retur_purchase_id'                => $this->request->getPost('hd_retur_purchase_id'),
            'payment_type'                        => $this->request->getPost('payment_type'),
            'hd_retur_total_transaction'          => $this->request->getPost('hd_retur_total_transaction')
        ];

        $validation->setRules([
            'hd_retur_purchase_id'            => ['rules' => 'required'],
            'payment_type'                    => ['rules' => 'required'],
            'hd_retur_total_transaction'      => ['rules' => 'required'],
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Silahkan Input Semua Data Terlebih Dahulu'];

        } else {

            if ($this->role->hasRole('retur_purchase.update_payment')) {

                $save = $this->M_retur->updateRetur($input);

                if ($save['success']) {

                    $result = ['success' => TRUE, 'message' => 'Data pembayaran retur berhasil disimpan', 'hd_retur_purchase_id ' => $save['hd_retur_purchase_id']];

                } else {

                    $result = ['success' => FALSE, 'message' => 'Data pembayaran retur gagal disimpan'];

                }

            } else {

                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah pembayaran retur'];

            }

        }

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);

    }


    public function getReturTemp(){

        $getTemp = $this->M_retur->getTemp($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);

    }

    public function getReturFooter()
    {
        $getFooter = $this->M_retur->getFooter($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getFooter as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);
    }


    public function deleteTemp($retur_item_id = '')
    {
        //$this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        if ($retur_item_id != '') {

            $user_id = $this->userLogin['user_id'];

            $delete = $this->M_retur->deletetemp($retur_item_id, $user_id );

            if ($delete) {

                $getTemp = $this->M_retur->getTemp($this->userLogin['user_id'])->getResultArray();

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
        resultJSON($result);
    }


    public function editReturPurchase($hd_retur_purchase_id = '')
    {

        $this->validationRequest(TRUE, 'GET');

        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah retur pembelian'];

        if ($this->role->hasRole('retur_purchase.edit')) {

            $getOrder = $this->M_retur->getRetur($hd_retur_purchase_id)->getRowArray();

            if ($getOrder == NULL) {

                $result = ['success' => FALSE, 'message' => 'Transaksi tidak ditemukan'];

            } else {

                $datacopy = [
                    'retur_user_id'         => $this->userLogin['user_id'],
                    'supplier_name'         => $getOrder['supplier_name'],
                    'hd_retur_purchase_id'  => $hd_retur_purchase_id
                ];

                $getTemp = $this->M_retur->copyReturToTemp($datacopy)->getResultArray();


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

    public function cancelRetur($hd_retur_purchase_id = '')
    {
        $this->validationRequest(TRUE, 'GET');

        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk Membatalkan PO'];

        if ($this->role->hasRole('retur_purchase.delete')) {

            $getOrder = $this->M_retur->getRetur($hd_retur_purchase_id)->getRowArray();

            if ($getOrder == NULL) {

                $result = ['success' => FALSE, 'message' => 'Transaksi tidak ditemukan'];

            } else {

                if($getOrder['hd_retur_status'] != 'Pending'){

                    $result = ['success' => FALSE, 'message' => 'Transaksi yang sudah selesai tidak dapat di hapus'];

                }else{

                    $cancelOrder = $this->M_retur->cancelOrder($hd_retur_purchase_id);        

                    $result = ['success' => TRUE, 'message' => 'Pengajuan Berhasil Di Batalkan'];   
                }

            }

        }   

        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function printInvoice($hd_retur_purchase_id = "")
    {
        if ($hd_retur_purchase_id == '') {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $getOrder = $this->M_retur->getRetur($hd_retur_purchase_id)->getRowArray();

            if ($getOrder == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $invoice_num = $getOrder['hd_retur_purchase_invoice'];

                $data = [

                    'hdRetur' => $getOrder,

                    'dtRetur' => $this->M_retur->getDtRetur($hd_retur_purchase_id)->getResultArray(),

                ];

                return $this->renderView('purchase/purchaseretur_invoice', $data);
            }

        }



    }

    //--------------------------------------------------------------------

}
