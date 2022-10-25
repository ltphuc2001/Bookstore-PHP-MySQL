<?php

$userObjLogin    = Session::get('userLogin');
$cart            = Session::get('cart');

$arrNotify  = ['success' => 'Bạn đã đặt hàng thành công', 'fail' => 'Đặt hàng thất bại!'];
$xhtmlBuy = '';



if ($cart == null || count($cart['quantity']) == 0) {
    $xhtmlBuy .= $arrNotify['fail'];
} else {
    $xhtmlBuy .= $arrNotify['success'];
}

?>
<div class="breadcrumb-section" style="margin-top: 107px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Giỏ hàng</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="" method="POST" name="admin-form" id="admin-form">
    <section class="cart-section section-b-space">
        <div class="container">
            <div class="row">
                <h3 style="padding-left: 600px;"><?php echo $xhtmlBuy; ?></h3>
            </div>
            <div class="row cart-buttons">
                <div class="col-8">
                    <a href="http://localhost/Bookstore-PHP-MySQL/project-final/index.html" class="btn btn-solid">Tiếp tục mua sắm</a>
                </div>
            </div>
    </section>
</form>

<div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
    <div class="phonering-alo-ph-circle"></div>
    <div class="phonering-alo-ph-circle-fill"></div>
    <a href="tel:0905744470" class="pps-btn-img" title="Liên hệ">
        <div class="phonering-alo-ph-img-circle"></div>
    </a>
</div>