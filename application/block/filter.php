<?php

    $arrFilterSort = ['default' => '-- Sắp xếp --', 'priceASC' => 'Giá tăng dần', 'priceDESC' => 'Giá giảm dần', 'latest' => 'Mới nhất'];
    $xhtmlSortForm = HelperDefault::sortForm($arrFilterSort, @$this->arrParams['sort'] ?? 'default');
?>


<div class="product-top-filter">
    <div class="row">
        <div class="col-xl-12">
            <div class="filter-main-btn">
                <span class="filter-btn btn btn-theme"><i class="fa fa-filter" aria-hidden="true"></i> Filter</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="product-filter-content">
                <div class="collection-view">               
                </div>              
                <div class="product-page-filter">
                    <?php echo $xhtmlSortForm; ?>
                </div>
            </div>
        </div>
    </div>
</div>