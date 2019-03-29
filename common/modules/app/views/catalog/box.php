<?php
use yii\helpers\Url;
$action = Yii::$app->controller->action->id;
?>
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?= Url::to(['/app/catalog/group']); ?>" class="color-inherit">
            <div class="info-box">
            <span class="info-box-icon <?= ($action !== 'group') ? 'bg-aqua' : 'bg-green' ?>">
                <i class="fa fa-file-text-o"></i>
            </span>

                <div class="info-box-content">
                    <span class="info-box-text"><?= Html::encode('') ?></span>
                    <span class="info-box-number"><?= $option['count'] ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div><!-- /.col -->
</div>