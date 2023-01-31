<?php

namespace App\Controllers\Webmin\Stocktransfer;

use App\Models\M_stock_transfer;
use App\Controllers\Base\WebminController;


class Stocktransfer extends WebminController
{

    protected $M_stock_transfer;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_stock_transfer = new M_stock_transfer;
    }


    public function index()
    {
        return $this->renderView('stock_transfer/stock_transfer');
    }

    public function tblstocktransfer()
    {
         $this->validationRequest(TRUE);
        if ($this->role->hasRole('transfer_stock.view')) {
            helper('datatable');

            $table = new \App\Libraries\Datatables('hd_transfer_stock');
            $table->db->select('hd_transfer_stock_id, hd_transfer_stock_no, hd_transfer_stock_date, a1.warehouse_name AS warehouse_from, a2.warehouse_name AS warehouse_to');
            $table->db->join('ms_warehouse a1', 'hd_transfer_stock.hd_transfer_stock_warehose_from=a1.warehouse_id', 'left');
            $table->db->join('ms_warehouse a2', 'hd_transfer_stock.hd_transfer_stock_warehose_to=a2.warehouse_id', 'left');
            $table->db->orderBy('hd_transfer_stock.created_at', 'desc');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['hd_transfer_stock_no']);
                $column[] = indo_short_date($row['hd_transfer_stock_date']);
                $column[] = esc($row['warehouse_from']);
                $column[] = esc($row['warehouse_to']);
                $btns = [];
                $prop =  'data-id="' . $row['hd_transfer_stock_id'] . '" data-name="' . esc($row['hd_transfer_stock_no']) . '"';
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="'.base_url().'/webmin/stock-transfer/get-stock-transfer-detail/'.$row['hd_transfer_stock_id'].'" class="margins btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'hd_transfer_stock_no', 'hd_transfer_stock_no','','warehouse_from','warehouse_to',''];
            $table->searchColumn = ['hd_transfer_stock_no', 'hd_transfer_stock_no'];
            $table->generate();
        }
    }

    public function searchProductTransfer()
    {
        $this->validationRequest(TRUE, 'GET');

        $warehouse_id = $this->request->getGet('warehouse');

        $keyword = $this->request->getGet('term');

        if($warehouse_id == 'null'){

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => 'Silahkan Pilih Gudang Pengambilan Terlebih Dahulu'];

        }else{

            $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];

            if (!($keyword == '' || $keyword == NULL)) {

                $M_product = model('M_product');

                $find = $M_product->searchProductBywarehouse($keyword, $warehouse_id)->getResultArray();

                $find_result = [];

                foreach ($find as $row) {

                    $diplay_text = $row['product_name'];

                    $find_result[] = [

                        'id'                  => $diplay_text,

                        'value'               => $diplay_text.'('.$row['unit_name'].')',

                        'item_id'             => $row['item_id'],

                        'purchase_price'      => $row['purchase_price'],

                        'warehouse_stock'     => $row['warehouse_stock'],

                    ];

                }

                $result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];

            }
        }

        resultJSON($result);
    }

    public function tempadd()
    {
        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        if($this->role->hasRole('transfer_stock.delete')) {

            $validation =  \Config\Services::validation();

            $input = [
                'item_id'                        => $this->request->getPost('item_id'),
                'item_qty'                       => $this->request->getPost('temp_qty'),
                'item_last_stock'                => $this->request->getPost('last_stock'),
                'item_warehouse_from_id'         => $this->request->getPost('warehouse_from'),
                'item_warehouse_from_text'       => $this->request->getPost('warehouse_from_text'),
                'item_warehouse_destination_id'  => $this->request->getPost('warehouse_to'),
                'item_warehouse_destination_text'=> $this->request->getPost('warehouse_to_text'),
            ];

            $validation->setRules([
                'item_warehouse_from_id'    => ['rules' => 'required'],
                'item_qty'                  => ['rules' => 'required|greater_than[0]'],
                'item_id'                   => ['rules' => 'required'],
            ]);

            if ($validation->run($input) === FALSE) {

                $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

            } else {

                $input['item_user_id'] = $this->userLogin['user_id'];

                $getTempCheck =  $this->M_stock_transfer->getTempCheck($input['item_id'])->getResultArray();

                if($input['item_qty'] + $getTempCheck[0]['total_temp'] > $input['item_last_stock']){

                    $result = ['success' => FALSE, 'message' => 'Stock tidak cukup atau tertahan di user lain'];

                }else{
                    $save = $this->M_stock_transfer->insertTemp($input);

                    if ($save) {

                        $result = ['success' => TRUE, 'message' => 'Data item berhasil ditambahkan'];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data item gagal ditambahkan'];

                    }
                }

            }

            $getTemp = $this->M_stock_transfer->getTemp($this->userLogin['user_id'])->getResultArray();

            $find_result = [];

            foreach ($getTemp as $k => $v) {

                $find_result[$k] = esc($v);

            }

            $result['data'] = $find_result;

            $result['csrfHash'] = csrf_hash();

        }else {

            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah transfer stock'];

        }

        resultJSON($result);
    }


    public function getTransferTemp()
    {
        $getTemp = $this->M_stock_transfer->getTemp($this->userLogin['user_id'])->getResultArray();


        $find_result = [];

        foreach ($getTemp as $k => $v) {

            $find_result[$k] = esc($v);

        }

        $result['data'] = $find_result;

        $result['csrfHash'] = csrf_hash();

        $result['success'] = 'TRUE';

        resultJSON($result);
    }


    public function tempDelete($item_id = '')

    {
        $this->validationRequest(TRUE);

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        if ($this->role->hasRole('transfer_stock.delete')) {

            if ($item_id != '') {

                $item_user_id = $this->userLogin['user_id'];

                $delete = $this->M_stock_transfer->deletetemp($item_id, $item_user_id);

                if ($delete) {

                    $getTemp = $this->M_stock_transfer->getTemp($this->userLogin['user_id'])->getResultArray();

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

        }else {

            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus data ini'];

        }

        resultJSON($result);
    }

    public function save($type)
    {

        $this->validationRequest(TRUE, 'POST');

        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];

        $validation =  \Config\Services::validation();

        $input = [
            'hd_transfer_stock_warehose_from'         => $this->request->getPost('hd_transfer_stock_warehose_from'),
            'hd_transfer_stock_warehose_to'           => $this->request->getPost('hd_transfer_stock_warehose_to'),
            'hd_transfer_stock_remark'                => $this->request->getPost('hd_transfer_stock_remark'),
            'hd_transfer_stock_date'                  => $this->request->getPost('hd_transfer_stock_date'),
            'is_consignment'                          => $this->request->getPost('is_consignment'),
        ];

        $validation->setRules([
            'hd_transfer_stock_warehose_from'      => ['rules' => 'required'],
            'hd_transfer_stock_warehose_to'        => ['rules' => 'required'],
            'hd_transfer_stock_date'               => ['rules' => 'required'],
            'is_consignment'                       => ['rules' => 'required'],
            'hd_transfer_stock_remark'             => ['rules' => 'max_length[500]']
        ]);

        if ($validation->run($input) === FALSE) {

            $result = ['success' => FALSE, 'message' => 'Silahkan Input Semua Data Terlebih Dahulu'];

        } else {

            if ($this->role->hasRole('transfer_stock.add')) {

                if($input['is_consignment'] == 'Y'){
                    $input['hd_transfer_stock_consignment_status'] = 'Pending';
                }

                $input['user_id']= $this->userLogin['user_id'];

                    $save = $this->M_stock_transfer->insertStockTransfer($input);

                    if ($save['success']) {

                        $result = ['success' => TRUE, 'message' => 'Data Transfer Stock berhasil disimpan', 'hd_transfer_stock_id ' => $save['hd_transfer_stock_id']];

                    } else {

                        $result = ['success' => FALSE, 'message' => 'Data Transfer Stock gagal disimpan'];

                    }

            } else {

                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah Transfer Stock'];

            }

        }

        $result['csrfHash'] = csrf_hash();

        resultJSON($result);

    }

    public function getStockTransferDetail($hd_transfer_stock_id = '')
    {

        if ($hd_transfer_stock_id == '') {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        } else {

            $getOrder =  $this->M_stock_transfer->getHdTransferStockdetail($hd_transfer_stock_id)->getRowArray();

            $getDtOrder =  $this->M_stock_transfer->getDtTransferStockdetail($hd_transfer_stock_id)->getResultArray();

            if ($getOrder == NULL) {

                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            } else {

                $data = [

                    'hdTransfer' => $getOrder,

                    'dtTransfer' => $getDtOrder

                ];

                return view('webmin/stock_transfer/stock_transfer_detail', $data);

            }

        }

    }


}
