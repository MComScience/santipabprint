<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 11/1/2562
 * Time: 14:12
 */
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use adminlte\helpers\Html;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;
?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">ข้อมูลรูปแบบการพิมพ์</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-print-option']) ?>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <?= $form->field($model, 'img')->widget(Upload::classname(), [
                    'url' => ['upload-icon'],
                    'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                    'id' => 'print-option-img'
                ])->label('ภาพตัวอย่าง <button type="button" 
                    class="btn btn-xs btn-default"
                    data-toggle="popover" 
                    data-placement="right"
                    data-html="true"
                    data-content="<small><span class=\'text-danger\'>Notice!</span> หากขนาดภาพใหญ่เกิน <strong>112x112</strong> ระบบจะปรับขนาดให้เหลือ <strong>112x112</strong></small>">
                      <i class="glyphicon glyphicon-question-sign"></i>
                </button>') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'print_option_id')->textInput([
                    'maxlength' => true,
                    'readonly' => true
                ])->hint('<small class="label bg-yellow">Notice! ระบบจะรันเลขสินค้าให้อัตโนมัติ</small>')
                    ->label('รหัสรูปแบบการพิมพ์ <button type="button" 
                        class="btn btn-xs btn-default"
                        data-toggle="popover" 
                        data-placement="right"
                        data-html="true"
                        data-content="<small>ตัวอย่างเลขรหัสรูปแบบการพิมพ์</small> <span class=\'label bg-yellow\'>P.0001</span>">
                          <i class="glyphicon glyphicon-question-sign"></i>
                    </button>') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'print_option_name')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'ตัวอย่าง เช่น พิมพ์ 4 สี'
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'print_option_description')->textarea([
                    'maxlength' => true,
                    'rows' => 3,
                    'placeholder' => 'รายละเอียด'
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <?= Html::activeHiddenInput($model, 'product_id',[
                    'value' => $modelProduct['product_id']
                ]) ?>
            </div>
        </div>
        <div class="form-group text-right">
            <?= Html::button(Icon::show('close').'ยกเลิก',['class' => 'btn btn-default','data-dismiss' => 'modal']) ?>
            <?= Html::submitButton(Icon::show('save').'บันทึก',['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$this->registerJs(<<<JS
$(function () {
  $('[data-toggle="popover"]').popover()
});
var \$form = $('#form-print-option');
\$form.on('beforeSubmit', function() {
    var tablePrintOption = $('#tb-print-option').DataTable();
    var data = \$form.serialize();
    var \$btn = $('#form-print-option button[type="submit"]').button('loading');
    $.ajax({
        url: \$form.attr('action'),
        type: \$form.attr('method'),
        data: data,
        success: function (response) {
            // Implement successful
            if (response.success) {
                swal({
                    type: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });
                tablePrintOption.ajax.reload();
                $('#ajaxCrudModal').modal('hide');
                \$btn.button('reset');
            } else {
                \$btn.button('reset');
                $.each(response.validate, function (key, val) {
                    $(\$form).yiiActiveForm('updateAttribute', key, [val]);
                });
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
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
