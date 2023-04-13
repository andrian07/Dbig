<?php

namespace App\Models;

use CodeIgniter\Model;

class M_submission extends Model
{
    protected $table_temp_submission = 'temp_submission';
    protected $table_hd_submission   = 'hd_submission';
    protected $table_warehouse       = 'ms_warehouse';
    protected $log_queries           = 'hd_log_queries';


    public function getSubmissiondetaildata($submission_id){

        $builder = $this->db->table($this->table_hd_submission);

        return $builder->select('*, hd_submission.created_at as created_at')

        ->join('ms_product_unit', 'ms_product_unit.item_id = hd_submission.submission_item_id')

        ->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

        ->join('ms_product_supplier', 'ms_product_supplier.product_id = ms_product.product_id')

        ->join('user_account', 'user_account.user_id = hd_submission.submission_user_id')

        ->join('ms_warehouse', 'ms_warehouse.warehouse_id = hd_submission.submission_warehouse_id')

        ->join('ms_salesman', 'ms_salesman.salesman_id = hd_submission.submission_salesman_id')

        ->where('submission_id', $submission_id)

        ->get();
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
        $save = $this->db->table($this->table_hd_submission)->update(['submission_status' => 'Decline', 'submission_admin_remark' => $input['submission_admin_remark']], ['submission_id ' => $input['submission_id_decline']]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'declinesubmission', $input['submission_id_decline']);
        return $save;
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

        $saveQueries = $this->db->getLastQuery()->getQuery();

        $submission_id = $this->db->insertID();

        if ($this->db->transStatus() === false) {

            $saveQueries = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'submission_id' => 0];

        } else {

            $this->db->transCommit();

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

    public function updateOrder($data)

    {

        $this->db->query('LOCK TABLES hd_submission WRITE,ms_supplier READ,ms_warehouse READ, user_account READ');

        $saveQueries = $this->db->table($this->table_hd_submission)->update($data, ['submission_id' => $data['submission_id']]);

        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }

        if ($this->db->transStatus() === false) {

            $saveQueries = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'submission_id' => 0];

        } else {

            $this->db->transCommit();

            $save = ['success' => TRUE, 'submission_id' => $data['submission_id']];

        }
        
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'EditSubmission', $data['submission_id']);

        return $save;

    }


    
}
