<?php

namespace App\Models\Accounting;

use CodeIgniter\Model;

class M_accounting_queries extends Model
{

    protected $DBGroup = 'accounting';
    protected $hd_journal = 'hd_journal';
    protected $hd_cashout = 'hd_cashout';
    protected $dt_cashout = 'dt_cashout';
    protected $hd_cashin = 'hd_cashin';
    protected $dt_cashin = 'dt_cashin';
    protected $ms_payment_method = 'ms_payment_method';
    

    public function insert_journal($data, $data_dt)
    {
        $db = \Config\Database::connect($this->DBGroup);
        $this->db->query('LOCK TABLES hd_journal WRITE, dt_journal WRITE, last_record_number WRITE');
        $this->db->transBegin();
        $store_code = $data['store_code'];
        $store_id = $data['store_id'];
        $journal_period = date("mY", strtotime($data['trx_date']));
        $_yy = substr($journal_period, -2);
        $_mm = substr($journal_period, 0, 2);
        $getLastNumber = $this->db->table('last_record_number')
        ->where('record_module', 'journal_code')
        ->where('record_period', $journal_period)
        ->where('store_id', $store_id)
        ->get()->getRowArray();
       
        if ($getLastNumber == NULL) {
            $journal_code  = 'JU/' . $store_code . "/$_yy/$_mm/" .  '000001';
            $update_last_number = [
                'record_module' => 'journal_code',
                'store_id'      => $store_id,
                'record_period' => $journal_period,
                'last_number'   => 1
            ];
            $sqlUpdateLastNumber = $this->db->table('last_record_number')->set($update_last_number)->getCompiledInsert();
        } else {
            $new_number = strval(intval($getLastNumber['last_number']) + 1);
            $journal_code  = 'JU/' . $store_code . "/$_yy/$_mm/" .   substr('000000' . $new_number, -6);
            $update_last_number = [
                'record_module' => 'journal_code',
                'store_id'      => $store_id,
                'record_period' => $journal_period,
                'last_number'   => $new_number
            ];
            $sqlUpdateLastNumber = $this->db->table('last_record_number')->set($update_last_number)->where('record_id', $getLastNumber['record_id'])->getCompiledUpdate();
        }
        $this->db->query($sqlUpdateLastNumber);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }
        $data_hd_journal = [
            'journal_code'                => $journal_code,
            'store_id'                    => $store_id,
            'journal_period'              => $journal_period,
            'journal_date'                => $data['trx_date'],
            'journal_remark'              => $data['remark'],
            'journal_debit_balance'       => $data['debit_balance'],
            'journal_credit_balance'      => $data['credit_balance'],
            'can_edit'                    => 'N',
            'user_id'                     => 1,
        ];
        $this->db->table($this->hd_journal)->insert($data_hd_journal);
        $journal_id  = $this->db->insertID();
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }
        $sqlDtJournal = "insert into dt_journal(journal_id,account_id,debit_balance,credit_balance) VALUES";
        $sqlDtValues = [];
        foreach ($data_dt as $row) {
            $journal_id           = $journal_id;
            $account_id           = $row['account_id'];
            $debit_balance        = $row['debit_balance'];
            $credit_balance       = $row['credit_balance'];
    
            $sqlDtValues[] = "('$journal_id','$account_id','$debit_balance','$credit_balance')";
        }
        $sqlDtJournal .= implode(',', $sqlDtValues);
        $this->db->query($sqlDtJournal);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }
        if ($this->db->transStatus() === false) {
            $saveQueries = NULL;
            $this->db->transRollback();
            $save = ['success' => FALSE, 'journal_id' => 0];
        } else {
            $this->db->transCommit();
            $save = ['success' => TRUE, 'journal_id' => $journal_id ];
        }
        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'jurnalApi', $journal_id, 'jurnalApi_insert');
        return $save;
    }
    
    public function insert_cashout($data, $data_dt)
    {
        $db = \Config\Database::connect($this->DBGroup);
        $this->db->query('LOCK TABLES hd_cashout WRITE, dt_cashout WRITE');
        $this->db->transBegin();
        $maxCode = $this->db->table($this->hd_cashout)->select('cashout_id, cashout_code')->orderBy('cashout_id', 'desc')->limit(1)->get()->getRowArray();
        $cashout_date =  date_format(date_create($data['cashout_date']),"y/m");
        $store_code = $data['cashout_store_code'];
        if ($maxCode == NULL) {
            $data['cashout_code'] = 'CO/'.$store_code.'/'.$cashout_date.'/'.'0000000001';
        } else {
            $invoice = substr($maxCode['cashout_code'], -10);
            $data['cashout_code'] = 'CO/'.$store_code.'/'.$cashout_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);
        }

        $data_hd_cashout = [
                    'cashout_code'             => $data['cashout_code'],
                    'cashout_store_id'         => $data['cashout_store_id'],
                    'cashout_account_id'       => $data['cashout_account_id'],
                    'cashout_recipient_id'     => $data['cashout_recipient_id'],
                    'cashout_recipient_name'   => $data['cashout_recipient_name'],
                    'cashout_date'             => $data['cashout_date'],
                    'cashout_ref'              => $data['cashout_ref'],
                    'cashout_journal_ref_id'   => $data['cashout_journal_ref_id'],
                    'cashout_total_nominal'    => $data['cashout_total_nominal'],
                    'cashout_type'             => $data['cashout_type'],
                    'cash_out_remark'          => $data['cash_out_remark'],
                    'cashout_created_by'       => $data['cashout_created_by']
        ];
        $this->db->table($this->hd_cashout)->insert($data_hd_cashout);
        $cashout_id  = $this->db->insertID();
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }
        
        $data_dt_cashout = [
            'cashout_id'                => $cashout_id,
            'dt_cashout_account_id'     => $data_dt['dt_cashout_account_id'],
            'dt_cashout_account_name'   => $data_dt['dt_cashout_account_name'],
            'dt_cashout_nominal'        => $data_dt['dt_cashout_nominal']
        ];
        $this->db->table($this->dt_cashout)->insert($data_dt_cashout);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }
        if ($this->db->transStatus() === false) {
            $saveQueries = NULL;
            $this->db->transRollback();
            $save = ['success' => FALSE, 'cashout_id' => 0];
        } else {
            $this->db->transCommit();
            $save = ['success' => TRUE, 'cashout_id' => $cashout_id ];
        }
        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'cashoutApi', $cashout_id, 'cashoutApi_insert');
        return $save;
    }

    public function insert_cashin($data, $data_dt)
    {
        $db = \Config\Database::connect($this->DBGroup);
        $this->db->query('LOCK TABLES hd_cashin WRITE, dt_cashin WRITE');
        $this->db->transBegin();
        $maxCode = $this->db->table($this->hd_cashin)->select('cashin_id, cashin_code')->orderBy('cashin_id', 'desc')->limit(1)->get()->getRowArray();
        $cashin_date =  date_format(date_create($data['cashin_date']),"y/m");
        $store_code = $data['cashin_store_code'];
        if ($maxCode == NULL) {
            $data['cashin_code'] = 'CO/'.$store_code.'/'.$cashin_date.'/'.'0000000001';
        } else {
            $invoice = substr($maxCode['cashin_code'], -10);
            $data['cashin_code'] = 'CO/'.$store_code.'/'.$cashin_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);
        }

        $data_hd_cashin = [
                    'cashin_code'             => $data['cashin_code'],
                    'cashin_store_id'         => $data['cashin_store_id'],
                    'cashin_account_id'       => $data['cashin_account_id'],
                    'cashin_recipient_id'     => $data['cashin_recipient_id'],
                    'cashin_recipient_name'   => $data['cashin_recipient_name'],
                    'cashin_date'             => $data['cashin_date'],
                    'cashin_ref'              => $data['cashin_ref'],
                    'cashin_journal_ref_id'   => $data['cashin_journal_ref_id'],
                    'cashin_total_nominal'    => $data['cashin_total_nominal'],
                    'cashin_type'             => $data['cashin_type'],
                    'cash_in_remark'          => $data['cash_in_remark'],
                    'cashin_created_by'       => $data['cashin_created_by']
        ];
        $this->db->table($this->hd_cashin)->insert($data_hd_cashin);
        $cashin_id  = $this->db->insertID();
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }
        $data_dt_cashin = [
            'cashin_id'                => $cashin_id,
            'dt_cashin_account_id'     => $data_dt['dt_cashin_account_id'],
            'dt_cashin_account_name'   => $data_dt['dt_cashin_account_name'],
            'dt_cashin_nominal'        => $data_dt['dt_cashin_nominal']
        ];
        $this->db->table($this->dt_cashin)->insert($data_dt_cashin);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }
        if ($this->db->transStatus() === false) {
            $saveQueries = NULL;
            $this->db->transRollback();
            $save = ['success' => FALSE, 'cashout_id' => 0];
        } else {
            $this->db->transCommit();
            $save = ['success' => TRUE, 'cashout_id' => $cashin_id ];
        }
        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'cashinApi', $cashin_id, 'cashinApi_insert');
        return $save;
    }
    


    public function getaccount_bank($payment_method){

        $builder = $this->db->table($this->ms_payment_method);

        return $builder->select('ms_account.account_id, ms_account.account_name')

        ->join('ms_account', 'ms_account.account_id = ms_payment_method.account_id')

        ->where('payment_method_id', $payment_method)

        ->get();
    }

    public function cancel_cashout($payment_debt_invoice)
    {

        $sqlupdate = "update hd_cashout set cashout_is_deleted = 'Y' where cashout_ref = '".$payment_debt_invoice."'";

        $this->db->query($sqlupdate);
    }
    public function cancel_journal($payment_debt_invoice)
    {

        $sqlupdate = "update hd_journal set deleted = 'Y' where journal_remark like '%".$payment_debt_invoice."%'";

        $this->db->query($sqlupdate);

    }


}
