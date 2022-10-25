<?php

 $userLogin   = Session::get('userLogin');
 $linkHistory       = URL::createLink('default', 'user', 'history');
 $linkAccount       = URL::createLink('default', 'user', 'account');
 $linkLogout        = URL::createLink('default', 'user', 'logout');
 $linkChangePass    = URL::createLink('default', 'user', 'changePass');


?>

<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">
                        Thông Tin Tài khoản </h2>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="faq-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="account-sidebar">
                    <a class="popup-btn">Menu</a>
                </div>
                <h3 class="d-lg-none">Tài khoản</h3>
                <div class="dashboard-left">
                    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> Ẩn</span></div>
                    <div class="block-content">
                        <ul>
                            <li class=""><a href="<?php echo $linkAccount ?>">Thông tin tài khoản</a></li>
                            <li class=""><a href="<?php echo $linkHistory ?>">Lịch sử mua hàng</a></li>
                            <li class="active"><a href="<?php echo $linkChangePass ?>">Thay đổi mật khẩu</a></li>
                            <li class=""><a href="<?php echo $linkLogout ?>">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard">
                        <form action="" method="post" id="admin-form" class="theme-form">
                            <h2>Thay đổi mật khẩu thành công</h2>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>