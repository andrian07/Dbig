<?php

namespace App\Models;

use CodeIgniter\Model;

class M_purchase extends Model
{
    protected $table_temp_purchase      = 'temp_purchase';
    protected $table_hd_purchase        = 'hd_purchase';
    protected $table_warehouse          = 'ms_warehouse';
    protected $table_hd_po              = 'hd_purchase_order';
    protected $table_dt_po              = 'dt_purchase_order';
    protected $table_dt_purchase        = 'dt_purchase';
    protected $table_ms_product_stock   = 'ms_product_stock';
    protected $table_ms_product         = 'ms_product';


    public function insertTemp($data)
    {

        $exist = $this->db->table($this->table_temp_purchase)

        ->where('temp_purchase_item_id', $data['temp_purchase_item_id'])

        ->where('temp_purchase_expire_date', $data['temp_purchase_expire_date'])

        ->where('temp_purchase_user_id', $data['temp_purchase_user_id'])

        ->countAllResults();


        if ($exist > 0) {

            return $this->db->table($this->table_temp_purchase)

            ->where('temp_purchase_item_id', $data['temp_purchase_item_id'])

            ->where('temp_purchase_expire_date', $data['temp_purchase_expire_date'])

            ->where('temp_purchase_user_id', $data['temp_purchase_user_id'])

            ->update($data);

        } else {

            $this->db->table($this->table_temp_purchase)->where('temp_purchase_user_id', $data['temp_purchase_user_id'])->where('temp_purchase_item_id', $data['temp_purchase_item_id'])->delete();

            return $this->db->table($this->table_temp_purchase)->insert($data);

        }

    }


    public function copyDtOrderToTemp($datacopy)
    {
        $user_id = $datacopy['user_id'];
        $supplier_id = $datacopy['supplier_id'];
        $supplier_name = $datacopy['supplier_name'];
        $purchase_order_id = $datacopy['purchase_order_id'];
        $purchase_order_invoice = $datacopy['purchase_order_invoice'];

        $this->clearTemp($user_id);

        $sqlText = "INSERT INTO temp_purchase(temp_purchase_po_id, temp_purchase_po_invoice, temp_purchase_item_id, temp_purchase_qty,temp_purchase_ppn, temp_purchase_dpp, temp_purchase_price, temp_purchase_discount1, temp_purchase_discount1_percentage, temp_purchase_discount2,temp_purchase_discount2_percentage, temp_purchase_discount3, temp_purchase_discount3_percentage, temp_purchase_discount_total,temp_purchase_ongkir, temp_purchase_expire_date,temp_purchase_total, temp_purchase_supplier_id,temp_purchase_supplier_name,temp_purchase_user_id) ";

        $sqlText .= "SELECT purchase_order_id, '". $purchase_order_invoice."' as purchase_order_invoice, detail_purchase_po_item_id, detail_purchase_po_qty,detail_purchase_po_ppn,detail_purchase_po_dpp,detail_purchase_po_price,detail_purchase_po_discount1,detail_purchase_po_discount1_percentage,detail_purchase_po_discount2,detail_purchase_po_discount2_percentage,detail_purchase_po_discount3,detail_purchase_po_discount3_percentage,detail_purchase_po_total_discount,detail_purchase_po_ongkir,detail_purchase_po_expire_date,detail_purchase_po_total,'".$supplier_id."' as detail_purchase_supplier_id,'".$supplier_name."' as detail_purchase_supplier_name,'".$user_id."' as detail_purchase_user_id";

        $sqlText .= " FROM dt_purchase_order WHERE purchase_order_id = '$purchase_order_id'";

        $this->db->query($sqlText);

        return $this->getTemp($user_id);
    }

    public function clearTemp($user_id)
    {
        return $this->db->table($this->table_temp_purchase)
        ->where('temp_purchase_user_id', $user_id)
        ->delete();
    }


