<?php
class UserModel extends Model
{
	private $_columns = ['id', 'username', 'email', 'fullname', 'telephone', 'address' ,'password', 'created', 'created_by', 'modified', 'modified_by', 'status', 'group_id'];
	private $_userInfo;

	public function __construct()
	{
		parent::__construct();
		$this->setTable('user');

		@$userObj 		 = Session::get('userLogin');
		$this->_userInfo = @$userObj['info'];
	}

	public function listItem($arrParam, $option = null)
	{
		if ($option['task'] == 'books-in-cart') {

			@$cart 		= Session::get('cart');

			if (!empty($cart)) {
				$ids = "";
				foreach ($cart['quantity'] as $key => $value) {
					$ids .= "'$key', ";
				}
				$ids .= " '0' ";

				$query[] 	= "SELECT `id`, `name`, `picture`";
				$query[] 	= "FROM `book`";
				$query[]	= "WHERE `status` = 'active' AND `id` IN ({$ids}) ";
				$query[] 	= "ORDER BY `ordering` ASC";

				$query		= implode(" ", $query);
				$result		= $this->listRecord($query);

				foreach ($result as $key => $value) {
					//$result[$key]['book_id'] 		= $result[$key]['id'];
					$result[$key]['quantity'] 		= $cart['quantity'][$value['id']];
					$result[$key]['totalprice'] 	= $cart['price'][$value['id']];
					//$result[$key]['price'] 		= $result[$key]['totalprice'] / $result[$key]['quantity'];
					$result[$key]['price'] 			= $cart['price'][$value['id']];
				}
			} else {
				$result = 0;
			}

			return $result;
		}


		if ($option['task'] == 'history-in-cart') {
			$username = $this->_userInfo['username'];

			$query[] 	= "SELECT `id`, `username`, `books`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`";
			$query[] 	= "FROM `cart`";
			$query[]	= "WHERE `username` = '$username' ";
			$query[]	= "AND `status` = 'active' ";
			$query[] 	= "ORDER BY `date` ASC";

			$query		= implode(" ", $query);
			$result		= $this->listRecord($query);

			return $result;
		}
	}


	public function infoItemLogin($arrParam)
	{
		$email 		= @$arrParam['form']['email'];
		$password 	= (@$arrParam['form']['password']);
		$query[] 	= "SELECT `u`.`id`, `u`.`username`,`u`.`email`, `u`.`password`, `u`.`fullname` ,`u`.`telephone` ,`u`.`address`,`u`.`group_id`,`g`.`group_acp`";
		$query[] 	= "FROM `user` AS `u` LEFT JOIN `group` AS `g` ON `u`.`group_id` = `g`.`id`";
		$query[]	= "WHERE `email` = '$email' AND `password` = '$password'";


		$query		= implode(" ", $query);
		$result 	= $this->singleRecord($query);
		return $result;
	}

	public function infoUserLogin()
	{

		$query[] 	= "SELECT `id`, `username`, `email`, `fullname`, `telephone`, `address` , `password`";
		$query[] 	= "FROM `user`";
		$query		= implode(" ", $query);
		$result 	= $this->singleRecord($query);
		return $result;
	}

	public function changeQuantity($arrParam)
	{
		$cart = Session::get('cart');
		$bookId = $arrParam['id'];
		$quantity =  json_decode($arrParam['quantity']);
		$cart['quantity'][$bookId] 	=  $arrParam['quantity'];
	}





	public function saveItem($arrParam, $options = null)
	{
		if ($options['task'] == 'add') {
			$arrParam['form']['created'] = date('Y-m-d H:i:s', time());
			$arrParam['form']['created_by'] = 'admin';

			$data = array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->insert($data);
		}

		if ($options['task'] == 'save-pass') {
			$userLogin = Session::get('userLogin');
			$id = $userLogin['info']['id'];
			$password = $arrParam['form']['password_new'];
			$query = "UPDATE `user` SET `password`= '$password' WHERE `id` = '$id'";
			$this->query($query);
		}



		if ($options['task'] == 'submit-cart') {
			$id = $this->randomString(8);
			$username = $this->_userInfo['username'];
			$books = json_encode($arrParam['form']['book_id']);
			$prices = json_encode($arrParam['form']['price']);
			$quantities = json_encode($arrParam['form']['quantity']);
			$pictures = json_encode($arrParam['form']['picture']);
			$names = json_encode($arrParam['form']['name']);
			$date	= date('Y-m-d H:i:s', time());

			$query = "INSERT INTO `cart`(`id`, `username`, `books`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`)
					VALUES ('$id', '$username','$books', '$prices', '$quantities', '$names', '$pictures', 'active' ,'$date' )";
			$this->query($query);

			Session::unset('cart');
		}
	}

	private function randomString($length = 5)
	{
		$arrCharacter = array_merge(range('a', 'z'), range(0, 9), range('A', 'Z'));
		$arrCharacter = implode('', $arrCharacter);
		$arrCharacter = str_shuffle($arrCharacter);

		$result = substr($arrCharacter, 0, $length);
		return $result;
	}
}
