<?php

namespace App\Models;

use CodeIgniter\Model;

class M_category extends Model
{
    protected $table = 'ms_category';

    public function getCategory($category_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        if ($category_id  != '') {
            $builder->where(['category_id' => $category_id]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }

        return $builder->get();
    }

    public function getCategoryByName($category_name, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->where(['category_name' => $category_name]);
        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }
        return $builder->get();
    }

    public function hasProduct($category_id)
    {
        return 0;
        // $getData = $this->db->table('ms_product')
        //     ->select('product_code')
        //     ->where('category_id', $category_id)
        //     ->limit(1)->get()->getRowArray();

        // if ($getData == NULL) {
        //     return 0;
        // } else {
        //     return 1;
        // }
    }

    public function insertCategory($data)
    {
        $this->db->query('LOCK TABLES ms_category WRITE');
        $save = $this->db->table($this->table)->insert($data);
        $saveQueries = NULL;
        $id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
            $id = $this->db->insertID();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'category', $id);
        return $save;
    }

    public function updateCategory($data)
    {
        $this->db->query('LOCK TABLES ms_category WRITE');
        $save = $this->db->table($this->table)->update($data, ['category_id' => $data['category_id']]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'category', $data['category_id']);
        return $save;
    }

    public function deleteCategory($category_id)
    {
        $this->db->query('LOCK TABLES ms_category WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['category_id' => $category_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'category', $category_id);
        return $save;
    }
}
