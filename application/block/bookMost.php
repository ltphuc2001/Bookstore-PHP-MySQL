<?php
$xhtmlBookSpecial = '';
$classPrice = '';
$classSaleOff = '';

if (count($this->bookSpecial)) {

    foreach ($this->bookSpecial as $key => $item) {
        $id                = $item['id'];
        $saleOff           = $item['sale_off'];
        $price             = $item['price'];
        $name              = $item['name'];
        $category_id       = $item['category_id'];
        $category_name     = $item['category_name'];


        $bookNameURL       = URL::filterURL($name);
        $catNameURL        = URL::filterURL($category_name);
        $link              = URL::createLink('default', 'book', 'item', ['category_id' => $item['category_id'], 'book_id' => $id], "$catNameURL/$bookNameURL-$category_id-$id.html");

        $description       = $item['description'];
        $picture           = IMG_DEFAULT_BOOK_PATH . $item['picture'];

        if ($saleOff > 0) {
            $classPrice = '
                            <h4 class="text-lowercase">' . number_format((100 - $saleOff) * $price / 100) . ' đ <del>' . number_format($price) . ' đ</del></h4>
                           
            ';
        } else {
            $classPrice = '                   
                            <h4 class="text-lowercase">' . number_format($price) . ' đ </h4>
            ';
        }

        $xhtmlBookSpecial .= '<div class="media">
        <a href="' . $link . '">
            <img class="img-fluid blur-up lazyload resize-img-specialBookList" src="' . $picture . '" alt="' . $name . '"></a>
        <div class="media-body align-self-center" style="padding-left: 13px">
            <a href="' . $link . '" title="' . $name . '">
                <h6>' . $name . '</h6>
            </a>
           ' . $classPrice . '
        </div>
    </div>';
    }
}
?>

<div class="theme-card">
    <h5 class="title-border">Sách nổi bật</h5>
    <div class="">
        <div>
            <?php echo $xhtmlBookSpecial ?>
        </div>
    </div>
</div>