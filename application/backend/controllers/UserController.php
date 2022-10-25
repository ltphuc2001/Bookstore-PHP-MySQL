<?php
class UserController extends Controller
{

	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	//ACTION: LIST USER
	public function indexAction()
	{
		$this->_view->setTitle('User: List');

		$countStatusItems = $this->_model->countItem($this->_arrParam, ['task' => 'count-item-by-status']);
		$totalItems		  = $countStatusItems[$this->_arrParam['status'] ?? 'all'];
		$this->_view->countStatusItems = $countStatusItems;
		$configPagination = ['totalItemsPerPage'	=> 5, 'pageRange' => 3];
		$this->setPagination($configPagination);
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);

		$this->_view->groupName 	= $this->_model->infoGroupName();
		$this->_view->items = $this->_model->listItems($this->_arrParam, null);


		$this->_view->render('user/index');
	}

	//ACTION: UPDATE GROUP NAME
	public function updateGroupNameAction()
	{
	}

	//ACTION: ChangePassword
	public function changePasswordAction()
	{
		if (@$this->_arrParam['form']['token']) {

			$validate = new Validate($this->_arrParam['form']);
			$validate->addRule('password', 'string', ['min' => 5, 'max' => 12]);
			$validate->run();

			$this->_arrParam['form'] = $validate->getResult();
			if (!$validate->isValid()) {
				$this->_view->errors = $validate->showErrorsBackend();
			} else {
				$this->_model->saveItem($this->_arrParam, ['task' => 'savePass']);
				URL::redirect(URL::createLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index'));
			}
		} else {
			$item = $this->_model->infoItem($this->_arrParam);
			$this->_arrParam['form'] = $item;
		}

		$this->_view->arrParams = $this->_arrParam;
		$this->_view->render('user/changePassword');
	}


	//ACTION: AJAX STATUS
	public function ajaxChangeStatusAction()
	{
		$result = $this->_model->changeStatus($this->_arrParam, ['task' => 'change-status']);
		echo json_encode($result);
	}

	//ACTION: AJAX GROUP ACP
	public function ajaxACPAction()
	{
		$result = $this->_model->changeStatus($this->_arrParam, ['task' => 'change-ajax-group-acp']);
		echo json_encode($result);
	}

	//ACTION: DELETE
	public function deleteAction()
	{

		$this->_model->deleteItem($this->_arrParam);
		$this->redirect('backend', 'user', 'index');
	}

	//ACTION: ACTIVE MULTI ITEMS
	public function activeAction()
	{
		$this->_model->statusItem($this->_arrParam);
		$this->redirect('backend', 'user', 'index');
	}

	//ACTION: INACTIVE MULTI ITEMS
	public function inactiveAction()
	{
		$this->_model->statusItem($this->_arrParam);
		$this->redirect('backend', 'user', 'index');
	}

	//ACTION FORM
	public function formAction()
	{
		$this->_view->setTitle('User :: Add');
		$this->_view->groupName 	= $this->_model->infoGroupName();

		if (@$this->_arrParam['id'] && !@$this->_arrParam['form']['token']) {
			$this->_view->setTitle('User :: Edit');
			$item = $this->_model->infoItem($this->_arrParam);

			if (empty($item)) URL::redirect(URL::createLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index'));
			$this->_arrParam['form'] = $item;
		}

		if (@$this->_arrParam['form']['token']) {
			$validate = new Validate($this->_arrParam['form']);
			$validate->addRule('username', 'string', ['min' => 3, 'max' => 50])
				->addRule('email', 'string', ['min' => 3, 'max' => 250])
				->addRule('fullname', 'string', ['min' => 3, 'max' => 250])
				->addRule('password', 'password', ['min' => 3, 'max' => 50])
				->addRule('telephone', 'string', ['min' => 1, 'max' => 20])
				->addRule('address', 'string', ['min' => 3, 'max' => 250])
				->addRule('group_id', 'select', ['deny' => 'default'])
				->addRule('status', 'select', ['deny' => 'default']);
			$validate->run();

			$this->_arrParam['form'] = $validate->getResult();
			if (!$validate->isValid()) {
				$this->_view->errors = $validate->showErrorsBackend();
			} else {
				$task = @$this->_arrParam['id'] ? 'edit' : 'add';
				$this->_model->saveItem($this->_arrParam, ['task' => $task]);
				URL::redirect(URL::createLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index'));
			}
		}

		$this->_view->arrParams = $this->_arrParam;
		$this->_view->render("{$this->_arrParam['controller']}/form");
	}


	public function changeGroupIDAction()
	{
		$this->_model->changeGroupID($this->_arrParam);
		$this->redirect('backend', 'user', 'index');
	}
}
