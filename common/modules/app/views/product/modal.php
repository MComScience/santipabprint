<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 10/1/2562
 * Time: 10:45
 */
use adminlte\assets\AjaxCrudAsset;
use yii\bootstrap\Modal;

AjaxCrudAsset::register($this);

Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",
    'options' => ['class' => 'modal', 'tabindex' => false,],
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);

Modal::end();
?>
