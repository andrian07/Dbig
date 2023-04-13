<?php

namespace App\Models;

use CodeIgniter\Model;

class M_warehouse extends Model
{
    protected $table = 'ms_warehouse';

    public function getWarehouse($warehouse_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_warehouse.*,ms_store.store_code,ms_store.store_name')
            ->join('ms_store', 'ms_warehouse.store_id=ms_store.store_id');

        if ($warehouse_id  != '') {
            $builder->where('ms_warehouse.warehouse_id', $warehouse_id);
        }

        if ($show_deleted == FALSE) {
            $builder->where('ms_warehouse.deleted', 'N');
        }

        return $builder->get();
    }

    public function getWarehouseByName($warehouse_name, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_warehouse.*,ms_store.store_code,ms_store.store_name')
            ->join('ms_store', 'ms_warehouse.store_id=ms_store.store_id');

        if ($warehouse_name  != '') {
            $builder->where('ms_warehouse.warehouse_name', $warehouse_name);
        }

        if ($show_deleted == FALSE) {
            $builder->where('ms_warehouse.deleted', 'N');
        }

        return $builder->get();
    }

    public function getWarehouseByCode($warehouse_code, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_warehouse.*,ms_store.store_code,ms_store.store_name')
            ->join('ms_store', 'ms_warehouse.store_id=ms_store.store_id');

        if ($warehouse_code  != '') {
            $builder->where('ms_warehouse.warehouse_code', $warehouse_code);
        }

        if ($show_deleted == FALSE) {
            $builder->where('ms_warehouse.deleted', 'N');
        }

        return $builder->get();
    }

    public function hasTransaction($warehouse_id)
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

    public function insertWarehouse($data)
    {
        $this->db->query('LOCK TABLES ms_warehouse WRITE');

        $save = $this->db->table($this->table)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'warehouse', $id);
        return $save;
    }

    public function updateWarehouse($data)
    {
        $this->db->query('LOCK TABLES ms_warehouse WRITE');
        $save = $this->db->table($this->table)->update($data, ['warehouse_id' => $data['warehouse_id']]);

        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'warehouse', $data['warehouse_id']);
        return $save;
    }

    public function deleteWarehouse($warehouse_id)
    {
        $this->db->query('LOCK TABLES ms_warehouse WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['warehouse_id' => $warehouse_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'warehouse', $warehouse_id);
        return $save;
    }
}
