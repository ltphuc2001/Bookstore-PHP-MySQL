<?php
    $linkCategory   = URL::createLink('default', 'category', 'index', null, 'danh-muc.html');
?>
<div class="product-pagination">
    <div class="theme-paggination-block">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <nav aria-label="Page navigation">
                        <nav>
                        <?= $this->pagination->showPaginationPublic($linkCategory); ?>
                        </nav>
                    </nav>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="product-search-count-bottom">
                        <h5><?php echo $this->totalItemsPerPage ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
