<?php


namespace App\Controllers\Webmin;

use App\Models\M_category;
use App\Controllers\Base\WebminController;

class Category extends WebminController
{
    protected $M_category;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_category = new M_category;
    }

    public function index()
    {
        $data = [
            'title'         => 'Kategori'
        ];
        return $this->renderView('masterdata/category', $data, 'category.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('category.view')) {
            helper('datatable');
            $table = new \App\Libraries\Datatables('ms_category');
            $table->db->select('category_id,category_name,category_description');
            $table->db->where('deleted', 'N');

            $table->renderColumn(function ($row, $i) {
                $column = [];

                $column[] = $i;
                $column[] = esc($row['category_name']);
                $column[] = esc($row['category_description']);

                $btns = [];
                $prop =  'data-id="' . $row['category_id'] . '" data-name="' . esc($row['category_name']) . '"';
                $btns[] = button_edit($prop);
                $btns[] = button_delete($prop);
                $column[] = implode('&nbsp;', $btns);

                return $column;
            });

            $table->orderColumn  = ['', 'category_name', 'category_description', ''];
            $table->searchColumn = ['category_name', 'category_description'];
            $table->generate();
        }
    }

    public function getById($category_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data kategori tidak ditemukan'];
        if ($this->role->hasRole('category.view')) {
            if ($category_id != '') {
                $find = $this->M_category->getCategory($category_id)->getRowArray();
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

    public function getByName()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data kategori tidak ditemukan'];
        if ($this->role->hasRole('category.view')) {
            $category_name = $this->request->getGet('category_name');
            if (!($category_name == '' || $category_name == NULL)) {
                $find = $this->M_category->getCategoryByName($category_name, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data kategori tidak ditemukan'];
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
            'category_id'           => $this->request->getPost('category_id'),
            'category_name'         => $this->request->getPost('category_name'),
            'category_description'  => $this->request->getPost('category_description'),
        ];

        $validation->setRules([
            'category_id'           => ['rules' => 'required'],
            'category_name'         => ['rules' => 'required|max_length[200]|is_unique[ms_category.category_name,category_id,{category_id}]'],
            'category_description'  => ['rules' => 'max_length[500]']
        ]);


        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($type == 'add') {
                if ($this->role->hasRole('category.add')) {
                    unset($input['category_id']);
                    $save = $this->M_category->insertCategory($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data kategori berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data kategori gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah kategori'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('category.edit')) {
                    $save = $this->M_category->updateCategory($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data kategori berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data kategori gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk mengubah kategori'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($category_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('category.delete')) {
            $hasProduct = $this->M_category->hasProduct($category_id);
            if ($hasProduct) {
                $result = ['success' => FALSE, 'message' => 'Kategori tidak dapat dihapus'];
            } else {
                if ($category_id != '') {
                    $delete = $this->M_category->deleteCategory($category_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data kategori berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data kategori gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus kategori'];
        }
        resultJSON($result);
    }

    //--------------------------------------------------------------------

}
