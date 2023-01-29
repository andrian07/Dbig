<?php

namespace App\Controllers\Webmin;

use App\Controllers\Base\WebminController;
use DateTime;

class Select extends WebminController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        die('Select2 Controllers');
    }

    public function store()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_store');

        $select2->db->select('store_id,store_code,store_name');
        $select2->db->where('deleted', 'N');

        $select2->searchFields  = ['store_code', 'store_name'];
        $select2->orderBy       = 'store_id';
        $select2->orderDir      = 'ASC';

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['store_id']);
            $result['text'] = $row['store_code'] . ' - ' . $row['store_name'];
            return $result;
        });

        $select2->generate();
    }

    public function userGroup()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('user_group');

        $select2->db->select('group_code,group_name');
        $select2->db->where('deleted', 'N');

        $select2->searchFields  = ['group_name'];
        $select2->orderBy       = 'group_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['group_code']);
            $result['text'] = esc($row['group_name']);
            return $result;
        });

        $select2->generate();
    }

    public function userAccount()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('user_account');

        $select2->db->select('user_id,user_code,user_name,user_realname');
        $select2->db->where('deleted', 'N');

        $select2->searchFields  = ['user_name', 'user_realname'];
        $select2->orderBy       = 'user_name';
        $select2->orderDir      = 'ASC';

        $store_id = $this->request->getGet('store_id');
        if ($store_id != NULL) {
            $list_store_id = explode(',', $store_id);
            $select2->db->whereIn('store_id', $list_store_id);
        }

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['user_id']);
            $result['text'] = $row['user_name'] . ' - ' . $row['user_realname'];
            return $result;
        });

        $select2->generate();
    }

    public function pcProvinces()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('pc_provinces');
        $select2->db->select('prov_id,prov_name');

        $prov_id = $this->request->getGet('prov_id');
        if ($prov_id != NULL) {
            $list_prov_id = explode(',', $prov_id);
            $select2->db->whereIn('prov_id', $list_prov_id);
        }

        $select2->searchFields  = ['prov_name'];
        $select2->orderBy       = 'prov_name';
        $select2->orderDir      = 'ASC';

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['prov_id']);
            $result['text'] = esc($row['prov_name']);
            return $result;
        });

        $select2->generate();
    }

    public function pcCities()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('pc_cities');
        $select2->db->select('pc_cities.city_id,pc_cities.city_name,pc_cities.prov_id,pc_provinces.prov_name');
        $select2->db->join('pc_provinces', 'pc_provinces.prov_id=pc_cities.prov_id');

        $prov_id = $this->request->getGet('prov_id');
        if ($prov_id != NULL) {
            $list_prov_id = explode(',', $prov_id);
            $select2->db->whereIn('pc_cities.prov_id', $list_prov_id);
        }

        $select2->searchFields  = ['pc_cities.city_name'];
        $select2->orderBy       = 'pc_cities.city_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']           = esc($row['city_id']);
            $result['text']         = esc($row['city_name']);
            $result['prov_id']      = esc($row['city_id']);
            $result['prov_name']    = esc($row['prov_name']);
            return $result;
        });

        $select2->generate();
    }

    public function pcDistricts()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('pc_districts');
        $select2->db->select('pc_districts.dis_id,pc_districts.dis_name,pc_cities.city_id,pc_cities.city_name,pc_cities.prov_id,pc_provinces.prov_name');
        $select2->db->join('pc_cities', 'pc_cities.city_id=pc_districts.city_id');
        $select2->db->join('pc_provinces', 'pc_provinces.prov_id=pc_cities.prov_id');

        $city_id = $this->request->getGet('city_id');
        if ($city_id != NULL) {
            $list_city_id = explode(',', $city_id);
            $select2->db->whereIn('pc_cities.city_id', $list_city_id);
        }

        $select2->searchFields  = ['pc_districts.dis_name'];
        $select2->orderBy       = 'pc_districts.dis_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']           = esc($row['dis_id']);
            $result['text']         = esc($row['dis_name']);
            $result['city_id']      = esc($row['city_id']);
            $result['city_name']    = esc($row['city_name']);
            $result['prov_id']      = esc($row['city_id']);
            $result['prov_name']    = esc($row['prov_name']);
            return $result;
        });

        $select2->generate();
    }

    public function pcSubDistricts()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('pc_postalcode');
        $select2->db->select('pc_postalcode.subdis_id,pc_subdistricts.subdis_name,pc_postalcode.dis_id,pc_districts.dis_name,pc_postalcode.city_id,pc_cities.city_name,pc_postalcode.prov_id,pc_provinces.prov_name,pc_postalcode.postal_code');
        $select2->db->join('pc_subdistricts', 'pc_subdistricts.subdis_id=pc_postalcode.subdis_id');
        $select2->db->join('pc_districts', 'pc_districts.dis_id=pc_postalcode.dis_id');
        $select2->db->join('pc_cities', 'pc_cities.city_id=pc_postalcode.city_id');
        $select2->db->join('pc_provinces', 'pc_provinces.prov_id=pc_postalcode.prov_id');

        $dis_id = $this->request->getGet('dis_id');
        if ($dis_id != NULL) {
            $list_dis_id = explode(',', $dis_id);
            $select2->db->whereIn('pc_postalcode.dis_id', $list_dis_id);
        }

        $select2->searchFields  = ['pc_subdistricts.subdis_name'];
        $select2->orderBy       = 'pc_subdistricts.subdis_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']           = esc($row['subdis_id']);
            $result['text']         = esc($row['subdis_name']);
            $result['dis_id']       = esc($row['dis_id']);
            $result['dis_name']     = esc($row['dis_name']);
            $result['city_id']      = esc($row['city_id']);
            $result['city_name']    = esc($row['city_name']);
            $result['prov_id']      = esc($row['city_id']);
            $result['prov_name']    = esc($row['prov_name']);
            $result['postal_code']  = esc($row['postal_code']);
            return $result;
        });

        $select2->generate();
    }

    public function unit()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_unit');

        $select2->db->select('unit_id,unit_name');
        $select2->db->where('deleted', 'N');

        $select2->searchFields  = ['unit_name'];
        $select2->orderBy       = 'unit_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['unit_id']);
            $result['text'] = esc($row['unit_name']);
            return $result;
        });

        $select2->generate();
    }


    /*public function salesman()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_salesman');

        $select2->db->select('salesman_id,salesman_code,salesman_name ');
        $select2->db->where('deleted', 'N');

        $select2->searchFields  = ['salesman_name', 'salesman_code'];
        $select2->orderBy       = 'salesman_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['salesman_id']);
            $result['text'] = $row['salesman_name'] . ' - ' . $row['salesman_code'];
            return $result;
        });

        $select2->generate();
    }*/


    public function brand()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_brand');

        $select2->db->select('brand_id,brand_name');
        $select2->db->where('deleted', 'N');

        $select2->searchFields  = ['brand_name'];
        $select2->orderBy       = 'brand_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['brand_id']);
            $result['text'] = esc($row['brand_name']);
            return $result;
        });

        $select2->generate();
    }

    public function category()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_category');

        $select2->db->select('category_id,category_name');
        $select2->db->where('deleted', 'N');

        $select2->searchFields  = ['category_name'];
        $select2->orderBy       = 'category_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['category_id']);
            $result['text'] = esc($row['category_name']);
            return $result;
        });

        $select2->generate();
    }

    public function product()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_product');

        $select2->db->select('product_id,product_name,product_code');
        $select2->db->where('deleted', 'N');

        $select2->searchFields  = ['product_code', 'product_name'];
        $select2->orderBy       = 'product_code';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['product_id']);
            $result['text'] = $row['product_code'] . ' - ' . $row['product_name'];
            return $result;
        });

        $select2->generate();
    }

    public function productUnit()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_product_unit');

        $select2->db->select('ms_product_unit.item_id,ms_product_unit.item_code,ms_product.product_name,ms_unit.unit_name');
        $select2->db->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id');
        $select2->db->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id');
        $select2->db->where('ms_product.deleted', 'N');

        $select2->searchFields  = ['ms_product_unit.item_code', 'ms_product.product_name'];
        $select2->orderBy       = 'ms_product.product_name';
        $select2->orderDir      = 'ASC';


        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = esc($row['item_id']);
            $result['text'] = $row['item_code'] . ' - ' . $row['product_name'] . ' (' . $row['unit_name'] . ')';
            return $result;
        });

        $select2->generate();
    }

    public function warehouse()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_warehouse');

        $select2->db->select('warehouse_id,warehouse_code,warehouse_name');
        $select2->db->where('deleted', 'N');

        $store_id = $this->request->getGet('store_id');
        if ($store_id != NULL) {
            $select2->db->where('store_id', $store_id);
        }

        $select2->searchFields  = ['warehouse_code', 'warehouse_name'];
        $select2->orderBy       = 'warehouse_code';
        $select2->orderDir      = 'ASC';

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = $row['warehouse_id'];
            $result['text'] = $row['warehouse_code'] . ' - ' . $row['warehouse_name'];
            return $result;
        });

        $select2->generate();
    }

    public function payment_method()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_payment_method');

        $select2->db->select('payment_method_id, payment_method_name, bank_account_name');
        $select2->db->where('deleted', 'N');

        $select2->searchFields  = ['payment_method_name'];
        $select2->orderBy       = 'payment_method_name';
        $select2->orderDir      = 'ASC';

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = $row['payment_method_id'];
            $result['text'] = $row['payment_method_name'] . '-' . $row['bank_account_name'];
            return $result;
        });

        $select2->generate();
    }

    public function noSubmission()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('hd_submission');

        $select2->db->select('submission_id, submission_inv');
        $select2->db->where('submission_status', 'Pending');
        $select2->db->where('submission_type', 'Pembelian');

        $select2->searchFields  = ['submission_inv'];
        $select2->orderBy       = 'submission_inv';
        $select2->orderDir      = 'ASC';

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = $row['submission_id'];
            $result['text'] = $row['submission_inv'];
            return $result;
        });

        $select2->generate();
    }

    public function noSubmissionConsignment()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('hd_submission');

        $select2->db->select('submission_id, submission_inv');
        $select2->db->where('submission_status', 'Pending');
        $select2->db->where('submission_type', 'Konsinyasi');

        $select2->searchFields  = ['submission_inv'];
        $select2->orderBy       = 'submission_inv';
        $select2->orderDir      = 'ASC';

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = $row['submission_id'];
            $result['text'] = $row['submission_inv'];
            return $result;
        });

        $select2->generate();
    }

    public function noPo()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('hd_purchase_order');

        $select2->db->select('purchase_order_invoice, purchase_order_id');
        $select2->db->where('purchase_order_status', 'Pending');

        $select2->searchFields  = ['purchase_order_invoice'];
        $select2->orderBy       = 'purchase_order_invoice';
        $select2->orderDir      = 'ASC';

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = $row['purchase_order_id'];
            $result['text'] = $row['purchase_order_invoice'];
            return $result;
        });

        $select2->generate();
    }

    public function noPoConsignment()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('hd_purchase_order_consignment');

        $select2->db->select('purchase_order_consignment_invoice, purchase_order_consignment_id');
        $select2->db->where('purchase_order_consignment_status', 'Pending');

        $select2->searchFields  = ['purchase_order_consignment_invoice'];
        $select2->orderBy       = 'purchase_order_consignment_invoice';
        $select2->orderDir      = 'ASC';

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = $row['purchase_order_consignment_id'];
            $result['text'] = $row['purchase_order_consignment_invoice'];
            return $result;
        });

        $select2->generate();
    }

    public function mappingArea()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_mapping_area');

        $select2->db->select('mapping_id,mapping_code,mapping_address');
        $select2->db->where('deleted', 'N');


        $select2->searchFields  = ['mapping_code', 'mapping_address'];
        $select2->orderBy       = 'mapping_code';
        $select2->orderDir      = 'ASC';

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = $row['mapping_id'];
            $result['text'] = $row['mapping_code'] . ' - ' . $row['mapping_address'];
            return $result;
        });

        $select2->generate();
    }

    public function supplier()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_supplier');

        $select2->db->select('supplier_id,supplier_code,supplier_name');
        $select2->db->where('deleted', 'N');

        $select2->searchFields  = ['supplier_code', 'supplier_name'];
        $select2->orderBy       = 'supplier_code';
        $select2->orderDir      = 'ASC';

        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']   = $row['supplier_id'];
            $result['text'] = $row['supplier_code'] . ' - ' . $row['supplier_name'];
            return $result;
        });

        $select2->generate();
    }



    public function customer()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_customer');

        $select2->db->select('customer_id,customer_code,customer_name,customer_group,customer_address,customer_phone,customer_point,exp_date,active');
        $select2->db->where('deleted', 'N');

        if ($this->request->getGet('customer_group') != NULL) {
            $customer_group = $this->request->getGet('customer_group');
            $filter_group = explode(',', $customer_group);
            $select2->db->whereIn('customer_group', $filter_group);
        }

        $select2->searchFields  = ['customer_name', 'customer_phone'];
        $select2->orderBy       = 'customer_name';
        $select2->orderDir      = 'ASC';

        $config_label_group = $this->appConfig->get('default', 'label_customer_group');
        $select2->renderResult(function ($row, $i) use ($config_label_group) {
            $result = [];
            $result['id']                   = $row['customer_id'];
            $result['text']                 = $row['customer_name'] . ' (' . $row['customer_phone'] . ')';
            $result['customer_id']          = $row['customer_id'];
            $result['customer_code']        = $row['customer_code'];
            $result['customer_name']        = $row['customer_name'];
            $result['customer_group']       = $row['customer_group'];
            $result['customer_group_label'] = isset($config_label_group[$row['customer_group']]) ? $config_label_group[$row['customer_group']] : 'NO_CONFIG';
            $result['customer_address']     = $row['customer_address'];
            $result['customer_phone']       = $row['customer_phone'];
            $result['customer_point']       = $row['customer_point'];
            $result['exp_date']             = indo_short_date($row['exp_date'], FALSE);

            $cur_date   = new DateTime(date('Y-m-d'));
            $exp_date   = new DateTime($row['exp_date']);

            if ($exp_date < $cur_date) {
                $result['exp_status']       = 'Y';
            } else {
                $result['exp_status']       = 'N';
            }
            $result['active']               = $row['active'];

            return $result;
        });

        $select2->generate();
    }


    public function searchProduct()
    {

        $this->validationRequest(TRUE, 'GET');

        $keyword = $this->request->getGet('term');

        if (!($keyword == '' || $keyword == NULL)) {

            $M_product = model('M_product');

            $find = $M_product->searchProductUnitByName($keyword)->getResultArray();

            $find_result = [];

            foreach ($find as $row) {

                $diplay_text = $row['product_name'];

                $find_result[] = [

                    'id'                  => $diplay_text,

                    'value'               => $diplay_text.'('.$row['unit_name'].')',

                    'item_id'             => $row['item_id'],

                    'price'               => $row['G5_sales_price']  

                ];

            }

            $result = ['success' => TRUE, 'num_product' => count($find_result), 'data' => $find_result, 'message' => ''];

        }

        resultJSON($result);
    }
    

    public function salesman()
    {
        $this->validationRequest(TRUE);
        $select2 = new \App\Libraries\Select2('ms_salesman');
        $select2->db->select('ms_salesman.salesman_id,ms_salesman.salesman_code,ms_salesman.salesman_name');

        if ($this->request->getGet('store_id') != NULL) {
            $store_id = $this->request->getGet('store_id');
            $filter_store = explode(',', $store_id);
            $select2->db->whereIn('store_id', $filter_store);
        }

        $select2->searchFields  = ['ms_salesman.salesman_code', 'ms_salesman.salesman_name'];
        $select2->orderBy       = 'ms_salesman.salesman_code';
        $select2->orderDir      = 'ASC';



        $select2->renderResult(function ($row, $i) {
            $result = [];
            $result['id']               = $row['salesman_id'];
            $result['text']             = $row['salesman_code'] . ' - ' . $row['salesman_name'];
            $result['salesman_code']    = $row['salesman_code'];
            $result['salesman_name']    = $row['salesman_name'];
            return $result;
        });

        $select2->generate();
    }

    //--------------------------------------------------------------------

}
