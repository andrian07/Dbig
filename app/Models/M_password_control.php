<?php

namespace App\Models;

use CodeIgniter\Model;

class M_password_control extends Model
{
    protected $table = 'password_control';
    protected $tLog  = 'log_password_control';

    public function getPasswordControl($password_control_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('password_control.*,user_account.user_name,user_account.user_realname,user_account.store_id,ms_store.store_code,ms_store.store_name,user_group.group_name');
        $builder->join('user_account', 'user_account.user_id=password_control.user_id');
        $builder->join('user_group', 'user_group.group_code=user_account.user_group');
        $builder->join('ms_store', 'ms_store.store_id=user_account.store_id');

        if ($password_control_id  != '') {
            $builder->where(['password_control.password_control_id' => $password_control_id]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['password_control.deleted' => 'N']);
        }

        return $builder->get();
    }

    public function getPasswordControlByUserId($user_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('password_control.*,user_account.user_index_fingerprint');
        $builder->join('user_account', 'user_account.user_id=password_control.user_id');

        if ($user_id  != '') {
            $builder->where(['password_control.user_id' => $user_id]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['password_control.deleted' => 'N']);
        }

        return $builder->get();
    }

    public function hasLog($password_control_id)
    {
        $getData = $this->db->table($this->tLog)
            ->select('log_id')
            ->where('password_control_id', $password_control_id)
            ->limit(1)->get()->getRowArray();

        if ($getData == NULL) {
            return 0;
        } else {
            return 1;
        }
    }

    public function insertPasswordControl($data)
    {
        $this->db->query('LOCK TABLES password_control WRITE,user_account READ');
        $saveQueries = NULL;
        $user_id = $data['user_id'];


        $getByUserId = $this->getPasswordControlByUserId($user_id, true)->getRowArray();
        if ($getByUserId == NULL) {
            $save = $this->db->table($this->table)->insert($data);
            $id = 0;
            if ($this->db->affectedRows() > 0) {
                $saveQueries = $this->db->getLastQuery()->getQuery();
                $id = $this->db->insertID();
            }
        } else {
            $id = $getByUserId['password_control_id'];
            $update_data = [
                'user_id'   => $user_id,
                'active'    => $data['active'],
                'deleted'   => 'N'
            ];

            $save = $this->db->table($this->table)->update($update_data, ['password_control_id' => $id]);
            if ($this->db->affectedRows() > 0) {
                $saveQueries = $this->db->getLastQuery()->getQuery();
            }
        }



        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'password_control', $id, 'add');
        return $save;
    }

    public function updatePasswordControl($data)
    {
        $this->db->query('LOCK TABLES password_control WRITE');
        $save = $this->db->table($this->table)->update($data, ['password_control_id' => $data['password_control_id']]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'password_control', $data['password_control_id'], 'edit');
        return $save;
    }

    public function deletePasswordControl($password_control_id)
    {
        $this->db->query('LOCK TABLES password_control WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['password_control_id' => $password_control_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'password_control', $password_control_id, 'delete');
        return $save;
    }
}
