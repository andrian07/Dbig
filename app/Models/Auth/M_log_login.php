<?php

namespace App\Models\Auth;

use CodeIgniter\Model;

class M_log_login extends Model
{
    protected $table = 'log_login';

    public function getLog($login_id = '')
    {
        $builder = $this->db->table($this->table);
        $builder->select("log_login.*,user_account.user_name,user_account.user_realname")
            ->join('user_account', 'user_account.user_id=log_login.user_id');

        if ($login_id   != '') {
            $builder->where('log_login.login_id', $login_id);
        }

        return $builder->get();
    }

    public function getLogByUser($user_id = '')
    {
        $builder = $this->db->table($this->table);
        $builder->select("log_login.*,user_account.user_name,user_account.user_realname")
            ->join('user_account', 'user_account.user_id=log_login.user_id');

        if ($user_id  != '') {
            $builder->where('log_login.user_id', $user_id);
        }

        return $builder->get();
    }

    public function getActiveSession()
    {
        $builder = $this->db->table('log_login');
        $builder->select("log_login.*,user_account.user_name,user_account.user_realname")
            ->join('user_account', 'user_account.user_id=log_login.user_id');

        $builder->where('log_login.is_valid', 'N');
        $builder->where('log_login.is_expired', 'N');
        return $builder->get();
    }

    public function getLogBySessionCode($session_code = '', $is_valid = '')
    {
        $builder = $this->db->table($this->table);
        $builder->select("log_login.*,user_account.username,user_account.user_realname")
            ->join('user_account', 'user_account.user_id=log_login.user_id');

        if ($session_code  != '') {
            $builder->where('log_login.session_code', $session_code);
        }

        if ($is_valid != '') {
            $builder->where('log_login.is_valid', $is_valid);
        }

        return $builder->get();
    }

    public function insertLog($log_data)
    {
        $this->db->query('LOCK TABLES log_login WRITE');
        helper('text');
        $session_code = random_string('alnum', 8);

        $isFound = false;
        while ($isFound == false) {
            $checkCode = $this->db->table($this->table)
                ->where('session_code', $session_code)
                ->where('is_valid', 'N')
                ->where('is_expired', 'N')
                ->get()
                ->getRowArray();

            if ($checkCode == null) {
                $isFound = true;
            }
        }

        $log_data['session_code'] = $session_code;

        $this->db->table($this->table)->insert($log_data);
        if ($this->db->affectedRows() > 0) {
            $login_id = $this->db->insertID();
        } else {
            $login_id = 0;
        }

        $this->db->query('UNLOCK TABLES');


        $result = [
            'login_id'      => $login_id,
            'session_code'  => $session_code
        ];
        return $result;
    }

    public function updateLog($log_data)
    {
        $this->db->query('LOCK TABLES log_login WRITE');
        $save = $this->db->table($this->table)->update($log_data, ['login_id' => $log_data['login_id']]);
        $this->db->query('UNLOCK TABLES');
        return $save;
    }
}
