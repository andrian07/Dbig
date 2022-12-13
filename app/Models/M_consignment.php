<?php

namespace App\Models;

use CodeIgniter\Model;

class M_consignment extends Model
{
    protected $table_hd_po_consignment = 'hd_purchase_order_consignment';
    protected $table_temp_po_consignment = 'temp_purchase_order_consignment';
    protected $table_temp_consignment = 'temp_purchase_consignment';
    protected $table_warehouse = 'ms_warehouse';
    protected $table_hd_purchase_consignment = 'hd_purchase_consignment';


    public function getTemp($user_id)
    {
        $builder = $this->db->table($this->table_temp_po_consignment);

        return $builder->select('ms_product.product_id, ms_product.product_code, ms_product.product_name, temp_purchase_order_consignment.temp_po_consignment_item_id, temp_purchase_order_consignment.temp_po_consignment_id, temp_purchase_order_consignment.temp_po_consignment_qty, temp_purchase_order_consignment.temp_po_consignment_expire_date, temp_purchase_order_consignment.temp_po_consignment_suplier_id, temp_purchase_order_consignment.temp_po_consignment_suplier_name, ms_unit.unit_name, ms_product_unit.item_code')

        ->join('ms_product_unit', 'ms_product_unit.item_id = temp_purchase_order_consignment.temp_po_consignment_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->where('temp_purchase_order_consignment.temp_po_consignment_user_id', $user_id)

        ->orderBy('temp_purchase_order_consignment.temp_po_consignment_update_at', 'ASC')

        ->get();
    }

    public function getTempInputConsignment($user_id)
    {
        $builder = $this->db->table($this->table_temp_consignment);

        return $builder->select('ms_product.product_id, ms_product.product_code, ms_product.product_name, temp_purchase_consignment.temp_consignment_item_id, temp_purchase_consignment.temp_consignment_id, temp_purchase_consignment.temp_consignment_qty, temp_purchase_consignment.temp_consignment_expire_date, temp_purchase_consignment.temp_consignment_suplier_id, temp_purchase_consignment.temp_consignment_suplier_name, ms_unit.unit_name, ms_product_unit.item_code, ms_product.base_purchase_price, ms_product_unit.product_content')

        ->join('ms_product_unit', 'ms_product_unit.item_id = temp_purchase_consignment.temp_consignment_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        //->join('ms_product_stock', 'ms_product_stock.product_id = ms_product.product_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->where('temp_purchase_consignment.temp_consignment_user_id', $user_id)

        ->orderBy('temp_purchase_consignment.temp_consignment_update_at', 'ASC')

        ->get();
    }

    public function getOrderPoConsignment($purchase_order_consignment_id)
    {
        $builder = $this->db->table($this->table_hd_po_consignment);

        $builder->select('hd_purchase_order_consignment.*,supplier_name ,user_account.user_realname, warehouse_name');

        $builder->join('user_account', 'user_account.user_id = hd_purchase_order_consignment.purchase_order_consignment_user_id');

        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase_order_consignment.purchase_order_consignment_supplier_id');

        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_purchase_order_consignment.purchase_order_consignment_store_id');

        if ($purchase_order_consignment_id  != '') {

            $builder->where(['hd_purchase_order_consignment.purchase_order_consignment_id ' => $purchase_order_consignment_id ]);

        }

        return $builder->get();
    }

    public function copyDtOrderToTemp($datacopy)
    {
        $user_id = $datacopy['user_id'];
        $supplier_id = $datacopy['supplier_id'];
        $supplier_name = $datacopy['supplier_name'];
        $purchase_order_id = $datacopy['purchase_order_id'];
        $purchase_order_invoice = $datacopy['purchase_order_invoice'];

        $this->clearTempInput($user_id);

        $sqlText = "INSERT INTO temp_purchase_consignment(temp_consignment_item_id, temp_consignment_qty, temp_consignment_expire_date,temp_consignment_suplier_id, temp_consignment_suplier_name, temp_consignment_user_id) ";

        $sqlText .= "SELECT dt_po_consignment_item_id, dt_po_consignment_qty, dt_po_consignment_expire_date,'".$supplier_id."' as dt_po_suplier_id,'".$supplier_name."' as dt_po_suplier_name,'".$user_id."' as dt_po_user_id";

        $sqlText .= " FROM dt_purchase_order_consignment WHERE dt_po_consignment_invoice = '$purchase_order_invoice'";

        $this->db->query($sqlText);

        return $this->getTempInputConsignment($user_id);
    }

    public function insertTemp($data)
    {

        $exist = $this->db->table($this->table_temp_po_consignment)

            ->where('temp_po_consignment_item_id', $data['temp_po_consignment_item_id'])

            ->where('temp_po_consignment_user_id', $data['temp_po_consignment_user_id'])

            ->countAllResults();

        if ($exist > 0) {

            return $this->db->table($this->table_temp_po_consignment)
                
            ->where('temp_po_consignment_item_id', $data['temp_po_consignment_item_id'])

            ->where('temp_po_consignment_user_id', $data['temp_po_consignment_user_id'])

            ->update($data);

        } else {

            return $this->db->table($this->table_temp_po_consignment)->insert($data);

        }

    }

    public function insertTempInput($data)
    {

        $exist = $this->db->table($this->table_temp_consignment)

            ->where('temp_consignment_item_id', $data['temp_consignment_item_id'])

            ->where('temp_consignment_user_id', $data['temp_consignment_user_id'])

            ->countAllResults();

        if ($exist > 0) {

            return $this->db->table($this->table_temp_consignment)
                
            ->where('temp_consignment_item_id', $data['temp_consignment_item_id'])

            ->where('temp_consignment_user_id', $data['temp_consignment_user_id'])

            ->update($data);

        } else {

            return $this->db->table($this->table_temp_consignment)->insert($data);

        }

    }


     public function deletetemp($temp_po_consignment_id){
        $this->db->query('LOCK TABLES temp_purchase_order_consignment WRITE');
        $save = $this->db->table($this->table_temp_po_consignment)->delete(['temp_po_consignment_id' => $temp_po_consignment_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');
        //saveQueries($saveQueries, 'deletetemp', $temp_submission_id, 'Hapus Temp');
        return $save;
    }

    public function deleteTempCons($temp_consignment_id){
        $this->db->query('LOCK TABLES temp_purchase_consignment WRITE');
        $save = $this->db->table($this->table_temp_consignment)->delete(['temp_consignment_id' => $temp_consignment_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');
        //saveQueries($saveQueries, 'deletetemp', $temp_submission_id, 'Hapus Temp');
        return $save;
    }

    

    public function checkInputTemp($temp_po_consignment_item_id)
    {

        $builder = $this->db->table($this->table_temp_po_consignment);

        return $builder->select('*')

        ->where('temp_po_consignment_item_id', $temp_po_consignment_item_id)

        ->get();
    }


    public function insertConsignment($data)

    {

        $this->db->query('LOCK TABLES hd_purchase_order_consignment WRITE,dt_purchase_order_consignment WRITE');

        $this->db->transBegin();

        $saveQueries = NULL;

        $maxCode = $this->db->table($this->table_hd_po_consignment)->select('max(purchase_order_consignment_invoice) as purchase_order_consignment_invoice')->get()->getRowArray();

        $warehouse_code = $this->db->table($this->table_warehouse)->select('warehouse_code')->where('warehouse_id', $data['purchase_order_consignment_store_id'])->get()->getRowArray();

        $invoice_date =  date_format(date_create($data['purchase_order_consignment_date']),"y/m");


        if ($maxCode['purchase_order_consignment_invoice'] == NULL) {

            $data['purchase_order_consignment_invoice'] = 'POK/'.$invoice_date.'/'.'0000000001';

        } else {

            $invoice = substr($maxCode['purchase_order_consignment_invoice'], -10);

            $data['purchase_order_consignment_invoice'] = 'LBM/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);

        }

        $this->db->table($this->table_hd_po_consignment)->insert($data);

        $purchase_order_consignment_id = $this->db->insertID();



        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = [

                'query_text'    => $this->db->getLastQuery()->getQuery(),

                'ref_id'        => $purchase_order_consignment_id

            ];

        }



        $sqlDtOrder = "insert into dt_purchase_order_consignment(dt_po_consignment_invoice,dt_po_consignment_item_id,dt_po_consignment_qty,dt_po_consignment_expire_date) VALUES";

        $sqlDtValues = [];

        $getTemp =  $this->db->table($this->table_temp_po_consignment)->where('temp_po_consignment_user_id', $data['purchase_order_consignment_user_id'])->get();

        foreach ($getTemp->getResultArray() as $row) {

            $dt_po_consignment_invoice          = $data['purchase_order_consignment_invoice'];
            $dt_po_consignment_item_id       = $row['temp_po_consignment_item_id'];
            $dt_po_consignment_qty              = $row['temp_po_consignment_qty'];
            $dt_po_consignment_expire_date      = $row['temp_po_consignment_expire_date'];

            $sqlDtValues[] = "('$dt_po_consignment_invoice','$dt_po_consignment_item_id','$dt_po_consignment_qty','$dt_po_consignment_expire_date')";

        }

        $sqlDtOrder .= implode(',', $sqlDtValues);



        $this->db->query($sqlDtOrder);

        if ($this->db->affectedRows() > 0) {
                $saveQueries = $this->db->getLastQuery()->getQuery();
        }

        if ($this->db->transStatus() === false) {

            $saveQueries = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'purchase_order_consignment_id' => 0];

        } else {

            $this->db->transCommit();

            $this->clearTemp($data['purchase_order_consignment_user_id']);

            $save = ['success' => TRUE, 'purchase_order_consignment_id' => $purchase_order_consignment_id ];

        }

        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'insertConsignment', $purchase_order_consignment_id);
        return $save;

    }

    public function insertInputConsignment($data)
    {

         $this->db->query('LOCK TABLES hd_purchase_consignment WRITE,dt_purchase_consignment WRITE, ms_warehouse_stock WRITE, ms_product_stock WRITE');

        $this->db->transBegin();

        $saveQueries = NULL;

        $maxCode = $this->db->table($this->table_hd_purchase_consignment)->select('max(purchase_consignment_invoice) as purchase_consignment_invoice')->get()->getRowArray();

        $warehouse_code = $this->db->table($this->table_warehouse)->select('warehouse_code')->where('warehouse_id', $data['purchase_consignment_store_id'])->get()->getRowArray();

        $invoice_date =  date_format(date_create($data['purchase_consignment_date']),"y/m");


        if ($maxCode['purchase_consignment_invoice'] == NULL) {

            $data['purchase_consignment_invoice'] = 'IC/'.$invoice_date.'/'.'0000000001';

        } else {

            $invoice = substr($maxCode['purchase_consignment_invoice'], -10);

            $data['purchase_consignment_invoice'] = 'IC/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);

        }

        $this->db->table($this->table_hd_purchase_consignment)->insert($data);

        $purchase_consignment_id = $this->db->insertID();



        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = [

                'query_text'    => $this->db->getLastQuery()->getQuery(),

                'ref_id'        => $purchase_consignment_id

            ];

        }



        $sqlDtOrder = "insert into dt_purchase_consignment(dt_consignment_invoice,dt_consignment_item_id,dt_consignment_qty,dt_consignment_expire_date) VALUES ";
        $sqlUpdateStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

        $sqlUpdateWarehouse = "insert into ms_warehouse_stock (product_id , warehouse_id , purchase_id , exp_date, stock) VALUES";

        $sqlDtValues = [];
        $vUpdateStock = [];
        $vUpdateWarehouse = [];

        $getTempInputConsignment =  $this->getTempInputConsignment($data['purchase_consignment_user_id']);

        
        foreach ($getTempInputConsignment->getResultArray() as $row) {

           

            $dt_consignment_invoice       = $data['purchase_consignment_invoice'];
            $dt_consignment_item_id       = $row['temp_consignment_item_id'];
            $dt_consignment_qty           = $row['temp_consignment_qty'];
            $dt_consignment_expire_date   = $row['temp_consignment_expire_date'];
            $product_content              = $row['product_content'];
            $product_id                   = $row['product_id'];
            $warehouse_id                 = $data['purchase_consignment_store_id'];


            $base_consignment_stock       = $dt_consignment_qty * $product_content;

            $sqlDtValues[] = "('$dt_consignment_invoice','$dt_consignment_item_id','$dt_consignment_qty','$dt_consignment_expire_date')";

            $vUpdateStock[] = "('$product_id', '$warehouse_id', '$base_consignment_stock')";

            $vUpdateWarehouse[] = "('$product_id', '$warehouse_id', '$purchase_consignment_id', '$dt_consignment_expire_date', '$base_consignment_stock')";

        }

        $sqlDtOrder .= implode(',', $sqlDtValues);

        $sqlUpdateStock .= implode(',', $vUpdateStock). " ON DUPLICATE KEY UPDATE stock = stock + VALUES(stock)";

        $sqlUpdateWarehouse .= implode(',', $vUpdateWarehouse). " ON DUPLICATE KEY UPDATE stock_id=VALUES(stock_id),stock=VALUES(stock)";

        $this->db->query($sqlDtOrder);
        if ($this->db->affectedRows() > 0) {

                $saveQueries[] = [

                    'query_text'    => $this->db->getLastQuery()->getQuery(),

                    'ref_id'        => $purchase_consignment_id

                ];

            }

        $this->db->query($sqlUpdateStock);

        if ($this->db->affectedRows() > 0) {

                $saveQueries[] = [

                    'query_text'    => $this->db->getLastQuery()->getQuery(),

                    'ref_id'        => $purchase_consignment_id

                ];

            }

        $this->db->query($sqlUpdateWarehouse);

        if ($this->db->affectedRows() > 0) {

                $saveQueries[] = [

                    'query_text'    => $this->db->getLastQuery()->getQuery(),

                    'ref_id'        => $purchase_consignment_id

                ];

            }


        if ($this->db->transStatus() === false) {

            $saveQueries[] = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'purchase_consignment_id' => 0];

        } else {

            $this->db->transCommit();

            $this->clearTempInput($data['purchase_consignment_user_id']);

            $save = ['success' => TRUE, 'purchase_consignment_id' => $purchase_consignment_id ];

        }

        $this->db->query('UNLOCK TABLES');

        foreach($saveQueries as $rowQuery){
        saveQueries($rowQuery['query_text'], 'insertConsignment', $purchase_consignment_id);
        }

        return $save;

    }

    public function clearTemp($user_id)
    {

        return $this->db->table($this->table_temp_po_consignment)

            ->where('temp_po_consignment_user_id', $user_id)

            ->delete();

    }

     public function clearTempInput($user_id)
    {

        return $this->db->table($this->table_temp_consignment)

            ->where('temp_consignment_user_id', $user_id)

            ->delete();

    }

}
