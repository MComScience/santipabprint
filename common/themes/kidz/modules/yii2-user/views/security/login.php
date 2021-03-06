<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if (Yii::$app->request->isAjax): ?>
    <style>
        
        /* Small devices (tablets, 768px and up) */
        @media (min-width: 768px) { 
            #ajaxCrudModal .modal-dialog {
                width: 350px;
            }
        }
        @media (max-width: 576px) { 
            #ajaxCrudModal .modal-dialog {
                width: auto;
            }
        }
    </style>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form-ajax',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnType' => false,
        'validateOnChange' => false,
    ]) ?>
    <div class="form-group formField">
        <?= $form->field($model, 'login',
            ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1', 'placeholder' => $model->getAttributeLabel('login')]]
        )->label(false);
        ?>
    </div>
    <div class="form-group formField">
        <?= $form->field($model, 'password',
            ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2', 'placeholder' => $model->getAttributeLabel('password')]])
            ->passwordInput()
            ->label(false) ?>
    </div>
    <div class="form-group formField">
        <?= Html::submitButton(
            Yii::t('user', 'Sign in'),
            ['class' => 'btn btn-success btn-block', 'tabindex' => '4', 'id' => 'btn-login']
        ) ?>
    </div>
    <?php if ($module->enablePasswordRecovery): ?>
        <div class="form-group formField">
            <p class="help-block">
                <?= Html::a(
                    Yii::t('user', 'Forgot password?'),
                    ['/user/recovery/request'],
                    ['tabindex' => '5']
                ) ?>
            </p>
        </div>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>
    <?= Connect::widget([
        'id' => 'auth-choice',
        'baseAuthUrl' => ['/user/security/auth'],
        'popupMode' => false,
    ]) ?>
<?php else: ?>
        <style>
            .auth-clients li {
                float: unset !important;
                margin: 0 0 0 0;
            }
        </style>
    <?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>
    <section class="mainContent full-width clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div class="panel panel-default formPanel">
                        <div class="panel-heading bg-color-1 border-color-1">
                            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
                        </div>
                        <div class="panel-body">
                            <?php $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => false,
                                'validateOnBlur' => false,
                                'validateOnType' => false,
                                'validateOnChange' => false,
                            ]) ?>
                            
                            <div class="form-group formField">
                                <?php if ($module->debug): ?>
                                    <?= $form->field($model, 'login', [
                                        'inputOptions' => [
                                            'autofocus' => 'autofocus',
                                            'class' => 'form-control',
                                            'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                                    ?>

                                <?php else: ?>

                                    <?= $form->field($model, 'login',
                                        ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1','placeholder' => 'Username']]
                                    );
                                    ?>

                                <?php endif ?>
                            </div>
                            <div class="form-group formField">
                                <?php if ($module->debug): ?>
                                    <div class="alert alert-warning">
                                        <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                                    </div>
                                <?php else: ?>
                                    <?= $form->field(
                                        $model,
                                        'password',
                                        ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2','placeholder' => 'Password']])
                                        ->passwordInput()
                                        ->label(
                                            Yii::t('user', 'Password')
                                            . ($module->enablePasswordRecovery ?
                                                ' (' . Html::a(
                                                    Yii::t('user', 'Forgot password?'),
                                                    ['/user/recovery/request'],
                                                    ['tabindex' => '5']
                                                )
                                                . ')' : '')
                                        ) ?>
                                <?php endif ?>
                            </div>
                            <div class="form-group formField">
                                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>
                            </div>
                            <div class="form-group formField">
                                <?= Html::submitButton(
                                    Yii::t('user', 'Sign in'),
                                    ['class' => 'btn btn-primary btn-block', 'tabindex' => '4', 'id' => 'btn-login']
                                ) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                            <div class="form-group formField">
                                <?php if ($module->enableConfirmation): ?>
                                    <p class="text-center">
                                        <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
                                    </p>
                                <?php endif ?>
                                <?php if ($module->enableRegistration): ?>
                                    <p class="text-center">
                                        <?= Html::a(Yii::t('user', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
                                    </p>
                                <?php endif ?>
                                <?= Connect::widget([
                                    'baseAuthUrl' => ['/user/security/auth'],
                                    'popupMode' => false,
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
<?php endif; ?>
