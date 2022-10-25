<?php

@$catID = $this->arrParams['category_id'];
$url = $_SERVER['REQUEST_URI'];
$urlCurrent = pathinfo($url, PATHINFO_BASENAME);
$urlName = explode(".", $urlCurrent);
$categoryName = substr($urlName[0], 0, -2);

$total = $this->totalItemsPerPage;
$search = @$this->arrParams['search'];

if(!empty($search)){
    $linkBook = null;
    $total = null;
} 
if (isset($catID)) {
    $linkBook   = URL::createLink('default', 'book', 'list', ['category_id' => $catID], "$categoryName-$catID.html");
}
else {
    $linkBook   = URL::createLink('default', 'book', 'list', null, "sach");
}

?>
<div class="product-pagination">
    <div class="theme-paggination-block">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <nav aria-label="Page navigation">
                        <nav>
                            <?= $this->pagination->showPaginationPublic($linkBook); ?>
                        </nav>
                    </nav>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="product-search-count-bottom">
                        <h5><?php echo $total ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>