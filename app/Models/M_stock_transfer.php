<?php

namespace App\Models;

use CodeIgniter\Model;

class M_stock_transfer extends Model
{

	protected $table_temp_transfer  = 'temp_transfer_stock';

	protected $table_hd_transfer_stock = 'hd_transfer_stock';

	protected $table_dt_transfer_stock = 'dt_transfer_stock';

	protected $table_warehouse = 'ms_warehouse';

	public function insertTemp($data)
	{

		$this->db->query('LOCK TABLES temp_transfer_stock WRITE');

		$exist = $this->db->table($this->table_temp_transfer)

		->where('item_id', $data['item_id'])

		->where('item_user_id', $data['item_user_id'])

		->countAllResults();

		if ($exist > 0) {

			return $this->db->table($this->table_temp_transfer)

			->where('item_id', $data['item_id'])

			->where('item_user_id', $data['item_user_id'])

			->update($data);

		} else {

			return $this->db->table($this->table_temp_transfer)->insert($data);

		}

	}

	public function getTemp($user_id)
	{
		$this->db->query('LOCK TABLES ms_product_unit READ, temp_transfer_stock READ, ms_product READ, ms_unit READ');

		$builder = $this->db->table($this->table_temp_transfer);

		return $builder->select('*')

		->join('ms_product_unit', 'ms_product_unit.item_id = temp_transfer_stock.item_id')

		->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id')

		->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id')

		->where('temp_transfer_stock.item_user_id', $user_id)

		->orderBy('temp_transfer_stock.item_update_at', 'ASC')

		->get();
	}

	public function getTempCheck($item_id)
	{
		$builder = $this->db->table($this->table_temp_transfer);

		return $builder->select('sum(item_qty) as total_temp')

		->where('item_id', $item_id)

		->get();
	}

	public function deletetemp($item_id, $item_user_id)
	{

		$this->db->query('LOCK TABLES temp_transfer_stock WRITE');

		$save = $this->db->table($this->table_temp_transfer)->delete(['item_id' => $item_id , 'item_user_id' => $item_user_id]);

		return $save;
	}

	public function clearTemp($user_id)
	{
		$this->db->query('LOCK TABLES temp_transfer_stock WRITE');
		return $this->db->table($this->table_temp_transfer)
		->where('item_user_id', $user_id)
		->delete();
	}

	public function insertStockTransfer($data)
	{

		$this->db->query('LOCK TABLES hd_transfer_stock WRITE');

		$this->db->transBegin();

		$saveQueries = NULL;

		$maxCode = $this->db->table($this->table_hd_transfer_stock)->select('hd_transfer_stock_id, hd_transfer_stock_no')->orderBy('hd_transfer_stock_id', 'desc')->limit(1)->get()->getRowArray();

		$warehouse_code = $this->db->table($this->table_warehouse)->select('warehouse_code')->where('warehouse_id', $data['hd_transfer_stock_warehose_from'])->get()->getRowArray();

		$invoice_date =  date_format(date_create($data['hd_transfer_stock_date']),"y/m/d");

		if ($maxCode == NULL) {

			$data['hd_transfer_stock_no'] = 'TRF/'.$warehouse_code['warehouse_code'].'/'.$invoice_date.'/'.'0000000001';

		} else {

			$invoice = substr($maxCode['hd_transfer_stock_no'], -10);

			$data['hd_transfer_stock_no'] = 'TRF/'.$warehouse_code['warehouse_code'].'/'.$invoice_date.'/'.substr('000000000' . strval(floatval($invoice) + 1), -10);

		}

		$this->db->table($this->table_hd_transfer_stock)->insert($data);

		$hd_transfer_stock_id  = $this->db->insertID();



		if ($this->db->affectedRows() > 0) {

			$saveQueries[] = [

				'query_text'    => $this->db->getLastQuery()->getQuery(),

				'ref_id'        => $hd_transfer_stock_id 

			];

		}



		$sqlDtOrder = "insert into dt_transfer_stock(hd_transfer_stock_id,item_id,item_qty) VALUES";

		$sqlUpdateStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

		$sqlPlusStock = "insert into ms_product_stock (product_id  , warehouse_id  , stock) VALUES";

		$sqlDtValues = [];

		$vUpdateStock = [];

		$vPlusStock = [];

		$getTemp =  $this->getTemp($data['user_id']);

		foreach ($getTemp->getResultArray() as $row) {

			$detail_hd_transfer_stock_id    = $hd_transfer_stock_id;
			$detail_item_id      			= $row['item_id'];
			$detail_item_qty             	= $row['item_qty'];
			$product_id						= $row['product_id'];
			$product_content        	    = floatval($row['product_content']);
			$base_purchase_stock   			= $row['item_qty'] * $product_content;
			$warehouse_id_from 				= $data['hd_transfer_stock_warehose_from'];
			$warehouse_id_to 				= $data['hd_transfer_stock_warehose_to'];

			$sqlDtValues[] = "('$detail_hd_transfer_stock_id','$detail_item_id','$detail_item_qty')";

			$vUpdateStock[] = "('$product_id', '$warehouse_id_from', '$base_purchase_stock')";

			$vPlusStock[] = "('$product_id', '$warehouse_id_to', '$base_purchase_stock')";
		}

		$sqlDtOrder .= implode(',', $sqlDtValues);

		$sqlUpdateStock .= implode(',', $vUpdateStock). " ON DUPLICATE KEY UPDATE stock=stock-VALUES(stock)";

		$sqlPlusStock .= implode(',', $vPlusStock). " ON DUPLICATE KEY UPDATE stock=stock+VALUES(stock)";

		$this->db->query('LOCK TABLES dt_transfer_stock WRITE, ms_product_stock WRITE');

		$this->db->query($sqlDtOrder);

		if ($this->db->affectedRows() > 0) {
			$saveQueries = $this->db->getLastQuery()->getQuery();
		}

		$this->db->query($sqlUpdateStock);

		if ($this->db->affectedRows() > 0) {
			$saveQueries = $this->db->getLastQuery()->getQuery();
		}

		$this->db->query($sqlPlusStock);

		if ($this->db->affectedRows() > 0) {
			$saveQueries = $this->db->getLastQuery()->getQuery();
		}

		if ($this->db->transStatus() === false) {

			$saveQueries = NULL;

			$this->db->transRollback();

			$save = ['success' => FALSE, 'hd_transfer_stock_id' => 0];

		} else {

			$this->db->transCommit();

			$this->clearTemp($data['user_id']);

			$save = ['success' => TRUE, 'hd_transfer_stock_id' => $hd_transfer_stock_id ];

		}

		$this->db->query('UNLOCK TABLES');

		saveQueries($saveQueries, 'insertTransferStock', $hd_transfer_stock_id);
		return $save;

	}

