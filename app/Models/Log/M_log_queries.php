<?php

namespace App\Models\Log;

use CodeIgniter\Model;

class M_log_queries extends Model
{
    protected $table = 'hd_log_queries';
    protected $DBGroup = 'logs';

    public function insertLog($queries = NULL, $log_remark = '', $user_id, $module = 'system', $ref_id = 0)
    {
        $db = \Config\Database::connect($this->DBGroup);
        if ($queries != NULL) {
            $db->query('LOCK TABLES hd_log_queries WRITE,dt_log_queries WRITE');
            $data_header = [
                'module'        => $module,
                'ref_id'        => $ref_id,
                'user_id'       => $user_id,
                'log_remark'    => $log_remark
            ];

            $db->table('hd_log_queries')->insert($data_header);
            $log_id = $db->insertID();

            if (is_string($queries)) {
                $data_detail = [
                    'log_id'        => $log_id,
                    'query_text'    => $queries,
                ];
                $db->table('dt_log_queries')->insert($data_detail);
            } else if (is_array($queries)) {
                $data_details = [];
                foreach ($queries as $qstr) {
                    $data_details[] = [
                        'log_id'        => $log_id,
                        'query_text'    => $qstr,
                    ];
                }
                $db->table('dt_log_queries')->insertBatch($data_details);
            }

            $db->query('UNLOCK TABLES');
        }
    }

    public function insertLogEdit($queries = NULL, $log_remark = '', $user_id, $module = 'system', $ref_id = 0)
    {
        $db = \Config\Database::connect($this->DBGroup);
        if ($queries != NULL) {
            $db->query('LOCK TABLES log_transaction_edit_queries WRITE');
            $data = [
                'log_transaction_code'      => $module,
                'log_transaction_id'        => $ref_id,
                'log_user_id'               => $user_id,
                'log_remark'                => $log_remark
            ];
            $db->table('log_transaction_edit_queries')->insert($data);
            $log_id = $db->insertID();
            $db->query('UNLOCK TABLES');
        }
    }

    public function getLogDetail($log_id)
    {
        $db = \Config\Database::connect($this->DBGroup);
        return $db->table('dt_log_queries')->where('log_id', $log_id)->get();
    }
}
