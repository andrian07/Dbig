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

    public function getListProductUnit($item_id)
    {
        return $this->db->table('ms_product_unit')
            ->select('ms_product.product_code,ms_product.product_name,ms_product_unit.*,(ms_product_unit.product_content*ms_product.base_purchase_price) as product_price,(ms_product_unit.product_content*ms_product.base_purchase_tax) as product_tax,ms_unit.unit_name')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->whereIn('ms_product_unit.item_id', $item_id)
            ->get();
    }

    public function getProductStock($product_id)
    {
        return $this->db->table('ms_product_stock')
            ->select('ms_product_stock.*,ms_warehouse.warehouse_code,ms_warehouse.warehouse_name,ms_store.store_name')
            ->join('ms_warehouse', 'ms_warehouse.warehouse_id=ms_product_stock.warehouse_id')
            ->join('ms_store', 'ms_store.store_id=ms_warehouse.store_id')
            ->where('ms_product_stock.product_id', $product_id)
            ->get();
    }

    public function getParcelItem($product_id)
    {
        return $this->db->table('ms_product_parcel')
            ->select('ms_product_parcel.product_id as parcel_id,ms_product_parcel.item_qty,ms_product.product_name,ms_product_unit.*,(ms_product_unit.product_content*ms_product.base_purchase_price) as purchase_price,(ms_product_unit.product_content*ms_product.base_purchase_tax) as purchase_tax,ms_unit.unit_name')
            ->join('ms_product_unit', 'ms_product_unit.item_id=ms_product_parcel.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->where('ms_product_parcel.product_id', $product_id)
            ->get();
    }

    public function getProductUnitByCode($item_code)
    {
        return $this->db->table('ms_product_unit')
            ->select('ms_product_unit.*,(ms_product_unit.product_content*ms_product.base_purchase_price) as product_price,(ms_product_unit.product_content*ms_product.base_purchase_tax) as product_tax,ms_unit.unit_name')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->where('ms_product_unit.item_code', $item_code)
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

    public function productUnitHasTransaction($item_id)
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

        $margin_allocation = 0;
        if ($data['has_tax'] == 'Y') {
            $margin_allocation = 50;
        }

        $data_unit = [
            'item_code'             => $product_id,
            'product_id'            => $product_id,
            'unit_id'               => $unit_id,
            'base_unit'             => 'Y',
            'product_content'       => 1,
            'margin_allocation'     => $margin_allocation,
            'is_sale'               => 'N',
            'show_on_mobile_app'    => 'N',
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


    public function searchProductUnitByName($keyword, $isItemCode = FALSE, $limit = 10)
    {
        $builder = $this->db->table('ms_product_unit');
        $builder->select('ms_product_unit.*,ms_product.product_name,ms_product_unit.item_code,(ms_product.base_purchase_price*ms_product_unit.product_content) as purchase_price,(ms_product.base_purchase_tax*ms_product_unit.product_content) as purchase_tax,ms_unit.unit_name,ms_product.is_parcel,base_purchase_price,base_purchase_tax,base_cogs, product_code')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->where('ms_product.deleted', 'N')
            ->where('ms_product.active', 'Y')
            ->where('ms_product.is_parcel', 'N');

        if ($isItemCode) {
            $builder->where('ms_product_unit.item_code', $keyword);
            $builder->orLike('ms_product.product_code', $keyword);
        } else {
            $builder->groupStart();
            $builder->like('ms_product_unit.item_code', $keyword);
            $builder->orLike('ms_product.product_name', $keyword);
            $builder->orLike('ms_product.product_code', $keyword);
            $builder->groupEnd();
        }
        return  $builder->limit($limit)->get();
    }

    public function searchProductBysuplier($keyword, $supplier_id = '', $isItemCode = FALSE, $limit = 10)
    {

        $builder = $this->db->table('ms_product_unit');
        $builder->select('ms_product_unit.*,ms_product.product_name,(ms_product.base_purchase_price*ms_product_unit.product_content) as purchase_price,(ms_product.base_purchase_tax*ms_product_unit.product_content) as purchase_tax,ms_unit.unit_name,ms_product.is_parcel, product_code')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_product_supplier', 'ms_product_supplier.product_id = ms_product.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->where('ms_product.deleted', 'N')
            ->where('ms_product.active', 'Y')
            ->where('ms_product.is_parcel', 'N');

        if ($isItemCode) {
            $builder->where('ms_product_unit.item_code', $keyword);
            $builder->orLike('ms_product.product_code', $keyword);
        } else {
            $builder->groupStart();
            $builder->Like('ms_product.product_name', $keyword);
            $builder->Like('ms_product_supplier.supplier_id', $supplier_id);
            $builder->orLike('ms_product_unit.item_code', $keyword);
            $builder->orLike('ms_product.product_code', $keyword);
            $builder->groupEnd();
        }
        return  $builder->limit($limit)->get();
    }

    public function searchProductBywarehouse($keyword, $warehouse_id = '', $isItemCode = FALSE, $limit = 10)
    {

        $builder = $this->db->table('ms_product_unit');
        $builder->select('ms_product_unit.*,ms_product.product_name,(ms_product.base_purchase_price*ms_product_unit.product_content) as purchase_price,(ms_product.base_purchase_tax*ms_product_unit.product_content) as purchase_tax,ms_unit.unit_name,ms_product.is_parcel,ms_product_stock.stock as warehouse_stock')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_product_stock', 'ms_product_stock.product_id = ms_product.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->where('ms_product.deleted', 'N')
            ->where('ms_product.active', 'Y');
        if ($isItemCode) {
            $builder->where('ms_product_unit.item_code', $keyword);
        } else {
            $builder->groupStart();
            $builder->Like('ms_product.product_name', $keyword);
            $builder->Like('ms_product_stock.warehouse_id', $warehouse_id);
            $builder->orLike('ms_product_unit.item_code', $keyword);
            $builder->groupEnd();
        }
        return  $builder->limit($limit)->get();
    }

    public function insertProductUnit($data)
    {
        $this->db->query('LOCK TABLES ms_product WRITE,ms_product_unit WRITE');

        $saveQueries = NULL;


        $product_id         = $data['product_id'];
        $product_content    = floatval($data['product_content']);
        $purchase_price     = floatval($data['purchase_price']);
        $purchase_tax       = floatval($data['purchase_tax']);


        $base_purchase_price = round(($purchase_price / $product_content), 2);
        $base_purchase_tax   = round(($purchase_tax / $product_content), 2);

        unset($data['purchase_price']);
        unset($data['purchase_tax']);
        $data['base_unit'] = 'N';


        $this->db->transBegin();

        $this->db->table($this->tProductUnit)->insert($data);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        $update_data = [
            'base_purchase_price'   => $base_purchase_price,
            'base_purchase_tax'     => $base_purchase_tax
        ];

        $this->db->table($this->table)->update($update_data, ['product_id' => $product_id]);
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
        saveQueries($saveQueries, 'product',  $product_id, 'add_item');
        return $save;
    }

    public function updateProductUnit($data)
    {
        $this->db->query('LOCK TABLES ms_product WRITE,ms_product_unit WRITE');

        $saveQueries = NULL;

        $item_id            = $data['item_id'];
        $product_id         = $data['product_id'];
        $product_content    = floatval($data['product_content']);
        $purchase_price     = floatval($data['purchase_price']);
        $purchase_tax       = floatval($data['purchase_tax']);


        $base_purchase_price = round(($purchase_price / $product_content), 2);
        $base_purchase_tax   = round(($purchase_tax / $product_content), 2);

        unset($data['purchase_price']);
        unset($data['purchase_tax']);


        $this->db->transBegin();

        $this->db->table($this->tProductUnit)->update($data, ['item_id' => $item_id]);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        $update_data = [
            'base_purchase_price'   => $base_purchase_price,
            'base_purchase_tax'     => $base_purchase_tax
        ];

        $this->db->table($this->table)->update($update_data, ['product_id' => $product_id]);
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
        saveQueries($saveQueries, 'product',  $product_id, 'update_item');
        return $save;
    }

    public function deleteProductUnit($item_id)
    {
        $getProductUnit = $this->db->table('ms_product_unit')->where('item_id', $item_id)->get()->getRowArray();
        if ($getProductUnit != NULL) {
            $this->db->query('LOCK TABLES ms_product_unit WRITE');
            $saveQueries = NULL;

            $product_id  = $getProductUnit['product_id'];
            $delete = $this->db->table($this->tProductUnit)->where('item_id', $item_id)->delete();
            if ($this->db->affectedRows() > 0) {
                $saveQueries = $this->db->getLastQuery()->getQuery();
            }

            $this->db->query('UNLOCK TABLES');
            saveQueries($saveQueries, 'product',  $product_id, 'delete_item');
            return $delete;
        } else {
            return 0;
        }
    }

    public function updateParcel($data, $user_id)
    {
        $this->db->query('LOCK TABLES ms_product WRITE,ms_product_unit WRITE,ms_product_parcel WRITE,temp_parcel WRITE,ms_unit READ');
        $saveQueries = NULL;

        $item_id            = $data['item_id'];
        $product_id         = $data['product_id'];
        $total_parcel_price = 0;
        $total_parcel_tax   = 0;

        $getTemp = $this->getTempParcel($product_id, $user_id)->getResultArray();
        $parcel_item_list = [];
        $parcel_delete_product_list = [];
        $query_update_parcel = "INSERT INTO ms_product_parcel(product_id,item_id,item_qty) VALUES";

        foreach ($getTemp as $row) {
            if ($row['temp_delete'] == 'Y') {
                $parcel_delete_product_list[] = $row['item_id'];
            } else {
                $parcel_item_id         = $row['item_id'];
                $parcel_item_qty        = floatval($row['item_qty']);
                $purchase_price         = floatval($row['purchase_price']);
                $purchase_tax           = floatval($row['purchase_tax']);

                $total_parcel_price += ($purchase_price * $parcel_item_qty);
                $total_parcel_tax   += ($purchase_tax * $parcel_item_qty);

                $parcel_item_list[] = "('$product_id','$parcel_item_id',$parcel_item_qty)";
            }
        }

        $query_update_parcel .= implode(',', $parcel_item_list) . " ON DUPLICATE KEY UPDATE item_qty=VALUES(item_qty)";

        $base_purchase_price   = floatval($data['purchase_price']);
        $base_purchase_tax     = floatval($data['purchase_tax']);

        unset($data['purchase_price']);
        unset($data['purchase_tax']);
        $this->db->transBegin();

        $this->db->table($this->tProductUnit)->update($data, ['item_id' => $item_id]);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        $update_data = [
            'base_purchase_price'   => $base_purchase_price,
            'base_purchase_tax'     => $base_purchase_tax
        ];

        $this->db->table($this->table)->update($update_data, ['product_id' => $product_id]);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }


        $this->db->query($query_update_parcel);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        if (count($parcel_delete_product_list) > 0) {
            $this->db->table('ms_product_parcel')->where('product_id', $product_id)->whereIn('item_id', $parcel_delete_product_list)->delete();
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }
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
        saveQueries($saveQueries, 'product',  $product_id, 'update_parcel');
        return $save;
    }

    public function getTempParcel($product_id, $user_id)
    {
        return $this->db->table('temp_parcel')
            ->select('temp_parcel.product_id as parcel_id,temp_parcel.item_qty,ms_product.product_name,ms_product_unit.*,(ms_product_unit.product_content*ms_product.base_purchase_price) as purchase_price,(ms_product_unit.product_content*ms_product.base_purchase_tax) as purchase_tax,ms_unit.unit_name,temp_parcel.temp_add,temp_parcel.temp_delete')
            ->join('ms_product_unit', 'ms_product_unit.item_id=temp_parcel.item_id')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->where('temp_parcel.product_id', $product_id)
            ->where('temp_parcel.user_id', $user_id)
            ->get();
    }

    public function copyToTempParcel($product_id, $user_id)
    {
        $this->db->table('temp_parcel')->where('product_id', $product_id)->where('user_id', $user_id)->delete();
        $getData = $this->db->table('ms_product_parcel')->where('product_id', $product_id)->get()->getResultArray();

        $data_parcel = [];

        foreach ($getData as $item) {
            $data_parcel[] = [
                'item_id'       => $item['item_id'],
                'product_id'    => $item['product_id'],
                'item_qty'      => $item['item_qty'],
                'user_id'       => $user_id,
                'temp_add'      => 'N'
            ];
        }
        if (count($data_parcel) > 0) {
            $this->db->table('temp_parcel')->insertBatch($data_parcel);
        }

        return $this->getTempParcel($product_id, $user_id);
    }

    public function insertTempParcel($data)
    {
        $wheres = [
            'item_id'       => $data['item_id'],
            'product_id'    => $data['product_id'],
            'user_id'       => $data['user_id'],
        ];

        $data['temp_delete'] = 'N';
        $getData = $this->db->table('temp_parcel')->where($wheres)->get()->getRowArray();
        if ($getData == NULL) {
            return $this->db->table('temp_parcel')->insert($data);
        } else {

            return $this->db->table('temp_parcel')->update($data, $wheres);
        }
    }

    public function deleteTempParcel($item_id, $product_id, $user_id)
    {
        $wheres = [
            'item_id'       => $item_id,
            'product_id'    => $product_id,
            'user_id'       => $user_id,
        ];

        $getData = $this->db->table('temp_parcel')->where($wheres)->get()->getRowArray();
        if ($getData == NULL) {
            return 1;
        } else {
            $temp_add = $getData['temp_add'];
            if ($temp_add == 'Y') {
                return $this->db->table('temp_parcel')->where($wheres)->delete();
            } else {
                return $this->db->table('temp_parcel')->where($wheres)->update(['temp_delete' => 'Y']);
            }
        }
    }

    //import product //
    public function importProduct($productData, $productSuppliers, $productItem, $parcelItem)
    {
        $this->db->query('LOCK TABLES ms_product WRITE,ms_product_supplier WRITE,ms_product_unit WRITE,ms_product_parcel WRITE');
        $saveQueries    = NULL;
        $errors         = [];

        $this->db->transBegin();
        $startNum = 1;
        $maxCode = $this->db->table($this->table)->select('product_code')->limit(1)->orderBy('product_id', 'desc')->get()->getRowArray();
        if ($maxCode == NULL) {
            $startNum = 1;
        } else {
            $startNum = intval(substr($maxCode['product_code'], -6)) + 1;
        }

        $listProductID  = [];
        $listItemID     = [];

        foreach ($productData as $product_code => $product) {
            // insert product //
            $product['product_code'] = 'P' . substr('000000' . strval($startNum), -6);
            $this->db->table('ms_product')->insert($product);
            $product_id = 0;
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
                $product_id = $this->db->insertID();
            }
            $errors[] = $this->db->error();
            $listProductID[$product_code] = $product_id;


            // insert product supplier //
            $insertProductSupplier = [];
            foreach ($productSuppliers[$product_code] as $supplier_id) {
                $insertProductSupplier[] = [
                    'product_id'    => $product_id,
                    'supplier_id'   => $supplier_id
                ];
            }

            if (count($insertProductSupplier) > 0) {
                $this->db->table('ms_product_supplier')->insertBatch($insertProductSupplier);
                if ($this->db->affectedRows() > 0) {
                    $saveQueries[] = $this->db->getLastQuery()->getQuery();
                }
                $errors[] = $this->db->error();
            }
            $startNum++;
        }

        if (count($productItem) > 0) {
            foreach ($productItem as $product_code => $items) {
                $product_id = isset($listProductID[$product_code]) ? $listProductID[$product_code] : 0;
                foreach ($items as $item) {
                    $item['product_id'] = $product_id;
                    $item_id    = 0;
                    $item_code  = $item['item_code'];

                    $this->db->table('ms_product_unit')->insert($item);
                    if ($this->db->affectedRows() > 0) {
                        $saveQueries[] = $this->db->getLastQuery()->getQuery();
                        $item_id = $this->db->insertID();
                    }
                    $errors[] = $this->db->error();
                    $listItemID[$item_code] = $item_id;
                }
            }
        }

        if (count($parcelItem) > 0) {
            foreach ($parcelItem as $product_code => $items) {
                $product_id = isset($listProductID[$product_code]) ? $listProductID[$product_code] : 0;
                $insertParcelItem = [];
                foreach ($items as $item) {
                    $item_code = $item['item_code'];
                    unset($item['item_code']);
                    $item['item_id']    = isset($listItemID[$item_code]) ? $listItemID[$item_code] : 0;
                    $item['product_id'] = $product_id;
                    $insertParcelItem[] = $item;
                }

                if (count($insertParcelItem) > 0) {
                    $this->db->table('ms_product_parcel')->insertBatch($insertParcelItem);
                    if ($this->db->affectedRows() > 0) {
                        $saveQueries[] = $this->db->getLastQuery()->getQuery();
                    }
                    $errors[] = $this->db->error();
                }
            }
        }

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $saveQueries = NULL;
            $save = ['success' => FALSE, 'errors' => $errors, 'message' => 'Import data produk gagal'];
        } else {
            $this->db->transCommit();
            $save = ['success' => TRUE, 'errors' => $errors, 'message' => 'Import data produk berhasil'];
        }

        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'product', 0, 'import');
        return $save;
    }


    //report section//
    public function getReportWarehouseStockList($warehouse_id = '', $product_tax = '')
    {
        $builder = $this->db->table('ms_product_stock');
        $builder->select('ms_product_stock.product_id,ms_product_stock.warehouse_id,ms_product_stock.stock,ms_product.product_code,ms_product.product_name,ms_category.category_name,ms_brand.brand_name,ms_warehouse.warehouse_code,ms_warehouse.warehouse_name,ms_product.has_tax')
            ->join('ms_product', 'ms_product.product_id=ms_product_stock.product_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_warehouse', 'ms_warehouse.warehouse_id=ms_product_stock.warehouse_id');

        if ($warehouse_id != '') {
            $builder->where('ms_product_stock.warehouse_id', $warehouse_id);
        }

        if ($product_tax != '') {
            $builder->where('ms_product.has_tax', $product_tax);
        }

        $builder->orderBy('ms_product.product_name,ms_warehouse.warehouse_code', 'ASC');
        return $builder->get();
    }

    public function getReportExpStockList($warehouse_id = '')
    {
        $builder = $this->db->table('ms_warehouse_stock');
        $builder->select('ms_warehouse_stock.product_id,ms_warehouse_stock.warehouse_id,sum(ms_warehouse_stock.stock) as stock,ms_warehouse_stock.exp_date,ms_product.product_code,ms_product.product_name,ms_category.category_name,ms_brand.brand_name,ms_warehouse.warehouse_code,ms_warehouse.warehouse_name,ms_product.has_tax')
            ->join('ms_product', 'ms_product.product_id=ms_warehouse_stock.product_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_warehouse', 'ms_warehouse.warehouse_id=ms_warehouse_stock.warehouse_id');

        if ($warehouse_id != '') {
            $builder->where('ms_warehouse_stock.warehouse_id', $warehouse_id);
        }

        $builder->where('ms_warehouse_stock.stock>', '0');

        $now = date('Y-m-d');
        $builder->where("ms_warehouse_stock.exp_date <= CAST('$now' AS DATE)");

        $builder->groupBy('ms_warehouse_stock.product_id,ms_warehouse_stock.warehouse_id,ms_warehouse_stock.exp_date');
        $builder->orderBy('ms_product.product_name,ms_warehouse.warehouse_code', 'ASC');
        return $builder->get();
    }

    public function getReportExpStockList_old($warehouse_id = '')
    {
        $builder = $this->db->table('ms_warehouse_stock');
        $builder->select('ms_warehouse_stock.product_id,ms_warehouse_stock.warehouse_id,ms_warehouse_stock.stock,ms_warehouse_stock.exp_date,ms_product.product_code,ms_product.product_name,ms_category.category_name,ms_brand.brand_name,ms_warehouse.warehouse_code,ms_warehouse.warehouse_name,ms_product.has_tax')
            ->join('ms_product', 'ms_product.product_id=ms_warehouse_stock.product_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_warehouse', 'ms_warehouse.warehouse_id=ms_warehouse_stock.warehouse_id');

        if ($warehouse_id != '') {
            $builder->where('ms_warehouse_stock.warehouse_id', $warehouse_id);
        }

        $builder->where('ms_warehouse_stock.stock>', '0');

        $now = date('Y-m-d');
        $builder->where("ms_warehouse_stock.exp_date <= CAST('$now' AS DATE)");

        $builder->orderBy('ms_product.product_name,ms_warehouse.warehouse_code', 'ASC');
        return $builder->get();
    }


    public function getListProductUnitByIDorBrand($item_id = [], $brand_id = [])
    {
        $builder =  $this->db->table('ms_product_unit')
            ->select('ms_product.product_code,ms_product.product_name,ms_product_unit.*,(ms_product_unit.product_content*ms_product.base_purchase_price) as product_price,(ms_product_unit.product_content*ms_product.base_purchase_tax) as product_tax,ms_unit.unit_name')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->where('ms_product.deleted', 'N');

        if (count($item_id) > 0) {
            $builder->whereIn('ms_product_unit.item_id', $item_id);
        }

        if (count($brand_id) > 0) {
            $builder->whereIn('ms_product.brand_id', $brand_id);
        }

        return $builder->get();
    }
}
