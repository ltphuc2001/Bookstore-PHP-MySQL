<?php
class BookController extends Controller
{

	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	//ACTION: LIST BOOK
	public function indexAction()
	{
		$this->_view->setTitle('Book :: List');
		if(@$this->_arrParam['filter_category'] == 0 ){
			$countStatusItems = $this->_model->countItem($this->_arrParam, ['task' => 'count-item-by-status']);
		}else if($this->_arrParam['filter_category'] != 0 ) {
			$countStatusItems = $this->_model->countItem($this->_arrParam, ['task' => 'count-item-by-status-ListBook']);
		}

		$totalItems		  = $countStatusItems[$this->_arrParam['status'] ?? 'all'];
		$this->_view->countStatusItems = $countStatusItems;
		$configPagination = ['totalItemsPerPage'	=> 5, 'pageRange' => 2];
		$this->setPagination($configPagination);
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);

	
		$this->_view->categoryName 	= $this->_model->infoCategory();
		
		
		$this->_view->items = $this->_model->listItems($this->_arrParam, null);



		$this->_view->render('book/index');
	}

	

	//ACTION: AJAX STATUS
	public function ajaxChangeStatusAction()
	{
		$result = $this->_model->changeStatus($this->_arrParam, ['task' => 'change-status']);
		echo json_encode($result);
	}

	//ACTION: AJAX SPECIAL
	public function ajaxChangeSpecialAction()
	{
		$result = $this->_model->changeStatus($this->_arrParam, ['task' => 'change-special']);
		echo json_encode($result);
	}

	//ACTION: ORDERING
	public function changeOrderingAction()
	{
		$this->_model->orderingItem($this->_arrParam);
		$this->redirect('backend', 'book', 'index');
	}

	//ACTION: DELETE
	public function deleteAction()
	{

		$this->_model->deleteItem($this->_arrParam);
		$this->redirect('backend', 'book', 'index');
	}

	//ACTION: ACTIVE MULTI ITEMS
	public function activeAction()
	{
		$this->_model->statusItem($this->_arrParam);
		$this->redirect('backend', 'book', 'index');
	}

	//ACTION: INACTIVE MULTI ITEMS
	public function inactiveAction()
	{
		$this->_model->statusItem($this->_arrParam);
		$this->redirect('backend', 'book', 'index');
	}

	//ACTION: FORM
	public function formAction()
	{
		$this->_view->setTitle('Book :: Add');
		$this->_view->categoryName 	= $this->_model->infoCategory();

		if(!empty($_FILES)) $this->_arrParam['form']['picture']	= $_FILES['picture'];
		
	
        if (@$this->_arrParam['id'] && !@$this->_arrParam['form']['token']) {
			$this->_view->setTitle('Book Manager :: Edit');
            $item 			= $this->_model->infoItem($this->_arrParam);
            if (empty($item)) URL::redirect(URL::createLink($this->_arrParam['module'], $this->_arrParam['controller'], 'index'));
            $this->_arrParam['form'] = $item;
			
        }

        if (@$this->_arrParam['form']['token'] > 0) {
            $validate = new Validate($this->_arrParam['form']);
            $validate->addRule('name', 'string', ['min' => 3, 'max' => 255])
                ->addRule('special',  'select', ['deny' => 'default'])
                ->addRule('status', 'select', ['deny' => 'default'])
				->addRule('category_id', 'select', ['deny' => 'default'])
				->addRule('price', 'int', ['min' => 1000, 'max' => 1000000])
				->addRule('sale_off', 'int2', ['min' => 0, 'max' => 100])
				->addRule('picture', 'file', ['min' => '100', 'max' => '1000000', 'extension' => ['jpg', 'png', 'jpeg']], false);
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
	


	//ACTION CHANGE CATEGORY_ID
	public function changeCategoryIDAction()
	{
		$this->_model->changeCategoryID($this->_arrParam);
		$this->redirect('backend', 'book', 'index');
	}


}
