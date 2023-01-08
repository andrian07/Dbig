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
}
