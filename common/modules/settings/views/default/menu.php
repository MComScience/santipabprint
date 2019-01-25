<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 10/1/2562
 * Time: 10:38
 */
use yii\helpers\Html;
use yii\helpers\Url;
use common\modules\settings\models\TblProductGroup;
use common\modules\settings\models\TblProductType;
use common\modules\settings\models\TblProduct;
?>
<div class="row settings">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/settings/product-group/index']) ?>" data-pjax="0">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text box-text"><?= Html::encode('กลุ่มสินค้า') ?></span>
                    <span class="info-box-number">
                        <?= TblProductGroup::find()->count(); ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/settings/product-type/index']) ?>" data-pjax="0">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text box-text"><?= Html::encode('ประเภทสินค้า') ?></span>
                    <span class="info-box-number">
                        <?= TblProductType::find()->count(); ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/settings/product/index']) ?>" data-pjax="0">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-cart-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text box-text"><?= Html::encode('สินค้า') ?></span>
                    <span class="info-box-number">
                        <?= TblProduct::find()->count(); ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/settings/product/quotation']) ?>" data-pjax="0">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-file-text-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text box-text"><?= Html::encode('ใบเสนอราคา') ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div>
</div>
