<?php
class AccountController extends Controller
{
	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('login.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	//ACTION LOGIN
	public function loginAction()
	{

		if (@$this->_arrParam['form']['token'] > 0) {
			$username = $this->_arrParam['form']['username'];
			$password = $this->_arrParam['form']['password'];
			$validate = new Validate($this->_arrParam['form']);

			$query = "SELECT `id` FROM `user` WHERE `username` = '$username' AND `password` = '$password'";

			$validate->addRule('username', 'existRecord', ['database' => $this->_model, 'query' => $query])
				->addRule('password', 'existRecord', ['database' => $this->_model, 'query' =>  $query]);
			$validate->run();

			if ($validate->isValid() == true) {
				//Session::set('loggedIn', true);
				$infoUser = $this->_model->infoItem($this->_arrParam);
				$arraySession = [
					'login' => true,
					'info' => $infoUser,
					'time' => time(),
					'group_acp' => $infoUser['group_acp']

				];
				Session::set('user', $arraySession);
				URL::redirect(URL::createLink('backend', 'dashboard', 'index'));
			} else {
				$this->_view->errors = $validate->showErrorsBackend();
			}
		}

		$this->_view->setTitle('Login');
		$this->_view->render('account/login');
	}

	//ACTION LOGOUT
	public function logoutAction()
	{
		Session::unset('user');
		URL::redirect(URL::createLink('backend', 'account', 'login'));
	}
}
