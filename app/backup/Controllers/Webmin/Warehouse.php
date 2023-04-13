<?php


namespace App\Controllers\Webmin;

use App\Models\M_warehouse;
use App\Controllers\Base\WebminController;

class Warehouse extends WebminController
{
    protected $M_warehouse;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_warehouse = new M_warehouse;
    }

    public function index()
    {
        $data = [
            'title'         => 'Gudang'
        ];

        return $this->renderView('masterdata/warehouse', $data, 'warehouse.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('warehouse.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('ms_warehouse');
            $table->db->select('ms_warehouse.*,ms_store.store_name');
            $table->db->join('ms_store', 'ms_store.store_id=ms_warehouse.store_id');
            $table->db->where('ms_warehouse.deleted', 'N');

            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['warehouse_code']);
                $column[] = esc($row['warehouse_name']);
                $column[] = esc($row['store_name']);
                $column[] = esc($row['warehouse_address']);
                $btns = [];
                $prop =  'data-id="' . $row['warehouse_id'] . '" data-name="' . esc($row['warehouse_name']) . '" data-code="' . esc($row['warehouse_code']) . '"';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['', 'ms_warehouse.warehouse_code', 'ms_warehouse.warehouse_name', 'ms_store.store_name', 'ms_warehouse.warehouse_address', ''];
            $table->searchColumn = ['ms_warehouse.warehouse_code', 'ms_warehouse.warehouse_name', 'ms_store.store_name', 'ms_warehouse.warehouse_address'];
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
