<?php
class BookModel extends Model
{
	private $_columns = ['id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering'];
	private $_userInfo;

	public function __construct()
	{
		parent::__construct();
		$this->setTable('book');

		$userObj 		 = Session::get('userLogin');
		@$this->_userInfo = $userObj['info'];
	}

	public function listItem($arrParam, $option = null)
	{

		if ($option['task'] == 'book-in-category') {

			$catID 		= @$arrParam['category_id'];
			$query[] 	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`sale_off`, `b`.`price`,`b`.`category_id`,`c`.`name` AS `category_name`";
			$query[] 	= "FROM `{$this->table}` AS `b`, `category` AS `c` ";
			$query[]    = "WHERE `b`.`status` = 'active' AND `b`.`category_id` = `c`.`id` AND `b`.`category_id` = '$catID' AND `c`.`status` = 'active'";
			$query[] 	= "ORDER BY `b`.`ordering` ASC";

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

		if ($option['task'] == 'book-relate') {
			$bookID 	= $arrParam['book_id'];
			$catID 		= $arrParam['category_id'];
			$query[] 	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`sale_off`, `b`.`price`,`b`.`category_id`,`c`.`name` AS `category_name`";
			$query[] 	= "FROM `{$this->table}` AS `b`, `category` AS `c` ";
			$query[]    = "WHERE `b`.`status` = 'active' AND `b`.`category_id` = `c`.`id` AND `b`.`category_id` = '$catID' AND `b`.`id` <> '$bookID'";
			$query[] 	= "ORDER BY `b`.`ordering` ASC";
			$query[]	= "LIMIT 0,6";

			$query		= implode(" ", $query);
			$result		= $this->listRecord($query);
			return $result;
		}


		if ($option['task'] == 'book-news') {
			$bookID 	= $arrParam['book_id'];
			$query[] 	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`sale_off`, `b`.`price`,`b`.`category_id`,`c`.`name` AS `category_name`";
			$query[] 	= "FROM `{$this->table}` AS `b`, `category` AS `c` ";
			$query[]    = "WHERE `b`.`status` = 'active' AND `b`.`category_id` = `c`.`id` AND `b`.`id` <> '$bookID'";
			$query[] 	= "ORDER BY `b`.`id` DESC";
			$query[]	= "LIMIT 0,3";

			$query		= implode(" ", $query);
			$result		= $this->listRecord($query);
			return $result;
		}

		if ($option['task'] == 'book-special') {
			$query[] 	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`sale_off`, `b`.`price`,`b`.`category_id`,`c`.`name` AS `category_name`";
			$query[] 	= "FROM `{$this->table}` AS `b`, `category` AS `c` ";
			$query[]	= "WHERE `b`.`status` = 'active' AND `b`.`special` = 'yes' AND `b`.`category_id` = `c`.`id` ";
			$query[] 	= "ORDER BY `b`.`ordering` ASC";
			$query[] 	= "LIMIT 0,4";

			$query		= implode(" ", $query);
			$result		= $this->listRecord($query);
			return $result;
		}

		if ($option['task'] == 'book-list') {
			$query[] 	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`sale_off`, `b`.`price`,`b`.`category_id`,`c`.`name` AS `category_name`";
			$query[] = "FROM `category` AS `c`, `book` AS `b`";
			$query[] = "WHERE `b`.`status` = 'active' AND `b`.`category_id` = `c`.`id` AND `c`.`status` = 'active'";

			//$query[] = "ORDER BY `b`.`ordering` ASC";
			//$query[] 	= "LIMIT 0,4";

			//SEARCH
			if (!empty($arrParam['search'])) {
				$keyword = $arrParam['search'];
				$query[] = "AND `b`.`name` LIKE '%" . trim($keyword) . "%'";
			}

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
	}

	public function countItem($arrParam, $option = null)
	{
		if ($option['task'] == 'count-item-by-status') {
			$query[] 	= "SELECT `status`, COUNT(*) AS `countStatus`, `category_id`";
			$query[] 	= "FROM `{$this->table}` WHERE `id` > 0";

			@$catID = $arrParam['category_id'];
			if (isset($catID)) {
				$query[] = "AND `category_id` = '$catID.' ";
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

		if ($option['task'] == 'get-category-name') {
			$query[]	= "SELECT `name`";
			$query[]	= "FROM `category`";
			$query[]	= "WHERE `id` = '" . @$arrParam['category_id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->singleRecord($query);
			return @$result['name'];
		}

		if ($option['task'] == 'book-info') {
			$query[]	= "SELECT `b`.`id`, `b`.`name`, `b`.`description`,`b`.`price`,`b`.`ordering` , `b`.`special`, `b`.`sale_off`, `b`.`picture`, `b`.`status`, `b`.`category_id`,`c`.`name` AS `category_name`";
			$query[]	= "FROM `{$this->table}` AS `b`, `category` AS `c` ";
			$query[]	= "WHERE `b`.`id` > 0 AND `c`.`id` = `b`.`category_id` AND `b`.`id` = '" . $arrParam['book_id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->singleRecord($query);
			return $result;
		}
	}


	//SORT FORM
	public function sortForm($arrParam, $option = null)
	{
		if ($option['task'] == 'priceASC') {
			$catID 		= @$arrParam['category_id'];
			$query[] 	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`sale_off`, `b`.`price`,`b`.`category_id`,`c`.`name` AS `category_name`";
			$query[] 	= "FROM `category` AS `c`, `book` AS `b`";
			if (isset($catID)) {
				$query[] 	= "WHERE `b`.`status` = 'active' AND `b`.`category_id` = `c`.`id` AND `c`.`status` = 'active' AND `b`.`category_id` = '$catID'";
			} else {
				$query[] 	= "WHERE `b`.`status` = 'active' AND `b`.`category_id` = `c`.`id` AND `c`.`status` = 'active'";
			}

			$query[] 	= "ORDER BY `b`.`price` ASC";
		}

		if ($option['task'] == 'priceDESC') {
			$catID 		= @$arrParam['category_id'];
			$query[] 	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`sale_off`, `b`.`price`,`b`.`category_id`,`c`.`name` AS `category_name`";
			$query[] 	= "FROM `category` AS `c`, `book` AS `b`";
			if (isset($catID)) {
				$query[] 	= "WHERE `b`.`status` = 'active' AND `b`.`category_id` = `c`.`id` AND `c`.`status` = 'active' AND `b`.`category_id` = '$catID'";
			} else {
				$query[] 	= "WHERE `b`.`status` = 'active' AND `b`.`category_id` = `c`.`id` AND `c`.`status` = 'active' ";
			}

			$query[] 	= "ORDER BY `b`.`price` DESC";
		}

		if ($option['task'] == 'latest') {
			$catID 		= @$arrParam['category_id'];
			$query[] 	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`sale_off`, `b`.`price`,`b`.`category_id`,`c`.`name` AS `category_name`";
			$query[] 	= "FROM `category` AS `c`, `book` AS `b`";
			if (isset($catID)) {
				$query[] 	= "WHERE `b`.`status` = 'active' AND `b`.`category_id` = `c`.`id` AND `c`.`status` = 'active' AND `b`.`category_id` = '$catID'";
			} else {
				$query[] 	= "WHERE `b`.`status` = 'active' AND `b`.`category_id` = `c`.`id` AND `c`.`status` = 'active'";
			}
			$query[] 	= "ORDER BY `b`.`id` DESC";
		}

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
}
