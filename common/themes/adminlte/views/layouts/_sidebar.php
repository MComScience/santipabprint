<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 10/1/2562
 * Time: 9:12
 */
use adminlte\widgets\Menu;
?>
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Yii::$app->user->identity->profile->getAvatar() ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?= Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menus', 'options' => ['class' => 'header']],
                    ['label' => 'หน้าหลัก', 'icon' => 'home', 'url' => ['/site/index']],
                    [
                        'label' => 'แคตตาล็อก',
                        'icon' => 'circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'หมวดหมู่', 'icon' => 'circle-o', 'url' => ['/app/catalog/group']],
                            ['label' => 'สินค้าตัวอย่าง', 'icon' => 'circle-o', 'url' => ['/app/catalog/index']],
                        ],
                    ],
                    ['label' => 'ใบเสนอราคา', 'icon' => 'file-text-o', 'url' => ['/app/quotation/index']],
                    ['label' => 'ต้งค่า', 'icon' => 'cogs', 'url' => ['/app/setting/index']],
                    /*[
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],*/
                ],
            ]
        ) ?>
    </section>
    <!-- /.sidebar -->
</aside>

<!-- =============================================== -->
