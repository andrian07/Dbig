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

    public function detail($product_id = '')
    {
        if ($product_id == '') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $find = $this->M_product->getProduct($product_id)->getRowArray();
            if ($find == NULL) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            } else {
                $data = [
                    'title' => 'Detail Produk'
                ];

                if ($find['is_parcel'] == 'Y') {
                    $data['product']            = $find;
                    $data['product_supplier']   = $this->M_product->getProductSupplier($product_id)->getResultArray();
                    $data['product_unit']       = $this->M_product->getProductUnit($product_id)->getResultArray();
                    $data['parcel_item']        = $this->M_product->getParcelItem($product_id)->getResultArray();
                    $data['customer_group']     = $this->appConfig->get('default', 'customer_group');

                    //dd($data);
                    return $this->renderView('masterdata/parcel_detail', $data);
                } else {
                    $data['product']            = $find;
                    $data['product_supplier']   = $this->M_product->getProductSupplier($product_id)->getResultArray();
                    $data['product_unit']       = $this->M_product->getProductUnit($product_id)->getResultArray();
                    $data['product_stock']      = $this->M_product->getProductStock($product_id)->getResultArray();
                    $data['customer_group']     = $this->appConfig->get('default', 'customer_group');

                    return $this->renderView('masterdata/product_detail', $data);
                }
            }
        }
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

    public function getProductUnit($product_id = '')
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

    public function getProductUnitByCode()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data produk tidak ditemukan'];
        if ($this->role->hasRole('product.view')) {
            $item_code = $this->request->getGet('item_code');
            if (!($item_code == '' || $item_code == NULL)) {
                $find = $this->M_product->getProductUnitByCode($item_code)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data produk tidak ditemukan'];
                } else {
                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                    }

                    $result = [
                        'success' => TRUE,
                        'exist' => TRUE,
                        'data' => $find_result,
                        'message' => ''
                    ];
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
            'base_cogs'            => $this->request->getPost('base_cogs'),
            'sales_point'          => $this->request->getPost('sales_point'),
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
            'base_cogs'             => ['rules' => 'required'],
            'sales_point'           => ['rules' => 'required|in_list[Y,N]'],
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
                $renameTo       = random_string('alnum', 10)  . date('dmyHis');
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

    public function saveProductUnit($type)
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();

        $input = [
            'item_id'               => $this->request->getPost('item_id'),
            'product_id'            => $this->request->getPost('product_id'),
            'item_code'             => $this->request->getPost('item_code'),
            'unit_id'               => $this->request->getPost('unit_id'),
            'product_content'       => $this->request->getPost('product_content'),
            'purchase_price'        => $this->request->getPost('purchase_price'),
            'purchase_tax'          => $this->request->getPost('purchase_tax'),
            'G1_margin_rate'        => $this->request->getPost('G1_margin_rate'),
            'G1_sales_price'        => $this->request->getPost('G1_sales_price'),
            'G2_margin_rate'        => $this->request->getPost('G2_margin_rate'),
            'G2_sales_price'        => $this->request->getPost('G2_sales_price'),
            'G3_margin_rate'        => $this->request->getPost('G3_margin_rate'),
            'G3_sales_price'        => $this->request->getPost('G3_sales_price'),
            'G4_margin_rate'        => $this->request->getPost('G4_margin_rate'),
            'G4_sales_price'        => $this->request->getPost('G4_sales_price'),
            'G5_margin_rate'        => $this->request->getPost('G5_margin_rate'),
            'G5_sales_price'        => $this->request->getPost('G5_sales_price'),
            'G6_margin_rate'        => $this->request->getPost('G6_margin_rate'),
            'G6_sales_price'        => $this->request->getPost('G6_sales_price'),

            'disc_seasonal'         => $this->request->getPost('disc_seasonal'),
            'disc_start_date'       => $this->request->getPost('disc_start_date'),
            'disc_end_date'         => $this->request->getPost('disc_end_date'),
            'G1_disc_price'         => $this->request->getPost('G1_disc_price'),
            'G1_promo_price'        => $this->request->getPost('G1_promo_price'),
            'G2_disc_price'         => $this->request->getPost('G2_disc_price'),
            'G2_promo_price'        => $this->request->getPost('G2_promo_price'),
            'G3_disc_price'         => $this->request->getPost('G3_disc_price'),
            'G3_promo_price'        => $this->request->getPost('G3_promo_price'),
            'G4_disc_price'         => $this->request->getPost('G4_disc_price'),
            'G4_promo_price'        => $this->request->getPost('G4_promo_price'),
            'G5_disc_price'         => $this->request->getPost('G5_disc_price'),
            'G5_promo_price'        => $this->request->getPost('G5_promo_price'),
            'G6_disc_price'         => $this->request->getPost('G6_disc_price'),
            'G6_promo_price'        => $this->request->getPost('G6_promo_price'),

            'margin_allocation'     => $this->request->getPost('margin_allocation'),
            'G1_margin_allocation'  => $this->request->getPost('G1_margin_allocation'),
            'G2_margin_allocation'  => $this->request->getPost('G2_margin_allocation'),
            'G3_margin_allocation'  => $this->request->getPost('G3_margin_allocation'),
            'G4_margin_allocation'  => $this->request->getPost('G4_margin_allocation'),
            'G5_margin_allocation'  => $this->request->getPost('G5_margin_allocation'),
            'G6_margin_allocation'  => $this->request->getPost('G6_margin_allocation'),

            'is_sale'               => $this->request->getPost('is_sale'),
            'show_on_mobile_app'    => $this->request->getPost('show_on_mobile_app'),
            'allow_change_price'    => $this->request->getPost('allow_change_price')
        ];

        $validation->setRules([
            'item_id'               => ['rules' => 'required'],
            'product_id'            => ['rules' => 'required'],
            'item_code'             => ['rules' => 'required|max_length[20]'],
            'unit_id'               => ['rules' => 'required'],
            'product_content'       => ['rules' => 'required'],
            'purchase_price'        => ['rules' => 'required'],
            'purchase_tax'          => ['rules' => 'required'],
            'G1_margin_rate'        => ['rules' => 'required'],
            'G1_sales_price'        => ['rules' => 'required'],
            'G2_margin_rate'        => ['rules' => 'required'],
            'G2_sales_price'        => ['rules' => 'required'],
            'G3_margin_rate'        => ['rules' => 'required'],
            'G3_sales_price'        => ['rules' => 'required'],
            'G4_margin_rate'        => ['rules' => 'required'],
            'G4_sales_price'        => ['rules' => 'required'],
            'G5_margin_rate'        => ['rules' => 'required'],
            'G5_sales_price'        => ['rules' => 'required'],
            'G6_margin_rate'        => ['rules' => 'required'],
            'G6_sales_price'        => ['rules' => 'required'],

            'disc_seasonal'         => ['rules' => 'required'],
            'G1_disc_price'         => ['rules' => 'required'],
            'G1_promo_price'        => ['rules' => 'required'],
            'G2_disc_price'         => ['rules' => 'required'],
            'G2_promo_price'        => ['rules' => 'required'],
            'G3_disc_price'         => ['rules' => 'required'],
            'G3_promo_price'        => ['rules' => 'required'],
            'G4_disc_price'         => ['rules' => 'required'],
            'G4_promo_price'        => ['rules' => 'required'],
            'G5_disc_price'         => ['rules' => 'required'],
            'G5_promo_price'        => ['rules' => 'required'],
            'G6_disc_price'         => ['rules' => 'required'],
            'G6_promo_price'        => ['rules' => 'required'],

            'margin_allocation'     => ['rules' => 'required'],
            'G1_margin_allocation'  => ['rules' => 'required'],
            'G2_margin_allocation'  => ['rules' => 'required'],
            'G3_margin_allocation'  => ['rules' => 'required'],
            'G4_margin_allocation'  => ['rules' => 'required'],
            'G5_margin_allocation'  => ['rules' => 'required'],
            'G6_margin_allocation'  => ['rules' => 'required'],

            'is_sale'               => ['rules' => 'required|in_list[Y,N]'],
            'show_on_mobile_app'    => ['rules' => 'required|in_list[Y,N]'],
            'allow_change_price'    => ['rules' => 'required|in_list[Y,N]'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($type == 'add') {
                if ($this->role->hasRole('product.manage')) {
                    unset($input['item_id']);
                    $save = $this->M_product->insertProductUnit($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data satuan produk berhasil disimpan'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data satuan produk gagal disimpan'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah atau mengubah satuan produk'];
                }
            } else if ($type == 'edit') {
                if ($this->role->hasRole('product.manage')) {
                    $save = $this->M_product->updateProductUnit($input);
                    if ($save) {
                        $result = ['success' => TRUE, 'message' => 'Data satuan produk berhasil diperbarui'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data satuan produk gagal diperbarui'];
                    }
                } else {
                    $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah atau mengubah satuan produk'];
                }
            }
        }

        $product_unit = [];
        if ($input['product_id'] != NULL) {
            $getProductUnit =  $this->M_product->getProductUnit($input['product_id'])->getResultArray();
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
        }

        $result['product_unit'] = $product_unit;
        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function saveParcel()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();

        $input = [
            'item_id'               => $this->request->getPost('item_id'),
            'product_id'            => $this->request->getPost('product_id'),
            'item_code'             => $this->request->getPost('item_code'),
            'unit_id'               => $this->request->getPost('unit_id'),
            'purchase_price'        => $this->request->getPost('purchase_price'),
            'purchase_tax'          => $this->request->getPost('purchase_tax'),
            'G1_margin_rate'        => $this->request->getPost('G1_margin_rate'),
            'G1_sales_price'        => $this->request->getPost('G1_sales_price'),
            'G2_margin_rate'        => $this->request->getPost('G2_margin_rate'),
            'G2_sales_price'        => $this->request->getPost('G2_sales_price'),
            'G3_margin_rate'        => $this->request->getPost('G3_margin_rate'),
            'G3_sales_price'        => $this->request->getPost('G3_sales_price'),
            'G4_margin_rate'        => $this->request->getPost('G4_margin_rate'),
            'G4_sales_price'        => $this->request->getPost('G4_sales_price'),
            'G5_margin_rate'        => $this->request->getPost('G5_margin_rate'),
            'G5_sales_price'        => $this->request->getPost('G5_sales_price'),
            'G6_margin_rate'        => $this->request->getPost('G6_margin_rate'),
            'G6_sales_price'        => $this->request->getPost('G6_sales_price'),

            'disc_seasonal'         => $this->request->getPost('disc_seasonal'),
            'disc_start_date'       => $this->request->getPost('disc_start_date'),
            'disc_end_date'         => $this->request->getPost('disc_end_date'),
            'G1_disc_price'         => $this->request->getPost('G1_disc_price'),
            'G1_promo_price'        => $this->request->getPost('G1_promo_price'),
            'G2_disc_price'         => $this->request->getPost('G2_disc_price'),
            'G2_promo_price'        => $this->request->getPost('G2_promo_price'),
            'G3_disc_price'         => $this->request->getPost('G3_disc_price'),
            'G3_promo_price'        => $this->request->getPost('G3_promo_price'),
            'G4_disc_price'         => $this->request->getPost('G4_disc_price'),
            'G4_promo_price'        => $this->request->getPost('G4_promo_price'),
            'G5_disc_price'         => $this->request->getPost('G5_disc_price'),
            'G5_promo_price'        => $this->request->getPost('G5_promo_price'),
            'G6_disc_price'         => $this->request->getPost('G6_disc_price'),
            'G6_promo_price'        => $this->request->getPost('G6_promo_price'),

            'margin_allocation'     => $this->request->getPost('margin_allocation'),
            'G1_margin_allocation'  => $this->request->getPost('G1_margin_allocation'),
            'G2_margin_allocation'  => $this->request->getPost('G2_margin_allocation'),
            'G3_margin_allocation'  => $this->request->getPost('G3_margin_allocation'),
            'G4_margin_allocation'  => $this->request->getPost('G4_margin_allocation'),
            'G5_margin_allocation'  => $this->request->getPost('G5_margin_allocation'),
            'G6_margin_allocation'  => $this->request->getPost('G6_margin_allocation'),

            'is_sale'               => $this->request->getPost('is_sale'),
            'show_on_mobile_app'    => $this->request->getPost('show_on_mobile_app'),
            'allow_change_price'    => $this->request->getPost('allow_change_price')
        ];

        $validation->setRules([
            'item_id'               => ['rules' => 'required'],
            'product_id'            => ['rules' => 'required'],
            'item_code'             => ['rules' => 'required|max_length[20]'],
            'unit_id'               => ['rules' => 'required'],
            'purchase_price'        => ['rules' => 'required'],
            'purchase_tax'          => ['rules' => 'required'],
            'G1_margin_rate'        => ['rules' => 'required'],
            'G1_sales_price'        => ['rules' => 'required'],
            'G2_margin_rate'        => ['rules' => 'required'],
            'G2_sales_price'        => ['rules' => 'required'],
            'G3_margin_rate'        => ['rules' => 'required'],
            'G3_sales_price'        => ['rules' => 'required'],
            'G4_margin_rate'        => ['rules' => 'required'],
            'G4_sales_price'        => ['rules' => 'required'],
            'G5_margin_rate'        => ['rules' => 'required'],
            'G5_sales_price'        => ['rules' => 'required'],
            'G6_margin_rate'        => ['rules' => 'required'],
            'G6_sales_price'        => ['rules' => 'required'],

            'disc_seasonal'         => ['rules' => 'required'],
            'G1_disc_price'         => ['rules' => 'required'],
            'G1_promo_price'        => ['rules' => 'required'],
            'G2_disc_price'         => ['rules' => 'required'],
            'G2_promo_price'        => ['rules' => 'required'],
            'G3_disc_price'         => ['rules' => 'required'],
            'G3_promo_price'        => ['rules' => 'required'],
            'G4_disc_price'         => ['rules' => 'required'],
            'G4_promo_price'        => ['rules' => 'required'],
            'G5_disc_price'         => ['rules' => 'required'],
            'G5_promo_price'        => ['rules' => 'required'],
            'G6_disc_price'         => ['rules' => 'required'],
            'G6_promo_price'        => ['rules' => 'required'],

            'margin_allocation'     => ['rules' => 'required'],
            'G1_margin_allocation'  => ['rules' => 'required'],
            'G2_margin_allocation'  => ['rules' => 'required'],
            'G3_margin_allocation'  => ['rules' => 'required'],
            'G4_margin_allocation'  => ['rules' => 'required'],
            'G5_margin_allocation'  => ['rules' => 'required'],
            'G6_margin_allocation'  => ['rules' => 'required'],

            'is_sale'               => ['rules' => 'required|in_list[Y,N]'],
            'show_on_mobile_app'    => ['rules' => 'required|in_list[Y,N]'],
            'allow_change_price'    => ['rules' => 'required|in_list[Y,N]'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($this->role->hasRole('product.manage')) {
                $user_id = $this->userLogin['user_id'];
                $save = $this->M_product->updateParcel($input, $user_id);
                if ($save) {
                    $result = ['success' => TRUE, 'message' => 'Data paket produk berhasil diperbarui'];
                } else {
                    $result = ['success' => FALSE, 'message' => 'Data paket produk gagal diperbarui'];
                }
            } else {
                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menambah atau mengubah paket produk'];
            }
        }

        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function deleteProductUnit($item_id = '')
    {
        $this->validationRequest(TRUE);
        $product_id = $this->request->getGet('product_id');
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('product.delete')) {
            $hasTransaction = $this->M_product->productUnitHasTransaction($item_id);
            if ($hasTransaction) {
                $result = ['success' => FALSE, 'message' => 'Satuan produk tidak dapat dihapus'];
            } else {
                if ($item_id != '') {
                    $delete = $this->M_product->deleteProductUnit($item_id);
                    if ($delete) {
                        $result = ['success' => TRUE, 'message' => 'Data satuan produk berhasil dihapus'];
                    } else {
                        $result = ['success' => FALSE, 'message' => 'Data satuan produk gagal dihapus'];
                    }
                }
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menghapus satuan produk'];
        }

        $product_unit = [];
        if ($product_id != NULL) {
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
        }

        $result['product_unit'] = $product_unit;
        resultJSON($result);
    }

    public function getTempParcel($product_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Data produk tidak ditemukan'];
        if ($this->role->hasRole('product.view')) {
            if ($product_id != '') {
                $find = $this->M_product->getProduct($product_id)->getRowArray();
                if ($find == NULL) {
                    $result = ['success' => TRUE, 'exist' => FALSE, 'message' => 'Data produk tidak ditemukan'];
                } else {
                    $import     = $this->request->getGet('import');
                    $user_id    = $this->userLogin['user_id'];

                    $find_result = [];
                    foreach ($find as $k => $v) {
                        $find_result[$k] = esc($v);
                    }

                    $product_unit = [];
                    $getProductUnit = $this->M_product->getProductUnit($product_id)->getRowArray();
                    foreach ($getProductUnit as $k => $v) {
                        $product_unit[$k] = esc($v);
                        if ($k == 'disc_start_date' || $k == 'disc_end_date') {
                            $product_unit['indo_' . $k] = indo_short_date($v);
                        }
                    }


                    if ($import == NULL) {
                        $parcel_item_list = $this->M_product->getTempParcel($product_id, $user_id)->getResultArray();
                    } else {
                        $parcel_item_list = $this->M_product->copyToTempParcel($product_id, $user_id)->getResultArray();
                    }

                    $result = [
                        'success'       => TRUE,
                        'exist'         => TRUE,
                        'data'          => $find_result,
                        'product_unit'  => $product_unit,
                        'item_list'     => $parcel_item_list,
                        'message'       => ''
                    ];
                }
            }
        }

        resultJSON($result);
    }

    public function addTempParcel()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();

        $user_id = $this->userLogin['user_id'];
        $input = [
            'product_id'            => $this->request->getPost('product_id'),
            'item_id'               => $this->request->getPost('item_id'),
            'item_qty'              => $this->request->getPost('item_qty'),
            'user_id'               => $user_id
        ];

        $validation->setRules([
            'product_id'            => ['rules' => 'required'],
            'item_id'               => ['rules' => 'required'],
            'item_qty'              => ['rules' => 'required'],
        ]);

        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            $save = $this->M_product->insertTempParcel($input);
            if ($save) {
                $result = ['success' => TRUE, 'message' => 'Data item paket produk berhasil disimpan'];
            } else {
                $result = ['success' => FALSE, 'message' => 'Data item paket produk gagal disimpan'];
            }
        }

        $parcel_item_list = $this->M_product->getTempParcel($input['product_id'], $user_id)->getResultArray();

        $result['item_list'] = $parcel_item_list;
        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function deleteTempParcel($product_id = '', $item_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($product_id != '' && $item_id != '') {
            $user_id    = $this->userLogin['user_id'];
            $delete     = $this->M_product->deleteTempParcel($item_id, $product_id, $user_id);
            if ($delete) {
                $result = ['success' => TRUE, 'message' => 'Data item parcel berhasil dihapus'];
            } else {
                $result = ['success' => FALSE, 'message' => 'Data item parcel gagal dihapus'];
            }
        }

        $parcel_item_list = $this->M_product->getTempParcel($product_id, $user_id)->getResultArray();
        $result['item_list'] = $parcel_item_list;
        resultJSON($result);
    }

    public function searchProduct()
    {
        $this->validationRequest(TRUE);
        $keyword = $this->request->getGet('term');
        $result = ['success' => FALSE, 'num_product' => 0, 'data' => [], 'message' => ''];
        if (!($keyword == '' || $keyword == NULL)) {

            $db = \Config\Database::connect();
            $find = $db->table('ms_product_unit')
                ->select('ms_product_unit.item_id,ms_product_unit.item_code,ms_product.product_name,ms_unit.unit_name')
                ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
                ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
                ->where('ms_product.deleted', 'N')
                ->where('ms_product.is_parcel', 'N')
                ->like('ms_product.product_name', $keyword)
                ->limit(15)
                ->get()
                ->getResultArray();

            $find_result = [];
            foreach ($find as $row) {
                $diplay_text = $row['item_code'] . ' - ' . $row['product_name'] . ' (' . $row['unit_name'] . ')';
                $find_result[] = [
                    'id'                => $diplay_text,
                    'value'             => $diplay_text,
                    'item_id'           => $row['item_id'],
                    'item_code'         => $row['item_code'],
                    'unit_name'         => $row['unit_name']
                ];
            }
            $result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];
        }
        resultJSON($result);
    }
    //--------------------------------------------------------------------

}
