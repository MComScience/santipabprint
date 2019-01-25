<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 11/1/2562
 * Time: 15:53
 */
use kartik\form\ActiveForm;
use kartik\icons\Icon;
use adminlte\helpers\Html;
?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">ข้อมูลการพับ</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-fold-option']) ?>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'fold_option_id')->textInput([
                    'maxlength' => true,
                    'readonly' => true
                ])->hint('<small class="label bg-yellow">Notice! ระบบจะรันเลขสินค้าให้อัตโนมัติ</small>')
                    ->label('รหัสวิธีการพับ <button type="button" 
                    class="btn btn-xs btn-default"
                    data-toggle="popover" 
                    data-placement="right"
                    data-html="true"
                    data-content="<small>ตัวอย่างเลขรหัสวิธีการพับ</small> <span class=\'label bg-yellow\'>DI.0001</span>">
                      <i class="glyphicon glyphicon-question-sign"></i>
                </button>') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'fold_option_name')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'ตัวอย่าง เช่น พับครึ่ง'
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'fold_option_description')->textarea([
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
var \$form = $('#form-fold-option');
\$form.on('beforeSubmit', function() {
    var tableFold = $('#tb-fold-option').DataTable();
    var data = \$form.serialize();
    var \$btn = $('#form-fold-option button[type="submit"]').button('loading');
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
                tableFold.ajax.reload();
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

