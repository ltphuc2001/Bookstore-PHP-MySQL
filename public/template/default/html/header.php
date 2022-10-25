<?php
$xhtml = '';
$userObjLogin    = Session::get('userLogin');
$userObjRegister = Session::get('userRegister');

$linkIndex      = URL::createLink('default', 'index', 'index', null, 'index.html');
$linkCart       = URL::createLink('default', 'user', 'cart', null, 'cart.html');


$home           = HelperDefault::itemNavBar('single', URL::createLink($this->arrParams['module'], 'home', 'index', null, 'index.html'), 'Trang chủ', 'index');
$book           = HelperDefault::itemNavBar('single', URL::createLink($this->arrParams['module'], 'book', 'list', null, 'sach.html'), 'Sách', 'book');
$category       = HelperDefault::itemNavBar('single', URL::createLink($this->arrParams['module'], 'category', 'index', null, 'danh-muc.html'), 'Danh mục', 'category');

//QUANTITY ORDER CART
$cart = Session::get('cart');
$totalOrder = 0;
if (isset($cart['quantity'])) {
    foreach (@$cart['quantity'] as $key => $value) {
        $totalOrder += $value;
    }
}


$arrMenu = [
    'login'         =>  ['link' => URL::createLink('default', 'user', 'login', null, 'login.html'),         'name' => 'Đăng Nhập'],
    'register'      =>  ['link' => URL::createLink('default', 'user', 'register', null, 'register.html'),   'name' => 'Đăng ký'],
    'account'       =>  ['link' => URL::createLink('default', 'user', 'account', null, 'my-account.html'),  'name' => 'Tài khoản'],
    'logout'        =>  ['link' => URL::createLink('default', 'user', 'logout'),                            'name' => 'Đăng xuất'],
    'admin'         =>  ['link' => URL::createLink('backend', 'account', 'login', null),    'name' => 'Admin Control'],


];

if (@$userObjLogin['login'] == true || @$userObjRegister['register'] == true) {
    $xhtml .= '<li><a href="' . $arrMenu['account']['link'] . '">' . $arrMenu['account']['name'] . '</a></li>';
    $xhtml .= '<li><a href="' . $arrMenu['logout']['link'] . '">' . $arrMenu['logout']['name'] . '</a></li>';

    if (@$userObjLogin['group_acp'] == 'yes') {
        $xhtml .= '<li><a href="' . $arrMenu['admin']['link'] . '">' . $arrMenu['admin']['name'] . '</a></li>';
    }
} else {
    $xhtml .= '<li><a href="' . $arrMenu['login']['link'] . '">' . $arrMenu['login']['name'] . '</a></li>';
    $xhtml .= '<li><a href="' . $arrMenu['register']['link'] . '">' . $arrMenu['register']['name'] . '</a></li>';
}




?>


<div class="loader_skeleton" style="display: none;">
    <div class="typography_section">
        <div class="typography-box">
            <div class="typo-content loader-typo">
                <div class="pre-loader"></div>
            </div>
        </div>
    </div>
</div>
<header class="my-header sticky">
    <div class="mobile-fix-option"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-menu">
                    <div class="menu-left">
                        <div class="brand-logo">
                            <a href="<?php echo $linkIndex ?>">
                                <h2 class="mb-0" style="color: #5fcbc4">BookStore</h2>
                            </a>
                        </div>
                    </div>
                    <div class="menu-right pull-right">
                        <div>
                            <nav id="main-nav">
                                <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                <ul id="main-menu" class="sm pixelstrap sm-horizontal" data-smartmenus-id="16564017362317122">
                                    <li>
                                        <div class="mobile-back text-right">Back<i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                                    </li>
                                    <?= $home . $book . $category ?>

                                </ul>
                            </nav>
                        </div>
                        <div class="top-header">
                            <ul class="header-dropdown">
                                <li class="onhover-dropdown mobile-account">
                                    <img src="<?php echo $this->_dirImg ?>avatar.png" alt="avatar">
                                    <ul class="onhover-show-div">
                                        <?php echo $xhtml; ?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div class="icon-nav">
                                <ul>
                                    <li class="onhover-div mobile-search">
                                        <div>
                                            <img src="<?php echo $this->_dirImg ?>search.png" onclick="openSearch()" class="img-fluid blur-up lazyloaded" alt="">
                                            <i class="ti-search" onclick="openSearch()"></i>
                                        </div>
                                        <div id="search-overlay" class="search-overlay">
                                            <div>
                                                <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                                                <div class="overlay-content">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <form action="<?= URL::createLink("default", "book", "list", ['search' => $this->arrParams['search'] ?? ''], 'sach.html') ?>" method="POST">
                                                                    <input type="hidden" name="module" value="default">
                                                                    <input type="hidden" name="controller" value="book">
                                                                    <input type="hidden" name="action" value="list">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="search" id="search-input" autocomplete="off" value="<?= $this->arrParams['search'] ?? '' ?>" placeholder="Tìm kiếm sách...">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="onhover-div mobile-cart">
                                        <div>
                                            <a href="<?php echo $linkCart ?>" id="cart" class="position-relative">
                                                <img src="<?php echo $this->_dirImg ?>cart.png" class="img-fluid blur-up lazyloaded" alt="cart">
                                                <i class="ti-shopping-cart"></i>
                                                <span class="ml-1 position-absolute translate-middle badge rounded-pill bg-warning text-dark" id="quantity-cart"><?php echo $totalOrder ?></span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>