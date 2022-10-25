<?php
class UserModel extends Model
{
	private $_columns = ['id', 'username', 'email', 'fullname', 'password', 'telephone', 'address', 'created', 'created_by', 'modified', 'modified_by', 'status', 'group_id'];

	public function __construct()
	{
		parent::__construct();
		$this->setTable('user');
	}

	public function listItems($arrParam, $options = null)
	{
		$query[] 	= "SELECT `u`.`id`, `u`.`username`, `u`.`email`, `u`.`fullname`, `u`.`password`, `u`.`telephone` , `u`.`address`  , `u`.`created`, `u`.`created_by`, `u`.`status`, `g`.`id` AS `group_id` , `g`.`name` AS `group_name`";
		$query[] 	= "FROM `{$this->table}` AS `u`, `group` AS `g` WHERE `u`.`id` > 0 AND `g`.`id` = `u`.`group_id`";

		//FILTER BY STATUS	

		if (!empty($arrParam['status']) && $arrParam['status'] != 'all') {
			$statusValue = $arrParam['status'];
			$query[] = "AND `u`.`status` = '$statusValue'";
		}

		//FILTER BY GROUP NAME
		if (!empty($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default') {
			$statusGroupName = $arrParam['filter_group_id'];
			$query[] = "AND `name` = '$statusGroupName'";
		}

		//SEARCH
		if (!empty($arrParam['search'])) {
			$keyword = $arrParam['search'];
			$query[] = "AND `u`.`username` LIKE '%$keyword%'";
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
		if ($arrParam['checkbox']) {
			$ids = $arrParam['checkbox'];
		} else {
			$ids = [$arrParam['id']];
		}
		$this->delete($ids);
	}

	public function statusItem($param)
	{
		$ids = implode(",", $param['cid']);
		$query = "UPDATE `user` SET `status`= '" . $param['action'] . "' WHERE `id` IN ({$ids})";
		$this->query($query);
	}

	public function changeStatus($param, $option = null)
	{
		if ($option['task'] == 'change-status') {
			$status 		= ($param['status'] == 'active') ? 'inactive' : 'active';
			$id		= $param['id'];
			$query	= "UPDATE `user` SET `status`= '$status' WHERE `id` = '$id'";
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

		if ($option['task'] == 'change-ajax-group-acp') {
			$group_acp 		= ($param['status'] == 'yes') ? 'no' : 'yes';
			$id				= $param['id'];
			$query			= "UPDATE `group` SET `group_acp`= '$group_acp' WHERE `id` = '$id'";
			$this->query($query);
			return  [
				'id' => $id,
				'group_acp' => $group_acp,
				'link' => URL::createLink($param['module'], $param['controller'], 'ajaxChangeStatus', ['group_acp' => $group_acp, 'id' => $id]),
				'removeClass' => $group_acp == 'active' ? 'btn-danger' : 'btn-success',
				'addClass'	  => $group_acp == 'active' ? 'btn-success' : 'btn-danger',
				'removeIcon'  => $group_acp == 'active' ? 'fa-minus' : 'fa-check',
				'addIcon'     => $group_acp == 'active' ? 'fa-check' : 'fa-minus',

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
				$query[] = "AND `username` LIKE '%$keyword%'";
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

	public function infoItem($arrParam)
	{

		$user 		= @$arrParam['form']['user'];
		$password 	= (@$arrParam['form']['password']);
		$query[] 	= "SELECT `u`.`id`, `u`.`username`,`u`.`email`, `u`.`password`, `u`.`fullname` ,`u`.`telephone` ,`u`.`address`,`u`.`group_id`,`g`.`group_acp`";
		$query[] 	= "FROM `user` AS `u` LEFT JOIN `group` AS `g` ON `u`.`group_id` = `g`.`id`";
		$query[]	= "WHERE `user` = '$user' AND `password` = '$password'";


		$query		= implode(" ", $query);
	
		$result 	= $this->singleRecord($query);
		return $result;
	}



	public function infoGroupName()
	{

		$query[]	= "SELECT `id`, `name`";
		$query[]	= "FROM `group`";
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

		if ($options['task'] == 'savePass') {
			$id = $params['form']['id'];
			$password = $params['form']['password'];
			$query = "UPDATE `$this->table` SET `password`= '$password' WHERE `id` = '$id'";
			$this->query($query);
			Session::set('message', 'Thay đổi mật khẩu thành công!');
		}
	}



	public function changeGroupID($param)
	{
		$id = $param['id'];
		$newGroupID =  $param['group_id'];
		$query = "UPDATE `$this->table` SET `group_id`= '$newGroupID' WHERE `id` = '$id'";
		$this->query($query);
	}



	// public function changeGroupACP($param)
	// {
	// 	$id = $param['id'];
	// 	$newGroupACP = ($param['group_acp'] == 'active') ? 'inactive' : 'active';
	// 	$query = "UPDATE `group` SET `group_acp`= '$newGroupACP' WHERE `id` = '$id'";
	// 	$this->query($query);
	// }

}
