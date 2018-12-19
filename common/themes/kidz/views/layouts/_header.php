<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<!-- ====================================
    ——— HEADER
    ===================================== -->
<header id="pageTop" class="header-wrapper">
    <!-- COLOR BAR -->
    <div class="container-fluid color-bar top-fixed clearfix">
        <div class="row">
            <div class="col-sm-1 col-xs-2 bg-color-1">fix bar</div>
            <div class="col-sm-1 col-xs-2 bg-color-2">fix bar</div>
            <div class="col-sm-1 col-xs-2 bg-color-3">fix bar</div>
            <div class="col-sm-1 col-xs-2 bg-color-4">fix bar</div>
            <div class="col-sm-1 col-xs-2 bg-color-5">fix bar</div>
            <div class="col-sm-1 col-xs-2 bg-color-6">fix bar</div>
            <div class="col-sm-1 bg-color-1 hidden-xs">fix bar</div>
            <div class="col-sm-1 bg-color-2 hidden-xs">fix bar</div>
            <div class="col-sm-1 bg-color-3 hidden-xs">fix bar</div>
            <div class="col-sm-1 bg-color-4 hidden-xs">fix bar</div>
            <div class="col-sm-1 bg-color-5 hidden-xs">fix bar</div>
            <div class="col-sm-1 bg-color-6 hidden-xs">fix bar</div>
        </div>
    </div>

    <!-- TOP INFO BAR -->
    <div class="top-info-bar bg-color-7 hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <ul class="list-inline topList">
                        <li><i class="fa fa-envelope bg-color-1" aria-hidden="true"></i> <a
                                    href="mailto:santipabprint@gmail.com">santipabprint@gmail.com</a></li>
                        <li><i class="fa fa-phone bg-color-2" aria-hidden="true"></i> 053-241-519</li>
                        <li class="hidden-md hidden-xs hidden-sm"><i class="fa fa-clock-o bg-color-6" aria-hidden="true"></i> เวลาทำการ: 09:00 - 16:00 น.</li>
                    </ul>
                </div>
                <div class="col-sm-5">
                    <ul class="list-inline functionList">
                        <li class="">
                            <?= \lajax\languagepicker\widgets\LanguagePicker::widget([
                                'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_DROPDOWN,
                                'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE
                            ]); ?>
                            &nbsp;
                        </li>
                        <li>
                            <?php if (Yii::$app->user->isGuest): ?>
                                <i class="fa fa-lock bg-color-5" aria-hidden="true"></i>
                                <?= Html::a('Login', ['/auth/login'], ['role' => 'modal-remote']); ?>
                                <span>or</span>
                                <?= Html::a('Register', ['/user/registration/register'], ['role' => 'modal-remote']); ?>
                            <?php else: ?>
                                <i class="fa fa-unlock-alt bg-color-5" aria-hidden="true"></i>
                                <?= Html::a('Logout ' . '(' . Yii::$app->user->identity->username . ')', ['/auth/logout'], ['data-method' => 'post']); ?>
                            <?php endif; ?>
                        </li>
                        <li class="cart-dropdown">
                            <a href="#" class="bg-color-6 shop-cart">
                                <i class="fa fa-shopping-basket " aria-hidden="true"></i>
                                <span class="badge bg-color-1">3</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><i class="fa fa-shopping-basket " aria-hidden="true"></i>3 items in your cart</li>
                                <li>
                                    <a href="single-product.html">
                                        <div class="media">
                                            <div class="media-left">
                                                <img src="<?= $themeAsset ?>/img/home/cart/cart-img.png"
                                                     alt="cart-Image">
                                            </div>
                                            <div class="media-body">
                                                <h4>Barbie Racing Car</h4>
                                                <div class="price">
                                                    <span class="color-1">$50</span>
                                                </div>
                                                <span class="amount">Qnt: 1</span>
                                            </div>
                                        </div>
                                    </a>
                                    <span class="cancel"><i class="fa fa-close" aria-hidden="true"></i></span>
                                </li>
                                <li>
                                    <a href="single-product.html">
                                        <div class="media">
                                            <div class="media-left">
                                                <img src="<?= $themeAsset ?>/img/home/cart/cart-img.png"
                                                     alt="cart-Image">
                                            </div>
                                            <div class="media-body">
                                                <h4>Barbie Racing Car</h4>
                                                <div class="price">
                                                    <span class="color-1">$50</span>
                                                </div>
                                                <span class="amount">Qnt: 1</span>
                                            </div>
                                        </div>
                                    </a>
                                    <span class="cancel"><i class="fa fa-close" aria-hidden="true"></i></span>
                                </li>
                                <li>
                                    <a href="single-product.html">
                                        <div class="media">
                                            <div class="media-left">
                                                <img src="<?= $themeAsset ?>/img/home/cart/cart-img.png"
                                                     alt="cart-Image">
                                            </div>
                                            <div class="media-body">
                                                <h4>Barbie Racing Car</h4>
                                                <div class="price">
                                                    <span class="color-1">$50</span>
                                                </div>
                                                <span class="amount">Qnt: 1</span>
                                            </div>
                                        </div>
                                    </a>
                                    <span class="cancel"><i class="fa fa-close" aria-hidden="true"></i></span>
                                </li>
                                <li>
                                    <span class="cart-total">Subtotal</span>
                                    <span class="cart-price">$150</span>
                                    <div class="cart-button">
                                        <button type="button" class="btn btn-primary"
                                                onclick="location.href='checkout-step-1.html';">Checkout
                                        </button>
                                        <button type="button" class="btn btn-primary"
                                                onclick="location.href='cart-page.html';">View Cart
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav id="menuBar" class="navbar navbar-default lightHeader" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Url::base(true) ?>"><img
                            src="<?= Yii::getAlias('@web/images/santipab_logo.png') ?>" alt="Kidz School"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown singleDrop color-1   active ">
                        <a href="<?= Url::base(true) ?>">
                            <i class="fa fa-home bg-color-1" aria-hidden="true"></i> <span class="active">หน้าแรก</span>
                        </a>
                    </li>
                    <li class="dropdown singleDrop color-3 ">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false"><i class="fa fa-print bg-color-3"
                                                                         aria-hidden="true"></i>
                            <span>ดิจิตอลพริ้นท์</span></a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            <li class=" "><a href="#">Print On Demend</a></li>
                            <li class=" "><a href="#">Personalized Printing</a></li>
                        </ul>
                    </li>
                    <li class=" dropdown singleDrop color-2 ">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"
                           data-hover="dropdown" data-delay="300" data-close-others="true" aria-expanded="false">
                            <i class="fa fa-newspaper-o bg-color-2" aria-hidden="true"></i>
                            <span>สื่อสิ่งพิมพ์</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left" style="border-top: 4px solid #b5d56a;">
                            <li class=" "><a href="#">หนังสือ และ วารสาร</a></li>
                            <li class=" "><a href="#">ไดอารี่ และ สมุด</a></li>
                            <li class=" "><a href="#">การ์ด และ นามบัตร</a></li>
                            <li class=" "><a href="#">ใบปลิว และ แผ่นพั</a></li>
                            <li class=" "><a href="#">ปฏิทิน</a></li>
                            <li class=" "><a href="#">เอกสารสำนักงาน</a></li>
                            <li class=" "><a href="#">อื่นๆ</a></li>
                        </ul>
                    </li>
                    <li class="dropdown singleDrop color-4 ">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cubes bg-color-4" aria-hidden="true"></i>
                            <span>บรรจุภัณฑ์</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class=" "><a href="#">ฉลากและป้ายสินค้า</a></li>
                            <li class=" "><a href="#">กล่องกระดาษ</a></li>
                            <li class=" "><a href="#">กล่องออฟเซ็ท</a></li>
                            <li class=" "><a href="#">กล่องกระดาษหุ้มแข็ง</a></li>
                            <li class=" "><a href="#">กระป๋องกระดาษ</a></li>
                            <li class=" "><a href="#">ถุงกระดาษ</a></li>
                            <li class=" "><a href="#">กล่องพลาสติก</a></li>
                        </ul>
                    </li>
                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->can('admin')): ?>
                        <li class="dropdown singleDrop color-3 ">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs bg-color-3"
                                                                             aria-hidden="true"></i>
                                <span>ตั้งค่า</span></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="">
                                    <?= Html::a('<i class="fa fa-users"></i>&nbsp;ผู้ใช้งาน', ['/user/admin/index']) ?>
                                </li>
                                <li class="">
                                    <?= Html::a('<i class="fa fa-circle-thin"></i>&nbsp;สิทธิ์', ['/rbac']) ?>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <li class="dropdown singleDrop color-5  ">
                        <a href="<?= Url::to(['/site/about']) ?>" >
                            <i class="fa fa-exclamation bg-color-5" aria-hidden="true"></i>
                            <span>เกี่ยวกับเรา</span>
                        </a>
                    </li>
                    <li class="dropdown singleDrop color-6 ">
                        <a href="<?= Url::to(['/site/contact']) ?>"><i class="fa fa-gg bg-color-6"></i>
                            <span>ติดต่อเรา</span>
                        </a>
                    </li>
                    <?php if (Yii::$app->user->isGuest): ?>
                    <li class="dropdown singleDrop color-2 hidden-lg hidden-md">
                        <a href="<?= Url::to(['/auth/login']) ?>" role="modal-remote"><i class="fa fa-sign-in bg-color-2"></i>
                            <span>เข้าสู่ระบบ</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <li class="dropdown singleDrop color-4 ">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false"><i class="fa fa-user bg-color-4"
                                                                             aria-hidden="true"></i>
                                <span>บัญชีผู้ใช้</span></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="">
                                    <?= Html::a('<i class="fa fa-address-card-o"></i>&nbsp;Profile', ['/user/settings/profile']) ?>
                                </li>
                                <li class="">
                                    <?= Html::a('<i class="fa fa-address-card-o"></i>&nbsp;Account', ['/user/settings/account']) ?>
                                </li>
                                <li class="">
                                    <?= Html::a('<i class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout', ['/auth/logout'], ['data-method' => 'post']) ?>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="cart-dropdown">
                <a href="#" class="bg-color-6 shop-cart">
                    <i class="fa fa-shopping-basket " aria-hidden="true"></i>
                    <span class="badge bg-color-1">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><i class="fa fa-shopping-basket " aria-hidden="true"></i>3 items in your cart</li>
                    <li>
                        <a href="single-product.html">
                            <div class="media">
                                <div class="media-left">
                                    <img src="<?= $themeAsset ?>/img/home/cart/cart-img.png" alt="cart-Image">
                                </div>
                                <div class="media-body">
                                    <h4>Barbie Racing Car</h4>
                                    <div class="price">
                                        <span class="color-1">$50</span>
                                    </div>
                                    <span class="amount">Qnt: 1</span>
                                </div>
                            </div>
                        </a>
                        <span class="cancel"><i class="fa fa-close" aria-hidden="true"></i></span>
                    </li>
                    <li>
                        <a href="single-product.html">
                            <div class="media">
                                <div class="media-left">
                                    <img src="<?= $themeAsset ?>/img/home/cart/cart-img.png" alt="cart-Image">
                                </div>
                                <div class="media-body">
                                    <h4>Barbie Racing Car</h4>
                                    <div class="price">
                                        <span class="color-1">$50</span>
                                    </div>
                                    <span class="amount">Qnt: 1</span>
                                </div>
                            </div>
                        </a>
                        <span class="cancel"><i class="fa fa-close" aria-hidden="true"></i></span>
                    </li>
                    <li>
                        <a href="single-product.html">
                            <div class="media">
                                <div class="media-left">
                                    <img src="<?= $themeAsset ?>/img/home/cart/cart-img.png" alt="cart-Image">
                                </div>
                                <div class="media-body">
                                    <h4>Barbie Racing Car</h4>
                                    <div class="price">
                                        <span class="color-1">$50</span>
                                    </div>
                                    <span class="amount">Qnt: 1</span>
                                </div>
                            </div>
                        </a>
                        <span class="cancel"><i class="fa fa-close" aria-hidden="true"></i></span>
                    </li>
                    <li>
                        <span class="cart-total">Subtotal</span>
                        <span class="cart-price">$150</span>
                        <div class="cart-button">
                            <button type="button" class="btn btn-primary"
                                    onclick="location.href='checkout-step-1.html';">Checkout
                            </button>
                            <button type="button" class="btn btn-primary" onclick="location.href='cart-page.html';">View
                                Cart
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>