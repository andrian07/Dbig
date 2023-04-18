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



        $sqlDtSalesAdmin = "insert into dt_sales_admin(sales_admin_id,dt_item_id,dt_temp_qty,dt_purchase_price,dt_purchase_tax,dt_purchase_cogs,dt_product_price,dt_disc1,dt_price_disc1_percentage,dt_disc2,dt_price_disc2_percentage,dt_disc3,dt_price_disc3_percentage,dt_total_discount,dt_total_dpp,dt_total_ppn,dt_sales_price,user_id) VALUES";

        $sqlUpdateStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

        //$sqlUpdateWarehouse = "insert into ms_warehouse_stock (stock_id,product_id , warehouse_id , purchase_id , exp_date, stock) VALUES";

        $sqlDtValues = [];
        $vUpdateStock = [];
        $vUpdateWarehouse = [];

        $getTotalItem = $this->db->table($this->table_temp_sales_admin)->select('sum(temp_qty * product_content) as qty')->join('ms_product_unit', 'ms_product_unit.item_id = temp_sales_admin.item_id')->where('user_id', $data['user_id'])->get()->getRowArray();


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

            $total_qty_all              = floatval($getTotalItem['qty']);
            $discount_per_nota          = round(($data['sales_admin_total_discount'] / $total_qty_all), 2);
            $discount_nota_per_item     = round($dt_sales_price - ($discount_per_nota * $base_purchase_stock), 2);

            $ppn_per_item               = round((($dt_sales_price - $discount_nota_per_item) * 0.11), 2);

            $dt_total_discount          = $dt_disc1 + $dt_disc2 + $dt_disc3;
            $dt_total_ppn               = $ppn_per_item * $base_purchase_stock;
            $dt_total_dpp               = $dt_sales_price - $dt_total_ppn;

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
            $sqlDtValues[] = "('$sales_admin_id','$dt_item_id','$dt_temp_qty','$dt_purchase_price','$dt_purchase_tax','$dt_purchase_cogs','$dt_product_price','$dt_disc1','$dt_price_disc1_percentage','$dt_disc2','$dt_price_disc2_percentage','$dt_disc3','$dt_price_disc3_percentage','$dt_total_discount','$dt_total_dpp','$dt_total_ppn','$dt_sales_price','$user_id')";

            $vUpdateStock[] = "('$product_id', '$warehouse_id', '$base_purchase_stock')";

            

            if($getLastEd != null){
                $a = 0;
                for($a = $base_purchase_stock; $a > 0; $a++){

                    $getLastEdStock = $this->db->table($this->table_ms_warehouse_stock)->select('*')->where('product_id', $product_id)->where('stock > 0')->orderBy('exp_date', 'asc')->limit(1)->get()->getRowArray();


                    if($getLastEdStock != null){
                        $stock_id_eds     = $getLastEdStock['stock_id'];
                        $stock_eds        = $getLastEdStock['stock'];


                        $total_input = $stock_eds - $a;

                        if($total_input < 0){
                            $total_input = 0;
                        }

                        $sqlUpdateWarehouse = "update ms_warehouse_stock set stock = '".$total_input."' where stock_id = '".$stock_id_eds."'";
                        $this->db->query($sqlUpdateWarehouse);
                        $a = $base_purchase_stock - $stock_eds;
                    }else{
                        $a = -1;
                    }

                }
            }
        }//

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

        saveQueries($saveQueries, 'sales_admin', $sales_admin_id, 'insert');

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


        $this->db->query('LOCK TABLES hd_sales_admin WRITE, dt_sales_admin WRITE, temp_sales_admin WRITE,ms_customer READ, ms_store READ, ms_product_unit READ, ms_product READ, ms_unit READ, ms_salesman READ, ms_payment_method READ, user_account READ, ms_warehouse READ, ms_warehouse_stock READ, ms_product_stock WRITE');

        $sales_admin_id = $data['sales_admin_id'];

        $save = ['success' => FALSE, 'sales_admin_id' => 0];

        $getOrder = $this->getOrder($sales_admin_id)->getRowArray();

        $saveQueries = NULL;

        if ($getOrder != NULL) {

            $user_id                          = $data['user_id'];
            $sales_admin_id                   = $data['sales_admin_id'];

            $update = $this->db->table($this->table_hd_sales_admin)->update($data, ['sales_admin_id' => $sales_admin_id]);

            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }


            $sqlDtSalesAdmin = "insert into dt_sales_admin(sales_admin_id,dt_item_id,dt_temp_qty,dt_purchase_price,dt_purchase_tax,dt_purchase_cogs,dt_product_price,dt_disc1,dt_price_disc1_percentage,dt_disc2,dt_price_disc2_percentage,dt_disc3,dt_price_disc3_percentage,dt_total_discount,dt_total_dpp,dt_total_ppn,dt_sales_price,user_id) VALUES";

            $sqlUpdateStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

            $sqlDtValues = [];
            $vUpdateStock = [];

            $getTotalItem = $this->db->table($this->table_temp_sales_admin)->select('sum(temp_qty * product_content) as qty')->join('ms_product_unit', 'ms_product_unit.item_id = temp_sales_admin.item_id')->where('user_id', $data['user_id'])->get()->getRowArray();

            $getTemp =  $this->getTemp($data['user_id']);

            foreach($getTemp->getResultArray() as $row) {

                $getLastTransaction = $this->db->table($this->table_dt_sales_admin)->select('dt_temp_qty')->where('sales_admin_id', $sales_admin_id)->where('dt_item_id', $row['item_id'])->get()->getRowArray();

                $last_qty                   = $getLastTransaction['dt_temp_qty'];
                $new_qty                    = $row['temp_qty'] - $last_qty;
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

                $total_qty_all              = floatval($getTotalItem['qty']);
                $discount_per_nota          = round(($data['sales_admin_total_discount'] / $total_qty_all), 2);
                $discount_nota_per_item     = round($dt_sales_price - ($discount_per_nota * $base_purchase_stock), 2);

                $ppn_per_item               = round((($dt_sales_price - $discount_nota_per_item) * 0.11), 2);

                $dt_total_discount          = $dt_disc1 + $dt_disc2 + $dt_disc3;
                $dt_total_ppn               = $ppn_per_item * $base_purchase_stock;
                $dt_total_dpp               = $dt_sales_price - $dt_total_ppn;

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
                $sqlDtValues[] = "('$sales_admin_id','$dt_item_id','$dt_temp_qty','$dt_purchase_price','$dt_purchase_tax','$dt_purchase_cogs','$dt_product_price','$dt_disc1','$dt_price_disc1_percentage','$dt_disc2','$dt_price_disc2_percentage','$dt_disc3','$dt_price_disc3_percentage','$dt_total_discount','$dt_total_dpp','$dt_total_ppn','$dt_sales_price','$user_id')";

                $vUpdateStock[] = "('$product_id', '$warehouse_id', '$base_purchase_stock')";

                $sqlDtSalesAdmin .= implode(',', $sqlDtValues);

                if($last_qty < $dt_temp_qty){
                    $sqlUpdateStock .= implode(',', $vUpdateStock). " ON DUPLICATE KEY UPDATE stock=stock-VALUES(stock)";
                }else{
                    $sqlUpdateStock .= implode(',', $vUpdateStock). " ON DUPLICATE KEY UPDATE stock=stock+VALUES(stock)";
                }

                if($getLastEd != null){

                    $getLastEdStock = $this->db->table($this->table_ms_warehouse_stock)->select('*')->where('product_id', $product_id)->orderBy('exp_date', 'asc')->limit(1)->get()->getRowArray();
                    $sqlUpdateWarehouse = "update ms_warehouse_stock set stock = '".$total_input."' where stock_id = '".$stock_id_eds."'";
                    $this->db->query($sqlUpdateWarehouse);
                }

            }

            $delete_dt = $this->db->table($this->table_dt_sales_admin)->delete(['sales_admin_id' => $sales_admin_id ]);

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

            $save = ['success' => TRUE, 'sales_admin_id' => $sales_admin_id ];

            saveQueries($saveQueries, 'sales_admin', $sales_admin_id, 'edit');

            return $save;
        }

    }

    public function getReportDataDetail($start_date, $end_date, $store_id, $customer_id, $salesman_id, $status)
    {
        $builder = $this->db->table('hd_sales_admin')->select("sales_admin_invoice, sales_date, sales_due_date, item_code, product_name, salesman_name, dt_temp_qty, dt_product_price, dt_sales_price");
        $builder->join('dt_sales_admin', 'dt_sales_admin.sales_admin_id = hd_sales_admin.sales_admin_id');
        $builder->join('ms_customer', 'ms_customer.customer_id  = hd_sales_admin.sales_customer_id');
        $builder->join('ms_store', 'ms_store.store_id = hd_sales_admin.sales_store_id');
        $builder->join('ms_salesman', 'ms_salesman.salesman_id = hd_sales_admin.sales_salesman_id');
        $builder->join('ms_product_unit', 'ms_product_unit.item_id = dt_sales_admin.dt_item_id');
        $builder->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id');
        $builder->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id');
        $builder->where("(sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        if ($store_id != null) {
            $builder->where('sales_store_id', $store_id);
        }
        if ($customer_id != null) {
            $builder->where('sales_customer_id', $customer_id);
        }
        if ($salesman_id != null) {
            $builder->where('sales_salesman_id', $salesman_id);
        }
        if ($status == 2) {
            $builder->where('sales_due_date > CURDATE()');
        }
        return $builder->orderBy('hd_sales_admin.created_at', 'ASC')->get();
    }

    public function getReportDataHeader($start_date, $end_date, $store_id, $customer_id, $salesman_id, $status)
    {
        $builder = $this->db->table('hd_sales_admin')->select("sales_admin_invoice, sales_date, sales_due_date, salesman_name, customer_name, sales_admin_total_discount, sales_admin_ppn, sales_admin_down_payment, sales_admin_grand_total");
        $builder->join('ms_customer', 'ms_customer.customer_id  = hd_sales_admin.sales_customer_id');
        $builder->join('ms_store', 'ms_store.store_id = hd_sales_admin.sales_store_id');
        $builder->join('ms_salesman', 'ms_salesman.salesman_id = hd_sales_admin.sales_salesman_id');
        $builder->where("(sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        if ($store_id != null) {
            $builder->where('sales_store_id', $store_id);
        }
        if ($customer_id != null) {
            $builder->where('sales_customer_id', $customer_id);
        }
        if ($salesman_id != null) {
            $builder->where('sales_salesman_id', $salesman_id);
        }
        if ($status == 2) {
            $builder->where('sales_due_date > CURDATE()');
        }
        return $builder->orderBy('hd_sales_admin.created_at', 'ASC')->get();
    }


}
