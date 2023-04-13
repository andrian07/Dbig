<?php

namespace App\Models;

use CodeIgniter\Model;

class M_unit extends Model
{
    protected $table = 'ms_unit';

    public function getUnit($unit_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        if ($unit_id  != '') {
            $builder->where(['unit_id' => $unit_id]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }

        return $builder->get();
    }

    public function getUnitByName($unit_name, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->where(['unit_name' => $unit_name]);
        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }
        return $builder->get();
    }

    public function hasProduct($unit_id)
    {
        return 0;
        // $getData = $this->db->table('ms_product_unit')
        //     ->select('item_code')
        //     ->where('unit_id', $unit_id)
        //     ->limit(1)->get()->getRowArray();

        // if ($getData == NULL) {
        //     return 0;
        // } else {
        //     return 1;
        // }
    }

    public function insertUnit($data)
    {
        $this->db->query('LOCK TABLES ms_unit WRITE');

        $save = $this->db->table($this->table)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'unit', $id);
        return $save;
    }

    public function updateUnit($data)
    {
        $this->db->query('LOCK TABLES ms_unit WRITE');
        $save = $this->db->table($this->table)->update($data, ['unit_id' => $data['unit_id']]);

        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'unit', $data['unit_id']);
        return $save;
    }

    public function deleteUnit($unit_id)
    {
        $this->db->query('LOCK TABLES ms_unit WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['unit_id' => $unit_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'unit', $unit_id);
        return $save;
    }
}
