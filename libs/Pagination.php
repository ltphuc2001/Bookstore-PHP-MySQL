<?php
class Pagination
{

	public $totalItems;					// Tổng số phần tử
	public $totalItemsPerPage		= 1;	// Tổng số phần tử xuất hiện trên một trang
	public $pageRange				= 5;	// Số trang xuất hiện
	public $totalPage;						// Tổng số trang
	public $currentPage			= 1;	// Trang hiện tại

	public function __construct($totalItems, $pagination)
	{
		$this->totalItems			= $totalItems;
		$this->totalItemsPerPage	= $pagination['totalItemsPerPage'];

		if ($pagination['pageRange'] % 2 == 0) $pagination['pageRange'] = $pagination['pageRange'] + 1;

		$this->pageRange			= $pagination['pageRange'];
		$this->currentPage			= $pagination['currentPage'];
		$this->totalPage			= ceil($totalItems / $pagination['totalItemsPerPage']);
	}

	public function showPagination($link)
	{
		// Pagination
		$paginationHTML = '';
		if ($this->totalPage > 1) {
			$start 	= '<div class="button2-right off"><div class="start"><span>Start</span></div></div>';
			$prev 	= '<div class="button2-right off"><div class="prev"><span>Pre</span></div></div>';
			if ($this->currentPage > 1) {
				$start 	= '<div class="button2-right"><div class="start"><a onclick="javascript:changePage(1)" href="#">Start</a></div></div>';
				$prev 	= '<div class="button2-right"><div class="prev"><a onclick="javascript:changePage(' . ($this->currentPage - 1) . ')" href="#">Previous</a></div></div>';
			}

			$next 	= '<div class="button2-left off"><div class="next"><span>Next</span></div></div>';
			$end 	= '<div class="button2-left off"><div class="end"><span>End</span></div></div>';
			if ($this->currentPage < $this->totalPage) {
				$next 	= '<div class="button2-left"><div class="next"><a onclick="javascript:changePage(' . ($this->currentPage + 1) . ')" href="#">Next</a></div></div>';
				$end 	= '<div class="button2-left"><div class="end"><a href="#" onclick="javascript:changePage(' . $this->totalPage . ')">End</a></div></div>';
			}

			if ($this->pageRange < $this->totalPage) {
				if ($this->currentPage == 1) {
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				} else if ($this->currentPage == $this->totalPage) {
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				} else {
					$startPage		= $this->currentPage - ($this->pageRange - 1) / 2;
					$endPage		= $this->currentPage + ($this->pageRange - 1) / 2;

					if ($startPage < 1) {
						$endPage	= $endPage + 1;
						$startPage = 1;
					}

					if ($endPage > $this->totalPage) {
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			} else {
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}

			$listPages = '<div class="button2-left"><div class="page">';
			for ($i = $startPage; $i <= $endPage; $i++) {
				if ($i == $this->currentPage) {
					$listPages .= '<span>' . $i . '</span>';
				} else {
					$listPages .= '<a href="#" onclick="javascript:changePage(' . $i . ')">' . $i . '</a>';
				}
			}
			$listPages .= '</div></div>';
			$endPagination	= '<div class="limit">Page ' . $this->currentPage . ' of ' . $this->totalPage . '</div>';
			$paginationHTML = '<div class="pagination">' . $start . $prev . $listPages . $next . $end . $endPagination . '</div>';
		}
		return $paginationHTML;
	}

	public function showPaginationBackend()
	{
		// Pagination
		$queries = [];
		$query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
		parse_str($query, $queries);
		unset($queries['page']);
		$link = 'index.php?' . http_build_query($queries);
		$paginationHTML = '';

		if ($this->totalPage > 1) {
			$start 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-double-left"></i></a></li>';
			$prev 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>';
			if ($this->currentPage > 1) {
				$start 	= sprintf('<li class="page-item"><a class="page-link" href="%s&page=1"><i class="fas fa-angle-double-left"></i></a></li>', $link);
				$prev 	= sprintf('<li class="page-item"><a class="page-link" href="%s&page=%s"><i class="fas fa-angle-left"></i></a></li>', $link, $this->currentPage - 1);
			}

			$next 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>';
			$end 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-double-right"></i></a></li>';
			if ($this->currentPage < $this->totalPage) {
				$next 	= sprintf('<li class="page-item"><a class="page-link" href="%s&page=%s"><i class="fas fa-angle-right"></i></a></li>', $link, $this->currentPage + 1);
				$end 	= sprintf('<li class="page-item"><a class="page-link" href="%s&page=%s"><i class="fas fa-angle-double-right"></i></a></li>', $link, $this->totalPage);
			}

			if ($this->pageRange < $this->totalPage) {
				if ($this->currentPage == 1) {
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				} else if ($this->currentPage == $this->totalPage) {
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				} else {
					$startPage		= $this->currentPage - ($this->pageRange - 1) / 2;
					$endPage		= $this->currentPage + ($this->pageRange - 1) / 2;

					if ($startPage < 1) {
						$endPage	= $endPage + 1;
						$startPage = 1;
					}

					if ($endPage > $this->totalPage) {
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			} else {
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}

			$listPages = '';
			for ($i = $startPage; $i <= $endPage; $i++) {
				if ($i == $this->currentPage) {
					$listPages .= sprintf('<li class="page-item active"><a class="page-link">%s</a></li>', $i);
				} else {
					$listPages .= sprintf('<li class="page-item"><a class="page-link" href="%s&page=%s">%s</a></li>', $link, $i, $i);
				}
			}

			$paginationHTML = '<ul class="pagination m-0 float-right">' . $start . $prev . $listPages . $next . $end . '</ul>';
		}
		return $paginationHTML;
	}

	public function showPaginationPublic($linkA)
	{

		//Pagination
		$queries = [];
		$query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
		parse_str($query, $queries);
		unset($queries['page']);

		// $url = $_SERVER['REQUEST_URI'];
		// $a = pathinfo($url, PATHINFO_BASENAME);
		
		$link =  $linkA . http_build_query($queries);


		$paginationHTML = '';

		if ($this->totalPage > 1) {
			$start 	= '<li class="page-item disabled"><a href="" class="page-link"><i class="fa fa-angle-double-left"></i></a></li>';
			$prev 	= '<li class="page-item disabled"><a href="" class="page-link"><i class="fa fa-angle-left"></i></a></li>';
			if ($this->currentPage > 1) {
				$start 	= sprintf('<li class="page-item"><a href="%s&page=1" class="page-link"><i class="fa fa-angle-double-left"></i></a></li>', $link);
				$prev 	= sprintf('<li class="page-item disabled"><a href="%s&page=%s" class="page-link"><i class="fa fa-angle-left"></i></a></li>', $link, $this->currentPage - 1);
			}

			$next 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>';
			$end 	= '<li class="page-item disabled"><a class="page-link" href="#"><i class="fa fa-angle-double-right"></i></a></li>';
			if ($this->currentPage < $this->totalPage) {
				$next 	= sprintf('<li class="page-item"><a class="page-link" href="%s&page=%s"><i class="fa fa-angle-right"></i></a></li>', $link, $this->currentPage + 1);
				$end 	= sprintf('<li class="page-item"><a class="page-link" href="%s&page=%s"><i class="fa fa-angle-double-right"></i></a></li>', $link, $this->totalPage);
			}

			if ($this->pageRange < $this->totalPage) {
				if ($this->currentPage == 1) {
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				} else if ($this->currentPage == $this->totalPage) {
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				} else {
					$startPage		= $this->currentPage - ($this->pageRange - 1) / 2;
					$endPage		= $this->currentPage + ($this->pageRange - 1) / 2;

					if ($startPage < 1) {
						$endPage	= $endPage + 1;
						$startPage = 1;
					}

					if ($endPage > $this->totalPage) {
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			} else {
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}

			$listPages = '';
			for ($i = $startPage; $i <= $endPage; $i++) {
				if ($i == $this->currentPage) {
					$listPages .= sprintf('<li class="page-item active"><a class="page-link">%s</a></li>', $i);
				} else {
					$listPages .= sprintf('<li class="page-item"><a class="page-link" href="%s&page=%s">%s</a></li>', $link, $i, $i);
				}
			}

			$paginationHTML = '<ul class="pagination">' . $start . $prev . $listPages . $next . $end . '</ul>';
		}
		return $paginationHTML;

		// Pagination
		// Pagination
		// $paginationHTML = '';
		// if ($this->totalPage > 1) {
		// 	$start 	= '<li class="page-item disabled"><a href="" class="page-link" style="background-color: #f2f2f2"><i class="fa fa-angle-double-left"></i></a></li>';
		// 	$prev 	= '<li class="page-item disabled"><a href="" class="page-link" style="background-color: #f2f2f2"><i class="fa fa-angle-left"></i></a></li>';
		// 	if ($this->currentPage > 1) {
		// 		$start 	= sprintf('<li class="page-item"><a href="%s" class="page-link"><i class="fa fa-angle-double-left"></i></a></li>', "$link&page=1");
		// 		$prev 	= sprintf('<li class="page-item"><a href="%s" class="page-link"><i class="fa fa-angle-left"></i></a></li>', "$link&page=" . ($this->currentPage - 1));
		// 	}

		// 	$next 	= '<li class="page-item disabled"><a class="page-link" href="#" style="background-color: #f2f2f2"><i class="fa fa-angle-right"></i></a></li>';
		// 	$end 	= '<li class="page-item disabled"><a class="page-link" href="#" style="background-color: #f2f2f2"><i class="fa fa-angle-double-right"></i></a></li>';
		// 	if ($this->currentPage < $this->totalPage) {
		// 		$next 	= sprintf('<li class="page-item"><a class="page-link" href="%s"><i class="fa fa-angle-right"></i></a></li>', "$link&page=" . ($this->currentPage + 1));
		// 		$end 	= sprintf('<li class="page-item"><a class="page-link" href="%s"><i class="fa fa-angle-double-right"></i></a></li>', "$link&page={$this->totalPage}");
		// 	}

		// 	if ($this->pageRange < $this->totalPage) {
		// 		if ($this->currentPage == 1) {
		// 			$startPage 	= 1;
		// 			$endPage 	= $this->pageRange;
		// 		} else if ($this->currentPage == $this->totalPage) {
		// 			$startPage		= $this->totalPage - $this->pageRange + 1;
		// 			$endPage		= $this->totalPage;
		// 		} else {
		// 			$startPage		= $this->currentPage - ($this->pageRange - 1) / 2;
		// 			$endPage		= $this->currentPage + ($this->pageRange - 1) / 2;

		// 			if ($startPage < 1) {
		// 				$endPage	= $endPage + 1;
		// 				$startPage = 1;
		// 			}

		// 			if ($endPage > $this->totalPage) {
		// 				$endPage	= $this->totalPage;
		// 				$startPage 	= $endPage - $this->pageRange + 1;
		// 			}
		// 		}
		// 	} else {
		// 		$startPage		= 1;
		// 		$endPage		= $this->totalPage;
		// 	}

		// 	$listPages = '';
		// 	for ($i = $startPage; $i <= $endPage; $i++) {
		// 		if ($i == $this->currentPage) {
		// 			$listPages .= sprintf('<li class="page-item active"><a class="page-link">%s</a></li>', $i);
		// 		} else {
		// 			$listPages .= sprintf('<li class="page-item"><a class="page-link" href="%s">%s</a></li>', "$link&page=$i", $i);
		// 		}
		// 	}
		// 	$paginationHTML = '<ul class="pagination">' . $start . $prev . $listPages . $next . $end  . '</ul>';
		// }
		// return $paginationHTML;
	}
}
