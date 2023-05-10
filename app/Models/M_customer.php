<?php

namespace App\Models;

use CodeIgniter\Model;

class M_customer extends Model
{
    protected $table = 'ms_customer';

    public function getCustomer($customer_id = '', $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->select('ms_customer.*,ms_mapping_area.mapping_code,ms_mapping_area.mapping_address,ms_salesman.salesman_code,ms_salesman.salesman_name');
        $builder->join('ms_mapping_area', 'ms_mapping_area.mapping_id=ms_customer.mapping_id', 'left');
        $builder->join('ms_salesman', 'ms_salesman.salesman_id=ms_customer.salesman_id', 'left');
        if ($customer_id  != '') {
            $builder->where(['ms_customer.customer_id' => $customer_id]);
        }

        if ($show_deleted == FALSE) {
            $builder->where(['ms_customer.deleted' => 'N']);
        }

        return $builder->get();
    }

    public function getCustomerByCode($customer_code, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->where(['customer_code' => $customer_code]);
        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }
        return $builder->get();
    }

    public function getCustomerByEmail($customer_email, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->where(['customer_email' => $customer_email]);
        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }
        return $builder->get();
    }

    public function getCustomerByPhone($customer_phone, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->where(['customer_phone' => $customer_phone]);
        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }
        return $builder->get();
    }

    public function getCustomerByReferralCode($referral_code, $show_deleted = FALSE)
    {
        $builder = $this->db->table($this->table);
        $builder->where(['referral_code' => $referral_code]);
        if ($show_deleted == FALSE) {
            $builder->where(['deleted' => 'N']);
        }
        return $builder->get();
    }

    public function hasTransaction($customer_id)
    {
        return 0;
    }

    public function insertCustomer($data)
    {
        $this->db->query('LOCK TABLES ms_customer WRITE,last_record_number WRITE');
        $sqlUpdateLastNumber = NULL;
        $saveQueries = NULL;

        if (strtoupper($data['customer_code']) == 'AUTO') {
            $record_period = date('mY');
            $getLastNumber = $this->db->table('last_record_number')
                ->where('record_module', 'customer')
                ->where('record_period', $record_period)
                ->get()->getRowArray();

            if ($getLastNumber == NULL) {
                $data['customer_code'] = 'C' . substr($record_period, 0, 2) . substr($record_period, -2) . '00001';

                $update_last_number = [
                    'record_module' => 'customer',
                    'store_id'      => 0,
                    'record_period' => $record_period,
                    'last_number'   => 1
                ];
                $sqlUpdateLastNumber = $this->db->table('last_record_number')->set($update_last_number)->getCompiledInsert();
            } else {
                $new_number = strval(intval($getLastNumber['last_number']) + 1);
                $data['customer_code'] = 'C' . substr($record_period, 0, 2) . substr($record_period, -2) . substr('00000' . $new_number, -5);

                $update_last_number = [
                    'record_module' => 'customer',
                    'store_id'      => 0,
                    'record_period' => $record_period,
                    'last_number'   => $new_number
                ];
                $sqlUpdateLastNumber = $this->db->table('last_record_number')->set($update_last_number)->where('record_id', $getLastNumber['record_id'])->getCompiledUpdate();
            }
        }

        $this->db->transBegin();
        $this->db->table($this->table)->insert($data);
        $customer_id = 0;
        if ($this->db->affectedRows() > 0) {
            $saveQueries[]  = $this->db->getLastQuery()->getQuery();
            $customer_id    = $this->db->insertID();
        }

        if ($sqlUpdateLastNumber != NULL) {
            $this->db->query($sqlUpdateLastNumber);
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

        saveQueries($saveQueries, 'customer', $customer_id, 'add');
        return $save;
    }

    public function updateCustomer($data)
    {
        $this->db->query('LOCK TABLES ms_customer WRITE');
        $save = $this->db->table($this->table)->update($data, ['customer_id' => $data['customer_id']]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'customer', $data['customer_id'], 'update');
        return $save;
    }

    public function deleteCustomer($customer_id)
    {
        $this->db->query('LOCK TABLES ms_customer WRITE');
        $data = ['deleted' => 'Y'];
        $save = $this->db->table($this->table)->update($data, ['customer_id' => $customer_id]);
        $saveQueries = NULL;
        if ($this->db->affectedRows() > 0) {
            $saveQueries = $this->db->getLastQuery()->getQuery();
        }
        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'customer', $customer_id, 'delete');
        return $save;
    }


    public function verificationEmail($customer_id)
    {
        $this->db->query('LOCK TABLES ms_customer WRITE,ms_mapping_area READ,ms_salesman READ,ms_config READ,customer_history_point WRITE');
        $saveQueries = NULL;

        $result = ['success' => false, 'message' => 'Verifikasi gagal', 'customer_data' => null];
        $getCustomer = $this->getCustomer($customer_id)->getRowArray();

        if ($getCustomer == NULL) {
            $result = ['success' => false, 'message' => 'Akun tidak ditemukan', 'customer_data' => null];
        } else {
            $isVerif = $getCustomer['verification_email'] == 'Y' ? true : false;
            if ($isVerif) {
                $result = ['success' => true, 'message' => 'Halo <b>' . $getCustomer['customer_name'] . '</b>,<br>Verifikasi akun anda berhasil', 'customer_data' => $getCustomer];
            } else {
                $this->db->transBegin();
                $this->db->table($this->table)->update(['verification_email' => 'Y'], ['customer_id' => $customer_id]);
                if ($this->db->affectedRows() > 0) {
                    $saveQueries[]  = $this->db->getLastQuery()->getQuery();
                }

                // check referal code //
                if ($getCustomer['invite_by_referral_code'] != '') {
                    $allowedCustomerGroup = ['G3', 'G4']; //G3=GOLD G4=PLATINUM
                    //check registered user group//
                    if (in_array($getCustomer['customer_group'], $allowedCustomerGroup)) {
                        $getInviteUser = $this->getCustomerByReferralCode($getCustomer['invite_by_referral_code'])->getRowArray();
                        if ($getInviteUser != NULL) {
                            //check inviter user group//
                            if (in_array($getInviteUser['customer_group'], $allowedCustomerGroup)) {
                                $getConfigPoint = $this->db->table('ms_config')
                                    ->select('config_value')
                                    ->where('config_group', 'default')
                                    ->where('config_subgroup', 'customer_group')
                                    ->where('config_name', 'referral_point')
                                    ->get()->getRowArray();
                                $add_point = $getConfigPoint == NULL ? 0 : floatval($getConfigPoint['config_value']);

                                $customer_point     = floatval($getCustomer['customer_point']);
                                $new_customer_point = $customer_point + $add_point;

                                $inviter_id         = intval($getInviteUser['customer_id']);
                                $inviter_point      = floatval($getInviteUser['customer_point']);
                                $new_inviter_point  = $inviter_point + $add_point;

                                // update batch  point //
                                $updatePoint = [];
                                $updatePoint[] = [
                                    'customer_id'       => $customer_id,
                                    'customer_point'    => $new_customer_point
                                ];

                                $updatePoint[] = [
                                    'customer_id'       => $inviter_id,
                                    'customer_point'    => $new_inviter_point
                                ];
                                $this->db->table('ms_customer')->updateBatch($updatePoint, 'customer_id');
                                if ($this->db->affectedRows() > 0) {
                                    $saveQueries[]  = $this->db->getLastQuery()->getQuery();
                                }

                                // insert log history point //
                                $historyData = [];
                                $historyData[] = [
                                    'customer_id'       => $customer_id,
                                    'log_point_remark'  => 'Bonus referral code',
                                    'customer_point'    =>  $add_point
                                ];
                                $historyData[] = [
                                    'customer_id'       => $inviter_id,
                                    'log_point_remark'  => 'Bonus referral code',
                                    'customer_point'    =>  $add_point
                                ];
                                $this->db->table('customer_history_point')->insertBatch($historyData);
                                if ($this->db->affectedRows() > 0) {
                                    $saveQueries[]  = $this->db->getLastQuery()->getQuery();
                                }
                            }
                        }
                    }
                }
                // end check referal code //

                if ($this->db->transStatus() === false) {
                    $this->db->transRollback();
                    $saveQueries = NULL;
                    $result = ['success' => false, 'message' => 'Verifikasi akun gagal', 'customer_data' => $getCustomer];
                } else {
                    $this->db->transCommit();
                    $result = ['success' => true, 'message' => 'Halo <b>' . $getCustomer['customer_name'] . '</b>,<br>Verifikasi akun anda berhasil', 'customer_data' => $getCustomer];
                }
            }
        }
        $this->db->query('UNLOCK TABLES');

        saveQueries($saveQueries, 'customer', $customer_id, 'verification');
        return  $result;
    }


    public function importCustomer($customerData)
    {
        $this->db->query('LOCK TABLES ms_customer WRITE,last_record_number WRITE');
        $saveQueries    = NULL;
        $errors         = [];
        $this->db->transBegin();
        $record_period = date('mY');
        $getLastNumber = $this->db->table('last_record_number')
            ->where('record_module', 'customer')
            ->where('record_period', $record_period)
            ->get()->getRowArray();

        $record_id = 0;
        if ($getLastNumber == NULL) {
            $last_number    = 0;
        } else {
            $record_id      = intval($getLastNumber['record_id']);
            $last_number    = intval($getLastNumber['last_number']);
        }

        $max_insert = 1;
        $batchInsert = array_chunk($customerData, $max_insert);
        foreach ($batchInsert as $batch) {
            $insert_customer = [];
            foreach ($batch as $data) {
                $customer_code = $data['customer_code'];
                if ($customer_code == '') {
                    $last_number++;
                    $data['customer_code'] =  'C' . substr($record_period, 0, 2) . substr($record_period, -2) . substr('00000' . $last_number, -5);
                }

                $insert_customer[] = $data;
            }
            $this->db->table($this->table)->insertBatch($insert_customer, true, $max_insert);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[]  = $this->db->getLastQuery()->getQuery();
            }
            $errors[] = $this->db->error();
        }

        $update_last_number = [
            'record_module' => 'customer',
            'store_id'      => 0,
            'record_period' => $record_period,
            'last_number'   => $last_number
        ];

        if ($record_id == 0) {
            $this->db->table('last_record_number')->set($update_last_number)->insert();
            $errors[] = $this->db->error();
            if ($this->db->affectedRows() > 0) {
                $saveQueries[]  = $this->db->getLastQuery()->getQuery();
            }
        } else {
            $this->db->table('last_record_number')->set($update_last_number)->where('record_id', $record_id)->update();
            $errors[] = $this->db->error();
            if ($this->db->affectedRows() > 0) {
                $saveQueries[]  = $this->db->getLastQuery()->getQuery();
            }
        }


        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $saveQueries = NULL;
            $save = ['success' => FALSE, 'errors' => $errors, 'message' => 'Import data customer gagal'];
        } else {
            $this->db->transCommit();
            $save = ['success' => TRUE, 'errors' => $errors, 'message' => 'Import data customer gagal'];
        }

        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'customer', 0, 'import');
        return $save;
    }
}
