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
    protected $table_product_point = 'ms_point_reward';
    protected $table_exchange_point = 'customer_history_point';

    public function getCustomerLogin($customer_phone)
    {
        $builder = $this->db->table($this->table_customer);
        $builder->select('customer_id, customer_code, customer_name, customer_address, customer_phone, customer_email, customer_point, customer_group,mapping_id,exp_date, active, verification_email, customer_password, created_at, referral_code');
        $builder->where(['customer_phone ' => $customer_phone]);
        $builder->where(['active ' => 'Y']);
        return $builder->get();
    }

    public function getCustomerResetPass($customer_id)
    {
        $builder = $this->db->table($this->table_customer);
        $builder->select('customer_id, customer_code, customer_name, customer_address, customer_phone, customer_email, customer_point, customer_group,mapping_id,exp_date, active, verification_email, customer_password, created_at, referral_code');
        $builder->where(['customer_id ' => $customer_id]);
        $builder->where(['active ' => 'Y']);
        return $builder->get();
    }

    public function check_email($email)
    {   
        $builder = $this->db->table($this->table_customer);
        $builder->select('customer_email');
        $builder->where(['customer_email ' => $email]);
        return $builder->get();
    }

    public function check_phone($phone)
    {   
        $builder = $this->db->table($this->table_customer);
        $builder->select('customer_phone');
        $builder->where(['customer_phone ' => $phone]);
        return $builder->get();
    }

    public function check_pass($customer_id)
    {
        $builder = $this->db->table($this->table_customer);
        $builder->select('customer_password');
        $builder->where(['customer_id ' => $customer_id]);
        return $builder->get();
    }

    public function check_referalcode($invite_by_referral_code)
    {   
        $builder = $this->db->table($this->table_customer);
        $builder->select('referral_code');
        $builder->where(['referral_code ' => $invite_by_referral_code]);
        return $builder->get();
    }

    public function updateCustomer($data)
    {
        $this->db->query('LOCK TABLES ms_customer WRITE');
        $save = $this->db->table($this->table_customer)->update($data, ['customer_id' => $data['customer_id']]);
        $this->db->query('UNLOCK TABLES');
        return $save;
    }

    public function updatePass($customer_id, $data)
    {
         return $this->db->table($this->table_customer)

            ->where('customer_id', $customer_id)

            ->update($data);
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
             $builder->select('item_id, product_code, product_name, product_image, G2_sales_price as sell_price, product_description, unit_name');
        }else if($customer_group == 'G3'){
             $builder->select('item_id, product_code, product_name, product_image, G3_sales_price as sell_price, product_description, unit_name');
        }else if($customer_group == 'G4'){
             $builder->select('item_id, product_code, product_name, product_image, G4_sales_price as sell_price, product_description, unit_name');
        }else{
            $builder->select('item_id, product_code, product_name, product_image, G5_sales_price as sell_price, product_description, unit_name');
        }
        $builder->join('ms_product_unit', 'ms_product_unit.product_id = ms_product.product_id');
        $builder->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id');
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


    public function getCustomerByPhone($customer_phone)
    {
        $builder = $this->db->table($this->table_customer);
        $builder->select('customer_id, customer_code, customer_name, customer_phone, customer_address, customer_email, customer_point, customer_group,mapping_id,exp_date, active, verification_email, customer_password, created_at, referral_code');
        $builder->where(['customer_phone ' => $customer_phone]);
        $builder->where(['active ' => 'Y']);
        return $builder->get(10);
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

    public function getitempoint($perpage, $start)
    {
        $builder = $this->db->table($this->table_product_point);
        $builder->where('start_date < CURDATE()');
        $builder->where('end_date > CURDATE()');
        $builder->where('reward_stock > 0');
        $builder->where(['active' => 'Y' ]);
        $builder->where(['deleted' => 'N' ]);
        if($perpage == '' || $start == ''){
        return $builder->get();
        }else{
        return $builder->get($perpage, $start);
        }
    }

    public function getHistoryPoint($perpage, $start, $customer_id)
    {
        $builder = $this->db->table($this->table_exchange_point);
        $builder->where(['customer_id' => $customer_id]);
        $builder->orderBy('created_at','desc' );
        if($perpage == '' || $start == ''){
        return $builder->get();
        }else{
        return $builder->get($perpage, $start);
        }
    }
}
