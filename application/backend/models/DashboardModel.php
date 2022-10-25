<?php
class DashBoardModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function listItemsGroup(){
		$query	 	= "SELECT COUNT(*) AS `countGroup` FROM `group`";
		$result		= $this->singleRecord($query);
		return $result;
	}

	public function listItemsUser(){
		$query	 	= "SELECT COUNT(*) AS `countUser` FROM `user`";
		$result		= $this->singleRecord($query);
		return $result;
	}

	public function listItemCategory(){
		$query	 	= "SELECT COUNT(*) AS `countCategory` FROM `category`";
		$result		= $this->singleRecord($query);
		return $result;
	}

	public function listItemBook(){
		$query	 	= "SELECT COUNT(*) AS `countBook` FROM `book`";
		$result		= $this->singleRecord($query);
		return $result;
	}

	public function listItemCart(){
		$query	 	= "SELECT COUNT(*) AS `countCart` FROM `cart`";
		$result		= $this->singleRecord($query);
		return $result;
	}

}
