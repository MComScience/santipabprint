<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 10/1/2562
 * Time: 9:10
 */
use yii\helpers\Url;
use yii\helpers\Html;
$avatar = Yii::$app->user->identity->profile->getAvatar();
$fullname = Yii::$app->user->identity->profile->getFullname();
?>
<header class="main-header">
    <!-- Logo -->
    <a href="<?= Url::base(true) ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>SP</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg uppercase"><b></b>Santipab</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $avatar ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= $fullname ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $avatar ?>" class="img-circle" alt="User Image">

                            <p>
                                <?= $fullname ?>
                                <small></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a('ข้อมูลส่วนตัว',['/user/settings/profile'],[
                                    'class' => 'btn btn-default btn-flat'
                                ]) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a('ออกจากระบบ',['/user/security/logout'],[
                                    'class' => 'btn btn-default btn-flat',
                                    'data-method' => 'post'
                                ]) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
