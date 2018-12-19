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
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if(Yii::$app->request->isAjax): ?>
<style>
#ajaxCrudModal .modal-dialog {
    width: 350px;
}
</style>
<?php $form = ActiveForm::begin([
    'id' => 'registration-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
]); ?>
    <div class="form-group formField">
        <?= $form->field($model, 'email')->textInput([
            'type' => 'email',
            'placeholder' => $model->getAttributeLabel('email')
        ]) ?>
    </div>
    <div class="form-group formField">
        <?= $form->field($model, 'username')->textInput([
            'placeholder' => $model->getAttributeLabel('username')
        ]) ?>
    </div>
    <div class="form-group formField">
        <?php if ($module->enableGeneratingPassword == false): ?>
            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => $model->getAttributeLabel('password')
            ]) ?>
        <?php endif ?>
    </div>
    <div class="form-group formField">
        <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-primary btn-block bg-color-3 border-color-3']) ?>
    </div>
<?php ActiveForm::end(); ?>
<?php else: ?>
<section class="mainContent full-width clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading bg-color-1 border-color-1">
                        <h3 class="panel-title" style="color: #fff;"><?= Html::encode($this->title) ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin([
                            'id' => 'registration-form',
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                        ]); ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'username') ?>

                        <?php if ($module->enableGeneratingPassword == false): ?>
                            <?= $form->field($model, 'password')->passwordInput() ?>
                        <?php endif ?>

                        <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>

                        <?php ActiveForm::end(); ?>

                        <p class="text-center">
                            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
