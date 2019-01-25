<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 11/1/2562
 * Time: 11:13
 */
use kartik\form\ActiveForm;
use adminlte\helpers\Html;
use kartik\icons\Icon;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\modules\settings\models\TblPaperUnit;
?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">ข้อมูลขนาดกระดาษสินค้า</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'form-paper-size']) ?>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'paper_size_id')->textInput([
                        'maxlength' => true,
                        'readonly' => true
                    ])->hint('<small class="label bg-yellow">Notice! ระบบจะรันเลขสินค้าให้อัตโนมัติ</small>')
                        ->label('รหัสขนาดกระดาษ <button type="button" 
                        class="btn btn-xs btn-default"
                        data-toggle="popover" 
                        data-placement="right"
                        data-html="true"
                        data-content="<small>ตัวอย่างเลขรหัสขนาดกระดาษ</small> <span class=\'label bg-yellow\'>PPZ.0001</span>">
                          <i class="glyphicon glyphicon-question-sign"></i>
                    </button>') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= $form->field($model, 'paper_size_name')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'ตัวอย่าง เช่น 4*6, 5*7, A5'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'paper_size_description')->textarea([
                        'maxlength' => true,
                        'rows' => 3,
                        'placeholder' => 'รายละเอียด'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($model, 'paper_size_width')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'ความกว้าง'
                    ]) ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'paper_size_height')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'ความยาว'
                    ]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'paper_unit_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TblPaperUnit::find()->all(), 'paper_unit_id', 'paper_unit_name'),
                        'options' => ['placeholder' => 'หน่วย...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'theme' => Select2::THEME_BOOTSTRAP,
                    ])->label('หน่วย'); ?>
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
var \$form = $('#form-paper-size');
\$form.on('beforeSubmit', function() {
    var tablePaperSize = $('#tb-paper-size').DataTable();
    var data = \$form.serialize();
    var \$btn = $('#form-paper-size button[type="submit"]').button('loading');
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
                tablePaperSize.ajax.reload();
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