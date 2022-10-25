<?php

$cart = Session::get('cart');
$classPrice = '';
//SPECIAL BOOKS
$xhtmlSpecialBook = '';

if (count($this->specialBooks)) {
	foreach ($this->specialBooks as $key => $item) {
		$id                = $item['id'];
		$saleOff           = $item['sale_off'];
		$price             = $item['price'];
		$name              = $item['name'];


		$category_id              = $item['category_id'];
		$category_name            = $item['category_name'];
		$bookNameURL           	  = URL::filterURL($name);
		$catNameURL           	  = URL::filterURL($category_name);

		$link                     = URL::createLink('default', 'book', 'item', ['category_id' => $item['category_id'], 'book_id' => $id], "$catNameURL/$bookNameURL-$category_id-$id.html");

		//ADD CART
		$addCartItem              = 'javascript:addCartItem(\'' . $item['id'] . '\', \'' .number_format((100 - $saleOff) * $price / 100) . '\')';

		$description       = $item['description'];
		$picture           =  IMG_DEFAULT_BOOK_PATH .  $item['picture'];

		$linkOrder  = URL::createLink('default', 'user', 'order', ['book_id' => $id, 'price' => number_format((100 - $saleOff) * $price / 100)]);

		if ($item['sale_off'] > 0) {
			$classPrice = '
					<h4 class="text-lowercase">' . number_format((100 - $saleOff) * $price / 100) . ' đ <del>' . $price . ' đ</del></h4>
                   
    				';
			$linkOrder  = URL::createLink('default', 'user', 'order', ['book_id' => $id, 'price' => number_format((100 - $saleOff) * $price / 100)]);
		} else {
			$classPrice = '<h4 class="text-lowercase">' . number_format($price) . ' đ</h4>';
			$linkOrder  = URL::createLink('default', 'user', 'order', ['book_id' => $id, 'price' => number_format((100 - $saleOff) * $price / 100)]);
		}


		$xhtmlSpecialBook .= '
		<div class="slick-slide" data-slick-index="0" aria-hidden="true" style="width: 350px;" tabindex="-1"><div><div class="product-box" style="width: 100%; ">
                            <div class="img-wrapper">
                                <div class="lable-block">
                                    <span class="lable4 badge badge-danger"> -' . $saleOff . '%</span>
                                </div>
                                <div class="front">
                                    <a href="' . $link . '" class="blur-up lazyloaded">
                                        <img src="' . $picture . '" class="img-fluid blur-up lazyload resize-img-specialBook" alt="product" >
                                    </a>
                                </div>
                                <div class="cart-info cart-wrap">
                                    <a href="' . $addCartItem . '" title="Add to cart" tabindex="-1"><i class="ti-shopping-cart"></i></a>
                                    
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
                                <a href="item.html" title="' . $name . '" >
                                    <h6>' . $name . '</h6>
                                </a>
                                ' . $classPrice . '
                            </div>
                        </div></div></div>
		';
	}
}

//CATEGORY MOST BOOK

$xhtmlCategoryMost = '';



?>
<?php require_once 'elements/HomeSlider.php' ?>

<div class="title1 section-t-space title5">
	<h2 class="title-inner1">Sản phẩm nổi bật</h2>
	<hr role="tournament6">
</div>
<section class="section-b-space p-t-0 j-box ratio_asos">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="product-4 product-m no-arrow slick-initialized slick-slider">
					<div class="slick-list draggable">
						<div class="slick-track">
							<?php echo $xhtmlSpecialBook; ?>
						</div>

					</div>
				</div>
			</div>
		</div>
</section>
<!-- Product slider end -->
<!-- Top Collection end-->

<!-- service layout -->
<?php require_once 'elements/Service.php' ?>
<!-- service layout  end -->

<!-- Tab product -->

<?php require_once BLOCK_PATH . 'collectionMost.php' ?>
<!-- Tab product end -->
<!-- Quick-view modal popup start-->
<div class="modal fade bd-example-modal-lg theme-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content quick-view-modal">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
				<div class="row">
					<div class="col-lg-6 col-xs-12">
						<div class="quick-view-img"><img src="<?php echo $this->_dirImg ?>quick-view-bg.jpg" alt="" class="w-100 img-fluid blur-up lazyload book-picture"></div>
					</div>
					<div class="col-lg-6 rtl-text">
						<div class="product-right">
							<h2 class="book-name">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores,
								distinctio.</h2>
							<h3 class="book-price">26.910 ₫ <del>39.000 ₫</del></h3>
							<div class="border-product">
								<div class="book-description">Lorem ipsum dolor sit amet consectetur, adipisicing
									elit. Unde quae cupiditate delectus laudantium odio molestiae deleniti facilis
									itaque ut vero architecto nulla officiis in nam qui, doloremque iste. Incidunt,
									in?</div>
							</div>
							<div class="product-description border-product">
								<h6 class="product-title">Số lượng</h6>
								<div class="qty-box">
									<div class="input-group">
										<span class="input-group-prepend">
											<button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
												<i class="ti-angle-left"></i>
											</button>
										</span>
										<input type="text" name="quantity" class="form-control input-number" value="1">
										<span class="input-group-prepend">
											<button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
												<i class="ti-angle-right"></i>
											</button>
										</span>
									</div>
								</div>
							</div>
							<div class="product-buttons">
								<a href="#" class="btn btn-solid mb-1 btn-add-to-cart">Chọn Mua</a>
								<a href="item.html" class="btn btn-solid mb-1 btn-view-book-detail">Xem chi tiết</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Quick-view modal popup end-->