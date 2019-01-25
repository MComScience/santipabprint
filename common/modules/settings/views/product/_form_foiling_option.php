<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 11/1/2562
 * Time: 16:06
 */
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use adminlte\helpers\Html;
use kartik\widgets\ColorInput;
?>
<style type="text/css">
    span#tblfoilingoptions-foiling_option_color_code-cont {
        width: 70px;
    }
</style>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">ข้อมูลสีฟอยล์</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-foiling-option']) ?>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'foiling_option_id')->textInput([
                    'maxlength' => true,
                    'readonly' => true
                ])->hint('<small class="label bg-yellow">Notice! ระบบจะรันเลขสินค้าให้อัตโนมัติ</small>')
                    ->label('รหัสสีฟอยล์ <button type="button" 
                    class="btn btn-xs btn-default"
                    data-toggle="popover" 
                    data-placement="right"
                    data-html="true"
                    data-content="<small>ตัวอย่างเลขรหัสสีฟอยล์</small> <span class=\'label bg-yellow\'>FO.0001</span>">
                      <i class="glyphicon glyphicon-question-sign"></i>
                </button>') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'foiling_option_name')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'ตัวอย่าง เช่น สีเงิน'
                ]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'foiling_option_color_code')->widget(ColorInput::classname(), [
                    'options' => ['placeholder' => 'โค้ดสี...'],
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'foiling_option_description')->textarea([
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
var \$form = $('#form-foiling-option');
\$form.on('beforeSubmit', function() {
    var tableFoiling = $('#tb-foiling-option').DataTable();
    var data = \$form.serialize();
    var \$btn = $('#form-foiling-option button[type="submit"]').button('loading');
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
                tableFoiling.ajax.reload();
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