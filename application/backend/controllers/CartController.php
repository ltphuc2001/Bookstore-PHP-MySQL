<?php
class CartController extends Controller
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
		$this->_view->setTitle('Cart');

		$countStatusItems = $this->_model->countItem($this->_arrParam, ['task' => 'count-item-by-status']);
		$totalItems		  = $countStatusItems[$this->_arrParam['status'] ?? 'all'];
		$this->_view->countStatusItems = $countStatusItems;
		$configPagination = ['totalItemsPerPage'	=> 5, 'pageRange' => 3];
		$this->setPagination($configPagination);
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);


		// $this->_view->groupName 	= $this->_model->infoGroupName();
		$this->_view->items = $this->_model->listItems($this->_arrParam, null);


		$this->_view->render('cart/index');
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


	//ACTION: DELETE
	public function deleteAction()
	{
		$this->_model->deleteItem($this->_arrParam);
		$this->redirect('backend', 'cart', 'index');
	}
}
