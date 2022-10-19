<?php

namespace App\Models\Auth;

use CodeIgniter\Model;

class M_user_account extends Model
{
    protected $table = 'user_account';

    public function getUser($user_code = '', $show_deleted = FALSE, $show_non_active = TRUE)
    {
        $builder = $this->db->table($this->table);

        $builder->select('user_account.user_id,user_account.user_code,user_account.user_group,user_group.group_name,user_account.user_name,user_account.user_password,user_account.user_realname,user_account.active,user_account.deleted,user_account.store_id,ms_store.store_code,ms_store.store_name', FALSE);
        $builder->join('user_group', 'user_group.group_code=user_account.user_group');
        $builder->join('ms_store', 'ms_store.store_id=user_account.store_id');

        if ($user_code != '') {
            $builder->where(['user_account.user_code' => $user_code]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['user_account.deleted!=' => 'Y']);
        }

        if ($show_non_active == FALSE) {
            $builder->where(['user_account.active' => 'Y']);
        }

        return $builder->get();
    }

    public function getUserByName($username, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);

        $builder->select('user_account.user_id,user_account.user_code,user_account.user_group,user_group.group_name,user_account.user_name,user_account.user_password,user_account.user_realname,user_account.active,user_account.deleted,user_account.store_id,ms_store.store_code,ms_store.store_name', FALSE);
        $builder->join('user_group', 'user_group.group_code=user_account.user_group');
        $builder->join('ms_store', 'ms_store.store_id=user_account.store_id');

        $builder->where('user_account.user_name', $username);

        if ($show_deleted == FALSE) {
            $builder->where('user_account.deleted', 'N');
        }

        return $builder->get();
    }


    public function insertUser($user_data)
    {
        $this->db->query('LOCK TABLES user_account WRITE');
        $maxUserCode = $this->db->table($this->table)->select('max(user_code) as user_code')->get()->getRowArray();
        if ($maxUserCode['user_code'] == NULL) {
            $user_data['user_code'] = "U001";
        } else {
            $user_data['user_code'] = 'U' . substr('000' . strval(floatval(substr($maxUserCode['user_code'], -3)) + 1), -3);
        }
        $save = $this->db->table($this->table)->insert($user_data);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'user_account', 0, 'ADD USER ' . $user_data['user_code']);
        return $save;
    }

    public function updateUser($user_data)
    {
        $this->db->query('LOCK TABLES user_account WRITE');
        $save = $this->db->table($this->table)->update($user_data, ['user_code' => $user_data['user_code']]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'user_account', 0, 'EDIT USER ' . $user_data['user_code']);
        return $save;
    }

    public function deleteUser($user_code)
    {
        $this->db->query('LOCK TABLES user_account WRITE');
        $user_data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($user_data, ['user_code' => $user_code]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'user_account', 0, 'DELETE USER ' . $user_code);
        return $save;
    }
}
