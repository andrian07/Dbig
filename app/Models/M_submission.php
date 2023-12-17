<?php

namespace App\Models;

use CodeIgniter\Model;

class M_submission extends Model
{
    protected $table_temp_submission = 'temp_submission';
    protected $table_hd_submission   = 'hd_submission';
    protected $table_dt_submission   = 'dt_submission';
    protected $table_warehouse       = 'ms_warehouse';
    protected $log_queries           = 'hd_log_queries';
    protected $table_list_purchase_order   = 'list_purchase_order';
    protected $table_product_unit    = 'ms_product_unit';
    protected $list_auto_po = 'list_auto_po';

    

    public function getOrder($submission_id = '')
    {

        $builder = $this->db->table($this->table_hd_submission);

        $builder->select('hd_submission.*,dt_submission.*,supplier_name, salesman_name, user_account.user_realname, warehouse_name, hd_submission.created_at as created_at');

        $builder->join('dt_submission', 'dt_submission.dt_hd_submision_id = hd_submission.submission_id');

        $builder->join('ms_salesman', 'ms_salesman.salesman_id = hd_submission.submission_salesman_id');

        $builder->join('user_account', 'user_account.user_id = hd_submission.submission_user_id');

        $builder->join('ms_supplier', 'ms_supplier.supplier_id  = hd_submission.submission_supplieR_id');

        $builder->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_submission.submission_warehouse_id');

        if ($submission_id  != '') {

            $builder->where(['hd_submission.submission_id' => $submission_id ]);

        }

        return $builder->get();
    }

    public function insertTemp($data)
    {

        $exist = $this->db->table($this->table_temp_submission)

        ->where('temp_submission_item_id', $data['temp_submission_item_id'])

        ->where('temp_submission_user_id', $data['temp_submission_user_id'])

        ->countAllResults();


        if ($exist > 0) {

            return $this->db->table($this->table_temp_submission)

            ->where('temp_submission_item_id', $data['temp_submission_item_id'])

            ->where('temp_submission_user_id', $data['temp_submission_user_id'])

            ->update($data);

        } else {

            $this->db->table($this->table_temp_submission)->where('temp_submission_user_id', $data['temp_submission_user_id'])->where('temp_submission_item_id', $data['temp_submission_item_id'])->delete();

            return $this->db->table($this->table_temp_submission)->insert($data);

        }

    }


    public function getSubmissiondetaildata($submission_id){

        $builder = $this->db->table($this->table_hd_submission);

        return $builder->select('*, hd_submission.created_at as created_at')

        ->join('dt_submission', 'dt_submission.dt_hd_submision_id = hd_submission.submission_id')

        ->join('ms_product_unit', 'ms_product_unit.item_id = dt_submission.dt_submission_item_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_product_supplier', 'ms_product_supplier.product_id = ms_product.product_id')

        ->join('user_account', 'user_account.user_id = hd_submission.submission_user_id')

        ->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_submission.submission_warehouse_id')

         ->join('ms_supplier', 'ms_supplier.supplier_id = hd_submission.submission_supplier_id')

        ->join('ms_salesman', 'ms_salesman.salesman_id = hd_submission.submission_salesman_id')

        ->where('submission_id', $submission_id)

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

    public function declineOrder($input){
        $this->db->query('LOCK TABLES hd_submission WRITE');
        $save = $this->db->table($this->table_hd_submission)->update(['submission_status' => 'Decline', 'submission_admin_remark_cancel' => $input['submission_admin_remark_cancel']], ['submission_id ' => $input['submission_id_decline']]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'declinesubmission', $input['submission_id_decline']);
        return $save;
    }

    public function insertSubmissiontemp($input_temp)
    {   

        $item_id = $input_temp['temp_submission_item_id'];

        $supplier_id = $this->db->table($this->table_product_unit)->select('supplier_id')->join('ms_product_supplier','ms_product_supplier.product_id = ms_product_unit.product_id')->get()->getRowArray();

        $temp_submission_item_id        = $input_temp['temp_submission_item_id'];
        $temp_submission_qty            = $input_temp['temp_submission_qty'];
        $user_id                        = $input_temp['temp_submission_user_id'];
        $temp_submission_supplier_id    = $supplier_id['supplier_id'];

        $sqlTempSubmision = "insert into temp_submission(temp_submission_item_id,temp_submission_qty,temp_submission_supplier_id,temp_submission_user_id) VALUES";

        $sqlDtValues[] = "('$temp_submission_item_id','$temp_submission_qty','$temp_submission_supplier_id','$user_id')";

        $sqlTempSubmision .= implode(',', $sqlDtValues);

        $this->db->query($sqlTempSubmision);

        return $supplier_id['supplier_id'];

    }

    public function insertSubmission($data)
    {

        $this->db->query('LOCK TABLES hd_submission Write');

        $this->db->transBegin();

        $saveQueries = NULL;



        $maxCode = $this->db->table($this->table_hd_submission)->select('submission_id, submission_inv')->orderBy('submission_id', 'desc')->limit(1)->get()->getRowArray();



        $warehouse_code = $this->db->table($this->table_warehouse)->select('warehouse_code')->where('warehouse_id', $data['submission_warehouse_id'])->get()->getRowArray();

        $invoice_date =  date_format(date_create($data['submission_date']),"y/m/d");

        if ($maxCode == NULL) {

            $data['submission_inv'] = 'PJ/'.$warehouse_code['warehouse_code'].'/'.$invoice_date.'/'.'0000000001';

        } else {

            $invoice = substr($maxCode['submission_inv'], -10);

            $data['submission_inv'] = 'PJ/'.$warehouse_code['warehouse_code'].'/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);
            
        }

        $this->db->table($this->table_hd_submission)->insert($data);

        $saveQueries[] = $this->db->getLastQuery()->getQuery();

        $submission_id = $this->db->insertID();


        $sqlDtSubmision = "insert into dt_submission(dt_hd_submision_id,dt_submission_item_id,dt_submission_qty) VALUES";

        $sqlDtValues = [];

        $getTemp =  $this->db->table($this->table_temp_submission)->where('temp_submission_user_id', $data['submission_user_id'])->get();


        foreach ($getTemp->getResultArray() as $row) {

            $dt_submission_item_id           = $row['temp_submission_item_id'];
            $dt_submission_qty               = $row['temp_submission_qty'];

            $sqlDtValues[] = "('$submission_id','$dt_submission_item_id','$dt_submission_qty')";
        }

        $sqlDtSubmision .= implode(',', $sqlDtValues);
        
        $this->db->query($sqlDtSubmision);

        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }


        if ($this->db->transStatus() === false) {

            $saveQueries = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'submission_id' => 0];

        } else {

            $this->db->transCommit();

            $this->clearTemp($data['submission_user_id']);

            $save = ['success' => TRUE, 'submission_id' => $submission_id];

        }

