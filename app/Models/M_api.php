<?php

namespace App\Models;

use CodeIgniter\Model;

class M_api extends Model
{

    protected $table_customer = 'ms_customer';
    protected $table_banner = 'ms_mobile_banner';
    protected $table_promo = 'ms_mobile_promo';
    protected $table_prodcuct = 'ms_product';
    protected $table_category = 'ms_category';
    protected $table_brand = 'ms_brand';

    public function getCustomerLogin($customer_phone)
    {
        $builder = $this->db->table($this->table_customer);
        $builder->where(['customer_phone ' => $customer_phone]);
        return $builder->get();
    }

    public function getBanner($perpage, $start)
    {
        $builder = $this->db->table($this->table_banner);
        $builder->where('active ', 'Y');
        $builder->where('deleted ', 'N');
        if($perpage == '' || $start == ''){
        return $builder->get();
        }else{
        return $builder->get($perpage, $start);
        }
    }

    public function getPromo($perpage, $start)
    {
        $date = date("Y-m-d") ;
        $builder = $this->db->table($this->table_promo);
        $builder->where('active ','Y');
        $builder->where('deleted ','N');
        $builder->where('mobile_promo_end_date >=', $date);
         if($perpage == '' || $start == ''){
        return $builder->get();
        }else{
        return $builder->get($perpage, $start);
        }
    }

    public function getCategory($perpage, $start)
    {
        $builder = $this->db->table($this->table_category);
        $builder->where('deleted ', 'N');
        if($perpage == '' || $start == ''){
        return $builder->get();
        }else{
        return $builder->get($perpage, $start);
        }
    }

    public function getBrand($perpage, $start)
    {
        $builder = $this->db->table($this->table_brand);
        $builder->where('deleted ', 'N');
        if($perpage == '' || $start == ''){
        return $builder->get();
        }else{
        return $builder->get($perpage, $start);
        }
    }

    public function getProduct($customer_group, $perpage, $start, $brand_id, $category_id, $sort)
    {
        $builder = $this->db->table($this->table_prodcuct);
        if($customer_group == 'G2'){
            $builder->select('item_id, product_code, product_name, product_image, G2_sales_price as sell_price');
        }else if($customer_group == 'G3'){
            $builder->select('item_id, product_code, product_name, product_image, G3_sales_price as sell_price');
        }else if($customer_group == 'G4'){
            $builder->select('item_id, product_code, product_name, product_image, G4_sales_price as sell_price');
        }else{
            $builder->select('item_id, product_code, product_name, product_image, G1_sales_price as sell_price');
        }
        $builder->join('ms_product_unit', 'ms_product_unit.product_id = ms_product.product_id');
        $builder->where(['show_on_mobile_app' => 'Y' ]);
        if($brand_id != null){
        $builder->where(['brand_id' => $brand_id ]);
        }
        if($category_id != null){
        $builder->where(['category_id' => $category_id ]);
        }
        if($sort != 'new'){
        $builder->orderBy('product_name',$sort);
        }else{
        $builder->orderBy('ms_product.created_at','desc' );
        }
        if($perpage == '' || $start == ''){
        return $builder->get();
        }else{
        return $builder->get($perpage, $start);
        }
    }

    public function getBannerById($mobile_banner_id)
    {
        $builder = $this->db->table($this->table_banner);
        $builder->where('active', 'Y');
        $builder->where('deleted', 'N');
        $builder->where('mobile_banner_id', $mobile_banner_id);
        return $builder->get();
    }

    public function getPromoById($mobile_promo_id)
    {
        $builder = $this->db->table($this->table_promo);
        $builder->where('active', 'Y');
        $builder->where('deleted', 'N');
        $builder->where('mobile_promo_id', $mobile_promo_id);
        return $builder->get();
    }

    public function getProductById($customer_group, $item_id)
    {
        $builder = $this->db->table($this->table_prodcuct);if($customer_group == 'G2'){
            $builder->select('item_id, product_code, product_name, product_image, G2_sales_price as sell_price, product_description, unit_name');
        }else if($customer_group == 'G3'){
            $builder->select('item_id, product_code, product_name, product_image, G3_sales_price as sell_price, product_description, unit_name');
        }else if($customer_group == 'G4'){
            $builder->select('item_id, product_code, product_name, product_image, G4_sales_price as sell_price, product_description, unit_name');
        }else{
            $builder->select('item_id, product_code, product_name, product_image, G1_sales_price as sell_price, product_description, unit_name');
        }
        $builder->join('ms_product_unit', 'ms_product_unit.product_id = ms_product.product_id');
        $builder->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id');
        $builder->where(['show_on_mobile_app' => 'Y' ]);
        $builder->where(['item_id' => $item_id ]);
        return $builder->get();
    }

    public function getproductbyname($search , $customer_group)
    {
        $builder = $this->db->table($this->table_prodcuct);
        if($customer_group == 'G2'){
            $builder->select('item_id, product_code, product_name, product_image, G2_sales_price as sell_price, product_description, unit_name');
        }else if($customer_group == 'G3'){
            $builder->select('item_id, product_code, product_name, product_image, G3_sales_price as sell_price, product_description, unit_name');
        }else if($customer_group == 'G4'){
            $builder->select('item_id, product_code, product_name, product_image, G4_sales_price as sell_price, product_description, unit_name');
        }else{
            $builder->select('item_id, product_code, product_name, product_image, G1_sales_price as sell_price, product_description, unit_name');
        }
        $builder->join('ms_product_unit', 'ms_product_unit.product_id = ms_product.product_id');
        $builder->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id');
        $builder->where(['show_on_mobile_app' => 'Y' ]);
        $builder->where('product_name like "%'.$search.'%"');
        return $builder->get(10);
    }

    /*public function getitempoint($search)
    {
        $builder = $this->db->table($this->table_prodcuct);
        if($customer_group == 'G2'){
            $builder->select('item_id, product_code, product_name, product_image, G2_sales_price as sell_price, product_description, unit_name');
        }else if($customer_group == 'G3'){
            $builder->select('item_id, product_code, product_name, product_image, G3_sales_price as sell_price, product_description, unit_name');
        }else if($customer_group == 'G4'){
            $builder->select('item_id, product_code, product_name, product_image, G4_sales_price as sell_price, product_description, unit_name');
        }else{
            $builder->select('item_id, product_code, product_name, product_image, G1_sales_price as sell_price, product_description, unit_name');
        }
        $builder->join('ms_product_unit', 'ms_product_unit.product_id = ms_product.product_id');
        $builder->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id');
        $builder->where(['show_on_mobile_app' => 'Y' ]);
        $builder->where('product_name like "%'.$search.'%"');
        return $builder->get(10);
    }*/

    

}
