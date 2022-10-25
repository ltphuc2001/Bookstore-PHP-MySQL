<?php
class CartModel extends Model
{
	

	public function __construct()
	{
		parent::__construct();
		$this->setTable('cart');
	}

	public function listItems($arrParam, $options = null)
	{
		$query[] 	= "SELECT `c`.`id`, `u`.`username`, `u`.`fullname`, `u`.`email`,`u`.`telephone`,`u`.`address`, `c`.`books`, `c`.`prices`, `c`.`quantities` , `c`.`names`, `c`.`pictures`, `c`.`status`, `c`.`date`";
		$query[] 	= "FROM `{$this->table}` AS `c`, `user` AS `u` WHERE `c`.`username` = `u`.`username`";

		//FILTER BY STATUS	

		if (!empty($arrParam['status']) && $arrParam['status'] != 'all') {
			$statusValue = $arrParam['status'];
			$query[] = "AND `c`.`status` = '$statusValue'";
		}


		//SEARCH
		if (!empty($arrParam['search'])) {
			$keyword = $arrParam['search'];
			$query[] = "AND `c`.`id` LIKE '%$keyword%'";
		}

		// PAGINATION
		$pagination			= $arrParam['pagination'];
		$totalItemsPerPage	= $pagination['totalItemsPerPage'];
		if ($totalItemsPerPage > 0) {
			$position	= ($pagination['currentPage'] - 1) * $totalItemsPerPage;
			$query[]	= "LIMIT $position, $totalItemsPerPage";
		}
		
		$query		= implode(" ", $query);
		$result		= $this->listRecord($query);

		return $result;
	}

	public function deleteItem($arrParam)
	{
		$id = $arrParam['id'];
		$query = "DELETE FROM `cart` WHERE `id` = '$id'";
		$this->query($query);
	}

	public function statusItem($param)
	{
		$ids = implode(",", $param['cid']);
		$query = "UPDATE `cart` SET `status`= '" . $param['action'] . "' WHERE `id` IN ({$ids})";
		$this->query($query);
	}

	public function changeStatus($param, $option = null)
	{
		if ($option['task'] == 'change-status') {
			$status 		= ($param['status'] == 'active') ? 'inactive' : 'active';
			$id				= $param['id'];
			$query			= "UPDATE `cart` SET `status`= '$status' WHERE `id` = '$id'";
			$this->query($query);
			return  [
				'id' => $id,
				'status' => $status,
				'link' => URL::createLink($param['module'], $param['controller'], 'ajaxChangeStatus', ['status' => $status, 'id' => $id]),
				'removeClass' => $status == 'active' ? 'btn-danger' : 'btn-success',
				'addClass'	  => $status == 'active' ? 'btn-success' : 'btn-danger',
				'removeIcon'  => $status == 'active' ? 'fa-minus' : 'fa-check',
				'addIcon'     => $status == 'active' ? 'fa-check' : 'fa-minus',

			];
		}
	}


	public function countItem($arrParam, $option = null)
	{
		if ($option['task'] == 'count-item-by-status') {
			$query[] 	= "SELECT `status`, COUNT(*) AS `countStatus`";
			$query[] 	= "FROM `cart` ";

			//SEARCH
			if (!empty($arrParam['search'])) {
				$keyword = $arrParam['search'];
				$query[] = "WHERE `id` LIKE '%$keyword%'";
			}
			$query[] 	= "GROUP BY `status`";

			$query		= implode(" ", $query);
			$result		= $this->listRecord($query);
			$result     = array_combine(array_column($result, 'status'), array_column($result, 'countStatus'));
			$result 	= ['all' => array_sum($result)] + $result;
			return $result;
		}
	}



	public function infoItem($arrParam, $option = null)
	{
		if ($option == null) {
			$query[]	= "SELECT `id`, `username`, `password`, `email`, `fullname`, `group_id`, `status`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->singleRecord($query);
			return $result;
		}
	}






}
