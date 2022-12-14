<?php

namespace App\Models;

use CodeIgniter\Model;

class M_stock_opname extends Model
{
    protected $table = 'hd_opname';
    protected $tDetail = 'dt_opname';
    protected $tTemp = 'temp_opname';

    public function getOpname($opname_id = '')
    {
        $builder = $this->db->table('hd_opname');
        $builder->select('hd_opname.*,user_account.user_realname,user_account.user_name,ms_warehouse.warehouse_code,ms_warehouse.warehouse_name,ms_warehouse.warehouse_address')
            ->join('user_account', 'user_account.user_id=hd_opname.user_id')
            ->join('ms_warehouse', 'ms_warehouse.warehouse_id=hd_opname.warehouse_id');

        if ($opname_id != '') {
            $builder->where('hd_opname.opname_id', $opname_id);
        }

        return $builder->get();
    }


    public function getDetailOpname($opname_id)
    {
        $builder = $this->db->table('dt_opname');
        $builder->select('dt_opname.*,ms_product.product_code,ms_product.product_name')
            ->join('ms_product', 'ms_product.product_id=dt_opname.product_id')
            ->where('dt_opname.opname_id', $opname_id);
        return $builder->get();
    }

    public function opnameProduct($warehouse_id, $product_id = [], $user_id)
    {
        $save = ['success' => FALSE, 'message' => 'Gagal menambahkan data produk'];

        $this->db->transBegin();
        $find_product = [];
        foreach ($product_id as $pid) {
            $find_product['P' . $pid] = $pid;
        }

        $getStock = $this->db->table('ms_warehouse_stock')
            ->select('ms_warehouse_stock.stock_id,ms_warehouse_stock.warehouse_id,ms_warehouse_stock.product_id,ms_warehouse_stock.exp_date,ms_warehouse_stock.stock,ms_product.base_cogs')
            ->join('ms_product', 'ms_product.product_id=ms_warehouse_stock.product_id')
            ->where('ms_warehouse_stock.stock>', 0)
            ->where('ms_warehouse_stock.warehouse_id', $warehouse_id)
            ->whereIn('ms_warehouse_stock.product_id', $product_id)
            ->get()->getResultArray();

        $tempData = [];
        foreach ($getStock as $ws) {
            $stock_id       = $ws['stock_id'];
            $pid            = $ws['product_id'];
            if (isset($find_product['P' . $pid])) {
                unset($find_product['P' . $pid]);
            }

            $exp_date       = $ws['exp_date'];
            $stock          = $ws['stock'];
            $base_cogs      = $ws['base_cogs'];
            $product_key    = md5(date('YmdHis') . $user_id . $pid . $stock_id . $warehouse_id);
            $tempData[] = [
                'product_key'           => $product_key,
                'product_id'            => $pid,
                'stock_id'              => $stock_id,
                'warehouse_id'          => $warehouse_id,
                'temp_warehouse_stock'  => $stock,
                'temp_system_stock'     => $stock,
                'temp_base_cogs'        => $base_cogs,
                'temp_stock_difference' => 0,
                'temp_exp_date'         => $exp_date,
                'temp_detail_remark'    => '',
                'user_id'               => $user_id,
                'temp_add'              => 'N'
            ];
        }

        if (count($find_product) > 0) {
            $product_id = [];
            foreach ($find_product as $pid) {
                $product_id[] = $pid;
            }

            $getProduct = $this->db->table('ms_product')
                ->select('product_id,base_cogs')
                ->whereIn('product_id', $product_id)
                ->get()->getResultArray();

            foreach ($getProduct as $prd) {
                $pid        = $prd['product_id'];
                $base_cogs  = $prd['base_cogs'];
                $product_key    = md5(date('YmdHis') . $user_id . $pid . 0 . $warehouse_id);
                $tempData[] = [
                    'product_key'           => $product_key,
                    'product_id'            => $pid,
                    'stock_id'              => 0,
                    'warehouse_id'          => $warehouse_id,
                    'temp_warehouse_stock'  => 0,
                    'temp_system_stock'     => 0,
                    'temp_base_cogs'        => $base_cogs,
                    'temp_stock_difference' => 0,
                    'temp_exp_date'         => null,
                    'temp_detail_remark'    => '',
                    'user_id'               => $user_id,
                    'temp_add'              => 'Y'
                ];
            }
        }

        $this->db->table('temp_opname')->insertBatch($tempData);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $save = ['success' => FALSE, 'message' => 'Gagal menambahkan data produk'];
        } else {
            $this->db->transCommit();
            $save = ['success' => TRUE, 'message' => 'Berhasil menambahkan data produk'];
        }

