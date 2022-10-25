<?php
class AccountModel extends Model{
	public function __construct(){
		parent::__construct();
		$this->setTable('user');
	}
	
	public function infoItem($arrParam){
		$username 	= @$arrParam['form']['username'];
		$password 	= (@$arrParam['form']['password']);
		$query[] 	= "SELECT `u`.`id`, `u`.`fullname`,`u`.`email`,`u`.`group_id`,`g`.`group_acp`";
		$query[] 	= "FROM `user` AS `u` LEFT JOIN `group` AS g ON `u`.`group_id` = `g`.`id`";
		$query[]	= "WHERE `username` = '$username' AND `password` = '$password'";
		

		$query		= implode(" ", $query);
		$result 	= $this->singleRecord($query);
		return $result;	
	}
	
	
}