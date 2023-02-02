<?php

namespace App\Models;

use CodeIgniter\Model;

class M_salesman extends Model
{
    protected $table = 'ms_salesman';

    public function getSalesman($salesman_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_salesman.*,ms_store.store_code,ms_store.store_name')
            ->join('ms_store', 'ms_store.store_id=ms_salesman.store_id');

        if ($salesman_id  != '') {
            $builder->where('ms_salesman.salesman_id', $salesman_id);
        }

        if ($show_deleted == FALSE) {
            $builder->where('ms_salesman.deleted', 'N');
        }

        return $builder->get();
    }

    public function getSalesmanByCode($salesman_code, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_salesman.*,ms_store.store_code,ms_store.store_name')
            ->join('ms_store', 'ms_store.store_id=ms_salesman.store_id');

        if ($salesman_code  != '') {
            $builder->where('ms_salesman.salesman_code', $salesman_code);
        }

        if ($show_deleted == FALSE) {
            $builder->where('ms_salesman.deleted', 'N');
        }

        return $builder->get();
    }

    public function hasTransaction($supplier_id)
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

    public function insertSalesman($data)
    {
        $this->db->query('LOCK TABLES ms_salesman WRITE');

        $save = $this->db->table($this->table)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'salesman', $id, 'Add');
        return $save;
    }

    public function updateSalesman($data)
    {
        $this->db->query('LOCK TABLES ms_salesman WRITE');
        $save = $this->db->table($this->table)->update($data, ['salesman_id' => $data['salesman_id']]);

        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'salesman', $data['salesman_id'], 'Edit');
        return $save;
    }

    public function deleteSalesman($salesman_id)
    {
        $this->db->query('LOCK TABLES ms_salesman WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['salesman_id' => $salesman_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'salesman', $salesman_id, 'Delete');
        return $save;
    }
}
