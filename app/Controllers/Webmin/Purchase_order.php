<?php


namespace App\Controllers\Webmin;

use Dompdf\Dompdf;
use App\Models\M_purchase_order;
use App\Controllers\Base\WebminController;

class Purchase_order extends WebminController
{

    protected $M_purchase_order;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_purchase_order = new M_purchase_order;
    }


    public function index()
    {
        $data = [
            'title'         => 'Purchase Order'
        ];
        return $this->renderView('purchase/purchaseorder', $data);
    }

    public function tblpurchaseorders()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('purchase_order.view')) {
            helper('datatable');

            $table = new \App\Libraries\Datatables('hd_purchase_order');
            $table->db->select('purchase_order_id,purchase_order_invoice,purchase_order_date,supplier_name,purchase_order_total_ppn,purchase_order_total,purchase_order_status,purchase_order_item_status');
            $table->db->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase_order.purchase_order_supplier_id');
            $table->db->orderBy('hd_purchase_order.created_at', 'desc');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['purchase_order_invoice']);
                $column[] = indo_short_date($row['purchase_order_date']);
                if($row['purchase_order_total_ppn'] > 0){
                    $column[] = '<span class="badge badge-warning">BKP</span>';
                }else{
                    $column[] = '<span class="badge badge-primary">Non BKP</span>';
                }
                $column[] = esc($row['supplier_name']);
                $column[] = esc('Rp. '.number_format($row['purchase_order_total']));
                if($row['purchase_order_status'] == 'Selesai'){
                    $column[] = '<span class="badge badge-success">Selesai</span>';
                }else if($row['purchase_order_status'] == 'Pending'){
                    $column[] = '<span class="badge badge-primary">Pending</span>';
                }else{
                    $column[] = '<span class="badge badge-danger">Batal</span>';
                }

                $column[] = esc($row['purchase_order_item_status']);
                $btns = [];
                $prop =  'data-id="' . $row['purchase_order_id'] . '" data-name="' . esc($row['purchase_order_invoice']) . '"';
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/purchase-order/get-purchase-order-detail/'.$row['purchase_order_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $btns[] = '<button data-id="'.$row['purchase_order_id'] .'" data-name="'. esc($row['purchase_order_invoice']) .'" class="margins btn btn-sm btn-primary mb-2 btnstatus" data-toggle="tooltip" data-placement="top" data-title="Status" data-original-title="" title=""><i class="fas fa-truck-loading"></i></button>';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $btns[] = button_print($prop);
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'purchase_order_invoice', 'purchase_order_date','','purchase_order_status',''];
            $table->searchColumn = ['purchase_order_invoice', 'purchase_order_date','purchase_order_status'];
            $table->generate();
        }
    }

    public function searchProductBysuplier()
    {

        $this->validationRequest(TRUE, 'GET');

        $supplier = $this->request->getGet('sup');

        $keyword = $this->request->getGet('term');

        if($supplier == 'null'){

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Isi Nama Supplier Terlebih Dahulu'];

        }else{

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];

            if (!($keyword == '' || $keyword == NULL)) {

                $M_product = model('M_product');

                $find = $M_product->searchProductBysuplier($keyword, $supplier)->getResultArray();

                $find_result = [];

                foreach ($find as $row) {

                    $diplay_text = $row['product_name'];

                    $find_result[] = [


                        'id'                  => $diplay_text,

                        'value'               => $row['product_code'].' - '.$diplay_text.'('.$row['unit_name'].')',

                        'item_id'             => $row['item_id'],

                        'purchase_price'      => $row['purchase_price'],

                        'base_purchase_tax'   => $row['base_purchase_tax'],

                    ];

                }

                $result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];

            }
        }

        resultJSON($result);
    }


    public function getSubmissionDetail($submission_id = '')
    {
        $this->validationRequest(TRUE, 'GET');
        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses'];
        if ($this->role->hasRole('purchase_order.add')) {
            $M_submission = model('M_submission');
            $getOrder = $M_submission->getSubmissiondetaildata($submission_id)->getRowArray();
            if ($getOrder == NULL) {
                $result = ['success' => FALSE, 'message' => 'Transaksi dengan id invoice <b>' . $submission_id . '</b> tidak ditemukan'];
            } else {
                $checkNullItem = $M_submission->checkNullItem($submission_id)->getRowArray();
                if($checkNullItem != null){
                    $result = ['success' => FALSE, 'message' => 'Silahkan Lengkapi Data Produk Terlebih Dahulu'];
                }else{
                    $result = ['success' => TRUE, 'header' => $getOrder,  'message' => ''];
                }
            }
        }
        resultJSON($result);
    }

    public function getPurchaseOrderDetail($purchase_order_id = '')
    {

        if ($purchase_order_id == '') {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $getOrder =  $this->M_purchase_order->getPurchaseOrder($purchase_order_id)->getRowArray();

            if ($getOrder == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $invoice_num = $getOrder['purchase_order_invoice'];

                $data = [

                    'hdPO' => $getOrder,

                    'dtPO' => $this->M_purchase_order->getDtPurchaseOrder($purchase_order_id)->getResultArray(),

                    'logupdate' => $this->M_purchase_order->getLogEditOrder($purchase_order_id)->getResultArray()

                ];

                return view('webmin/purchase/purchaseorder_detail', $data);

            }

        }

    }

    public function getbyid($purchase_order_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data PO tidak ditemukan'];
        if ($this->role->hasRole('purchase_order.status')) {
            if ($purchase_order_id != '') {
                $find = $this->M_purchase_order->getOrder($purchase_order_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data kategori tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                    }
                    $result = ['success' => TRUE, 'exist' => TRUE, 'data' => $find_result, 'message' => ''];
                }
            }
        }

        resultJSON($result);
    }

    public function editOrder($purchase_order_id = '')
    {

        $this->validationRequest(TRUE, 'GET');

        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah pesanan pembelian'];

        if ($this->role->hasRole('purchase_order.edit')) {

            $getOrder = $this->M_purchase_order->getOrder($purchase_order_id)->getRowArray();

            if ($getOrder == NULL) {

                $result = ['success' => FALSE, 'message' => 'Transaksi dengan No invoice <b>' . $purchase_order_id . '</b> tidak ditemukan'];

            } else {

                $purchase_order_invoice = $getOrder['purchase_order_invoice'];

                $datacopy = [
                    'purchase_order_id'                 => $purchase_order_id,
                    'user_id'                           => $this->userLogin['user_id'],
                    'temp_po_supplier_id'               => $getOrder['purchase_order_supplier_id'],
                    'temp_po_supplier_name'             => $getOrder['supplier_name']
                ];

                $getTemp = $this->M_purchase_order->copyDtOrderToTemp($datacopy)->getResultArray();


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

    public function cancelOrder($purchase_order_id = '')
    {
        $this->validationRequest(TRUE, 'GET');

        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk Membatalkan PO'];

        if ($this->role->hasRole('purchase_order.delete')) {

            $getOrder = $this->M_purchase_order->getOrder($purchase_order_id)->getRowArray();

            if ($getOrder == NULL) {

                $result = ['success' => FALSE, 'message' => 'Transaksi dengan No invoice <b>' . $purchase_order_id . '</b> tidak ditemukan'];

            } else {

                $user_id = $this->userLogin['user_id'];

                $purchase_order_invoice = $getOrder['purchase_order_invoice'];

                $cancelOrder = $this->M_purchase_order->cancelOrder($purchase_order_invoice, $purchase_order_id);

                $result = ['success' => TRUE, 'message' => 'Pengajuan Berhasil Di Batalkan'];

            }

        }   

        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function tempadd(){

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();


        $input = [
            'temp_po_id'                        => $this->request->getPost('temp_po_id'),
            'temp_po_submission_id'             => $this->request->getPost('temp_po_submission_id'),
            'temp_po_submission_invoice'        => $this->request->getPost('temp_po_submission_invoice'),
            'temp_po_item_id'                   => $this->request->getPost('item_id'),
            'temp_po_qty'                       => $this->request->getPost('temp_qty'),
            'temp_po_ppn'                       => $this->request->getPost('temp_tax'),
            'temp_po_dpp'                       => $this->request->getPost('temp_dpp'),
            'temp_po_price'                     => $this->request->getPost('temp_price'),
            'temp_po_discount1'                 => $this->request->getPost('temp_discount1'),
            'temp_po_discount1_percentage'      => $this->request->getPost('temp_discount_percentage1'),
            'temp_po_discount2'                 => $this->request->getPost('temp_discount2'),
            'temp_po_discount2_percentage'      => $this->request->getPost('temp_discount_percentage2'),
            'temp_po_discount3'                 => $this->request->getPost('temp_discount3'),
            'temp_po_discount3_percentage'      => $this->request->getPost('temp_discount_percentage3'),
            'temp_po_ongkir'                    => $this->request->getPost('temp_ongkir'),
            'temp_po_expire_date'               => $this->request->getPost('temp_ed_date'),
            'temp_po_total'                     => $this->request->getPost('temp_total'),
            'temp_po_supplier_id'               => $this->request->getPost('temp_po_suplier_id'),
            'temp_po_supplier_name'             => $this->request->getPost('temp_po_suplier_name'),
            'temp_po_discount_total'            => $this->request->getPost('total_temp_discount'),

        ];
        



        $validation->setRules([
            'temp_po_item_id'    => ['rules' => 'required'],
            'temp_po_qty'           => ['rules' => 'required|greater_than[0]'],
            'temp_po_price'         => ['rules' => 'required|greater_than[0]'],
            'temp_po_ppn'           => ['rules' => 'required'],
            'temp_po_dpp'           => ['rules' => 'required'],
            'temp_po_price'         => ['rules' => 'required'],
            'temp_po_ongkir'        => ['rules' => 'required'],
            'temp_po_total'         => ['rules' => 'required'],
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            $input['temp_po_user_id'] = $this->userLogin['user_id'];

            $save = $this->M_purchase_order->insertTemp($input);


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

        $getTemp = $this->M_purchase_order->getTemp($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);
    }

    public function deleteTemp($temp_po_id = '')
    {
        //$this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('purchase_order.delete')) {
            if ($temp_po_id != '') {
                $delete = $this->M_purchase_order->deletetemp($temp_po_id);
                if ($delete) {
                 $getTemp = $this->M_purchase_order->getTemp($this->userLogin['user_id'])->getResultArray();
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


public function getPoTemp(){

    $getTemp = $this->M_purchase_order->getTemp($this->userLogin['user_id'])->getResultArray();

    $find_result = [];

    foreach ($getTemp as $k => $v) {

        $find_result[$k] = esc($v);

    }

    $result['data'] = $find_result;

    $result['csrfHash'] = csrf_hash();

    $result['success'] = 'TRUE';

    resultJSON($result);

}

public function getPoFooter(){


    $getFooter = $this->M_purchase_order->getFooter($this->userLogin['user_id'])->getResultArray();

    $find_result = [];

    foreach ($getFooter as $k => $v) {

        $find_result[$k] = esc($v);

    }

    $result['data'] = $find_result;

    $result['csrfHash'] = csrf_hash();

    $result['success'] = 'TRUE';

    resultJSON($result);

}

public function clearTemp()
{
    $this->M_purchase_order->clearTemp($this->userLogin['user_id']);

    $result['csrfHash'] = csrf_hash();

    $result['success'] = 'TRUE';

    resultJSON($result);
}

public function getTax(){

    $getTax = $this->M_purchase_order->getTax($this->userLogin['user_id'])->getResultArray();

    $find_result = [];

    foreach ($getTax as $k => $v) {

        $find_result[$k] = esc($v);

    }

    $result['data'] = $find_result;

    $result['csrfHash'] = csrf_hash();

    $result['success'] = 'TRUE';

    resultJSON($result);

}

public function save($type)
{

    $this->validationRequest(TRUE, 'POST');

    $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

    $validation =  \Config\Services::validation();


    if($this->request->getPost('purchase_show_tax_desc') == 'on'){
        $purchase_show_tax_desc = 'Y';
    }else{
        $purchase_show_tax_desc = 'N';
    }

    $input = [
        'purchase_order_id'                       => $this->request->getPost('purchase_order_id'),
        'purchase_order_date'                     => $this->request->getPost('purchase_order_date'),
        'purchase_order_supplier_id'              => $this->request->getPost('purchase_order_supplier_id'),
        'purchase_order_warehouse_id'             => $this->request->getPost('purchase_order_warehouse_id'),
        'purchase_order_remark'                   => $this->request->getPost('purchase_order_remark'),
        'purchase_show_tax_desc'                  => $purchase_show_tax_desc,
        'purchase_order_sub_total'                => $this->request->getPost('purchase_order_sub_total'),
        'purchase_order_discount1'                => $this->request->getPost('purchase_order_discount1'),
        'purchase_order_discount2'                => $this->request->getPost('purchase_order_discount2'),
        'purchase_order_discount3'                => $this->request->getPost('purchase_order_discount3'),
        'purchase_order_discount1_percentage'     => $this->request->getPost('purchase_order_discount1_percentage'),
        'purchase_order_discount2_percentage'     => $this->request->getPost('purchase_order_discount2_percentage'),
        'purchase_order_discount3_percentage'     => $this->request->getPost('purchase_order_discount3_percentage'),
        'purchase_order_total_discount'           => $this->request->getPost('purchase_order_total_discount'),
        'purchase_order_total_dpp'                => $this->request->getPost('purchase_order_dpp'),
        'purchase_order_total_ppn'                => $this->request->getPost('purchase_order_total_ppn'),
        'purchase_order_total_ongkir'             => $this->request->getPost('purchase_order_total_ongkir'),
        'purchase_order_total'                    => $this->request->getPost('purchase_order_total')
    ];

    $validation->setRules([
        'purchase_order_date'            => ['rules' => 'required'],
        'purchase_order_supplier_id'     => ['rules' => 'required'],
        'purchase_order_warehouse_id'     => ['rules' => 'required'],
        'purchase_order_remark'          => ['rules' => 'max_length[500]']
    ]);

    if ($validation->run($input) === FALSE) {

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

    } else {

        if ($type == 'add') {

            if ($this->role->hasRole('purchase_order.add')) {

                unset($input['purchase_order_id']);

                $input['purchase_order_user_id']= $this->userLogin['user_id'];

                $input['purchase_order_status'] = 'Pending';

                $save = $this->M_purchase_order->insertPurchaseOrder($input);

                if ($save['success']) {

                    $result = ['success' => TRUE, 'message' => 'Data pengajuan berhasil disimpan', 'purchase_order_id' => $save['purchase_order_id']];

                } else {

                    $result = ['success' => FALSE, 'message' => 'Data pengajuan gagal disimpan'];

                    
                }

            } else {

                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah pengajuan'];

            }

        } else if ($type == 'edit') {

            if ($this->role->hasRole('purchase_order.edit')) {

                $input['user_id']       = $this->userLogin['user_id'];

                $getOrder = $this->M_purchase_order->getOrder($input['purchase_order_id'])->getRowArray();

                $save = $this->M_purchase_order->updateOrder($input);

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

public function UpdateStatusItem()
{
    $this->validationRequest(TRUE, 'POST');

    $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

    $validation =  \Config\Services::validation();

    $input = [

        'purchase_order_id_status'      => $this->request->getPost('purchase_order_id_status'),
        'purchase_order_item_status'    => $this->request->getPost('purchase_order_item_status')
    ];

    if ($this->role->hasRole('purchase_order.status')) {

        $getOrder = $this->M_purchase_order->getOrder($input['purchase_order_id_status'])->getRowArray();

        if ($getOrder == NULL) {

            $result = ['success' => FALSE, 'message' => 'Transaksi tidak ditemukan'];

        } else {

            $UpdateStatusItem = $this->M_purchase_order->UpdateStatusItem($input);

            $result = ['success' => TRUE, 'message' => 'Update Status Berhasil'];

        }
    }

    $result['csrfHash'] = csrf_hash();
    resultJSON($result);
}


public function printinvoice($purchase_order_id = "")
{
    /*
    $export = $this->request->getGet('export');
    if ($export == 'pdf') {
        $dompdf = new Dompdf();
        $viewHtml = $this->renderView('purchase/purchaseorder_invoice');
        $dompdf->loadHtml($viewHtml);

            // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('a4', 'landscape');

            // Render the HTML as PDF
        $dompdf->render();

            // Output the generated PDF to Browser
        $dompdf->stream('invoice');
    } else {
    */
       if ($purchase_order_id == '') {

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

    } else {

        $getOrder =  $this->M_purchase_order->getPurchaseOrder($purchase_order_id)->getRowArray();

        if ($getOrder == NULL) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $invoice_num = $getOrder['purchase_order_invoice'];

            $data = [

                'hdPO' => $getOrder,

                'dtPO' => $this->M_purchase_order->getDtPurchaseOrder($purchase_order_id)->getResultArray()

            ];

            return $this->renderView('purchase/purchaseorder_invoice', $data);
        }

    }
    
    
    
}

    //--------------------------------------------------------------------

}
