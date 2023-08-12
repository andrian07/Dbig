<?php

namespace App\Models;

use CodeIgniter\Model;

class M_retur extends Model
{
    protected $table_temp_retur_purchase = 'temp_retur_purchase';
    protected $table_hd_retur = 'hd_retur_purchase';
    protected $table_dt_retur = 'dt_retur_purchase';
    protected $table_hd_purchase = 'hd_purchase';
    protected $table_warehouse_stock = 'ms_warehouse_stock';
    protected $table_warehouse = 'ms_warehouse';
    protected $table_dt_purchase = 'dt_purchase';
    protected $table_sales_admin = 'hd_sales_admin';
    protected $table_temp_sales_admin = 'temp_sales_admin';
    protected $table_temp_retur_sales_admin = 'temp_retur_sales_admin';
    protected $table_hd_retur_sales_admin = 'hd_retur_sales_admin';
    protected $table_dt_retur_sales_admin = 'dt_retur_sales_admin';
    protected $table_hd_sales_admin = 'hd_sales_admin';
    protected $hd_payment_debt = 'hd_payment_debt';
    protected $dt_payment_debt = 'dt_payment_debt';

    public function insertTemp($data)
    {

        $exist = $this->db->table($this->table_temp_retur_purchase)

        ->where('retur_item_id', $data['retur_item_id'])

        ->where('retur_purchase_invoice', $data['retur_purchase_invoice'])

        ->where('retur_user_id', $data['retur_user_id'])

        ->countAllResults();


        if ($exist > 0) {

            return $this->db->table($this->table_temp_retur_purchase)

            ->where('retur_item_id', $data['retur_item_id'])

            ->where('retur_purchase_invoice', $data['retur_purchase_invoice'])

            ->where('retur_user_id', $data['retur_user_id'])

            ->update($data);

        } else {

            $this->db->table($this->table_temp_retur_purchase)->where('retur_user_id', $data['retur_user_id'])->where('retur_item_id', $data['retur_item_id'])->delete();

            return $this->db->table($this->table_temp_retur_purchase)->insert($data);

        }

    }

    public function insertTempSalesAdmin($data)
    {

        $exist = $this->db->table($this->table_temp_retur_sales_admin)

        ->where('retur_item_id', $data['retur_item_id'])

        ->where('retur_user_id', $data['retur_user_id'])

        ->countAllResults();


        if ($exist > 0) {

            return $this->db->table($this->table_temp_retur_sales_admin)

            ->where('retur_item_id', $data['retur_item_id'])

            ->where('retur_user_id', $data['retur_user_id'])

            ->update($data);

        } else {

            $this->db->table($this->table_temp_retur_sales_admin)->where('retur_user_id', $data['retur_user_id'])->where('retur_item_id', $data['retur_item_id'])->delete();

            return $this->db->table($this->table_temp_retur_sales_admin)->insert($data);

        }

    }

    public function searchPurchaseBysuplier($keyword, $supplier_id = '', $isItemCode = FALSE, $limit = 10)
    {
        $builder = $this->db->table('hd_purchase');
        $builder->select('purchase_id, purchase_invoice');
        $builder->Like('purchase_invoice', $keyword);
        return  $builder->limit($limit)->get();
    }

    public function searchReturSalesAdminProduct($keyword, $sales_admin_id= '', $isItemCode = FALSE, $limit = 10)
    {
        $builder = $this->db->table('dt_sales_admin');
        $builder->select('*')
        ->join('ms_product_unit', 'ms_product_unit.item_id=dt_sales_admin.dt_item_id')
        ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
        ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id');

        if ($isItemCode) {
            $builder->where('ms_product_unit.item_code', $keyword);
            $builder->where('dt_sales_admin.sales_admin_id', $sales_admin_id);
        } else {
            $builder->where('dt_sales_admin.sales_admin_id', $sales_admin_id);
            $builder->groupStart();
            $builder->Like('ms_product.product_name', $keyword);
            $builder->orLike('ms_product_unit.item_code', $keyword);    
            $builder->groupEnd();
        }
        return  $builder->limit($limit)->get();
    }

    public function searchProductByInvoice($keyword, $purchaseno = '', $isItemCode = FALSE, $limit = 10)
    {

        $builder = $this->db->table('dt_purchase');
        $builder->select('ms_warehouse.*, dt_purchase.*, ms_product_unit.*,ms_product.product_name,(ms_product.base_purchase_price*ms_product_unit.product_content) as purchase_price,(ms_product.base_purchase_tax*ms_product_unit.product_content) as purchase_tax,ms_unit.unit_name,ms_product.is_parcel')
        ->join('ms_product_unit', 'ms_product_unit.item_id=dt_purchase.dt_purchase_item_id')
        ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
        ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
        ->join('hd_purchase', 'hd_purchase.purchase_invoice=dt_purchase.dt_purchase_invoice')
        ->join('ms_warehouse', 'ms_warehouse.warehouse_id=hd_purchase.purchase_warehouse_id');

        if ($isItemCode) {
            $builder->where('ms_product_unit.item_code', $keyword);
            $builder->where('dt_purchase.dt_purchase_invoice', $purchaseno);
            
        } else {
            $builder->where('dt_purchase.dt_purchase_invoice', $purchaseno);
            $builder->groupStart();
            $builder->Like('ms_product.product_name', $keyword);
            $builder->orLike('ms_product_unit.item_code', $keyword);    
            $builder->groupEnd();
        }
        return  $builder->limit($limit)->get();
    }

    public function searchInvoiceSalesAdmin($keyword, $isItemCode = FALSE, $limit = 10)
    {
        $builder = $this->db->table('hd_sales_admin');
        $builder->select('*');
        $builder->Like('sales_admin_invoice', $keyword);
        return  $builder->limit($limit)->get();
    }


    public function deletetemp($retur_item_id, $user_id)
    {

        return $this->db->table($this->table_temp_retur_purchase)

        ->where('retur_item_id', $retur_item_id)

        ->where('retur_user_id', $user_id)

        ->delete();
    }

    public function deleteTempSalesAdmin($retur_item_id, $user_id)
    {
        return $this->db->table($this->table_temp_retur_sales_admin)

        ->where('retur_item_id', $retur_item_id)

        ->where('retur_user_id', $user_id)

        ->delete();
    }

    public function getFooter($user_id){

        $builder = $this->db->table($this->table_temp_retur_purchase);

        return $builder->select('sum(retur_total) as subTotal')

        ->where('temp_retur_purchase.retur_user_id', $user_id)

        ->get();

    }

    public function getReturSalesAdminFooter($user_id){

        $builder = $this->db->table($this->table_temp_retur_sales_admin);

        return $builder->select('sum(retur_total) as subTotal')

        ->where('retur_user_id', $user_id)

        ->get();

    }

    public function getReturCheck($purchase_inv, $purchase_item_id)
    {

        $builder = $this->db->table('dt_retur_purchase');

        return $builder->select('sum(dt_retur_qty) as dt_retur_qty')

        ->where('dt_retur_purchase_invoice', $purchase_inv)

        ->where('dt_retur_item_id', $purchase_item_id)

        ->get();
    }

