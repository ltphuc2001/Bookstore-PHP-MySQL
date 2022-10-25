<?php
$xhtmlBookOrder  = '';
$xhtmlTotalPrice = '';
$totalPrice = 0;

$userObjLogin    = Session::get('userLogin');
$cart            = Session::get('cart');

if (!empty($this->items)) {
    foreach ($this->items as $key => $item) {
        $id         = $item['id'];
        $name       = $item['name'];
        $quantity   = $item['quantity'];
       
      
        $price      = number_format($item['price']);
        $priceTotalItem = number_format($item['totalprice'] * $item['quantity']);
        $totalPrice += $item['totalprice'] * $item['quantity'];
        $picture    = IMG_DEFAULT_BOOK_PATH . $item['picture'];
        $pictureInput = $item['picture'];
        $link                   = URL::createLink('default', 'book', 'item', ['book_id' => $id]);
        $linkDeleteItem         = URL::createLink('default', 'user', 'deleteItem', ['book_id' => $id]);
       
        $linkChangeQty =  URL::createLink($this->arrParams['module'], $this->arrParams['controller'],  'ajaxUpdateCart', ['quantity' => 'value_new', 'id' => $item['id']]);
       
        $inputBookID    = HelperDefault::inputHidden('form[book_id][]', $id, 'input_bookID_' . $id);
        $inputName      = HelperDefault::inputHidden('form[name][]', $name, 'input_name_' . $id);
        $inputPrice     = HelperDefault::inputHidden('form[price][]', $price, 'input_price_' . $id);
        $inputQuantity  = HelperDefault::inputHidden('form[quantity][]', $quantity, 'input_quantity_' . $id);
        $inputPicture    = HelperDefault::inputHidden('form[picture][]', $pictureInput, 'input_picture_' . $id);


        $xhtmlBookOrder  .= '
                                <tr>
                                    <td>
                                        <a href="' . $link . '"><img src="' . $picture . '" alt="' . $name . '"></a>
                                    </td>
                                    <td><a href="' . $link . '">' . $name . '</a>
                                        <div class="mobile-cart-content row">
                                            <div class="col-xs-3">
                                                <div class="qty-box">
                                                    <div class="input-group">
                                                        <input type="number"  name="quantity" value="' . $quantity . '" class="form-control input-number" id="change-quantity" min="1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <h2 class="td-color text-lowercase">' . $priceTotalItem . ' đ</h2>
                                            </div>
                                            <div class="col-xs-3">
                                                <h2 class="td-color text-lowercase">
                                                    <a href="#" class="icon"><i class="ti-close"></i></a>
                                                </h2>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h2 class="text-lowercase">' . number_format($item['price']) . ' đ</h2>
                                    </td>
                                    <td>
                                        <div class="qty-box">
                                            <div class="input-group">
                                                <input type="number" name="quantity" data-url="'.$linkChangeQty.'" value="' . $quantity . '" class="changeQty form-control input-number" >
                                            </div>
                                        </div>
                                    </td>
                                    <td><a href="'.$linkDeleteItem.'" class="icon"><i class="ti-close"></i></a></td>
                                    <td>
                                        <h2 class="td-color text-lowercase">' . $priceTotalItem . ' đ</h2>
                                    </td>
                                </tr>

        ';

        $xhtmlBookOrder .= $inputBookID . $inputName . $inputPicture . $inputPrice . $inputQuantity;
    }

    $xhtmlTotalPrice .= ' <h2 class="text-lowercase">' . number_format($totalPrice) . ' đ</h2>';
}



//BUTTON
$linkBuy = URL::createLink('defaul', 'user', 'buy', null, 'buy.html');
$btnSave  = HelperDefault::button($linkBuy, 'btn-submit', 'Đặt hàng');

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
                <div class="col-sm-12">
                    <table class="table cart-table table-responsive-xs">
                        <thead>
                            <tr class="table-head">
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Tên sách</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col"></th>
                                <th scope="col">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $xhtmlBookOrder ?>
                           
                        </tbody>

                    </table>
                    <table class="table cart-table table-responsive-md">
                        <tfoot>
                            <tr>
                                <td>Tổng :</td>
                                <td>
                                    <?php echo $xhtmlTotalPrice ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row cart-buttons">
                <div class="col-6">
                    <a href="http://localhost/Bookstore-PHP-MySQL/project-final/index.html" class="btn btn-solid">Tiếp tục mua sắm</a>
                </div>
                <div class="col-6">
                    <?php echo $btnSave; ?>
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