    public function getTemp($user_id)
    {
        $builder = $this->db->table($this->table_temp_purchase);

        return $builder->select('*, ms_product.product_id as product_id, (temp_purchase_discount1+temp_purchase_discount2+temp_purchase_discount3) as temp_total_discount')
        
        ->join('ms_product_unit', 'ms_product_unit.item_id = temp_purchase.temp_purchase_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->where('temp_purchase.temp_purchase_user_id', $user_id)

        ->orderBy('temp_purchase.temp_purchase_update_at', 'ASC')

        ->get();
    }



    public function checkEd($user_id){

        $builder = $this->db->table($this->table_temp_purchase);

        return $builder->select('*')

        ->where('temp_purchase.temp_purchase_user_id', $user_id)

        ->where('temp_purchase.temp_purchase_expire_date', null)

        ->get();

    }

    public function getFooter($user_id){

        $builder = $this->db->table($this->table_temp_purchase);

        return $builder->select('sum(temp_purchase_total) as subTotal, sum(temp_purchase_ongkir) as totalOngkir, sum(temp_purchase_ppn) as totalPpn')

        ->where('temp_purchase.temp_purchase_user_id', $user_id)

        ->get();

    }

    public function getTax($user_id){

        $builder = $this->db->table($this->table_temp_purchase);

        return $builder->select('has_tax')

        ->join('ms_product_unit', 'ms_product_unit.item_id = temp_purchase.temp_purchase_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->where('temp_purchase.temp_purchase_user_id', $user_id)

        ->where('ms_product.has_tax', 'Y')

        ->get();

    }


    public function deletetemp($temp_purchase_id){

        $this->db->query('LOCK TABLES temp_purchase WRITE');

        $save = $this->db->table($this->table_temp_purchase)->delete(['temp_purchase_id' => $temp_purchase_id]);

        $saveQueries = NULL;

        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }

        $this->db->query('UNLOCK TABLES');

        return $save;
    }



    public function getPurchase($purchase_id){

        $builder = $this->db->table($this->table_hd_purchase);

        return $builder->select('*, hd_purchase.created_at as created_at')

        ->join('user_account', 'user_account.user_id = hd_purchase.purchase_user_id')

        ->join('ms_supplier', 'ms_supplier.supplier_id = hd_purchase.purchase_supplier_id')

        ->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_purchase.purchase_warehouse_id')

        ->where('purchase_id', $purchase_id)

        ->get();
    }

    public function getDtPurchase($invoice_num){

        $builder = $this->db->table($this->table_dt_purchase);

        return $builder->select('*')

        ->join('ms_product_unit', 'ms_product_unit.item_id = dt_purchase.dt_purchase_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->where('dt_purchase_invoice', $invoice_num)

        ->get();

    }

    public function getProductContent($item_id)
    {
        $builder = $this->db->table('ms_product_unit');

        $builder->select('product_content');

        $builder->where('item_id', $item_id);

        return  $builder->get();
    }


    public function insertPurchase($data)
    {


        $this->db->query('LOCK TABLES hd_purchase WRITE, dt_purchase WRITE');

        $this->db->transBegin();



        $saveQueries = NULL;

        $maxCode = $this->db->table($this->table_hd_purchase)->select('purchase_id, purchase_invoice')->orderBy('purchase_id', 'desc')->limit(1)->get()->getRowArray();

        $warehouse_code = $this->db->table($this->table_warehouse)->select('warehouse_code')->where('warehouse_id', $data['purchase_warehouse_id'])->get()->getRowArray();

        $invoice_date =  date_format(date_create($data['purchase_date']),"y/m");

        $warehouse_code = $warehouse_code['warehouse_code'];


        if ($maxCode == NULL) {


            $data['purchase_invoice'] = 'LBM/'.$warehouse_code.'/'.$invoice_date.'/'.'0000000001';


        } else {


            $invoice = substr($maxCode['purchase_invoice'], -10);

            $data['purchase_invoice'] = 'LBM/'.$warehouse_code.'/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);
        }


        $this->db->table($this->table_hd_purchase)->insert($data);

        $purchase_id  = $this->db->insertID();




        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }


        $sqlDtOrder = "insert into dt_purchase(dt_purchase_po_id,dt_purchase_po_invoice,dt_purchase_invoice,dt_purchase_item_id,dt_purchase_qty,dt_purchase_ppn,dt_purchase_dicount_nota,dt_purchase_dpp,dt_purchase_price,dt_purchase_discount1,dt_purchase_discount1_percentage,dt_purchase_discount2,dt_purchase_discount2_percentage,dt_purchase_discount3,dt_purchase_discount3_percentage,dt_purchase_discount_total,dt_purchase_ongkir,dt_purchase_expire_date,dt_purchase_total,dt_purchase_supplier_id,dt_purchase_supplier_name,dt_purchase_user_id) VALUES";

        $sqlUpdateProduct = "insert into ms_product (product_id, product_code, product_name, category_id, brand_id, base_purchase_price, base_purchase_tax, base_cogs, product_description, product_image, min_stock, has_tax, is_parcel, active, deleted) VALUES";

        $sqlUpdateStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

        $sqlUpdateWarehouse = "insert into ms_warehouse_stock (product_id , warehouse_id , purchase_id , exp_date, stock) VALUES";

        $sqlDtValues = [];
        $vUpdateProduct = [];
        $vUpdateStock = [];
        $vUpdateWarehouse = [];


        $getTemp =  $this->getTemp($data['purchase_user_id']);


        foreach ($getTemp->getResultArray() as $row) {

            //print_r($discount_nota_item);die();
            //Detail Purchase Data
            $purchase_inv                          = $data['purchase_invoice'];
            $temp_purchase_po_id                   = $row['temp_purchase_po_id'];
            $temp_purchase_po_invoice              = $row['temp_purchase_po_invoice'];
            $temp_purchase_item_id                 = $row['temp_purchase_item_id'];
            $temp_purchase_qty                     = floatval($row['temp_purchase_qty']);
            $temp_purchase_ppn                     = floatval($row['temp_purchase_ppn']);
            $temp_purchase_dpp                     = floatval($row['temp_purchase_dpp']);
            $temp_purchase_price                   = floatval($row['temp_purchase_price']);  
            $temp_purchase_discount1               = floatval($row['temp_purchase_discount1']);
            $temp_purchase_discount1_percentage    = floatval($row['temp_purchase_discount1_percentage']);
            $temp_purchase_discount2               = floatval($row['temp_purchase_discount2']);
            $temp_purchase_discount2_percentage    = floatval($row['temp_purchase_discount2_percentage']);
            $temp_purchase_discount3               = floatval($row['temp_purchase_discount3']);
            $temp_purchase_discount3_percentage    = floatval($row['temp_purchase_discount3_percentage']);
            $temp_purchase_discount_total          = floatval($row['temp_purchase_discount_total']);
            $temp_purchase_ongkir                  = floatval($row['temp_purchase_ongkir']);
            $temp_purchase_expire_date             = $row['temp_purchase_expire_date'];
            $temp_purchase_total                   = floatval($row['temp_purchase_total']);
            $temp_purchase_supplier_id             = $row['temp_purchase_supplier_id'];
            $temp_purchase_supplier_name           = $row['temp_purchase_supplier_name'];
            $temp_purchase_user_id                 = $row['temp_purchase_user_id'];
            $price                                 = $temp_purchase_qty - $temp_purchase_discount_total;
            //End Detail Purchase Data

                //print_r($temp_purchase_po_id);die();
            $updateQtyPO =  $this->db->table($this->table_dt_po)->where('purchase_order_id', $temp_purchase_po_id)->where('detail_purchase_po_item_id', $temp_purchase_item_id)->update(['detail_purchase_po_recive' => $temp_purchase_qty]);

            $getTotalItemPurchase = $this->db->table($this->table_temp_purchase)->select('sum(temp_purchase_qty * product_content) as qty')->join('ms_product_unit', 'ms_product_unit.item_id = temp_purchase.temp_purchase_item_id')->where('temp_purchase_user_id', $data['purchase_user_id'])->get()->getRowArray();

            $product_id             = $row['product_id'];
            $product_code           = $row['product_code'];
            $product_name           = $row['product_name'];
            $category_id            = $row['category_id'];
            $brand_id               = $row['brand_id'];
            $product_description    = $row['product_description'];
            $product_image          = $row['product_image'];
            $min_stock              = floatval($row['min_stock']);
            $has_tax                = $row['has_tax'];
            $is_parcel              = $row['is_parcel'];
            $active                 = $row['active'];
            $deleted                = $row['deleted'];
            $base_cogs              = $row['base_cogs'];
            $warehouse_id           = $data['purchase_warehouse_id'];

            $getStock = $this->db->table($this->table_ms_product_stock)->select('sum(stock) as stock')->where('product_id', $product_id)->get()->getRowArray();
            if($getStock['stock'] == null){
                $stock              = 0;
            }else{
                $stock              = $getStock['stock'];    
            }



            $get_price = $this->db->table($this->table_ms_product)->select('base_purchase_price')->where('product_id', $product_id)->get()->getRowArray();
            $product_content        = floatval($row['product_content']);
            $base_unit              = floatval($temp_purchase_qty * $product_content);
            $total_qty_all          = floatval($getTotalItemPurchase['qty']);
            $discount_per_item      = round(($row['temp_purchase_discount_total'] / $base_unit), 2);
            $discount_per_nota      = round(($data['purchase_total_discount'] / $total_qty_all), 2);

            $last_base_purchase_price   = floatval($get_price['base_purchase_price']);
            $new_base_purchase_price    = floatval($row['temp_purchase_price'] / $product_content - $discount_per_item - $discount_per_nota);

            if($new_base_purchase_price  > $last_base_purchase_price){
                $base_purchase_price = $new_base_purchase_price;
            }else{
                $base_purchase_price = $last_base_purchase_price;
            }

            $base_ongkir            = floatval($temp_purchase_ongkir / $base_unit);
            $base_purchase_tax      = round(($base_purchase_price * 0.11), 2);
            $dt_ppn_cal             = round(($new_base_purchase_price * 0.11), 2);
            $new_cogs               = $new_base_purchase_price  +  $dt_ppn_cal + $base_ongkir;
            $new_total_stock        = $stock + $temp_purchase_qty;

            $calcualtion_cogs       = round((($base_cogs * $stock) + ($new_cogs * $new_total_stock)) / ($stock + $new_total_stock), 2);

            $temp_discount_per_item        =  $temp_purchase_discount_total /  $temp_purchase_qty;
            $temp_discount_nota_per_item   =  $discount_per_nota  *  $product_content;


            $dt_ppn                 = $dt_ppn_cal * $base_unit;
            $dt_dpp                 = $new_base_purchase_price * $base_unit;
            $dt_discount_nota       = $temp_discount_nota_per_item * $temp_purchase_qty;


            $sqlDtValues[] = "('$temp_purchase_po_id','$temp_purchase_po_invoice','$purchase_inv','$temp_purchase_item_id','$temp_purchase_qty','$dt_ppn','$dt_discount_nota','$dt_dpp','$temp_purchase_price','$temp_purchase_discount1','$temp_purchase_discount1_percentage','$temp_purchase_discount2','$temp_purchase_discount2_percentage','$temp_purchase_discount3','$temp_purchase_discount3_percentage','$discount_per_nota','$temp_purchase_ongkir','$temp_purchase_expire_date','$temp_purchase_total','$temp_purchase_supplier_id','$temp_purchase_supplier_name','$temp_purchase_user_id')";


            $vUpdateProduct[] = "('$product_id', '$product_code', '$product_name', '$category_id', '$brand_id', '$base_purchase_price', '$base_purchase_tax', '$calcualtion_cogs', '$product_description', '$product_image', '$min_stock', '$has_tax', '$is_parcel', '$active', '$deleted')";

            $vUpdateStock[] = "('$product_id', '$warehouse_id', '$base_unit')";

            $vUpdateWarehouse[] = "('$product_id', '$warehouse_id', '$purchase_id', '$temp_purchase_expire_date', '$base_unit')";
        }

        $sqlDtOrder .= implode(',', $sqlDtValues);

        
        //print_r($sqlDtOrder);die();
        if($new_base_purchase_price  < $last_base_purchase_price){
            $sqlUpdateProduct .= implode(',', $vUpdateProduct). " ON DUPLICATE KEY UPDATE base_cogs=VALUES(base_cogs)";
        }else{
            $sqlUpdateProduct .= implode(',', $vUpdateProduct). " ON DUPLICATE KEY UPDATE base_purchase_price=VALUES(base_purchase_price), base_purchase_tax=VALUES(base_purchase_tax), base_cogs=VALUES(base_cogs)";    
        }

        $sqlUpdateStock .= implode(',', $vUpdateStock). " ON DUPLICATE KEY UPDATE stock=stock+VALUES(stock)";

        $sqlUpdateWarehouse .= implode(',', $vUpdateWarehouse). " ON DUPLICATE KEY UPDATE stock_id=VALUES(stock_id),stock=VALUES(stock)";


        if($data['purchase_po_invoice'] != null){
            $updateStatus =  $this->db->table($this->table_hd_po)->where('purchase_order_invoice', $data['purchase_po_invoice'])->update(['purchase_order_status' => 'Selesai']);
        }

        $this->db->query($sqlDtOrder);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        $this->db->query($sqlUpdateProduct);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

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

            $save = ['success' => FALSE, 'purchase_id' => 0];

        } else {

            $this->db->transCommit();

            $this->clearTemp($data['purchase_user_id']);

            $save = ['success' => TRUE, 'purchase_id' => $purchase_id ];

        }

        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'purchase', $purchase_id, 'insertpurchase');