	public function getHdTransferStockdetail($hd_transfer_stock_id){

        $builder = $this->db->table($this->table_hd_transfer_stock);

        return $builder->select('*, a1.warehouse_name AS warehouse_from_name, a1.warehouse_code AS warehouse_from_code, a1.warehouse_address AS warehouse_from_address, a2.warehouse_name AS warehouse_to_name, a2.warehouse_code AS warehouse_to_code, a2.warehouse_address AS warehouse_to_address, hd_transfer_stock.created_at as created_at')

        ->join('ms_warehouse a1', 'hd_transfer_stock.hd_transfer_stock_warehose_from=a1.warehouse_id', 'left')

        ->join('ms_warehouse a2', 'hd_transfer_stock.hd_transfer_stock_warehose_to=a2.warehouse_id', 'left')

        ->join('user_account', 'user_account.user_id = hd_transfer_stock.user_id')

        ->where('hd_transfer_stock_id', $hd_transfer_stock_id)

        ->get();
    }

    public function getDtTransferStockdetail($hd_transfer_stock_id){

        $builder = $this->db->table($this->table_dt_transfer_stock);

        return $builder->select('*')

        ->join('ms_product_unit', 'ms_product_unit.item_id=dt_transfer_stock.item_id')

        ->join('ms_product', 'ms_product.product_id=ms_product_unit.product_id')

        ->join('ms_unit', 'ms_unit.unit_id=ms_product_unit.unit_id')

        ->where('hd_transfer_stock_id', $hd_transfer_stock_id)

        ->get();
    }

	public function getTransfer($start_date, $end_date, $source_warehouse_id, $dest_warehouse_id){

        $builder = $this->db->table($this->table_hd_transfer_stock);

        $builder->select('*, a1.warehouse_name AS warehouse_from_name, a1.warehouse_code AS warehouse_from_code, a1.warehouse_address AS warehouse_from_address, a2.warehouse_name AS warehouse_to_name, a2.warehouse_code AS warehouse_to_code, a2.warehouse_address AS warehouse_to_address, hd_transfer_stock.created_at as created_at');

        $builder->join('ms_warehouse a1', 'hd_transfer_stock.hd_transfer_stock_warehose_from=a1.warehouse_id', 'left');

        $builder->join('ms_warehouse a2', 'hd_transfer_stock.hd_transfer_stock_warehose_to=a2.warehouse_id', 'left');

		$builder->join('dt_transfer_stock', 'dt_transfer_stock.hd_transfer_stock_id = hd_transfer_stock.hd_transfer_stock_id');

		$builder->join('ms_product_unit', 'ms_product_unit.item_code = dt_transfer_stock.item_id');

		$builder->join('ms_product', 'ms_product.product_id = ms_product_unit.product_id');

		$builder->join('ms_unit', 'ms_unit.unit_id = ms_product_unit.unit_id');

        $builder->join('user_account', 'user_account.user_id = hd_transfer_stock.user_id');

		$builder->where("(hd_transfer_stock_date BETWEEN CAST('$start_date' AS DATE) AND CAST('$end_date' AS DATE))");

		if ($source_warehouse_id != null) {
			$builder->where('hd_transfer_stock_warehose_from', $source_warehouse_id);
		}

		if ($dest_warehouse_id != null) {
			$builder->where('hd_transfer_stock_warehose_to', $dest_warehouse_id);
		}

		return $builder->orderBy('hd_transfer_stock.created_at', 'ASC')->get();
    }

	

}
