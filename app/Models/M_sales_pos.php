<?php

namespace App\Models;

use CodeIgniter\Model;

class M_sales_pos extends Model
{
    protected $table    = 'hd_pos_sales';
    protected $dtSales  = 'dt_pos_sales';


    public function getSales($pos_sales_id = '')
    {
        $builder = $this->db->table($this->table);

        $builder->select('hd_pos_sales.*,ms_store.store_name,ms_customer.customer_name,user_account.user_realname');
        $builder->join('user_account', 'user_account.user_id=hd_pos_sales.user_id');
        $builder->join('ms_store', 'ms_store.store_id=hd_pos_sales.store_id');
        $builder->join('ms_customer', 'ms_customer.customer_id=hd_pos_sales.customer_id');


        if ($pos_sales_id  != '') {
            $builder->where('hd_pos_sales.pos_sales_id', $pos_sales_id);
        }

        return $builder->get();
    }

    public function getDetailSales($pos_sales_id = '', $detail_id = '')
    {
        $builder = $this->db->table($this->dtSales);
        $builder->select('dt_pos_sales.*,ms_product_unit.item_code,ms_product.product_name,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name');
        $builder->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id');
        $builder->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id');
        $builder->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id');
        $builder->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales.salesman_id', 'left');
        if ($pos_sales_id  != '') {
            $builder->where('dt_pos_sales.pos_sales_id', $pos_sales_id);
        }
        if ($detail_id  != '') {
            $builder->where('dt_pos_sales.detail_id', $detail_id);
        }
        return $builder->get();
    }

    public function changeSalesman($detail_id, $salesman_id)
    {
        $this->db->query('LOCK TABLES dt_pos_sales WRITE');
        $data = [
            'salesman_id' => $salesman_id
        ];
        $save = $this->db->table($this->dtSales)->update($data, ['detail_id' => $detail_id]);

        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'sales_pos', $detail_id, 'Edit_Salesman');
        return $save;
    }
}
