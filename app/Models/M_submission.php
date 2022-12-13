<?php

namespace App\Models;

use CodeIgniter\Model;

class M_submission extends Model
{
    protected $table_temp_submission = 'temp_submission';
    protected $table_hd_submission   = 'hd_submission';
    protected $table_dt_submission   = 'dt_submission';
    protected $logUpdate             = 'log_transaction_edit_queries';
    protected $table_warehouse       = 'ms_warehouse';



    public function getOrder($submission_id = '')
    {

        $builder = $this->db->table($this->table_hd_submission);

        $builder->select('hd_submission.*,user_account.user_realname,supplier_name, CONCAT(warehouse_code, " - " ,warehouse_name) as warehouse_name');

        $builder->join('user_account', 'user_account.user_id = hd_submission.submission_user_id');

        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_submission.submission_store_id');

        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_submission.submission_supplier_id');

        if ($submission_id  != '') {

            $builder->where(['hd_submission.submission_id' => $submission_id ]);

        }

        return $builder->get();
    }

      public function checkNullItem($submission_inv = '')
    {

        $builder = $this->db->table($this->table_dt_submission);
        $builder->select('*');
        $builder->where(['detail_submission_inv' => $submission_inv ]);
        $builder->where(['detail_submission_product_id' => 0 ]);
        return $builder->get();
    }

    public function getOrderInv($submission_inv = '')
    {

        $builder = $this->db->table($this->table_hd_submission);

        $builder->select('hd_submission.*,user_account.user_realname,supplier_name, CONCAT(warehouse_code, " - " ,warehouse_name) as warehouse_name');

        $builder->join('user_account', 'user_account.user_id = hd_submission.submission_user_id');

        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_submission.submission_store_id');

        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_submission.submission_supplier_id');

        if ($submission_inv  != '') {

            $builder->where(['hd_submission.submission_inv' => $submission_inv ]);

        }

        return $builder->get();
    }



    public function copyDtOrderToTemp($submission_inv, $user_id, $supplier_id, $supplier_name)
    {
        $this->clearTemp($user_id);

        $sqlText = "INSERT INTO temp_submission(temp_submission_product_name,temp_submission_product_id,temp_submission_order_qty,temp_submission_status,temp_submission_desc,temp_submission_user_id,temp_submission_supplier_id,temp_submission_supplier_name) ";

        $sqlText .= "SELECT detail_submission_product_name, detail_submission_product_id, detail_submission_order_qty, detail_submission_status,detail_submission_desc,detail_submission_user_id,'".$supplier_id."' as supplier_id,'".$supplier_name."' as supplier_name";

        $sqlText .= " FROM dt_submission WHERE detail_submission_inv = '$submission_inv'";


        $this->db->query($sqlText);

        return $this->getTemp($user_id);
    }

    public function insertTemp($data)
    {

        $this->db->query('LOCK TABLES temp_submission WRITE');
        $save = $this->db->table($this->table_temp_submission)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        return $save;
    }


    public function getTemp($user_id)
    {
        $builder = $this->db->table($this->table_temp_submission);

        return $builder->select('ms_product.product_id, ms_product.product_code, ms_product.product_name, ms_product.product_code, temp_submission.temp_submission_product_name, temp_submission.temp_submission_id, temp_submission.temp_submission_order_qty, temp_submission.temp_submission_status, temp_submission.temp_submission_desc, temp_submission.temp_submission_approval, temp_submission.temp_submission_supplier_id, temp_submission.temp_submission_supplier_name, ms_product_unit.item_code, ms_product_unit.item_id')

        ->join('ms_product_unit', 'ms_product_unit.item_id = temp_submission.temp_submission_product_id', 'left')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id', 'left')

        ->where('temp_submission.temp_submission_user_id', $user_id)

        ->orderBy('temp_submission.temp_submission_update_at', 'ASC')

        ->get();
    }

