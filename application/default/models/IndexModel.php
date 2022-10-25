<?php
class IndexModel extends Model
{
	private $_columns = ['id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering'];
	private $_userInfo;

	public function __construct()
	{
		parent::__construct();
		$this->setTable('book');
	}

	public function listItem($arrParam, $option = null)
	{
		if ($option['task'] == 'book-special') {
			$query[] 	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`sale_off`, `b`.`price`,`b`.`category_id`,`c`.`name` AS `category_name`";
			$query[] 	= "FROM `{$this->table}` AS `b`, `category` AS `c` ";
			$query[]	= "WHERE `b`.`status` = 'active' AND `b`.`special` = 'yes' AND `c`.`id`= `b`.`category_id` ";
			$query[] 	= "ORDER BY `c`.`ordering` ASC";
			$query[] 	= "LIMIT 0,4";
		}

		if ($option['task'] == 'book-in-category') {
			$catID 		= @$arrParam['category_id'];
			$query[] 	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`description`, `b`.`sale_off`, `b`.`price`,`b`.`category_id`,`c`.`name` AS `category_name`";
			$query[] 	= "FROM `{$this->table}` AS `b`, `category` AS `c` ";
			$query[] 	= "WHERE `b`.`status` = 'active' AND `c`.`status` = 'active' AND `b`.`category_id` = '$catID'";
			$query[] 	= "ORDER BY `b`.`ordering` ASC";
		}

		if ($option['task'] == 'category') {
			$query[] 	= "SELECT `id`, `name`, `ordering`, `status`";
			$query[] 	= "FROM `category` WHERE `status` = 'active'";
		}


		$query		= implode(" ", $query);
		$result		= $this->listRecord($query);

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

	public function infoItem($arrParam, $option = null)
	{

		if ($option['task'] == 'get-category-name') {
			$query[]	= "SELECT `name`";
			$query[]	= "FROM `category`";
			$query[]	= "WHERE `id` = '" . $arrParam['category_id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->singleRecord($query);
			return $result['name'];
		}
	}
}
