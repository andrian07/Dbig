<?php


namespace App\Controllers\Webmin;

use App\Models\M_salesman;
use App\Controllers\Base\WebminController;

class Salesman extends WebminController
{
    protected $M_salesman;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_salesman = new M_salesman;
    }

    public function index()
    {
        $data = [
            'title'         => 'Salesman'
        ];

        return $this->renderView('masterdata/salesman', $data, 'salesman.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('salesman.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('ms_salesman');
            $table->db->select('ms_salesman.*,ms_store.store_code,ms_store.store_name');
            $table->db->join('ms_store', 'ms_store.store_id=ms_salesman.store_id');
            $table->db->where('ms_salesman.deleted', 'N');

            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = esc($row['salesman_code']);
                $column[] = esc($row['salesman_name']);
                $column[] = esc($row['salesman_address']);
                $column[] = esc($row['salesman_phone']);
                $column[] = esc($row['store_name']);
                $btns = [];
                $prop =  'data-id="' . $row['salesman_id'] . '" data-name="' . esc($row['salesman_name']) . '" data-code="' . esc($row['salesman_code']) . '"';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);
                return $column;
            });

            $table->orderColumn  = ['ms_salesman.salesman_id', 'ms_salesman.salesman_code', 'ms_salesman.salesman_name', 'ms_salesman.salesman_address', 'ms_salesman.salesman_phone', 'ms_store.store_name', ''];
            $table->searchColumn = ['ms_salesman.salesman_code', 'ms_salesman.salesman_name'];
            $table->generate();
        }
    }

    public function getById($salesman_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data salesman tidak ditemukan'];
        if ($this->role->hasRole('salesman.view')) {
            if ($salesman_id != '') {
                $find = $this->M_salesman->getSalesman($salesman_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data salesman tidak ditemukan'];
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
        $result = ['success' => FALSE, 'message' => 'Data salesman tidak ditemukan'];
        if ($this->role->hasRole('salesman.view')) {
            $salesman_code = $this->request->getGet('salesman_code');
            if (!($salesman_code == '' || $salesman_code == NULL)) {
                $find = $this->M_salesman->getSalesmanByCode($salesman_code, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data salesman tidak ditemukan'];
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
            'salesman_id'           => $this->request->getPost('salesman_id'),
            'salesman_code'         => $this->request->getPost('salesman_code'),
            'salesman_name'         => $this->request->getPost('salesman_name'),
            'salesman_address'      => $this->request->getPost('salesman_address'),
            'salesman_phone'        => $this->request->getPost('salesman_phone'),
            'store_id'              => $this->request->getPost('store_id'),
        ];

        $validation->setRules([
            'salesman_id'           => ['rules' => 'required'],
            'salesman_code'         => ['rules' => 'required|max_length[10]'],
            'salesman_name'         => ['rules' => 'required|max_length[200]'],
            'salesman_address'      => ['rules' => 'max_length[500]'],
            'salesman_phone'        => ['rules' => 'required|min_length[8]|max_length[15]'],
            'store_id'              => ['rules' => 'required'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($type == 'add') {
                if ($this->role->hasRole('salesman.add')) {
                    unset($input['salesman_id']);
                    $save = $this->M_salesman->insertSalesman($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data salesman berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data salesman gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah salesman'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('salesman.edit')) {
                    $save = $this->M_salesman->updateSalesman($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data salesman berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data salesman gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah salesman'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($salesman_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('salesman.delete')) {
            if ($salesman_id != '') {
                $hasTransaction = $this->M_salesman->hasTransaction($salesman_id);
                if ($hasTransaction) {
                    $result = ['success' => FALSE, 'message' => 'Salesman tidak dapat dihapus'];
                } else {
                    $delete = $this->M_salesman->deleteSalesman($salesman_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data salesman berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data salesman gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus salesman'];
        }
        resultJSON($result);
    }

    //--------------------------------------------------------------------

}
