<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 24/1/2562
 * Time: 14:41
 */

use kartik\form\ActiveForm;
use adminlte\helpers\Html;
use kartik\icons\Icon;

?>
<?php $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_VERTICAL,
    'id' => 'form-download',
    'options' => ['autocomplete' => 'off']
]); ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'quotation_customer_name')->textInput([
                'placeholder' => $model->getAttributeLabel('quotation_customer_name'),
                'maxlength' => true,
                'autocomplete' => 'off'
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'quotation_customer_address')->textarea([
                'placeholder' => $model->getAttributeLabel('quotation_customer_address'),
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'quotation_customer_email')->textInput([
                'type' => 'email',
                'maxlength' => true,
                'autocomplete' => 'off',
                'placeholder' => $model->getAttributeLabel('quotation_customer_email'),
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'quotation_customer_tel')->textInput([
                'type' => 'tel',
                'maxlength' => true,
                'autocomplete' => 'off',
                'placeholder' => $model->getAttributeLabel('quotation_customer_tel'),
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-right">
            <?= Html::button(Icon::show('close') . 'ยกเลิก', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
            <?= Html::submitButton(Icon::show('print') . 'ใบเสนอราคา', ['class' => 'btn btn-info', 'data-loading-text' => 'Loading...']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>

<?php
$this->registerJs(<<<JS
$('#ajaxCrudModal .modal-footer').hide();
var \$form = $('#form-download');
var \$formQuo = $('#form-quotation');
\$form.on('beforeSubmit', function() {
    var dataObj = {}, dataQO = {};
    \$form.serializeArray().map(function (x) {
        dataObj[x.name] = x.value;
    });
    \$formQuo.serializeArray().map(function (x) {
        dataQO[x.name] = x.value;
    });
    var \$btn = $('#form-download button[type="submit"]').button('loading');
    $.ajax({
        url: \$form.attr('action'),
        type: \$form.attr('method'),
        data: $.extend(dataObj, dataQO),
        success: function (response) {
            // Implement successful
            \$btn.button('reset');
            if (response.success) {
                $('#ajaxCrudModal').modal('hide');
                window.location.href = response.url;
            } else {
                Swal({
                    type: 'error',
                    title: 'Oops!',
                    text: 'เกิดข้อผิดพลาด!',
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            \$btn.button('reset');
            Swal({
                type: 'error',
                title: textStatus,
                text: errorThrown,
            });
        }
    });
    return false; // prevent default submit
});
JS
);
?>