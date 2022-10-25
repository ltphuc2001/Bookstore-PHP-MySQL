<?php

$xhtmlCategoryMost = '';
$xhtmlBookMost = '';
$classSaleOff = '';

$model = new Model();
$cID  = 2;
$query[] = "SELECT `b`.`id` AS 'book_id', `b`.`description`, `b`.`name` AS 'book_name', `c`.`name` AS 'category_name', `b`.`price`, `b`.`special`, `b`.`sale_off`, `b`.`picture`, `b`.`category_id`";
$query[] = "FROM `book` AS `b`, `category` AS `c`";
$query[] = "WHERE `b`.`category_id` = `c`.`id`";
$query[] = "AND `c`.`id` = '$cID' AND `b`.`status` = 'active' AND `b`.`special` = 'yes' AND `c`.`status` = 'active'";
$query[] = "ORDER BY `c`.`ordering`";


$query        = implode(" ", $query);
$listBook = $model->listRecord($query);


if (!empty($listBook) > 0) {

    $i = 1;
    $xhtmlCategoryMost .= '<ul class="tabs tab-title">';


    $activeDefault = ($i == 1) ? 'active default' : '';
    $activeTab     = ($i == 1) ? 'class="current"' : '';

    $xhtmlCategoryMost .= '<li class="current">Kinh Tế</li>';

   
    $xhtmlBookMost .= '<div id="tab-category-2" class="tab-content ' . $activeDefault . '" style="display: block;" ">
                            <div class="no-slider row tab-content-inside">';
    $countItemBook = 1;

    foreach ($listBook as $keyBook => $valueBook) {

        // Danh sách "sản phẩm nổi bật" chỉ cho phép chứa tối đa 8 item, kiểm tra nếu số item vượt quá 8 sẽ ngắt vòng lặp
        if ($countItemBook > 8) {
            break;
        }
        
        $id             = $valueBook['book_id'];
        $saleOff        = $valueBook['sale_off'];
        $name           = $valueBook['book_name'];
        $category_name        = $valueBook['category_name'];
        $category_id        = $valueBook['category_id'];
        $price          = $valueBook['price'];
        $imgBook        = IMG_DEFAULT_BOOK_PATH . $valueBook['picture'];

        //ADD TO CART 
        $bookNameURL       = URL::filterURL($name);
        $catNameURL        = URL::filterURL($category_name);
        $addCartItem              = 'javascript:addCartItem(\'' . $valueBook['book_id'] . '\', \'' . number_format((100 - $saleOff) * $price / 100) . '\')';
        // $linkModalView  = URL::createLink($this->arrParam['module'], $this->arrParam['controller'], 'ajaxLoadInfo', ['id' => $valueBook['book_id']]);
        $link              = URL::createLink('default', 'book', 'item', ['category_id' => $valueBook['category_id'], 'book_id' => $valueBook['book_id']], "$catNameURL/$bookNameURL-$category_id-$id.html");
        $linkViewAll    = URL::createLink('default', 'book', 'list', ['category_id' => $valueBook['category_id']], "$catNameURL-$category_id.html");

        if ($saleOff > 0) {
            $classPrice = '
                                <h4 class="text-lowercase pt-2">' . number_format((100 - $saleOff) * $price / 100) . ' đ <del>' . number_format($price) . ' đ</del></h4>
                               
                ';

            $classSaleOff = '
                <div class="lable-block">
                    <span class="lable4 badge badge-danger"> -' . $saleOff . '%</span>
                </div>';

        } else {
            $classPrice = '                   
                                <h4 class="text-lowercase pt-2">' . number_format($price) . ' đ </h4>
                ';
            $classSaleOff = '';
        }

        $xhtmlBookMost .= '<div class="product-box">
                <div class="img-wrapper">
                    '.$classSaleOff.'
                    <div class="front">
                        <a href="' . $link . '">
                            <img src="' . $imgBook . '" class="img-fluid blur-up lazyload" style="height: 500px; width: 100%;">
                        </a>
                    </div>
                    <div class="cart-info cart-wrap">
                        <a href="' . $addCartItem . '" title="Add to cart"><i class="ti-shopping-cart"></i></a>
                       
                    </div>
                </div>
                <div class="product-detail">
                    <a href="' . $link . '">
                        <h6 class="cs-ellipsis-4 pb-0">' . $valueBook['book_name'] . '</h6>
                    </a>
                    ' . $classPrice . '
                </div>
            </div>';
        $countItemBook++;
    }
    $xhtmlBookMost .= ' </div>
                        <div class="text-center"><a href="' . $linkViewAll . '" class="btn btn-solid">Xem tất cả</a></div>
                    </div>';
    $i++;


    $xhtmlCategoryMost .= '</ul>';
} else {
    $xhtmlCategoryMost = '<p class="font-weight-bold text-center h6 text-muted">Danh mục đang được cập nhật !</p>';
}


?>


<div class="title1 section-t-space title5">
    <h2 class="title-inner1">Danh mục nổi bật</h2>
    <hr role="tournament6">
</div>


<section class="p-t-0 j-box ratio_asos">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="theme-tab">
                    <?php echo $xhtmlCategoryMost; ?>
                    <div class="tab-content-cls">
                        <?php echo $xhtmlBookMost; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>