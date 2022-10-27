<?php

namespace App\Models\Auth;

use CodeIgniter\Model;

class M_user_role extends Model
{
    protected $table = 'user_role';

    public function getRole($group_code)
    {
        $builder = $this->db->table($this->table);
        $builder->select('module_name,role_name,role_value');
        $builder->where(['group_code' => $group_code]);
        return $builder->get();
    }

    public function updateRole($data_role)
    {
        $this->db->query('LOCK TABLES user_role WRITE');
        $group_code = '';
        $values = [];
        $sqlText = "INSERT INTO user_role(group_code,module_name,role_name,role_value) VALUES";
        foreach ($data_role as $r) {
            $group_code = $r['group_code'];
            $values[] = "('" . $r['group_code'] . "','" . $r['module_name'] . "','" . $r['role_name'] . "','" . $r['role_value'] . "')";
        }

        $sqlText .= implode(",", $values) . " ON DUPLICATE KEY UPDATE role_value=VALUES(role_value)";

        $save = $this->db->query($sqlText);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'user_role', 0, 'EDIT ROLE ' . $group_code);
        return $save;
    }
}