        return $save;

    }

    public function getReportData($start_date, $end_date, $warehouse, $product_tax, $supplier_id, $category_id, $brand_id)
    {
        $builder = $this->db->table('hd_purchase')->select("*");
        $builder->join('dt_purchase', 'dt_purchase.dt_purchase_invoice = hd_purchase.purchase_invoice');
        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase.purchase_supplier_id');
        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_purchase.purchase_warehouse_id');
        $builder->join('ms_product_unit', 'ms_product_unit.item_id = dt_purchase.dt_purchase_item_id');
        $builder->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id');
        $builder->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id');
        $builder->join('ms_category', 'ms_category.category_id = ms_product.category_id');
        $builder->join('ms_brand', 'ms_brand.brand_id = ms_product.brand_id');  
        $builder->where("(purchase_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");

        if ($warehouse != null) {
            $builder->where('purchase_warehouse_id', $warehouse);
        }
        if ($product_tax != null) {
            if($product_tax == 'Y'){
                $builder->where('purchase_total_ppn >', '0');
            }else{
                $builder->where('purchase_total_ppn <', '0');
            }
        }
        if ($supplier_id != null) {
            $builder->where('purchase_supplier_id', $supplier_id);
        }
        if ($category_id != null) {
            $builder->where('ms_product.category_id', $category_id);
        }
        if ($brand_id != null) {
            $builder->where('ms_product.brand_id', $brand_id);
        }
        return $builder->orderBy('hd_purchase.created_at', 'ASC')->get();
    }

    public function getReportDataPurchaseHeader($start_date, $end_date, $warehouse, $product_tax, $supplier_id)
    {

        $builder = $this->db->table('hd_purchase')->select("supplier_code, supplier_name, purchase_invoice, purchase_date, purchase_due_date, purchase_total_dpp, purchase_total_ppn, purchase_total_ongkir, purchase_total, warehouse_name");
        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase.purchase_supplier_id');
        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_purchase.purchase_warehouse_id');
        $builder->where("(purchase_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");

        if ($warehouse != null) {
            $builder->where('purchase_warehouse_id', $warehouse);
        }
        if ($product_tax != null) {
            if($product_tax == 'Y'){
                $builder->where('purchase_total_ppn >', '0');
            }else{
                $builder->where('purchase_total_ppn <', '0');
            }
        }
        if ($supplier_id != null) {
            $builder->where('purchase_supplier_id', $supplier_id);
        }
        return $builder->orderBy('hd_purchase.created_at', 'ASC')->get();
    }

    public function getDebtPending($start_date, $end_date, $supplier_id)
    {
        $builder = $this->db->table('hd_purchase')->select("purchase_invoice, purchase_date, purchase_due_date, purchase_total, purchase_remaining_debt, purchase_down_payment, supplier_name");
        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase.purchase_supplier_id');
        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_purchase.purchase_warehouse_id');
        $builder->where("purchase_remaining_debt > 0");
        $builder->where("(purchase_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        if ($supplier_id != null) {
            $builder->where('purchase_supplier_id', $supplier_id);
        }
        return $builder->orderBy('hd_purchase.created_at', 'ASC')->get();
    }

    public function getDebtDueDate($start_date, $end_date, $supplier_id)
    {
        $builder = $this->db->table('hd_purchase')->select("purchase_invoice, purchase_date, purchase_due_date, purchase_total, purchase_remaining_debt, purchase_down_payment");
        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase.purchase_supplier_id');
        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_purchase.purchase_warehouse_id');
        $builder->where("purchase_remaining_debt > 0");
        $builder->where("(purchase_due_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        if ($supplier_id != null) {
            $builder->where('purchase_supplier_id', $supplier_id);
        }
        return $builder->orderBy('hd_purchase.created_at', 'ASC')->get();
    }


}
