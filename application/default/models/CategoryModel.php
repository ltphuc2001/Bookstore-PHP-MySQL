<?php
class CategoryModel extends Model
{
	private $_columns = ['id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering'];
	private $_userInfo;

	public function __construct()
	{
		parent::__construct();
		$this->setTable('category');
	}

	public function listItems($arrParam, $options = null)
	{
		$query[] 	= "SELECT `id`, `name`, `picture`";
		$query[] 	= "FROM `{$this->table}` WHERE `status` = 'active'";
		$query[] 	= "ORDER BY `ordering` ASC";

		// PAGINATION
		$pagination			= $arrParam['pagination'];
		$totalItemsPerPage	= $pagination['totalItemsPerPage'];
		if ($totalItemsPerPage > 0) {
			$position	= ($pagination['currentPage'] - 1) * $totalItemsPerPage;
			$query[]	= "LIMIT $position, $totalItemsPerPage";
		}

		$query				= implode(' ', $query);
		$arrlistBooks 		= $this->listRecord($query);

		// show total items per page
		$start				= ($position + 1);

		$end  				= $pagination['currentPage'] * $totalItemsPerPage;
		$totalBooks			= $this->countItem($arrParam, ['task' => 'count-item-by-status'])['active'];
		if ($end > $totalBooks) {
			$end = $totalBooks;
		}

		/**
		 * vd: thay vì vd: showing items 9 - 9 of 9 result 
		 * thì thay bằng : showing items 9 of 9 result 
		 */
		$rangeItems			= $start . ' - ' . $end;
		if ($start == $end) {
			$rangeItems		= $end;
		}
		$resultshowItems 	= 'Showing Items ' . $rangeItems . ' of ' . $totalBooks . ' Result ';

		$result = ['list' => $arrlistBooks, 'resultshowItems' => $resultshowItems];
		return $result;
	}

	public function countItem($arrParam, $option = null)
	{
		if ($option['task'] == 'count-item-by-status') {
			$query[] 	= "SELECT `status`, COUNT(*) AS `countStatus`";
			$query[] 	= "FROM `{$this->table}` WHERE `id` > 0";

			//SEARCH
			// if (!empty($arrParam['search'])) {
			// 	$keyword = $arrParam['search'];
			// 	$query[] = "AND `name` LIKE '%$keyword%'";
			// }
			$query[] 	= "GROUP BY `status`";

			$query		= implode(" ", $query);
			$result		= $this->listRecord($query);
			$result     = array_combine(array_column($result, 'status'), array_column($result, 'countStatus'));
			$result 	= ['all' => array_sum($result)] + $result;

			return $result;
		}
	}
}
