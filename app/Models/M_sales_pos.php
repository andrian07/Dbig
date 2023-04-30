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

    /* Report Section */
    public function getReportSalesList($start_date, $end_date, $store_id = '', $user_id = '', $product_tax = '')
    {
        // get sales //
        $querySales = $this->db->table('dt_pos_sales');
        $querySales->select('hd_pos_sales.pos_sales_invoice,hd_pos_sales.pos_sales_date,hd_pos_sales.payment_list,hd_pos_sales.payment_remark,ms_store.store_code,user_account.user_realname,sum(dt_pos_sales.sales_dpp*dt_pos_sales.sales_qty) as sales_dpp,sum(dt_pos_sales.sales_ppn*dt_pos_sales.sales_qty) as sales_ppn,hd_pos_sales.created_at')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales.user_id')
            ->where("(hd_pos_sales.pos_sales_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySales->where('hd_pos_sales.store_id', $store_id);
        }

        if ($user_id != '') {
            $querySales->where('hd_pos_sales.user_id', $user_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySales->where('dt_pos_sales.sales_ppn>0');
            } else {
                $querySales->where('dt_pos_sales.sales_ppn=0');
            }
        }

        $querySales->groupBy('dt_pos_sales.pos_sales_id');



        // get sales return //
        $querySalesReturn = $this->db->table('dt_pos_sales_return');
        $querySalesReturn->select('hd_pos_sales_return.pos_sales_return_invoice as pos_sales_invoice,hd_pos_sales_return.pos_sales_return_date as pos_sales_date,hd_pos_sales_return.payment_list,hd_pos_sales_return.payment_remark,ms_store.store_code,user_account.user_realname,(sum(dt_pos_sales_return.sales_return_dpp*dt_pos_sales_return.sales_return_qty)*-1) as sales_dpp,(sum(dt_pos_sales_return.sales_return_ppn*dt_pos_sales_return.sales_return_qty)*-1) as sales_ppn,hd_pos_sales_return.created_at')
            ->join('hd_pos_sales_return', 'hd_pos_sales_return.pos_sales_return_id=dt_pos_sales_return.pos_sales_return_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales_return.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales_return.user_id')
            ->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySalesReturn->where('hd_pos_sales_return.store_id', $store_id);
        }

        if ($user_id != '') {
            $querySalesReturn->where('hd_pos_sales_return.user_id', $user_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn>0');
            } else {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn=0');
            }
        }

        $querySalesReturn->groupBy('dt_pos_sales_return.pos_sales_return_id');

        $qSI = $querySales->getCompiledSelect();
        $qSR = $querySalesReturn->getCompiledSelect();

        $sqlText = "$qSI UNION ALL $qSR ORDER BY created_at ASC";
        $getResult = $this->db->query($sqlText)->getResultArray();
        return $getResult;
    }

    public function getReportDetailSalesList($start_date, $end_date, $store_id = '', $user_id = '', $product_tax = '')
    {
        // get sales //
        $querySales = $this->db->table('dt_pos_sales');
        $querySales->select('hd_pos_sales.pos_sales_invoice,hd_pos_sales.pos_sales_date,hd_pos_sales.payment_list,hd_pos_sales.payment_remark,ms_store.store_code,user_account.user_realname,dt_pos_sales.sales_dpp,dt_pos_sales.sales_ppn,dt_pos_sales.sales_qty,ms_product_unit.item_code,ms_product.product_name,ms_brand.brand_name,ms_category.category_name,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name,hd_pos_sales.created_at')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales.user_id')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales.salesman_id', 'left')
            ->where("(hd_pos_sales.pos_sales_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySales->where('hd_pos_sales.store_id', $store_id);
        }

        if ($user_id != '') {
            $querySales->where('hd_pos_sales.user_id', $user_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySales->where('dt_pos_sales.sales_ppn>0');
            } else {
                $querySales->where('dt_pos_sales.sales_ppn=0');
            }
        }



        // get sales return //
        $querySalesReturn = $this->db->table('dt_pos_sales_return');
        $querySalesReturn->select('hd_pos_sales_return.pos_sales_return_invoice as pos_sales_invoice,hd_pos_sales_return.pos_sales_return_date as pos_sales_date,hd_pos_sales_return.payment_list,hd_pos_sales_return.payment_remark,ms_store.store_code,user_account.user_realname,dt_pos_sales_return.sales_return_dpp as sales_dpp,dt_pos_sales_return.sales_return_ppn as sales_ppn,(dt_pos_sales_return.sales_return_qty*-1) as sales_qty,ms_product_unit.item_code,ms_product.product_name,ms_brand.brand_name,ms_category.category_name,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name,hd_pos_sales_return.created_at')
            ->join('hd_pos_sales_return', 'hd_pos_sales_return.pos_sales_return_id=dt_pos_sales_return.pos_sales_return_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales_return.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales_return.user_id')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales_return.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales_return.salesman_id', 'left')
            ->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySalesReturn->where('hd_pos_sales_return.store_id', $store_id);
        }

        if ($user_id != '') {
            $querySalesReturn->where('hd_pos_sales_return.user_id', $user_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn>0');
            } else {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn=0');
            }
        }

        $qSI = $querySales->getCompiledSelect();
        $qSR = $querySalesReturn->getCompiledSelect();

        $sqlText = "$qSI UNION ALL $qSR ORDER BY created_at,pos_sales_invoice ASC";
        $getResult = $this->db->query($sqlText)->getResultArray();
        return $getResult;
    }

    public function getReportSalesListBySalesman($start_date, $end_date, $store_id = '', $salesman_id = '', $product_tax = '')
    {
        // get sales //
        $querySales = $this->db->table('dt_pos_sales');
        $querySales->select('hd_pos_sales.pos_sales_invoice,hd_pos_sales.pos_sales_date,hd_pos_sales.payment_list,hd_pos_sales.payment_remark,ms_store.store_code,user_account.user_realname,sum(dt_pos_sales.sales_dpp*dt_pos_sales.sales_qty) as sales_dpp,sum(dt_pos_sales.sales_ppn*dt_pos_sales.sales_qty) as sales_ppn,hd_pos_sales.created_at,dt_pos_sales.salesman_id,ms_salesman.salesman_code,ms_salesman.salesman_name')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales.salesman_id', 'left')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales.user_id')
            ->where("(hd_pos_sales.pos_sales_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySales->where('hd_pos_sales.store_id', $store_id);
        }

        if ($salesman_id != '') {
            $querySales->where('dt_pos_sales.salesman_id', $salesman_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySales->where('dt_pos_sales.sales_ppn>0');
            } else {
                $querySales->where('dt_pos_sales.sales_ppn=0');
            }
        }

        $querySales->groupBy('dt_pos_sales.salesman_id,dt_pos_sales.pos_sales_id');



        // get sales return //
        $querySalesReturn = $this->db->table('dt_pos_sales_return');
        $querySalesReturn->select('hd_pos_sales_return.pos_sales_return_invoice as pos_sales_invoice,hd_pos_sales_return.pos_sales_return_date as pos_sales_date,hd_pos_sales_return.payment_list,hd_pos_sales_return.payment_remark,ms_store.store_code,user_account.user_realname,(sum(dt_pos_sales_return.sales_return_dpp*dt_pos_sales_return.sales_return_qty)*-1) as sales_dpp,(sum(dt_pos_sales_return.sales_return_ppn*dt_pos_sales_return.sales_return_qty)*-1) as sales_ppn,hd_pos_sales_return.created_at,dt_pos_sales_return.salesman_id,ms_salesman.salesman_code,ms_salesman.salesman_name')
            ->join('hd_pos_sales_return', 'hd_pos_sales_return.pos_sales_return_id=dt_pos_sales_return.pos_sales_return_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales_return.salesman_id', 'left')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales_return.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales_return.user_id')
            ->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySalesReturn->where('hd_pos_sales_return.store_id', $store_id);
        }

        if ($salesman_id != '') {
            $querySalesReturn->where('dt_pos_sales_return.salesman_id', $salesman_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn>0');
            } else {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn=0');
            }
        }
        $querySalesReturn->groupBy('dt_pos_sales_return.salesman_id,dt_pos_sales_return.pos_sales_return_id');


        $qSI = $querySales->getCompiledSelect();
        $qSR = $querySalesReturn->getCompiledSelect();

        $sqlText = "$qSI UNION ALL $qSR ORDER BY salesman_id,created_at ASC";
        $getResult = $this->db->query($sqlText)->getResultArray();
        return $getResult;
    }

    public function getReportDetailSalesListBySalesman($start_date, $end_date, $store_id = '', $salesman_id = '', $product_tax = '')
    {
        // get sales //
        $querySales = $this->db->table('dt_pos_sales');
        $querySales->select('hd_pos_sales.pos_sales_invoice,hd_pos_sales.pos_sales_date,hd_pos_sales.payment_list,hd_pos_sales.payment_remark,ms_store.store_code,user_account.user_realname,dt_pos_sales.sales_dpp,dt_pos_sales.sales_ppn,dt_pos_sales.sales_qty,ms_product_unit.item_code,ms_product.product_name,ms_brand.brand_name,ms_category.category_name,dt_pos_sales.salesman_id,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name,hd_pos_sales.created_at')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales.user_id')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales.salesman_id', 'left')
            ->where("(hd_pos_sales.pos_sales_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySales->where('hd_pos_sales.store_id', $store_id);
        }

        if ($salesman_id != '') {
            $querySales->where('dt_pos_sales.salesman_id', $salesman_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySales->where('dt_pos_sales.sales_ppn>0');
            } else {
                $querySales->where('dt_pos_sales.sales_ppn=0');
            }
        }



        // get sales return //
        $querySalesReturn = $this->db->table('dt_pos_sales_return');
        $querySalesReturn->select('hd_pos_sales_return.pos_sales_return_invoice as pos_sales_invoice,hd_pos_sales_return.pos_sales_return_date as pos_sales_date,hd_pos_sales_return.payment_list,hd_pos_sales_return.payment_remark,ms_store.store_code,user_account.user_realname,dt_pos_sales_return.sales_return_dpp as sales_dpp,dt_pos_sales_return.sales_return_ppn as sales_ppn,(dt_pos_sales_return.sales_return_qty*-1) as sales_qty,ms_product_unit.item_code,ms_product.product_name,ms_brand.brand_name,ms_category.category_name,dt_pos_sales_return.salesman_id,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name,hd_pos_sales_return.created_at')
            ->join('hd_pos_sales_return', 'hd_pos_sales_return.pos_sales_return_id=dt_pos_sales_return.pos_sales_return_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales_return.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales_return.user_id')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales_return.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales_return.salesman_id', 'left')
            ->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySalesReturn->where('hd_pos_sales_return.store_id', $store_id);
        }

        if ($salesman_id != '') {
            $querySalesReturn->where('dt_pos_sales_return.salesman_id', $salesman_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn>0');
            } else {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn=0');
            }
        }

        $qSI = $querySales->getCompiledSelect();
        $qSR = $querySalesReturn->getCompiledSelect();

        $sqlText = "$qSI UNION ALL $qSR ORDER BY salesman_id,created_at ASC";
        $getResult = $this->db->query($sqlText)->getResultArray();
        return $getResult;
    }

    public function getReportSalesListByPayment($start_date, $end_date, $store_id = '', $payment_method_id = '')
    {
        // get sales //

        $querySales = $this->db->table('dt_pos_sales_payment');
        $querySales->select('hd_pos_sales.pos_sales_invoice,hd_pos_sales.pos_sales_date,hd_pos_sales.payment_list,hd_pos_sales.payment_remark,ms_store.store_code,user_account.user_realname,dt_pos_sales_payment.payment_balance,hd_pos_sales.created_at,dt_pos_sales_payment.payment_method_id,ms_payment_method.payment_method_name,ms_payment_method.bank_account_name')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales_payment.pos_sales_id')
            ->join('ms_payment_method', 'ms_payment_method.payment_method_id=dt_pos_sales_payment.payment_method_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales.user_id')
            ->where("(hd_pos_sales.pos_sales_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySales->where('hd_pos_sales.store_id', $store_id);
        }

        if ($payment_method_id != '') {
            $querySales->where('dt_pos_sales_payment.payment_method_id', $payment_method_id);
        }



        // get sales return //
        $payment_cash_id = 1;

        $querySalesReturn = $this->db->table('hd_pos_sales_return');
        $querySalesReturn->select("hd_pos_sales_return.pos_sales_return_invoice as pos_sales_invoice,hd_pos_sales_return.pos_sales_return_date as pos_sales_date,hd_pos_sales_return.payment_list,hd_pos_sales_return.payment_remark,ms_store.store_code,user_account.user_realname,(hd_pos_sales_return.pos_sales_return_total*-1) as payment_balance,hd_pos_sales_return.created_at,1 as payment_method_id,'CASH' as payment_method_name,'' as bank_account_name")
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales_return.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales_return.user_id')
            ->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySalesReturn->where('hd_pos_sales_return.store_id', $store_id);
        }

        if ($payment_method_id != '') {
            if ($payment_method_id != $payment_cash_id) {
                $querySalesReturn->where('hd_pos_sales_return.pos_sales_return_invoice', 'cash');
            }
        }

        $qSI = $querySales->getCompiledSelect();
        $qSR = $querySalesReturn->getCompiledSelect();

        $sqlText = "$qSI UNION ALL $qSR ORDER BY payment_method_id,created_at ASC";
        $getResult = $this->db->query($sqlText)->getResultArray();
        return $getResult;
    }

    public function getReportDetailSalesListByBrand($start_date, $end_date, $store_id = '', $brand_id = '', $product_tax = '')
    {
        // get sales //
        $querySales = $this->db->table('dt_pos_sales');
        $querySales->select('hd_pos_sales.pos_sales_invoice,hd_pos_sales.pos_sales_date,hd_pos_sales.payment_list,hd_pos_sales.payment_remark,ms_store.store_code,user_account.user_realname,dt_pos_sales.sales_dpp,dt_pos_sales.sales_ppn,dt_pos_sales.sales_qty,ms_product_unit.item_code,ms_product.product_name,ms_brand.brand_name,ms_category.category_name,dt_pos_sales.salesman_id,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name,hd_pos_sales.created_at')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales.user_id')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales.salesman_id', 'left')
            ->where("(hd_pos_sales.pos_sales_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySales->where('hd_pos_sales.store_id', $store_id);
        }

        if ($brand_id != '') {
            $querySales->where('ms_product.brand_id', $brand_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySales->where('dt_pos_sales.sales_ppn>0');
            } else {
                $querySales->where('dt_pos_sales.sales_ppn=0');
            }
        }



        // get sales return //
        $querySalesReturn = $this->db->table('dt_pos_sales_return');
        $querySalesReturn->select('hd_pos_sales_return.pos_sales_return_invoice as pos_sales_invoice,hd_pos_sales_return.pos_sales_return_date as pos_sales_date,hd_pos_sales_return.payment_list,hd_pos_sales_return.payment_remark,ms_store.store_code,user_account.user_realname,dt_pos_sales_return.sales_return_dpp as sales_dpp,dt_pos_sales_return.sales_return_ppn as sales_ppn,(dt_pos_sales_return.sales_return_qty*-1) as sales_qty,ms_product_unit.item_code,ms_product.product_name,ms_brand.brand_name,ms_category.category_name,dt_pos_sales_return.salesman_id,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name,hd_pos_sales_return.created_at')
            ->join('hd_pos_sales_return', 'hd_pos_sales_return.pos_sales_return_id=dt_pos_sales_return.pos_sales_return_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales_return.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales_return.user_id')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales_return.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales_return.salesman_id', 'left')
            ->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySalesReturn->where('hd_pos_sales_return.store_id', $store_id);
        }

        if ($brand_id != '') {
            $querySalesReturn->where('ms_product.brand_id', $brand_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn>0');
            } else {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn=0');
            }
        }

        $qSI = $querySales->getCompiledSelect();
        $qSR = $querySalesReturn->getCompiledSelect();

        $sqlText = "$qSI UNION ALL $qSR ORDER BY brand_name,created_at ASC";
        $getResult = $this->db->query($sqlText)->getResultArray();
        return $getResult;
    }

    public function getReportDetailSalesListByCategory($start_date, $end_date, $store_id = '', $category_id = '', $product_tax = '')
    {
        // get sales //
        $querySales = $this->db->table('dt_pos_sales');
        $querySales->select('hd_pos_sales.pos_sales_invoice,hd_pos_sales.pos_sales_date,hd_pos_sales.payment_list,hd_pos_sales.payment_remark,ms_store.store_code,user_account.user_realname,dt_pos_sales.sales_dpp,dt_pos_sales.sales_ppn,dt_pos_sales.sales_qty,ms_product_unit.item_code,ms_product.product_name,ms_brand.brand_name,ms_category.category_name,dt_pos_sales.salesman_id,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name,hd_pos_sales.created_at')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales.user_id')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales.salesman_id', 'left')
            ->where("(hd_pos_sales.pos_sales_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySales->where('hd_pos_sales.store_id', $store_id);
        }

        if ($category_id != '') {
            $querySales->where('ms_product.category_id', $category_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySales->where('dt_pos_sales.sales_ppn>0');
            } else {
                $querySales->where('dt_pos_sales.sales_ppn=0');
            }
        }



        // get sales return //
        $querySalesReturn = $this->db->table('dt_pos_sales_return');
        $querySalesReturn->select('hd_pos_sales_return.pos_sales_return_invoice as pos_sales_invoice,hd_pos_sales_return.pos_sales_return_date as pos_sales_date,hd_pos_sales_return.payment_list,hd_pos_sales_return.payment_remark,ms_store.store_code,user_account.user_realname,dt_pos_sales_return.sales_return_dpp as sales_dpp,dt_pos_sales_return.sales_return_ppn as sales_ppn,(dt_pos_sales_return.sales_return_qty*-1) as sales_qty,ms_product_unit.item_code,ms_product.product_name,ms_brand.brand_name,ms_category.category_name,dt_pos_sales_return.salesman_id,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name,hd_pos_sales_return.created_at')
            ->join('hd_pos_sales_return', 'hd_pos_sales_return.pos_sales_return_id=dt_pos_sales_return.pos_sales_return_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales_return.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales_return.user_id')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales_return.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales_return.salesman_id', 'left')
            ->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySalesReturn->where('hd_pos_sales_return.store_id', $store_id);
        }

        if ($category_id != '') {
            $querySalesReturn->where('ms_product.category_id', $category_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn>0');
            } else {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn=0');
            }
        }

        $qSI = $querySales->getCompiledSelect();
        $qSR = $querySalesReturn->getCompiledSelect();

        $sqlText = "$qSI UNION ALL $qSR ORDER BY category_name,created_at ASC";
        $getResult = $this->db->query($sqlText)->getResultArray();
        return $getResult;
    }

    public function getReportDetailSalesListByCustomer($start_date, $end_date, $store_id = '', $customer_id = '', $product_tax = '')
    {
        // get sales //
        $querySales = $this->db->table('dt_pos_sales');
        $querySales->select('hd_pos_sales.pos_sales_invoice,hd_pos_sales.pos_sales_date,hd_pos_sales.payment_list,hd_pos_sales.payment_remark,ms_store.store_code,user_account.user_realname,dt_pos_sales.sales_dpp,dt_pos_sales.sales_ppn,dt_pos_sales.sales_qty,ms_product_unit.item_code,ms_product.product_name,ms_brand.brand_name,ms_category.category_name,dt_pos_sales.salesman_id,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name,hd_pos_sales.created_at,ms_customer.customer_code,ms_customer.customer_name')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->join('ms_customer', 'ms_customer.customer_id=hd_pos_sales.customer_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales.user_id')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales.salesman_id', 'left')
            ->where("(hd_pos_sales.pos_sales_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySales->where('hd_pos_sales.store_id', $store_id);
        }

        if ($customer_id != '') {
            $querySales->where('hd_pos_sales.customer_id', $customer_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySales->where('dt_pos_sales.sales_ppn>0');
            } else {
                $querySales->where('dt_pos_sales.sales_ppn=0');
            }
        }



        // get sales return //
        $querySalesReturn = $this->db->table('dt_pos_sales_return');
        $querySalesReturn->select('hd_pos_sales_return.pos_sales_return_invoice as pos_sales_invoice,hd_pos_sales_return.pos_sales_return_date as pos_sales_date,hd_pos_sales_return.payment_list,hd_pos_sales_return.payment_remark,ms_store.store_code,user_account.user_realname,dt_pos_sales_return.sales_return_dpp as sales_dpp,dt_pos_sales_return.sales_return_ppn as sales_ppn,(dt_pos_sales_return.sales_return_qty*-1) as sales_qty,ms_product_unit.item_code,ms_product.product_name,ms_brand.brand_name,ms_category.category_name,dt_pos_sales_return.salesman_id,ms_salesman.salesman_code,ms_salesman.salesman_name,ms_unit.unit_name,hd_pos_sales_return.created_at,ms_customer.customer_code,ms_customer.customer_name')
            ->join('hd_pos_sales_return', 'hd_pos_sales_return.pos_sales_return_id=dt_pos_sales_return.pos_sales_return_id')
            ->join('ms_customer', 'ms_customer.customer_id=hd_pos_sales_return.customer_id')
            ->join('ms_store', 'ms_store.store_id=hd_pos_sales_return.store_id')
            ->join('user_account', 'user_account.user_id=hd_pos_sales_return.user_id')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales_return.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_salesman', 'ms_salesman.salesman_id=dt_pos_sales_return.salesman_id', 'left')
            ->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN '$start_date' AND '$end_date')");

        if ($store_id != '') {
            $querySalesReturn->where('hd_pos_sales_return.store_id', $store_id);
        }

        if ($customer_id != '') {
            $querySalesReturn->where('hd_pos_sales_return.customer_id', $customer_id);
        }

        if ($product_tax != '') {
            if ($product_tax == 'Y') {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn>0');
            } else {
                $querySalesReturn->where('dt_pos_sales_return.sales_return_ppn=0');
            }
        }

        $qSI = $querySales->getCompiledSelect();
        $qSR = $querySalesReturn->getCompiledSelect();

        $sqlText = "$qSI UNION ALL $qSR ORDER BY customer_name,created_at ASC";
        $getResult = $this->db->query($sqlText)->getResultArray();
        return $getResult;
    }
}
