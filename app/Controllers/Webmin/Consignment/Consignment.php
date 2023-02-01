<?php

namespace App\Controllers\Webmin\Consignment;

use App\Models\M_consignment;
use Dompdf\Dompdf;
use App\Controllers\Base\WebminController;

class Consignment extends WebminController
{

    protected $M_consignment;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
         $this->M_consignment = new M_consignment;
    }

    public function index(){
        
    }

    public function purchaseOrderConsignment(){
        $data = [
            'title'         => 'Purchase Order Konsinyasi'
        ];
        return $this->renderView('consignment/purchaseorder_consignment', $data);
    }

    public function recapConsignment()
    {
        $data = [
            'title'         => 'Rekap Konsinyasi'
        ];
        return $this->renderView('consignment/recap_consignment', $data);
    }

    public function tblhdPoConsignment()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('purchase_order_consignment.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('hd_purchase_order_consignment');
            $table->db->select('purchase_order_consignment_id, purchase_order_consignment_invoice, purchase_order_consignment_date, supplier_name, user_realname, purchase_order_consignment_status');
            $table->db->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase_order_consignment.purchase_order_consignment_supplier_id');
            $table->db->join('user_account', 'user_account.user_id = hd_purchase_order_consignment.purchase_order_consignment_user_id');
            $table->db->orderBy('hd_purchase_order_consignment.created_at', 'desc');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['purchase_order_consignment_invoice']);
                $column[] = indo_short_date($row['purchase_order_consignment_date'], FALSE);
                $column[] = esc($row['supplier_name']);
                if($row['purchase_order_consignment_status'] == 'Accept'){
                    $column[] = '<span class="badge badge-success">Selesai</span>';
                }else if($row['purchase_order_consignment_status'] == 'Pending'){
                    $column[] = '<span class="badge badge-primary">Pending</span>';
                }else{
                    $column[] = '<span class="badge badge-danger">Batal</span>';
                }
                $btns = [];

                $prop =  'data-id="' . $row['purchase_order_consignment_id'] . '" data-name="' . esc($row['purchase_order_consignment_invoice']) . '"';
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/consignment/get-consignment-po-detail/'.$row['purchase_order_consignment_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'purchase_order_consignment_invoice','supplier_name','purchase_order_consignment_date','','purchase_order_consignment_status',''];
            $table->searchColumn = ['purchase_order_consignment_invoice','supplier_name', 'purchase_order_consignment_date','purchase_order_consignment_status'];
            $table->generate();
        }
    }

    public function tblhdInputConsignment()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('purchase_input_consignment.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('hd_purchase_consignment');
            $table->db->select('*');
            $table->db->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase_consignment.purchase_consignment_supplier_id');
            $table->db->join('user_account', 'user_account.user_id = hd_purchase_consignment.purchase_consignment_user_id');
            $table->db->orderBy('hd_purchase_consignment.created_at', 'desc');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['purchase_consignment_invoice']);
                $column[] = esc($row['purchase_consignment_po']);
                $column[] = indo_short_date($row['purchase_consignment_date'], FALSE);
                $column[] = esc($row['supplier_name']);
                $btns = [];
                $prop =  'data-id="'.$row['purchase_consignment_id'].'" data-name="'.esc($row['purchase_consignment_id']).'"';
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/submission/get-submission-detail/'.$row['purchase_consignment_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'purchase_consignment_date','supplier_name',''];
            $table->searchColumn = ['purchase_consignment_po','supplier_name', 'purchase_consignment_date'];
            $table->generate();
        }
    }

    public function getConsignmentPoDetail($purchase_order_consignment_id = '')
    {
        if ($purchase_order_consignment_id == '') {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $getOrder =  $this->M_consignment->getOrderPoConsignment($purchase_order_consignment_id)->getRowArray();

            if ($getOrder == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $purchase_order_consignment_invoice = $getOrder['purchase_order_consignment_invoice'];

                $data = [

                    'hdConsignment' => $getOrder,

                    'dtConsignment' => $this->M_consignment->getDtConsignmentPoDetail($purchase_order_consignment_invoice)->getResultArray(),

                ];

                return view('webmin/consignment/consignment_po_detail', $data);

            }

        }
    }


    public function stockInputConsignment(){
        $data = [
            'title'         => 'Input Stok Konsinyasi'
        ];
        return $this->renderView('consignment/stock_input_consignment', $data);
    }

    public function printinvoice(){
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
            return $this->renderView('consignment/purchaseorder_consignment_invoice');
        }
    }

     public function tempadd(){

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            //'temp_po_consignment_id'                => $this->request->getPost('temp_po_consignment_id'),
            'temp_po_consignment_item_id'           => $this->request->getPost('item_id'),
            'temp_po_consignment_submission_id'     => $this->request->getPost('temp_po_consignment_submission_id'),
            'temp_po_consignment_submission_invoice'=> $this->request->getPost('temp_po_consignment_submission_invoice'),
            'temp_po_consignment_qty'               => $this->request->getPost('temp_qty'),
            'temp_po_consignment_expire_date'       => $this->request->getPost('temp_ed_date'),
            'temp_po_consignment_suplier_id'        => $this->request->getPost('temp_supplier_id'),
            'temp_po_consignment_suplier_name'      => $this->request->getPost('temp_supplier_name'),
        ];

        $validation->setRules([
            'temp_po_consignment_qty'    => ['rules' => 'required|greater_than[0]']
        ]);

        if ($validation->run($input) === FALSE) {

                $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

            } else {

                $input['temp_po_consignment_user_id'] = $this->userLogin['user_id'];

                $save = $this->M_consignment->insertTemp($input);

                if ($save) {

                    $result = ['success' => TRUE, 'message' => 'Data item berhasil ditambahkan'];

                } else {

                    $result = ['success' => FALSE, 'message' => 'Data item gagal ditambahkan'];

                }

            }
        

        $getTemp = $this->M_consignment->getTemp($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);

        
    }


    public function tempaddinput()
    {
        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'temp_consignment_id'            => $this->request->getPost('temp_consignment_id'),
            'temp_consignment_item_id'       => $this->request->getPost('item_id'),
            'temp_consignment_qty'           => $this->request->getPost('temp_qty'),
            'temp_consignment_expire_date'   => $this->request->getPost('temp_ed_date'),
            'temp_consignment_suplier_id'    => $this->request->getPost('temp_supplier_id'),
            'temp_consignment_suplier_name'  => $this->request->getPost('temp_supplier_name'),
        ];

        $validation->setRules([
            'temp_consignment_qty'    => ['rules' => 'required|greater_than[0]']
        ]);

        if ($validation->run($input) === FALSE) {

                $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

            } else {

                $input['temp_consignment_user_id'] = $this->userLogin['user_id'];

                $save = $this->M_consignment->insertTempInput($input);

                if ($save) {

                    $result = ['success' => TRUE, 'message' => 'Data item berhasil ditambahkan'];

                } else {

                    $result = ['success' => FALSE, 'message' => 'Data item gagal ditambahkan'];

                }

            }
        

        $getTempInputConsignment = $this->M_consignment->getTempInputConsignment($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTempInputConsignment as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);
    }

    public function deleteTemp($temp_po_consignment_id = '')
    {
        //$this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('purchase_order_consignment.delete')) {
            if ($temp_po_consignment_id != '') {
                $delete = $this->M_consignment->deletetemp($temp_po_consignment_id);
                if ($delete) {
                   $getTemp = $this->M_consignment->getTemp($this->userLogin['user_id'])->getResultArray();
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

    public function deleteTempCons($temp_consignment_id = '')
    {
        //$this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('purchase_consignment.delete')) {
            if ($temp_consignment_id != '') {
                $delete = $this->M_consignment->deleteTempCons($temp_consignment_id);
                if ($delete) {
                   $getTempInputConsignment = $this->M_consignment->getTempInputConsignment($this->userLogin['user_id'])->getResultArray();
                   $find_result = [];
                   foreach ($getTempInputConsignment as $k => $v) {
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

    public function getConsignmentTemp()
    {
        $getTemp = $this->M_consignment->getTemp($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);
    }

    public function getInputConsignmentTemp()
    {
        $getTempInputConsignment = $this->M_consignment->getTempInputConsignment($this->userLogin['user_id'])->getResultArray();

        $find_result = [];

        foreach ($getTempInputConsignment as $k => $v) {

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

        $input = [

            'purchase_order_consignment_supplier_id' => $this->request->getPost('supplier_id'),
            'purchase_order_consignment_date'        => $this->request->getPost('po_consignment_date'),
            'purchase_order_consignment_warehouse_id'=> $this->request->getPost('warehouse'),
            'purchase_order_consignment_remark'      => $this->request->getPost('po_consignment_remark'),

        ];

        $validation->setRules([

            'purchase_order_consignment_warehouse_id'    => ['rules' => 'required'],
            'purchase_order_consignment_date'        => ['rules' => 'required'],
            'purchase_order_consignment_remark'      => ['rules' => 'max_length[500]'],
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            if ($type == 'add') {

                if ($this->role->hasRole('purchase_order_consignment.add')) {

                    unset($input['purchase_order_consignment_id']);

                    $input['purchase_order_consignment_user_id']= $this->userLogin['user_id'];

                    $input['purchase_order_consignment_status'] = 'Pending';

                    $save = $this->M_consignment->insertConsignment($input);

                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data PO Konsinyasi berhasil disimpan', 'purchase_order_consignment_id' => $save['purchase_order_consignment_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data PO Konsinyasi  gagal disimpan'];

                    }

                } else {

                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah PO Konsinyasi'];

                }

            } else if ($type == 'edit') {

                if ($this->role->hasRole('purchase_order_consignment.edit')) {

                    $input['purchase_order_consignment_user_id']   = $this->userLogin['user_id'];

                    $save = $this->M_purchase_order->updateOrder($input);

                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data pesanan berhasil diperbarui', 'purchase_order_consignment_id' => $save['purchase_order_consignment_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data pesanan gagal diperbarui'];

                    }

                } else {

                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah PO Konsinyasi'];

                }

            }

        }

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);

    }


    public function saveInput($type)
    {
        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [

            'purchase_consignment_supplier_id' => $this->request->getPost('supplier_id'),
            'purchase_consignment_date'        => $this->request->getPost('purchase_consignment_date'),
            'purchase_consignment_warehouse_id'    => $this->request->getPost('warehouse'),
            'purchase_consignment_remark'      => $this->request->getPost('purchase_consignment_remark'),
            'purchase_consignment_po'          => $this->request->getPost('no_po_consignment'),

        ];

        $validation->setRules([

            'purchase_consignment_warehouse_id'    => ['rules' => 'required'],
            'purchase_consignment_date'        => ['rules' => 'required'],
            'purchase_consignment_remark'      => ['rules' => 'max_length[500]'],
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            if ($type == 'add') {

                if ($this->role->hasRole('input_consignment.add')) {

                    unset($input['purchase_consignment_id']);

                    $input['purchase_consignment_user_id']= $this->userLogin['user_id'];

                    $save = $this->M_consignment->insertInputConsignment($input);


                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data Penginputan Konsinyasi berhasil disimpan', 'purchase_consignment_id' => $save['purchase_consignment_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data Penginputan Konsinyasi  gagal disimpan'];

                    }

                } else {

                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah Penginputan Konsinyasi'];

                }

            }

        }

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);
    }

    public function copyPurchaseOrderConsignment($purchase_order_consignment_id = '')
    {
        $this->validationRequest(TRUE, 'GET');

        $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah transaksi pesanan konsinyasi'];

        if ($this->role->hasRole('input_consignment.add')) {

            $getOrderPoConsignment = $this->M_consignment->getOrderPoConsignment($purchase_order_consignment_id)->getRowArray();
            
            if ($getOrderPoConsignment == NULL) {

                $result = ['success' => FALSE, 'message' => 'Transaksi dengan id invoice <b>' . $purchase_order_consignment_id . '</b> tidak ditemukan'];

            } else {

                $find_result = [];

                $user_id = $this->userLogin['user_id'];

                if ($getOrderPoConsignment['purchase_order_consignment_status'] == 'Pending') {

                    $datacopy = [
                        'user_id'                           => $getOrderPoConsignment['purchase_order_consignment_user_id'],
                        'supplier_id'                       => $getOrderPoConsignment['purchase_order_consignment_supplier_id'],
                        'supplier_name'                     => $getOrderPoConsignment['supplier_name'],
                        'purchase_order_id'                 => $getOrderPoConsignment['purchase_order_consignment_id'],
                        'purchase_order_invoice'            => $getOrderPoConsignment['purchase_order_consignment_invoice'],

                    ];

                    $getTemp = $this->M_consignment->copyDtOrderToTemp($datacopy)->getResultArray();

                    $find_result = [];

                    foreach ($getTemp as $k => $v) {

                        $find_result[$k] = esc($v);

                    }

                    $result = ['success' => TRUE, 'header' => $getOrderPoConsignment, 'data' => $find_result, 'message' => ''];


                }

            }
            $result['csrfHash'] = csrf_hash();

            resultJSON($result);

        }
    }

    //--------------------------------------------------------------------

}
