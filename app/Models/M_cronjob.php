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

    public function groupHasVoucher($voucher_group_id)
    {
        $getData = $this->db->table('ms_voucher')
            ->select('voucher_id')
            ->where('voucher_group_id', $voucher_group_id)
            ->where('deleted', 'N')
            ->limit(1)->get()->getRowArray();

        if ($getData == NULL) {
            return 0;
        } else {
            return 1;
        }
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
