<?php
class GroupModel extends Model
{
	private $_columns = ['id', 'name', 'group_acp', 'created', 'created_by', 'modified', 'modified_by', 'status'];
	private $_userInfo;

	public function __construct()
	{
		parent::__construct();
		$this->setTable('group');
	}

	public function listItems($arrParam, $options = null)
	{
		$query[] 	= "SELECT `id`, `name`, `group_acp`, `created`, `created_by`, `modified`, `modified_by`, `status`";
		$query[] 	= "FROM `{$this->table}` WHERE `id` > 0";

		//FILTER BY STATUS	

		if (!empty($arrParam['status']) && $arrParam['status'] != 'all') {
			$statusValue = $arrParam['status'];
			$query[] = "AND `status` = '$statusValue'";
		}

		//FILTER BY GROUP_ACP
		if (!empty($arrParam['filter_group_acp']) && $arrParam['filter_group_acp'] != 'default') {
			$statusGroupACPValue = $arrParam['filter_group_acp'];
			$query[] = "AND `group_acp` = '$statusGroupACPValue'";
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
		}
		$query 	= "DELETE FROM `group` WHERE `id` IN ({$ids})";
		$this->query($query);
	}

	public function statusItem($param)
	{
		$ids = implode(",", $param['cid']);
		$query = "UPDATE `group` SET `status`= '" . $param['action'] . "' WHERE `id` IN ({$ids})";
		$this->query($query);
	}

	public function changeStatus($param, $option = null)
	{
		if ($option['task'] == 'change-status') {
			$status 		= ($param['status'] == 'active') ? 'inactive' : 'active';
			$id		= $param['id'];
			$query	= "UPDATE `group` SET `status`= '$status' WHERE `id` = '$id'";
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

		if ($option['task'] == 'change-group-acp') {
			$group_acp 		= ($param['group_acp'] == 'yes') ? 'no' : 'yes';
			$id				= $param['id'];
			$query			= "UPDATE `group` SET `group_acp`= '$group_acp' WHERE `id` = '$id'";
			$this->query($query);

			return  [
				'id' => $id,
				'group_acp' => $group_acp,
				'link' => URL::createLink($param['module'], $param['controller'], 'ajaxACP', ['group_acp' => $group_acp, 'id' => $id]),
				'removeClass' => $group_acp == 'yes' ? 'btn-danger' : 'btn-success',
				'addClass'	  => $group_acp == 'yes' ? 'btn-success' : 'btn-danger',
				'removeIcon'  => $group_acp == 'yes' ? 'fa-minus' : 'fa-check',
				'addIcon'     => $group_acp == 'yes' ? 'fa-check' : 'fa-minus',

			];
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

	public function addItem($outValidate)
	{
		$this->insert($outValidate);
	}

	public function infoItem($arrParam, $option = null)
	{
		if ($option == null) {
			$query[]	= "SELECT `id`, `name`, `group_acp`, `status`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->singleRecord($query);
			return $result;
		}
	}

	public function infoGroupName()
	{

		$query[]	= "SELECT `id`, `name`";
		$query[]	= "FROM `$this->table`";
		$query		= implode(" ", $query);
		$result		= array_column($this->listRecord($query), 'name', 'id');
		return $result;
	}

	public function saveItem($params, $options = null)
	{
		if ($options['task'] == 'add') {
			$params['form']['created'] = date('Y-m-d H:i:s', time());
			$params['form']['created_by'] = 'admin';

			$data = array_intersect_key($params['form'], array_flip($this->_columns));
			$this->insert($data);
			Session::set('message', 'Thêm mới dữ liệu thành công!');
		}

		if ($options['task'] == 'edit') {
			$params['form']['modified'] = date('Y-m-d H:i:s', time());
			$params['form']['modified_by'] = 'admin';

			$data = array_intersect_key($params['form'], array_flip($this->_columns));
			$this->update($data, [['id', $params['id']]]);
			Session::set('message', 'Cập nhật dữ liệu thành công!');
		}
	}
}
