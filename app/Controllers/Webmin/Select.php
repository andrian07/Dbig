<?php


namespace App\Controllers\Webmin;

use App\Controllers\Base\WebminController;


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
            $result['text'] = $row['payment_method_name'].'-'.$row['bank_account_name'];
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

    public function noPoConsignment(){
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

    //--------------------------------------------------------------------

}
