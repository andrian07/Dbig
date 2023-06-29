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
            $product_code = "00000001";
        } else {
            $product_code =  substr('00000000' . strval(floatval($maxCode['product_code']) + 1), -8);
        }

        $data['product_code'] = $product_code;

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

        $item_code  = $product_code;
        $addNum     = 1;
        $isExist    = true;
        while ($isExist) {
            $check = $this->db->table('ms_product_unit')->select('item_id')->where('item_code', $item_code)->get()->getRowArray();
            if ($check == null) {
                $isExist = false;
            } else {
                $item_code = $item_code . strval($addNum);
                $addNum++;
            }
        }


        $data_unit = [
            'item_code'             => $item_code,
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
    public function importProduct_v1($productData, $productSuppliers, $productItem, $parcelItem)
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

    public function importProduct($productData, $productSuppliers, $productItem, $parcelItem)
    {
        $this->db->query('LOCK TABLES ms_product WRITE,ms_product_supplier WRITE,ms_product_unit WRITE,ms_product_parcel WRITE');
        $saveQueries    = NULL;
        $errors         = [];

        $this->db->transBegin();


        $listProductID  = [];
        $listItemID     = [];

        foreach ($productData as $product_code => $product) {
            // insert product //
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

    public function batchUpdateProduct($productData, $productUnit)
    {
        $this->db->query('LOCK TABLES ms_product WRITE,ms_product_unit WRITE');
        $saveQueries    = NULL;
        $errors         = [];

        $this->db->transBegin();

        if (count($productData) > 0) {
            foreach ($productData as $row) {
                $this->db->table('ms_product')->where('product_id', $row['product_id'])->update($row);
                if ($this->db->affectedRows() > 0) {
                    $saveQueries[] = $this->db->getLastQuery()->getQuery();
                }
                $errors[] = $this->db->error();
            }
        }


        if (count($productUnit) > 0) {
            foreach ($productUnit as $row) {
                $this->db->table('ms_product_unit')->where('item_id', $row['item_id'])->update($row);
                if ($this->db->affectedRows() > 0) {
                    $saveQueries[] = $this->db->getLastQuery()->getQuery();
                }
                $errors[] = $this->db->error();
            }
        }

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $saveQueries = NULL;
            $save = ['success' => FALSE, 'errors' => $errors, 'message' => 'Update data produk gagal'];
        } else {
            $this->db->transCommit();
            $save = ['success' => TRUE, 'errors' => $errors, 'message' => 'Update data produk berhasil'];
        }

        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'product', 0, 'batch_update');
        return $save;
    }


    //report section//

    public function getReportProductList($has_tax = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_product.*,ms_brand.brand_name,ms_category.category_name');
        $builder->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id');
        $builder->join('ms_category', 'ms_category.category_id=ms_product.category_id');

        if ($has_tax  != '') {
            $builder->where('ms_product.has_tax', $has_tax);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['ms_product.deleted' => 'N']);
        }

        return $builder->get();
    }

    public function getReportInitStock($product_ids = [], $start_date = null, $end_date = null)
    {
        // query dengan format return product_id | warehouse_id | stock_date | stock(qty*product_content) | created_at //

        // getting from purchase //
        $builder = $this->db->table('dt_purchase');
        $builder->select('ms_product_unit.product_id,hd_purchase.purchase_warehouse_id as warehouse_id,hd_purchase.purchase_date AS stock_date,(ms_product_unit.product_content*dt_purchase.dt_purchase_qty) AS stock,hd_purchase.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_purchase.dt_purchase_item_id')
            ->join('hd_purchase', 'hd_purchase.purchase_invoice=dt_purchase.dt_purchase_invoice')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_purchase.purchase_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_purchase.purchase_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchase = $builder->getCompiledSelect();

        // getting from purchase return //
        $builder = $this->db->table('dt_retur_purchase');
        $builder->select('ms_product_unit.product_id,dt_retur_purchase.dt_retur_warehouse as warehouse_id,hd_retur_purchase.hd_retur_date AS stock_date,(ms_product_unit.product_content*dt_retur_purchase.dt_retur_qty) AS stock,hd_retur_purchase.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_retur_purchase.dt_retur_item_id')
            ->join('hd_retur_purchase', 'hd_retur_purchase.hd_retur_purchase_id=dt_retur_purchase.hd_retur_purchase_id')
            ->where('hd_retur_purchase.hd_retur_status', 'Selesai')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_retur_purchase.hd_retur_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_retur_purchase.hd_retur_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchaseReturn = $builder->getCompiledSelect();


        // getting from hd_purchase_consignment //
        $builder = $this->db->table('dt_purchase_consignment');
        $builder->select('ms_product_unit.product_id,hd_purchase_consignment.purchase_consignment_warehouse_id as warehouse_id,hd_purchase_consignment.purchase_consignment_date AS stock_date,(ms_product_unit.product_content*dt_purchase_consignment.dt_consignment_qty) AS stock,hd_purchase_consignment.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_purchase_consignment.dt_consignment_item_id')
            ->join('hd_purchase_consignment', 'hd_purchase_consignment.purchase_consignment_invoice=dt_purchase_consignment.dt_consignment_invoice')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_purchase_consignment.purchase_consignment_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_purchase_consignment.purchase_consignment_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchaseConsignment = $builder->getCompiledSelect();


        // getting from sales pos //
        $builder = $this->db->table('dt_pos_sales');
        $builder->select('ms_product_unit.product_id,hd_pos_sales.warehouse_id,hd_pos_sales.pos_sales_date AS stock_date,((ms_product_unit.product_content*dt_pos_sales.sales_qty)*-1) AS stock,hd_pos_sales.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_pos_sales.pos_sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_pos_sales.pos_sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesPos = $builder->getCompiledSelect();


        // getting from sales return pos //
        $builder = $this->db->table('dt_pos_sales_return');
        $builder->select('ms_product_unit.product_id,hd_pos_sales_return.warehouse_id,hd_pos_sales_return.pos_sales_return_date AS stock_date,(ms_product_unit.product_content*dt_pos_sales_return.sales_return_qty) AS stock,hd_pos_sales_return.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales_return.item_id')
            ->join('hd_pos_sales_return', 'hd_pos_sales_return.pos_sales_return_id=dt_pos_sales_return.pos_sales_return_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_pos_sales_return.pos_sales_return_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesPosReturn = $builder->getCompiledSelect();


        // getting from sales admin //
        $builder = $this->db->table('dt_sales_admin');
        $builder->select('ms_product_unit.product_id,hd_sales_admin.sales_store_id as warehouse_id,hd_sales_admin.sales_date AS stock_date,((ms_product_unit.product_content*dt_sales_admin.dt_temp_qty)*-1) AS stock,hd_sales_admin.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_sales_admin.dt_item_id')
            ->join('hd_sales_admin', 'hd_sales_admin.sales_admin_id=dt_sales_admin.sales_admin_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_sales_admin.sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_sales_admin.sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesAdmin = $builder->getCompiledSelect();


        // getting from sales return admin //
        $builder = $this->db->table('dt_retur_sales_admin');
        $builder->select('ms_product_unit.product_id,hd_retur_sales_admin.hd_retur_store_id as warehouse_id,hd_retur_sales_admin.hd_retur_date AS stock_date,(ms_product_unit.product_content*dt_retur_sales_admin.dt_retur_qty) AS stock,hd_retur_sales_admin.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_retur_sales_admin.dt_retur_item_id')
            ->join('hd_retur_sales_admin', 'hd_retur_sales_admin.hd_retur_sales_admin_id=dt_retur_sales_admin.hd_retur_sales_admin_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_retur_sales_admin.hd_retur_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_retur_sales_admin.hd_retur_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesReturnAdmin = $builder->getCompiledSelect();



        // getting from stock opname //
        $builder = $this->db->table('dt_opname');
        $builder->select('dt_opname.product_id,hd_opname.warehouse_id,hd_opname.opname_date AS stock_date,(dt_opname.warehouse_stock-dt_opname.system_stock) AS stock,hd_opname.created_at')
            ->join('hd_opname', 'hd_opname.opname_id=dt_opname.opname_id')
            ->whereIn('dt_opname.product_id', $product_ids);
        if ($start_date == null) {
            $builder->where("hd_opname.opname_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_opname.opname_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlOpname = $builder->getCompiledSelect();


        // getting from transfer out //
        $builder = $this->db->table('dt_transfer_stock');
        $builder->select('ms_product_unit.product_id,hd_transfer_stock.hd_transfer_stock_warehose_from as warehouse_id,hd_transfer_stock.hd_transfer_stock_date AS stock_date,((ms_product_unit.product_content*dt_transfer_stock.item_qty)*-1) AS stock,hd_transfer_stock.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_transfer_stock.item_id')
            ->join('hd_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id=dt_transfer_stock.hd_transfer_stock_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_transfer_stock.hd_transfer_stock_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_transfer_stock.hd_transfer_stock_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlTransferOut = $builder->getCompiledSelect();

        // getting from transfer in //
        $builder = $this->db->table('dt_transfer_stock');
        $builder->select('ms_product_unit.product_id,hd_transfer_stock.hd_transfer_stock_warehose_to as warehouse_id,hd_transfer_stock.hd_transfer_stock_date AS stock_date,(ms_product_unit.product_content*dt_transfer_stock.item_qty) AS stock,hd_transfer_stock.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_transfer_stock.item_id')
            ->join('hd_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id=dt_transfer_stock.hd_transfer_stock_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_transfer_stock.hd_transfer_stock_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_transfer_stock.hd_transfer_stock_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlTransferIn = $builder->getCompiledSelect();


        $unionAll = "($sqlPurchase)
        UNION ALL
        ($sqlPurchaseReturn)
        UNION ALL
        ($sqlPurchaseConsignment)
        UNION ALL
        ($sqlSalesPos)
        UNION ALL
        ($sqlSalesPosReturn)
        UNION ALL
        ($sqlSalesAdmin)
        UNION ALL
        ($sqlSalesReturnAdmin)
        UNION ALL
        ($sqlOpname)
        UNION ALL
        ($sqlTransferOut)
        UNION ALL
        ($sqlTransferIn)";

        $sqlGetStockData = "SELECT stock_data.product_id,stock_data.warehouse_id,sum(stock_data.stock) as stock FROM ($unionAll) as stock_data GROUP BY stock_data.product_id,stock_data.warehouse_id";
        return $this->db->query($sqlGetStockData)->getResultArray();
    }

    public function getReportStockInOut($product_ids = [], $start_date = null, $end_date = null)
    {
        // query dengan format return product_id | warehouse_id | stock_date | stock_in|stock_out(qty*product_content) | created_at //

        // getting from purchase [IN]//
        $builder = $this->db->table('dt_purchase');
        $builder->select('ms_product_unit.product_id,hd_purchase.purchase_warehouse_id as warehouse_id,hd_purchase.purchase_date AS stock_date,(ms_product_unit.product_content*dt_purchase.dt_purchase_qty) AS stock_in,0 AS stock_out,hd_purchase.created_at', false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_purchase.dt_purchase_item_id')
            ->join('hd_purchase', 'hd_purchase.purchase_invoice=dt_purchase.dt_purchase_invoice')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_purchase.purchase_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_purchase.purchase_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchase = $builder->getCompiledSelect();

        // getting from purchase return [OUT]//
        $builder = $this->db->table('dt_retur_purchase');
        $builder->select('ms_product_unit.product_id,dt_retur_purchase.dt_retur_warehouse as warehouse_id,hd_retur_purchase.hd_retur_date AS stock_date,0 AS stock_in,((ms_product_unit.product_content*dt_retur_purchase.dt_retur_qty)*-1) AS stock_out,hd_retur_purchase.created_at', false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_retur_purchase.dt_retur_item_id')
            ->join('hd_retur_purchase', 'hd_retur_purchase.hd_retur_purchase_id=dt_retur_purchase.hd_retur_purchase_id')
            ->where('hd_retur_purchase.hd_retur_status', 'Selesai')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_retur_purchase.hd_retur_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_retur_purchase.hd_retur_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchaseReturn = $builder->getCompiledSelect();


        // getting from hd_purchase_consignment [IN]//
        $builder = $this->db->table('dt_purchase_consignment');
        $builder->select('ms_product_unit.product_id,hd_purchase_consignment.purchase_consignment_warehouse_id as warehouse_id,hd_purchase_consignment.purchase_consignment_date AS stock_date,(ms_product_unit.product_content*dt_purchase_consignment.dt_consignment_qty) AS stock_in,0 AS stock_out,hd_purchase_consignment.created_at', false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_purchase_consignment.dt_consignment_item_id')
            ->join('hd_purchase_consignment', 'hd_purchase_consignment.purchase_consignment_invoice=dt_purchase_consignment.dt_consignment_invoice')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_purchase_consignment.purchase_consignment_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_purchase_consignment.purchase_consignment_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchaseConsignment = $builder->getCompiledSelect();


        // getting from sales pos [OUT]//
        $builder = $this->db->table('dt_pos_sales');
        $builder->select('ms_product_unit.product_id,hd_pos_sales.warehouse_id,hd_pos_sales.pos_sales_date AS stock_date,0 AS stock_in,((ms_product_unit.product_content*dt_pos_sales.sales_qty)*-1) AS stock_out,hd_pos_sales.created_at', false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_pos_sales.pos_sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_pos_sales.pos_sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesPos = $builder->getCompiledSelect();


        // getting from sales return pos [IN]//
        $builder = $this->db->table('dt_pos_sales_return');
        $builder->select('ms_product_unit.product_id,hd_pos_sales_return.warehouse_id,hd_pos_sales_return.pos_sales_return_date AS stock_date,(ms_product_unit.product_content*dt_pos_sales_return.sales_return_qty) AS stock_in,0 AS stock_out,hd_pos_sales_return.created_at', false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales_return.item_id')
            ->join('hd_pos_sales_return', 'hd_pos_sales_return.pos_sales_return_id=dt_pos_sales_return.pos_sales_return_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_pos_sales_return.pos_sales_return_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesPosReturn = $builder->getCompiledSelect();


        // getting from sales admin [OUT]//
        $builder = $this->db->table('dt_sales_admin');
        $builder->select('ms_product_unit.product_id,hd_sales_admin.sales_store_id as warehouse_id,hd_sales_admin.sales_date AS stock_date,0 AS stock_in,((ms_product_unit.product_content*dt_sales_admin.dt_temp_qty)*-1) AS stock_out,hd_sales_admin.created_at', false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_sales_admin.dt_item_id')
            ->join('hd_sales_admin', 'hd_sales_admin.sales_admin_id=dt_sales_admin.sales_admin_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_sales_admin.sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_sales_admin.sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesAdmin = $builder->getCompiledSelect();


        // getting from sales return admin [OUT]//
        $builder = $this->db->table('dt_retur_sales_admin');
        $builder->select('ms_product_unit.product_id,hd_retur_sales_admin.hd_retur_store_id as warehouse_id,hd_retur_sales_admin.hd_retur_date AS stock_date,(ms_product_unit.product_content*dt_retur_sales_admin.dt_retur_qty) AS stock_in,0 AS stock_out,hd_retur_sales_admin.created_at', false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_retur_sales_admin.dt_retur_item_id')
            ->join('hd_retur_sales_admin', 'hd_retur_sales_admin.hd_retur_sales_admin_id=dt_retur_sales_admin.hd_retur_sales_admin_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_retur_sales_admin.hd_retur_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_retur_sales_admin.hd_retur_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesReturnAdmin = $builder->getCompiledSelect();



        // getting from stock opname [IN|OUT]//
        $builder = $this->db->table('dt_opname');
        $builder->select('dt_opname.product_id,hd_opname.warehouse_id,hd_opname.opname_date AS stock_date,IF((dt_opname.warehouse_stock-dt_opname.system_stock)>=0,(dt_opname.warehouse_stock-dt_opname.system_stock),0) AS stock_in,IF((dt_opname.warehouse_stock-dt_opname.system_stock)<0,(dt_opname.warehouse_stock-dt_opname.system_stock),0) AS stock_out,hd_opname.created_at', false)
            ->join('hd_opname', 'hd_opname.opname_id=dt_opname.opname_id')
            ->whereIn('dt_opname.product_id', $product_ids);
        if ($start_date == null) {
            $builder->where("hd_opname.opname_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_opname.opname_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlOpname = $builder->getCompiledSelect();


        // getting from transfer out [OUT]//
        $builder = $this->db->table('dt_transfer_stock');
        $builder->select('ms_product_unit.product_id,hd_transfer_stock.hd_transfer_stock_warehose_from as warehouse_id,hd_transfer_stock.hd_transfer_stock_date AS stock_date,0 AS stock_in,((ms_product_unit.product_content*dt_transfer_stock.item_qty)*-1) AS stock_out,hd_transfer_stock.created_at', false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_transfer_stock.item_id')
            ->join('hd_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id=dt_transfer_stock.hd_transfer_stock_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_transfer_stock.hd_transfer_stock_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_transfer_stock.hd_transfer_stock_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlTransferOut = $builder->getCompiledSelect();

        // getting from transfer in [IN]//
        $builder = $this->db->table('dt_transfer_stock');
        $builder->select('ms_product_unit.product_id,hd_transfer_stock.hd_transfer_stock_warehose_to as warehouse_id,hd_transfer_stock.hd_transfer_stock_date AS stock_date,(ms_product_unit.product_content*dt_transfer_stock.item_qty) AS stock_in,0 AS stock_out,hd_transfer_stock.created_at', false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_transfer_stock.item_id')
            ->join('hd_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id=dt_transfer_stock.hd_transfer_stock_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_transfer_stock.hd_transfer_stock_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_transfer_stock.hd_transfer_stock_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlTransferIn = $builder->getCompiledSelect();


        $unionAll = "($sqlPurchase)
        UNION ALL
        ($sqlPurchaseReturn)
        UNION ALL
        ($sqlPurchaseConsignment)
        UNION ALL
        ($sqlSalesPos)
        UNION ALL
        ($sqlSalesPosReturn)
        UNION ALL
        ($sqlSalesAdmin)
        UNION ALL
        ($sqlSalesReturnAdmin)
        UNION ALL
        ($sqlOpname)
        UNION ALL
        ($sqlTransferOut)
        UNION ALL
        ($sqlTransferIn)";

        $sqlGetStockData = "SELECT stock_data.product_id,stock_data.warehouse_id,sum(stock_data.stock_in) as stock_in,sum(stock_data.stock_out) as stock_out FROM ($unionAll) as stock_data group by stock_data.product_id,stock_data.warehouse_id";

        return $this->db->query($sqlGetStockData)->getResultArray();
    }

    public function getReportStockLog($product_ids = [], $start_date = null, $end_date = null)
    {
        // query dengan format return product_id | warehouse_id | stock_date | stock_in|stock_out(qty*product_content) | stock_remark | created_at //

        // getting from purchase [IN]//
        $builder = $this->db->table('dt_purchase');
        $builder->select("ms_product_unit.product_id,hd_purchase.purchase_warehouse_id as warehouse_id,hd_purchase.purchase_date AS stock_date,(ms_product_unit.product_content*dt_purchase.dt_purchase_qty) AS stock_in,0 AS stock_out,CONCAT('Pembelian ',hd_purchase.purchase_invoice) as stock_remark,hd_purchase.created_at", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_purchase.dt_purchase_item_id')
            ->join('hd_purchase', 'hd_purchase.purchase_invoice=dt_purchase.dt_purchase_invoice')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_purchase.purchase_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_purchase.purchase_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchase = $builder->getCompiledSelect();

        // getting from purchase return [OUT]//
        $builder = $this->db->table('dt_retur_purchase');
        $builder->select("ms_product_unit.product_id,dt_retur_purchase.dt_retur_warehouse as warehouse_id,hd_retur_purchase.hd_retur_date AS stock_date,0 AS stock_in,((ms_product_unit.product_content*dt_retur_purchase.dt_retur_qty)*-1) AS stock_out,CONCAT('Retur Pembelian ',dt_retur_purchase.dt_retur_purchase_invoice) AS stock_remark,hd_retur_purchase.created_at", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_retur_purchase.dt_retur_item_id')
            ->join('hd_retur_purchase', 'hd_retur_purchase.hd_retur_purchase_id=dt_retur_purchase.hd_retur_purchase_id')
            ->where('hd_retur_purchase.hd_retur_status', 'Selesai')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_retur_purchase.hd_retur_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_retur_purchase.hd_retur_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchaseReturn = $builder->getCompiledSelect();


        // getting from hd_purchase_consignment [IN]//
        $builder = $this->db->table('dt_purchase_consignment');
        $builder->select("ms_product_unit.product_id,hd_purchase_consignment.purchase_consignment_warehouse_id as warehouse_id,hd_purchase_consignment.purchase_consignment_date AS stock_date,(ms_product_unit.product_content*dt_purchase_consignment.dt_consignment_qty) AS stock_in,0 AS stock_out,CONCAT('Pembelian Konsinyasi ',hd_purchase_consignment.purchase_consignment_invoice) AS stock_remark,hd_purchase_consignment.created_at", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_purchase_consignment.dt_consignment_item_id')
            ->join('hd_purchase_consignment', 'hd_purchase_consignment.purchase_consignment_invoice=dt_purchase_consignment.dt_consignment_invoice')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_purchase_consignment.purchase_consignment_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_purchase_consignment.purchase_consignment_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchaseConsignment = $builder->getCompiledSelect();


        // getting from sales pos [OUT]//
        $builder = $this->db->table('dt_pos_sales');
        $builder->select("ms_product_unit.product_id,hd_pos_sales.warehouse_id,hd_pos_sales.pos_sales_date AS stock_date,0 AS stock_in,((ms_product_unit.product_content*dt_pos_sales.sales_qty)*-1) AS stock_out,CONCAT('Penjualan POS ',hd_pos_sales.pos_sales_invoice) AS stock_remark,hd_pos_sales.created_at", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_pos_sales.pos_sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_pos_sales.pos_sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesPos = $builder->getCompiledSelect();


        // getting from sales return pos [IN]//
        $builder = $this->db->table('dt_pos_sales_return');
        $builder->select("ms_product_unit.product_id,hd_pos_sales_return.warehouse_id,hd_pos_sales_return.pos_sales_return_date AS stock_date,(ms_product_unit.product_content*dt_pos_sales_return.sales_return_qty) AS stock_in,0 AS stock_out,CONCAT('Retur Penjualan POS ',hd_pos_sales_return.pos_sales_return_invoice) AS stock_remark,hd_pos_sales_return.created_at", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales_return.item_id')
            ->join('hd_pos_sales_return', 'hd_pos_sales_return.pos_sales_return_id=dt_pos_sales_return.pos_sales_return_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_pos_sales_return.pos_sales_return_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesPosReturn = $builder->getCompiledSelect();


        // getting from sales admin [OUT]//
        $builder = $this->db->table('dt_sales_admin');
        $builder->select("ms_product_unit.product_id,hd_sales_admin.sales_store_id as warehouse_id,hd_sales_admin.sales_date AS stock_date,0 AS stock_in,((ms_product_unit.product_content*dt_sales_admin.dt_temp_qty)*-1) AS stock_out,CONCAT('Penjualan Admin ',hd_sales_admin.sales_admin_invoice) AS stock_remark,hd_sales_admin.created_at", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_sales_admin.dt_item_id')
            ->join('hd_sales_admin', 'hd_sales_admin.sales_admin_id=dt_sales_admin.sales_admin_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_sales_admin.sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_sales_admin.sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesAdmin = $builder->getCompiledSelect();


        // getting from sales return admin [OUT]//
        $builder = $this->db->table('dt_retur_sales_admin');
        $builder->select("ms_product_unit.product_id,hd_retur_sales_admin.hd_retur_store_id as warehouse_id,hd_retur_sales_admin.hd_retur_date AS stock_date,(ms_product_unit.product_content*dt_retur_sales_admin.dt_retur_qty) AS stock_in,0 AS stock_out,CONCAT('Retur Penjualan Admin ',hd_retur_sales_admin.hd_retur_sales_admin_invoice) AS stock_remark,hd_retur_sales_admin.created_at", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_retur_sales_admin.dt_retur_item_id')
            ->join('hd_retur_sales_admin', 'hd_retur_sales_admin.hd_retur_sales_admin_id=dt_retur_sales_admin.hd_retur_sales_admin_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_retur_sales_admin.hd_retur_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_retur_sales_admin.hd_retur_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesReturnAdmin = $builder->getCompiledSelect();



        // getting from stock opname [IN|OUT]//
        $builder = $this->db->table('dt_opname');
        $builder->select("dt_opname.product_id,hd_opname.warehouse_id,hd_opname.opname_date AS stock_date,IF((dt_opname.warehouse_stock-dt_opname.system_stock)>=0,(dt_opname.warehouse_stock-dt_opname.system_stock),0) AS stock_in,IF((dt_opname.warehouse_stock-dt_opname.system_stock)<0,(dt_opname.warehouse_stock-dt_opname.system_stock),0) AS stock_out,CONCAT('Stok Opname ',hd_opname.opname_code) AS stock_remark,hd_opname.created_at", false)
            ->join('hd_opname', 'hd_opname.opname_id=dt_opname.opname_id')
            ->whereIn('dt_opname.product_id', $product_ids);
        if ($start_date == null) {
            $builder->where("hd_opname.opname_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_opname.opname_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlOpname = $builder->getCompiledSelect();


        // getting from transfer out [OUT]//
        $builder = $this->db->table('dt_transfer_stock');
        $builder->select("ms_product_unit.product_id,hd_transfer_stock.hd_transfer_stock_warehose_from as warehouse_id,hd_transfer_stock.hd_transfer_stock_date AS stock_date,0 AS stock_in,((ms_product_unit.product_content*dt_transfer_stock.item_qty)*-1) AS stock_out,CONCAT('Transfer Stok ',hd_transfer_stock.hd_transfer_stock_no) AS stock_remark,hd_transfer_stock.created_at", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_transfer_stock.item_id')
            ->join('hd_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id=dt_transfer_stock.hd_transfer_stock_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_transfer_stock.hd_transfer_stock_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_transfer_stock.hd_transfer_stock_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlTransferOut = $builder->getCompiledSelect();

        // getting from transfer in [IN]//
        $builder = $this->db->table('dt_transfer_stock');
        $builder->select("ms_product_unit.product_id,hd_transfer_stock.hd_transfer_stock_warehose_to as warehouse_id,hd_transfer_stock.hd_transfer_stock_date AS stock_date,(ms_product_unit.product_content*dt_transfer_stock.item_qty) AS stock_in,0 AS stock_out,CONCAT('Transfer Stok ',hd_transfer_stock.hd_transfer_stock_no) AS stock_remark,hd_transfer_stock.created_at", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_transfer_stock.item_id')
            ->join('hd_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id=dt_transfer_stock.hd_transfer_stock_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_transfer_stock.hd_transfer_stock_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_transfer_stock.hd_transfer_stock_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlTransferIn = $builder->getCompiledSelect();


        $unionAll = "($sqlPurchase)
        UNION ALL
        ($sqlPurchaseReturn)
        UNION ALL
        ($sqlPurchaseConsignment)
        UNION ALL
        ($sqlSalesPos)
        UNION ALL
        ($sqlSalesPosReturn)
        UNION ALL
        ($sqlSalesAdmin)
        UNION ALL
        ($sqlSalesReturnAdmin)
        UNION ALL
        ($sqlOpname)
        UNION ALL
        ($sqlTransferOut)
        UNION ALL
        ($sqlTransferIn)";

        $sqlGetStockData = "SELECT stock_data.* FROM ($unionAll) as stock_data ORDER BY stock_data.stock_date,stock_data.created_at ASC";

        return $this->db->query($sqlGetStockData)->getResultArray();
    }



    public function getReportInitStock2($product_ids = [], $start_date = null, $end_date = null)
    {
        // query dengan format return product_id | warehouse_id | stock_date | stock(qty*product_content) | created_at //

        // getting from purchase //
        $builder = $this->db->table('dt_purchase');
        $builder->select('ms_product_unit.product_id,hd_purchase.purchase_warehouse_id as warehouse_id,hd_purchase.purchase_date AS stock_date,(ms_product_unit.product_content*dt_purchase.dt_purchase_qty) AS stock,hd_purchase.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_purchase.dt_purchase_item_id')
            ->join('hd_purchase', 'hd_purchase.purchase_invoice=dt_purchase.dt_purchase_invoice')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_purchase.purchase_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_purchase.purchase_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchase = $builder->getCompiledSelect();

        // getting from purchase return //
        $builder = $this->db->table('dt_retur_purchase');
        $builder->select('ms_product_unit.product_id,dt_retur_purchase.dt_retur_warehouse as warehouse_id,hd_retur_purchase.hd_retur_date AS stock_date,(ms_product_unit.product_content*dt_retur_purchase.dt_retur_qty) AS stock,hd_retur_purchase.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_retur_purchase.dt_retur_item_id')
            ->join('hd_retur_purchase', 'hd_retur_purchase.hd_retur_purchase_id=dt_retur_purchase.hd_retur_purchase_id')
            ->where('hd_retur_purchase.hd_retur_status', 'Selesai')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_retur_purchase.hd_retur_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_retur_purchase.hd_retur_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchaseReturn = $builder->getCompiledSelect();


        // getting from hd_purchase_consignment //
        $builder = $this->db->table('dt_purchase_consignment');
        $builder->select('ms_product_unit.product_id,hd_purchase_consignment.purchase_consignment_warehouse_id as warehouse_id,hd_purchase_consignment.purchase_consignment_date AS stock_date,(ms_product_unit.product_content*dt_purchase_consignment.dt_consignment_qty) AS stock,hd_purchase_consignment.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_purchase_consignment.dt_consignment_item_id')
            ->join('hd_purchase_consignment', 'hd_purchase_consignment.purchase_consignment_invoice=dt_purchase_consignment.dt_consignment_invoice')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_purchase_consignment.purchase_consignment_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_purchase_consignment.purchase_consignment_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlPurchaseConsignment = $builder->getCompiledSelect();


        // getting from sales pos //
        $builder = $this->db->table('dt_pos_sales');
        $builder->select('ms_product_unit.product_id,hd_pos_sales.warehouse_id,hd_pos_sales.pos_sales_date AS stock_date,((ms_product_unit.product_content*dt_pos_sales.sales_qty)*-1) AS stock,hd_pos_sales.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_pos_sales.pos_sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_pos_sales.pos_sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesPos = $builder->getCompiledSelect();


        // getting from sales return pos //
        $builder = $this->db->table('dt_pos_sales_return');
        $builder->select('ms_product_unit.product_id,hd_pos_sales_return.warehouse_id,hd_pos_sales_return.pos_sales_return_date AS stock_date,(ms_product_unit.product_content*dt_pos_sales_return.sales_return_qty) AS stock,hd_pos_sales_return.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales_return.item_id')
            ->join('hd_pos_sales_return', 'hd_pos_sales_return.pos_sales_return_id=dt_pos_sales_return.pos_sales_return_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_pos_sales_return.pos_sales_return_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_pos_sales_return.pos_sales_return_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesPosReturn = $builder->getCompiledSelect();


        // getting from sales admin //
        $builder = $this->db->table('dt_sales_admin');
        $builder->select('ms_product_unit.product_id,hd_sales_admin.sales_store_id as warehouse_id,hd_sales_admin.sales_date AS stock_date,((ms_product_unit.product_content*dt_sales_admin.dt_temp_qty)*-1) AS stock,hd_sales_admin.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_sales_admin.dt_item_id')
            ->join('hd_sales_admin', 'hd_sales_admin.sales_admin_id=dt_sales_admin.sales_admin_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_sales_admin.sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_sales_admin.sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesAdmin = $builder->getCompiledSelect();


        // getting from sales return admin //
        $builder = $this->db->table('dt_retur_sales_admin');
        $builder->select('ms_product_unit.product_id,hd_retur_sales_admin.hd_retur_store_id as warehouse_id,hd_retur_sales_admin.hd_retur_date AS stock_date,(ms_product_unit.product_content*dt_retur_sales_admin.dt_retur_qty) AS stock,hd_retur_sales_admin.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_retur_sales_admin.dt_retur_item_id')
            ->join('hd_retur_sales_admin', 'hd_retur_sales_admin.hd_retur_sales_admin_id=dt_retur_sales_admin.hd_retur_sales_admin_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_retur_sales_admin.hd_retur_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_retur_sales_admin.hd_retur_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesReturnAdmin = $builder->getCompiledSelect();



        // getting from stock opname //
        $builder = $this->db->table('dt_opname');
        $builder->select('dt_opname.product_id,hd_opname.warehouse_id,hd_opname.opname_date AS stock_date,(dt_opname.warehouse_stock-dt_opname.system_stock) AS stock,hd_opname.created_at')
            ->join('hd_opname', 'hd_opname.opname_id=dt_opname.opname_id')
            ->whereIn('dt_opname.product_id', $product_ids);
        if ($start_date == null) {
            $builder->where("hd_opname.opname_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_opname.opname_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlOpname = $builder->getCompiledSelect();


        // getting from transfer out //
        $builder = $this->db->table('dt_transfer_stock');
        $builder->select('ms_product_unit.product_id,hd_transfer_stock.hd_transfer_stock_warehose_from as warehouse_id,hd_transfer_stock.hd_transfer_stock_date AS stock_date,((ms_product_unit.product_content*dt_transfer_stock.item_qty)*-1) AS stock,hd_transfer_stock.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_transfer_stock.item_id')
            ->join('hd_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id=dt_transfer_stock.hd_transfer_stock_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_transfer_stock.hd_transfer_stock_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_transfer_stock.hd_transfer_stock_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlTransferOut = $builder->getCompiledSelect();

        // getting from transfer in //
        $builder = $this->db->table('dt_transfer_stock');
        $builder->select('ms_product_unit.product_id,hd_transfer_stock.hd_transfer_stock_warehose_to as warehouse_id,hd_transfer_stock.hd_transfer_stock_date AS stock_date,(ms_product_unit.product_content*dt_transfer_stock.item_qty) AS stock,hd_transfer_stock.created_at')
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_transfer_stock.item_id')
            ->join('hd_transfer_stock', 'hd_transfer_stock.hd_transfer_stock_id=dt_transfer_stock.hd_transfer_stock_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_transfer_stock.hd_transfer_stock_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_transfer_stock.hd_transfer_stock_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlTransferIn = $builder->getCompiledSelect();


        $unionAll = "($sqlPurchase)
        UNION ALL
        ($sqlPurchaseReturn)
        UNION ALL
        ($sqlPurchaseConsignment)
        UNION ALL
        ($sqlSalesPos)
        UNION ALL
        ($sqlSalesPosReturn)
        UNION ALL
        ($sqlSalesAdmin)
        UNION ALL
        ($sqlSalesReturnAdmin)
        UNION ALL
        ($sqlOpname)
        UNION ALL
        ($sqlTransferOut)
        UNION ALL
        ($sqlTransferIn)";

        $sqlGetStockData = "SELECT stock_data.* FROM ($unionAll) as stock_data";
    }



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

    public function getListProductUnitByBrand($brand_id = [])
    {
        $builder =  $this->db->table('ms_product_unit')
            ->select('ms_product.product_code,ms_product.product_name,ms_product_unit.*,(ms_product_unit.product_content*ms_product.base_purchase_price) as product_price,(ms_product_unit.product_content*ms_product.base_purchase_tax) as product_tax,ms_unit.unit_name,ms_brand.brand_name,ms_category.category_name,ms_product.base_purchase_price,ms_product.base_purchase_tax,ms_product.base_cogs,ms_product.has_tax,ms_product.is_parcel')
            ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')
            ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')
            ->join('ms_brand', 'ms_brand.brand_id=ms_product.brand_id')
            ->join('ms_category', 'ms_category.category_id=ms_product.category_id')
            ->where('ms_product.deleted', 'N');


        if (count($brand_id) > 0) {
            $builder->whereIn('ms_product.brand_id', $brand_id);
        }

        return $builder->get();
    }

    public function getListProductByID($product_ids = [])
    {
        $builder =  $this->db->table('ms_product')
            ->select('ms_product.*');

        if (count($product_ids) > 0) {
            $builder->whereIn('ms_product.product_id', $product_ids);
        }

        return $builder->get();
    }

    public function getReportMinStockProduct()
    {
        $subQueryStock = $this->db->table('ms_product_stock')
            ->select("product_id,SUM(stock) AS stock_total,GROUP_CONCAT(CONCAT(warehouse_id,'=',stock) SEPARATOR ';') AS warehouse_stock", false)
            ->groupBy('product_id')
            ->getCompiledSelect();

        $builder = $this->db->table('ms_product');
        $builder->select("ms_product.product_id,ms_product.product_code,ms_product.product_name,ms_product.min_stock,IFNULL(product_stock.stock_total,0) AS stock_total,product_stock.warehouse_stock", false);
        $builder->join("($subQueryStock) AS product_stock", 'product_stock.product_id=ms_product.product_id', 'LEFT', false);
        $builder->where('IFNULL(product_stock.stock_total,0)<=ms_product.min_stock', null, false);

        return $builder->get();
    }

    public function getSalesStockByProduct($product_ids = [], $start_date, $end_date)
    {
        // subquery output product_id,sales_stock
        // getting from sales pos //
        $builder = $this->db->table('dt_pos_sales');
        $builder->select("ms_product_unit.product_id,(ms_product_unit.product_content*dt_pos_sales.sales_qty) AS sales_stock", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_pos_sales.pos_sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_pos_sales.pos_sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesPos = $builder->getCompiledSelect();

        // getting from sales admin //
        $builder = $this->db->table('dt_sales_admin');
        $builder->select("ms_product_unit.product_id,(ms_product_unit.product_content*dt_sales_admin.dt_temp_qty) AS sales_stock", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_sales_admin.dt_item_id')
            ->join('hd_sales_admin', 'hd_sales_admin.sales_admin_id=dt_sales_admin.sales_admin_id')
            ->whereIn('ms_product_unit.product_id', $product_ids);

        if ($start_date == null) {
            $builder->where("hd_sales_admin.sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_sales_admin.sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesAdmin = $builder->getCompiledSelect();

        $unionAll = "($sqlSalesPos) UNION ALL ($sqlSalesAdmin)";
        $sqlGetSalesStock = "SELECT sales_data.product_id,SUM(sales_data.sales_stock) AS sales_stock FROM ($unionAll) AS sales_data GROUP BY sales_data.product_id";

        return $this->db->query($sqlGetSalesStock)->getResultArray();
    }


    public function getHistorySalesPrice($product_id, $start_date, $end_date)
    {
        // subquery output product_id,sales_date,customer_group,sales_price,count_data //

        // getting from sales pos //
        $builder = $this->db->table('dt_pos_sales');
        $builder->select("dt_pos_sales.detail_id as id,ms_product_unit.product_id,hd_pos_sales.pos_sales_date as sales_date,hd_pos_sales.customer_group,dt_pos_sales.product_price as sales_price", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_pos_sales.item_id')
            ->join('hd_pos_sales', 'hd_pos_sales.pos_sales_id=dt_pos_sales.pos_sales_id')
            ->where('ms_product_unit.product_id', $product_id);

        if ($start_date == null) {
            $builder->where("hd_pos_sales.pos_sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_pos_sales.pos_sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesPos = $builder->getCompiledSelect();

        // getting from sales admin //
        $builder = $this->db->table('dt_sales_admin');
        $builder->select("dt_sales_admin.dt_sales_admin_id as id,ms_product_unit.product_id,hd_sales_admin.sales_date,ms_customer.customer_group,dt_sales_admin.dt_product_price as sales_price", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_sales_admin.dt_item_id')
            ->join('hd_sales_admin', 'hd_sales_admin.sales_admin_id=dt_sales_admin.sales_admin_id')
            ->join('ms_customer', 'ms_customer.customer_id=hd_sales_admin.sales_customer_id')
            ->where('ms_product_unit.product_id', $product_id);

        if ($start_date == null) {
            $builder->where("hd_sales_admin.sales_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_sales_admin.sales_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }
        $sqlSalesAdmin = $builder->getCompiledSelect();

        $unionAll = "($sqlSalesPos) UNION ALL ($sqlSalesAdmin)";
        $sqlGetSalesData = "SELECT sales_data.product_id,sales_data.customer_group,sales_data.sales_date,sales_data.sales_price,count(sales_data.id) as count_data FROM ($unionAll) AS sales_data GROUP BY sales_data.product_id,sales_data.sales_date,sales_data.customer_group,sales_data.sales_price ORDER BY sales_data.customer_group,sales_data.sales_date";

        return $this->db->query($sqlGetSalesData)->getResultArray();
    }

    public function getHistoryPurchasePrice($product_id, $start_date, $end_date)
    {

        // getting from purchase //
        $builder = $this->db->table('dt_purchase');
        $builder->select("ms_product_unit.product_id,hd_purchase.purchase_date AS purchase_date,dt_purchase.dt_purchase_total AS purchase_price,dt_purchase.dt_purchase_id", false)
            ->join('ms_product_unit', 'ms_product_unit.item_id=dt_purchase.dt_purchase_item_id')
            ->join('hd_purchase', 'hd_purchase.purchase_invoice=dt_purchase.dt_purchase_invoice')
            ->where('ms_product_unit.product_id', $product_id);

        if ($start_date == null) {
            $builder->where("hd_purchase.purchase_date<=CAST('$end_date' AS DATE)");
        } else {
            $builder->where("(hd_purchase.purchase_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");
        }

        $sqlPurchase = $builder->getCompiledSelect();

        $sqlText = "SELECT stock_data.product_id,stock_data.purchase_date,stock_data.purchase_price,count(stock_data.dt_purchase_id) as count_data FROM ($sqlPurchase) as stock_data GROUP BY stock_data.product_id,stock_data.purchase_date,stock_data.purchase_price ORDER BY purchase_date";
        return $this->db->query($sqlText)->getResultArray();
    }
}