    public function deletetemp($temp_submission_id){
        $this->db->query('LOCK TABLES temp_submission WRITE');
        $save = $this->db->table($this->table_temp_submission)->delete(['temp_submission_id' => $temp_submission_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');
        //saveQueries($saveQueries, 'deletetemp', $temp_submission_id, 'Hapus Temp');
        return $save;
    }

    public function editTemp($data){
        $this->db->query('LOCK TABLES temp_submission WRITE');
        $save = $this->db->table($this->table_temp_submission)->update($data, ['temp_submission_id' => $data['temp_submission_id']]);

        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        //saveQueries($saveQueries, 'edittemp', $data['temp_submission_id']);
        return $save;
    }

    public function cancelOrder($submission_inv, $submission_id){
        $this->db->query('LOCK TABLES hd_submission WRITE');
        $save = $this->db->table($this->table_hd_submission)->update(['submission_status' => 'Cancel'], ['submission_id ' => $submission_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'cancelsubmission', $submission_id);
        return $save;
    }

    public function insertSubmission($data)
    {
        $this->db->query('LOCK TABLES hd_submission WRITE,dt_submission WRITE');

        $this->db->transBegin();

        $saveQueries = NULL;

        $maxCode = $this->db->table($this->table_hd_submission)->select('submission_id, submission_inv')->orderBy('submission_id', 'desc')->limit(1)->get()->getRowArray();

        $warehouse_code = $this->db->table($this->table_warehouse)->select('warehouse_code')->where('warehouse_id', $data['submission_store_id'])->get()->getRowArray();

        $invoice_date =  date_format(date_create($data['submission_date']),"y/m/d");

        if ($maxCode == NULL) {

            $data['submission_inv'] = 'PJ/'.$warehouse_code['warehouse_code'].'/'.$invoice_date.'/'.'0000000001';

        } else {

            $invoice = substr($maxCode['submission_inv'], -10);

            $data['submission_inv'] = 'PJ/'.$warehouse_code['warehouse_code'].'/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);
            
        }

        $this->db->table($this->table_hd_submission)->insert($data);

        $submission_id = $this->db->insertID();



        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = [

                'query_text'    => $this->db->getLastQuery()->getQuery(),

                'ref_id'        => $submission_id

            ];

        }

        $sqlDtOrder = "insert into dt_submission(detail_submission_product_name,detail_submission_inv,detail_submission_product_id,detail_submission_order_qty,detail_submission_status,detail_submission_desc,detail_submission_user_id) VALUES";

        $sqlDtValues = [];

        $getTemp =  $this->db->table($this->table_temp_submission)->where('temp_submission_user_id', $data['submission_user_id'])->get();

        foreach ($getTemp->getResultArray() as $row) {

            $detail_submission_inv             = $data['submission_inv'];
            $detail_submission_product_name    = $row['temp_submission_product_name'];
            $detail_submission_product_id      = $row['temp_submission_product_id'];
            $detail_submission_order_qty       = $row['temp_submission_order_qty'];
            $detail_submission_status          = $row['temp_submission_status'];
            $detail_submission_desc            = $row['temp_submission_desc'];
            $detail_submission_user_id         = $row['temp_submission_user_id'];
            $sqlDtValues[] = "('$detail_submission_product_name','$detail_submission_inv','$detail_submission_product_id',$detail_submission_order_qty,'$detail_submission_status','$detail_submission_desc','$detail_submission_user_id')";

        }

        $sqlDtOrder .= implode(',', $sqlDtValues);

        $this->db->query($sqlDtOrder);

        if ($this->db->affectedRows() > 0) {
                $saveQueries = $this->db->getLastQuery()->getQuery();
        }

        if ($this->db->transStatus() === false) {

            $saveQueries = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'submission_id' => 0];

        } else {

            $this->db->transCommit();

            $this->clearTemp($data['submission_user_id']);

            $save = ['success' => TRUE, 'submission_id' => $submission_id ];

        }

        $this->db->query('UNLOCK TABLES');

        $data_save = saveQueries($saveQueries, 'insertSubmission', $submission_id);
        return $save;

    }


    public function clearTemp($user_id)

    {

        return $this->db->table($this->table_temp_submission)

            ->where('temp_submission_user_id', $user_id)

            ->delete();

    }

    public function clearUpdateDetail($submission_inv){
        return $this->db->table($this->table_dt_submission)

            ->where('detail_submission_inv', $submission_inv)

            ->delete();
    }

    public function getSubmission($submission_id){

        $builder = $this->db->table($this->table_hd_submission);

        return $builder->select('*')

        ->join('user_account', 'user_account.user_id = hd_submission.submission_user_id')

        ->join('ms_supplier', 'ms_supplier.supplier_id = hd_submission.submission_supplier_id')

        ->where('submission_id', $submission_id)

        ->get();
    }

    public function getSubmissiondetail($submission_id){

         $builder = $this->db->table($this->table_hd_submission);

        return $builder->select('*')

         ->join('user_account', 'user_account.user_id = hd_submission.submission_user_id')

        ->where('submission_id', $submission_id)

        ->get();
    }

    public function getDtSubmission($invoice_num){

        $builder = $this->db->table($this->table_dt_submission);

        return $builder->select('*')

        ->join('ms_product', 'ms_product.product_id = dt_submission.detail_submission_product_id', 'left')

        ->where('detail_submission_inv', $invoice_num)

        ->get();

    }

      public function getLogEditOrder($submission_id = '')

    {

        $builder = $this->db->table($this->logUpdate);

        $builder->select('log_transaction_edit_queries.log_user_id,user_account.user_name,user_account.user_realname,log_transaction_edit_queries.created_at');

        $builder->join('user_account', 'user_account.user_id=log_transaction_edit_queries.log_user_id');

        if ($submission_id  != '') {

            $builder->where('log_transaction_edit_queries.log_transaction_id', $submission_id);

        }

        $builder->where('log_transaction_edit_queries.log_transaction_code', 'Submission');

        $builder->orderBy('log_transaction_edit_queries.log_edit_id', 'ASC');

        return $builder->get();

    }

    public function saveLastData($submission_id, $input_detail_last_data)
    {
        saveEditQueries('Submission',$submission_id, $input_detail_last_data);

    }



    public function updateOrder($data)

    {

        $this->db->query('LOCK TABLES hd_submission WRITE,dt_submission WRITE,temp_submission WRITE,ms_supplier READ,ms_warehouse READ, user_account READ');

        $submission_id = $data['submission_id'];

        $save = ['success' => FALSE, 'submission_id' => 0];

        $getOrder = $this->getOrder($submission_id)->getRowArray();

        $submission_inv = $getOrder['submission_inv'];

        if ($getOrder != NULL) {

            if ($getOrder['submission_status'] == 'Pending') {

                $this->db->transBegin();

                $saveQueries = NULL;

                $user_id = $data['user_id'];

                unset($data['user_id']);

                $sqlDtOrder = "INSERT INTO dt_submission(detail_submission_product_name,detail_submission_inv,detail_submission_product_id,detail_submission_order_qty,detail_submission_status,detail_submission_desc,detail_submission_user_id) VALUES ";

                $sqlDtValues = [];

                $deleteItemId = [];

                $getTemp =  $this->db->table($this->table_temp_submission)->where('temp_submission_user_id', $user_id)->get();

                foreach ($getTemp->getResultArray() as $row) {

                    $detail_submission_product_name     = $row['temp_submission_product_name'];

                    $detail_submission_inv              = $submission_inv;

                    $detail_submission_product_id       = $row['temp_submission_product_id'];

                    $detail_submission_order_qty        = $row['temp_submission_order_qty'];

                    $detail_submission_status           = $row['temp_submission_status'];
                      
                    $detail_submission_desc             = $row['temp_submission_desc'];
                    
                    $detail_submission_user_id          = $row['temp_submission_user_id'];

                    $sqlDtValues[] = "('$detail_submission_product_name','$detail_submission_inv',$detail_submission_product_id,$detail_submission_order_qty,'$detail_submission_status','$detail_submission_desc','$detail_submission_user_id')";
                }

                $sqlDtOrder .= implode(',', $sqlDtValues);
                
                //$sqlDtOrder .= " ON DUPLICATE KEY UPDATE detail_submission_order_qty = VALUES(detail_submission_order_qty)";
               
                $this->db->table($this->table_hd_submission)->where('submission_id', $submission_id)->update($data);

                $query_text_header = $this->db->getLastQuery()->getQuery();

                $this->clearUpdateDetail($submission_inv);

                $this->db->query($sqlDtOrder);

                $logUpdate = [

                    'log_transaction_code'  => 'Submission',

                    'log_transaction_id' => $submission_id,

                    'log_user_id' => $user_id,

                    'log_remark' => 'EditSubmission',

                    'log_detail' => $sqlDtOrder,

                    'log_header' => $query_text_header

                ];

                $this->db->table($this->logUpdate)->insert($logUpdate);


                if ($this->db->transStatus() === false) {

                    $saveQueries = NULL;

                    $this->db->transRollback();

                    $save = ['success' => FALSE, 'submission_id' => 0];

                } else {

                    $this->db->transCommit();

                    $this->clearTemp($user_id);

                    $save = ['success' => TRUE, 'submission_id' => $submission_id];

                }

                $this->db->query('UNLOCK TABLES');

                 $data_save = saveQueries("EditSubmission", "EditSubmission", $submission_id);

            }

              return $save;
        }

    }


    
}
