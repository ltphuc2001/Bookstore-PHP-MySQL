<?php
$linkCategory =  URL::createLink('default', 'book', 'list', ['category_id' => 2], "kinh-te-2.html");
?>

<div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
    <div class="phonering-alo-ph-circle"></div>
    <div class="phonering-alo-ph-circle-fill"></div>
    <a href="tel:0905744470" class="pps-btn-img" title="Liên hệ">
        <div class="phonering-alo-ph-img-circle"></div>
    </a>
</div>

<footer class="footer-light mt-5">
    <section class="section-b-space light-layout">
        <div class="container">
            <div class="row footer-theme partition-f">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-title footer-mobile-title">
                        <h4>Giới thiệu</h4>
                    </div>
                    <div class="footer-contant">
                        <div class="footer-logo">
                            <h2 style="color: #5fcbc4">BookStore</h2>
                        </div>
                        <p>Tự hào là website bán sách trực tuyến lớn nhất Việt Nam, cung cấp đầy đủ các thể loại
                            sách, đặc biệt với những đầu sách độc quyền trong nước và quốc tế</p>
                    </div>
                </div>
                <div class="col offset-xl-1">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Danh mục nổi bật</h4>
                        </div>
                        <div class="footer-contant">
                            <ul>
                                <li><a href="<?php echo $linkCategory ?> ">Kinh Tế</a></li>                              
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Chính sách</h4>
                        </div>
                        <div class="footer-contant">
                            <ul>
                                <li><a href="#">Điều khoản sử dụng</a></li>
                                <li><a href="#">Chính sách bảo mật</a></li>
                                <li><a href="#">Hợp tác phát hành</a></li>
                                <li><a href="#">Phương thức vận chuyển</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="sub-title">
                        <div class="footer-title">
                            <h4>Thông tin</h4>
                        </div>
                        <div class="footer-contant">
                            <ul class="contact-list">
                                <li><i class="fa fa-phone"></i>Hotline: <a href="tel:0905744470">0829 069 600</a></li>
                                <li><i class="fa fa-envelope-o"></i>Email: <a href="" class="text-lowercase">ltphuc142001@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="sub-footer">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="footer-end">
                        <p><i class="fa fa-copyright" aria-hidden="true"></i> 2020 ZendVN</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer> <!-- footer end -->

<!-- tap to top -->
<div class="tap-top top-cls">
    <div>
        <i class="fa fa-angle-double-up"></i>
    </div>
</div>