        if ($this->db->affectedRows() > 0) {

            $saveQueries = [

                'query_text'    => $this->db->getLastQuery()->getQuery(),

                'ref_id'        => $submission_id

            ];

        }

        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'Submission', $submission_id);

        return $save;

    }


    public function clearTemp($user_id)
    {
        return $this->db->table($this->table_temp_submission)
        ->where('temp_submission_user_id', $user_id)
        ->delete();
    }

    public function getLogEditOrder($submission_id = '')

    {

        $builder = $this->db->table($this->log_queries);

        $builder->select('*');

        $builder->join('user_account', 'user_account.user_id=hd_log_queries.user_id');

        $builder->join('dt_log_queries', 'dt_log_queries.log_id = hd_log_queries.log_id');

        if ($submission_id  != '') {

            $builder->where('ref_id', $submission_id);

        }

        $builder->where('module', 'EditSubmission');

        $builder->orderBy('detail_id', 'ASC');

        return $builder->get();

    }

    public function saveLastData($submission_id, $input_detail_last_data)
    {
        saveEditQueries('submission',$submission_id, $input_detail_last_data);

    }


    public function checkNullItem($submission_id = '')
    {
        $builder = $this->db->table($this->table_hd_submission);

        $builder->select('*');

        $builder->where(['submission_id' => $submission_id]);

        $builder->where(['submission_item_id' => 0 ]);

        return $builder->get();
    }

    public function checkSupplier()
    {
        $builder = $this->db->table($this->table_hd_submission);

        $builder->select('*');

        $builder->where(['submission_id' => $submission_id]);

        $builder->where(['submission_item_id' => 0 ]);

        return $builder->get();
    }
    

    public function getTemp($user_id)
    {
        $builder = $this->db->table($this->table_temp_submission);

        return $builder->select('*')

        ->join('ms_product_unit', 'ms_product_unit.item_id = temp_submission.temp_submission_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

        ->where('temp_submission.temp_submission_user_id', $user_id)

        ->orderBy('temp_submission.temp_submission_update_at', 'ASC')

        ->get();
    }

    public function updateOrder($data)
    {

        $this->db->query('LOCK TABLES hd_submission WRITE, dt_submission WRITE, temp_submission WRITE, ms_supplier READ, ms_warehouse READ, user_account READ, ms_salesman READ');

        $submission_id = $data['submission_id'];

        $save = ['success' => FALSE, 'submission_id' => 0];

        $getOrder = $this->getOrder($submission_id)->getRowArray();

        if ($getOrder != NULL) {

            if ($getOrder['submission_status'] == 'Pending') {

                $this->db->transBegin();

                $saveQueries = NULL;

                $user_id = $data['submission_user_id'];

                unset($data['submission_user_id']);

                $sqlDtOrder = "INSERT INTO dt_submission(dt_hd_submision_id,dt_submission_item_id,dt_submission_qty) VALUES ";

                $sqlDtValues = [];

                $deleteItemId = [];

                $getTemp =  $this->db->table($this->table_temp_submission)->where('temp_submission_user_id', $user_id)->get();

                foreach ($getTemp->getResultArray() as $row) {

                    $dt_hd_submision_id               = $submission_id;

                    $dt_submission_item_id            = $row['temp_submission_item_id'];

                    $dt_submission_qty                = $row['temp_submission_qty'];

                    $sqlDtValues[] = "('$dt_hd_submision_id','$dt_submission_item_id','$dt_submission_qty')";
                }

                $sqlDtOrder .= implode(',', $sqlDtValues);

                //$sqlDtOrder .= " ON DUPLICATE KEY UPDATE dt_hd_submision_id = VALUES($dt_hd_submision_id)";

                //print_r($data);die();

                $this->db->table($this->table_hd_submission)->where('submission_id', $submission_id)->update($data);

                $query_text_header = $this->db->getLastQuery()->getQuery();

                $this->db->table($this->table_dt_submission)->where('dt_hd_submision_id', $submission_id)->delete();

                $this->db->query($sqlDtOrder);


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

                $data_save = saveQueries("Submision", "EditSubmision", $submission_id);

            }

            return $save;
        }
    }

    public function copyDtSubmisionToTemp($datacopy)
    {
        $user_id = $datacopy['user_id'];
        $submission_id = $datacopy['submission_id'];
        $supplier_id = $datacopy['temp_submission_supplier_id'];
        $supplier_name = $datacopy['temp_submission_supplier_name'];
        $salesman_id = $datacopy['temp_submission_salesman_id'];
        $salesman_name = $datacopy['temp_submission_salesman_name'];
        $warehouse_id = $datacopy['temp_submission_warehouse_id'];
        $warehouse_name = $datacopy['temp_submission_warehouse_name'];
        $submission_status = $datacopy['temp_submission_status'];

        $this->clearTemp($user_id);

        $sqlText = "insert into temp_submission(temp_submission_item_id,temp_submission_item_name,temp_submission_qty,temp_submission_supplier_id,temp_submission_supplier_name,temp_submission_salesman_id,temp_submission_salesman_name,temp_submission_warehouse_id,temp_submission_warehouse_name,temp_submission_user_id) ";

        $sqlText .= "select dt_submission_item_id, product_name, dt_submission_qty,'".$supplier_id."' as supplier_id,'".$supplier_name."' as supplier_name,'".$salesman_id."' as salesman_id,'".$salesman_name."' as salesman_name, '".$warehouse_id."' as warehouse_id,'".$warehouse_name."' as warehouse_name,'".$user_id."' as user_id";

        $sqlText .= " FROM dt_submission, ms_product_unit, ms_product WHERE dt_submission.dt_submission_item_id = ms_product_unit.item_id and ms_product_unit.product_id = ms_product.product_id and dt_hd_submision_id = '$submission_id'";

        $this->db->query($sqlText);

        return $this->getTemp($user_id);
    }

    public function updateNotif($product_id)
    {

        $this->db->query('LOCK TABLES list_purchase_order WRITE');

        $saveQueries = $this->db->table($this->table_list_purchase_order)->update(['status' => 'Success'], ['product_id ' => $product_id]);

        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }

        if ($this->db->transStatus() === false) {

            $saveQueries = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'submission_id' => 0];

        } else {

            $this->db->transCommit();

            $save = ['success' => TRUE, 'product_id' => $product_id];

        }
        
        $this->db->query('UNLOCK TABLES');

        return $save;

    }

    public function updatestatuslist($product_id)
    {
        $this->db->query('LOCK TABLES list_auto_po WRITE');

        $saveQueries = $this->db->table($this->list_auto_po)->update(['status' => 'Success'], ['product_id ' => $product_id]);

        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }

        if ($this->db->transStatus() === false) {

            $saveQueries = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'product_id' => 0];

        } else {

            $this->db->transCommit();

            $save = ['success' => TRUE, 'product_id' => $product_id];

        }
        
        $this->db->query('UNLOCK TABLES');

        return $save;
    }
    

    


    
}
