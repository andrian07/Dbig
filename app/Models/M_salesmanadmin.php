<?php

namespace App\Models;

use CodeIgniter\Model;

class M_salesmanadmin extends Model
{
    protected $table_temp_sales_admin = 'temp_sales_admin';
    protected $table_hd_sales_admin = 'hd_sales_admin';
    protected $table_dt_sales_admin = 'dt_sales_admin';
    protected $table_ms_store = 'ms_store';
    protected $table_ms_warehouse = 'ms_warehouse';
    protected $table_ms_warehouse_stock = 'ms_warehouse_stock';

    public function insertTemp($data)
    {

        $exist = $this->db->table($this->table_temp_sales_admin)

        ->where('item_id', $data['item_id'])

        ->where('user_id', $data['user_id'])

        ->countAllResults();

        if ($exist > 0) {

            return $this->db->table($this->table_temp_sales_admin)

            ->where('item_id', $data['item_id'])

            ->where('user_id', $data['user_id'])

            ->update($data);

        } else {

            return $this->db->table($this->table_temp_sales_admin)->insert($data);

        }

    }


    public function getTemp($user_id)
    {
        $builder = $this->db->table($this->table_temp_sales_admin);

        return $builder->select('*, (temp_disc1+temp_disc2+temp_disc3) as temp_total_discount')

        ->join('ms_product_unit', 'ms_product_unit.item_id = temp_sales_admin.item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->where('temp_sales_admin.user_id', $user_id)

        ->orderBy('temp_sales_admin.updated_at', 'ASC')

        ->get();
    }




    public function getSalesadminFooter($user_id)
    {
        $builder = $this->db->table($this->table_temp_sales_admin);

        return $builder->select('sum(temp_sales_price) as total_footer_price')

        ->where('temp_sales_admin.user_id', $user_id)

        ->get();
    }

    public function deletetemp($temp_sales_admin_id )
    {
        $this->db->query('LOCK TABLES temp_sales_admin WRITE');

        $save = $this->db->table($this->table_temp_sales_admin)->delete(['temp_sales_admin_id' => $temp_sales_admin_id ]);

        $saveQueries = NULL;

        if ($this->db->affectedRows() > 0) {

            $saveQueries = $this->db->getLastQuery()->getQuery();

        }

        $this->db->query('UNLOCK TABLES');

        return $save;
    }

    public function getOrder($sales_admin_id = '')
    {

        $builder = $this->db->table($this->table_hd_sales_admin);

        $builder->select('hd_sales_admin.*,dt_sales_admin.*, ms_payment_method.*, customer_name,customer_address,customer_phone,store_code,store_name,user_account.user_realname, ms_salesman.salesman_name, ms_salesman.salesman_code, hd_sales_admin.created_at as created_at');

        $builder->join('dt_sales_admin', 'dt_sales_admin.sales_admin_id = hd_sales_admin.sales_admin_id');

        $builder->join('user_account', 'user_account.user_id = hd_sales_admin.user_id');

        $builder->join('ms_customer', 'ms_customer.customer_id  = hd_sales_admin.sales_customer_id');

        $builder->join('ms_salesman', 'ms_salesman.salesman_id  = hd_sales_admin.sales_salesman_id');

        $builder->join('ms_store', 'ms_store.store_id  = hd_sales_admin.sales_store_id');

        $builder->join('ms_payment_method', 'ms_payment_method.payment_method_id  = hd_sales_admin.sales_payment_type');

        if ($sales_admin_id  != '') {

            $builder->where(['hd_sales_admin.sales_admin_id' => $sales_admin_id ]);

        }

        return $builder->get();
    }

    public function getDtSalesmanOrder($sales_admin_id)
    {
        $builder = $this->db->table($this->table_dt_sales_admin);

        return $builder->select('*')

        ->join('ms_product_unit', 'ms_product_unit.item_id = dt_sales_admin.dt_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->where('sales_admin_id', $sales_admin_id)

        ->get();
    }



    public function clearTemp($user_id)
    {
        return $this->db->table($this->table_temp_sales_admin)

        ->where('user_id', $user_id)

        ->delete();
    }

    public function insertsalesadmin($data)
    {

        $this->db->query('LOCK TABLES hd_sales_admin WRITE');

        $this->db->transBegin();

        $saveQueries = NULL;

        $maxCode = $this->db->table($this->table_hd_sales_admin)->select('sales_admin_id, sales_admin_invoice')->orderBy('sales_admin_id', 'desc')->limit(1)->get()->getRowArray();

        $store_code = $this->db->table($this->table_ms_store)->select('store_code')->where('store_id', $data['sales_store_id'])->get()->getRowArray();

        $invoice_date =  date_format(date_create($data['sales_date']),"y/m/d");

        if ($maxCode == NULL) {

            $data['sales_admin_invoice'] = 'J/'.$store_code['store_code'].'/'.$invoice_date.'/'.'0000000001';

        } else {

            $invoice = substr($maxCode['sales_admin_invoice'], -10);

            $data['sales_admin_invoice '] = 'J/'.$store_code['store_code'].'/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);

        }

        $this->db->table($this->table_hd_sales_admin)->insert($data);

        $sales_admin_id  = $this->db->insertID();


        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }



        $sqlDtSalesAdmin = "insert into dt_sales_admin(sales_admin_id,dt_item_id,dt_temp_qty,dt_purchase_price,dt_purchase_tax,dt_purchase_cogs,dt_product_price,dt_disc1,dt_price_disc1_percentage,dt_disc2,dt_price_disc2_percentage,dt_disc3,dt_price_disc3_percentage,dt_sales_price,user_id) VALUES";

        $sqlUpdateStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

        //$sqlUpdateWarehouse = "insert into ms_warehouse_stock (stock_id,product_id , warehouse_id , purchase_id , exp_date, stock) VALUES";

        $sqlDtValues = [];
        $vUpdateStock = [];
        $vUpdateWarehouse = [];



        $getTemp =  $this->getTemp($data['user_id']);

        foreach ($getTemp->getResultArray() as $row) {

            $dt_item_id                 = $row['item_id'];
            $dt_temp_qty                = $row['temp_qty'];
            $dt_purchase_price          = $row['temp_purchase_price'];
            $dt_purchase_tax            = $row['temp_purchase_tax'];
            $dt_purchase_cogs           = $row['temp_purchase_cogs'];
            $dt_product_price           = $row['temp_product_price'];
            $dt_disc1                   = $row['temp_disc1'];
            $dt_price_disc1_percentage  = $row['temp_price_disc1_percentage'];
            $dt_disc2                   = $row['temp_disc2'];
            $dt_price_disc2_percentage  = $row['temp_price_disc2_percentage'];
            $dt_disc3                   = $row['temp_disc3'];
            $dt_price_disc3_percentage  = $row['temp_price_disc3_percentage'];
            $dt_sales_price             = $row['temp_sales_price'];
            $user_id                    = $row['user_id'];

            $product_id                 = $row['product_id'];
            $base_purchase_stock        = $dt_temp_qty * $row['product_content'];


            $getWarehouse = $this->db->table($this->table_ms_warehouse)->select('warehouse_id')->where('store_id', $data['sales_store_id'])->get()->getRowArray();

            $warehouse_id =  $getWarehouse['warehouse_id'];


            $getLastEd = $this->db->table($this->table_ms_warehouse_stock)->select('*')->where('product_id', $product_id)->where('stock > 0')->orderBy('exp_date', 'asc')->limit(1)->get()->getRowArray();

            if($getLastEd != null){
                $stock_id_ed     = $getLastEd['stock_id'];
                $product_id_ed   = $getLastEd['product_id'];
                $warehouse_id_ed = $getLastEd['warehouse_id'];
                $purchase_id_ed  = $getLastEd['purchase_id'];
                $exp_date_ed     = $getLastEd['exp_date'];
                $stock_ed        = $getLastEd['stock'];
            }
            $sqlDtValues[] = "('$sales_admin_id','$dt_item_id','$dt_temp_qty','$dt_purchase_price','$dt_purchase_tax','$dt_purchase_cogs','$dt_product_price','$dt_disc1','$dt_price_disc1_percentage','$dt_disc2','$dt_price_disc2_percentage','$dt_disc3','$dt_price_disc3_percentage','$dt_sales_price','$user_id')";

            $vUpdateStock[] = "('$product_id', '$warehouse_id', '$base_purchase_stock')";

            if($getLastEd != null){
                for($a = $dt_temp_qty; $a > 0; $a++){

                    $getLastEdStock = $this->db->table($this->table_ms_warehouse_stock)->select('*')->where('product_id', $product_id)->where('stock > 0')->orderBy('exp_date', 'asc')->limit(1)->get()->getRowArray();

                    if($getLastEdStock != null){
                        $stock_id_eds     = $getLastEdStock['stock_id'];
                        $stock_eds        = $getLastEdStock['stock'];
                    }


                    $total_input = $stock_eds - $dt_temp_qty;

                    if($total_input < 0){
                        $total_input = 0;
                    }

                    $sqlUpdateWarehouse = "update ms_warehouse_stock set stock = '".$total_input."' where stock_id = '".$stock_id_eds."'";
                    $this->db->query($sqlUpdateWarehouse);
                    $a = $dt_temp_qty - $stock_eds;
                }
            }
        }

        $sqlDtSalesAdmin .= implode(',', $sqlDtValues);

        $sqlUpdateStock .= implode(',', $vUpdateStock). " ON DUPLICATE KEY UPDATE stock=stock-VALUES(stock)";

        if($getLastEd != null){
            $sqlUpdateWarehouse .= implode(',', $vUpdateWarehouse). " ON DUPLICATE KEY UPDATE stock_id=VALUES(stock_id),stock=stock-VALUES(stock)";
        }


        $this->db->query($sqlDtSalesAdmin);
        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }


        $this->db->query($sqlUpdateStock);

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }




