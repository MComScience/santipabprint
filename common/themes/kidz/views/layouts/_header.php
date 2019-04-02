<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Menu;
use kartik\icons\Icon;
use yii\bootstrap\Nav;
$urlBuilder = Yii::$app->glide->urlBuilder;
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
                        <li>
                            <i class="fa fa-envelope bg-color-1" aria-hidden="true"></i>
                            <a href="mailto:santipabprint@gmail.com">santipabprint@gmail.com</a>
                        </li>
                        <li>
                            <i class="fa fa-phone bg-color-2" aria-hidden="true"></i> 053-241-519
                        </li>
                        <li class="hidden-md hidden-xs hidden-sm">
                            <i class="fa fa-clock-o bg-color-6" aria-hidden="true"></i> เวลาทำการ: 09:00 - 16:00 น.
                        </li>
                    </ul>
                </div>
                <div class="col-sm-5">
                    <?php
                    $session = Yii::$app->session;
                    $cart = $session->get('cart');
                    $count = 0;
                    if ($session->has('cart') && $cart && is_array($cart)){
                        $count = count($cart);
                    }
                    $items = [
                        [
                            'label' => Icon::show('shopping-basket') . Html::tag('span', $count, [
                                    'class' => 'badge bg-color-1 header-cart'
                                ]),
                            'url' => ['/product/cart'],
                            'options' => ['class' => 'cart-dropdown'],
                            'template' => '<a href="{url}" class="bg-color-6 shop-cart">{label}</a>',
                        ],
                    ];
                    echo Menu::widget([
                        'items' => array_merge([
                            [
                                'label' => \lajax\languagepicker\widgets\LanguagePicker::widget([
                                    'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_DROPDOWN,
                                    'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE
                                ])
                            ],
                            [
                                'label' => 'เข้าสู่ระบบ',
                                'template' => Icon::show('lock', ['class' => 'bg-color-5']) .
                                    '<a href="{url}" role="modal-remote">{label}</a><span>or</span>' .
                                    Html::a('ลงทะเบียน', ['/user/registration/register'], ['role' => 'modal-remote']),
                                'url' => ['/auth/login'],
                                'visible' => Yii::$app->user->isGuest
                            ],
                        ], $items),
                        'options' => ['class' => 'list-inline functionList'],
                        'encodeLabels' => false,
                        'submenuTemplate' => "\n<ul class='dropdown-menu dropdown-menu-right'>\n{items}\n</ul>\n"
                    ]);
                    ?>
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
                <a class="navbar-brand" href="<?= Url::base(true) ?>">
                    <img src="<?= $urlBuilder->getUrl('images/logo-png.png', []) ?>" alt="<?= Yii::$app->name ?>" class="santipab-logo">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <?php
                $dropDownOptions = ['class' => 'dropdown-menu dropdown-menu-right'];
                echo Nav::widget([
                    'items' => [
                        [
                            'label' => Icon::show('home', ['class' => 'bg-color-1']) . '<span>หน้าแรก</span>',
                            'url' => ['/site/index'],
                            'options' => [
                                'class' => 'singleDrop color-1'
                            ],
                            'visible' => false
                        ],
                        [
                            'label' => Icon::show('file-text-o', ['style' => 'background-color: #b5d56a;color:#fff;']) . '<span> ขอใบเสนอราคา</span><span class="hidden-xs hidden-sm">Quotation</span>',
                            'url' => ['/app/product/index'],
                            'options' => [
                                'class' => 'singleDrop',
                            ]
                        ],
                        [
                            'label' => Icon::show('th', ['class' => 'bg-color-3']) . '<span>ตัวอย่างผลิตภัณฑ์</span><span class="hidden-xs hidden-sm">Products</span>',
                            'url' => ['/product/catalog-list'],
                            'options' => [
                                'class' => 'singleDrop color-3'
                            ]
                        ],
                        [
                            'label' => Icon::show('cogs', ['class' => 'bg-color-1']) . '<span>ตั้งค่า</span><span class="hidden-xs hidden-sm">Settings</span>',
                            'url' => 'javascript:void(0)',
                            'options' => [
                                'class' => 'singleDrop color-1'
                            ],
                            'items' => [
                                [
                                    'label' => Icon::show('cog') . 'ตั้งค่าระบบ',
                                    'url' => ['/app/setting/index'],
                                ],
                                /* [
                                    'label' => Icon::show('shopping-cart') . 'สินค้า',
                                    'url' => ['/app/setting/index'],
                                ], */
                                [
                                    'label' => Icon::show('users') . 'ผู้ใช้งาน',
                                    'url' => ['/user/admin/index'],
                                ],
                                [
                                    'label' => Icon::show('circle-thin') . 'สิทธิ์',
                                    'url' => ['/rbac/assignment'],
                                ],
                                [
                                    'label' => Icon::show('user-circle') . 'ข้อมูลส่วนตัว',
                                    'url' => ['/user/settings/profile'],
                                ],
                                [
                                    'label' => Icon::show('address-card-o') . 'บัญชี',
                                    'url' => ['/user/settings/account'],
                                ],
                            ],
                            'dropDownOptions' => $dropDownOptions,
                            'visible' => !Yii::$app->user->isGuest && Yii::$app->user->can('admin')
                        ],
                        /* [
                            'label' => Icon::show('file-text-o', ['class' => 'bg-color-5']) . '<span>ใบเสนอราคา</span>',
                            'url' => ['/app/quotation/index'],
                            'options' => [
                                'class' => 'singleDrop color-5'
                            ],
                            'visible' => !Yii::$app->user->isGuest && Yii::$app->user->can('admin')
                        ], */
                        /* [
                            'label' => Icon::show('th', ['class' => 'bg-color-5']) . '<span>เกี่ยวกับเรา</span>',
                            'url' => ['/site/about'],
                            'options' => [
                                'class' => 'singleDrop color-5'
                            ]
                        ], */
                        [
                            'label' => Icon::show('phone', ['class' => 'bg-color-6']) . '<span>ติดต่อเรา</span><span class="hidden-xs hidden-sm">Contact us</span>',
                            'url' => ['/site/contact'],
                            'options' => [
                                'class' => 'singleDrop color-6'
                            ]
                        ],
                        [
                            'label' => Icon::show('sign-in', ['class' => 'bg-color-6']) . '<span>เข้าสู่ระบบ</span><span class="hidden-xs hidden-sm">Sign In</span>',
                            'url' => ['/auth/login'],
                            'options' => [
                                'class' => 'singleDrop color-2 hidden-lg hidden-md'
                            ],
                            'linkOptions' => ['role' => 'modal-remote'],
                            'visible' => Yii::$app->user->isGuest
                        ],
                        /* [
                            'label' => Icon::show('user', ['class' => 'bg-color-4']) . '<span>บัญชีผู้ใช้</span>',
                            'url' => 'javascript:void(0)',
                            'options' => [
                                'class' => 'singleDrop color-4'
                            ],
                            'items' => [
                                [
                                    'label' => Icon::show('address-card-o') . 'ข้อมูลส่วนตัว',
                                    'url' => ['/user/settings/profile'],
                                ],
                                [
                                    'label' => Icon::show('address-card-o') . 'บัญชี',
                                    'url' => ['/user/settings/account'],
                                ],
                            ],
                            'dropDownOptions' => $dropDownOptions,
                            'visible' => !Yii::$app->user->isGuest
                        ], */
                        [
                            'label' => Icon::show('sign-out',['class' => 'bg-color-4']) . '<span>ออกจากระบบ</span><span class="hidden-xs hidden-sm">Sign Out</span>',
                            'url' => ['/auth/logout'],
                            'linkOptions' => ['data-method' => 'post'],
                            'options' => [
                                'class' => 'singleDrop color-4'
                            ],
                            'visible' => !Yii::$app->user->isGuest
                        ],
                    ],
                    'options' => ['class' => 'nav navbar-nav navbar-right'],
                    'encodeLabels' => false,
                    'dropDownCaret' => '',
                ]);
                ?>
                <?php /*
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown singleDrop color-1">
                        <a href="<?= Url::base(true) ?>">
                            <i class="fa fa-home bg-color-1" aria-hidden="true"></i> <span class="active">หน้าแรก</span>
                        </a>
                    </li>
                    <li class="singleDrop color-3 ">
                        <a href="<?= Url::to(['/product/index']) ?>">
                            <i class="fa fa-th bg-color-3" aria-hidden="true"></i>
                            <span>สินค้า</span></a>
                    </li>
                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->can('admin')): ?>
                        <li class="dropdown singleDrop color-3 ">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs bg-color-3"
                                                                             aria-hidden="true"></i>
                                <span>ตั้งค่า</span></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="">
                                    <?= Html::a('<i class="fa fa-shopping-cart"></i>&nbsp;สินค้า', ['/settings/default/index']) ?>
                                </li>
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
                        <a href="<?= Url::to(['/site/about']) ?>">
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
                            <a href="<?= Url::to(['/auth/login']) ?>" role="modal-remote"><i
                                        class="fa fa-sign-in bg-color-2"></i>
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
                </ul>*/ ?>
            </div>
            <div class="cart-dropdown">
                <a href="<?= Url::to(['/product/cart']) ?>" class="bg-color-6 shop-cart">
                    <i class="fa fa-shopping-basket " aria-hidden="true"></i>
                    <span class="badge bg-color-1"><?= $count ?></span>
                </a>
            </div>
        </div>
    </nav>
</header>