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
            $table->db->select('*');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['purchase_order_invoice']);
                $column[] = esc($row['purchase_order_date']);
                $column[] = esc('');
                $column[] = esc('');
                $column[] = esc($row['purchase_order_total']);
                $column[] = esc($row['purchase_order_status']);
                $btns = [];
                $prop =  'data-id="' . $row['purchase_order_id'] . '" data-name="' . esc($row['purchase_order_invoice']) . '"';
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/submission/get-submission-detail/'.$row['purchase_order_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
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

        $suplier = $this->request->getGet('sup');

        $keyword = $this->request->getGet('term');

        if($suplier == 'null'){

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Isi Nama Supplier Terlebih Dahulu'];

        }else{

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];

            if (!($keyword == '' || $keyword == NULL)) {

                $M_product = model('M_product');

                $find = $M_product->searchProductBysuplier($keyword, $suplier)->getResultArray();

                $find_result = [];

                foreach ($find as $row) {

                    $diplay_text = $row['product_name'];

                    $find_result[] = [

                        'id'                  => $diplay_text,

                        'value'               => $diplay_text,

                        'product_id'          => $row['product_id'],

                        'base_purchase_price' => $row['base_purchase_price']

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
            'temp_po_id'                        => $this->request->getPost('temp_po_id'),
            'temp_po_product_id'                => $this->request->getPost('product_id'),
            'temp_po_qty'                       => $this->request->getPost('temp_qty'),
            'temp_po_ppn'                       => $this->request->getPost('temp_tax'),
            'temp_po_dpp'                       => $this->request->getPost('temp_dpp'),
            'temp_po_price'                     => $this->request->getPost('temp_price'),
            'temp_po_discount1'                 => $this->request->getPost('temp_discount1'),
            'temp_po_discount1_percentage'      => $this->request->getPost('temp_po_discount1_percentage'),
            'temp_po_discount2'                 => $this->request->getPost('temp_discount2'),
            'temp_po_discount2_percentage'      => $this->request->getPost('temp_po_discount2_percentage'),
            'temp_po_discount3'                 => $this->request->getPost('temp_discount3'),
            'temp_po_discount3_percentage'      => $this->request->getPost('temp_po_discount3_percentage'),
            'temp_po_ongkir'                    => $this->request->getPost('temp_ongkir'),
            'temp_po_expire_date'               => $this->request->getPost('temp_ed_date'),
            'temp_po_total'                     => $this->request->getPost('temp_total'),
            'temp_po_suplier_id'                => $this->request->getPost('temp_po_suplier_id'),
            'temp_po_suplier_name'              => $this->request->getPost('temp_po_suplier_name'),
            'temp_po_user_id'                   => $this->request->getPost('product_name'),
            'temp_po_discount_total'            => $this->request->getPost('total_temp_discount'),

        ];

        $validation->setRules([
            'temp_po_product_id'    => ['rules' => 'required'],
            'temp_po_qty'           => ['rules' => 'required|greater_than[0]'],
            'temp_po_ppn'           => ['rules' => 'required'],
            'temp_po_dpp'           => ['rules' => 'required'],
            'temp_po_price'         => ['rules' => 'required'],
            'temp_po_ongkir'        => ['rules' => 'required'],
            'temp_po_expire_date'   => ['rules' => 'required'],
            'temp_po_total'         => ['rules' => 'required'],
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        } else {

            $input['temp_po_user_id'] = $this->userLogin['user_id'];
            if($input['temp_po_id'] == ''){
                $save = $this->M_purchase_order->insertTemp($input);
            }else{
                $save = $this->M_purchase_order->editTemp($input);
            }

            if ($save) {

                $result = ['success' => TRUE, 'message' => 'Data item berhasil ditambahkan'];

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

    public function save($type)
    {

        //$this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'purchase_order_date'           => $this->request->getPost('purchase_order_date'),
            'purchase_order_supplier_id'    => $this->request->getPost('purchase_order_supplier_id'),
            'purchase_order_store_id'       => $this->request->getPost('purchase_order_store_id'),
            'purchase_order_remark'         => $this->request->getPost('purchase_order_remark'),
            'purchase_order_sub_total'      => $this->request->getPost('purchase_order_sub_total'),
            'purchase_order_discount1'      => $this->request->getPost('purchase_order_discount1'),
            'purchase_order_discount2'      => $this->request->getPost('purchase_order_discount2'),
            'purchase_order_discount3'      => $this->request->getPost('purchase_order_discount3'),
            'purchase_order_total_discount' => $this->request->getPost('purchase_order_total_discount'),
            'purchase_order_total_ppn'      => $this->request->getPost('purchase_order_total_ppn'),
            'purchase_order_total'          => $this->request->getPost('purchase_order_total')
        ];

        $validation->setRules([
            'purchase_order_date'            => ['rules' => 'required'],
            'purchase_order_supplier_id'     => ['rules' => 'required'],
            'purchase_order_store_id'        => ['rules' => 'required'],
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

    public function printinvoice()
    {
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
            return $this->renderView('purchase/purchaseorder_invoice');
        }
    }

    //--------------------------------------------------------------------

}
