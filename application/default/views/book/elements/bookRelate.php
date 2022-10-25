<?php 

$xhtmlBookRelate = '';
$classPrice = '';
$classSaleOff = '';


if (count($this->bookRelate)) {
    foreach ($this->bookRelate as $key => $item) {
        $id                = $item['id'];
        $saleOff           = $item['sale_off'];
        $price             = $item['price'];
        $category_id       = $item['category_id'];
        $category_name     = $item['category_name'];
       
        $name              = $item['name'];
        $description       = $item['description'];
        $picture           = IMG_DEFAULT_BOOK_PATH . $item['picture'];
        $bookNameURL       = URL::filterURL($name);
        $catNameURL        = URL::filterURL($category_name);

        $addCart              = 'javascript:addCart(\'' . $item['id'] . '\', \'' .number_format((100 - $saleOff) * $price / 100) . '\')';
        $link              = URL::createLink('default', 'book', 'item', ['category_id' => $this->bookInfo['category_id'], 'book_id' => $id], "$catNameURL/$bookNameURL-$category_id-$id.html");


        if($saleOff > 0){
            $classPrice = '
                            <h4 class="text-lowercase">'.number_format((100-$saleOff)*$price/100).' đ <del>'.number_format($price).' đ</del></h4>
                           
            ';

            $classSaleOff = '
                    <div class="lable-block">
                        <span class="lable4 badge badge-danger"> -'.$saleOff.'%</span>
                    </div>
            ';

        }else{
            $classPrice = '                   
                            <h4 class="text-lowercase">'.number_format($price).' đ </h4>
            ';

            $classSaleOff = '';
        }

        

        $xhtmlBookRelate .= '<div class="col-xl-2 col-md-4 col-sm-6">
        <div class="product-box">
            <div class="img-wrapper">
                '.$classSaleOff.'
                <div class="front">
                    <a href="'.$link.'" class="blur-up lazyloaded" >
                        <img src="'.$picture.'" class="img-fluid blur-up lazyload resize-img-bookRelate " >
                    </a>
                </div>
                <div class="cart-info cart-wrap">
                    <a href="'.$addCart.'" title="Add to cart"><i class="ti-shopping-cart"></i></a>
                    <a id="single_image" href="'.$picture.'" title="Quick View"><i class="ti-search" data-toggle="modal" data-target="#quick-view"></i></a>
                </div>
            </div>
            <div class="product-detail">
                <a href="item.html" title="'.$name.'">
                    <h6>'.$name.'</h6>
                </a>
               '.$classPrice.'
            </div>
        </div>

    </div>';
    }
}

?>

<div class="row search-product">
    <?php echo $xhtmlBookRelate ?>
</div>