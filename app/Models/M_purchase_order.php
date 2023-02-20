<?php

namespace App\Models;

use CodeIgniter\Model;

class M_purchase_order extends Model
{
    protected $table_temp_po = 'temp_purchase_order';
    protected $table_hd_po = 'hd_purchase_order';
    protected $table_dt_po = 'dt_purchase_order';
    protected $logUpdate   = 'log_transaction_edit_queries';
    protected $table_hd_submission   = 'hd_submission';
    protected $table_warehouse       = 'ms_warehouse';


    public function getOrder($purchase_order_id = '')
    {

        $builder = $this->db->table($this->table_hd_po);

        $builder->select('hd_purchase_order.*,dt_purchase_order.*,supplier_name ,user_account.user_realname, warehouse_name, hd_purchase_order.created_at as created_at');

         $builder->join('dt_purchase_order', 'dt_purchase_order.purchase_order_id = hd_purchase_order.purchase_order_id');

        $builder->join('user_account', 'user_account.user_id = hd_purchase_order.purchase_order_user_id');

        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase_order.purchase_order_supplier_id');

        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_purchase_order.purchase_order_warehouse_id');

        if ($purchase_order_id  != '') {

            $builder->where(['hd_purchase_order.purchase_order_id' => $purchase_order_id ]);

        }

        return $builder->get();
    }




    public function insertTemp($data)
    {

        $exist = $this->db->table($this->table_temp_po)

        ->where('temp_po_item_id', $data['temp_po_item_id'])

        ->where('temp_po_user_id', $data['temp_po_user_id'])

        ->countAllResults();

        if ($exist > 0) {

            return $this->db->table($this->table_temp_po)

            ->where('temp_po_item_id', $data['temp_po_item_id'])

            ->where('temp_po_user_id', $data['temp_po_user_id'])

            ->update($data);

        } else {

            return $this->db->table($this->table_temp_po)->insert($data);

        }

    }



    public function insertPurchaseOrder($data)

    {

        $this->db->query('LOCK TABLES hd_purchase_order WRITE');

        $this->db->transBegin();

        $saveQueries = NULL;

        $maxCode = $this->db->table($this->table_hd_po)->select('purchase_order_id, purchase_order_invoice')->orderBy('purchase_order_id', 'desc')->limit(1)->get()->getRowArray();

        $warehouse_code = $this->db->table($this->table_warehouse)->select('warehouse_code')->where('warehouse_id', $data['purchase_order_warehouse_id'])->get()->getRowArray();

        $invoice_date =  date_format(date_create($data['purchase_order_date']),"y/m/d");

        if ($maxCode == NULL) {

            $data['purchase_order_invoice'] = 'PO/'.$warehouse_code['warehouse_code'].'/'.$invoice_date.'/'.'0000000001';

        } else {

            $invoice = substr($maxCode['purchase_order_invoice'], -10);

            $data['purchase_order_invoice'] = 'PO/'.$warehouse_code['warehouse_code'].'/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);
            
        }

        $this->db->table($this->table_hd_po)->insert($data);

        $purchase_order_id  = $this->db->insertID();



        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = [

                'query_text'    => $this->db->getLastQuery()->getQuery(),

                'ref_id'        => $purchase_order_id 

            ];

        }



        $sqlDtOrder = "insert into dt_purchase_order(purchase_order_id,detail_submission_id,detail_submission_invoice,detail_purchase_po_item_id,detail_purchase_po_qty,detail_purchase_po_ppn,detail_purchase_po_dpp,detail_purchase_po_price,detail_purchase_po_discount1,detail_purchase_po_discount1_percentage,detail_purchase_po_discount2,detail_purchase_po_discount2_percentage,detail_purchase_po_discount3,detail_purchase_po_discount3_percentage,detail_purchase_po_total_discount,detail_purchase_po_ongkir,detail_purchase_po_expire_date,detail_purchase_po_total) VALUES";

        $sqlDtValues = [];

        $getTemp =  $this->db->table($this->table_temp_po)->where('temp_po_user_id', $data['purchase_order_user_id'])->get();


