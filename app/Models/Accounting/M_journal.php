<?php

namespace App\Models\Accounting;

use CodeIgniter\Model;

class M_journal extends Model
{
    protected $DBGroup = 'accounting';
    protected $table = 'hd_journal';
    protected $dt_journal = 'dt_journal';
    protected $tempJournal = 'temp_journal';

    public function getJournal($journal_id = '')
    {
        $builder = $this->db->table($this->table);
        $builder->select('hd_journal.*,user_account.user_realname');
        $builder->join('user_account', 'user_account.user_id=hd_journal.user_id');

        if ($journal_id != '') {
            $builder->where('hd_journal.journal_id', $journal_id);
        }

        return $builder->get();
    }

    public function getDtJournal($journal_id = '')
    {
        $builder = $this->db->table($this->dt_journal);
        $builder->select('dt_journal.*,ms_account.account_code,ms_account_group.group_code,ms_account.account_name');
        $builder->join('ms_account', 'ms_account.account_id=dt_journal.account_id');
        $builder->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id');

        if ($journal_id != '') {
            $builder->where('dt_journal.journal_id', $journal_id);
        }
        $builder->orderBy('debit_balance', 'desc');
        return $builder->get();
    }


    public function insertJournal($data, $details = NULL, $return_journal_id = FALSE)
    {
        $save = 1;
        $saveQueries = NULL;
        $this->db->query('LOCK TABLES last_record_number WRITE,hd_journal WRITE,dt_journal WRITE,temp_journal READ,ms_account READ,ms_account_group READ');

        if ($details == NULL) {
            $details = $this->getTemp($data['user_id'])->getResultArray();
        }

        if (count($details) > 0) {
            $journal_period = $data['journal_period'];
            $store_id       = $data['store_id'];
            $store_code     = $data['store_code'];
            unset($data['store_code']);

            $_yy = substr($data['journal_period'], -2);
            $_mm = substr($data['journal_period'], 0, 2);

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

            $this->db->transBegin();

            $data['journal_code'] = $journal_code;
            $this->db->table($this->table)->insert($data);
            $journal_id = $this->db->insertID();

            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }

            $qDtJournal = "INSERT INTO dt_journal(journal_id,account_id,debit_balance,credit_balance) VALUES";
            $vDtJournal = [];

            foreach ($details as $row) {
                $account_id     = $row['account_id'];
                $debit_balance  = floatval($row['debit_balance']);
                $credit_balance = floatval($row['credit_balance']);

                $vDtJournal[] = "('$journal_id','$account_id',$debit_balance,$credit_balance)";
            }
            $qDtJournal .= implode(',', $vDtJournal);

            $this->db->query($qDtJournal);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }

            $this->db->query($sqlUpdateLastNumber);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }

            if ($this->db->transStatus() === false) {
                $saveQueries = NULL;
                $this->db->transRollback();
                $save = 0;
            } else {
                $this->db->transCommit();
                $this->clearTemp($data['user_id']);
                $save = 1;
                //MODIFY SAVE RETURN JOURNAL ID
                if ($return_journal_id) {
                    $save = $journal_id;
                }
            }
        } else {
            $save = 0;
        }


        $this->db->query('UNLOCK TABLES');
        //saveQueries($saveQueries, 'journal', $journal_id, 'add');
        return $save;
    }

    public function updateJournal($data)
    {
        $save = 0;
        $saveQueries = NULL;
        $this->db->query('LOCK TABLES hd_journal WRITE,dt_journal WRITE,temp_journal READ,ms_account READ,ms_account_group READ');
        $details = $this->getTemp($data['user_id'])->getResultArray();
        $journal_id = $data['journal_id'];

        $delete_id          = [];
        $qUpdateDtJournal   = "INSERT INTO dt_journal(detail_id,journal_id,account_id,debit_balance,credit_balance) VALUES";
        $qAddDtJournal      = "INSERT INTO dt_journal(journal_id,account_id,debit_balance,credit_balance) VALUES";

        $vAddDtJournal = [];
        $vUpdateDtJournal = [];

        foreach ($details as $row) {
            $detail_id      = $row['detail_id'];
            $account_id     = $row['account_id'];
            $debit_balance  = floatval($row['debit_balance']);
            $credit_balance = floatval($row['credit_balance']);

            if ($row['temp_delete'] == 'N') {
                if ($row['temp_add'] == 'N') {
                    $vUpdateDtJournal[] = "('$detail_id','$journal_id','$account_id',$debit_balance,$credit_balance)";
                } else {
                    $vAddDtJournal[] = "('$journal_id','$account_id',$debit_balance,$credit_balance)";
                }
            } else {
                $delete_id[] = $detail_id;
            }
        }

        $qUpdateDtJournal .= implode(',', $vUpdateDtJournal) . ' ON DUPLICATE KEY UPDATE account_id=VALUES(account_id),debit_balance=VALUES(debit_balance),credit_balance=VALUES(credit_balance)';
        $qAddDtJournal .= implode(',', $vAddDtJournal);

        $this->db->transBegin();

        $this->db->table($this->table)->where('journal_id', $journal_id)->update($data);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }


        if (count($vUpdateDtJournal) > 0) {
            $this->db->query($qUpdateDtJournal);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }
        }


        if (count($vAddDtJournal) > 0) {
            $this->db->query($qAddDtJournal);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }
        }


        if (count($delete_id) > 0) {
            $this->db->table('dt_journal')->whereIn('detail_id', $delete_id)->delete();
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }
        }

        if ($this->db->transStatus() === false) {
            $saveQueries = NULL;
            $this->db->transRollback();
            $save = 0;
        } else {
            $this->db->transCommit();
            $this->clearTemp($data['user_id']);
            $save = 1;
        }

        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'journal', $journal_id, 'edit');
        return $save;
    }

    public function deleteJournal($journal_id)
    {
        $save = 0;
        $saveQueries = NULL;
        $this->db->query('LOCK TABLES hd_journal WRITE,dt_journal WRITE');
        $this->db->transBegin();

        $this->db->table('hd_journal')->where('journal_id', $journal_id)->set('deleted', 'Y')->update();
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        if ($this->db->transStatus() === false) {
            $saveQueries = NULL;
            $this->db->transRollback();
            $save = 0;
        } else {
            $this->db->transCommit();
            $save = 1;
        }

        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'journal', $journal_id, 'delete');
        return $save;
    }

    public function copyDtJournalToTemp($journal_id, $user_id)
    {
        $this->clearTemp($user_id);
        $this->db->query("LOCK TABLES dt_journal WRITE,temp_journal WRITE");
        $data_journal = [];
        $getDtJournal = $this->db->table($this->dt_journal)->where('journal_id', $journal_id)->orderBy('debit_balance', 'desc')->get()->getResultArray();
        foreach ($getDtJournal as $row) {
            $detail_id      =  $row['detail_id'];
            $account_id     =  $row['account_id'];
            $debit_balance  =  floatval($row['debit_balance']);
            $credit_balance =  floatval($row['credit_balance']);
            $temp_key       =  md5($detail_id . $account_id . $user_id . date('YmdHis'));
            $data_journal[] = [
                'temp_key'          => $temp_key,
                'account_id'        => $account_id,
                'debit_balance'     => $debit_balance,
                'credit_balance'    => $credit_balance,
                'detail_id'         => $detail_id,
                'temp_add'          => 'N',
                'temp_delete'       => 'N',
                'user_id'           => $user_id
            ];
        }

        $this->db->table('temp_journal')->insertBatch($data_journal);
        $this->db->query('UNLOCK TABLES');

        return $this->getTemp($user_id);
    }

    public function getTemp($user_id)
    {
        $builder = $this->db->table($this->tempJournal);
        return $builder->select('temp_journal.*,ms_account_group.group_code,ms_account.account_code,ms_account.account_name,ms_account.increase_in,ms_account.reduce_in')
            ->join('ms_account', 'ms_account.account_id=temp_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('temp_journal.user_id', $user_id)
            ->orderBy('temp_journal.created_at', 'ASC')
            ->get();
    }

    public function clearTemp($user_id)
    {
        return $this->db->table($this->tempJournal)
            ->where('user_id', $user_id)
            ->delete();
    }

    public function insertTemp($data)
    {
        $exist = $this->db->table($this->tempJournal)
            ->where('temp_key', $data['temp_key'])
            ->where('user_id', $data['user_id'])
            ->countAllResults();

        $data['temp_delete'] = 'N';
        if ($exist > 0) {
            return $this->db->table($this->tempJournal)
                ->where('temp_key', $data['temp_key'])
                ->where('user_id', $data['user_id'])
                ->update($data);
        } else {
            $data['detail_id']  = 0;
            $data['temp_add']   = 'Y';
            return $this->db->table($this->tempJournal)->insert($data);
        }
    }

    public function deleteTemp($temp_key, $user_id)
    {
        $getData = $this->db->table($this->tempJournal)
            ->where('temp_key', $temp_key)
            ->where('user_id', $user_id)
            ->get()->getRowArray();

        if ($getData == NULL) {
            return 0;
        } else {
            if ($getData['temp_add'] == 'Y') {
                return $this->db->table($this->tempJournal)
                    ->where('temp_key', $temp_key)
                    ->where('user_id', $user_id)
                    ->delete();
            } else {
                return $this->db->table($this->tempJournal)
                    ->where('temp_key', $temp_key)
                    ->where('user_id', $user_id)
                    ->update(['temp_delete' => 'Y']);
            }
        }


        return $this->db->table($this->tempJournal)
            ->where('temp_key', $temp_key)
            ->where('user_id', $user_id)
            ->delete();
    }

    /* report  journal */

    public function getJournalByPeriod($journal_period, $store_id)
    {
        $builder = $this->db->table('dt_journal');
        $builder->select('dt_journal.account_id,hd_journal.journal_id,hd_journal.journal_code,hd_journal.journal_date,hd_journal.journal_period,hd_journal.journal_remark,ms_account.account_code,ms_account.account_name,ms_account_group.group_code,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('hd_journal.journal_period', $journal_period)
            ->where('hd_journal.store_id',  $store_id)
            ->where('hd_journal.deleted',  'N');
        return  $builder->orderBy('hd_journal.journal_date,dt_journal.journal_id', 'ASC')->get();
    }


    public function getJournalByDate($start_date, $end_date, $store_id)
    {
        $builder = $this->db->table('dt_journal');
        $builder->select('dt_journal.account_id,hd_journal.journal_id,hd_journal.journal_code,hd_journal.journal_date,hd_journal.journal_period,hd_journal.journal_remark,ms_account.account_code,ms_account.account_name,ms_account_group.group_code,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('hd_journal.store_id',  $store_id)
            ->where('hd_journal.deleted',  'N')
            ->where("(hd_journal.journal_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");


        return  $builder->orderBy('hd_journal.journal_date,dt_journal.journal_id,dt_journal.credit_balance', 'ASC')->get();
    }



    /* end report journal */


    /* report ledger */
    public function getJournalByAccount($journal_period, $store_id, $account_id = '')
    {
        $builder = $this->db->table('dt_journal');
        $builder->select('dt_journal.account_id,hd_journal.journal_id,hd_journal.journal_code,hd_journal.journal_date,hd_journal.journal_period,hd_journal.journal_remark,ms_account.account_code,ms_account.account_name,ms_account_group.group_code,dt_journal.debit_balance,dt_journal.credit_balance,ms_account.increase_in')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('hd_journal.journal_period', $journal_period)
            ->where('hd_journal.store_id',  $store_id)
            ->where('hd_journal.deleted',  'N');
        if ($account_id != '') {
            $builder->where('dt_journal.account_id', $account_id);
        }
        return $builder->orderBy('ms_account.account_name,hd_journal.journal_date,dt_journal.detail_id', 'ASC')->get();
    }

    public function getAccountJournalByDate($start_date, $end_date, $store_id, $account_id = '')
    {
        $builder = $this->db->table('dt_journal');
        $builder->select('dt_journal.account_id,hd_journal.journal_id,hd_journal.journal_code,hd_journal.journal_date,hd_journal.journal_period,hd_journal.journal_remark,ms_account.account_code,ms_account.account_name,ms_account_group.group_code,dt_journal.debit_balance,dt_journal.credit_balance,ms_account.increase_in')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where("(hd_journal.journal_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))")
            ->where('hd_journal.store_id',  $store_id)
            ->where('hd_journal.deleted',  'N');
        if ($account_id != '') {
            $builder->where('dt_journal.account_id', $account_id);
        }
        return $builder->orderBy('ms_account.account_name,hd_journal.journal_date,dt_journal.detail_id', 'ASC')->get();
    }
    /* end report ledger */

    /* report balance sheet v1 */
    public function getBalanceSheet($max_date, $min_date = null, $store_id)
    {
        $qGetAccount = $this->db->table('ms_account')
            ->select('ms_account.account_id,0 AS debit_balance,0 AS credit_balance')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('ms_account.deleted', 'N');
        $getAllAccount = $qGetAccount->getCompiledSelect();


        $qGetJurnal = $this->db->table('dt_journal')
            ->select('dt_journal.account_id,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id');
        if ($min_date != null) {
            $qGetJurnal->where("hd_journal.journal_date>=CAST('$min_date' AS DATE)");
        }

        $qGetJurnal->where("hd_journal.journal_date<=CAST('$max_date' AS DATE)")
            ->where('hd_journal.store_id',  $store_id)
            ->where('hd_journal.deleted',  'N');
        $getAllJournal = $qGetJurnal->getCompiledSelect();

        $tQuery =  "((" . $getAllAccount . ") UNION ALL (" . $getAllJournal . ")) as dtJournal";
        $builder = $this->db->table($tQuery);
        return $builder->select('dtJournal.account_id,ms_account_group.group_code,ms_account.account_code,ms_account.account_name,SUM(dtJournal.debit_balance) AS debit_balance,SUM(dtJournal.credit_balance) AS credit_balance,ms_account.increase_in,ms_account.reduce_in')
            ->join('ms_account', 'ms_account.account_id=dtJournal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->groupBy('dtJournal.account_id')
            ->orderBy('ms_account_group.group_code', 'ASC')
            ->get();
    }
    /* end report balance sheet v1 */

    /* report balance sheet v2 */
    public function getBalanceSheetGroupByType($store_id, $max_date, $group_type = ['assets', 'obligation', 'capital'])
    {
        $qGetAccount = $this->db->table('ms_account')
            ->select('ms_account.account_id,0 AS debit_balance,0 AS credit_balance')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('ms_account.deleted', 'N');
        if ($group_type != NULL) {
            if (is_array($group_type)) {
                $qGetAccount->whereIn('ms_account_group.group_type', $group_type);
            } else {
                $qGetAccount->where('ms_account_group.group_type', $group_type);
            }
        }
        $getAllAccount = $qGetAccount->getCompiledSelect();


        $qGetJurnal = $this->db->table('dt_journal')
            ->select('dt_journal.account_id,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where("hd_journal.journal_date<=CAST('$max_date' AS DATE)");
        if ($group_type != NULL) {
            if (is_array($group_type)) {
                $qGetJurnal->whereIn('ms_account_group.group_type', $group_type);
            } else {
                $qGetJurnal->where('ms_account_group.group_type', $group_type);
            }
        }
        $qGetJurnal->where('hd_journal.store_id',  $store_id)
            ->where('hd_journal.deleted',  'N');
        $getAllJournal = $qGetJurnal->getCompiledSelect();


        $tQuery =  "((" . $getAllAccount . ") UNION ALL (" . $getAllJournal . ")) as dtJournal";
        $builder = $this->db->table($tQuery);
        return $builder->select('dtJournal.account_id,ms_account_group.group_code,ms_account.account_code,ms_account.account_name,SUM(dtJournal.debit_balance) AS debit_balance,SUM(dtJournal.credit_balance) AS credit_balance,ms_account.increase_in,ms_account.reduce_in,ms_account_group.group_name,ms_account_group.group_type')
            ->join('ms_account', 'ms_account.account_id=dtJournal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->groupBy('dtJournal.account_id')
            ->orderBy('dtJournal.account_id', 'ASC')
            ->get();
    }
    /* end report balance sheet v2 */

    /* report income recap */
    public function getJournalGroupAccountByDate($store_id, $max_date, $min_date, $group_type = null, $account_id = null)
    {
        $qGetAccount = $this->db->table('ms_account')
            ->select('ms_account.account_id,0 AS debit_balance,0 AS credit_balance')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('ms_account.deleted', 'N');

        if ($account_id != null) {
            if (is_string($account_id)) {
                $qGetAccount->where('ms_account.account_id', $account_id);
            } else {
                $qGetAccount->whereIn('ms_account.account_id', $account_id);
            }
        }


        if ($group_type != null) {
            $qGetAccount->where('ms_account_group.group_type', $group_type);
        }
        $getAllAccount = $qGetAccount->getCompiledSelect();


        $qGetJurnal = $this->db->table('dt_journal')
            ->select('dt_journal.account_id,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where("(hd_journal.journal_date BETWEEN CAST('$min_date' AS DATE) AND CAST('$max_date' AS DATE))");

        if ($account_id != null) {
            if (is_string($account_id)) {
                $qGetJurnal->where('dt_journal.account_id', $account_id);
            } else {
                $qGetJurnal->whereIn('dt_journal.account_id', $account_id);
            }
        }

        if ($group_type != null) {
            $qGetJurnal->where('ms_account_group.group_type', $group_type);
        }

        $qGetJurnal->where('hd_journal.store_id',  $store_id)
            ->where('hd_journal.deleted',  'N');

        $getAllJournal = $qGetJurnal->getCompiledSelect();
        $tQuery =  "((" . $getAllAccount . ") UNION ALL (" . $getAllJournal . ")) as dtJournal";


        $builder = $this->db->table($tQuery);
        return $builder->select('dtJournal.account_id,ms_account_group.group_code,ms_account.account_code,ms_account.account_name,SUM(dtJournal.debit_balance) AS debit_balance,SUM(dtJournal.credit_balance) AS credit_balance,ms_account.increase_in,ms_account.reduce_in')
            ->join('ms_account', 'ms_account.account_id=dtJournal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->groupBy('dtJournal.account_id')
            ->orderBy('dtJournal.account_id', 'ASC')
            ->get();
    }
    /* end income recap */



    public function getAccountInitialBalance($journal_period, $account_id)
    {
        $mm             = substr($journal_period, 0, 2);
        $yyyy           = substr($journal_period, -4);
        $period_date    = "$yyyy-$mm-01";

        $builder = $this->db->table('dt_journal');
        $builder->select('dt_journal.account_id,ms_account.account_code,ms_account.account_name,ms_account_group.group_code,ms_account.increase_in,ms_account.reduce_in,IFNULL(SUM(dt_journal.debit_balance),0) as debit_balance,IFNULL(SUM(dt_journal.credit_balance),0) as credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('hd_journal.journal_date<', $period_date)
            ->where('dt_journal.account_id', $account_id)
            ->groupBy('dt_journal.account_id');

        return $builder->get();
    }

    public function getJournalByPeriod_old($journal_period)
    {
        $builder = $this->db->table('dt_journal');
        $builder->select('dt_journal.account_id,hd_journal.journal_id,hd_journal.journal_code,hd_journal.journal_date,hd_journal.journal_period,hd_journal.journal_remark,ms_account.account_code,ms_account.account_name,ms_account_group.group_code,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('hd_journal.journal_period', $journal_period);
        return  $builder->orderBy('hd_journal.journal_date,dt_journal.journal_id', 'ASC')->get();
    }

    public function getJournalByAccount_old($journal_period, $account_id = '')
    {
        $builder = $this->db->table('dt_journal');
        $builder->select('dt_journal.account_id,hd_journal.journal_id,hd_journal.journal_code,hd_journal.journal_date,hd_journal.journal_period,hd_journal.journal_remark,ms_account.account_code,ms_account.account_name,ms_account_group.group_code,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('hd_journal.journal_period', $journal_period);
        if ($account_id != '') {
            $builder->where('dt_journal.account_id', $account_id);
        }
        return  $builder->orderBy('hd_journal.journal_date, dt_journal.detail_id', 'ASC')->get();
    }

    public function getDailyJournalRecap($date_from, $date_until, $account_id = '')
    {
        $builder = $this->db->table('dt_journal');
        $builder->select('dt_journal.account_id,hd_journal.journal_date,ms_account.account_code,ms_account.account_name,ms_account_group.group_code,sum(dt_journal.debit_balance) as debit_balance,sum(dt_journal.credit_balance) as credit_balance,count(dt_journal.detail_id) as count_journal')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id');

        $builder->where("(hd_journal.journal_date BETWEEN '$date_from' AND '$date_until')");

        if ($account_id != '') {
            $builder->where('dt_journal.account_id', $account_id);
        }
        $builder->groupBy(['hd_journal.journal_date', 'dt_journal.account_id']);

        return  $builder->orderBy('hd_journal.journal_date,ms_account.account_name', 'ASC')->get();
    }

    public function getJournalGroupAccount($journal_period, $account_id = null, $group_type = null)
    {
        $qGetAccount = $this->db->table('ms_account')
            ->select('ms_account.account_id,0 AS debit_balance,0 AS credit_balance')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('ms_account.deleted', 'N');
        if ($account_id != null) {
            if (is_string($account_id)) {
                $qGetAccount->where('ms_account.account_id', $account_id);
            } else {
                $qGetAccount->whereIn('ms_account.account_id', $account_id);
            }
        }

        if ($group_type != null) {
            $qGetAccount->where('ms_account_group.group_type', $group_type);
        }

        $getAllAccount = $qGetAccount->getCompiledSelect();


        $qGetJurnal = $this->db->table('dt_journal')
            ->select('dt_journal.account_id,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('hd_journal.journal_period', $journal_period);
        if ($account_id != null) {
            if (is_string($account_id)) {
                $qGetJurnal->where('dt_journal.account_id', $account_id);
            } else {
                $qGetJurnal->whereIn('dt_journal.account_id', $account_id);
            }
        }

        if ($group_type != null) {
            $qGetJurnal->where('ms_account_group.group_type', $group_type);
        }

        $getAllJournal = $qGetJurnal->getCompiledSelect();

        $tQuery =  "((" . $getAllAccount . ") UNION ALL (" . $getAllJournal . ")) as dtJournal";


        $builder = $this->db->table($tQuery);
        return $builder->select('dtJournal.account_id,ms_account_group.group_code,ms_account.account_code,ms_account.account_name,SUM(dtJournal.debit_balance) AS debit_balance,SUM(dtJournal.credit_balance) AS credit_balance,ms_account.increase_in,ms_account.reduce_in')
            ->join('ms_account', 'ms_account.account_id=dtJournal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->groupBy('dtJournal.account_id')
            ->orderBy('dtJournal.account_id', 'ASC')
            ->get();
    }

    public function getJournalGroupAccountByDate_group($min_date, $max_date, $account_id = null, $group_type = null)
    {
        $qGetAccount = $this->db->table('ms_account')
            ->select('ms_account.account_id,0 AS debit_balance,0 AS credit_balance')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('ms_account.deleted', 'N');
        if ($account_id != null) {
            if (is_string($account_id)) {
                $qGetAccount->where('ms_account.account_id', $account_id);
            } else {
                $qGetAccount->whereIn('ms_account.account_id', $account_id);
            }
        }

        if ($group_type != null) {
            $qGetAccount->where('ms_account_group.group_type', $group_type);
        }

        $getAllAccount = $qGetAccount->getCompiledSelect();


        $qGetJurnal = $this->db->table('dt_journal')
            ->select('dt_journal.account_id,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where("(hd_journal.journal_date BETWEEN '$min_date' AND '$max_date')");

        if ($account_id != null) {
            if (is_string($account_id)) {
                $qGetJurnal->where('dt_journal.account_id', $account_id);
            } else {
                $qGetJurnal->whereIn('dt_journal.account_id', $account_id);
            }
        }

        if ($group_type != null) {
            $qGetJurnal->where('ms_account_group.group_type', $group_type);
        }

        $getAllJournal = $qGetJurnal->getCompiledSelect();

        $tQuery =  "((" . $getAllAccount . ") UNION ALL (" . $getAllJournal . ")) as dtJournal";


        $builder = $this->db->table($tQuery);
        return $builder->select('dtJournal.account_id,ms_account_group.group_code,ms_account.account_code,ms_account.account_name,SUM(dtJournal.debit_balance) AS debit_balance,SUM(dtJournal.credit_balance) AS credit_balance,ms_account.increase_in,ms_account.reduce_in')
            ->join('ms_account', 'ms_account.account_id=dtJournal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->groupBy('dtJournal.account_id')
            ->orderBy('dtJournal.account_id', 'ASC')
            ->get();
    }

    public function getSalesCogs($journal_period)
    {
        return 0;
        //$journal_period = 072022
        // $min_date = substr($journal_period, -4) . '-' . substr($journal_period, 0, 2) . '-01';
        // $max_date = substr($journal_period, -4) . '-' . substr($journal_period, 0, 2) . '-31';
        // $getCogs = $this->db->table('dt_sales')
        //     ->select('IFNULL(sum(dt_sales.cogs * dt_sales.sales_qty),0) as total_cogs')
        //     ->join('hd_sales', 'hd_sales.sales_id=dt_sales.sales_id')
        //     ->where("(hd_sales.sales_date BETWEEN '$min_date' AND '$max_date')")
        //     ->where('hd_sales.sales_cancel', 'N')
        //     ->get()
        //     ->getRowArray();
        // $sales_cogs = $getCogs == NULL ? 0 : floatval($getCogs['total_cogs']);

        // $getReturnCogs = $this->db->table('dt_sales_return')
        //     ->select('IFNULL(sum(dt_sales_return.cogs * dt_sales_return.sales_return_qty),0) as total_cogs')
        //     ->join('hd_sales_return', 'hd_sales_return.sales_return_id=dt_sales_return.sales_return_id')
        //     ->where("(hd_sales_return.sales_return_date BETWEEN '$min_date' AND '$max_date')")
        //     ->where('hd_sales_return.sales_return_cancel', 'N')
        //     ->get()
        //     ->getRowArray();
        // $sales_return_cogs = $getReturnCogs == NULL ? 0 : floatval($getReturnCogs['total_cogs']);

        // return $sales_cogs - $sales_return_cogs;
    }

    public function getSalesCogsByDate($min_date, $max_date)
    {
        return 0;
        // $getCogs = $this->db->table('dt_sales')
        //     ->select('IFNULL(sum(dt_sales.cogs * dt_sales.sales_qty),0) as total_cogs')
        //     ->join('hd_sales', 'hd_sales.sales_id=dt_sales.sales_id')
        //     ->where("(hd_sales.sales_date BETWEEN '$min_date' AND '$max_date')")
        //     ->where('hd_sales.sales_cancel', 'N')
        //     ->get()
        //     ->getRowArray();
        // $sales_cogs = $getCogs == NULL ? 0 : floatval($getCogs['total_cogs']);

        // $getReturnCogs = $this->db->table('dt_sales_return')
        //     ->select('IFNULL(sum(dt_sales_return.cogs * dt_sales_return.sales_return_qty),0) as total_cogs')
        //     ->join('hd_sales_return', 'hd_sales_return.sales_return_id=dt_sales_return.sales_return_id')
        //     ->where("(hd_sales_return.sales_return_date BETWEEN '$min_date' AND '$max_date')")
        //     ->where('hd_sales_return.sales_return_cancel', 'N')
        //     ->get()
        //     ->getRowArray();
        // $sales_return_cogs = $getReturnCogs == NULL ? 0 : floatval($getReturnCogs['total_cogs']);

        // return $sales_cogs - $sales_return_cogs;
    }

    public function getInitialInventory($journal_period,  $purchase_account = [], $sales_account = [], $product_cogs_account = 113)
    {

        //$journal_period = 072022
        $mm     = intval(substr($journal_period, 0, 2)) - 1;
        $smm    = substr('0' . $mm, -2);
        $max_date = substr($journal_period, -4) . '-' . $smm . '-31';

        $qGetAccount = $this->db->table('ms_account')
            ->select('ms_account.account_id,0 AS debit_balance,0 AS credit_balance')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('ms_account.deleted', 'N');
        $qGetAccount->whereIn('ms_account.account_id', $purchase_account);
        $getAllAccount = $qGetAccount->getCompiledSelect();

        $qGetJurnal = $this->db->table('dt_journal')
            ->select('dt_journal.account_id,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('hd_journal.journal_date<=', $max_date);
        $qGetJurnal->whereIn('dt_journal.account_id', $purchase_account);
        $getAllJournal = $qGetJurnal->getCompiledSelect();

        $tQuery =  "((" . $getAllAccount . ") UNION ALL (" . $getAllJournal . ")) as dtJournal";

        $builder = $this->db->table($tQuery);
        $getInventoryStock = $builder->select('dtJournal.account_id,ms_account_group.group_code,ms_account.account_code,ms_account.account_name,SUM(dtJournal.debit_balance) AS debit_balance,SUM(dtJournal.credit_balance) AS credit_balance,ms_account.increase_in,ms_account.reduce_in')
            ->join('ms_account', 'ms_account.account_id=dtJournal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->groupBy('dtJournal.account_id')
            ->orderBy('dtJournal.account_id', 'ASC')
            ->get()
            ->getResultArray();



        $stock = 0;
        foreach ($getInventoryStock as $row) {
            $stock += floatval($row['debit_balance']) - floatval($row['credit_balance']);
        }

        $getAccountCogs = $this->db->table('dt_journal')
            ->select('dt_journal.account_id,IFNULL(sum(dt_journal.debit_balance),0) as debit_balance,IFNULL(sum(dt_journal.credit_balance),0) as credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('dt_journal.account_id', $product_cogs_account)
            ->where('hd_journal.journal_date<=', $max_date)
            ->groupBy('dt_journal.account_id')->get()->getRowArray();

        $productCogs = $getAccountCogs == NULL ? 0 : floatval($getAccountCogs['debit_balance']) - floatval($getAccountCogs['credit_balance']);



        // $getCogs = $this->db->table('dt_sales')
        //     ->select('IFNULL(sum(dt_sales.cogs * dt_sales.sales_qty),0) as total_cogs')
        //     ->join('hd_sales', 'hd_sales.sales_id=dt_sales.sales_id')
        //     ->where("(hd_sales.sales_date <= '$max_date')")
        //     ->where('hd_sales.sales_cancel', 'N')
        //     ->get()
        //     ->getRowArray();
        $getCogs = NULL;

        $sales_cogs = $getCogs == NULL ? 0 : floatval($getCogs['total_cogs']);

        // $getReturnCogs = $this->db->table('dt_sales_return')
        //     ->select('IFNULL(sum(dt_sales_return.cogs * dt_sales_return.sales_return_qty),0) as total_cogs')
        //     ->join('hd_sales_return', 'hd_sales_return.sales_return_id=dt_sales_return.sales_return_id')
        //     ->where("(hd_sales_return.sales_return_date <= '$max_date')")
        //     ->where('hd_sales_return.sales_return_cancel', 'N')
        //     ->get()
        //     ->getRowArray();
        $getReturnCogs = NULL;
        $sales_return_cogs = $getReturnCogs == NULL ? 0 : floatval($getReturnCogs['total_cogs']);


        $stock = $stock - ($sales_cogs - $sales_return_cogs) -  $productCogs;
        return $stock;
    }


    public function getInitialInventory_old($journal_period,  $purchase_account = [], $sales_account = [])
    {
        //$journal_period = 072022
        $mm     = intval(substr($journal_period, 0, 2)) - 1;
        $smm    = substr('0' . $mm, -2);
        $max_date = substr($journal_period, -4) . '-' . $smm . '-31';

        $qGetAccount = $this->db->table('ms_account')
            ->select('ms_account.account_id,0 AS debit_balance,0 AS credit_balance')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('ms_account.deleted', 'N');
        $qGetAccount->whereIn('ms_account.account_id', $purchase_account);
        $getAllAccount = $qGetAccount->getCompiledSelect();


        $qGetJurnal = $this->db->table('dt_journal')
            ->select('dt_journal.account_id,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('hd_journal.journal_date<=', $max_date);
        $qGetJurnal->whereIn('dt_journal.account_id', $purchase_account);
        $getAllJournal = $qGetJurnal->getCompiledSelect();

        $tQuery =  "((" . $getAllAccount . ") UNION ALL (" . $getAllJournal . ")) as dtJournal";

        $builder = $this->db->table($tQuery);
        $getInventoryStock = $builder->select('dtJournal.account_id,ms_account_group.group_code,ms_account.account_code,ms_account.account_name,SUM(dtJournal.debit_balance) AS debit_balance,SUM(dtJournal.credit_balance) AS credit_balance,ms_account.increase_in,ms_account.reduce_in')
            ->join('ms_account', 'ms_account.account_id=dtJournal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->groupBy('dtJournal.account_id')
            ->orderBy('dtJournal.account_id', 'ASC')
            ->get()
            ->getResultArray();

        $stock = 0;
        foreach ($getInventoryStock as $row) {
            $stock += floatval($row['debit_balance']) - floatval($row['credit_balance']);
        }


        $getCogs = $this->db->table('dt_sales')
            ->select('IFNULL(sum(dt_sales.cogs * dt_sales.sales_qty),0) as total_cogs')
            ->join('hd_sales', 'hd_sales.sales_id=dt_sales.sales_id')
            ->where("(hd_sales.sales_date <= '$max_date')")
            ->where('hd_sales.sales_cancel', 'N')
            ->get()
            ->getRowArray();
        $sales_cogs = $getCogs == NULL ? 0 : floatval($getCogs['total_cogs']);

        $getReturnCogs = $this->db->table('dt_sales_return')
            ->select('IFNULL(sum(dt_sales_return.cogs * dt_sales_return.sales_return_qty),0) as total_cogs')
            ->join('hd_sales_return', 'hd_sales_return.sales_return_id=dt_sales_return.sales_return_id')
            ->where("(hd_sales_return.sales_return_date <= '$max_date')")
            ->where('hd_sales_return.sales_return_cancel', 'N')
            ->get()
            ->getRowArray();
        $sales_return_cogs = $getReturnCogs == NULL ? 0 : floatval($getReturnCogs['total_cogs']);

        $stock = $stock - ($sales_cogs - $sales_return_cogs);
        return $stock;
    }

    public function getBalanceSheet_old($journal_period)
    {
        $builder = $this->db->table('ms_journal');
        return $builder->select('ms_account_group.group_code,ms_account.account_code,ms_account.account_name,IFNULL(SUM(ms_journal.debit_balance),0) AS debit_balance,IFNULL(SUM(ms_journal.credit_balance),0) AS credit_balance')
            ->join('ms_account', 'ms_account.account_id=ms_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('ms_journal.journal_period', $journal_period)
            ->groupBy('ms_journal.account_id')
            ->orderBy('ms_journal.account_id', 'ASC')
            ->get();
    }



    // neraca //
    public function getBalanceSheetGroupByType_old($max_date, $group_type = ['assets', 'obligation', 'capital'])
    {
        $qGetAccount = $this->db->table('ms_account')
            ->select('ms_account.account_id,0 AS debit_balance,0 AS credit_balance')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('ms_account.deleted', 'N');
        if ($group_type != NULL) {
            if (is_array($group_type)) {
                $qGetAccount->whereIn('ms_account_group.group_type', $group_type);
            } else {
                $qGetAccount->where('ms_account_group.group_type', $group_type);
            }
        }
        $getAllAccount = $qGetAccount->getCompiledSelect();


        $qGetJurnal = $this->db->table('dt_journal')
            ->select('dt_journal.account_id,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('hd_journal.journal_date<=', $max_date);
        if ($group_type != NULL) {
            if (is_array($group_type)) {
                $qGetJurnal->whereIn('ms_account_group.group_type', $group_type);
            } else {
                $qGetJurnal->where('ms_account_group.group_type', $group_type);
            }
        }
        $getAllJournal = $qGetJurnal->getCompiledSelect();


        $tQuery =  "((" . $getAllAccount . ") UNION ALL (" . $getAllJournal . ")) as dtJournal";
        $builder = $this->db->table($tQuery);
        return $builder->select('dtJournal.account_id,ms_account_group.group_code,ms_account.account_code,ms_account.account_name,SUM(dtJournal.debit_balance) AS debit_balance,SUM(dtJournal.credit_balance) AS credit_balance,ms_account.increase_in,ms_account.reduce_in,ms_account_group.group_name,ms_account_group.group_type')
            ->join('ms_account', 'ms_account.account_id=dtJournal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->groupBy('dtJournal.account_id')
            ->orderBy('dtJournal.account_id', 'ASC')
            ->get();
    }

    public function getBalanceSheetGroupByType_old2($max_date, $group_type = ['assets', 'obligation', 'capital'])
    {
        $qGetAccount = $this->db->table('ms_account')
            ->select('ms_account.account_id,0 AS debit_balance,0 AS credit_balance')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('ms_account.deleted', 'N');
        if ($group_type != NULL) {
            if (is_array($group_type)) {
                $qGetAccount->whereIn('ms_account_group.group_type', $group_type);
            } else {
                $qGetAccount->where('ms_account_group.group_type', $group_type);
            }
        }
        $getAllAccount = $qGetAccount->getCompiledSelect();


        $qGetJurnal = $this->db->table('dt_journal')
            ->select('dt_journal.account_id,dt_journal.debit_balance,dt_journal.credit_balance')
            ->join('hd_journal', 'hd_journal.journal_id=dt_journal.journal_id')
            ->join('ms_account', 'ms_account.account_id=dt_journal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->where('hd_journal.journal_date<=', $max_date);
        if ($group_type != NULL) {
            if (is_array($group_type)) {
                $qGetJurnal->whereIn('ms_account_group.group_type', $group_type);
            } else {
                $qGetJurnal->where('ms_account_group.group_type', $group_type);
            }
        }
        $getAllJournal = $qGetJurnal->getCompiledSelect();


        $tQuery =  "((" . $getAllAccount . ") UNION ALL (" . $getAllJournal . ")) as dtJournal";
        $builder = $this->db->table($tQuery);
        return $builder->select('dtJournal.account_id,ms_account_group.group_code,ms_account.account_code,ms_account.account_name,SUM(dtJournal.debit_balance) AS debit_balance,SUM(dtJournal.credit_balance) AS credit_balance,ms_account.increase_in,ms_account.reduce_in,ms_account_group.group_name,ms_account_group.group_type')
            ->join('ms_account', 'ms_account.account_id=dtJournal.account_id')
            ->join('ms_account_group', 'ms_account_group.group_id=ms_account.group_id')
            ->groupBy('dtJournal.account_id')
            ->orderBy('dtJournal.account_id', 'ASC')
            ->get();
    }
}