    public function getRemainingDebt($retur_purchase_invoice)
    {
        $builder = $this->db->table('hd_purchase');

        return $builder->select('purchase_remaining_debt')

        ->where('purchase_invoice', $retur_purchase_invoice)

        ->get();
    }

    public function getTemp($user_id)
    {
        $builder = $this->db->table($this->table_temp_retur_purchase);

        return $builder->select('temp_retur_purchase.*, ms_product_unit.item_code, ms_product.product_code, ms_product_unit.product_content,  ms_product.product_name, temp_retur_purchase.retur_item_id, ms_product.product_id, ms_warehouse.warehouse_name, ms_unit.unit_name')
        
        ->join('ms_product_unit', 'ms_product_unit.item_id = temp_retur_purchase.retur_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->join('ms_warehouse', 'ms_warehouse.warehouse_id = temp_retur_purchase.retur_warehouse')

        ->where('temp_retur_purchase.retur_user_id', $user_id)

        ->orderBy('temp_retur_purchase.retur_update_at', 'ASC')

        ->get();
    }

    public function getTempReturSalesAdmin($user_id)
    {
        $builder = $this->db->table($this->table_temp_retur_sales_admin);

        return $builder->select('store_id, store_name, customer_id, customer_name, temp_retur_sales_admin.*, ms_product_unit.item_code, ms_product.product_id, ms_product.product_code, ms_product_unit.product_content,  ms_product.product_name, temp_retur_sales_admin.retur_item_id, ms_product.product_id, ms_unit.unit_name, hd_sales_admin.sales_admin_id')

        ->join('hd_sales_admin', 'hd_sales_admin.sales_admin_invoice = temp_retur_sales_admin.retur_sales_admin_invoice')

        ->join('ms_customer', 'ms_customer.customer_id = hd_sales_admin.sales_customer_id')

        ->join('ms_store', 'ms_store.store_id = hd_sales_admin.sales_store_id')

        ->join('ms_product_unit', 'ms_product_unit.item_id = temp_retur_sales_admin.retur_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->where('temp_retur_sales_admin.retur_user_id', $user_id)

        ->orderBy('temp_retur_sales_admin.retur_update_at', 'ASC')

        ->get();
    }

    public function getTempReturPPNandDPP($user_id)
    {
        $builder = $this->db->table($this->table_temp_retur_purchase);

        return $builder->select('sum(retur_ppn) as total_retur_ppn, sum(retur_dpp) as total_retur_dpp')

        ->where('temp_retur_purchase.retur_user_id', $user_id)

        ->get();
    }

    public function getTempReturPPNandDPPSalesAdmin($user_id)
    {
        $builder = $this->db->table($this->table_temp_retur_sales_admin);

        return $builder->select('sum(retur_ppn) as total_retur_ppn, sum(retur_price - retur_disc - retur_disc_nota) as total_retur_dpp')

        ->where('temp_retur_sales_admin.retur_user_id', $user_id)

        ->get();
    }

    public function updateRetur($input)
    {
        $this->db->query('LOCK TABLES hd_retur_purchase WRITE, dt_retur_purchase READ');

        $this->db->transBegin();

        $saveQueries = NULL;

        $hd_retur_purchase_id           = $input['hd_retur_purchase_id'];
        $hd_retur_payment               = $input['payment_type'];
        $hd_retur_total_transaction     = $input['hd_retur_total_transaction'];
        $payment_bank                   = $input['payment_bank'];
        $user_id                        = $input['user_id'];
        $payment_bank_name              = $input['payment_bank_name'];
       
        $updateRetur = "update hd_retur_purchase SET hd_retur_payment = '".$hd_retur_payment."' WHERE hd_retur_purchase_id = '".$hd_retur_purchase_id."'";
        $this->db->query($updateRetur);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }
        
        /*
        // SAVE DEBT HISTORY //
        $get_purchase = $this->getReturAccounting($hd_retur_purchase_id)->getRowArray();
        $data = [
            'purchase_id'                => $get_purchase['purchase_id'],
            'payment_debt_supplier_id'   => $get_purchase['supplier_id'],
            'payment_debt_total_invoice' => $get_purchase['purchase_total'],
            'payment_debt_total_pay'     => $hd_retur_total_transaction,
            'payment_debt_method_id'     => $payment_bank,
            'payment_debt_method_name'   => $payment_bank_name,
            'payment_debt_date'          => date("Y/m/d"),
            'user_id'                    => $user_id,
        ];  
        $maxCode = $this->db->table($this->hd_payment_debt)->select('payment_debt_id, payment_debt_invoice')->orderBy('payment_debt_id', 'desc')->limit(1)->get()->getRowArray();
        $invoice_date =  date_format(date_create($data['payment_debt_date']),"y/m/d");
        if ($maxCode == NULL) {
            $data['payment_debt_invoice'] = 'PH/'.$invoice_date.'/'.'0000000001';
        } else {
            $invoice = substr($maxCode['payment_debt_invoice'], -10);
            $data['payment_debt_invoice'] = 'PH/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);
        }
        $count_invoice =  $this->count_invoice($data['user_id'])->getResultArray();
        $data['payment_debt_total_invoice'] = $count_invoice[0]['total_invoice_pay'];
        $this->db->table($this->hd_payment_debt)->insert($data);
        $payment_debt_id  = $this->db->insertID();
        if ($this->db->affectedRows() > 0) {
           $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }
        $data_dt = [
            'payment_debt_id'                => $payment_debt_id,
            'dt_payment_debt_purchase_id'    => $get_purchase['purchase_id'],
            'dt_payment_debt_discount'       => 0,
            'dt_payment_debt_retur'          => 0,
            'dt_payment_debt_desc'           => 'Retur Item',
            'dt_payment_debt_nominal'        => $hd_retur_total_transaction,
        ];
        $this->db->table($this->dt_payment_debt)->insert($data_dt);
        $payment_debt_id  = $this->db->insertID();
        if ($this->db->affectedRows() > 0) {
           $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }
        //END SAVE DEBT HISTORY //
        */

        $getTotalRetur = $this->db->table($this->table_dt_retur)->select('dt_retur_purchase_invoice, sum(dt_retur_total) as total_retur')->where('hd_retur_purchase_id', $hd_retur_purchase_id)->groupby('dt_retur_purchase_invoice')->get();
        foreach ($getTotalRetur->getResultArray() as $row) {
           if($hd_retur_payment == 'Ya'){
            $get_purchase_retur_nominal = $this->db->table($this->table_hd_purchase)->select('purchase_retur_nominal')->where('purchase_invoice', $row['dt_retur_purchase_invoice'])->get()->getResultArray();
            $total_retur_purchase = $get_purchase_retur_nominal[0]['purchase_retur_nominal'] + $hd_retur_total_transaction;
            $remaining_debt_cal = $input['remaining_debt'] - $hd_retur_total_transaction;
            $updatePurchase =  "update hd_purchase SET purchase_remaining_debt = '".$remaining_debt_cal."' WHERE purchase_invoice = '".$row['dt_retur_purchase_invoice']."'";
            $this->db->query($updatePurchase);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
    
            }
        }
    }

    $updateStatus =  $this->db->table($this->table_hd_retur)->where('hd_retur_purchase_id', $hd_retur_purchase_id)->update(['hd_retur_status' => 'Selesai']);


        //$sqlUpdateProduct = "insert into ms_product (product_id, product_code, product_name, category_id, brand_id, base_purchase_price, base_purchase_tax, base_cogs, product_description, product_image, min_stock, has_tax, is_parcel, active, deleted) VALUES";

    $sqlUpdateStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

    $sqlUpdateWarehouse = "insert into ms_warehouse_stock (stock_id, product_id , warehouse_id , purchase_id , exp_date, stock) VALUES";

        //$vUpdateProduct = [];
    $vUpdateStock = [];
    $vUpdateWarehouse = [];

    $getDtRetur =  $this->getDtRetur($hd_retur_purchase_id);

    foreach ($getDtRetur->getResultArray() as $row) {

        $hd_retur_purchase_id                  = $hd_retur_purchase_id ;
        $dt_retur_purchase_invoice             = $row['dt_retur_purchase_invoice'];
        $dt_retur_supplier_id                  = $row['dt_retur_supplier_id'];
        $dt_retur_item_id                      = $row['dt_retur_item_id'];
        $dt_retur_price                        = floatval($row['dt_retur_price']);
        $dt_retur_ppn                          = floatval($row['dt_retur_ppn']);
        $dt_retur_warehouse                    = $row['dt_retur_warehouse'];
        $dt_retur_qty                          = floatval($row['dt_retur_qty']);
        $dt_retur_total                        = floatval($row['dt_retur_total']);


        $getPurchase = $this->db->table($this->table_hd_purchase)->select('*')->where('purchase_invoice', $dt_retur_purchase_invoice)->get()->getRowArray();

            /*$product_id             = $row['product_id'];
            $product_code           = $row['product_code'];
            $product_name           = $row['product_name'];
            $category_id            = $row['category_id'];
            $brand_id               = $row['brand_id'];
            $base_purchase_price    = $row['base_purchase_price'];
            $base_purchase_tax      = $row['base_purchase_tax'];
            $base_cogs              = $row['base_cogs'];
            $product_description    = $row['product_description'];
            $product_image          = $row['product_image'];
            $min_stock              = $row['min_stock'];
            $has_tax                = $row['has_tax'];
            $is_parcel              = $row['is_parcel'];
            $active                 = $row['active'];
            $deleted                = $row['deleted'];
            $stock                  = $row['stock'];

            print_r($row );die();

            $calcualtion_cogs       = round((($base_cogs * $stock) + ($new_cogs * $new_total_stock)) / ($stock + $new_total_stock), 2);
            */
            $product_id             = $row['product_id'];
            
            $product_content        = floatval($row['product_content']);

            $base_purchase_stock    = $dt_retur_qty * $product_content;

            $purchase_id            = $getPurchase['purchase_id'];



            $getWarehouseStock = $this->db->table($this->table_warehouse_stock)->select('*')->where('purchase_id', $purchase_id)->where('product_id', $product_id)->get()->getRowArray();


            $stock_id               = $getWarehouseStock['stock_id'];

            $exp_date_ed            = $getWarehouseStock['exp_date'];

            //$vUpdateProduct[] = "('$product_id', '$product_code', '$product_name', '$category_id', '$brand_id', '$base_purchase_price', '$base_purchase_tax', '$calcualtion_cogs', '$product_description', '$product_image', '$min_stock', '$has_tax', '$is_parcel', '$active', '$deleted')";

            $vUpdateStock[] = "('$product_id', '$dt_retur_warehouse', '$base_purchase_stock')";

            $vUpdateWarehouse[] = "('$stock_id', '$product_id', '$dt_retur_warehouse', '$purchase_id', '$exp_date_ed', '$base_purchase_stock')";
        }

        
        $sqlUpdateStock .= implode(',', $vUpdateStock). " ON DUPLICATE KEY UPDATE stock=stock-VALUES(stock)";

        $sqlUpdateWarehouse .= implode(',', $vUpdateWarehouse). " ON DUPLICATE KEY UPDATE stock=stock-VALUES(stock)";

        
        $this->db->query($sqlUpdateStock);

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }

        $this->db->query($sqlUpdateWarehouse);

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }

        if ($this->db->transStatus() === false) {

            $saveQueries[] = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'hd_retur_purchase_id' => 0];

        } else {

            $this->db->transCommit();

            $save = ['success' => TRUE, 'hd_retur_purchase_id' => $hd_retur_purchase_id ];

        }


        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'retur_purchase', $hd_retur_purchase_id, 'update_payment');

        return $save;

    }


    public function updateReturSalesAdmin($input)
    {
        $this->db->query('LOCK TABLES hd_retur_sales_admin WRITE, dt_retur_sales_admin READ');

        $this->db->transBegin();

        $saveQueries = NULL;

        $sales_no                          = $input['sales_no'];
        $hd_retur_sales_admin_id           = $input['hd_retur_sales_admin_id'];
        $hd_retur_payment                  = $input['payment_type'];
        $hd_retur_total_transaction        = $input['hd_retur_total_transaction'];


        $updateRetur = "update hd_retur_sales_admin SET hd_retur_payment = '".$hd_retur_payment."' WHERE hd_retur_sales_admin_id = '".$hd_retur_sales_admin_id."'";

        $this->db->query($updateRetur);

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }
        $get_sales_admin = $this->db->table($this->table_hd_sales_admin)->select('*')->where('sales_admin_invoice', $sales_no)->get()->getRowArray();
             
        if($hd_retur_payment == 'Ya'){

            $get_sales_admin_retur_nominal = $this->db->table($this->table_hd_sales_admin)->select('sales_admin_retur_nominal, sales_admin_remaining_payment')->where('sales_admin_invoice', $sales_no)->get()->getRowArray();
            $total_retur_sales_admin = $get_sales_admin_retur_nominal['sales_admin_retur_nominal'] + $hd_retur_total_transaction;
            $remaining_repayment_cal = $get_sales_admin_retur_nominal['sales_admin_remaining_payment'] - $hd_retur_total_transaction;
            $updateSalesAdmin =  "update hd_sales_admin SET sales_admin_remaining_payment = '".$remaining_repayment_cal."' WHERE sales_admin_invoice = '".$sales_no."'";
            $this->db->query($updateSalesAdmin);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
    
            }
        }

        $updateStatus =  $this->db->table($this->table_hd_retur_sales_admin)->where('hd_retur_sales_admin_id', $hd_retur_sales_admin_id)->update(['hd_retur_status' => 'Selesai']);


        
        $sqlUpdateStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

        $sqlUpdateWarehouse = "insert into ms_warehouse_stock (stock_id, product_id , warehouse_id , purchase_id , exp_date, stock) VALUES";

        //$vUpdateProduct = [];
        $vUpdateStock = [];
        $vUpdateWarehouse = [];


        $getDtRetur =  $this->getDtReturSalesAdmin($hd_retur_sales_admin_id);

        foreach ($getDtRetur->getResultArray() as $row) {

            $getWarehouse =  $this->getWarehouse($row['hd_retur_store_id'], $hd_retur_sales_admin_id)->getRowArray();

            $hd_retur_sales_admin_id               = $hd_retur_sales_admin_id ;
            $dt_retur_item_id                      = $row['dt_retur_item_id'];
            $dt_retur_price                        = floatval($row['dt_retur_price']);
            $dt_retur_dpp                          = floatval($row['dt_retur_dpp']);
            $dt_retur_ppn                          = floatval($row['dt_retur_ppn']);
            $dt_retur_warehouse                    = $getWarehouse['warehouse_id'];
            $dt_retur_qty                          = floatval($row['dt_retur_qty']);
            $dt_retur_total                        = floatval($row['dt_retur_total']);

            $product_id                            = $row['product_id'];
            
            $product_content        = floatval($row['product_content']);

            $base_sales_stock    = $dt_retur_qty * $product_content;

            $getWarehouseStock = $this->db->table($this->table_warehouse_stock)->select('*')->where('product_id', $product_id)->where('warehouse_id', $dt_retur_warehouse)->orderBy('exp_date', 'desc')->limit(1)->get()->getRowArray();

            if($getWarehouseStock != null){
                $stock_id               = $getWarehouseStock['stock_id'];
                $exp_date_ed            = $getWarehouseStock['exp_date'];
                $purchase_id            = $getWarehouseStock['purchase_id'];
            }

            $vUpdateStock[] = "('$product_id', '$dt_retur_warehouse', '$base_sales_stock')";

            if($getWarehouseStock != null){
                $vUpdateWarehouse[] = "('$stock_id', '$product_id', '$dt_retur_warehouse', '$purchase_id', '$exp_date_ed', '$base_sales_stock')";
            }
        }

        
        $sqlUpdateStock .= implode(',', $vUpdateStock). " ON DUPLICATE KEY UPDATE stock=stock+VALUES(stock)";

        if($getWarehouseStock != null){
            $sqlUpdateWarehouse .= implode(',', $vUpdateWarehouse). " ON DUPLICATE KEY UPDATE stock=stock+VALUES(stock)";
        }

        
        $this->db->query($sqlUpdateStock);

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }

        if($getWarehouseStock != null){
            $this->db->query($sqlUpdateWarehouse);

            if ($this->db->affectedRows() > 0) {

                $saveQueries[] = $this->db->getLastQuery()->getQuery();

            }
        }

        if ($this->db->transStatus() === false) {

            $saveQueries[] = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'hd_retur_sales_admin_id' => 0];

        } else {

            $this->db->transCommit();

            $save = ['success' => TRUE, 'hd_retur_sales_admin_id' => $hd_retur_sales_admin_id ];

        }


        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'retur_sales_admin', $hd_retur_sales_admin_id, 'update_payment');

        return $save;

    }

    public function cancelOrder($hd_retur_purchase_id)
    {

        $this->db->query('LOCK TABLES hd_retur_purchase WRITE');

        $save =  $this->db->table($this->table_hd_retur)->where('hd_retur_purchase_id', $hd_retur_purchase_id)->update(['hd_retur_status' => 'Cancel']);

        $saveQueries = NULL;

        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }

        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'retur_purchase', $hd_retur_purchase_id, 'cancel_retur');

        return $save;
    }

    public function cancelOrderSalesAdmin($hd_retur_sales_admin_id)
    {

        $this->db->query('LOCK TABLES hd_retur_sales_admin WRITE');

        $save =  $this->db->table($this->table_hd_retur_sales_admin)->where('hd_retur_sales_admin_id', $hd_retur_sales_admin_id)->update(['hd_retur_status' => 'Cancel']);

        $saveQueries = NULL;

        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }

        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'retur_purchase', $hd_retur_sales_admin_id, 'cancel_retur_sales_admin');

        return $save;
    }

    public function insertRetur($data)
    {
        $this->db->query('LOCK TABLES hd_retur_purchase WRITE, dt_retur_purchase WRITE');

        $this->db->transBegin();

        $saveQueries = NULL;

        $maxCode = $this->db->table($this->table_hd_retur)->select('hd_retur_purchase_id, hd_retur_purchase_invoice')->orderBy('hd_retur_purchase_id', 'desc')->limit(1)->get()->getRowArray();

        $invoice_date =  date_format(date_create($data['hd_retur_date']),"y/m");

        if ($maxCode == NULL) {

            $data['hd_retur_purchase_invoice'] = 'RTR/'.$invoice_date.'/'.'0000000001';

        } else {

            $invoice = substr($maxCode['hd_retur_purchase_invoice'], -10);

            $data['hd_retur_purchase_invoice'] = 'RTR/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);
        }

        $getTempReturPPNandDPP =  $this->getTempReturPPNandDPP($data['created_by'])->getResultArray();

        $data['hd_retur_total_dpp'] = $getTempReturPPNandDPP[0]['total_retur_dpp'];

        $data['hd_retur_total_ppn'] = $getTempReturPPNandDPP[0]['total_retur_ppn'];

        $this->db->table($this->table_hd_retur)->insert($data);

        $hd_retur_purchase_id  = $this->db->insertID();

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }


        $sqlDtOrder = "insert into dt_retur_purchase(hd_retur_purchase_id,dt_retur_purchase_invoice,dt_retur_supplier_id,dt_retur_item_id,dt_retur_price,dt_retur_ppn,dt_retur_dpp,dt_retur_disc,dt_retur_disc_nota,dt_retur_ongkir,dt_retur_warehouse,dt_retur_qty_buy,dt_retur_qty,dt_retur_total) VALUES";

        //$sqlUpdateStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

        //$sqlUpdateWarehouse = "insert into ms_warehouse_stock (stock_id, product_id , warehouse_id , purchase_id , exp_date, stock) VALUES";

        $sqlDtValues = [];
        $vUpdateProduct = [];
        $vUpdateStock = [];
        $vUpdateWarehouse = [];


        $getTemp =  $this->getTemp($data['created_by']);


        foreach ($getTemp->getResultArray() as $row) {

            $hd_retur_purchase_id                  = $hd_retur_purchase_id ;
            $dt_retur_purchase_invoice             = $row['retur_purchase_invoice'];
            $dt_retur_supplier_id                  = $row['retur_supplier_id'];
            $dt_retur_item_id                      = $row['retur_item_id'];
            $dt_retur_price                        = floatval($row['retur_price']);
            $dt_retur_ppn                          = floatval($row['retur_ppn']);

            $dt_retur_dpp                          = floatval($row['retur_dpp']);
            $dt_retur_disc                         = floatval($row['retur_disc']);
            $dt_retur_disc_nota                    = floatval($row['retur_disc_nota']);
            $dt_retur_ongkir                       = floatval($row['retur_ongkir']);

            $dt_retur_warehouse                    = $row['retur_warehouse'];
            $dt_retur_qty                          = floatval($row['retur_qty']);
            $dt_retur_qty_buy                      = floatval($row['retur_qty_buy']);
            $dt_retur_total                        = floatval($row['retur_total']);


            $getPurchase = $this->db->table($this->table_hd_purchase)->select('*')->where('purchase_invoice', $dt_retur_purchase_invoice)->get()->getRowArray();

            $product_id             = $row['product_id'];

            $product_content        = floatval($row['product_content']);

            $base_purchase_stock    = $dt_retur_qty * $product_content;

            $purchase_id            = $getPurchase['purchase_id'];



            $getWarehouseStock = $this->db->table($this->table_warehouse_stock)->select('*')->where('purchase_id', $purchase_id)->where('product_id', $product_id)->get()->getRowArray();

            $sqlDtValues[] = "('$hd_retur_purchase_id','$dt_retur_purchase_invoice','$dt_retur_supplier_id','$dt_retur_item_id','$dt_retur_price','$dt_retur_ppn','$dt_retur_dpp','$dt_retur_disc','$dt_retur_disc_nota','$dt_retur_ongkir','$dt_retur_warehouse','$dt_retur_qty_buy','$dt_retur_qty','$dt_retur_total')";

        }

        $sqlDtOrder .= implode(',', $sqlDtValues);



        $this->db->query($sqlDtOrder);

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }

        if ($this->db->transStatus() === false) {

            $saveQueries[] = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'hd_retur_purchase_id' => 0];

        } else {

            $this->db->transCommit();

            $this->clearTemp($data['created_by']);

            $save = ['success' => TRUE, 'hd_retur_purchase_id' => $hd_retur_purchase_id ];

        }


        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'retur_purchase', $hd_retur_purchase_id, 'insertReturPurchase');

        return $save;
    }

    public function insertReturSalesAdmin($data)
    {
        $this->db->query('LOCK TABLES hd_retur_sales_admin WRITE, dt_retur_sales_admin WRITE');

        $this->db->transBegin();

        $saveQueries = NULL;

        $maxCode = $this->db->table($this->table_hd_retur_sales_admin)->select('hd_retur_sales_admin_id, hd_retur_sales_admin_invoice')->orderBy('hd_retur_sales_admin_id', 'desc')->limit(1)->get()->getRowArray();

        $invoice_date =  date_format(date_create($data['hd_retur_date']),"y/m");

        if ($maxCode == NULL) {

            $data['hd_retur_sales_admin_invoice'] = 'RTR/A/'.$invoice_date.'/'.'0000000001';

        } else {

            $invoice = substr($maxCode['hd_retur_sales_admin_invoice'], -10);

            $data['hd_retur_sales_admin_invoice'] = 'RTR/A/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);
        }

        $getTempReturPPNandDPPSalesAdmin =  $this->getTempReturPPNandDPPSalesAdmin($data['created_by'])->getResultArray();

        $data['hd_retur_total_dpp'] = $getTempReturPPNandDPPSalesAdmin[0]['total_retur_dpp'];

        $data['hd_retur_total_ppn'] = $getTempReturPPNandDPPSalesAdmin[0]['total_retur_ppn'];

        $this->db->table($this->table_hd_retur_sales_admin)->insert($data);

        $hd_retur_sales_admin_id  = $this->db->insertID();

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }


        $sqlDtOrder = "insert into dt_retur_sales_admin(hd_retur_sales_admin_id,dt_retur_item_id,dt_retur_price,dt_retur_ppn,dt_retur_dpp,dt_retur_disc,dt_retur_disc_nota,dt_retur_qty,dt_retur_qty_sell,dt_retur_total) VALUES";


        $sqlDtValues = [];


        $getTemp =  $this->getTempReturSalesAdmin($data['created_by']);


        foreach ($getTemp->getResultArray() as $row) {

            $hd_retur_sales_admin_id               = $hd_retur_sales_admin_id ;
            $dt_retur_item_id                      = $row['retur_item_id'];
            $dt_retur_price                        = floatval($row['retur_price']);
            $dt_retur_ppn                          = floatval($row['retur_ppn']);
            $dt_retur_disc                         = floatval($row['retur_disc']);
            $dt_retur_disc_nota                    = floatval($row['retur_disc_nota']);
            $dt_retur_dpp                          = floatval($row['retur_price'] - $row['retur_disc'] - $row['retur_disc_nota']);
            $dt_retur_qty                          = floatval($row['retur_qty']);
            $dt_retur_qty_sell                     = floatval($row['retur_qty_sell']);
            $dt_retur_total                        = floatval($row['retur_total']);

            $sales_admin_id                        = $data['sales_admin_id'];

            $product_id             = $row['product_id'];
            $product_content        = floatval($row['product_content']);
            $base_purchase_stock    = $dt_retur_qty * $product_content;

            //$getwarehouse = $this->db->table($this->table_warehouse)->select('*')->where('store_id', $data['hd_retur_store_id'])->where('warehouse_name NOT LIKE "%konsinyasi%"')->limit(1)->get()->getRowArray();

            //$warehouse_id = $getwarehouse['warehouse_id'];

            //$getWarehouseStock = $this->db->table($this->table_warehouse_stock)->select('*')->where('product_id', $product_id)->where('warehouse_id', $warehouse_id)->orderBy('exp_date', 'desc')->limit(1)->get()->getRowArray();



            $sqlDtValues[] = "('$hd_retur_sales_admin_id','$dt_retur_item_id','$dt_retur_price','$dt_retur_ppn','$dt_retur_dpp','$dt_retur_disc','$dt_retur_disc_nota','$dt_retur_qty','$dt_retur_qty_sell','$dt_retur_total')";

        }

        $sqlDtOrder .= implode(',', $sqlDtValues);



        $this->db->query($sqlDtOrder);
        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }

        if ($this->db->transStatus() === false) {

            $saveQueries[] = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'hd_retur_sales_admin_id' => 0];

        } else {

            $this->db->transCommit();

            $this->clearTempSalesAdmin($data['created_by']);

            $save = ['success' => TRUE, 'hd_retur_sales_admin_id' => $hd_retur_sales_admin_id ];

        }


        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'retur_sales_admin', $hd_retur_sales_admin_id, 'insertReturSalesAdmin');

        return $save;
    }

    public function clearTemp($user_id)
    {
        return $this->db->table($this->table_temp_retur_purchase)

        ->where('retur_user_id', $user_id)

        ->delete();
    }

    public function clearTempSalesAdmin($user_id)
    {
        return $this->db->table($this->table_temp_retur_sales_admin)

        ->where('retur_user_id', $user_id)

        ->delete();
    }


    public function getRetur($hd_retur_purchase_id)
    {

        $builder = $this->db->table($this->table_hd_retur);

        return $builder->select('*, hd_retur_purchase.created_at as created_at')

        ->join('user_account', 'user_account.user_id = hd_retur_purchase.created_by')

        ->join('ms_supplier', 'ms_supplier.supplier_id = hd_retur_purchase.hd_retur_supplier_id')

        ->where('hd_retur_purchase.hd_retur_purchase_id', $hd_retur_purchase_id)

        ->get();
    }

    public function getReturAccounting($hd_retur_purchase_id)
    {

        $builder = $this->db->table($this->table_hd_retur);

        return $builder->select('*, hd_retur_purchase.created_at as created_at')

        ->join('dt_retur_purchase', 'dt_retur_purchase.hd_retur_purchase_id = hd_retur_purchase.hd_retur_purchase_id')

        ->join('hd_purchase', 'hd_purchase.purchase_invoice = dt_retur_purchase.dt_retur_purchase_invoice')

        ->join('ms_warehouse', 'ms_warehouse.warehouse_id = dt_retur_purchase.dt_retur_warehouse')

        ->join('ms_store', 'ms_store.store_id = ms_warehouse.store_id')

        ->join('user_account', 'user_account.user_id = hd_retur_purchase.created_by')

        ->join('ms_supplier', 'ms_supplier.supplier_id = hd_retur_purchase.hd_retur_supplier_id')

        ->where('hd_retur_purchase.hd_retur_purchase_id', $hd_retur_purchase_id)

        ->get();
    }

    public function getReturSalesAdminAccounting($hd_retur_sales_admin_id)
    {

        $builder = $this->db->table($this->table_hd_retur_sales_admin);

        return $builder->select('*, hd_retur_sales_admin.created_at as created_at')

        ->join('dt_retur_sales_admin', 'dt_retur_sales_admin.hd_retur_sales_admin_id = hd_retur_sales_admin.hd_retur_sales_admin_id')

        ->join('hd_sales_admin', 'hd_sales_admin.sales_admin_id = hd_retur_sales_admin.sales_admin_id')

        ->join('ms_store', 'ms_store.store_id = hd_retur_sales_admin.hd_retur_store_id')

        ->join('user_account', 'user_account.user_id = hd_retur_sales_admin.created_by')

        ->join('ms_customer', 'ms_customer.customer_id = hd_retur_sales_admin.hd_retur_customer_id')

        ->where('hd_retur_sales_admin.hd_retur_sales_admin_id', $hd_retur_sales_admin_id)

        ->get();
    }

    public function getDtRetur($hd_retur_purchase_id)
    {

        $builder = $this->db->table($this->table_dt_retur);

        return $builder->select('*')

        ->join('ms_product_unit', 'ms_product_unit.item_id = dt_retur_purchase.dt_retur_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_warehouse', 'ms_warehouse.warehouse_id = dt_retur_purchase.dt_retur_warehouse')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->where('hd_retur_purchase_id', $hd_retur_purchase_id)

        ->get();

    }

    public function getReturSalesAdmin($hd_retur_sales_admin_id)
    {

        $builder = $this->db->table($this->table_hd_retur_sales_admin);

        return $builder->select('*, hd_retur_sales_admin.created_at as created_at')

        ->join('user_account', 'user_account.user_id = hd_retur_sales_admin.created_by')

        ->join('ms_customer', 'ms_customer.customer_id = hd_retur_sales_admin.hd_retur_customer_id')

        ->join('ms_store', 'ms_store.store_id = hd_retur_sales_admin.hd_retur_store_id')

        ->where('hd_retur_sales_admin.hd_retur_sales_admin_id', $hd_retur_sales_admin_id)

        ->get();
    }

    
    public function getDtReturSalesAdmin($hd_retur_sales_admin_id)
    {

        $builder = $this->db->table($this->table_dt_retur_sales_admin);

        return $builder->select('*')

        ->join('hd_retur_sales_admin', 'hd_retur_sales_admin.hd_retur_sales_admin_id = dt_retur_sales_admin.hd_retur_sales_admin_id')

        ->join('ms_product_unit', 'ms_product_unit.item_id = dt_retur_sales_admin.dt_retur_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->join('ms_store', 'ms_store.store_id = hd_retur_sales_admin.hd_retur_store_id')

        //->join('ms_warehouse', 'ms_warehouse.store_id = ms_store.store_id')

        ->where('dt_retur_sales_admin.hd_retur_sales_admin_id', $hd_retur_sales_admin_id)

        ->get();

    }

    public function getWarehouse($hd_retur_store_id, $hd_retur_sales_admin_id)
    {

        $builder = $this->db->table($this->table_dt_retur_sales_admin);

        return $builder->select('*')

        ->join('hd_retur_sales_admin', 'hd_retur_sales_admin.hd_retur_sales_admin_id = dt_retur_sales_admin.hd_retur_sales_admin_id')

        ->join('ms_store', 'ms_store.store_id = hd_retur_sales_admin.hd_retur_store_id')

        ->join('ms_warehouse', 'ms_warehouse.store_id = ms_store.store_id')

        ->where('dt_retur_sales_admin.hd_retur_sales_admin_id', $hd_retur_sales_admin_id)

        ->get();

    }

    public function getOrder($hd_retur_purchase_id = '')
    {
        $builder = $this->db->table($this->table_hd_retur);

        $builder->select('*, hd_retur_purchase.created_at as created_at');

        $builder->join('user_account', 'user_account.user_id = hd_retur_purchase.created_by');

        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_retur_purchase.hd_retur_supplier_id');

        if ($hd_retur_purchase_id  != '') {

            $builder->where(['hd_retur_purchase.hd_retur_purchase_id ' => $hd_retur_purchase_id ]);

        }

        return $builder->get();
    }

    public function getOrderSalesAdmin($hd_retur_sales_admin_id = '')
    {
        $builder = $this->db->table($this->table_hd_retur_sales_admin);

        $builder->select('*, hd_retur_sales_admin.created_at as created_at');

        $builder->join('user_account', 'user_account.user_id = hd_retur_sales_admin.created_by');

        $builder->join('ms_customer', 'ms_customer.customer_id  = hd_retur_sales_admin.hd_retur_customer_id');

        $builder->join('ms_store', 'ms_store.store_id = hd_retur_sales_admin.hd_retur_store_id');

        if ($hd_retur_sales_admin_id != '') {

            $builder->where(['hd_retur_sales_admin.hd_retur_sales_admin_id ' => $hd_retur_sales_admin_id ]);

        }

        return $builder->get();
    }

    public function getSalesAdmin($sales_admin_id)
    {
        $builder = $this->db->table($this->table_sales_admin);

        $builder->select('*');

        $builder->where(['sales_admin_id' => $sales_admin_id]);

        return $builder->get();
    }

    public function copyReturToTemp($datacopy)
    {
        $user_id       = $datacopy['retur_user_id'];
        $supplier_name = $datacopy['supplier_name'];
        $hd_retur_purchase_id = $datacopy['hd_retur_purchase_id'];

        $this->clearTemp($user_id);

        $sqlText = "INSERT INTO temp_retur_purchase(retur_purchase_invoice,retur_supplier_id,retur_item_id,retur_price,retur_ppn,retur_dpp,retur_disc,retur_disc_nota,retur_ongkir,retur_warehouse,retur_qty_buy,retur_qty,retur_total,retur_supplier_name,retur_user_id  ) ";


        $sqlText .= "SELECT dt_retur_purchase_invoice,dt_retur_supplier_id,dt_retur_item_id, dt_retur_price,dt_retur_ppn,dt_retur_dpp,dt_retur_disc,dt_retur_disc_nota,dt_retur_ongkir,dt_retur_warehouse,dt_retur_qty_buy,dt_retur_qty,dt_retur_total,'".$supplier_name."' as retur_supplier_name, '".$user_id."' as retur_user_id";

        $sqlText .= " FROM dt_retur_purchase WHERE hd_retur_purchase_id = '$hd_retur_purchase_id'";


        $this->db->query($sqlText);

        return $this->getTemp($user_id);
    }

    public function copyReturSalesAdminToTemp($datacopy)
    {
        $user_id                   = $datacopy['retur_user_id'];
        $sales_admin_invoice       = $datacopy['sales_admin_invoice'];
        $hd_retur_sales_admin_id   = $datacopy['hd_retur_sales_admin_id'];

        $builder = $this->db->table($this->table_hd_retur);

        $this->clearTempSalesAdmin($user_id);

        $get_sales_admin = $this->db->table($this->table_hd_sales_admin)->select('*')->where('sales_admin_invoice', $sales_admin_invoice)->get()->getRowArray();

        $sqlText = "INSERT INTO temp_retur_sales_admin(retur_sales_admin_invoice,retur_item_id,retur_price,retur_ppn,retur_disc,retur_disc_nota,retur_qty,retur_qty_sell,retur_total,retur_user_id  ) ";

        $sqlText .= "SELECT '".$sales_admin_invoice."' as retur_sales_admin_invoice,dt_retur_item_id,dt_retur_price, dt_retur_ppn,dt_retur_disc,dt_retur_disc_nota,dt_retur_qty,dt_retur_qty_sell,dt_retur_total,'".$user_id."' as retur_user_id";

        $sqlText .= " FROM dt_retur_sales_admin WHERE hd_retur_sales_admin_id = '$hd_retur_sales_admin_id'";

        $this->db->query($sqlText);

        return $this->getTempReturSalesAdmin($user_id);
    }


    public function updateOrder($data)
    {

        $this->db->query('LOCK TABLES hd_retur_purchase WRITE, dt_retur_purchase WRITE, hd_purchase READ, temp_retur_purchase WRITE, ms_supplier READ, ms_warehouse READ, user_account READ');

        $hd_retur_purchase_id = $data['hd_retur_purchase_id'];

        $save = ['success' => FALSE, 'hd_retur_purchase_id' => 0];

        $getOrder = $this->getOrder($hd_retur_purchase_id)->getRowArray();

        if ($getOrder != NULL) {

            if ($getOrder['hd_retur_status'] == 'Pending') {

                $this->db->transBegin();

                $saveQueries = NULL;

                $user_id = $data['created_by'];

                unset($data['user_id']);

                $sqlDtOrder = "INSERT INTO dt_retur_purchase(hd_retur_purchase_id,dt_retur_purchase_invoice,dt_retur_supplier_id,dt_retur_item_id,dt_retur_price,dt_retur_ppn,dt_retur_dpp,dt_retur_disc,dt_retur_disc_nota,dt_retur_ongkir,dt_retur_warehouse,dt_retur_qty_buy,dt_retur_qty,dt_retur_total) VALUES ";

                $sqlDtValues = [];

                $deleteItemId = [];

                $getTemp =  $this->getTemp($data['created_by']);

                foreach ($getTemp->getResultArray() as $row) {

                    $hd_retur_purchase_id                  = $hd_retur_purchase_id ;
                    $dt_retur_purchase_invoice             = $row['retur_purchase_invoice'];
                    $dt_retur_supplier_id                  = $row['retur_supplier_id'];
                    $dt_retur_item_id                      = $row['retur_item_id'];
                    $dt_retur_price                        = floatval($row['retur_price']);
                    $dt_retur_ppn                          = floatval($row['retur_ppn']);

                    $dt_retur_dpp                          = floatval($row['retur_dpp']);
                    $dt_retur_disc                         = floatval($row['retur_disc']);
                    $dt_retur_disc_nota                    = floatval($row['retur_disc_nota']);
                    $dt_retur_ongkir                       = floatval($row['retur_ongkir']);

                    $dt_retur_warehouse                    = $row['retur_warehouse'];
                    $dt_retur_qty                          = floatval($row['retur_qty']);
                    $dt_retur_qty_buy                      = floatval($row['retur_qty_buy']);
                    $dt_retur_total                        = floatval($row['retur_total']);


                    $getPurchase = $this->db->table($this->table_hd_purchase)->select('*')->where('purchase_invoice', $dt_retur_purchase_invoice)->get()->getRowArray();

                    $product_id             = $row['product_id'];

                    $product_content        = floatval($row['product_content']);

                    $base_purchase_stock    = $dt_retur_qty * $product_content;

                    $purchase_id            = $getPurchase['purchase_id'];



                    $getWarehouseStock = $this->db->table($this->table_warehouse_stock)->select('*')->where('purchase_id', $purchase_id)->where('product_id', $product_id)->get()->getRowArray();

                    $sqlDtValues[] = "('$hd_retur_purchase_id','$dt_retur_purchase_invoice','$dt_retur_supplier_id','$dt_retur_item_id','$dt_retur_price','$dt_retur_ppn','$dt_retur_dpp','$dt_retur_disc','$dt_retur_disc_nota','$dt_retur_ongkir','$dt_retur_warehouse','$dt_retur_qty_buy','$dt_retur_qty','$dt_retur_total')";

                }

                $sqlDtOrder .= implode(',', $sqlDtValues);

                $this->db->table($this->table_hd_retur)->where('hd_retur_purchase_id', $hd_retur_purchase_id)->update($data);

                if ($this->db->affectedRows() > 0) {

                    $saveQueries[] = $this->db->getLastQuery()->getQuery();

                }

                $this->clearUpdateDetail($hd_retur_purchase_id);

                $this->db->query($sqlDtOrder);

                if ($this->db->affectedRows() > 0) {

                    $saveQueries[] = $this->db->getLastQuery()->getQuery();

                }


                if ($this->db->transStatus() === false) {

                    $saveQueries = NULL;

                    $this->db->transRollback();

                    $save = ['success' => FALSE, 'hd_retur_purchase_id' => 0];

                } else {

                    $this->db->transCommit();

                    $this->clearTemp($user_id);

                    $save = ['success' => TRUE, 'hd_retur_purchase_id' => $hd_retur_purchase_id];

                }

                $this->db->query('UNLOCK TABLES');

                saveQueries($saveQueries, 'retur_purchase', $hd_retur_purchase_id, 'updateReturPurchase');

            }

            return $save;
        }

    }


    public function updateOrderReturSalesAdmin($data)
    {

        $this->db->query('LOCK TABLES hd_retur_sales_admin WRITE, dt_retur_sales_admin WRITE, temp_retur_sales_admin WRITE, ms_customer READ, ms_store READ, user_account READ');

        $hd_retur_sales_admin_id = $data['hd_retur_sales_admin_id'];

        $save = ['success' => FALSE, 'hd_retur_sales_admin_id' => 0];

        $getOrder = $this->getOrderSalesAdmin($hd_retur_sales_admin_id)->getRowArray();

        if ($getOrder != NULL) {

            if ($getOrder['hd_retur_status'] == 'Pending') {

                $this->db->transBegin();

                $saveQueries = NULL;

                $user_id = $data['created_by'];

                $sqlDtOrder = "INSERT INTO dt_retur_sales_admin(hd_retur_sales_admin_id,dt_retur_item_id,dt_retur_price,dt_retur_ppn,dt_retur_dpp,dt_retur_disc,dt_retur_disc_nota,dt_retur_qty,dt_retur_qty_sell,dt_retur_total) VALUES ";

                $sqlDtValues = [];

                $deleteItemId = [];

                $getTemp =  $this->db->table($this->table_temp_retur_sales_admin)->where('retur_user_id', $user_id)->get();

                foreach ($getTemp->getResultArray() as $row) {

                    $hd_retur_sales_admin_id    = $hd_retur_sales_admin_id;

                    $dt_retur_item_id           = $row['retur_item_id'];

                    $dt_retur_price             = $row['retur_price'];

                    $dt_retur_ppn               = floatval($row['retur_ppn']);

                    $dt_retur_dpp               = floatval($row['retur_price'] - $row['retur_disc'] - $row['retur_disc_nota']);

                    $dt_retur_disc              = floatval($row['retur_disc']);

                    $dt_retur_disc_nota         = floatval($row['retur_disc_nota']);

                    $dt_retur_qty               = floatval($row['retur_qty']);

                    $dt_retur_qty_sell          = floatval($row['retur_qty_sell']);

                    $dt_retur_total             = floatval($row['retur_total']);

                    $sqlDtValues[] = "('$hd_retur_sales_admin_id','$dt_retur_item_id','$dt_retur_price','$dt_retur_ppn','$dt_retur_dpp','$dt_retur_disc','$dt_retur_disc_nota','$dt_retur_qty','$dt_retur_qty_sell','$dt_retur_total')";
                }

                $sqlDtOrder .= implode(',', $sqlDtValues);

                $this->db->table($this->table_hd_retur_sales_admin)->where('hd_retur_sales_admin_id', $hd_retur_sales_admin_id)->update($data);

                if ($this->db->affectedRows() > 0) {

                    $saveQueries[] = $this->db->getLastQuery()->getQuery();

                }

                $this->clearUpdateDetailSalesAdmin($hd_retur_sales_admin_id);

                $this->db->query($sqlDtOrder);

                if ($this->db->affectedRows() > 0) {

                    $saveQueries[] = $this->db->getLastQuery()->getQuery();

                }


                if ($this->db->transStatus() === false) {

                    $saveQueries = NULL;

                    $this->db->transRollback();

                    $save = ['success' => FALSE, 'hd_retur_sales_admin_id' => 0];

                } else {

                    $this->db->transCommit();

                    $this->clearTempSalesAdmin($user_id);

                    $save = ['success' => TRUE, 'hd_retur_sales_admin_id' => $hd_retur_sales_admin_id];

                }

                $this->db->query('UNLOCK TABLES');

                saveQueries($saveQueries, 'retur_sales_admin', $hd_retur_sales_admin_id, 'updateReturSalesAdmin');

            }

            return $save;
        }

    }

    public function clearUpdateDetail($hd_retur_purchase_id){

        return $this->db->table($this->table_dt_retur)

        ->where('hd_retur_purchase_id', $hd_retur_purchase_id)

        ->delete();
    }

    public function clearUpdateDetailSalesAdmin($hd_retur_sales_admin_id){

        return $this->db->table($this->table_dt_retur_sales_admin)

        ->where('hd_retur_sales_admin_id', $hd_retur_sales_admin_id)

        ->delete();
    }

    public function getReportHeaderData($start_date, $end_date, $supplier_id)
    {
        $builder = $this->db->table('hd_retur_purchase')->select("*");
        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_retur_purchase.hd_retur_supplier_id');
        $builder->where("(hd_retur_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        if ($supplier_id != null) {
            $builder->where('hd_retur_supplier_id', $supplier_id);
        }
        return $builder->orderBy('hd_retur_purchase.created_at', 'ASC')->get();
    }

    public function getSalesAdminByid($sales_admin_id)
    {
        $builder = $this->db->table('hd_sales_admin')->select("sales_customer_id, customer_name, sales_store_id, store_name, store_code, sales_admin_id");
        $builder->join('ms_customer', 'ms_customer.customer_id  = hd_sales_admin.sales_customer_id');
        $builder->join('ms_store', 'ms_store.store_id  = hd_sales_admin.sales_store_id');
        $builder->where('sales_admin_id', $sales_admin_id);
        return $builder->get();
    }

    public function getReportData($start_date, $end_date, $supplier_id)
    {
        $builder = $this->db->table('hd_retur_purchase')->select("hd_retur_total_dpp, hd_retur_total_ppn, hd_retur_total_transaction, hd_retur_purchase_invoice, hd_retur_date, supplier_code, supplier_name, hd_retur_purchase_invoice, dt_retur_purchase_invoice, hd_retur_date, item_code, product_name, brand_name, category_name, dt_retur_qty, unit_name, dt_retur_price, dt_retur_dpp, dt_retur_ppn, dt_retur_total, warehouse_name, dt_retur_disc, dt_retur_disc_nota, dt_retur_ongkir");
        $builder->join('dt_retur_purchase', 'dt_retur_purchase.hd_retur_purchase_id = hd_retur_purchase.hd_retur_purchase_id');
        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = dt_retur_purchase.dt_retur_warehouse');
        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_retur_purchase.hd_retur_supplier_id');
        $builder->join('ms_product_unit', 'ms_product_unit.item_id = dt_retur_purchase.dt_retur_item_id');
        $builder->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id');
        $builder->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id');
        $builder->join('ms_category', 'ms_category.category_id = ms_product.category_id');
        $builder->join('ms_brand', 'ms_brand.brand_id = ms_product.brand_id');  
        $builder->where("(hd_retur_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        if ($supplier_id != null) {
            $builder->where('hd_retur_supplier_id', $supplier_id);
        }
        return $builder->orderBy('hd_retur_purchase.created_at', 'ASC')->get();
    }


}
