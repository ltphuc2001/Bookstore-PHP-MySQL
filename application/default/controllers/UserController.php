<?php
class UserController extends Controller
{

	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	//ACTION LOGIN
	public function loginAction()
	{
		$this->_view->setTitle('Đăng nhập');

		//die('Function die is called!');
		if (@$this->_arrParam['form']['token'] > 0) {
			$email = $this->_arrParam['form']['email'];
			$password = $this->_arrParam['form']['password'];
			$validate = new Validate($this->_arrParam['form']);


			$query = "SELECT `id` FROM `user` WHERE `email` = '$email' AND `password` = '$password'";

			$validate->addRule('email', 'existRecord', ['database' => $this->_model, 'query' => $query])
				->addRule('password', 'existRecord', ['database' => $this->_model, 'query' =>  $query]);
			$validate->run();


			if ($validate->isValid() == true) {
				//Session::set('loggedIn', true);
				$infoUser = $this->_model->infoItemLogin($this->_arrParam);
			
				$arraySession = [
					'login' => true,
					'info' => $infoUser,
					'time' => time(),
					'group_acp' => $infoUser['group_acp']

				];
				Session::set('userLogin', $arraySession);
				URL::redirect(URL::createLink('default', 'index', 'index', null, 'index.html'));
			} else {
				$this->_view->errors = $validate->showErrorsPublic();
			}
		}

		$this->_view->render('user/login');
	}

	//ACTION LOGOUT
	public function logoutAction()
	{

		Session::unset('userLogin');
		Session::unset('userRegister');
		Session::unset('cart');

		URL::redirect(URL::createLink('default', 'index', 'index', null, 'index.html'));
	}

	//ACTION CHANGE PASSWORD
	public function changePassAction()
	{
		$this->_view->setTitle('Thay đổi mật khẩu');
		Session::get('userLogin');

		if (@$this->_arrParam['form']['token'] > 0) {
			$passwordOld = $this->_arrParam['form']['password_old'];
			$validate = new Validate($this->_arrParam['form']);
			$query = "SELECT `id` FROM `user` WHERE `password` = '$passwordOld'";
			$validate->addRule('password_old', 'existRecord', ['database' => $this->_model, 'query' =>  $query]);
			$validate->run();
			if ($validate->isValid() == false) {
				$this->_view->errors = $validate->showErrorsPublic();
			} else {
				//Session::set('loggedIn', true);	
				$this->_model->saveItem($this->_arrParam, ['task' => 'save-pass']);
				$this->_view->render('user/successChangePass');
			}
		}


		$this->_view->render('user/changePassword');
	}

	//ACTION REGISTER
	public function registerAction()
	{
		$this->_view->setTitle('Đăng ký');
		Session::unset('userLogin');

		if (isset($this->_arrParam['form']['submit'])) {
			$queryUserName	= "SELECT `id` FROM `user` WHERE `username` = '" . $this->_arrParam['form']['username'] . "'";
			$queryEmail		= "SELECT `id` FROM `user` WHERE `email` = '" . $this->_arrParam['form']['email'] . "'";
			
			$validate = new Validate($this->_arrParam['form']);
			$validate->addRule('username', 'string-notExistRecord', ['database' => $this->_model, 'query' => $queryUserName, 'min' => 3, 'max' => 25])
				->addRule('email', 'notExistRecord', ['database' => $this->_model, 'query' => $queryEmail])
				->addRule('telephone', 'string', ['min' => 1, 'max' => 20])
				->addRule('address', 'string', ['min' => 3, 'max' => 250]);

			$validate->run();

			$this->_arrParam['form'] = $validate->getResult();
			if ($validate->isValid() == false) {
				$this->_view->errors = $validate->showErrorsPublic();
			} else {
				$this->_model->saveItem($this->_arrParam, ['task' => 'add']);
				$infoUser = $this->_model->infoItemLogin($this->_arrParam);
				$arraySessionLogin = [
					'login' => true,
					'info' => $infoUser,
					'time' => time(),
					'group_acp' => $infoUser['group_acp']

				];
				Session::set('userLogin', $arraySessionLogin);
				URL::redirect(URL::createLink('default', 'index', 'index', null, 'index.html'));
			}
		}

		$this->_view->render('user/register');
	}

