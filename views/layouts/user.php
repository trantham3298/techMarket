<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/css/fontawesome/css/all.css" rel="stylesheet" type="text/css" />
    <link href="/css/bootstrap-4.0.0/bootstrap-4.0.0/dist/css/bootstrap-grid.css" rel="stylesheet" type="text/css" />
    <link href="/css/bootstrap-4.0.0/bootstrap-4.0.0/dist/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/css/bootstrap-4.0.0/bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/common/until.css" rel="stylesheet" type="text/css" />
    <link href="/css/common/main.css" rel="stylesheet" type="text/css" />
    <link href="/css/common/header.css" rel="stylesheet" type="text/css" />
    <link href="/css/common/footer.css" rel="stylesheet" type="text/css" />
    <link href="/css/common/banner.css" rel="stylesheet" type="text/css" />
    <link href="/css/pages/home.css" rel="stylesheet" type="text/css" />
    <link href="/css/pages/list.css" rel="stylesheet" type="text/css" />
    <link href="/css/pages/detail.css" rel="stylesheet" type="text/css" />
    <link href="/css/pages/cart.css" rel="stylesheet" type="text/css" />
    <link href="/css/pages/about.css" rel="stylesheet" type="text/css" />
    <link href="/css/pages/contact.css" rel="stylesheet" type="text/css" />
    <link href="/css/pages/checkout.css" rel="stylesheet" type="text/css" />
    <link href="/css/pages/profile.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    
    <title><?= $this->title ?? 'TECHOFTTVV' ?></title>
</head>

