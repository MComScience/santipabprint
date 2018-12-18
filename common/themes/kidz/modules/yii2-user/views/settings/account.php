<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\SettingsForm $model
 */

$this->title = Yii::t('user', 'Account settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.input-group {
    width: 100%;
}
</style>
<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="mainContent full-width clearfix">
    <div class="container">
        <div class="sectionTitle text-center">
            <h2>
                <span class="shape shape-left bg-color-4"></span>
                <span><?= $this->title ?></span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="homeContactContent">
                    <?php $form = ActiveForm::begin([
                        'id' => 'account-form',
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        //'options' => ['class' => 'form-horizontal'],
                        /* 'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                            'labelOptions' => ['class' => 'col-lg-3 control-label'],
                        ], */
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                    ]); ?>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'email', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6 col-xs-12">
                            <?= $form->field($model, 'email',['showLabels' => false]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'username', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6 col-xs-12">
                            <?= $form->field($model, 'username',['showLabels' => false]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'new_password', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6 col-xs-12">
                            <?= $form->field($model, 'new_password',['showLabels' => false])->passwordInput() ?>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'current_password', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6 col-xs-12">
                            <?= $form->field($model, 'current_password',['showLabels' => false])->passwordInput() ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success','style' => 'display: block;width: 100%;']) ?><br>
                        </div>
                    </div>

                    <?php if ($model->module->enableAccountDelete): ?>
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= Yii::t('user', 'Delete account') ?></h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <?= Yii::t('user', 'Once you delete your account, there is no going back') ?>.
                                    <?= Yii::t('user', 'It will be deleted forever') ?>.
                                    <?= Yii::t('user', 'Please be certain') ?>.
                                </p>
                                <?= Html::a(Yii::t('user', 'Delete account'), ['delete'], [
                                    'class' => 'btn btn-danger',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('user', 'Are you sure? There is no going back'),
                                ]) ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->render('_mobile_menu') ?>