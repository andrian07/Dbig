<?php

namespace App\Models;

use CodeIgniter\Model;

class M_supplier extends Model
{
    protected $table = 'ms_supplier';

    public function getSupplier($supplier_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_supplier.*,ms_mapping_area.mapping_code,ms_mapping_area.mapping_address')
            ->join('ms_mapping_area', 'ms_mapping_area.mapping_id=ms_supplier.mapping_id');

        if ($supplier_id  != '') {
            $builder->where('ms_supplier.supplier_id', $supplier_id);
        }

        if ($show_deleted == FALSE) {
            $builder->where('ms_supplier.deleted', 'N');
        }

        return $builder->get();
    }

    public function getSupplierByName($supplier_name, $show_deleted = FALSE)
    {

        $builder = $this->db->table($this->table);
        $builder->select('ms_supplier.*,ms_mapping_area.mapping_code,ms_mapping_area.mapping_address')
            ->join('ms_mapping_area', 'ms_mapping_area.mapping_id=ms_supplier.mapping_id');

        if ($supplier_name  != '') {
            $builder->where('ms_supplier.supplier_name', $supplier_name);
        }

        if ($show_deleted == FALSE) {
            $builder->where('ms_supplier.deleted', 'N');
        }

        return $builder->get();
    }

    public function getSupplierByCode($supplier_code, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_supplier.*,ms_mapping_area.mapping_code,ms_mapping_area.mapping_address')
            ->join('ms_mapping_area', 'ms_mapping_area.mapping_id=ms_supplier.mapping_id');

        if ($supplier_code  != '') {
            $builder->where('ms_supplier.supplier_code', $supplier_code);
        }

        if ($show_deleted == FALSE) {
            $builder->where('ms_supplier.deleted', 'N');
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

    public function insertSupplier($data)
    {
        $this->db->query('LOCK TABLES ms_supplier WRITE');

        $save = $this->db->table($this->table)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'supplier', $id);
        return $save;
    }

    public function updateSupplier($data)
    {
        $this->db->query('LOCK TABLES ms_supplier WRITE');
        $save = $this->db->table($this->table)->update($data, ['supplier_id' => $data['supplier_id']]);

        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'supplier', $data['supplier_id']);
        return $save;
    }

    public function deleteSupplier($supplier_id)
    {
        $this->db->query('LOCK TABLES ms_supplier WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['supplier_id' => $supplier_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'supplier', $supplier_id);
        return $save;
    }
}
