<?php


namespace App\Controllers\Webmin;

use App\Models\M_warehouse;
use App\Controllers\Base\WebminController;

class StockOpname extends WebminController
{
    protected $M_stock_opname;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_stock_opname = new M_warehouse;
    }

    public function index()
    {
        $data = [
            'title'         => 'Stok Opname'
        ];

        return $this->renderView('stock_opname/stock_opname', $data, 'stock_opname.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('stock_opname.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('hd_opname');
            $table->db->select('hd_opname.opname_id,hd_opname.opname_code,hd_opname.opname_date,ms_warehouse.warehouse_code,ms_warehouse.warehouse_name,hd_opname.opname_total,user_account.user_realname');
            $table->db->join('ms_warehouse', 'ms_warehouse.warehouse_id=hd_opname.warehouse_id');
            $table->db->join('user_account', 'user_account.user_id=hd_opname.user_id');
            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['opname_code']);
                $column[] = indo_short_date($row['opname_date']);
                $column[] = esc($row['warehouse_code'] . ' - ' . $row['warehouse_name']);
                $column[] = numberFormat($row['opname_total'], TRUE);
                $column[] = esc($row['user_realname']);
                $btns = [];
                $prop =  'data-id="' . $row['opname_id'] . '"';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['hd_opname.opname_id', 'hd_opname.opname_code', 'hd_opname.opname_date', 'ms_warehouse.warehouse_code', 'hd_opname.opname_total', 'user_account.user_realname', ''];
            $table->searchColumn = ['hd_opname.opname_code'];
            $table->generate();
        }
    }

    public function getById($warehouse_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data gudang tidak ditemukan'];
        if ($this->role->hasRole('warehouse.view')) {
            if ($warehouse_id != '') {
                $find = $this->M_warehouse->getWarehouse($warehouse_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data satuan tidak ditemukan'];
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

    public function getByCode()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data gudang tidak ditemukan'];
        if ($this->role->hasRole('warehouse.view')) {
            $warehouse_code = $this->request->getGet('warehouse_code');
            if (!($warehouse_code == '' || $warehouse_code == NULL)) {
                $find = $this->M_warehouse->getWarehouseByCode($warehouse_code, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data gudang tidak ditemukan'];
                } else {
                    $find_result = array();
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                    }
                    $result = ['success' => TRUE, 'exist' => TRUE, 'data' => $find_result, 'message' => ''];
                }
            }
        }
        resultJSON($result);
    }

    public function getByName()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data gudang tidak ditemukan'];
        if ($this->role->hasRole('warehouse.view')) {
            $warehouse_name = $this->request->getGet('warehouse_name');
            if (!($warehouse_name == '' || $warehouse_name == NULL)) {
                $find = $this->M_warehouse->getWarehouseByName($warehouse_name, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data gudang tidak ditemukan'];
                } else {
                    $find_result = array();
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                    }
                    $result = ['success' => TRUE, 'exist' => TRUE, 'data' => $find_result, 'message' => ''];
                }
            }
        }
        resultJSON($result);
    }

    public function opnameProduct()
    {
        $this->validationRequest(TRUE);
        $user_id = $this->userLogin['user_id'];
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();
        $input = [
            'warehouse_id'              => $this->request->getPost('warehouse_id'),
            'product_id'                => $this->request->getPost('product_id'),
        ];

        $validation->setRules([
            'warehouse_id'              => ['rules' => 'required'],
            'product_id'                => ['rules' => 'required'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($this->role->hasRole('stock_opname.add')) {
                $warehouse_id   = $input['warehouse_id'];
                $product_id     = is_array($input['product_id']) ? $input['product_id'] : explode(',', $input['product_id']);
                $save = $this->M_stock_opname->opnameProduct($warehouse_id, $product_id, $user_id);
                if ($save) {
                    $result = ['success' => TRUE, 'message' => 'Data gudang berhasil disimpan'];
                } else {
                    $result = ['success' => FALSE, 'message' => 'Data gudang gagal disimpan'];
                }
            } else {
                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah stok opname'];
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function save($type)
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();
        $input = [
            'warehouse_id'           => $this->request->getPost('warehouse_id'),
            'warehouse_code'         => $this->request->getPost('warehouse_code'),
            'warehouse_name'         => $this->request->getPost('warehouse_name'),
            'store_id'               => $this->request->getPost('store_id'),
            'warehouse_address'      => $this->request->getPost('warehouse_address'),
        ];

        $validation->setRules([
            'warehouse_id'           => ['rules' => 'required'],
            'warehouse_code'         => ['rules' => 'required|max_length[10]'],
            'warehouse_name'         => ['rules' => 'required|max_length[200]'],
            'store_id'               => ['rules' => 'required'],
            'warehouse_address'      => ['rules' => 'max_length[500]']
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($type == 'add') {
                if ($this->role->hasRole('warehouse.add')) {
                    unset($input['warehouse_id']);
                    $save = $this->M_warehouse->insertWarehouse($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data gudang berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data gudang gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah gudang'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('warehouse.edit')) {
                    $save = $this->M_warehouse->updateWarehouse($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data gudang berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data gudang gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah gudang'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($warehouse_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('warehouse.delete')) {
            if ($warehouse_id != '') {
                $hasTransaction = $this->M_warehouse->hasTransaction($warehouse_id);
                if ($hasTransaction) {
                    $result = ['success' => FALSE, 'message' => 'Gudang tidak dapat dihapus'];
                } else {
                    $delete = $this->M_warehouse->deleteWarehouse($warehouse_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data gudang berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data gudang gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus gudang'];
        }
        resultJSON($result);
    }

    //--------------------------------------------------------------------

}
