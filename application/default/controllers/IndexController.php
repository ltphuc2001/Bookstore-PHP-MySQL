<?php
class IndexController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	public function indexAction(){
		$this->_view->setTitle('Trang chủ | BookStore');

		$this->_view->specialBooks = $this->_model->listItem($this->_arrParam, ['task' => 'book-special']);
		$this->_view->items 	   = $this->_model->listItem($this->_arrParam, ['task' => 'book-in-category']);
		$this->_view->listCategory = $this->_model->listItem($this->_arrParam, ['task' => 'category']);
		// $this->_view->bookInfo 	   = $this->_model->infoItem($this->_arrParam, ['task' => 'book-info']);
		
	
		$this->_view->render('index/index');
		
	}

	

	
	
}