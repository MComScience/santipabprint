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
use kartik\icons\Icon;
use kidz\bootstraptoggle\BootstrapToggle;
use kartik\select2\Select2;
use kidz\user\models\TbProvince;
use yii\helpers\ArrayHelper;
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\User $model
 * @var dektrium\user\models\Account $account
 */

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .field-profile-sex_id {
        float: left;
    }
    .homeContactContent form .btn {
        float: none;
        width: auto;
    }
    .toggle-off i, .toggle-on i {
        z-index: 100 !important;
        position: relative !important;
        width: auto !important;
        height: auto !important;
        line-height: 0px !important;
        color: #fff !important;
    }
    .input-group {
        width: 100%;
    }
    .upload-kit .upload-kit-input, .upload-kit .upload-kit-item {
        float: left;
        position: relative;
        padding: 0;
        margin: 0;
        border: 5px solid #f0c24b;
        border-radius: 7%;
        height: 160px;
        width: 160px;
    }
    .select2-selection--single {
        border-color: #b5d56a!important;
        border: 3px solid #b5d56a !important;
    }
</style>
<section class="mainContent full-width clearfix">
    <div class="container">
        <div class="sectionTitle text-center">
            <h2>
                <span class="shape shape-left bg-color-4"></span>
                <span><?= Html::encode($this->title) ?></span>
                <span class="shape shape-right bg-color-4"></span>
            </h2>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="homeContactContent">
                    <?php $form = ActiveForm::begin([
                        'id' => 'connect-account-form',
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                    ]); ?>
                    <div class="form-group">
                        <?= Html::activeLabel($profile, 'sex_id', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6 col-xs-12">
                            <?= $form->field($profile, 'sex_id',['showLabels' => false])->widget(BootstrapToggle::className(),[
                                'clientOptions' => [
                                    'on' => Icon::show('mars').'ชาย',
                                    'off' => Icon::show('venus').'หญิง',
                                    'onstyle' => 'success',
                                    'offstyle' => 'info',
                                    //'style' => 'ios',
                                    'width' => 120
                                ],
                                'options' => ['label' => false],
                            ]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($profile, 'first_name', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6 col-xs-12">
                            <?= $form->field($profile, 'first_name', [
                                'showLabels' => false,
                                'addon' => ['prepend' => ['content' => Icon::show('user',[])]]
                            ])->textInput([
                                'placeholder' => $profile->getAttributeLabel('first_name'),
                                'class' => 'form-control border-color-2'
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($profile, 'last_name', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($profile, 'last_name', [
                                'showLabels' => false,
                                'addon' => ['prepend' => ['content' => Icon::show('user',[])]]
                            ])->textInput([
                                'placeholder' => $profile->getAttributeLabel('last_name'),
                                'class' => 'form-control border-color-2'
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($profile, 'birthday', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($profile, 'birthday',[
                                'showLabels' => false,
                                'addon' => ['prepend' => ['content' => Icon::show('calendar',[])]]
                            ])->widget(\yii\widgets\MaskedInput::className(), [
                                'mask' => '99/99/9999',
                                'options' => [
                                    'placeholder' => $profile->getAttributeLabel('birthday'),
                                    'class' => 'form-control border-color-2'
                                ],
                            ])->hint('<small class="text-danger">โปรดระบุปีเป็น พ.ศ.</small>') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($profile, 'tel', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($profile, 'tel',[
                                'showLabels' => false,
                                'addon' => ['prepend' => ['content' => Icon::show('phone',[])]]
                            ])->widget(\yii\widgets\MaskedInput::className(), [
                                'mask' => '999-999-9999',
                                'options' => [
                                    'class' => 'form-control border-color-2',
                                    'placeholder' => $profile->getAttributeLabel('tel')
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($profile, 'province', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($profile, 'province',['showLabels' => false])->widget(Select2::classname(), [
                                'language' => 'th',
                                'data' => ArrayHelper::map(TbProvince::find()->asArray()->all(), 'province_id', 'province_name'),
                                'options' => ['placeholder' => 'เลือกจังหวัด...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'size' => 'lg'
                            ]); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'email', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'email', [
                                'showLabels' => false,
                                'addon' => ['prepend' => ['content' => Icon::show('envelope-o',[])]]
                            ])->textInput([
                                'placeholder' => $model->getAttributeLabel('email'),
                                'class' => 'form-control border-color-2',
                                'type' => 'email'
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'username', ['class' => 'col-sm-3 control-label']) ?>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'username', [
                                'showLabels' => false,
                                'addon' => ['prepend' => ['content' => Icon::show('user',[])]]
                            ])->textInput([
                                'placeholder' => $model->getAttributeLabel('username'),
                                'class' => 'form-control border-color-2'
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <?= Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'btn btn-block btn-success','style' => 'display: block;width: 100%;']) ?>
                            <br>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