	//ACTION ACCOUNT
	public function accountAction()
	{
		$this->_view->setTitle('Tài khoản');
		$this->_view->infoUser = $this->_model->infoUserLogin($this->_arrParam);
		$this->_view->render('user/account');
	}

	//ACTION HISTORY
	public function historyAction()
	{
		$this->_view->setTitle('Lịch sử mua hàng');
		$this->_view->items = $this->_model->listItem($this->_arrParam, ['task' => 'history-in-cart']);
		$this->_view->render('user/history');
	}

	//ACTION ORDER
	public function orderAction()
	{

		$cart = Session::get('cart');
		$bookId = $this->_arrParam['book_id'];

		$price 	= filter_var($this->_arrParam['price'], FILTER_SANITIZE_NUMBER_INT);

		$qty = $this->_arrParam['quantity'];


		$this->_view->items = $this->_model->listItem($this->_arrParam, ['task' => 'order-books-in-cart']);
		if (empty($cart)) {
			$cart['book_id'][$bookId] 	= $bookId;
			$cart['quantity'][$bookId] 	= $qty;
			$cart['price'][$bookId] 	= $price;
		} else {

			if (key_exists($bookId, $cart['quantity'])) {
				$cart['book_id'][$bookId] 		 = $bookId;


				$cart['quantity'][$bookId]  	 += $qty;

				$cart['price'][$bookId]			 = filter_var($price, FILTER_SANITIZE_NUMBER_INT);
			} else {
				$cart['book_id'][$bookId] 	= $bookId;
				$cart['quantity'][$bookId] 	= $qty;
				$cart['price'][$bookId] 	= $price;
			}
		}

		Session::set('cart', $cart);

		$totalOrder = 0;
		foreach ($cart['quantity'] as $key => $value) {
			$totalOrder += $value;
		}
		echo json_encode($totalOrder);
	}


	//ACTION CART
	public function cartAction()
	{
		$this->_view->setTitle('Giỏ hàng');
		$userObjRegister = Session::get('userRegister');
		$userLogin  	 = Session::get('userLogin');
		$cart 			 = Session::get('cart');


		if (isset($userLogin) || isset($userObjRegister)) {

			$this->_view->items = $this->_model->listItem($this->_arrParam, ['task' => 'books-in-cart']);
			$this->_view->render('user/cart');
		} else {
			URL::redirect(URL::createLink('default', 'user', 'login', null, 'login.html'));
		}
	}

	//ACTION AJAX UPDATE CART
	public function ajaxUpdateCartAction()
	{
		$cart 		= Session::get('cart');
		$bookId 	= $this->_arrParam['id'];
		$quantity 	= $this->_arrParam['quantity'];
		$cart['quantity'][$bookId] 	=  $quantity;
		Session::set('cart', $cart);
	}

	//ACTION BUY
	public function buyAction()
	{
		$cart 		= Session::get('cart');
		$this->_view->render('user/notifyBuy');
		Session::set('cart', $cart);
		$countProductCart = count($cart['quantity']);
		if ($countProductCart != 0) {
			$this->_model->saveItem($this->_arrParam, ['task' => 'submit-cart']);
		}
	}

	//ACTION DELETE ITEM
	public function deleteItemAction()
	{
		$cart 		= Session::get('cart');
		$book_Id 	= $this->_arrParam['book_id'];

		foreach ($cart as $key => $value) {
			unset($cart[$key][$book_Id]);
		}
		Session::set('cart', $cart);
		URL::redirect(URL::createLink('default', 'user', 'cart', null, 'cart.html'));
	}
}
