<?php

$cateID = @$this->arrParams['category_id'];
$model = new Model();
$query = "SELECT `id`, `name` FROM `category` WHERE `status` = 'active' ORDER BY `ordering` ASC";
$listCategory = $model->listRecord($query);


$xhtml = '';
if (!empty($listCategory)) {
    foreach ($listCategory as $key => $value) {
        $id                = $value['id'];
        $name              = $value['name'];
        $nameURL           = URL::filterURL($name);
        $link              = URL::createLink('default', 'book', 'list', ['category_id' => $id], "$nameURL-$id.html");
        if ($cateID == $value['id']) {
            $xhtml             .= ' <div class="collection-brand-filter">
                                        <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 category-item">
                                            <a class="my-text-primary" href="' . $link . '">' . $name . '</a>
                                        </div>           
                                    </div>';
        } else {
            $xhtml             .= ' <div class="collection-brand-filter">
                                        <div class="custom-control custom-checkbox collection-filter-checkbox pl-0 category-item">
                                            <a class="" href="' . $link . '">' . $name . '</a>
                                        </div>           
                                    </div>';
        }
    }
}


?>

<div class="collection-filter-block">
    <!-- brand filter start -->
    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
    <div class="collection-collapse-block open">
        <h3 class="collapse-block-title">Danh mục</h3>
        <div class="collection-collapse-block-content">
            <?php echo $xhtml ?>
        </div>
    </div>
</div>