<body>
    <header class="header">
        <div class="container-fluid ">
            <div class="row header-layout">
                <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 logo-primary-responsive">
                    <button style="margin-right: 15px; display: none;" class="header-nav-btn-primary button-recommend-primary header-nav-btn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <a href="/" class="logo">TechOfTTVV</a>
                    <i style="display: none;" class="fas fa-shopping-basket cart-btn-responsive view-cart-btn"></i>
                    <span style="display: none;" class="cart-quanti-primary-responsive show-cart-quantity"><?= $_SESSION['amount'] ?? '0' ?></span>
                </div>
                <div class="col-12 col-sm-6 col-md-7 col-lg-6 col-xl-4 col-search-responsive">
                    <nav class="header-nav">
                        <select form="searchProduct" name="category">
                            <option value="">Danh m???c</option>
                            <?php foreach (\app\controllers\MainController::$ctrl->allCategory() as $category) : ?>
                                <option value="<?= $category->id ?>"><?= $category->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <!-- <h3 class="header-nav-category header-menu-toggle-btn">
                            Danh M???c
                            <i style="margin-left: 15px;" class="fas fa-angle-down header-cate-icon"></i>
                            <i style="margin-left: 15px; display: none;" class="fas fa-angle-up header-cate-icon"></i>
                        </h3> -->
                        <!-- <div class="menu" id="scrollbar-primary">
                            <ul class="toggle-menu">
                                <li class="menu-item"><a href="#">S???n ph???m n???i b???t nh???t</a></li>
                                <li class="menu-item"><a href="#">S???n ph???m b??n ch???y nh???t</a></li>
                                    <li class="menu-item">
                                        <label for="category"><?php echo $category->category_name ?></label>
                                    </li>
                            </ul>
                        </div> -->
                    </nav>
                    <form class="header-search-form form" action="/search-product" id="searchProduct" method="POST">
                        <span class="header-nav-border"></span>
                        <input type="text" placeholder="Tra c???u s???n ph???m t???i ????y" name="search" />
                        <button class="header-search-form-btn-primary btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-12 col-sm-6 col-md-5 col-lg-3 col-xl-5">
                    <div style="display: flex; justify-content: space-around;" class="header-action-responsive">
                        <?php if (\app\controllers\MainController::$ctrl->auth->isLoggedIn()) : ?>
                            <div class="header-action box-action login-responsive-primary" href="#">
                                <i style="margin-right: 10px;" class="far fa-user"></i>

                                <div class="login-responsive-primary">
                                    <a href="/profile" class="color-white"><?php echo \app\controllers\MainController::$ctrl->auth->getUser()->username ?></a>
                                    <!-- <span class="color">T??i kho???n</span> -->
                                    <a href="/logout">????ng xu???t</a>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="header-action box-action login-responsive-primary" href="#">
                                <i style="margin-right: 10px;" class="far fa-user"></i>
                                <div>
                                    <a href="/login" class="color">????ng nh???p</a>
                                    <a href="/register" class="color-white">T???o t??i kho???n</a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <a class="header-action box-action" href="#">
                            <i style="margin-right: 10px;" class="far fa-heart"></i>
                            <div class="login-responsive-primary">
                                <span class="color">S???n ph???m y??u th??ch</span>
                                <span class="color-white">Danh s??ch</span>
                            </div>
                        </a>
                        <div class="header-action box-action view-cart-btn">
                            <i style="margin-right: 10px;" class="fas fa-shopping-basket"></i>
                            <span class="cart-quanti-primary show-cart-quantity"><?= $_SESSION['amount'] ?? '0' ?></span>
                            <div class="login-responsive-primary">
                                <span class="color">Gi??? h??ng</span>
                                <span class="color-white show-cart-subtotal"><?= (isset($_SESSION['subtotal'])) ? number_format($_SESSION['subtotal'], 0, ',', '.') : '0' ?>??</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-layout">
                <aside class="menu-layout-nav">
                    <div class="close-menu-btn-primary close-menu-btn">
                        <h3>????ng</h3>
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="menu-layout-main">
                        <nav class="main-menu-items main-menu-items-toggle-btn">
                            <h4 class="menu-title-btn">Danh m???c</h4>
                            <ul id="menu-items">
                                <li>
                                    <a href="/">Trang ch???</a>
                                </li>
                                <li>
                                    <a href="/product-list">S???n ph???m</a>
                                </li>
                                <li>
                                    <a href="/about">V??? ch??ng t??i</a>
                                </li>
                                <li>
                                    <a href="/contact">Li??n h???</a>
                                </li>
                                <?php if (\app\controllers\MainController::$ctrl->auth->isLoggedIn()) : ?>
                                    <li>
                                        <a href="#">T??i kho???n c???a t??i</a>
                                    </li>
                                    <li>
                                        <a href="/logout">
                                            ????ng xu???t
                                            <i style="margin-left: 5px;" class="fas fa-power-off"></i>
                                        </a>
                                    </li>
                                <?php else : ?>
                                    <li>
                                        <a href="/login">
                                            ????ng nh???p
                                            <!-- <i style="margin-left: 5px;" class="fas fa-power-off"></i> -->
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <nav class="main-cate-items main-cate-items-toggle-btn">
                            <h4 class="cate-title-btn">Danh m???c s???n ph???m</h4>
                            <ul id="cate-items">
                                <li><a href="/new-product-list">S???n ph???m m???i nh???t</a></li>
                                <li><a href="/top-product-list">S???n ph???m b??n ch???y nh???t</a></li>
                                <?php foreach (\app\controllers\MainController::$ctrl->allCategory() as $category) : ?>
                                    <li><a href="/product-list?category=<?= $category->id ?>"><?= $category->category_name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </nav>
                    </div>
                </aside>
            </div>
        </div>
        <div class="cart-layout">
            <aside class="cart-layout-nav">
                <div class="cart-layout-title">
                    <h3>Gi??? h??ng</h3>
                    <i class="fas fa-times my-cart-icon close-my-cart-btn" data-toggle="tooltip" data-placement="left" title="????ng"></i>
                </div>
                <div class="clear"></div>
                <div class="show-cart-aside">
                    <?php if (!empty($_SESSION['cart'])) : ?>
                        <nav class="cart-layout-items">
                            <ul>
                                <?php foreach ($_SESSION['cart'] as $product) : ?>
                                    <li class="cart-items row">
                                        <div class="col-3 cart-items-img">
                                            <a href="#">
                                                <img src="/img/products/<?= $product['image'] ?>" alt="" />
                                            </a>
                                        </div>
                                        <div class="col-7 cart-items-infor">
                                            <a href="/product-detail?id=<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a>
                                            <span class="cart-items-infor-price"><?= $product['discount_price'] != 0 ? number_format($product['discount_price'], 0, ',', '.') :  number_format($product['list_price'], 0, ',', '.')  ?>??</span>
                                            <span class="cart-items-infor-quanti"> x <?= $product['quantity'] ?></span>
                                        </div>
                                        <div class="col-2 cart-items-action">
                                            <!-- <a href="/cart?delete_id=<?= $product['product_id'] ?>"  data-toggle="tooltip" data-placement="top" title="X??a" class="fas fa-times"></a> -->
                                            <a title="delete" class="delete-product-cart" data-id="<?= $product['product_id'] ?>">
                                                <i class="fas fa-times"></i>
                                            </a>
                                            <a href="/product-detail?id=<?= $product['product_id'] ?>">
                                                <i data-toggle="tooltip" data-placement="bottom" title="Chi ti???t s???n ph???m" class="far fa-eye"></i>
                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                                <li class="text-center">
                                    <span style="float: left;">T???ng ????n h??ng:</span>
                                    <span style="float: right; color: balck; font-weight: bold;" class="show-cart-subtotal">
                                        <?= (isset($_SESSION['subtotal'])) ? number_format($_SESSION['subtotal'], 0, ',', '.') : '0' ?>??</span>
                                    <div class="clear"></div>
                                    <!-- <button class="button-border-primary view-cart-detail-btn"> -->
                                        <a href="/cart" class="button-border-primary view-cart-detail-btn" style="color: black;">XEM GI??? H??NG</a>
                                    <!-- </button> -->
                                    <!-- <button class="button-submit-primary view-checkout-btn"> -->
                                        <a href="/checkout" class="button-submit-primary view-checkout-btn">TI???N H??NG THANH TO??N</a>
                                    <!-- </button> -->
                                </li>
                            </ul>
                        </nav>
                    <?php else : ?>
                        <div class="cart-layout-empty">
                            <i class="fas fa-shopping-basket"></i>
                            <p>Gi??? h??ng ch??a c?? s???n ph???m n??o</p>
                            <a href="/product-list" class="button-submit-primary close-my-cart-btn">Th??m s???n ph???m</a>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
        <hr style="background: rgba(255,255,255,.15); width: 95%; margin: 0 auto;">
        <div class="row header-layout-department">
            <div class="col-12 col-sm-12 col-md-3" style="padding-right: 0">
                <div class="header-nav-department">
                    <h3 class="header-nav-department-toggle-primary header-nav-department-toggle-btn">
                        <i style="margin-right: 5px; display: none;" class="fas fa-times department-icon"></i>
                        <i style="margin-right: 5px;" class="fas fa-bars department-icon"></i>
                        Danh M???c
                    </h3>
                    <nav class="menu-department">
                        <ul class="toggle-menu-department">
                            <li class="menu-item-department"><a href="/new-product-list">S???n ph???m m???i nh???t</a></li>
                            <li class="menu-item-department"><a href="/top-product-list">S???n ph???m b??n ch???y nh???t</a></li>
                            <?php foreach (\app\controllers\MainController::$ctrl->allCategory() as $category) : ?>
                                <li class="menu-item-department"><a href="/product-list?category=<?= $category->id ?>"><?= $category->category_name ?></a></li>
                            <?php endforeach; ?>

                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6" style="padding-left: 0;">
                <nav class="header-pages-nav">
                    <ul class="row">
                        <li class="col-12 col-md-3">
                            <a href="/">Trang ch???</a>
                        </li>
                        <li class="col-12 col-md-3">
                            <a href="/product-list">S???n ph???m</a>
                        </li>
                        <li class="col-12 col-md-3">
                            <a href="/about">v??? ch??ng t??i</a>
                        </li>
                        <li class="col-12 col-md-3">
                            <a href="/contact">li??n h???</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-12 col-sm-6 col-md-3 header-freeship">
                <span>Mi???n ph?? giao h??ng cho ????n 500.000??</span>
                <!-- <a href="#" data-toggle="tool-tip" data-placement="top" title="Log out" class="logout-btn-primary" style="">
                    <i class="fas fa-power-off"></i>
                </a> -->
            </div>
        </div>
    </header>

    <main>
        {{content}}
    </main>

    <footer>
        <div class="row" style="padding-bottom: 40px;">
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 support-box">
                <div class="footer-top-service">
                    <i class="fas fa-shipping-fast"></i>
                    <div class="box-detail">
                        <p>GIAO H??NG MI???N PH??</p>
                        <p class="color">?????i v???i c??c ????n ?????t h??ng tr??n 500.000??</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 support-box ">
                <div class="footer-top-service">
                    <i class="far fa-credit-card"></i>
                    <div class="box-detail">
                        <p>THANH TO??N AN TO??N</p>
                        <p class="color">An to??n tuy???t ?????i</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 support-box ">
                <div class="footer-top-service">
                    <i class="fas fa-headset"></i>
                    <div class="box-detail">
                        <p>H??? TR??? 24/7</p>
                        <p class="color">24/7 Ch??m s??c kh??ch h??ng</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 support-box">
                <div class="footer-top-service">
                    <i class="fas fa-hand-holding-usd"></i>
                    <div class="box-detail">
                        <p>HO??N TI???N</p>
                        <p class="color">N???u c?? v???n ?????</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row footer-layout">
                <div class="col-12 col-md-12 order-lg-1 col-lg-6 order-xl-1 col-xl-3">
                    <div class="footer-responsive app-btn-toggle fixed-toggle-primary">
                        <div class="footer-content-responsive footer-content-app">
                            <h4 class="footer-title footer-content-title-responsive">Tech Of TTVV</h4>
                            <i class="fas fa-chevron-down down-icon-footer footer-icon footer-icon-app"></i>
                            <i class="fas fa-chevron-up footer-icon footer-icon-app"></i>
                        </div>
                        <nav class="menu-app-link fixed-toggle-primary-content">
                            <div class="clear"></div>
                            <p class="content-responsive" style="color: #999;">
                                Website b??n s???n ph???m c??ng ngh??? uy t??n s??? 1 Vi???t Nam
                            </p>
                            <ul class="social-links">
                                <li>
                                    <a href="https://www.facebook.com/nguyenluuphivu" title="facebook"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/Thm74455834" title="twitter"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/" title="instagram"><i class="fab fa-instagram"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-12 col-md-12 order-lg-12 col-lg-12 order-xl-2 col-xl-6">
                    <div class="row">
                        <nav class="col-12 col-md-12 col-lg-4 footer-services">
                            <div class="footer-responsive customer-toggle-primary fixed-toggle-primary">
                                <div class="footer-content-responsive footer-content-customer">
                                    <h4 class="footer-title">Danh m???c s???n ph???m</h4>
                                    <i class="fas fa-chevron-down down-icon-footer footer-icon footer-icon-customer"></i>
                                    <i class="fas fa-chevron-up footer-icon footer-icon-customer"></i>
                                </div>
                                <ul class="footer-content footer-content-customers fixed-toggle-primary-content">
                                    <li><a href="/product-list?category=1">??i???n tho???i di ?????ng</a></li>
                                    <li><a href="/product-list?category=2">Latop</a></li>
                                    <li><a href="/product-list?category=3">M??y ???nh</a></li>
                                    <li><a href="/product-list?category=4">Tai nghe</a></li>
                                    <li><a href="/product-list?category=5">Ph??? ki???n</a></li>
                                </ul>
                            </div>
                        </nav>
                        <nav class="col-12 col-md-12 col-lg-4 footer-services">
                            <div class="footer-responsive customer-helper-toggle-primary fixed-toggle-primary">
                                <div class="footer-content-responsive footer-content-customer-helper">
                                    <h4 class="footer-title">Ch??m s??c kh??ch h??ng</h4>
                                    <i class="fas fa-chevron-down down-icon-footer footer-icon footer-icon-customer-helper"></i>
                                    <i class="fas fa-chevron-up footer-icon footer-icon-customer-helper"></i>
                                </div>
                                <ul class="footer-content footer-content-customers-helper fixed-toggle-primary-content">
                                    <li><a href="/contact">Li??n h??? v???i ch??ng t??i</a></li>
                                    <li><a href="/about">V??? ch??ng t??i</a></li>
                                </ul>
                            </div>
                        </nav>
                        <nav class="col-12 col-md-12 col-lg-4 footer-services">
                            <div class="footer-responsive customer-account-toggle-primary fixed-toggle-primary">
                                <div class="footer-content-responsive footer-content-customer-account">
                                    <h4 class="footer-title">T??i kho???n</h4>
                                    <i class="fas fa-chevron-down down-icon-footer footer-icon footer-icon-customer-account"></i>
                                    <i class="fas fa-chevron-up footer-icon footer-icon-customer-account"></i>
                                </div>
                                <ul class="footer-content footer-content-customers-account fixed-toggle-primary-content">
                                    <li><a href="/profile">Trang c?? nh??n</a></li>
                                    <li><a href="/login">????ng nh???p</a></li>
                                    <li><a href="/register">????ng k??</a></li>
                                    <li><a href="/change-password">?????i m???t kh???u</a></li>
                                    <li><a href="/forgot-password">Qu??n m???t kh???u?</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="col-12 col-md-12 order-lg-2 col-lg-6 order-xl-3 col-xl-3 send-mail-footer">
                    <div class="footer-responsive fixed-toggle-primary">
                        <div class="footer-content-responsive newsletter-btn-toggle footer-content-newsletter">
                            <h4 class="footer-title">????ng k?? nh???n b???n tin</h4>
                            <i class="fas fa-chevron-down down-icon-footer footer-icon footer-icon-newsletter"></i>
                            <i class="fas fa-chevron-up footer-icon footer-icon-newsletter"></i>
                        </div>
                        <div class="menu-newsletter fixed-toggle-primary-content">
                            <p class="join-title">
                                Tham gia c??ng h??n 60.000 ng?????i ????ng k?? v?? nh???n ???????c m???t phi???u gi???m gi?? m???i cho m???i
                                Ng??y th??? b???y.
                            </p>
                            <form action="/" class="newsletter form" method="post">
                                <input type="email" placeholder="Nh???p ?????a ch??? Email" name="email" />
                                <button><i class="far fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="push-up-btn-primary">
            <i class="fas fa-angle-double-up"></i>
        </div>
    </footer>
    <script src="/js/common/jquery.js" type="text/javascript"></script>
    <script src="/js/jquery.lazy-master/jquery.lazy.js" type="text/javascript"></script>
    <script src="/css/bootstrap-4.0.0/bootstrap-4.0.0/js/dist/popper.min.js" type="text/javascript"></script>
    <script src="/css/bootstrap-4.0.0/bootstrap-4.0.0/js/dist/util.js" type="text/javascript"></script>
    <script src="/css/bootstrap-4.0.0/bootstrap-4.0.0/js/dist/modal.js" type="text/javascript"></script>
    <script src="/css/bootstrap-4.0.0/bootstrap-4.0.0/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/css/bootstrap-4.0.0/bootstrap-4.0.0/js/dist/tooltip.js" type="text/javascript"></script>
    <script src="/css/bootstrap-4.0.0/bootstrap-4.0.0/dist/js/bootstrap.js" type="text/javascript"></script>
    <script src="/js/common/footer.js" type="text/javascript"></script>
    <script src="/js/common/header.js" type="text/javascript"></script>
    <script src="/js/pages/main.js" type="text/javascript"></script>
    <script src="/js/pages/home.js" type="text/javascript"></script>
    <script src="/js/pages/product-list.js" type="text/javascript"></script>
    <script src="/js/pages/detail.js" type="text/javascript"></script>
    <script src="/js/pages/cart.js" type="text/javascript"></script>
    <script src="/js/pages/checkout.js" type="text/javascript"></script>
    <script src="/js/pages/about.js" type="text/javascript"></script>
    <script src="/js/pages/contact.js" type="text/javascript"></script>
    <script src="/js/pages/profile.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/api/cart.js" type="text/javascript"></script>
    
    <script src="/js/common/validate.js" type="text/javascript"></script>
    <script src="/js/api/form.js" type="text/javascript"></script>

</body>

</html>