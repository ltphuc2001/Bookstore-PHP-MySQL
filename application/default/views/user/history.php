<?php
 $linkHistory       = URL::createLink('default', 'user', 'history', null, 'history.html');
 $linkAccount       = URL::createLink('default', 'user', 'account', null, 'my-account.html');
 $linkLogout        = URL::createLink('default', 'user', 'logout');
 $linkChangePass    = URL::createLink('default', 'user', 'changePass', null, 'changePass.html');

$xhtmlHistory = '';
if (!empty($this->items)) {

    $tableHeader = '
                <tr>
                    <td>Hình ảnh</td>
                    <td>Tên sách</td>
                    <td>Giá</td>
                    <td>Số lượng</td>
                    <td>Thành tiền</td>
                </tr>
    ';

    foreach ($this->items as $key => $item) {
        $cartID         = $item['id'];
        $date           = date("d/m/Y H:i:s", strtotime($item['date']));
        $arrBookID      = json_decode($item['books']);
        $arrPrice       = json_decode($item['prices']);
        $arrName        = json_decode($item['names'], JSON_UNESCAPED_UNICODE);
        $arrQuantity    = json_decode($item['quantities']);
        $arrPicture     = json_decode($item['pictures']);
        $totalPrice     = 0;
        $tableContent   = '';


        foreach (@$arrBookID as $keyB => $itemB) {

            $prices = filter_var($arrPrice[$keyB], FILTER_SANITIZE_NUMBER_INT);
            $linkBook = URL::createLink('default', 'book', 'item', ['book_id' => $itemB]);
            $picturePath = IMG_DEFAULT_BOOK_PATH . $arrPicture[$keyB];
            $totalPrice  += $arrQuantity[$keyB] * $prices;
            $tableContent .= '
            <tr>
                 <td>
                    <a href="' . $linkBook . '"><img src="' . $picturePath . '" alt="' . $arrName[$keyB] . '" style="width: 80px"></a></td>
                 <td style="min-width: 200px">' . $arrName[$keyB] . '</td>
                 <td style="min-width: 100px">' . number_format($prices) . ' đ</td>
                 <td>' . $arrQuantity[$keyB] . '</td>
                 <td style="min-width: 150px">' . number_format($arrQuantity[$keyB] * $prices) . ' đ</td>
            </tr>
            <tr></tr>
            ';
        }


        $xhtmlHistory .= '
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button style="text-transform: none;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#' . $cartID . '">Mã đơn hàng: ' . $cartID . '</button>&nbsp;&nbsp;Thời gian: ' . $date . '
                                </h5>
                            </div>
                            <div id="' . $cartID . '" class="collapse" data-parent="#accordionExample" style="">
                                <div class="card-body table-responsive">
                                    <table class="table btn-table">

                                        <thead>
                                           ' . $tableHeader . '
                                        </thead>

                                        <tbody>
                                           ' . $tableContent . '
                                           
                                        </tbody>

                                        <tfoot>
                                            <tr class="my-text-primary font-weight-bold">
                                                <td colspan="4" class="text-right">Tổng: </td>
                                                <td>' . number_format($totalPrice) . ' đ</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
        ';
    }
} else {
    $xhtmlHistory = '<h2>Chưa có đơn hàng nào</h2>';
}


?>

<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title">
                    <h2 class="py-2">Lịch sử mua hàng</h2>
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
                <h3 class="d-lg-none">Lịch sử mua hàng</h3>
                <div class="dashboard-left">
                    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> Ẩn</span></div>
                    <div class="block-content">
                        <ul>
                            <li class=""><a href="<?php echo $linkAccount ?>">Thông tin tài khoản</a></li>
                            <li class="active"><a href="<?php echo $linkHistory ?>">Lịch sử mua hàng</a></li>
                            <li class=""><a href="<?php echo $linkChangePass ?>">Thay đổi mật khẩu</a></li>
                            <li class=""><a href="<?php echo $linkLogout ?>">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="accordion theme-accordion" id="accordionExample">
                    <div class="accordion theme-accordion" id="accordionExample">
                        <?php echo $xhtmlHistory; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>