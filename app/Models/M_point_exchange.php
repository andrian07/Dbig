<?php

namespace App\Models;

use CodeIgniter\Model;

class M_point_exchange extends Model
{
    protected $table = 'exchange_point';

    public function getExchange($exchange_id = '')
    {
        $builder = $this->db->table($this->table);
        $builder->select('exchange_point.*,user_account.user_realname,ms_point_reward.reward_name,ua.user_realname as completed_by_realname');
        $builder->join('ms_point_reward', 'ms_point_reward.reward_id=exchange_point.reward_id');
        $builder->join('user_account', 'user_account.user_id=exchange_point.user_id', 'left');
        $builder->join('user_account as ua', 'ua.user_id=exchange_point.completed_by', 'left');

        $builder->where('exchange_id', $exchange_id);
        return $builder->get();
    }

    public function exchangeReward($data)
    {

        $sqlUpdateLastNumber    = NULL;
        $saveQueries            = NULL;
        $this->db->query('LOCK TABLES ms_point_reward WRITE,last_record_number WRITE,customer_history_point WRITE,ms_customer WRITE,exchange_point WRITE');

        $customer_id    = $data['customer_id'];
        $reward_id      = $data['reward_id'];
        $reward_point   = floatval($data['reward_point']);

        $getCustomer = $this->db->table('ms_customer')->where('customer_id', $customer_id)->get()->getRowArray();
        if ($getCustomer == NULL) {
            $save = ['success' => FALSE, 'message' => 'Customer tidak ditemukan'];
        } else {
            $customer_point = floatval($getCustomer['customer_point']);
            if ($customer_point >= $reward_point) {
                $getReward = $this->db->table('ms_point_reward')->where('reward_id', $reward_id)->get()->getRowArray();

                $reward_stock = floatval($getReward['reward_stock']);

                if ($reward_stock > 0) {
                    $record_period = date('mY');
                    $getLastNumber = $this->db->table('last_record_number')
                        ->where('record_module', 'exchange_point')
                        ->where('record_period', $record_period)
                        ->get()->getRowArray();

                    if ($getLastNumber == NULL) {
                        $data['exchange_code'] = 'TP' . date('ym') . '000001';

                        $update_last_number = [
                            'record_module' => 'exchange_point',
                            'store_id'      => 0,
                            'record_period' => $record_period,
                            'last_number'   => 1
                        ];
                        $sqlUpdateLastNumber = $this->db->table('last_record_number')->set($update_last_number)->getCompiledInsert();
                    } else {
                        $new_number = strval(intval($getLastNumber['last_number']) + 1);
                        $data['exchange_code'] = 'TP' . date('ym') . substr('000000' . $new_number, -6);

                        $update_last_number = [
                            'record_module' => 'exchange_point',
                            'store_id'      => 0,
                            'record_period' => $record_period,
                            'last_number'   => $new_number
                        ];
                        $sqlUpdateLastNumber = $this->db->table('last_record_number')->set($update_last_number)->where('record_id', $getLastNumber['record_id'])->getCompiledUpdate();
                    }

                    $this->db->transBegin();
                    $this->db->table($this->table)->insert($data);
                    $exchange_id = 0;

                    if ($this->db->affectedRows() > 0) {
                        $saveQueries[]  = $this->db->getLastQuery()->getQuery();
                        $exchange_id    = $this->db->insertID();
                    }

                    $new_customer_point = $customer_point - $reward_point;
                    $this->db->table('ms_customer')->update(['customer_point' => $new_customer_point], ['customer_id' => $customer_id]);
                    if ($this->db->affectedRows() > 0) {
                        $saveQueries[]  = $this->db->getLastQuery()->getQuery();
                    }

                    $new_reward_stock = $reward_stock - 1;
                    $this->db->table('ms_point_reward')->update(['reward_stock' => $new_reward_stock], ['reward_id' => $reward_id]);
                    if ($this->db->affectedRows() > 0) {
                        $saveQueries[]  = $this->db->getLastQuery()->getQuery();
                    }


                    $history_data = [
                        'customer_id'       => $customer_id,
                        'log_point_remark'  => 'Penukaran ' . $getReward['reward_name'],
                        'customer_point'    => ($reward_point * -1)
                    ];
                    $this->db->table('customer_history_point')->insert($history_data);
                    if ($this->db->affectedRows() > 0) {
                        $saveQueries[]  = $this->db->getLastQuery()->getQuery();
                    }

                    $this->db->query($sqlUpdateLastNumber);
                    if ($this->db->affectedRows() > 0) {
                        $saveQueries[] = $this->db->getLastQuery()->getQuery();
                    }


                    if ($this->db->transStatus() === false) {
                        $this->db->transRollback();
                        $saveQueries = NULL;
                        $save = ['success' => FALSE, 'message' => 'Penukaran hadiah gagal'];
                    } else {
                        $this->db->transCommit();
                        $save = ['success' => TRUE, 'message' => 'Penukaran hadiah berhasil'];
                    }
                } else {
                    $save = ['success' => FALSE, 'message' => 'Stok hadiah tidak cukup. sisa: ' . $reward_stock];
                }
            } else {
                $save = ['success' => FALSE, 'message' => 'Poin customer tidak cukup. sisa: ' . $customer_point];
            }
        }


        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'exchange_point',  $exchange_id, 'add');
        return $save;
    }

    public function cancelExchange($exchange_id, $store_id, $user_id)
    {
        $saveQueries            = NULL;
        $this->db->query('LOCK TABLES exchange_point WRITE,ms_point_reward WRITE,ms_customer WRITE,customer_history_point WRITE');

        $getExchange = $this->db->table('exchange_point')
            ->where('exchange_id', $exchange_id)
            ->where('exchange_status', 'pending')
            ->get()->getRowArray();

        if ($getExchange != NULL) {
            $this->db->transBegin();

            $customer_id = $getExchange['customer_id'];
            $getCustomer = $this->db->table('ms_customer')->where('customer_id', $customer_id)->get()->getRowArray();
            $reward_id      = $getExchange['reward_id'];
            $customer_point = floatval($getCustomer['customer_point']);
            $reward_point   = floatval($getExchange['reward_point']);

            $new_customer_point = $customer_point + $reward_point;
            $this->db->table('ms_customer')->where('customer_id', $customer_id)->update(['customer_point' => $new_customer_point]);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[] = $this->db->getLastQuery()->getQuery();
            }


            $this->db->table('ms_point_reward')->set('reward_stock', 'reward_stock+1', FALSE)->where('reward_id', $reward_id)->update();
            if ($this->db->affectedRows() > 0) {
                $saveQueries[]  = $this->db->getLastQuery()->getQuery();
            }


            $history_data = [
                'customer_id'       => $customer_id,
                'log_point_remark'  => 'Pembatalan penukaran poin ' . $getExchange['exchange_code'],
                'customer_point'    => $reward_point
            ];
            $this->db->table('customer_history_point')->insert($history_data);
            if ($this->db->affectedRows() > 0) {
                $saveQueries[]  = $this->db->getLastQuery()->getQuery();
            }


            $update_data = [
                'store_id'        => $store_id,
                'completed_by'    => $user_id,
                'completed_at'    => date('Y-m-d H:i:s'),
                'exchange_status' => 'cancel'
            ];

            $this->db->table('exchange_point')
                ->where('exchange_id', $exchange_id)
                ->where('exchange_status', 'pending')
                ->update($update_data);

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
        } else {
            $save = 0;
        }
        $this->db->query('UNLOCK TABLES');
        saveQueries($saveQueries, 'exchange_point', $exchange_id, 'cancel');
        return $save;
    }

    public function successExchange($exchange_id, $store_id, $user_id)
    {
        $saveQueries  = NULL;
        $this->db->query('LOCK TABLES exchange_point WRITE');

        $getExchange = $this->db->table('exchange_point')
            ->where('exchange_id', $exchange_id)
            ->where('exchange_status', 'pending')
            ->get()->getRowArray();

        if ($getExchange != NULL) {
            $update_data = [
                'store_id'        => $store_id,
                'completed_by'    => $user_id,
                'completed_at'    => date('Y-m-d H:i:s'),
                'exchange_status' => 'success'
            ];

            $update = $this->db->table('exchange_point')
                ->where('exchange_id', $exchange_id)
                ->where('exchange_status', 'pending')
                ->update($update_data);


            if ($this->db->affectedRows() > 0) {
                $saveQueries = $this->db->getLastQuery()->getQuery();
            }
            $this->db->query('UNLOCK TABLES');

            if ($update) {
                $save = 1;
            } else {
                $save = 0;
            }
        } else {
            $save = 0;
        }

        saveQueries($saveQueries, 'exchange_point', $exchange_id, 'success');
        return $save;
    }
}
