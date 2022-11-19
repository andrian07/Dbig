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
            'title'             => 'Produk',
            'customer_group'    => $this->appConfig->get('default', 'customer_group')
        ];
        return $this->renderView('masterdata/product', $data, 'product.view');
    }

    public function table()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('product.view')) {
            helper('datatable');
            $filter_category        = $this->request->getPost('filter_category');
            $filter_brand           = $this->request->getPost('filter_brand');
            $filter_supplier        = $this->request->getPost('filter_supplier');
            $filter_product_type    = $this->request->getPost('filter_product_type');

            $table = new \App\Libraries\Datatables('ms_product_supplier');
            $table->db->select("ms_product.*,ms_category.category_name,ms_brand.brand_name,GROUP_CONCAT(JSON_OBJECT('supplier_id',ms_product_supplier.supplier_id,'supplier_name',ms_supplier.supplier_name)) as product_supplier");
            $table->db->join('ms_supplier', 'ms_supplier.supplier_id=ms_product_supplier.supplier_id');
            $table->db->join('ms_product', 'ms_product.product_id=ms_product_supplier.product_id');
            $table->db->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id');
            $table->db->join('ms_category', 'ms_category.category_id=ms_product.category_id');
            $table->db->where('ms_product.deleted', 'N');

            if (!($filter_category == '' ||  $filter_category == NULL)) {
                $table->db->where('ms_product.category_id', $filter_category);
            }

            if (!($filter_brand == '' ||  $filter_brand == NULL)) {
                $table->db->where('ms_product.brand_id', $filter_brand);
            }

            if (!($filter_supplier == '' ||  $filter_supplier == NULL)) {
                $table->db->where('ms_product_supplier.supplier_id', $filter_supplier);
            }

            if (!($filter_product_type == '' ||  $filter_product_type == NULL)) {
                $table->db->where('ms_product.is_parcel', $filter_product_type);
            }



            $table->db->groupBy('ms_product_supplier.product_id');



            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = '<b>' . esc($row['product_code']) . '</b><br/>' . esc($row['product_name']);
                $column[] = esc($row['brand_name']);
                $column[] = esc($row['category_name']);

                $suppliers = [];
                $json = json_decode('[' . $row['product_supplier'] . ']', TRUE);
                foreach ($json as $val) {
                    $suppliers[] = '<span class="badge badge-primary">' . $val['supplier_name'] . '</span>';
                }
                $column[] = implode("<br>", $suppliers);

                $column[] = $row['is_parcel'] == 'Y' ? activeSymbol(TRUE) : activeSymbol(FALSE);
                $column[] = $row['has_tax'] == 'Y' ? activeSymbol(TRUE) : activeSymbol(FALSE);
                $column[] = $row['active'] == 'Y' ? activeSymbol(TRUE) : activeSymbol(FALSE);

                $noImage  = base_url('assets/images/no-image.PNG');
                $thumbUrl = getImage($row['product_image'], 'product', TRUE, $noImage);
                $imageUrl = getImage($row['product_image'], 'product', FALSE, $noImage);
                $column[] = fancy_image(esc($row['product_name']), $imageUrl, $thumbUrl, 'img-thumbnail');


                $btns = [];
                $prop =  'data-id="' . $row['product_id'] . '" data-name="' . esc($row['product_name']) . '" data-parcel="' . $row['is_parcel'] . '"';

                $btns[] = '<button class="btn btn-sm btn-default btnsetup mb-2" ' . $prop . ' data-toggle="tooltip" data-placement="top" data-title="Pengaturan Produk"><i class="fas fa-cog"></i></button>&nbsp;';
                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="' . base_url('webmin/product/detail/' . $row['product_id']) . '" class="btn btn-sm btn-default mb-2" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a><br />';

                $btns[] = button_edit($prop);
                $btns[] = '&nbsp;';
                $btns[] = button_delete($prop);
                $column[] = implode('', $btns);

                return $column;
            });

            $table->orderColumn  = ['', 'ms_product.product_name', 'ms_brand.brand_name', 'ms_category.category_name', '', 'ms_product.is_parcel', 'ms_product.has_tax', 'ms_product.active', '', ''];
            $table->searchColumn = ['ms_product.product_code', 'ms_product.product_name'];
            $table->generate();
        }
    }

    public function getById($product_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data produk tidak ditemukan'];
        if ($this->role->hasRole('product.view')) {
            if ($product_id != '') {
                $find = $this->M_product->getProduct($product_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data produk tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                        if ($k == 'product_image') {
                            $noImage  = base_url('assets/images/no-image.PNG');
                            $imageUrl = getImage($v, 'product', FALSE, $noImage);
                            $find_result['image_url'] = $imageUrl;
                        }
                    }

                    $product_supplier =  $this->M_product->getProductSupplier($product_id)->getResultArray();

                    $result = [
                        'success' => TRUE,
                        'exist' => TRUE,
                        'data' => $find_result,
                        'product_supplier' => $product_supplier,
                        'message' => ''
                    ];
                }
            }
        }

        resultJSON($result);
    }

    public function getProductUnit($product_id = '')
    {
        //$this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data produk tidak ditemukan'];
        if ($this->role->hasRole('product.view')) {
            if ($product_id != '') {
                $find = $this->M_product->getProduct($product_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data produk tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                        if ($k == 'product_image') {
                            $noImage  = base_url('assets/images/no-image.PNG');
                            $imageUrl = getImage($v, 'product', FALSE, $noImage);
                            $find_result['image_url'] = $imageUrl;
                        }
                    }

                    $product_unit = [];

                    $getProductUnit =  $this->M_product->getProductUnit($product_id)->getResultArray();
                    foreach ($getProductUnit as $pu) {
                        $_product_unit = [];
                        foreach ($pu as $k => $v) {
                            $_product_unit[$k] = esc($v);
                            if ($k == 'disc_start_date' || $k == 'disc_end_date') {
                                $_product_unit['indo_' . $k] = indo_short_date($v);
                            }
                        }
                        $product_unit[] = $_product_unit;
                    }


                    $result = [
                        'success' => TRUE,
                        'exist' => TRUE,
                        'data' => $find_result,
                        'product_unit' => $product_unit,
                        'message' => ''
                    ];
                }
            }
        }

        resultJSON($result);
    }

    public function getByName()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data product tidak ditemukan'];
        if ($this->role->hasRole('product.view')) {
            $product_name = $this->request->getGet('product_name');
            if (!($product_name == '' || $product_name == NULL)) {
                $find = $this->M_product->getProductByName($product_name, TRUE)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data produk tidak ditemukan'];
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

            'is_parcel'             => ['rules' => 'required|in_list[Y,N]'],
            'has_tax'               => ['rules' => 'required|in_list[Y,N]'],
            'active'                => ['rules' => 'required|in_list[Y,N]'],
            'min_stock'             => ['rules' => 'required'],
            'product_description'   => ['rules' => 'max_length[500]']
        ]);

        if ($type == 'add') {
            $validation->setRules([
                'base_unit'             => ['rules' => 'required'],
            ]);
        }

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
                    if (isset($input['base_unit'])) {
                        unset($input['base_unit']);
                    }
                    $save = $this->M_product->updateProduct($input);
                    if ($save) {
                        if ($isUploadFile) {
                            deleteImage($old_product_image, 'product');
                        }
                        $result = ['success' => TRUE, 'message' => 'Data produk berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data produk gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah atau mengubah produk'];
                }
            }
        }


        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function delete($product_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('product.delete')) {
            $hasProduct = $this->M_product->hasTransaction($product_id);
            if ($hasProduct) {
                $result = ['success' => FALSE, 'message' => 'Produk tidak dapat dihapus'];
            } else {
                if ($product_id != '') {
                    $delete = $this->M_product->deleteProduct($product_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data produk berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data produk gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus produk'];
        }
        resultJSON($result);
    }

    //--------------------------------------------------------------------

}
