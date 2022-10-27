<?php

namespace App\Libraries;

class Select2
{
    private $conn;
    public $db;


    private $renderColumn = null;

    /* Request Section */
    private $request;

    /* Config */
    public $limit = 20;
    public $searchFields = [];
    public $orderBy = '';
    public $orderDir = 'ASC';
    private $renderResult = null;

    public function __construct($table_name, $db_group = NULL)
    {
        if ($db_group == NULL) {
            $this->conn = \Config\Database::connect();
        } else {
            $this->conn = \Config\Database::connect($db_group);
        }
        $this->db = $this->conn->table($table_name);

        $requestData = $_REQUEST;
        $search = isset($requestData['search']) ? $requestData['search'] : '';
        $this->request = [
            'search' => $search
        ];

        $this->db->where('"1"', '"1"', FALSE);
    }

    public function renderResult(callable $callback)
    {
        $this->renderResult = $callback;
    }


    public function generate()
    {
        $search = $this->request['search'];
        $searchFields = $this->searchFields;
        $this->db->groupStart();
        $field_row = 0;
        foreach ($searchFields as $src) {
            if ($field_row == 0) {
                $this->db->like($src, $search);
            } else {
                $this->db->orLike($src, $search);
            }
            $field_row++;
        }
        $this->db->groupEnd();
        $this->db->limit($this->limit);

        $this->db->orderBy($this->orderBy, $this->orderDir);
        $getData = $this->db->get();

        $_row = 0;
        $result_list = [];
        foreach ($getData->getResultArray() as $field) {
            $result_row = [];
            if (is_callable($this->renderResult)) {
                $result_row = call_user_func($this->renderResult, $field, $_row);
            }

            $result_list[$_row] = $result_row;
            $_row++;
        }

        header('Content-Type: application/json');
        echo json_encode($result_list, JSON_HEX_APOS | JSON_HEX_QUOT);
    }
}