        return $save;
    }

    public function getTemp($warehouse_id, $user_id)
    {
        return $this->db->table('temp_opname')
            ->select("temp_opname.product_key,temp_opname.product_id,ms_product.product_code,ms_product.product_name,temp_opname.temp_base_cogs,temp_opname.temp_warehouse_stock,temp_opname.temp_system_stock,(SELECT ms_unit.unit_name FROM ms_product_unit JOIN ms_unit ON ms_unit.unit_id=ms_product_unit.unit_id WHERE ms_product_unit.product_id=temp_opname.product_id AND ms_product_unit.base_unit='Y') as unit_name,temp_opname.temp_exp_date,temp_opname.temp_detail_remark,temp_opname.temp_add")
            ->join('ms_product', 'ms_product.product_id=temp_opname.product_id')
            ->where('temp_opname.warehouse_id', $warehouse_id)
            ->where('temp_opname.user_id', $user_id)
            ->get();
    }

    public function getTempByProductId($product_id, $warehouse_id, $user_id)
    {
        return $this->db->table('temp_opname')
            ->select("temp_opname.product_key,temp_opname.product_id,ms_product.product_code,ms_product.product_name,temp_opname.temp_base_cogs,temp_opname.temp_warehouse_stock,temp_opname.temp_system_stock,(SELECT ms_unit.unit_name FROM ms_product_unit JOIN ms_unit ON ms_unit.unit_id=ms_product_unit.unit_id WHERE ms_product_unit.product_id=temp_opname.product_id AND ms_product_unit.base_unit='Y') as unit_name,temp_opname.temp_exp_date,temp_opname.temp_detail_remark,temp_opname.temp_add")
            ->join('ms_product', 'ms_product.product_id=temp_opname.product_id')
            ->where('temp_opname.product_id', $product_id)
            ->where('temp_opname.warehouse_id', $warehouse_id)
            ->where('temp_opname.user_id', $user_id)
            ->get();
    }

    public function clearTemp($user_id)
    {
        return $this->db->table('temp_opname')
            ->where('temp_opname.user_id', $user_id)
            ->delete();
    }

    public function updateTemp($data)
    {
        if ($data['product_key'] == '' || $data['product_key'] == NULL) {
            $data['product_key']   = md5($data['product_id'] . $data['user_id'] . $data['warehouse_id'] . date('dmYHis'));
            $data['stock_id']      = '0';
            $data['temp_add']      = 'Y';
            return  $this->db->table('temp_opname')->insert($data);
        } else {
            return $this->db->table('temp_opname')->update($data, ['product_key' => $data['product_key']]);
        }
    }

    public function deleteTemp($product_id, $warehouse_id, $user_id, $isProductID = TRUE)
    {
        $builder = $this->db->table('temp_opname')
            ->where('warehouse_id', $warehouse_id)
            ->where('user_id', $user_id);

        if ($isProductID) {
            $builder->where('product_id', $product_id);
        } else {
            $builder->where('product_key', $product_id);
        }
        return $builder->delete();
    }


    public function insertOpname($data)
    {
        $this->db->query('LOCK TABLES hd_opname WRITE,dt_opname WRITE,temp_opname WRITE,ms_product_stock WRITE,ms_warehouse_stock WRITE,last_record_number WRITE');
        $sqlUpdateLastNumber = NULL;
        $saveQueries = NULL;
        $maxInsert = 500;

        $store_id       = $data['store_id'];
        $store_code     = $data['store_code'];
        $opname_date    = $data['opname_date'];
        $opname_total   = $data['opname_total'];
        $warehouse_id   = $data['warehouse_id'];
        $user_id        = $data['user_id'];

        unset($data['store_id']);
        unset($data['store_code']);

        $this->db->transBegin();

        $opname_id              = 0;
        $query_warehouse_stock  = '';
        $query_stock            = '';


        $record_period = date('mY');
        $getLastNumber = $this->db->table('last_record_number')
            ->where('record_module', 'stock_opname')
            ->where('store_id', $store_id)
            ->where('record_period', $record_period)
            ->get()->getRowArray();

        if ($getLastNumber == NULL) {
            $data['opname_code'] = 'OP/' . $store_code . '/' . substr($record_period, -2) . '/' . substr($record_period, 0, 2) . '/000001';

            $update_last_number = [
                'record_module' => 'stock_opname',
                'store_id'      => $store_id,
                'record_period' => $record_period,
                'last_number'   => 1
            ];
            $sqlUpdateLastNumber = $this->db->table('last_record_number')->set($update_last_number)->getCompiledInsert();
        } else {
            $new_number = strval(intval($getLastNumber['last_number']) + 1);
            $data['opname_code'] = 'OP/' . $store_code . '/' . substr($record_period, -2) . '/' . substr($record_period, 0, 2) . '/' . substr('000000' . $new_number, -6);

            $update_last_number = [
                'record_module' => 'stock_opname',
                'store_id'      => $store_id,
                'record_period' => $record_period,
                'last_number'   => $new_number
            ];
            $sqlUpdateLastNumber = $this->db->table('last_record_number')->set($update_last_number)->where('record_id', $getLastNumber['record_id'])->getCompiledUpdate();
        }

        $this->db->table('hd_opname')->insert($data);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
            $opname_id = $this->db->insertID();
        }


        if ($opname_id > 0) {

            $temp_product_stock             = [];
            $data_product_stock             = [];
            $data_insert_warehouse_stock    = [];
            $data_update_warehouse_stock    = [];
            $data_dtopname                  = [];

            $getTemp = $this->db->table('temp_opname')
                ->where('warehouse_id', $warehouse_id)
                ->where('user_id', $user_id)
                ->get()->getResultArray();
            foreach ($getTemp as $row) {
                $product_id         = $row['product_id'];
                $pid                = 'P' . $product_id;
                $stock_id           = intval($row['stock_id']);
                $warehouse_stock    = floatval($row['temp_warehouse_stock']);
                $system_stock       = floatval($row['temp_system_stock']);
                $base_cogs          = floatval($row['temp_base_cogs']);
                $stock_difference   = floatval($row['temp_stock_difference']);
                $exp_date           = $row['temp_exp_date'];
                $detail_remark      = $row['temp_detail_remark'];
                $stock_add          = $warehouse_stock - $system_stock;

                $data_dtopname[]    = [
                    'opname_id'                 => $opname_id,
                    'product_id'                => $product_id,
                    'detail_remark'             => $detail_remark,
                    'exp_date'                  => $exp_date,
                    'warehouse_stock'           => $warehouse_stock,
                    'system_stock'              => $system_stock,
                    'base_cogs'                 => $base_cogs,
                    'opname_stock_difference'   => $stock_difference
                ];

                if ($stock_add != 0) {
                    if ($stock_id > 0) {
                        // update //
                        $data_update_warehouse_stock[] = [
                            'stock_id'      => $stock_id,
                            'stock'         => $warehouse_stock
                        ];
                    } else {
                        // insert //
                        $data_insert_warehouse_stock[] = [
                            'product_id'    => $product_id,
                            'warehouse_id'  => $warehouse_id,
                            'purchase_id'   => 0,
                            'exp_date'      => $exp_date,
                            'stock'         => $warehouse_stock
                        ];
                    }

                    if (isset($temp_product_stock[$pid])) {
                        $temp_product_stock[$pid]['stock_add'] += $stock_add;
                    } else {
                        $temp_product_stock[$pid] = [
                            'product_id'    => $product_id,
                            'stock_add'     => $stock_add,
                        ];
                    }
                }
            }


            $_part_dtopname = array_chunk($data_dtopname, $maxInsert);
            foreach ($_part_dtopname as $data_opname) {
                $this->db->table('dt_opname')->insertBatch($data_opname);
                if ($this->db->affectedRows() > 0) {
                    $saveQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }


            $_part_insert_warehouse_stock = array_chunk($data_insert_warehouse_stock, $maxInsert);
            foreach ($_part_insert_warehouse_stock as $data_insert) {
                $this->db->table('ms_warehouse_stock')->insertBatch($data_insert);
                if ($this->db->affectedRows() > 0) {
                    $saveQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }

            $_part_update_warehouse_stock = array_chunk($data_update_warehouse_stock, $maxInsert);
            foreach ($_part_update_warehouse_stock as $data_update) {
                $vUpdateStock           = [];
                $qUpdateStock           = "INSERT INTO ms_warehouse_stock(stock_id,product_id,warehouse_id,purchase_id,exp_date,stock) VALUES";
                foreach ($data_update as $ws) {
                    $sid    = $ws['stock_id'];
                    $stock  = $ws['stock'];
                    $vUpdateStock[] = "('$sid','0','0','0',null,'$stock')";
                }

                $qUpdateStock .= implode(',', $vUpdateStock) . " ON DUPLICATE KEY UPDATE stock=VALUES(stock)";
                $this->db->query($qUpdateStock);
                if ($this->db->affectedRows() > 0) {
                    $saveQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }


            if (count($temp_product_stock) > 0) {
                $_temp_part = array_chunk($temp_product_stock, $maxInsert);
                foreach ($_temp_part as $temp) {
                    $vUpdateStock           = [];
                    $qUpdateStock           = "INSERT INTO ms_product_stock(product_id,warehouse_id,stock) VALUES";
                    foreach ($temp as $ps) {
                        $pid    = $ps['product_id'];
                        $stock  = $ps['stock_add'];
                        $vUpdateStock[] = "('$pid','$warehouse_id',$stock)";
                    }

                    $qUpdateStock .= implode(',', $vUpdateStock) . " ON DUPLICATE KEY UPDATE stock=stock+VALUES(stock)";
                    $this->db->query($qUpdateStock);
                    if ($this->db->affectedRows() > 0) {
                        $saveQueries[] = $this->db->getLastQuery()->getQuery();
                    }
                }
            }

            if ($sqlUpdateLastNumber != NULL) {
                $this->db->query($sqlUpdateLastNumber);
                if ($this->db->affectedRows() > 0) {
                    $saveQueries[] = $this->db->getLastQuery()->getQuery();
                }
            }
        }


        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $saveQueries = NULL;
            $save = 0;
        } else {
            $this->db->transCommit();
            $this->db->table('temp_opname')->where('user_id', $user_id)->delete();
            $save = 1;
        }

        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'stock_opname', $opname_id);
        return $save;
    }



    /* end */

    public function getVoucherGroup($voucher_group_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table('ms_voucher_group');
        if ($show_deleted == FALSE) {
            $builder->where('deleted', 'N');
        }

        if ($voucher_group_id != '') {
            $builder->where('voucher_group_id', $voucher_group_id);
        }

        return $builder->get();
    }

    public function getVoucherCategoryRestriction($voucher_group_id)
    {
        return $this->db->table('ms_voucher_category_restriction')
            ->select('ms_voucher_category_restriction.voucher_group_id,ms_voucher_category_restriction.category_id,ms_category.category_name')
            ->join('ms_category', 'ms_category.category_id=ms_voucher_category_restriction.category_id')
            ->where('ms_voucher_category_restriction.voucher_group_id', $voucher_group_id)->get();
    }

    public function getVoucherBrandRestriction($voucher_group_id)
    {
        return $this->db->table('ms_voucher_brand_restriction')
            ->select('ms_voucher_brand_restriction.voucher_group_id,ms_voucher_brand_restriction.brand_id,ms_brand.brand_name')
            ->join('ms_brand', 'ms_brand.brand_id=ms_voucher_brand_restriction.brand_id')
            ->where('ms_voucher_brand_restriction.voucher_group_id', $voucher_group_id)->get();
    }

    public function getVoucher($voucher_group_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table('ms_voucher');
        $builder->select('ms_voucher.*,ms_customer.customer_name,user_account.user_realname');
        $builder->join('ms_customer', 'ms_customer.customer_id=ms_voucher.used_by', 'left');
        $builder->join('user_account', 'user_account.user_id=ms_voucher.created_by');
        if ($show_deleted == FALSE) {
            $builder->where('ms_voucher.deleted', 'N');
        }

        if ($voucher_group_id != '') {
            $builder->where('ms_voucher.voucher_group_id', $voucher_group_id);
        }

        return $builder->get();
    }

    public function getVoucherByCode($voucher_code, $show_deleted = FALSE)
    {
        $builder = $this->db->table('ms_voucher');
        if ($show_deleted == FALSE) {
            $builder->where('deleted', 'N');
        }

        $builder->where('voucher_code', $voucher_code);
        return $builder->get();
    }

    public function insertVoucherGroup($data)
    {
        $this->db->query('LOCK TABLES ms_voucher_group WRITE,ms_voucher_category_restriction WRITE,ms_voucher_brand_restriction WRITE');

        $category_restriction   = is_string($data['category_restriction']) ? explode(',', $data['category_restriction']) : $data['category_restriction'];
        $brand_restriction      = is_string($data['brand_restriction']) ? explode(',', $data['brand_restriction']) : $data['brand_restriction'];

        unset($data['category_restriction']);
        unset($data['brand_restriction']);

        $this->db->transBegin();
        $saveQueries        = NULL;
        $voucher_group_id   = 0;

        $this->db->table('ms_voucher_group')->insert($data);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
            $voucher_group_id = $this->db->insertID();
        }

        $data_category = [];
        foreach ($category_restriction as $ctg) {
            $data_category[] = [
                'voucher_group_id'  => $voucher_group_id,
                'category_id'       => $ctg
            ];
        }

        if (count($data_category) > 0) {
            $this->db->table('ms_voucher_category_restriction')->insertBatch($data_category);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }
        }

        $data_brand = [];
        foreach ($brand_restriction  as $brd) {
            $data_brand[] = [
                'voucher_group_id'  => $voucher_group_id,
                'brand_id'          => $brd
            ];
        }

        if (count($data_brand) > 0) {
            $this->db->table('ms_voucher_brand_restriction')->insertBatch($data_brand);
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

        saveQueries($saveQueries, 'voucher', $voucher_group_id);
        return $save;
    }

    public function updateVoucherGroup($data)
    {
        $this->db->query('LOCK TABLES ms_voucher_group WRITE,ms_voucher_category_restriction WRITE,ms_voucher_brand_restriction WRITE');

        $category_restriction   = is_string($data['category_restriction']) ? explode(',', $data['category_restriction']) : $data['category_restriction'];
        $brand_restriction      = is_string($data['brand_restriction']) ? explode(',', $data['brand_restriction']) : $data['brand_restriction'];

        unset($data['category_restriction']);
        unset($data['brand_restriction']);

        $this->db->transBegin();
        $saveQueries        = NULL;
        $voucher_group_id   = $data['voucher_group_id'];

        $this->db->table('ms_voucher_group')->where('voucher_group_id', $voucher_group_id)->update($data);
        if ($this->db->affectedRows() > 0) {
            $saveQueries[] = $this->db->getLastQuery()->getQuery();
        }

        $data_category = [];
        foreach ($category_restriction as $ctg) {
            $data_category[] = [
                'voucher_group_id'  => $voucher_group_id,
                'category_id'       => $ctg
            ];
        }

        if (count($data_category) > 0) {
            $this->db->table('ms_voucher_category_restriction')->where('voucher_group_id', $voucher_group_id)->delete();
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }

            $this->db->table('ms_voucher_category_restriction')->insertBatch($data_category);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }
        } else {
            $this->db->table('ms_voucher_category_restriction')->where('voucher_group_id', $voucher_group_id)->delete();
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }
        }

        $data_brand = [];
        foreach ($brand_restriction  as $brd) {
            $data_brand[] = [
                'voucher_group_id'  => $voucher_group_id,
                'brand_id'          => $brd
            ];
        }

        if (count($data_brand) > 0) {
            $this->db->table('ms_voucher_brand_restriction')->where('voucher_group_id', $voucher_group_id)->delete();
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }

            $this->db->table('ms_voucher_brand_restriction')->insertBatch($data_brand);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }
        } else {
            $this->db->table('ms_voucher_brand_restriction')->where('voucher_group_id', $voucher_group_id)->delete();
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

        saveQueries($saveQueries, 'voucher', $voucher_group_id);
        return $save;
    }

    public function deleteVoucherGroup($voucher_group_id)
    {
        $this->db->query('LOCK TABLES ms_voucher_group WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table('ms_voucher_group')->update($data, ['voucher_group_id' => $voucher_group_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'voucher', $voucher_group_id);
        return $save;
    }



    public function generateVoucher($voucher_group_id, $count_voucher, $user_id)
    {
        $this->db->query('LOCK TABLES ms_voucher_group WRITE,ms_voucher WRITE');
        $result         = ['success' => FALSE, 'message' => 'Grup voucher tidak ditemukan'];
        $maxVoucher     = 9999;
        $saveQueries    = NULL;

        $getVoucherGroup = $this->db->table('ms_voucher_group')->where('deleted', 'N')->where('voucher_group_id', $voucher_group_id)->get()->getRowArray();
        if ($getVoucherGroup != NULL) {
            $last_voucher_number    = floatval($getVoucherGroup['last_voucher_number']);

            if (($last_voucher_number + $count_voucher) > $maxVoucher) {
                $result         = ['success' => FALSE, 'message' => 'Jumlah voucher melebihi batas maximum'];
            } else {
                helper('text');
                $voucher_data       = [];
                $count_voucher      = intval($count_voucher);
                $totalGenerate      = 0;
                $listGenerateCode   = [];

                while ($totalGenerate < $count_voucher) {
                    $new_voucher_code = strtoupper(random_string('alnum', 12));
                    if (!in_array($new_voucher_code, $listGenerateCode)) {
                        $check = $this->getVoucherByCode($new_voucher_code, TRUE)->getRowArray();
                        if ($check == NULL) {
                            $voucher_data[] = [
                                'voucher_group_id'  => $voucher_group_id,
                                'voucher_code'      => $new_voucher_code,
                                'created_by'        => $user_id,
                            ];
                            $listGenerateCode[] = $new_voucher_code;
                            $totalGenerate++;
                        }
                    }
                }



                $this->db->transBegin();
                $last_voucher_number += $count_voucher;
                $this->db->table('ms_voucher_group')->where('voucher_group_id', $voucher_group_id)->update(['last_voucher_number' => $last_voucher_number]);
                if ($this->db->affectedRows() > 0) {
                    $saveQueries[] = $this->db->getLastQuery()->getQuery();
                }

                $maxInsert = 500;
                $batchQueue = array_chunk($voucher_data, $maxInsert);
                foreach ($batchQueue as $insertData) {
                    $this->db->table('ms_voucher')->insertBatch($insertData, TRUE, 500);
                    if ($this->db->affectedRows() > 0) {
                        $saveQueries[] = $this->db->getLastQuery()->getQuery();
                    }
                }

                if ($this->db->transStatus() === false) {
                    $this->db->transRollback();
                    $saveQueries = NULL;
                    $result = ['success' => FALSE];
                } else {
                    $this->db->transCommit();
                    $result = ['success' => TRUE];
                }
            }
        }

        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'voucher', $voucher_group_id, 'generate voucher');
        return $result;
    }

    public function deleteVoucher($voucher_id)
    {
        $this->db->query('LOCK TABLES ms_voucher WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table('ms_voucher')->update($data, ['voucher_id' => $voucher_id, 'voucher_status' => 'not used']);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'voucher', $voucher_id);
        return $save;
    }
}
