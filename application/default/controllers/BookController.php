<?php
class BookController extends Controller
{

	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function listAction()
	{
		$this->_view->setTitle('Sách');
		$this->_view->categoryName = $this->_model->infoItem($this->_arrParam, ['task' => 'get-category-name']);

		// $this->_view->bookInfo 		= $this->_model->infoItem($this->_arrParam, ['task' => 'book-info']);
		$this->_view->allBooks     = $this->_model->listItem($this->_arrParam, ['task' => 'book-list']);
		$this->_view->bookSpecial  = $this->_model->listItem($this->_arrParam, ['task' => 'book-special']);
		//Chỉ lấy những book được active và category active


		if (empty($this->_arrParam['search'])) {
			$countStatusAcive = $this->_model->countItem($this->_arrParam, ['task' => 'count-item-by-status']);
			$totalItems		  = $countStatusAcive['active'];
			$this->_view->countStatusAcive = $countStatusAcive;
			$this->_view->currentPage = $this->_pagination['currentPage'];
			$configPagination = ['totalItemsPerPage'	=> 8, 'pageRange' => 2];
			$this->setPagination($configPagination);

			//$this->_view->totalItemsPerPage = $configPagination['totalItemsPerPage'];
		}
		$this->_view->totalItemsPerPage	= $this->_model->listItem($this->_arrParam, ['task' => 'book-list'])['resultshowItems'];
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);




		//SORT FORM
		$valueSort = @$this->_arrParam['sort'];
		switch ($valueSort) {
			case 'priceASC':
				$this->_view->items 	= $this->_model->sortForm($this->_arrParam, ['task' => 'priceASC']);
				$this->_view->allBooks 	= $this->_model->sortForm($this->_arrParam, ['task' => 'priceASC']);
				break;
			case 'priceDESC':
				$this->_view->items 	= $this->_model->sortForm($this->_arrParam, ['task' => 'priceDESC']);
				$this->_view->allBooks 	= $this->_model->sortForm($this->_arrParam, ['task' => 'priceDESC']);
				break;
			case 'latest':
				$this->_view->items 	= $this->_model->sortForm($this->_arrParam, ['task' => 'latest']);
				$this->_view->allBooks 	= $this->_model->sortForm($this->_arrParam, ['task' => 'latest']);
				break;
			case 'default':
				$this->_view->items 	= $this->_model->listItem($this->_arrParam, ['task' => 'book-in-category']);
				break;
			default:
				$this->_view->items 	= $this->_model->listItem($this->_arrParam, ['task' => 'book-in-category'])['list'];
				$this->_view->allBooks 	= $this->_model->listItem($this->_arrParam, ['task' => 'book-list'])['list'];
		}


		$this->_view->render('book/list');
	}

	public function itemAction()
	{
		$this->_view->setTitle('Item');
		$this->_view->bookInfo 		= $this->_model->infoItem($this->_arrParam, ['task' => 'book-info']);
		$this->_view->bookRelate 	= $this->_model->listItem($this->_arrParam, ['task' => 'book-relate']);
		$this->_view->bookNews		= $this->_model->listItem($this->_arrParam, ['task' => 'book-news']);

		$this->_view->render('book/item');
	}
}
