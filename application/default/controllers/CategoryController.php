<?php
class CategoryController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	//ACTION: LIST CATEGORY
	public function indexAction(){
		$this->_view->setTitle('Category');

		//Chỉ lấy những category được active
		$countStatusAcive = $this->_model->countItem($this->_arrParam, ['task' => 'count-item-by-status']);
		$totalItems		  = $countStatusAcive['active'];
		$this->_view->countStatusAcive = $countStatusAcive;
		$configPagination = ['totalItemsPerPage'	=> 5, 'pageRange' => 2];
		$this->_view->totalItemsPerPage = $configPagination['totalItemsPerPage'];
		$this->setPagination($configPagination);
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);

		$this->_view->totalItemsPerPage	= $this->_model->listItems($this->_arrParam)['resultshowItems'];
		$this->_view->items = $this->_model->listItems($this->_arrParam, null)['list'];
		$this->_view->render('category/list');
	}


}