        foreach ($getTemp->getResultArray() as $row) {

            $detail_purchase_submission_id           = $row['temp_po_submission_id'];
            $detail_purchase_submission_invoice      = $row['temp_po_submission_invoice'];
            $detail_purchase_po_item_id              = $row['temp_po_item_id'];
            $detail_purchase_po_qty                  = $row['temp_po_qty'];
            $detail_purchase_po_ppn                  = $row['temp_po_ppn'];
            $detail_purchase_po_dpp                  = $row['temp_po_dpp'];
            $detail_purchase_po_price                = $row['temp_po_price'];
            $detail_purchase_po_discount1            = $row['temp_po_discount1'];
            $detail_purchase_po_discount1_percentage = $row['temp_po_discount1_percentage'];
            $detail_purchase_po_discount2            = $row['temp_po_discount2'];
            $detail_purchase_po_discount2_percentage = $row['temp_po_discount2_percentage'];
            $detail_purchase_po_discount3            = $row['temp_po_discount3'];
            $detail_purchase_po_discount3_percentage = $row['temp_po_discount3_percentage'];
            $detail_purchase_po_total_discount       = $row['temp_po_discount_total'];
            $detail_purchase_po_ongkir               = $row['temp_po_ongkir'];
            $detail_purchase_po_expire_date          = $row['temp_po_expire_date'];
            $detail_purchase_po_total                = $row['temp_po_total'];

            $sqlDtValues[] = "('$purchase_order_id','$detail_purchase_submission_id','$detail_purchase_submission_invoice','$detail_purchase_po_item_id','$detail_purchase_po_qty','$detail_purchase_po_ppn','$detail_purchase_po_dpp','$detail_purchase_po_price','$detail_purchase_po_discount1','$detail_purchase_po_discount1_percentage','$detail_purchase_po_discount2','$detail_purchase_po_discount2_percentage','$detail_purchase_po_discount3','$detail_purchase_po_discount3_percentage','$detail_purchase_po_total_discount','$detail_purchase_po_ongkir','$detail_purchase_po_expire_date','$detail_purchase_po_total')";

            if($detail_purchase_submission_id != null){
                $updateStatus =  $this->db->table($this->table_hd_submission)->where('submission_id ', $detail_purchase_submission_id)->update(['submission_status' => 'Accept']);
            }
        }

        $sqlDtOrder .= implode(',', $sqlDtValues);




