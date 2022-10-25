<?php
$xhtmlBook = '';
$classPrice = '';
$classSaleOff = '';

@$catID = $this->arrParam['category_id'];

if (isset($catID)) {
    if (count($this->items)) {
        foreach ($this->items as $key => $item) {
            $id                = $item['id'];
            $saleOff           = $item['sale_off'];
            $price             = $item['price'];
            $name               = HelperDefault::highlight(@$this->arrParams['search'], $item['name']);
            @$category_id       = $item['category_id'];
            
            $category_name            = $item['category_name'];
            $bookNameURL                 = URL::filterURL($name);
            $catNameURL                 = URL::filterURL($category_name);

            $nameURL           = URL::filterURL($name);
            //CART
            $addCartItem              = 'javascript:addCartItem(\'' . $item['id'] . '\', \'' . number_format((100 - $saleOff) * $price / 100) . '\')';

            $link                     = URL::createLink('default', 'book', 'item', ['category_id' => $item['category_id'], 'book_id' => $id], "$catNameURL/$bookNameURL-$category_id-$id.html");
            //$linkOrder          = URL::createLink('default', 'user', 'order', ['book_id' => $id, 'price' => number_format((100 - $saleOff) * $price / 100)]);
            $description       = $item['description'];
            $picture           = IMG_DEFAULT_BOOK_PATH . $item['picture'];

            if ($saleOff > 0) {
                $classPrice = '
                                    <h4 class="text-lowercase">' . number_format((100 - $saleOff) * $price / 100) . ' đ <del>' . number_format($price) . ' đ</del></h4>
                                   
                    ';

                $classSaleOff = '
                            <div class="lable-block">
                                <span class="lable4 badge badge-danger"> -' . $saleOff . '%</span>
                            </div>
                    ';
            } else {
                $classPrice = '                   
                                    <h4 class="text-lowercase">' . number_format($price) . ' đ </h4>
                    ';

                $classSaleOff = '';
            }

            $xhtmlBook .= '<div class="col-xl-3 col-6 col-grid-box">
                <div class="product-box">
                    <div class="img-wrapper">
                        ' . $classSaleOff . '
                        <div class="front">
                            <a href="' . $link . '" >
                                <img src="' . $picture . '" class="img-fluid blur-up lazyload resize-img-book">
                            </a>
                        </div>
                        <div class="cart-info cart-wrap">
                            <a href="' . $addCartItem . '" title="Add to cart"><i class="ti-shopping-cart"></i></a>
                            
                        </div>
                    </div>
                    <div class="product-detail">
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <a href="item.html" title="' . $name . '">
                            <h6>' . $name . '</h6>
                        </a>
                        <p>' . $description . '</p>
                       ' . $classPrice . '
                    </div>
                </div>
            </div>';
        }
    }
} else {
    if (count($this->allBooks)) {
        foreach ($this->allBooks as $key => $item) {
           
            $id                = $item['id'];
            $saleOff           = $item['sale_off'];
            $price             = $item['price'];
            $name               = HelperDefault::highlight(@$this->arrParams['search'], $item['name']);
            @$category_id       = $item['category_id'];

            $category_name            = $item['category_name'];
            $bookNameURL                 = URL::filterURL($name);
            $catNameURL                 = URL::filterURL($category_name);

            $nameURL           = URL::filterURL($name);
            //CART
            $addCartItem              = 'javascript:addCartItem(\'' . $item['id'] . '\', \'' . number_format((100 - $saleOff) * $price / 100) . '\')';

            $link                     = URL::createLink('default', 'book', 'item', ['category_id' => $item['category_id'], 'book_id' => $id], "$catNameURL/$bookNameURL-$category_id-$id.html");
            //$linkOrder          = URL::createLink('default', 'user', 'order', ['book_id' => $id, 'price' => number_format((100 - $saleOff) * $price / 100)]);
            $description       = $item['description'];
            $picture           = IMG_DEFAULT_BOOK_PATH . $item['picture'];

            if ($saleOff > 0) {
                $classPrice = '
                                <h4 class="text-lowercase">' . number_format((100 - $saleOff) * $price / 100) . ' đ <del>' . number_format($price) . ' đ</del></h4>
                               
                ';

                $classSaleOff = '
                        <div class="lable-block">
                            <span class="lable4 badge badge-danger"> -' . $saleOff . '%</span>
                        </div>
                ';
            } else {
                $classPrice = '                   
                                <h4 class="text-lowercase">' . number_format($price) . ' đ </h4>
                ';

                $classSaleOff = '';
            }

            $xhtmlBook .= '<div class="col-xl-3 col-6 col-grid-box">
            <div class="product-box">
                <div class="img-wrapper">
                    ' . $classSaleOff . '
                    <div class="front">
                        <a href="' . $link . '" >
                            <img src="' . $picture . '" class="img-fluid blur-up lazyload resize-img-book">
                        </a>
                    </div>
                    <div class="cart-info cart-wrap">
                        <a href="' . $addCartItem . '" title="Add to cart"><i class="ti-shopping-cart"></i></a>
                        
                    </div>
                </div>
                <div class="product-detail">
                    <a href="item.html" title="' . $name . '">
                        <h6>' . $name . '</h6>
                    </a>
                    <p>' . $description . '</p>
                   ' . $classPrice . '
                </div>
            </div>
        </div>';
        }
    } else {
        $xhtmlBook .= '<h2>Không có dữ liệu</h2>';
    }
}



?>
<?php require_once 'elements/breadcrumb.php' ?>
<section class="section-b-space j-box ratio_asos">
    <div class="collection-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 collection-filter">
                    <!-- side-bar colleps block stat -->
                    <?php require_once BLOCK_PATH . 'category.php' ?>

                    <?php require_once BLOCK_PATH . 'bookMost.php' ?>
                    <!-- silde-bar colleps block end here -->
                </div>
                <div class="collection-content col">
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="collection-product-wrapper">
                                    <?php require_once BLOCK_PATH . 'filter.php' ?>
                                    <div class="product-wrapper-grid" id="my-product-list">
                                        <div class="row margin-res">
                                            <?php echo $xhtmlBook; ?>
                                        </div>
                                    </div>
                                    <?php require_once 'elements/pagination.php' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>