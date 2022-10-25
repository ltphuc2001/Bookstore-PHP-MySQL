<?php
class BookModel extends Model
{
	private $_columns = ['id', 'name', 'description', 'price', 'special', 'sale_off', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'category_id'];
	private $_userInfo;

	public function __construct()
	{
		parent::__construct();
		$this->setTable('book');
	}

	public function listItems($arrParam, $options = null)
	{
		$query[] 	= "SELECT `b`.`id`, `b`.`name`, `b`.`description`,`b`.`price`,`b`.`ordering` , `b`.`special`, `b`.`sale_off`, `b`.`picture`, `b`.`created`, `b`.`created_by`, `b`.`status`, `b`.`modified`,`b`.`modified_by`,`b`.`category_id`, `c`.`name` AS `category_name`";
		$query[] 	= "FROM `{$this->table}` AS `b`, `category` AS `c` WHERE `b`.`id` > 0 AND `c`.`id` = `b`.`category_id`";



		//FILTER BY STATUS	

		if (!empty($arrParam['status']) && $arrParam['status'] != 'all') {
			$statusValue = $arrParam['status'];
			$query[] = "AND `b`.`status` = '$statusValue'";
		}

		//FILTER BY CATEGORY_ID
		if (!empty($arrParam['filter_category']) && $arrParam['filter_category'] != 'default') {
			$statusCategoryID = $arrParam['filter_category'];
			$query[] = "AND `b`.`category_id` = '$statusCategoryID'";
		}

		//FILTER BY SPECIAL
		if (!empty($arrParam['filter_special']) && $arrParam['filter_special'] != 'default') {
			$statusSpecial = $arrParam['filter_special'];
			$query[] = "AND `b`.`special` = '$statusSpecial'";
		}

		//SEARCH
		if (!empty($arrParam['search'])) {
			$keyword = $arrParam['search'];
			$query[] = "AND `b`.`name` LIKE '%$keyword%'";
		}

		//PAGINATION
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

	//ORDERING ITEM
	public function orderingItem($arrParam)
	{
		$id 	  = $arrParam['id'];
		$ordering = $arrParam['ordering'];

		if (!empty($ordering)) {
			$query	= "UPDATE `$this->table` SET `ordering` = $ordering  WHERE `id` = '" . $id . "'";
			$this->query($query);
			Session::set('message', 'Cập nhật ordering thành công!');
		}
	}

	//DELETE ITEM
	public function deleteItem($arrParam)
	{
		if (isset($arrParam['id'])) {
			$ids = $arrParam['id'];
		} else {
			$ids 	= implode(",", $arrParam['cid']);
		}
		$query 	= "DELETE FROM `book` WHERE `id` IN ({$ids})";
		$this->query($query);
		Session::set('message', 'Xoá dữ liệu thành công!');
	}

	//STATUS ITEM	
	public function statusItem($param)
	{
		$ids = implode(",", $param['cid']);
		$query = "UPDATE `book` SET `status`= '" . $param['action'] . "' WHERE `id` IN ({$ids})";
		$this->query($query);
	}

	//CHANGE STATUS
	public function changeStatus($param, $option = null)
	{
		if ($option['task'] == 'change-status') {
			$status 		= ($param['status'] == 'active') ? 'inactive' : 'active';
			$id				= $param['id'];
			$query			= "UPDATE `book` SET `status`= '$status' WHERE `id` = '$id'";
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

		if ($option['task'] == 'change-special') {
			$special 		= ($param['special'] == 'yes') ? 'no' : 'yes';
			$id				= $param['id'];
			$query			= "UPDATE `book` SET `special`= '$special' WHERE `id` = '$id'";

			$this->query($query);
			return  [
				'id' => $id,
				'special' => $special,
				'link' => URL::createLink($param['module'], $param['controller'], 'ajaxChangeSpecial', ['special' => $special, 'id' => $id]),
				'removeClass' => $special == 'yes' ? 'btn-danger' : 'btn-success',
				'addClass'	  => $special == 'yes' ? 'btn-success' : 'btn-danger',
				'removeIcon'  => $special == 'yes' ? 'fa-minus' : 'fa-check',
				'addIcon'     => $special == 'yes' ? 'fa-check' : 'fa-minus',

			];
		}
	}

	//CHANGE ORDERING
	public function changeOrdering($param)
	{
		$ordering 		= $param['ordering'];
		$id				= $param['id'];
		$query			= "UPDATE `book` SET `ordering`= '$ordering' WHERE `id` = '$id'";
		$this->query($query);
		return  [
			'id' => $id,
			'ordering' => $ordering,
			'link' => URL::createLink($param['module'], $param['controller'], 'ajaxChangeOrdering', ['ordering' => $ordering, 'id' => $id]),
		];
	}


	//COUNT ITEM
	public function countItem($arrParam, $option = null)
	{
		if ($option['task'] == 'count-item-by-status') {
			$query[] 	= "SELECT `status`, COUNT(*) AS `countStatus`";
			$query[] 	= "FROM `{$this->table}` WHERE `id` > 0";

			//SEARCH
			if (!empty($arrParam['search'])) {
				$keyword = $arrParam['search'];
				$query[] = "AND `name` LIKE '%$keyword%'";
			}


			$query[] 	= "GROUP BY `status`";

			$query		= implode(" ", $query);
			$result		= $this->listRecord($query);
			$result     = array_combine(array_column($result, 'status'), array_column($result, 'countStatus'));
			$result 	= ['all' => array_sum($result)] + $result;
			return $result;
		}

		if ($option['task'] == 'count-item-by-status-ListBook') {

			$catID 		= @$arrParam['filter_category'];
			$query[] 	= "SELECT `b`.`status`, COUNT(`b`.`id`) AS `countStatus`";
			$query[] 	= "FROM `{$this->table}` AS `b`, `category` AS `c` ";
			$query[]	= "WHERE `c`.`id` = `b`.`category_id`";
			$query[]	= "AND `b`.`category_id` = '$catID'";
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
			$query[]	= "SELECT `id`,`name` ,`description`, `price`, `sale_off`, `picture`, `ordering`, `status`, `special`,`category_id`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->singleRecord($query);
			return $result;
		}
	}

	public function infoCategory()
	{

		$query[]	= "SELECT `id`, `name`";
		$query[]	= "FROM `category`";
		$query		= implode(" ", $query);
		$result		= array_column($this->listRecord($query), 'name', 'id');
		return $result;
	}

	public function changeCategoryID($param)
	{
		$id = $param['id'];
		$newCategoryID =  $param['category_id'];
		$query = "UPDATE `$this->table` SET `category_id`= '$newCategoryID' WHERE `id` = '$id'";
		$this->query($query);
	}



	public function saveItem($params, $options = null)
	{
		require_once LIBRARY_EXT_PATH . 'Upload.php';
		$uploadObj = new Upload();

		if ($options['task'] == 'add') {
			$params['form']['picture'] = $uploadObj->uploadFile($params['form']['picture'], 'book');
			$params['form']['created'] = date('Y-m-d H:i:s', time());
			$params['form']['created_by'] = 'admin';


			$data = array_intersect_key($params['form'], array_flip($this->_columns));
			$this->insert($data);
			Session::set('message', 'Thêm mới dữ liệu thành công!');
		}

		if ($options['task'] == 'edit') {
			if ($params['form']['picture']['name'] == null) {
				unset($params['form']['picture']);
			} else {
				$params['form']['picture'] = $uploadObj->uploadFile($params['form']['picture'], 'book');
			}
			$params['form']['modified'] = date('Y-m-d H:i:s', time());
			$params['form']['modified_by'] = 'admin';

			$data = array_intersect_key($params['form'], array_flip($this->_columns));
			$this->update($data, [['id', $params['id']]]);
			Session::set('message', 'Cập nhật dữ liệu thành công!');
		}
	}
}
