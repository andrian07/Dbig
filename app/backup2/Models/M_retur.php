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

    public function searchPurchaseBysuplier($keyword, $supplier_id = '', $isItemCode = FALSE, $limit = 10)
    {
        $builder = $this->db->table('hd_purchase');
        $builder->select('purchase_id, purchase_invoice');
        $builder->Like('purchase_invoice', $keyword);
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


    public function deletetemp($retur_item_id, $user_id){

        return $this->db->table($this->table_temp_retur_purchase)

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

    public function getReturCheck($purchase_inv, $purchase_item_id)
    {

        $builder = $this->db->table('dt_retur_purchase');

        return $builder->select('sum(dt_retur_qty) as dt_retur_qty')

        ->where('dt_retur_purchase_invoice', $purchase_inv)

        ->where('dt_retur_item_id', $purchase_item_id)

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

    public function getTempReturPPNandDPP($user_id)
    {
        $builder = $this->db->table($this->table_temp_retur_purchase);

        return $builder->select('sum(retur_ppn) as total_retur_ppn, sum(retur_dpp) as total_retur_dpp')
        
        ->where('temp_retur_purchase.retur_user_id', $user_id)

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


        $updateRetur = "update hd_retur_purchase SET hd_retur_payment = '".$hd_retur_payment."' WHERE hd_retur_purchase_id = '".$hd_retur_purchase_id."'";

        $this->db->query($updateRetur);

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }

        $getTotalRetur = $this->db->table($this->table_dt_retur)->select('dt_retur_purchase_invoice, sum(dt_retur_total) as total_retur')->where('hd_retur_purchase_id', $hd_retur_purchase_id)->groupby('dt_retur_purchase_invoice')->get();


        foreach ($getTotalRetur->getResultArray() as $row) {
         if($hd_retur_payment == 'Ya'){
            $get_purchase_retur_nominal = $this->db->table($this->table_hd_purchase)->select('purchase_retur_nominal')->where('purchase_invoice', $row['dt_retur_purchase_invoice'])->get()->getResultArray();

            $total_retur_purchase = $get_purchase_retur_nominal[0]['purchase_retur_nominal'] + $hd_retur_total_transaction;

            $updateStatus =  $this->db->table($this->table_hd_purchase)->where('purchase_invoice', $row['dt_retur_purchase_invoice'])->update(['purchase_retur_nominal' => $total_retur_purchase]);
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

        $sqlUpdateStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

        $sqlUpdateWarehouse = "insert into ms_warehouse_stock (stock_id, product_id , warehouse_id , purchase_id , exp_date, stock) VALUES";

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

    public function clearTemp($user_id)
    {
        return $this->db->table($this->table_temp_retur_purchase)

        ->where('retur_user_id', $user_id)

        ->delete();
    }


    public function getRetur($hd_retur_purchase_id){

        $builder = $this->db->table($this->table_hd_retur);

        return $builder->select('*, hd_retur_purchase.created_at as created_at')

        ->join('user_account', 'user_account.user_id = hd_retur_purchase.created_by')

        ->join('ms_supplier', 'ms_supplier.supplier_id = hd_retur_purchase.hd_retur_supplier_id')

        ->where('hd_retur_purchase.hd_retur_purchase_id', $hd_retur_purchase_id)

        ->get();
    }

    public function getDtRetur($hd_retur_purchase_id){

        $builder = $this->db->table($this->table_dt_retur);

        return $builder->select('*')

        ->join('ms_product_unit', 'ms_product_unit.item_id = dt_retur_purchase.dt_retur_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_warehouse', 'ms_warehouse.warehouse_id = dt_retur_purchase.dt_retur_warehouse')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->where('hd_retur_purchase_id', $hd_retur_purchase_id)

        ->get();

    }


    public function getOrder($hd_retur_purchase_id = '')
    {
        $builder = $this->db->table($this->table);

        $builder->select('*, hd_purchase_order_consignment.created_at as created_at');

        $builder->join('user_account', 'user_account.user_id = hd_purchase_order_consignment.purchase_order_consignment_user_id');

        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase_order_consignment.purchase_order_consignment_supplier_id');

        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_purchase_order_consignment.purchase_order_consignment_warehouse_id');

        if ($purchase_order_consignment_id  != '') {

            $builder->where(['hd_purchase_order_consignment.purchase_order_consignment_id ' => $purchase_order_consignment_id ]);

        }

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


    public function updateOrder($data)
    {

        $this->db->query('LOCK TABLES hd_retur_purchase WRITE, dt_retur_purchase WRITE, temp_retur_purchase WRITE, ms_supplier READ, ms_warehouse READ, user_account READ');

        $hd_retur_purchase_id = $data['hd_retur_purchase_id'];

        $save = ['success' => FALSE, 'hd_retur_purchase_id' => 0];

        $getOrder = $this->getOrder($hd_retur_purchase_id)->getRowArray();

        if ($getOrder != NULL) {

            if ($getOrder['hd_retur_status'] == 'Pending') {

                $this->db->transBegin();

                $saveQueries = NULL;

                $user_id = $data['created_at'];

                unset($data['user_id']);

                $sqlDtOrder = "INSERT INTO dt_retur_purchase(hd_retur_purchase_id,dt_retur_purchase_invoice,dt_retur_supplier_id,dt_retur_item_id,dt_retur_price,dt_retur_ppn,dt_retur_warehouse,dt_retur_qty_buy,dt_retur_qty,dt_retur_total) VALUES ";

                $sqlDtValues = [];

                $deleteItemId = [];

                $getTemp =  $this->db->table($this->table_temp_po)->where('temp_po_user_id', $user_id)->get();

                foreach ($getTemp->getResultArray() as $row) {

                    $hd_retur_purchase_id                       = $hd_retur_purchase_id;

                    $dt_retur_purchase_invoice                  = $row['retur_purchase_invoice'];

                    $dt_retur_supplier_id                       = $row['retur_supplier_id'];

                    $dt_retur_item_id                           = $row['retur_item_id'];

                    $dt_retur_price                             = $row['retur_price'];

                    $dt_retur_ppn                               = $row['retur_ppn'];

                    $dt_retur_warehouse                         = $row['retur_warehouse'];

                    $dt_retur_qty_buy                           = $row['retur_qty_buy'];

                    $dt_retur_qty                               = $row['retur_qty'];

                    $dt_retur_total                             = $row['retur_total'];

                    $sqlDtValues[] = "('$hd_retur_purchase_id','$dt_retur_purchase_invoice','$dt_retur_supplier_id','$dt_retur_item_id','$dt_retur_price','$dt_retur_price','$dt_retur_ppn','$dt_retur_warehouse','$dt_retur_qty_buy','$dt_retur_qty','$dt_retur_total')";
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


    public function clearUpdateDetail($hd_retur_purchase_id){

        return $this->db->table($this->table_dt_retur)

        ->where('hd_retur_purchase_id', $hd_retur_purchase_id)

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

    public function getReportData($start_date, $end_date, $supplier_id)
    {
        $builder = $this->db->table('hd_retur_purchase')->select("hd_retur_total_dpp, hd_retur_total_ppn, hd_retur_total_transaction, hd_retur_purchase_invoice, hd_retur_date, supplier_code, supplier_name, hd_retur_purchase_invoice, dt_retur_purchase_invoice, hd_retur_date, item_code, product_name, brand_name, category_name, dt_retur_qty, unit_name, dt_retur_price, dt_retur_dpp, dt_retur_ppn, dt_retur_total, warehouse_name");
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
