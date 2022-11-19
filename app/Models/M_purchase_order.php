<?php

namespace App\Models;

use CodeIgniter\Model;

class M_purchase_order extends Model
{
    protected $table_temp_po = 'temp_purchase_order';
    protected $table_hd_po = 'hd_purchase_order';

    public function insertTemp($data)
    {
        $this->db->query('LOCK TABLES temp_purchase_order WRITE');
        $save = $this->db->table($this->table_temp_po)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');
        return $save;
    }

    public function insertPurchaseOrder($data)

    {

        $this->db->query('LOCK TABLES hd_purchase_order WRITE,dt_submission WRITE');

        $this->db->transBegin();

        $saveQueries = NULL;

        $maxCode = $this->db->table($this->table_hd_po)->select('max(purchase_order_invoice) as purchase_order_invoice')->get()->getRowArray();

        if ($maxCode == NULL) {

            $data['purchase_order_invoice'] = "0000000001";

        } else {

            $data['purchase_order_invoice'] = substr('000000000' . strval(floatval($maxCode['purchase_order_invoice']) + 1), -10);

        }

        $this->db->table($this->table_hd_po)->insert($data);

        $purchase_order_id  = $this->db->insertID();



        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = [

                'query_text'    => $this->db->getLastQuery()->getQuery(),

                'ref_id'        => $purchase_order_id 

            ];

        }



        $sqlDtOrder = "insert into dt_purchase_order(detail_purchase_order_inv,detail_purchase_po_product_id,detail_purchase_po_qty,detail_purchase_po_ppn,detail_purchase_po_dpp,detail_purchase_po_price,detail_purchase_po_discount1,detail_purchase_po_discount2,detail_purchase_po_discount3,detail_purchase_po_ongkir,detail_purchase_po_expire_date,detail_purchase_po_total) VALUES";

        $sqlDtValues = [];

        $getTemp =  $this->db->table($this->table_temp_po)->where('temp_po_suplier_id', $data['purchase_order_user_id'])->get();

        foreach ($getTemp->getResultArray() as $row) {

            $detail_purchase_order_inv              = $data['purchase_order_invoice'];
            $detail_purchase_po_product_id          = $row['temp_po_product_id'];
            $detail_purchase_po_qty                 = $row['temp_po_qty'];
            $detail_purchase_po_ppn                 = $row['temp_po_ppn'];
            $detail_purchase_po_dpp                 = $row['temp_po_dpp'];
            $detail_purchase_po_price               = $row['temp_po_price'];
            $detail_purchase_po_discount1           = $row['temp_po_discount1'];
            $detail_purchase_po_discount2           = $row['temp_po_discount2'];
            $detail_purchase_po_discount3           = $row['temp_po_discount3'];
            $detail_purchase_po_ongkir              = $row['temp_po_ongkir'];
            $detail_purchase_po_expire_date         = $row['temp_po_expire_date'];
            $detail_purchase_po_total               = $row['temp_po_total'];

            $sqlDtValues[] = "('$detail_purchase_order_inv','$detail_purchase_po_product_id','$detail_purchase_po_qty',$detail_purchase_po_ppn,'$detail_purchase_po_dpp','$detail_purchase_po_price','$detail_purchase_po_discount1','$detail_purchase_po_discount2','$detail_purchase_po_discount3','$detail_purchase_po_ongkir','$detail_purchase_po_expire_date','$detail_purchase_po_total')";
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

        ->join('ms_product', 'ms_product.product_id = temp_purchase_order.temp_po_product_id')

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
    
}
