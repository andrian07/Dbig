<?php

namespace App\Models;

use CodeIgniter\Model;

class M_cronjob extends Model
{
    protected $table = 'list_purchase_order';

    public function insertListPurchaseOrder($orderData, $insertDate)
    {
        $isSuccess = true;
        if (count($orderData) > 0) {
            $saveQueries = NULL;
            $this->db->query('LOCK TABLES list_purchase_order WRITE');
            $this->db->transBegin();
            $max_insert = 500;

            $this->db->table('list_purchase_order')->where('update_date', $insertDate)->delete();

            $batchUpdate = array_chunk($orderData, $max_insert);
            foreach ($batchUpdate as $batch) {
                $this->db->table('list_purchase_order')->insertBatch($batch);
                if ($this->db->affectedRows() > 0) {
                    $saveQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                $isSuccess = false;
                $saveQueries = NULL;
            } else {
                $this->db->transCommit();
            }

            $this->db->query('UNLOCK TABLES');

            logQueries($saveQueries, 'list_purchase_order', 0, 'CJ_UPDATE');
            return $isSuccess;
        }
    }

    public function insertListUpdateSafetyStock($listData, $insertDate)
    {
        $isSuccess = true;
        if (count($listData) > 0) {
            $this->db->query('LOCK TABLES list_update_safety_stock WRITE');
            $this->db->transBegin();
            $max_insert = 500;

            $this->db->table('list_update_safety_stock')->where('update_date', $insertDate)->delete();

            $batchUpdate = array_chunk($listData, $max_insert);
            foreach ($batchUpdate as $batch) {
                $this->db->table('list_update_safety_stock')->insertBatch($batch);
            }

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                $isSuccess = false;
            } else {
                $this->db->transCommit();
            }

            $this->db->query('UNLOCK TABLES');
        }
        return $isSuccess;
    }

    public function getListUpdateSafetyStock($updateDate = '', $autoDelete = true)
    {
        if ($updateDate == '') {
            return [];
        } else {
            $builder = $this->db->table('list_update_safety_stock');

            $getData = $builder->select('list_update_safety_stock.product_id,ms_product.product_code,ms_product.product_name,list_update_safety_stock.old_min_stock,list_update_safety_stock.three_month_sales,list_update_safety_stock.new_min_stock')
                ->join('ms_product', 'ms_product.product_id=list_update_safety_stock.product_id')
                ->where('list_update_safety_stock.update_date', $updateDate)
                ->get()->getResultArray();

            return $getData;
        }
    }


    public function updateMinStock($productData = [])
    {
        $isSuccess = true;
        if (count($productData) > 0) {
            $saveQueries = NULL;
            $this->db->query('LOCK TABLES ms_product WRITE');
            $this->db->transBegin();
            $max_insert = 500;
            $base_sql = "INSERT INTO ms_product(product_id,min_stock) VALUES";
            $batchUpdate = array_chunk($productData, $max_insert);
            foreach ($batchUpdate as $batch) {
                $values = [];
                foreach ($batch as $row) {
                    $product_id = $row['product_id'];
                    $min_stock  = $row['min_stock'];
                    $values[] = "('$product_id','$min_stock')";
                }

                $sqltext = $base_sql . implode(',', $values) . ' ON DUPLICATE KEY UPDATE min_stock=VALUES(min_stock)';
                $this->db->query($sqltext);
                if ($this->db->affectedRows() > 0) {
                    $saveQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                $isSuccess = false;
                $saveQueries = NULL;
            } else {
                $this->db->transCommit();
            }

            $this->db->query('UNLOCK TABLES');
            logQueries($saveQueries, 'ms_product', 0, 'CJ_UPDATE');
            return $isSuccess;
        }
    }

    public function deleteRecapData($max_date)
    {
        $deleteListPO = $this->db->table('list_purchase_order')->where('update_date<', $max_date)->delete();
        $deleteListSafety = $this->db->table('list_update_safety_stock')->where('update_date<', $max_date)->delete();
        return $deleteListPO && $deleteListSafety;
    }
}