        if ($this->db->transStatus() === false) {

            $saveQueries[] = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'sales_admin_id' => 0];

        } else {

            $this->db->transCommit();

            $this->clearTemp($data['user_id']);

            $save = ['success' => TRUE, 'sales_admin_id' => $sales_admin_id ];

        }


        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'sales_admin', $sales_admin_id, 'insertsalesadmin');

        return $save;

    }


    public function copyDtSalesToTemp($datacopy)
    {
        $user_id = $datacopy['user_id'];
        $sales_admin_id = $datacopy['sales_admin_id'];

        $this->clearTemp($user_id);

        $sqlText = "INSERT INTO temp_sales_admin(item_id,temp_qty,temp_purchase_price,temp_purchase_tax,temp_purchase_cogs,temp_product_price,temp_disc1,temp_price_disc1_percentage,temp_disc2,temp_price_disc2_percentage,temp_disc3,temp_price_disc3_percentage,temp_sales_price,user_id) ";

        $sqlText .= "SELECT dt_item_id,dt_temp_qty,dt_purchase_price,dt_purchase_tax,dt_purchase_cogs,dt_product_price,dt_disc1,dt_price_disc1_percentage,dt_disc2,dt_price_disc2_percentage,dt_disc3,dt_price_disc3_percentage,dt_sales_price,'".$user_id."' as user_id";

        $sqlText .= " FROM dt_sales_admin WHERE sales_admin_id = '$sales_admin_id'";

        $this->db->query($sqlText);

        return $this->getTemp($user_id);
    }

    public function updatesalesmanadmin($data)
    {

        $this->db->query('LOCK TABLES hd_sales_admin WRITE, dt_sales_admin WRITE, temp_sales_admin WRITE,ms_customer READ, ms_store READ, ms_salesman READ, ms_payment_method READ, user_account READ');

        $sales_admin_id = $data['sales_admin_id'];

        $save = ['success' => FALSE, 'sales_admin_id' => 0];

        $getOrder = $this->getOrder($sales_admin_id)->getRowArray();

        if ($getOrder != NULL) {

            $this->db->transBegin();

            $saveQueries = NULL;

            $user_id = $data['user_id'];

            $sqlDtOrder = "insert into dt_sales_admin(sales_admin_id,dt_item_id,dt_temp_qty,dt_purchase_price,dt_purchase_tax,dt_purchase_cogs,dt_product_price,dt_disc1,dt_price_disc1_percentage,dt_disc2,dt_price_disc2_percentage,dt_disc3,dt_price_disc3_percentage,dt_sales_price,user_id) VALUES ";

            $sqlUpdateStock = "insert into ms_product_stock (product_id, warehouse_id,stock) VALUES";

            $sqlUpdateWarehouse = "insert into ms_warehouse_stock (stock_id,product_id,warehouse_id,purchase_id,exp_date,stock) VALUES";

            $sqlDtOrder = [];
            $vUpdateStock = [];
            $vUpdateWarehouse = [];

            $getTemp =  $this->getTemp($data['user_id']);

            foreach ($getTemp->getResultArray() as $row) {

                $sales_admin_id            = $sales_admin_id;

                $dt_item_id                = $row['item_id'];

                $dt_temp_qty               = $row['temp_qty'];

                $dt_purchase_price         = $row['temp_purchase_price'];

                $dt_purchase_tax           = $row['temp_purchase_tax'];

                $dt_purchase_cogs          = $row['temp_purchase_cogs'];

                $dt_product_price          = $row['temp_product_price'];

                $dt_disc1                  = $row['temp_disc1'];

                $dt_price_disc1_percentage = $row['temp_price_disc1_percentage'];

                $dt_disc2                  = $row['temp_disc2'];

                $dt_price_disc2_percentage = $row['temp_price_disc2_percentage'];

                $dt_disc3                  = $row['temp_disc3'];

                $dt_price_disc3_percentage = $row['temp_price_disc3_percentage'];

                $dt_sales_price            = $row['temp_sales_price'];

                $user_id                   = $row['user_id'];

                $getDtSales =  $this->db->table($this->table_dt_sales_admin)->where('sales_admin_id', $sales_admin_id)->where('dt_item_id', $row['item_id'])->get()->getRowArray();



                $base_sales_stock        = $dt_temp_qty * $row['product_content'];

                $edit_stock              = $getDtSales['dt_temp_qty'] - $base_sales_stock;

                print_r($edit_stock);die();

                $sqlDtValues[] = "('$sales_admin_id','$dt_item_id','$dt_temp_qty','$dt_purchase_price','$dt_purchase_tax','$dt_purchase_cogs','$dt_product_price','$dt_disc1','$dt_price_disc1_percentage','$dt_disc2','$dt_price_disc2_percentage','$dt_disc3','$dt_price_disc3_percentage','$dt_sales_price','$user_id')";

                $getWarehouse = $this->db->table($this->table_ms_warehouse)->select('warehouse_id')->where('store_id', $data['sales_store_id'])->get()->getRowArray();

                $warehouse_id =  $getWarehouse['warehouse_id'];

                $getLastEd = $this->db->table($this->table_ms_warehouse_stock)->select('*')->where('product_id', $product_id)->orderBy('exp_date', 'asc')->limit(1)->get()->getRowArray();

                if($getLastEd != null){
                    $stock_id_ed     = $getLastEd['stock_id'];
                    $product_id_ed   = $getLastEd['product_id'];
                    $warehouse_id_ed = $getLastEd['warehouse_id'];
                    $purchase_id_ed  = $getLastEd['purchase_id'];
                    $exp_date_ed     = $getLastEd['exp_date'];
                    $stock_ed        = $getLastEd['stock'];
                }
                $sqlDtValues[] = "('$sales_admin_id','$dt_item_id','$dt_temp_qty','$dt_purchase_price','$dt_purchase_tax','$dt_purchase_cogs','$dt_product_price','$dt_disc1','$dt_price_disc1_percentage','$dt_disc2','$dt_price_disc2_percentage','$dt_disc3','$dt_price_disc3_percentage','$dt_sales_price','$user_id')";

                $vUpdateStock[] = "('$product_id', '$warehouse_id', '$base_purchase_stock')";

                if($getLastEd != null){
                    $vUpdateWarehouse[] = "('$stock_id_ed', '$product_id_ed', '$warehouse_id_ed', '$purchase_id_ed', '$exp_date_ed', '$stock_ed')";
                }
            }

            $sqlDtOrder .= implode(',', $sqlDtValues);


            //$sqlDtOrder .= " ON DUPLICATE KEY UPDATE detail_purchase_order_id = VALUES(detail_purchase_order_id)";

            //print_r($sqlDtOrder);die();


            $this->db->table($this->table_hd_po)->where('purchase_order_id', $purchase_order_id)->update($data);

            $query_text_header = $this->db->getLastQuery()->getQuery();

            $this->clearUpdateDetail($purchase_order_id);

            $this->db->query($sqlDtOrder);

            $logUpdate = [

                'log_transaction_code'  => 'Edit PO',

                'log_transaction_id' => $purchase_order_id,

                'log_user_id' => $user_id,

                'log_remark' => 'EditPO',

                'log_detail' => $sqlDtOrder,

                'log_header' => $query_text_header

            ];

            $this->db->table($this->logUpdate)->insert($logUpdate);


            if ($this->db->transStatus() === false) {

                $saveQueries = NULL;

                $this->db->transRollback();

                $save = ['success' => FALSE, 'purchase_order_id' => 0];

            } else {

                $this->db->transCommit();

                $this->clearTemp($user_id);

                $save = ['success' => TRUE, 'purchase_order_id' => $purchase_order_id];

            }

            $this->db->query('UNLOCK TABLES');

            $data_save = saveQueries("PO", "EditPO", $purchase_order_id);


            return $save;
        }
    }



}
