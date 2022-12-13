<?php

namespace App\Models;

use CodeIgniter\Model;

class M_point_reward extends Model
{
    protected $table = 'ms_point_reward';

    public function getReward($reward_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_point_reward.*');
        if ($reward_id  != '') {
            $builder->where(['ms_point_reward.reward_id' => $reward_id]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['ms_point_reward.deleted' => 'N']);
        }

        return $builder->get();
    }

    public function searchReward($search, $limit = 15)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_point_reward.*');
        $curDate = date('Y-m-d');
        $builder->where("'$curDate' BETWEEN ms_point_reward.start_date AND ms_point_reward.end_Date");
        $builder->groupStart()
            ->like('ms_point_reward.reward_code', $search)
            ->orLike('ms_point_reward.reward_name', $search)
            ->groupEnd();

        return $builder->limit($limit)->get();
    }

    public function insertReward($data)
    {
        $this->db->query('LOCK TABLES ms_point_reward WRITE,last_record_number WRITE');
        $sqlUpdateLastNumber    = NULL;
        $saveQueries            = NULL;

        $record_period = date('mY');
        $getLastNumber = $this->db->table('last_record_number')
            ->where('record_module', 'reward_point')
            ->where('record_period', $record_period)
            ->get()->getRowArray();

        if ($getLastNumber == NULL) {
            $data['reward_code'] = 'R' . date('ym') . '001';

            $update_last_number = [
                'record_module' => 'reward_point',
                'store_id'      => 0,
                'record_period' => $record_period,
                'last_number'   => 1
            ];
            $sqlUpdateLastNumber = $this->db->table('last_record_number')->set($update_last_number)->getCompiledInsert();
        } else {
            $new_number = strval(intval($getLastNumber['last_number']) + 1);
            $data['reward_code'] = 'R' . date('ym') . substr('00000' . $new_number, -3);

            $update_last_number = [
                'record_module' => 'reward_point',
                'store_id'      => 0,
                'record_period' => $record_period,
                'last_number'   => $new_number
            ];
            $sqlUpdateLastNumber = $this->db->table('last_record_number')->set($update_last_number)->where('record_id', $getLastNumber['record_id'])->getCompiledUpdate();
        }

        $this->db->transBegin();
        $this->db->table($this->table)->insert($data);
        $reward_id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries[]  = $this->db->getLastQuery()->getQuery();
            $reward_id      = $this->db->insertID();
        }

        $this->db->query($sqlUpdateLastNumber);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $saveQueries = NULL;
            $save = 0;
        } else {
            $this->db->transCommit();
            $save = 1;
        }


        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'reward_point',  $reward_id, 'add');
        return $save;
    }

    public function updateReward($data)
    {
        $this->db->query('LOCK TABLES ms_reward_point WRITE');
        $save = $this->db->table($this->table)->update($data, ['reward_id' => $data['reward_id']]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'reward_point', $data['reward_id'], 'update');
        return $save;
    }

    public function deleteReward($reward_id)
    {
        $this->db->query('LOCK TABLES ms_reward WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['reward_id' => $reward_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'reward_point', $reward_id, 'delete');
        return $save;
    }
}
