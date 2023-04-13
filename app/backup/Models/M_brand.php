<?php

namespace App\Models;

use CodeIgniter\Model;

class M_brand extends Model
{
    protected $table = 'ms_brand';

    public function getBrand($brand_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        if ($brand_id  != '') {
            $builder->where(['brand_id' => $brand_id]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }

        return $builder->get();
    }

    public function getBrandByName($brand_name, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->where(['brand_name' => $brand_name]);
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

    public function insertBrand($data)
    {
        $this->db->query('LOCK TABLES ms_brand WRITE');

        $save = $this->db->table($this->table)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'brand', $id);
        return $save;
    }

    public function updateBrand($data)
    {
        $this->db->query('LOCK TABLES ms_brand WRITE');
        $save = $this->db->table($this->table)->update($data, ['brand_id' => $data['brand_id']]);

        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'brand', $data['brand_id']);
        return $save;
    }

    public function deleteBrand($brand_id)
    {
        $this->db->query('LOCK TABLES ms_brand WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['brand_id' => $brand_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'brand', $brand_id);
        return $save;
    }
}
