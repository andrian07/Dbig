<?php

namespace App\Libraries;

class Datatables
{
    /* Connection to db */
    private $conn;
    private $request = [];
    private $table = '';

    private $renderColumn = null;

    public $defaultOrderColumn = 0;
    public $defaultOrderBy = 'ASC';

    public $orderColumn = [];
    public $searchColumn = [];
    public $column = [];
    public $db;

    public function __construct($table_name, $db_group = NULL)
    {
        if ($db_group == NULL) {
            $this->conn = \Config\Database::connect();
        } else {
            $this->conn = \Config\Database::connect($db_group);
        }
        $this->db       = $this->conn->table($table_name);
        $this->table    = $table_name;
        $requestData    = $_REQUEST;
        if (isset($requestData['search']['value'])) {
            $search     = $requestData['search']['value'];
        } else {
            $search     = '';
        }

        $length = isset($requestData['length']) ? $requestData['length'] : 10;
        $start = isset($requestData['start']) ? $requestData['start'] : 0;
        $order_column = isset($requestData['order'][0]['column']) ? $requestData['order'][0]['column'] : $this->defaultOrderColumn;
        $order_by = isset($requestData['order'][0]['dir']) ? $requestData['order'][0]['dir'] : $this->defaultOrderBy;
        $draw = isset($requestData['draw']) ? intval($requestData['draw']) : 0;

        $this->request = [
            'search' => $search,
            'length' => $length,
            'start'  => $start,
            'order_column'  => $order_column,
            'order_by' => $order_by,
            'draw' => $draw
        ];

        $this->db->where('"1"', '"1"', FALSE);
    }

    public function renderColumn(callable $callback)
    {
        $this->renderColumn = $callback;
    }

    private function getResults()
    {
        $recordTotal = $this->db->countAllResults(FALSE);
        $recordFiltered = $recordTotal;
        $search = $this->request['search'];
        $searchColumn = $this->searchColumn;
        if (count($searchColumn) > 0 && trim($search) != '') {
            $this->db->groupStart();
            $sRow = 1;
            foreach ($searchColumn as $col) {
                if ($sRow == 1) {
                    $this->db->like($col, $search);
                } else {
                    $this->db->orLike($col, $search);
                }
                $sRow++;
            }
            $this->db->groupEnd();
            $recordFiltered = $this->db->countAllResults(FALSE);;
        }

        $orderColumn = $this->orderColumn[$this->request['order_column']];
        $orderBy = $this->request['order_by'];


        $this->db->orderBy($orderColumn, $orderBy);
        $this->db->limit($this->request['length'], $this->request['start']);

        return [
            'recordTotal'    => $recordTotal,
            'recordFiltered' => $recordFiltered,
            'data'           => $this->db->get()
        ];
    }

    public function generate()
    {
        $result = $this->getResults();
        $data = $result['data'];

        $_row = $this->request['start'] + 1;
        $result_list = [];
        foreach ($data->getResultArray() as $field) {
            $result_row = [];
            if (is_callable($this->renderColumn)) {
                $result_row = call_user_func($this->renderColumn, $field, $_row);
            }
            $_row++;
            $result_list[] = $result_row;
        }

        $json = [
            "draw"            => $this->request['draw'],
            "recordsTotal"    => $result['recordTotal'],
            "recordsFiltered" => $result['recordFiltered'],
            "data"            => $result_list
        ];

        header('Content-Type: application/json');
        echo json_encode($json, JSON_HEX_APOS | JSON_HEX_QUOT);
    }
}
