<?php


namespace App\Controllers\Webmin;

use App\Models\M_brand;
use App\Controllers\Base\WebminController;

class Brand extends WebminController
{
    protected $M_brand;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_brand = new M_brand;
    }

    public function index()
    {
        $data = [
            'title'         => 'Brand'
        ];

        return $this->renderView('masterdata/brand', $data, 'brand.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('brand.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('ms_brand');
            $table->db->select('brand_id,brand_name,brand_description');
            $table->db->where('deleted', 'N');

            $table->renderColumn(function ($row, $i) {
                $column = [];

                $column[] = $i;
                $column[] = esc($row['brand_name']);
                $column[] = esc($row['brand_description']);

                $btns = [];
                $prop =  'data-id="' . $row['brand_id'] . '" data-name="' . esc($row['brand_name']) . '"';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);

                return $column;
            });

            $table->orderColumn  = ['', 'brand_name', 'brand_description', ''];
            $table->searchColumn = ['brand_name', 'brand_description'];
            $table->generate();
        }
    }

    public function getById($brand_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data brand tidak ditemukan'];
        if ($this->role->hasRole('brand.view')) {
            if ($brand_id != '') {
                $find = $this->M_brand->getBrand($brand_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data brand tidak ditemukan'];
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
        $result = ['success' => FALSE, 'message' => 'Data brand tidak ditemukan'];
        if ($this->role->hasRole('brand.view')) {
            $brand_name = $this->request->getGet('brand_name');
            if (!($brand_name == '' || $brand_name == NULL)) {
                $find = $this->M_brand->getBrandByName($brand_name, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data brand tidak ditemukan'];
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
            'brand_id'           => $this->request->getPost('brand_id'),
            'brand_name'         => $this->request->getPost('brand_name'),
            'brand_description'  => $this->request->getPost('brand_description'),
        ];

        $validation->setRules([
            'brand_id'           => ['rules' => 'required'],
            'brand_name'         => ['rules' => 'required|max_length[200]|is_unique[ms_brand.brand_name,brand_id,{brand_id}]'],
            'brand_description'  => ['rules' => 'max_length[500]']
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($type == 'add') {
                if ($this->role->hasRole('brand.add')) {
                    unset($input['brand_id']);
                    $save = $this->M_brand->insertBrand($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data brand berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data brand gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah brand'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('brand.edit')) {
                    $save = $this->M_brand->updateBrand($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data brand berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data brand gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah brand'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($brand_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('brand.delete')) {
            if ($brand_id != '') {
                $hasProduct = $this->M_brand->hasProduct($brand_id);
                if ($hasProduct) {
                    $result = ['success' => FALSE, 'message' => 'Brand tidak dapat dihapus'];
                } else {
                    $delete = $this->M_brand->deleteBrand($brand_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data brand berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data brand gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus brand'];
        }
        resultJSON($result);
    }

    //--------------------------------------------------------------------

}
