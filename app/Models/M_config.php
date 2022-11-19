<?php

namespace App\Models;

use CodeIgniter\Model;

class M_config extends Model
{
    protected $table = 'ms_config';

    public function getConfig($config_group = '', $config_subgroup = '', $config_name = '')
    {
        $builder = $this->db->table($this->table);

        if ($config_group != '') {
            $builder->where('config_group', $config_group);
        }

        if ($config_subgroup != '') {
            $builder->where('config_subgroup', $config_subgroup);
        }

        if ($config_name != '') {
            $builder->where('config_name', $config_name);
        }

        return $builder->get();
    }

    public function updateConfig($data)
    {
        $this->db->query('LOCK TABLES ms_config WRITE');
        $qInsert = $this->db->table($this->table)->set($data)->getCompiledInsert();
        $qInsert .= ' ON DUPLICATE KEY UPDATE config_value=VALUES(config_value)';

        $save = $this->db->query($qInsert);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = 0;
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'config', $id, 'update');
        return $save;
    }
}
