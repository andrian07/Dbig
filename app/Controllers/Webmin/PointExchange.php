<?php

namespace App\Controllers\Webmin;

use App\Models\M_point_exchange;
use App\Controllers\Base\WebminController;

class PointExchange extends WebminController
{
    protected $M_point_exchange;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->M_point_exchange = new M_point_exchange;
    }

    public function index()
    {
        $data = [
            'title'             => 'Penukaran Poin',
        ];
        return $this->renderView('customer_point/point_exchange', $data, 'point_exchange.view');
    }

    public function searchReward()
    {
        $this->validationRequest(TRUE);
        $keyword = $this->request->getGet('term');
        $result = ['success' => FALSE, 'num_reward' => 0, 'data' => [], 'message' => ''];
        if (!($keyword == '' || $keyword == NULL)) {
            $M_point_reward = model('M_point_reward');
            $find =  $M_point_reward->searchReward($keyword)->getResultArray();

            $find_result = [];
            foreach ($find as $row) {
                $diplay_text = $row['reward_code'] . ' - ' . $row['reward_name'];
                $find_result[] = [
                    'id'                => $diplay_text,
                    'value'             => $diplay_text,
                    'reward_id'         => $row['reward_id'],
                    'reward_code'       => $row['reward_code'],
                    'reward_name'       => $row['reward_name'],
                    'reward_point'      => $row['reward_point'],
                    'reward_stock'      => $row['reward_stock'],
                ];
            }

            $result = ['success' => TRUE, 'num_reward' => count($find_result), 'data' => $find_result, 'message' => ''];
        }
        resultJSON($result);
    }

    public function tableExchange()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('point_reward.view')) {
            helper('datatable');
            $customer_id = $this->request->getPost('customer_id');
            $table = new \App\Libraries\Datatables('exchange_point');
            $table->db->select('exchange_point.*,user_account.user_realname,ms_point_reward.reward_name');
            $table->db->join('ms_point_reward', 'ms_point_reward.reward_id=exchange_point.reward_id');
            $table->db->join('user_account', 'user_account.user_id=exchange_point.user_id', 'left');
            $table->db->where('exchange_point.customer_id', $customer_id);

            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = indo_short_date($row['exchange_date']);
                $column[] = esc($row['reward_name']);
                $column[] = numberFormat($row['reward_point'], true);
                if ($row['user_realname'] != NULL) {
                    $column[] = esc($row['user_realname']);
                } else {
                    $column[] = 'System';
                }
                $label_status = '';
                switch ($row['exchange_status']) {
                    case 'pending':
                        $label_status = '<span class="badge badge-primary">Proses</span>';
                        break;
                    case 'success':
                        $label_status = ' <span class="badge badge-success">Selesai</span>';
                        break;
                    case 'cancel':
                        $label_status = '<span class="badge badge-danger">Batal</span>';
                        break;
                }
                $column[] = $label_status;

                $btns = [];

                $btns[] = '<a href="javascript:;" data-fancybox data-type="iframe" data-src="' . base_url('webmin/point-exchange/detail/' . $row['exchange_id']) . '" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></a>';
                $prop =  'data-id="' . $row['exchange_id'] . '" data-name="' . esc($row['reward_name']) . '" data-code="' . esc($row['exchange_code']) . '"';

                if ($row['exchange_status'] != 'pending') {
                    $prop .= ' disabled';
                }
                $btns[] = '<button ' . $prop . ' class="btn btn-sm btn-danger btncancel" data-toggle="tooltip" data-placement="top" data-title="Batal"><i class="fas fa-times"></i></button>';
                $btns[] = '<button ' . $prop . ' class="btn btn-sm btn-success btncomplete" data-toggle="tooltip" data-placement="top" data-title="Selesai"><i class="fas fa-check"></i></button>';
                $column[] = implode('&nbsp;', $btns);

                return $column;
            });

            $table->orderColumn  = ['', 'exchange_point.exchange_code', 'ms_reward_point.reward_name', 'exchange_point.reward_point', 'exchange_point.user_id', 'exchange_point.exchange_status', ''];
            $table->searchColumn = ['ms_reward_point.reward_name'];
            $table->generate();
        }
    }

    public function tableHistory()
    {
        $this->validationRequest(TRUE);
        if ($this->role->hasRole('point_reward.view')) {
            helper('datatable');
            $customer_id = $this->request->getPost('customer_id');
            $table = new \App\Libraries\Datatables('customer_history_point');
            $table->db->select('*');
            $table->db->where('customer_id', $customer_id);

            $table->renderColumn(function ($row, $i) {
                $column = [];
                $column[] = $i;
                $column[] = indo_short_date($row['created_at'], TRUE, ' ');
                $column[] = esc($row['log_point_remark']);

                $customer_point = floatval($row['customer_point']);
                if ($customer_point >= 0) {
                    $column[] = '<span class="text-success">+' . numberFormat($customer_point, true) . '</span>';
                } else {
                    $column[] = '<span class="text-danger">' . numberFormat($customer_point, true) . '</span>';
                }
                return $column;
            });

            $table->orderColumn  = ['', 'created_at', 'log_point_remark', 'customer_point'];
            $table->searchColumn = ['log_point_remark'];
            $table->generate();
        }
    }

    public function exchange()
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        $validation =  \Config\Services::validation();

        $input = [
            'customer_id'           => $this->request->getPost('customer_id'),
            'reward_id'             => $this->request->getPost('reward_id'),
            'reward_point'          => $this->request->getPost('reward_point'),
            'exchange_date'         => date('Y-m-d'),
            'exchange_status'       => 'success',
            'store_id'              => $this->userLogin['store_id'],
            'user_id'               => $this->userLogin['user_id'],
            'completed_by'          => $this->userLogin['user_id'],
            'completed_at'          => date('Y-m-d H:i:s')
        ];


        $validation->setRules([
            'reward_id'            => ['rules' => 'required'],
            'reward_point'         => ['rules' => 'required'],
            'customer_id'          => ['rules' => 'required'],
        ]);


        if ($validation->run($input) === FALSE) {
            $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        } else {
            if ($this->role->hasRole('point_exchange.view')) {
                $result = $this->M_point_exchange->exchangeReward($input);
            } else {
                $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menukar hadiah'];
            }
        }

        $result['csrfHash'] = csrf_hash();
        resultJSON($result);
    }

    public function cancelExchange($exchange_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('point_exchange.view')) {
            $store_id   = $this->userLogin['store_id'];
            $user_id    = $this->userLogin['user_id'];

            $cancel = $this->M_point_exchange->cancelExchange($exchange_id, $store_id, $user_id);
            if ($cancel) {
                $result = ['success' => TRUE, 'message' => 'Penukaran hadiah berhasil dibatalkan'];
            } else {
                $result = ['success' => FALSE, 'message' => 'Penukaran hadiah gagal dibatalkan'];
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk membatalkan penukaran hadiah'];
        }
        resultJSON($result);
    }

    public function successExchange($exchange_id = '')
    {
        $this->validationRequest(TRUE);
        $result = ['success' => FALSE, 'message' => 'Input tidak valid'];
        if ($this->role->hasRole('point_exchange.view')) {
            $store_id   = $this->userLogin['store_id'];
            $user_id    = $this->userLogin['user_id'];

            $cancel = $this->M_point_exchange->successExchange($exchange_id, $store_id, $user_id);
            if ($cancel) {
                $result = ['success' => TRUE, 'message' => 'Penukaran hadiah berhasil diselesaikan'];
            } else {
                $result = ['success' => FALSE, 'message' => 'Penukaran hadiah gagal diselesaikan'];
            }
        } else {
            $result = ['success' => FALSE, 'message' => 'Anda tidak memiliki akses untuk menyelesaikan penukaran hadiah'];
        }
        resultJSON($result);
    }

    public function detail($exchange_id = '')
    {
        if ($exchange_id == '') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $find = $this->M_point_exchange->getExchange($exchange_id)->getRowArray();
            if ($find == NULL) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            } else {
                $data = [
                    'title'     => 'Detail Penukaran',
                    'detail'    => $find,

                ];
                return $this->renderView('customer_point/point_exchange_detail', $data, 'point_exchange.view');
            }
        }
    }
    //--------------------------------------------------------------------

}
