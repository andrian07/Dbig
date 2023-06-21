<?php

namespace App\Models\Accounting;

use CodeIgniter\Model;

class M_accounting_queries extends Model
{

    protected $DBGroup = 'accounting';
    protected $hd_journal = 'hd_journal';
    protected $hd_cashout = 'hd_cashout';
    protected $dt_journal = 'dt_journal';
    protected $ms_account_api = 'ms_account_api';
    protected $temp_cashout = 'temp_cashout';
    protected $ms_payment_method = 'ms_payment_method';
    

    public function insertTempCashout($data)
    {
        $db = \Config\Database::connect($this->DBGroup);
        $exist = $this->db->table($this->temp_cashout)
        ->where('temp_cashout_id', $data['temp_cashout_id'])
        ->countAllResults();
        if ($exist > 0) {
            return $this->db->table($this->temp_cashout)
            ->where('temp_cashout_id', $data['temp_cashout_id'])
            ->update($data);
        } else {
            return $this->db->table($this->temp_cashout)->insert($data);
        }
    }

    public function getApiAccount($api_name)
    {
        $db = \Config\Database::connect($this->DBGroup);
        $builder = $this->db->table($this->ms_account_api);
        $builder->select('*');
        $builder->where('account_api_name', $api_name);
        return $builder->get();
    }

    public function getApiAccountBank($bank_name)
    {
        $db = \Config\Database::connect($this->DBGroup);
        $builder = $this->db->table($this->ms_payment_method);
        $builder->select('*');
        $builder->where('payment_method_id', $bank_name);
        return $builder->get();
    }

    public function getTempcashout($user_id)
    {
        $db = \Config\Database::connect($this->DBGroup);
        $builder = $this->db->table($this->temp_cashout);
        return $builder->select('temp_cashout.*,ms_account_group.group_code,ms_account.account_code,ms_account.account_name,ms_account.increase_in,ms_account.reduce_in')
        ->join('ms_account', 'ms_account.account_id=temp_cashout.temp_cashout_account_id')
        ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
        ->where('temp_cashout.temp_cashout_user_id', $user_id)
        ->orderBy('temp_cashout.temp_cashout_created_at', 'ASC')
        ->get();
    }

    public function clearTempJurnal($user_id)
    {
        $db = \Config\Database::connect($this->DBGroup);
        return $this->db->table($this->temp_cashout)
        ->where('temp_cashout_user_id', $user_id)
        ->delete();
    }

    public function clearTempCashout($user_id)
    {
        return $this->db->table($this->temp_cashout)
        ->where('temp_cashout_user_id', $user_id)
        ->delete();
    }


    public function insertJurnalApi($data)
    {
        //input journal//

        $db = \Config\Database::connect($this->DBGroup);

        $this->db->query('LOCK TABLES hd_journal WRITE, dt_journal WRITE');

        $this->db->transBegin();

        $store_code = $data['store_code'];
        $store_id = $data['cashout_store_id'];

        $journal_period = date("mY", strtotime($data['cashout_date']));
        $store_id = $data['cashout_store_id'];
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
            'journal_date'                => $data['cashout_date'],
            'journal_remark'              => $data['cash_out_remark'],
            'journal_debit_balance'       => $data['cashout_total_nominal'],
            'journal_credit_balance'      => $data['cashout_total_nominal'],
            'can_edit'                    => 'N',
            'user_id'                     => $data['cashout_created_by'],
        ];

        $this->db->table($this->hd_journal)->insert($data_hd_journal);

