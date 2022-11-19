<?php

namespace App\Models;

use CodeIgniter\Model;

class M_consignment extends Model
{
    protected $table_hd_po_consignment = 'hd_purchase_order_consignment';
    protected $table_temp_po_consignment = 'temp_purchase_order_consignment';


    public function getTemp($user_id)
    {
        $builder = $this->db->table($this->table_temp_po_consignment);

        return $builder->select('ms_product.product_id, ms_product.product_code, ms_product.product_name, temp_purchase_order_consignment.temp_po_consignment_product_id, temp_purchase_order_consignment.temp_po_consignment_id, temp_purchase_order_consignment.temp_po_consignment_qty, temp_purchase_order_consignment.temp_po_consignment_expire_date, temp_purchase_order_consignment.temp_po_consignment_suplier_id, temp_purchase_order_consignment.temp_po_consignment_suplier_name')

        ->join('ms_product', 'ms_product.product_id = temp_purchase_order_consignment.temp_po_consignment_product_id')

        ->where('temp_purchase_order_consignment.temp_po_consignment_user_id', $user_id)

        ->orderBy('temp_purchase_order_consignment.temp_po_consignment_update_at', 'ASC')

        ->get();
    }

    public function insertTemp($data)
    {

        $exist = $this->db->table($this->table_temp_po_consignment)

            ->where('temp_po_consignment_product_id', $data['temp_po_consignment_product_id'])

            ->where('temp_po_consignment_user_id', $data['temp_po_consignment_user_id'])

            ->countAllResults();

        if ($exist > 0) {

            return $this->db->table($this->table_temp_po_consignment)
                
            ->where('temp_po_consignment_product_id', $data['temp_po_consignment_product_id'])

            ->where('temp_po_consignment_user_id', $data['temp_po_consignment_user_id'])

            ->update($data);

        } else {

            return $this->db->table($this->table_temp_po_consignment)->insert($data);

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

    public function checkInputTemp($temp_po_consignment_product_id)
    {

        $builder = $this->db->table($this->table_temp_po_consignment);

        return $builder->select('*')

        ->where('temp_po_consignment_product_id', $temp_po_consignment_product_id)

        ->get();
    }


    public function insertConsignment($data)

    {

        $this->db->query('LOCK TABLES hd_purchase_order_consignment WRITE,dt_submission WRITE');

        $this->db->transBegin();

        $saveQueries = NULL;

        $maxCode = $this->db->table($this->table_hd_po_consignment)->select('max(purchase_order_consignment_invoice) as purchase_order_consignment_invoice')->get()->getRowArray();

        if ($maxCode == NULL) {

            $data['purchase_order_consignment_invoice'] = "0000000001";

        } else {

            $data['purchase_order_consignment_invoice'] = substr('000000000' . strval(floatval($maxCode['purchase_order_consignment_invoice']) + 1), -10);

        }

        $this->db->table($this->table_hd_po_consignment)->insert($data);

        $purchase_order_consignment_id = $this->db->insertID();



        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = [

                'query_text'    => $this->db->getLastQuery()->getQuery(),

                'ref_id'        => $purchase_order_consignment_id

            ];

        }



        $sqlDtOrder = "insert into dt_purchase_order_consignment(dt_po_consignment_invoice,dt_po_consignment_product_id,dt_po_consignment_qty,dt_po_consignment_expire_date) VALUES";

        $sqlDtValues = [];

        $getTemp =  $this->db->table($this->table_temp_po_consignment)->where('temp_po_consignment_user_id', $data['purchase_order_consignment_user_id'])->get();

        foreach ($getTemp->getResultArray() as $row) {

            $dt_po_consignment_invoice          = $data['purchase_order_consignment_invoice'];
            $dt_po_consignment_product_id       = $row['temp_po_consignment_product_id'];
            $dt_po_consignment_qty              = $row['temp_po_consignment_qty'];
            $dt_po_consignment_expire_date      = $row['temp_po_consignment_expire_date'];
            $sqlDtValues[] = "('$dt_po_consignment_invoice','$dt_po_consignment_product_id','$dt_po_consignment_qty','$dt_po_consignment_expire_date')";

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

    public function clearTemp($user_id)
    {

        return $this->db->table($this->table_temp_po_consignment)

            ->where('temp_po_consignment_user_id', $user_id)

            ->delete();

    }

}