        $this->db->query($sqlDtOrder);

        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }

        if ($this->db->transStatus() === false) {

            $saveQueries = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'purchase_order_id' => 0];

        } else {

            $this->db->transCommit();

            $this->clearTemp($data['purchase_order_user_id']);

            $save = ['success' => TRUE, 'purchase_order_id' => $purchase_order_id ];

        }

        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'inserPurchaseOrder', $purchase_order_id);
        return $save;

    }

    public function clearTemp($user_id)
    {

        return $this->db->table($this->table_temp_po)

        ->where('temp_po_user_id', $user_id)

        ->delete();

    }

    public function getTemp($user_id)
    {
        $builder = $this->db->table($this->table_temp_po);

        return $builder->select('*, (temp_po_discount1+temp_po_discount2+temp_po_discount3) as temp_total_discount')

        ->join('ms_product_unit', 'ms_product_unit.item_id = temp_purchase_order.temp_po_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->where('temp_purchase_order.temp_po_user_id', $user_id)

        ->orderBy('temp_purchase_order.temp_po_update_at', 'ASC')

        ->get();
    }

    public function getFooter($user_id){

        $builder = $this->db->table($this->table_temp_po);

        return $builder->select('sum(temp_po_total) as subTotal, sum(temp_po_ongkir) as totalOngkir, sum(temp_po_ppn) as totalPpn')

        ->where('temp_purchase_order.temp_po_user_id', $user_id)

        ->get();

    }


    public function getTax($user_id){

        $builder = $this->db->table($this->table_temp_po);

        return $builder->select('has_tax')

        ->join('ms_product_unit', 'ms_product_unit.item_id = temp_purchase_order.temp_po_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->where('temp_purchase_order.temp_po_user_id', $user_id)

        ->where('ms_product.has_tax', 'Y')

        ->get();

    }

    public function deletetemp($temp_po_id){
        $this->db->query('LOCK TABLES temp_purchase_order WRITE');
        $save = $this->db->table($this->table_temp_po)->delete(['temp_po_id' => $temp_po_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');
        //saveQueries($saveQueries, 'deletetemp', $temp_submission_id, 'Hapus Temp');
        return $save;
    }

    public function getPurchaseOrder($purchase_order_id){

     $builder = $this->db->table($this->table_hd_po);

     return $builder->select('*, hd_purchase_order.created_at as created_at')

     ->join('user_account', 'user_account.user_id = hd_purchase_order.purchase_order_user_id')

     ->join('ms_supplier', 'ms_supplier.supplier_id = hd_purchase_order.purchase_order_supplier_id')

     ->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_purchase_order.purchase_order_warehouse_id')

     ->where('purchase_order_id', $purchase_order_id)

     ->get();
 }

 public function cancelOrder($purchase_order_invoice, $purchase_order_id){
    $this->db->query('LOCK TABLES hd_purchase_order WRITE');
    $save = $this->db->table($this->table_hd_po)->update(['purchase_order_status' => 'Cancel'], ['purchase_order_id ' => $purchase_order_id]);
    $saveQueries = NULL;
    if ($this->db->affectedRows() > 0) {
        $saveQueries = $this->db->getLastQuery()->getQuery();
    }
    $this->db->query('UNLOCK TABLES');

    saveQueries($saveQueries, 'CancelPO', $purchase_order_id);
    return $save;
}


public function getDtPurchaseOrder($purchase_order_id){

    $builder = $this->db->table($this->table_dt_po);

    return $builder->select('*')

    ->join('ms_product_unit', 'ms_product_unit.item_id = dt_purchase_order.detail_purchase_po_item_id')

    ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

    ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

    ->where('purchase_order_id', $purchase_order_id)

    ->get();

}

public function getLogEditOrder($purchase_order_id = '')

{

    $builder = $this->db->table($this->logUpdate);

    $builder->select('log_transaction_edit_queries.log_user_id,user_account.user_name,user_account.user_realname,log_transaction_edit_queries.created_at');

    $builder->join('user_account', 'user_account.user_id=log_transaction_edit_queries.log_user_id');

    if ($purchase_order_id  != '') {

        $builder->where('log_transaction_edit_queries.log_transaction_id', $purchase_order_id);

    }

    $builder->where('log_transaction_edit_queries.log_transaction_code', 'Edit PO');

    $builder->orderBy('log_transaction_edit_queries.log_edit_id', 'ASC');

    return $builder->get();

}

public function getOrderInv($purchase_order_invoice = '')
{

    $builder = $this->db->table($this->table_hd_po);

    $builder->select('hd_purchase_order.*,supplier_name ,user_account.user_realname, warehouse_name');

    $builder->join('user_account', 'user_account.user_id = hd_purchase_order.purchase_order_user_id');

    $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_purchase_order.purchase_order_supplier_id');

    $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_purchase_order.purchase_order_warehouse_id');

    if ($purchase_order_invoice  != '') {

        $builder->where(['hd_purchase_order.purchase_order_invoice' => $purchase_order_invoice]);

    }

    return $builder->get();
}

public function copyDtOrderToTemp($datacopy)
{
    $user_id = $datacopy['user_id'];
    $purchase_order_id = $datacopy['purchase_order_id'];
    $supplier_id = $datacopy['temp_po_supplier_id'];
    $supplier_name = $datacopy['temp_po_supplier_name'];

    $this->clearTemp($user_id);

    $sqlText = "INSERT INTO temp_purchase_order(temp_po_submission_id,temp_po_submission_invoice,temp_po_item_id,temp_po_qty,temp_po_ppn,temp_po_dpp,temp_po_price,temp_po_discount1,temp_po_discount1_percentage,temp_po_discount2,temp_po_discount2_percentage,temp_po_discount3,temp_po_discount3_percentage,temp_po_discount_total,temp_po_ongkir,temp_po_expire_date,temp_po_total,temp_po_supplier_id,temp_po_supplier_name,temp_po_user_id) ";

    $sqlText .= "SELECT detail_submission_id,detail_submission_invoice,detail_purchase_po_item_id, detail_purchase_po_qty, detail_purchase_po_ppn, detail_purchase_po_dpp,detail_purchase_po_price,detail_purchase_po_discount1,detail_purchase_po_discount1_percentage,detail_purchase_po_discount2,detail_purchase_po_discount2_percentage,detail_purchase_po_discount3,detail_purchase_po_discount3_percentage,detail_purchase_po_total_discount,detail_purchase_po_ongkir,detail_purchase_po_expire_date,detail_purchase_po_total,'".$supplier_id."' as detail_po_supplier_id, '".$supplier_name."' as detail_po_supplier_name,'".$user_id."' as detail_po_user_id";

    $sqlText .= " FROM dt_purchase_order WHERE purchase_order_id = '$purchase_order_id'";

    $this->db->query($sqlText);

    return $this->getTemp($user_id);
}

public function clearUpdateDetail($purchase_order_id){

    return $this->db->table($this->table_dt_po)

    ->where('purchase_order_id', $purchase_order_id)

    ->delete();
}

public function UpdateStatusItem($input){
        $this->db->query('LOCK TABLES hd_purchase_order WRITE');
        $save = $this->db->table($this->table_hd_po)->update(['purchase_order_item_status' => $input['purchase_order_item_status']], ['purchase_order_id ' => $input['purchase_order_id_status']]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'UpdateStatusItem', $input['purchase_order_id_status']);
        return $save;
    }

public function updateOrder($data)
{

    $this->db->query('LOCK TABLES hd_purchase_order WRITE, dt_purchase_order WRITE, temp_purchase_order WRITE,ms_supplier READ, ms_warehouse READ, user_account READ');

    $purchase_order_id = $data['purchase_order_id'];

    $save = ['success' => FALSE, 'purchase_order_id' => 0];

    $getOrder = $this->getOrder($purchase_order_id)->getRowArray();

    if ($getOrder != NULL) {

        if ($getOrder['purchase_order_status'] == 'Pending') {

            $this->db->transBegin();

            $saveQueries = NULL;

            $user_id = $data['user_id'];

            unset($data['user_id']);

            $sqlDtOrder = "INSERT INTO dt_purchase_order(purchase_order_id,detail_submission_id,detail_submission_invoice,detail_purchase_po_item_id,detail_purchase_po_qty,detail_purchase_po_ppn,detail_purchase_po_dpp,detail_purchase_po_price,detail_purchase_po_discount1,detail_purchase_po_discount1_percentage,detail_purchase_po_discount2,detail_purchase_po_discount2_percentage,detail_purchase_po_discount3,detail_purchase_po_discount3_percentage,detail_purchase_po_total_discount,detail_purchase_po_ongkir,detail_purchase_po_expire_date,detail_purchase_po_total) VALUES ";

            $sqlDtValues = [];

            $deleteItemId = [];

            $getTemp =  $this->db->table($this->table_temp_po)->where('temp_po_user_id', $user_id)->get();

            foreach ($getTemp->getResultArray() as $row) {

                $purchase_order_id                          = $purchase_order_id;

                $detail_submission_id                       = $row['temp_po_submission_id'];

                $detail_submission_invoice                  = $row['temp_po_submission_invoice'];

                $detail_purchase_po_item_id                 = $row['temp_po_item_id'];

                $detail_purchase_po_qty                     = $row['temp_po_qty'];

                $detail_purchase_po_ppn                     = $row['temp_po_ppn'];

                $detail_purchase_po_dpp                     = $row['temp_po_dpp'];

                $detail_purchase_po_price                   = $row['temp_po_price'];

                $detail_purchase_po_discount1               = $row['temp_po_discount1'];

                $detail_purchase_po_discount1_percentage    = $row['temp_po_discount1_percentage'];

                $detail_purchase_po_discount2               = $row['temp_po_discount2'];

                $detail_purchase_po_discount2_percentage    = $row['temp_po_discount2_percentage'];

                $detail_purchase_po_discount3               = $row['temp_po_discount3'];

                $detail_purchase_po_discount3_percentage    = $row['temp_po_discount3_percentage'];

                $detail_purchase_po_total_discount          = $row['temp_po_discount_total'];

                $detail_purchase_po_ongkir                  = $row['temp_po_ongkir'];

                $detail_purchase_po_expire_date             = $row['temp_po_expire_date'];

                $detail_purchase_po_total                   = $row['temp_po_total'];

                $sqlDtValues[] = "('$purchase_order_id','$detail_submission_id','$detail_submission_invoice','$detail_purchase_po_item_id','$detail_purchase_po_qty','$detail_purchase_po_ppn','$detail_purchase_po_dpp','$detail_purchase_po_price','$detail_purchase_po_discount1','$detail_purchase_po_discount1_percentage','$detail_purchase_po_discount2','$detail_purchase_po_discount2_percentage','$detail_purchase_po_discount3','$detail_purchase_po_discount3_percentage','$detail_purchase_po_total_discount','$detail_purchase_po_ongkir','$detail_purchase_po_expire_date','$detail_purchase_po_total')";
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

        }

        return $save;
    }

}

}