        $journal_id  = $this->db->insertID();

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }

        $sqlDtOrderJournal = "insert into dt_journal(journal_id,account_id,debit_balance,credit_balance) VALUES";

        $sqlDtValuesJournal = [];

        $getTemp =  $this->getTempcashout($data['cashout_created_by']);


        foreach ($getTemp->getResultArray() as $row) {

            $journal_id                  = $journal_id;
            $account_id                  = $row['temp_cashout_account_id'];
            $debit_balance               = $row['temp_cashout_nominal'];
            $credit_balance              = 0;

            $sqlDtValuesJournal[] = "('$journal_id','$account_id','$debit_balance','$credit_balance')";
        }

        $sqlDtOrderJournal .= implode(',', $sqlDtValuesJournal);

        $this->db->query($sqlDtOrderJournal);

        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        $data_dt_journal_bank = [
            'journal_id'                    => $journal_id,
            'account_id'                    => $data['cashout_account_id'],
            'debit_balance'                 => 0,
            'credit_balance'                => $data['cashout_total_nominal'],
        ];

        $this->db->table($this->dt_journal)->insert($data_dt_journal_bank);

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }
        if ($this->db->transStatus() === false) {

            $saveQueries = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'journal_id' => 0];

        } else {

            $this->db->transCommit();

            $this->clearTempJurnal($data['cashout_created_by']);

            $save = ['success' => TRUE, 'journal_id' => $journal_id ];

        }

        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'jurnalApi', $journal_id, 'jurnalApi_insert');

        return $save;

        // end input journal //
    }


    public function insertCashOut($data, $details = NULL)
    {
        $db = \Config\Database::connect($this->DBGroup);

        $this->db->query('LOCK TABLES hd_cashout WRITE, dt_cashout WRITE');

        $this->db->transBegin();

        $saveQueries = NULL;

        $maxCode = $this->db->table($this->hd_cashout)->select('cashout_id, cashout_code')->orderBy('cashout_id', 'desc')->limit(1)->get()->getRowArray();

        $cashout_date =  date_format(date_create($data['cashout_date']),"y/m");

        $store_code = $data['store_code'];

        $account_cash = $data['cashout_account_id'];


        if ($maxCode == NULL) {


            $data['cashout_code'] = 'CO/'.$store_code.'/'.$cashout_date.'/'.'0000000001';


        } else {


            $invoice = substr($maxCode['cashout_code'], -10);

            $data['cashout_code'] = 'CO/'.$store_code.'/'.$cashout_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);
        }

        unset($data['account_cash']);
        unset($data['store_code']);

        $this->db->table($this->hd_cashout)->insert($data);

        $cashout_id  = $this->db->insertID();


        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }

        $sqlDtOrder = "insert into dt_cashout(cashout_id,dt_cashout_account_id,dt_cashout_account_name,dt_cashout_nominal) VALUES";

        $sqlDtValues = [];

        $getTemp =  $this->getTempcashout($data['cashout_created_by']);


        foreach ($getTemp->getResultArray() as $row) {

            $cashout_id                  = $cashout_id;
            $dt_cashout_account_id       = $row['temp_cashout_account_id'];
            $dt_cashout_account_name     = $row['temp_cashout_account_name'];
            $dt_cashout_nominal          = $row['temp_cashout_nominal'];


            $sqlDtValues[] = "('$cashout_id','$dt_cashout_account_id','$dt_cashout_account_name','$dt_cashout_nominal')";
        }

        $sqlDtOrder .= implode(',', $sqlDtValues);

        $this->db->query($sqlDtOrder);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        //input journal//
        $journal_period = date("mY", strtotime($data['cashout_date']));
        $store_id = $data['cashout_store_id'];
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
            'journal_date'                => $data['cashout_date'],
            'journal_remark'              => $data['cash_out_remark'],
            'journal_debit_balance'       => $data['cashout_total_nominal'],
            'journal_credit_balance'      => $data['cashout_total_nominal'],
            'can_edit'                    => 'N',
            'user_id'                     => $data['cashout_created_by'],
        ];

        $this->db->table($this->hd_journal)->insert($data_hd_journal);

        $journal_id  = $this->db->insertID();

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }

        $data_update_journal_id = [
            'cashout_journal_ref_id'   => $journal_id,
        ];

        $this->db->table($this->hd_cashout)->where('cashout_id', $cashout_id)->update($data_update_journal_id);

        $sqlDtOrderJournal = "insert into dt_journal(journal_id,account_id,debit_balance,credit_balance) VALUES";

        $sqlDtValuesJournal = [];

        $getTemp =  $this->getTempcashout($data['cashout_created_by']);


        foreach ($getTemp->getResultArray() as $row) {

            $journal_id                  = $journal_id;
            $account_id                  = $row['temp_cashout_account_id'];
            $debit_balance               = $row['temp_cashout_nominal'];
            $credit_balance              = 0;

            $sqlDtValuesJournal[] = "('$journal_id','$account_id','$debit_balance','$credit_balance')";
        }

        $sqlDtOrderJournal .= implode(',', $sqlDtValuesJournal);

        $this->db->query($sqlDtOrderJournal);

        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        $data_dt_journal_bank = [
            'journal_id'                    => $journal_id,
            'account_id'                    => $account_cash,
            'debit_balance'                 => 0,
            'credit_balance'                => $data['cashout_total_nominal'],
        ];

        $this->db->table($this->dt_journal)->insert($data_dt_journal_bank);

        if ($this->db->affectedRows() > 0) {

            $saveQueries[] = $this->db->getLastQuery()->getQuery();

        }

        // end input journal //

        if ($this->db->transStatus() === false) {

            $saveQueries = NULL;

            $this->db->transRollback();

            $save = ['success' => FALSE, 'cashout_id' => 0];

        } else {

            $this->db->transCommit();

            $this->cleartempCashout($data['cashout_created_by']);

            $save = ['success' => TRUE, 'cashout_id' => $cashout_id ];

        }

        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'CashOut', $cashout_id, 'cashout_insert');

        return $save;
    }

}
