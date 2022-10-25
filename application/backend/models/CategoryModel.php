<?php
class CategoryModel extends Model
{
	private $_columns = ['id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'showHome'];
	private $_userInfo;

	public function __construct()
	{
		parent::__construct();
		$this->setTable('category');
	}

	public function listItems($arrParam, $options = null)
	{
		$query[] 	= "SELECT `id`, `name`, `picture`, `created`, `created_by`, `modified`, `modified_by`, `status`, `showHome` ,`ordering`";
		$query[] 	= "FROM `{$this->table}` WHERE `id` > 0";

		//FILTER BY STATUS	

		if (!empty($arrParam['status']) && $arrParam['status'] != 'all') {
			$statusValue = $arrParam['status'];
			$query[] = "AND `status` = '$statusValue'";
		}


		//SEARCH
		if (!empty($arrParam['search'])) {
			$keyword = $arrParam['search'];
			$query[] = "AND `name` LIKE '%$keyword%'";
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
		if (isset($arrParam['id'])) {
			$ids = $arrParam['id'];
		} else {

			$ids 	= implode(",", $arrParam['cid']);

			$query = "SELECT `id`, `picture` AS `name` FROM `category` WHERE `id` IN ({$ids})";
			$arrImg = $this->listRecord($query);
			require_once LIBRARY_EXT_PATH . 'Upload.php';
			$uploadObj = new Upload();
			foreach ($arrImg as $value) {
				$uploadObj->removeFile('category', $value);
				$uploadObj->removeFile('category', '60x90' . $value);
			}
		}
		$query 	= "DELETE FROM `category` WHERE `id` IN ({$ids})";
		$this->query($query);
		Session::set('message', 'Xoá dữ liệu thành công!');
	}

	public function statusItem($param)
	{

		$ids = implode(",", $param['cid']);
		$query = "UPDATE `category` SET `status`= '" . $param['action'] . "' WHERE `id` IN ({$ids})";
		$this->query($query);
	}

	public function changeStatus($param, $option = null)
	{
		if ($option['task'] == 'change-status') {
			$status 		= ($param['status'] == 'active') ? 'inactive' : 'active';
			$id				= $param['id'];
			$query			= "UPDATE `category` SET `status`= '$status' WHERE `id` = '$id'";
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

		if ($option['task'] == 'change-showHome') {
			$showHome 		= ($param['showHome'] == 'active') ? 'inactive' : 'active';
			$id				= $param['id'];
			$query			= "UPDATE `category` SET `showHome`= '$showHome' WHERE `id` = '$id'";
			$this->query($query);
			return  [
				'id' => $id,
				'status' => $showHome,
				'link' => URL::createLink($param['module'], $param['controller'], 'ajaxChangeStatus', ['showhome' => $showHome, 'id' => $id]),
				'removeClass' => $showHome == 'active' ? 'btn-danger' : 'btn-success',
				'addClass'	  => $showHome == 'active' ? 'btn-success' : 'btn-danger',
				'removeIcon'  => $showHome == 'active' ? 'fa-minus' : 'fa-check',
				'addIcon'     => $showHome == 'active' ? 'fa-check' : 'fa-minus',

			];
		}
	}
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
	}



	public function infoItem($arrParam, $option = null)
	{
		if ($option == null) {
			$query[]	= "SELECT `id`,`name` ,`picture`, `ordering`, `status`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->singleRecord($query);
			return $result;
		}
	}





	public function saveItem($params, $options = null)
	{
		require_once LIBRARY_EXT_PATH . 'Upload.php';
		$uploadObj = new Upload();

		if ($options['task'] == 'add') {

			$params['form']['picture'] = $uploadObj->uploadFile($params['form']['picture'], 'category');
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
				$params['form']['picture'] = $uploadObj->uploadFile($params['form']['picture'], 'category');
			}
			$params['form']['modified'] = date('Y-m-d H:i:s', time());
			$params['form']['modified_by'] = 'admin';

			$data = array_intersect_key($params['form'], array_flip($this->_columns));
			$this->update($data, [['id', $params['id']]]);
			Session::set('message', 'Cập nhật dữ liệu thành công!');
		}
	}
}
