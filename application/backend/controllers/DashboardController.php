<?php
class DashboardController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	public function indexAction(){
		$this->_view->setTitle('DashBoard');


		$this->_view->itemsGroup	 = $this->_model->listItemsGroup();
		$this->_view->itemsUser 	 = $this->_model->listItemsUser();
		$this->_view->itemCategory   = $this->_model->listItemCategory();
		$this->_view->itemBook		 = $this->_model->listItemBook();
		$this->_view->itemCart		 = $this->_model->listItemCart();


		$this->_view->render('dashboard/index');
		
		
	}
	
	
}