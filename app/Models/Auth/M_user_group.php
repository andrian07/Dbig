<?php

namespace App\Models\Auth;

use CodeIgniter\Model;

class M_user_group extends Model
{
    protected $table = 'user_group';

    public function getGroup($group_code = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('group_code,group_name');
        if ($group_code != '') {
            $builder->where(['group_code' => $group_code]);
        }
        if ($show_deleted == FALSE) {
            $builder->where('deleted', 'N');
        }
        return $builder->get();
    }

    public function getGroupByName($group_name)
    {
        return $this->getWhere(['group_name' => $group_name]);
    }

    // public function insertGroup($group_data)
    // {
    //     $this->db->query('LOCK TABLES user_group WRITE');
    //     $maxGroupCode = $this->db->table($this->table)->select('max(group_code) as group_code')->get()->getRowArray();
    //     if ($maxGroupCode['group_code'] == NULL) {
    //         $group_data['group_code'] = "L01";
    //     } else {
    //         $group_data['group_code'] = 'L' . substr('00' . strval(floatval(substr($maxGroupCode['group_code'], -2)) + 1), -2);
    //     }

    //     $save = $this->db->table($this->table)->insert($group_data);
    //     $saveQueries = NULL;
    //     if ($this->db->affectedRows() > 0) {
    //         $saveQueries = $this->db->getLastQuery()->getQuery();
    //     }
    //     $this->db->query('UNLOCK TABLES');

    //     saveQueries($saveQueries, 'user_group');
    //     return $save;
    // }

    // public function updateGroup($group_data)
    // {
    //     $this->db->query('LOCK TABLES user_group WRITE');
    //     $save = $this->db->table($this->table)->update($group_data, ['group_code' => $group_data['group_code']]);
    //     $saveQueries = NULL;
    //     if ($this->db->affectedRows() > 0) {
    //         $saveQueries = $this->db->getLastQuery()->getQuery();
    //     }
    //     $this->db->query('UNLOCK TABLES');

    //     saveQueries($saveQueries, 'user_group');
    //     return $save;
    // }

    // public function deleteGroup($group_code)
    // {
    //     $this->db->query('LOCK TABLES user_group WRITE');
    //     $group_data = ['deleted' => 'Y'];
    //     $save = $this->db->table($this->table)->update($group_data, ['group_code' => $group_code]);
    //     $saveQueries = NULL;
    //     if ($this->db->affectedRows() > 0) {
    //         $saveQueries = $this->db->getLastQuery()->getQuery();
    //     }
    //     $this->db->query('UNLOCK TABLES');

    //     saveQueries($saveQueries, 'user_group');
    //     return $save;
    // }
}
