<?php

namespace App\Models;

use CodeIgniter\Model;

class M_api_accounting extends Model
{

    protected $log_api_accounting = 'log_api_accounting';
    protected $hd_purchase = 'hd_purchase';
    protected $hd_payment_debt = 'hd_payment_debt';
    protected $hd_retur_purchase = 'hd_retur_purchase';
    protected $hd_sales_admin = 'hd_sales_admin';
    protected $hd_payment_receivable = 'hd_payment_receivable';
    
    /*public function getLastPostPurchase($api_module, $)
    {
        $builder = $this->db->table($this->log_api_accounting);
        $builder->select('*');
        $builder->where(['api_module' => 'Purchase']);
        $builder->limit(1);
        return $builder->get();
    }*/

    public function getPurchaseApi($api_last_record_id)
    {
        $builder = $this->db->table($this->hd_purchase);
        $builder->select('*');
        $builder->join('ms_supplier', 'ms_supplier.supplier_id=hd_purchase.purchase_supplier_id');
        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id=hd_purchase.purchase_warehouse_id');
        $builder->join('ms_store', 'ms_store.store_id=ms_warehouse.store_id');
        $builder->where('purchase_id >=', $api_last_record_id);
        $builder->orderBy('purchase_id', 'ASC');
        return $builder->get();
    }

    public function getDebtRepaymentApi($api_last_record_id)
    {
        $builder = $this->db->table($this->hd_payment_debt);
        $builder->select('*');
        $builder->join('ms_supplier', 'ms_supplier.supplier_id=hd_payment_debt.payment_debt_supplier_id');
        $builder->where('payment_debt_id >=', $api_last_record_id);
         $builder->orderBy('payment_debt_id', 'ASC');
        return $builder->get();
    }

    public function getReturPurchaseApi($api_last_record_id)
    {
        $builder = $this->db->table($this->hd_retur_purchase);
        $builder->select('*');
        $builder->join('ms_supplier', 'ms_supplier.supplier_id=hd_retur_purchase.hd_retur_supplier_id');
        $builder->where('hd_retur_status', 'Selesai');
        $builder->where('hd_retur_purchase_id >=', $api_last_record_id);
        $builder->orderBy('hd_retur_purchase_id', 'ASC');
        return $builder->get();
    }

    public function getSalesAdmin($api_last_record_id)
    {
        $builder = $this->db->table($this->hd_sales_admin);
        $builder->select('*');
        $builder->join('ms_customer', 'ms_customer.customer_id=hd_sales_admin.sales_customer_id');
        $builder->join('ms_store', 'ms_store.store_id=hd_sales_admin.sales_store_id');
        $builder->where('sales_admin_id >=', $api_last_record_id);
        $builder->orderBy('sales_admin_id', 'ASC');
        return $builder->get();
    }


    public function getReceivableRepaymentApi($api_last_record_id)
    {
        $builder = $this->db->table($this->hd_payment_receivable);
        $builder->select('*');
        $builder->join('ms_customer', 'ms_customer.customer_id=hd_payment_receivable.payment_receivable_customer_id');
        $builder->where('payment_receivable_id >=', $api_last_record_id);
        $builder->orderBy('payment_receivable_id', 'ASC');
        return $builder->get();
    }


}
