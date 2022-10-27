<?php


namespace App\Controllers\Webmin;

use App\Models\M_product;
use App\Controllers\Base\WebminController;


class Product extends WebminController
{
    protected $M_product;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_product = new M_product;
    }

    public function index()
    {
        $data = [
            'title'         => 'Produk'
        ];
        return $this->renderView('masterdata/product', $data, 'product.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('product.view')) {
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
            'product_id'           => $this->request->getPost('product_id'),
            'product_name'         => $this->request->getPost('product_name'),
            'category_id'          => $this->request->getPost('category_id'),
            'brand_id'             => $this->request->getPost('brand_id'),
            'supplier_id'          => $this->request->getPost('supplier_id'),
            'base_unit'            => $this->request->getPost('base_unit'),
            'is_parcel'            => $this->request->getPost('is_parcel'),
            'has_tax'              => $this->request->getPost('has_tax'),
            'active'               => $this->request->getPost('active'),
            'min_stock'            => $this->request->getPost('min_stock'),
            'product_description'  => $this->request->getPost('product_description'),
            'upload_image'         => $this->request->getFile('upload_image')
        ];

        $old_product_image  = $this->request->getPost('old_product_image');
        $isUploadFile       = FALSE;

        $validation->setRules([
            'product_id'            => ['rules' => 'required'],
            'product_name'          => ['rules' => 'required|max_length[200]'],
            'category_id'           => ['rules' => 'required'],
            'brand_id'              => ['rules' => 'required'],
            'supplier_id'           => ['rules' => 'required'],
            'base_unit'             => ['rules' => 'required'],
            'is_parcel'             => ['rules' => 'required|in_list[Y,N]'],
            'has_tax'               => ['rules' => 'required|in_list[Y,N]'],
            'active'                => ['rules' => 'required|in_list[Y,N]'],
            'min_stock'             => ['rules' => 'required'],
            'product_description'   => ['rules' => 'max_length[500]']
        ]);

        if ($input['upload_image'] != NULL) {
            $maxUploadSize = $this->maxUploadSize['kb'];
            $ext = implode(',', $this->myConfig->uploadFileType['image']);
            $validation->setRules([
                'upload_image' => ['label' => 'upload_image', 'rules' => 'max_size[upload_image,' . $maxUploadSize . ']|ext_in[upload_image,' . $ext . ']|is_image[upload_image]'],
            ]);
        }

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($input['upload_image'] != NULL) {
                helper(['upload', 'text']);
                $renameTo       = random_string('alnum', 10)  . date('dmyHis');;
                $uploadImage    = upload_image('upload_image', $renameTo, 'product');
                if ($uploadImage != '') {
                    $isUploadFile  = TRUE;
                    $input['product_image'] = $uploadImage;
                }
            }
            unset($input['upload_image']);

            if ($type == 'add') {
                if ($this->role->hasRole('product.manage')) {
                    unset($input['product_id']);
                    $save = $this->M_product->insertProduct($input);
                    if ($save) {
                        if ($isUploadFile) {
                            deleteImage($old_product_image, 'product');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data produk berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data produk gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah atau mengubah produk'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('product.manage')) {
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
        $namafile = 'wpFyq8Q9ds261022232906.jpg';
        deleteImage($namafile, 'product');


        // $this->validationRequest(TRUE);
        // $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        // if ($this->role->hasRole('category.delete')) {
        //     $hasProduct = $this->M_category->hasProduct($category_id);
        //     if ($hasProduct) {
        //         $result = ['success' => FALSE, 'message' => 'Kategori tidak dapat dihapus'];
        //     } else {
        //         if ($category_id != '') {
        //             $delete = $this->M_category->deleteCategory($category_id);
        //             if ($delete) {
        //                 $result = ['success' => TRUE, 'message' => 'Data kategori berhasil dihapus'];
        //             } else {
        //                 $result = ['success' => FALSE, 'message' => 'Data kategori gagal dihapus'];
        //             }
        //         }
        //     }
        // } else {
        //     $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus kategori'];
        // }
        // resultJSON($result);
    }

    //--------------------------------------------------------------------

}
