<?php


namespace App\Controllers\Webmin;

use App\Models\M_unit;
use App\Controllers\Base\WebminController;

class Unit extends WebminController
{
    protected $M_unit;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_unit = new M_unit;
    }

    public function index()
    {
        $data = [
            'title'         => 'Satuan'
        ];

        return $this->renderView('masterdata/unit', $data, 'unit.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('unit.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('ms_unit');
            $table->db->select('unit_id,unit_name,unit_description');
            $table->db->where('deleted', 'N');

            $table->renderColumn(function ($row, $i) {
                $column = [];

                $column[] = $i;
                $column[] = esc($row['unit_name']);
                $column[] = esc($row['unit_description']);

                $btns = [];
                $prop =  'data-id="' . $row['unit_id'] . '" data-name="' . esc($row['unit_name']) . '"';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);

                return $column;
            });

            $table->orderColumn  = ['', 'unit_name', 'unit_description', ''];
            $table->searchColumn = ['unit_name', 'unit_description'];
            $table->generate();
        }
    }

    public function getById($unit_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data satuan tidak ditemukan'];
        if ($this->role->hasRole('unit.view')) {
            if ($unit_id != '') {
                $find = $this->M_unit->getUnit($unit_id)->getRowArray();
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

    public function getByName()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data satuan tidak ditemukan'];
        if ($this->role->hasRole('unit.view')) {
            $unit_name = $this->request->getGet('unit_name');
            if (!($unit_name == '' || $unit_name == NULL)) {
                $find = $this->M_unit->getUnitByName($unit_name, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data satuan tidak ditemukan'];
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
            'unit_id'           => $this->request->getPost('unit_id'),
            'unit_name'         => $this->request->getPost('unit_name'),
            'unit_description'  => $this->request->getPost('unit_description'),
        ];

        $validation->setRules([
            'unit_id'           => ['rules' => 'required'],
            'unit_name'         => ['rules' => 'required|max_length[200]|is_unique[ms_unit.unit_name,unit_id,{unit_id}]'],
            'unit_description'  => ['rules' => 'max_length[500]']
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($type == 'add') {
                if ($this->role->hasRole('unit.add')) {
                    unset($input['unit_id']);
                    $save = $this->M_unit->insertUnit($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data satuan berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data satuan gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah satuan'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('unit.edit')) {
                    $save = $this->M_unit->updateUnit($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data satuan berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data satuan gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah satuan'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($unit_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('unit.delete')) {
            if ($unit_id != '') {
                $hasProduct = $this->M_unit->hasProduct($unit_id);
                if ($hasProduct) {
                    $result = ['success' => FALSE, 'message' => 'Satuan tidak dapat dihapus'];
                } else {
                    $delete = $this->M_unit->deleteUnit($unit_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data satuan berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data satuan gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus satuan'];
        }
        resultJSON($result);
    }

    //--------------------------------------------------------------------

}
