<?php
$xhtml = '';

if (count($this->items)) {
    foreach ($this->items as $key => $item) {
        $id                = $item['id'];
        $name              = $item['name'];
        $nameURL           = URL::filterURL($name);
        $link              = URL::createLink('default', 'book', 'list', ['category_id' => $id], "$nameURL-$id.html");
       
        $picture           = IMG_DEFAULT_CATEGORY_PATH . $item['picture'] ;

        $xhtml .= '
        <div class="product-box">
            <div class="img-wrapper">
                <div class="front">
                    <a href="'.$link.'"><img src="'.$picture.'" class="img-fluid blur-up lazyload resize-img-category" alt=""></a>
                </div>
            </div>
            <div class="product-detail">
                <a href="list.html"><h4>' . $name . '</h4></a>
            </div>
        </div>
        ';
    }
}

?>

<?php require_once 'elements/breadcrumb.php' ?>
<section class="ratio_asos j-box pets-box section-b-space" id="category">
    <div class="container">
        <div class="no-slider five-product row">
           <?php echo $xhtml; ?>
        </div>

        <?php require_once 'elements/pagination.php' ?>
    </div>
</section>