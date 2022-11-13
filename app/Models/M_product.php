<?php

namespace App\Models;

use CodeIgniter\Model;

class M_product extends Model
{
    protected $table = 'ms_product';
    protected $tProductSupplier = 'ms_product_supplier';
    protected $tProductUnit = 'ms_product_unit';

    public function getProduct($product_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_product.*,ms_brand.brand_name,ms_category.category_name');
        $builder->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id');
        $builder->join('ms_category', 'ms_category.category_id=ms_product.category_id');

        if ($product_id  != '') {
            $builder->where('ms_product.product_id', $product_id);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['ms_product.deleted' => 'N']);
        }

        return $builder->get();
    }

    public function getProductSupplier($product_id)
    {
        return $this->db->table('ms_product_supplier')
            ->select('ms_product_supplier.*,ms_supplier.supplier_name')
            ->join('ms_supplier', 'ms_supplier.supplier_id=ms_product_supplier.supplier_id')
            ->where('ms_product_supplier.product_id', $product_id)
            ->get();
    }

    public function getProductUnit($product_id)
    {
        return $this->db->table('ms_product_unit')
            ->select('ms_product_unit.*,(ms_product_unit.product_content*ms_product.base_purchase_price) as product_price,(ms_product_unit.product_content*ms_product.base_purchase_tax) as product_tax,ms_unit.unit_name')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->where('ms_product_unit.product_id', $product_id)
            ->get();
    }


    public function getProductByName($product_name, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->where(['product_name' => $product_name]);
        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }
        return $builder->get();
    }

    public function hasTransaction($product_id)
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

    public function insertProduct($data)
    {
        $this->db->query('LOCK TABLES ms_product WRITE,ms_product_supplier WRITE,ms_product_unit WRITE');

        $saveQueries = NULL;
        $product_id = 0;

        $maxCode = $this->db->table($this->table)->select('product_code')->limit(1)->orderBy('product_id', 'desc')->get()->getRowArray();
        if ($maxCode == NULL) {
            $data['product_code'] = "P000001";
        } else {
            $data['product_code'] = 'P' . substr('000000' . strval(floatval(substr($maxCode['product_code'], -6)) + 1), -6);
        }


        $supplier_id    = is_string($data['supplier_id']) ? explode(',', $data['supplier_id']) : $data['supplier_id'];
        $unit_id        = $data['base_unit'];
        unset($data['supplier_id']);
        unset($data['base_unit']);

        $this->db->transBegin();
        $this->db->table($this->table)->insert($data);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
            $product_id = $this->db->insertID();
        }

        $data_supplier = [];
        foreach ($supplier_id as $sid) {
            $data_supplier[] = [
                'product_id' => $product_id,
                'supplier_id' => $sid
            ];
        }
        $this->db->table($this->tProductSupplier)->insertBatch($data_supplier);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        $data_unit = [
            'item_code'             => $product_id,
            'product_id'            => $product_id,
            'unit_id'               => $unit_id,
            'base_unit'             => 'Y',
            'product_content'       => 1,
            'is_sale'               => 'N',
            'show_on_mobile_apps'   => 'N',
            'allow_change_price'    => 'N',
        ];
        $this->db->table($this->tProductUnit)->insert($data_unit);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $saveQueries = NULL;
            $save = 0;
        } else {
            $this->db->transCommit();
            $save = 1;
        }

        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'product',  $product_id, 'add');
        return $save;
    }

    public function updateProduct($data)
    {
        $this->db->query('LOCK TABLES ms_product WRITE,ms_product_supplier WRITE');

        $saveQueries = NULL;
        $product_id = $data['product_id'];

        $supplier_id    = is_string($data['supplier_id']) ? explode(',', $data['supplier_id']) : $data['supplier_id'];
        unset($data['supplier_id']);

        $this->db->transBegin();
        $this->db->table($this->table)->where('product_id', $product_id)->update($data);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        $data_supplier = [];
        foreach ($supplier_id as $sid) {
            $data_supplier[] = [
                'product_id' => $product_id,
                'supplier_id' => $sid
            ];
        }

        $this->db->table($this->tProductSupplier)->where('product_id', $product_id)->delete();
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        $this->db->table($this->tProductSupplier)->insertBatch($data_supplier);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $saveQueries = NULL;
            $save = 0;
        } else {
            $this->db->transCommit();
            $save = 1;
        }

        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'product',  $product_id, 'edit');
        return $save;
    }

    public function deleteProduct($product_id)
    {
        $this->db->query('LOCK TABLES ms_product WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['product_id' => $product_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'product', $product_id, 'delete');
        return $save;
    }
}
