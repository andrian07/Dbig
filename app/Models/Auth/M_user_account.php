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
}
