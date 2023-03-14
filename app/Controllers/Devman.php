<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;

class Devman extends BaseController
{
    public function index()
    {
        if (session()->get('devman_login') != NULL) {
            return redirect()->to(base_url('devman/log-queries'));
        }

        $data = [
            'alert' => session()->getFlashdata('alert'),
            'input' => session()->getFlashdata('input')
        ];
        return view('devman/login', $data);
    }

    public function login()
    {
        $this->validationRequest();
        if (session()->get('devman_login') != NULL) {
            return redirect()->to(base_url('devman/log-queries'));
        }

        $validation =  \Config\Services::validation();
        $validation->setRules([
            'username' => ['label' => 'Username', 'rules' => 'required|min_length[5]|max_length[100]'],
            'password' => ['label' => 'Password', 'rules' => 'required|min_length[8]|max_length[100]'],
        ]);

        $input = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password')
        ];

        if ($validation->run($input)) {
            if ($input['username'] == DEV_USERNAME && $input['password'] == DEV_PASSWORD) {
                $loginData = [
                    'login_at' => date('Y-m-d H:i:s')
                ];
                session()->set('devman_login', $loginData);
                return redirect()->to(base_url('devman/log-queries'));
            } else {
                session()->setFlashdata('input', $this->request->getPost());
                session()->setFlashdata('alert', ['type' => 'danger', 'message' => 'Username atau password anda salah!']);
                return redirect()->to(base_url('devman/auth'));
            }
        } else {
            session()->setFlashdata('alert', ['type' => 'danger', 'message' => 'Username atau password anda salah']);
            session()->setFlashdata('input', $this->request->getPost());
            return redirect()->to(base_url('devman/auth'));
        }
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('alert', ['type' => 'info', 'message' => 'Anda berhasil keluar dari aplikasi']);
        return redirect()->to(base_url('devman/auth'));
    }

    public function logQueries()
    {
        $data = [
            'title' => 'Log Queries'
        ];
        return view('devman/log_queries', $data);
    }

    public function getLogQueries()
    {
        $this->validationRequest(TRUE);
        helper('datatable');
        $table = new \App\Libraries\Datatables('dt_log_queries', 'logs');
        $table->db->select('hd_log_queries.*,count(dt_log_queries.detail_id) as count_queries');
        $table->db->join('hd_log_queries', 'hd_log_queries.log_id=dt_log_queries.log_id');
        $table->db->groupBy('dt_log_queries.log_id');

        $table->orderColumn  = ['', 'hd_log_queries.log_id', 'hd_log_queries.module', 'hd_log_queries.ref_id', 'hd_log_queries.user_id', 'hd_log_queries.log_remark', ''];
        $table->searchColumn = ['dt_log_queries.query_text'];


        $table->renderColumn(function ($row, $i) {
            $column   = [];
            $log_id   = $row['log_id'];
            $column[] = $i;
            $column[] = indo_short_date($row['created_at'], true, '<br>');
            $column[] = esc($row['module']);
            $column[] = esc($row['ref_id']);
            $column[] = esc($row['user_id']);
            $column[] = esc($row['log_remark']);
            $column[] = '<button data-id="' . $log_id . '" class="btn btn-sm btn-default btndetail" data-toggle="tooltip" data-placement="top" data-title="Detail"><i class="fas fa-eye"></i></button>';
            return $column;
        });


        $table->generate();
    }

    public function getLogQueriesDetail($log_id = 1)
    {
        $this->validationRequest(true);
        $result = [
            'log_id'        => $log_id,
            'log_detail'    => []
        ];

        $M_log_queries = model('Log/M_log_queries');
        $getLogs =  $M_log_queries->getLogDetail($log_id)->getResultArray();
        foreach ($getLogs as $log) {
            $result['log_detail'][] = esc($log);
        }
        resultJSON($result);
    }

    public function install()
    {
        $migration  = $this->request->getGet('migration') == NULL ? FALSE : TRUE;
        $demo       = $this->request->getGet('demo') == NULL ? FALSE : TRUE;
        $configDir = $this->myConfig->uploadImage;
        foreach ($configDir as $cfg) {
            $upload_dir     = isset($cfg['upload_dir']) ? $cfg['upload_dir'] : NULL;
            $thumb_dir      = isset($cfg['thumb_dir']) ? $cfg['thumb_dir'] : NULL;
            if ($upload_dir != NULL) {
                if (!file_exists($upload_dir)) {
                    $run    = mkdir($upload_dir, 0777, true);
                    $result = !$run ? 'FAILED' : 'SUCCESS';
                    echo "CREATE DIR $upload_dir : $result </br>";
                }
            }

            if ($thumb_dir != NULL) {
                if (!file_exists($thumb_dir)) {
                    $run    = mkdir($thumb_dir, 0777, true);
                    $result = !$run ? 'FAILED' : 'SUCCESS';
                    echo "CREATE DIR $thumb_dir : $result </br>";
                }
            }
        }

        if ($migration) {
            $migrate = \Config\Services::migrations();
            try {
                $migrate->latest();
                echo "Run Migration : SUCCESS </br>";
            } catch (Throwable $e) {
                echo "Run Migration : FAILED </br>";
            }
        }

        // run seeder //
        $seeder = \Config\Database::seeder();
        echo "Run InitSeeder </br>";
        $seeder->call('InitSeeder');

        if ($demo) {
            echo "Run DemoSeeder </br>";
            $seeder->call('DemoSeeder');
        }
    }

    public function testEmail()
    {
        helper('encrypter');
        $customer_id    = 2;
        $customer_name  = 'Eric Tandra';
        $customer_email = 'andrian.chen@yahoo.com';

        /* sample verification email */
        // url valid for 1 days (60 seconds * 60 minutes * 24 hours)
        $params = [
            'customer_id'       => $customer_id,
            'customer_code'     => 'C022300001',
            'exp_time'          => time() + (60 * 60 * 24)
        ];
        $toJson = json_encode($params);
        $strEncode = strEncode($toJson);
        $verificationUrl = base_url('verification/' . $strEncode) . '?cid=' . $customer_id;

        $subject = 'Verifikasi Email';
        $data = [
            'customer_name'    => $customer_name,
            'verification_url' => $verificationUrl,
        ];
        $message = view('email/verification', $data);
        /* end sample verification email */

        $mail = new \App\Libraries\Mail();
        $mail->setTo($customer_email);
        $mail->setSubject($subject);
        $mail->setMessage($message);

        if ($mail->send()) {
            echo "Berhasil Terkirim";
        } else {
            ob_start();
            $mail->get_debugger_messages();
            $error = ob_end_clean();
            $errors[] = $error;
        }
    }
}
