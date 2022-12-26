<?php

namespace App\Models;

use CodeIgniter\Model;

class M_salesmanadmin extends Model
{
    protected $table_temp_sales_admin = 'temp_sales_admin';
    protected $table_hd_sales_admin = 'hd_sales_admin';
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

   public function deletetemp($temp_sales_admin_id ){
    $this->db->query('LOCK TABLES temp_sales_admin WRITE');
    $save = $this->db->table($this->table_temp_sales_admin)->delete(['temp_sales_admin_id' => $temp_sales_admin_id ]);
    $saveQueries = NULL;
    if ($this->db->affectedRows() > 0) {
        $saveQueries = $this->db->getLastQuery()->getQuery();
    }
    $this->db->query('UNLOCK TABLES');
        //saveQueries($saveQueries, 'deletetemp', $temp_submission_id, 'Hapus Temp');
    return $save;
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

        $saveQueries[] = [

            'query_text'    => $this->db->getLastQuery()->getQuery(),

            'ref_id'        => $sales_admin_id 

        ];

    }



    $sqlDtSalesAdmin = "insert into dt_sales_admin(sales_admin_id,dt_item_id,dt_temp_qty,dt_purchase_price,dt_purchase_tax,dt_purchase_cogs,dt_product_price,dt_disc1,dt_price_disc1_percentage,dt_disc2,dt_price_disc2_percentage,dt_disc3,dt_price_disc3_percentage,dt_sales_price,user_id) VALUES";

    $sqlUpdateStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

    $sqlUpdateWarehouse = "insert into ms_warehouse_stock (stock_id,product_id , warehouse_id , purchase_id , exp_date, stock) VALUES";

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

        $getLastEd = $this->db->table($this->table_ms_warehouse_stock)->select('*')->where('product_id', $product_id)->orderBy('exp_date', 'asc')->limit(1)->get()->getRowArray();

        $stock_id_ed     = $getLastEd['stock_id'];
        $product_id_ed   = $getLastEd['product_id'];
        $warehouse_id_ed = $getLastEd['warehouse_id'];
        $purchase_id_ed  = $getLastEd['purchase_id'];
        $exp_date_ed     = $getLastEd['exp_date'];
        $stock_ed        = $getLastEd['stock'];

        $sqlDtValues[] = "('$sales_admin_id','$dt_item_id','$dt_temp_qty','$dt_purchase_price','$dt_purchase_tax','$dt_purchase_cogs','$dt_product_price','$dt_disc1','$dt_price_disc1_percentage','$dt_disc2','$dt_price_disc2_percentage','$dt_disc3','$dt_price_disc3_percentage','$dt_sales_price','$user_id')";

        $vUpdateStock[] = "('$product_id', '$warehouse_id', '$base_purchase_stock')";

        $vUpdateWarehouse[] = "('$stock_id_ed', '$product_id_ed', '$warehouse_id_ed', '$purchase_id_ed', '$exp_date_ed', '$stock_ed')";
    }

    $sqlDtSalesAdmin .= implode(',', $sqlDtValues);

    $sqlUpdateStock .= implode(',', $vUpdateStock). " ON DUPLICATE KEY UPDATE stock=stock-VALUES(stock)";

    $sqlUpdateWarehouse .= implode(',', $vUpdateWarehouse). " ON DUPLICATE KEY UPDATE stock_id=VALUES(stock_id),stock=stock-VALUES(stock)";


    $this->db->query($sqlDtSalesAdmin);
    if ($this->db->affectedRows() > 0) {

        $saveQueries[] = [

            'query_text'    => $this->db->getLastQuery()->getQuery(),

            'ref_id'        => $sales_admin_id

        ];

    }


    $this->db->query($sqlUpdateStock);

    if ($this->db->affectedRows() > 0) {

        $saveQueries[] = [

            'query_text'    => $this->db->getLastQuery()->getQuery(),

            'ref_id'        => $sales_admin_id

        ];

    }

    $this->db->query($sqlUpdateWarehouse);

    if ($this->db->affectedRows() > 0) {

        $saveQueries[] = [

            'query_text'    => $this->db->getLastQuery()->getQuery(),

            'ref_id'        => $sales_admin_id

        ];

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

    foreach($saveQueries as $rowQuery){

        saveQueries($rowQuery['query_text'], 'salesadmin', $sales_admin_id);

    }

    return $save;

}


}
