<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/1/2562
 * Time: 9:25
 */

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;
use adminlte\helpers\Html;
use yii\helpers\ArrayHelper;
use common\modules\app\models\TblUnit;
use kartik\icons\Icon;

//style
$this->registerCss(<<<CSS
    .panel-quotation {
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }
    .select2-container--bootstrap .select2-results__group {
        display: block;
        color: #333;
        text-shadow: 0 1px 0 #fff;
        background-color: #eee;
        border-top: 1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
        padding: 6px 12px;
        line-height: 1.428571429;
        white-space: nowrap;
    }
    .label-option {
        background-color: #eee;
        color: #333;
        font-weight: bold;
        font-size: 14px;
    }
    .inline-block {
        display: inline-block;
    }
CSS
);
//script
$this->registerJs(<<<JS
function format(state) {
    if (!state.id) return state.text; // optgroup
    return state.text;
}
JS
    , View::POS_HEAD);
$escape = new JsExpression("function(m) { return m; }");
$textRequired = Html::tag('span', '*', ['class' => 'text-danger']);
?>

<div class="panel panel-info panel-quotation">
    <div class="panel-body">
        <!-- แนวตั้ง / แนวนอน -->
        <div class="row" style="display: <?= $queryBuilder->isShowInput($option, 'land_orient') ? '' : 'none'; ?>">
            <div class="col-xs-6 col-sm-6 col-md-6 page-qty">
                <?php
                echo $form->field($model, 'land_orient')->radioList([
                    '1' => 'แนวตั้ง',
                    '2' => 'แนวนอน'
                ], [
                    'inline' => true,
                    'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                        $radio = Html::beginTag('div', ['class' => 'radio inline-block']) .
                            Html::beginTag('label', ['class' => 'radio-inline']) .
                            Html::radio($name, $checked, ['value' => $value, 'id' => Html::getInputId($model, 'land_orient').'-'.$index]) .
                            Html::tag('span', Icon::show('circle', ['class' => 'cr-icon']), ['class' => 'cr']) .
                            ucwords($label) .
                            Html::endTag('label') .
                            Html::endTag('div');
                        return $radio;
                    }
                ])->label('รูปแบบ' . $textRequired);
                ?>
            </div>
        </div>
        <!-- ขนาด -->
        <div class="row paper-size-id">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <?php
                echo $form->field($model, 'paper_size_id')->widget(Select2::classname(), [
                    'data' => $queryBuilder->getPaperSizeOption(),
                    'options' => ['placeholder' => 'เลือกขนาด'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'templateResult' => new JsExpression('format'),
                        'templateSelection' => new JsExpression('format'),
                        'escapeMarkup' => $escape,
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label($queryBuilder->getInputLabel($option, 'paper_size_id', $model));
                ?>
            </div>
        </div>
        <!-- ขนาดกำหนดเอง -->
        <span class="label label-option custom-paper-size" style="display: none;">
            <?= Icon::show('angle-double-down') . ' กำหนดขนาดเอง ' . Icon::show('angle-double-down') ?>
        </span>
        <div class="row custom-paper-size" style="display: none;">
            <div class="col-xs-6 col-sm-3 col-md-3 paper-size-width">
                <?php
                echo $form->field($model, 'paper_size_width')->textInput([
                    //'type' => 'number',
                    //'min' => 0,
                    'placeholder' => 'กว้าง'
                ])->label('กว้าง' . $textRequired);
                ?>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-3 paper-size-height">
                <?php
                echo $form->field($model, 'paper_size_lenght')->textInput([
                    //'type' => 'number',
                    //'min' => 0,
                    'placeholder' => 'ยาว'
                ])->label('ยาว' . $textRequired);
                ?>
            </div>
           
            <div class="col-xs-6 col-sm-3 col-md-3 paper-size-height" style="display: <?= $queryBuilder->isShowInput($option, 'paper_size_height') ? '' : 'none'; ?>">
                <?php
                echo $form->field($model, 'paper_size_height')->textInput([
                    //'type' => 'number',
                    //'min' => 0,
                    'placeholder' => 'สูง'
                ])->label('สูง' . $textRequired);
                ?>
            </div>
        
            <div class="col-xs-6 col-sm-3 col-md-3 paper-size-unit">
                <?php
                echo $form->field($model, 'paper_size_unit')->widget(Select2::classname(), [
                   // 'data' => ArrayHelper::map(TblUnit::find()->asArray()->all(), 'unit_id', 'unit_name'),
                    'data' => ArrayHelper::map(TblUnit::find()->where(['unit_id' => [2,3]])->asArray()->all(), 'unit_id', 'unit_name'),
                    'options' => ['placeholder' => 'เลือกหน่วย'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label('หน่วย' . $textRequired);
                ?>
            </div>
        </div>

        <!-- วิธีเข้าเล่ม -->
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 before-print"
                 style="display: <?= $queryBuilder->isShowInput($option, 'book_binding_id') ? '' : 'none'; ?>">
                <?php
                echo $form->field($model, 'book_binding_id')->widget(Select2::classname(), [
                    'data' => $queryBuilder->getBookBindingOption(),
                    //'options' => ['placeholder' => 'วิธีเข้าเล่ม'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'templateResult' => new JsExpression('format'),
                        'templateSelection' => new JsExpression('format'),
                        'escapeMarkup' => $escape,
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label($queryBuilder->getInputLabel($option, 'book_binding_id', $model));
                ?>
            </div>
        </div>

        <!-- จำนวน -->
        <div class="row" style="display: <?= $queryBuilder->isShowInput($option, 'page_qty') ? '' : 'none'; ?>">
            <div class="col-xs-6 col-sm-3 col-md-3 page-qty">
                <?php
                echo $form->field($model, 'page_qty')->textInput([
                    'type' => 'tel',
                    'min' => 1,
                    'placeholder' => 'จำนวน'
                ])->label($queryBuilder->getInputLabel($option, 'page_qty', $model));
                ?>
            </div>
        </div>

        <!-- กระดาษ -->
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 paper-id">
                <?php
                echo $form->field($model, 'paper_id')->widget(Select2::classname(), [
                    'data' => $queryBuilder->getPaperOption(),
                    'options' => ['placeholder' => 'เลือกกระดาษ'],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label($queryBuilder->getInputLabel($option, 'paper_id', $model));
                ?>
            </div>
        </div>

        <!-- พิมพ์หน้าเดียว -->
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 before-print"
                 style="display: <?= $queryBuilder->isShowInput($option, 'print_one_page') ? '' : 'none'; ?>">
                <?php
                echo $form->field($model, 'print_one_page')->widget(Select2::classname(), [
                    'data' => $queryBuilder->getBeforePrintOption(),
                    'options' => ['placeholder' => 'เลือกตัวเลือก'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'templateResult' => new JsExpression('format'),
                        'templateSelection' => new JsExpression('format'),
                        'escapeMarkup' => $escape,
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label($queryBuilder->getInputLabel($option, 'print_one_page', $model));
                ?>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 after-print"
                 style="display: <?= $queryBuilder->isShowInput($option, 'print_two_page') ? '' : 'none'; ?>">
                <?php
                echo $form->field($model, 'print_two_page')->widget(Select2::classname(), [
                    'data' => $queryBuilder->getAfterPrintOption(),
                    'options' => ['placeholder' => 'เลือกตัวเลือก'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'templateResult' => new JsExpression('format'),
                        'templateSelection' => new JsExpression('format'),
                        'escapeMarkup' => $escape,
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label($queryBuilder->getInputLabel($option, 'print_two_page', $model));
                ?>
            </div>
        </div>
        <!-- เคลือบ -->
        <div class="row" style="display: <?= $queryBuilder->isShowInput($option, 'coating_id') ? '' : 'none'; ?>">
            <div class="col-xs-6 col-sm-6 col-md-6 coating-id">
                <?php
                echo $form->field($model, 'coating_id')->widget(Select2::classname(), [
                    'data' => $queryBuilder->getCoatingOption(),
                    'options' => ['placeholder' => 'เลือกวิธีเคลือบ'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'templateResult' => new JsExpression('format'),
                        'templateSelection' => new JsExpression('format'),
                        'escapeMarkup' => $escape,
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label($queryBuilder->getInputLabel($option, 'coating_id', $model));
                ?>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 coating-option" style="display: none;">
                <?php
                echo $form->field($model, 'coating_option')->radioList([
                    'one_page' => 'ด้านเดียว',
                    'two_page' => 'สองด้าน'
                ], [
                    'inline' => true,
                    'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                        $radio = Html::beginTag('div', ['class' => 'radio inline-block']) .
                            Html::beginTag('label', ['class' => 'radio-inline']) .
                            Html::radio($name, $checked, ['value' => $value, 'id' => Html::getInputId($model, 'coating_option').'-'.$index]) .
                            Html::tag('span', Icon::show('circle', ['class' => 'cr-icon']), ['class' => 'cr']) .
                            ucwords($label) .
                            Html::endTag('label') .
                            Html::endTag('div');
                        return $radio;
                    }
                ])->label('เคลือบด้านเดียว หรือ สองด้าน?');
                ?>
            </div>
        </div>
        <!-- ไดคัท -->
        <span class="label label-option"
              style="display: <?= $queryBuilder->isShowInput($option, 'diecut') ? '' : 'none'; ?>">
            <?= Icon::show('angle-double-down') . ' ไดคัท ' . Icon::show('angle-double-down') ?>
        </span>
        <div class="row" style="display: <?= $queryBuilder->isShowInput($option, 'diecut') ? '' : 'none'; ?>">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?php
                echo $form->field($model, 'diecut')->radioList([
                    'N' => 'ไม่ไดคัท',
                    'Default' => 'ไดคัทตามรูปแบบ',
                    'Curve' => 'ไดคัทมุมมน'
                ], [
                    'inline' => true,
                    'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                        $radio = Html::beginTag('div', ['class' => 'radio inline-block']) .
                            Html::beginTag('label', ['class' => 'radio-inline']) .
                            Html::radio($name, $checked, ['value' => $value, 'id' => Html::getInputId($model, 'diecut').'-'.$index]) .
                            Html::tag('span', Icon::show('circle', ['class' => 'cr-icon']), ['class' => 'cr']) .
                            ucwords($label) .
                            Html::endTag('label') .
                            Html::endTag('div');
                        return $radio;
                    }
                ])->label(false);
                ?>
            </div>
        </div>
        <div class="row diecut-id" style="display: none">
            <div class="col-xs-6 col-sm-6 col-md-6 diecut-id"
                 style="display: <?= $queryBuilder->isShowInput($option, 'diecut_id') ? '' : 'none'; ?>">
                <?php
                echo $form->field($model, 'diecut_id')->widget(Select2::classname(), [
                    'data' => $queryBuilder->getDiecutOption(),
                    'options' => ['placeholder' => 'เลือกไดคัท'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label($queryBuilder->getInputLabel($option, 'diecut_id', $model));
                ?>
            </div>
        </div>
        
        <!-- ตัดเป็นตัว/เจาะ -->
        <span class="label label-option" style="display: <?= $queryBuilder->isShowInput($option, 'perforate') ? '' : 'none'; ?>" >
            <?= Icon::show('angle-double-down') . 'ตัดเป็นตัว/เจาะ' . Icon::show('angle-double-down') ?>
        </span>
        <div class="row" style="display: <?= $queryBuilder->isShowInput($option, 'perforate') ? '' : 'none'; ?>">
              <div class="col-xs-6 col-sm-6 col-md-6 coating-id">
                    <?php
                        echo $form->field($model, 'perforate')->widget(Select2::classname(), [
                    'data' => [
                        0 => 'ตัดเป็นตัวอย่างเดียว',
                        1 => 'ตัดเป็นตัว + เจาะรูกลม'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'options' => ['placeholder' => 'เลือก'],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label(false);
                ?>
             </div>
        </div>
         <div class="row perforate-option" style="display: none">
            <div class="col-xs-6 col-sm-6 col-md-6 perforate-option">
                    <?php
                    echo $form->field($model, 'perforate_option_id')->widget(Select2::classname(), [
                        'data' => $queryBuilder->getPerforateOption(),
                        'options' => ['placeholder' => 'เลือกมุมเจาะ'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'templateResult' => new JsExpression('format'),
                            'templateSelection' => new JsExpression('format'),
                            'escapeMarkup' => $escape,
                        ],
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'size' => Select2::MEDIUM,
                    ])->label($queryBuilder->getInputLabel($option, 'perforate_option_id', $model));
                    ?>
            </div>
         </div>
        <!-- วิธีพับ -->
        <span class="label label-option"
              style="display: <?= $queryBuilder->isShowInput($option, 'fold_id') ? '' : 'none'; ?>">
            <?= Icon::show('angle-double-down') . ' วิธีพับ ' . Icon::show('angle-double-down') ?>
        </span>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 fold-id"
                 style="display: <?= $queryBuilder->isShowInput($option, 'fold_id') ? '' : 'none'; ?>">
                <?php
                echo $form->field($model, 'fold_id')->widget(Select2::classname(), [
                    'data' => $queryBuilder->getFoldOption(),
                    //'options' => ['placeholder' => 'เลือกวิธีพับ'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'templateResult' => new JsExpression('format'),
                        'templateSelection' => new JsExpression('format'),
                        'escapeMarkup' => $escape,
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label($queryBuilder->getInputLabel($option, 'fold_id', $model));
                ?>
            </div>
        </div>
        <!-- ฟอยล์ -->
        <span class="label label-option"
              style="display: <?= $queryBuilder->isShowInput($option, 'foil_color_id') ? '' : 'none'; ?>">
            <?= Icon::show('angle-double-down') . ' ฟอยล์ ' . Icon::show('angle-double-down') ?>
        </span>
        <div class="row foil-option" style="display: <?= $queryBuilder->isShowInput($option, 'foil_color_id') ? '' : 'none'; ?>">
            <div class="col-xs-6 col-sm-3 col-md-3 foil-size-width">
                <?php
                echo $form->field($model, 'foil_size_width')->textInput([
                    //'type' => 'number',
                    //'min' => 0,
                    'placeholder' => 'กว้าง'
                ])->label('กว้าง');
                ?>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-3 foil-size-height">
                <?php
                echo $form->field($model, 'foil_size_height')->textInput([
                    //'type' => 'number',
                    //'min' => 0,
                    'placeholder' => 'ยาว'
                ])->label('ยาว');
                ?>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-3 foil-size-unit">
                <?php
                echo $form->field($model, 'foil_size_unit')->widget(Select2::classname(), [
                    //'data' => ArrayHelper::map(TblUnit::find()->asArray()->all(), 'unit_id', 'unit_name'),
                    'data' => ArrayHelper::map(TblUnit::find()->where(['unit_id' => [2,3]])->asArray()->all(), 'unit_id', 'unit_name'),
                    'options' => ['placeholder' => 'เลือกหน่วย'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label('หน่วย');
                ?>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-3 foil-color-id">
                <?php
                echo $form->field($model, 'foil_color_id')->widget(Select2::classname(), [
                    'data' => $queryBuilder->getFoilOption(),
                    'options' => ['placeholder' => 'เลือกสีฟอยล์'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'templateResult' => new JsExpression('format'),
                        'templateSelection' => new JsExpression('format'),
                        'escapeMarkup' => $escape,
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label($queryBuilder->getInputLabel($option, 'foil_color_id', $model));
                ?>
            </div>
        </div>
        <div class="row foil-option" style="display: <?= $queryBuilder->isShowInput($option, 'foil_print') ? '' : 'none'; ?>">
            <div class="col-xs-12 col-sm-12 col-md-12 foil-size-width">
                <?php
                echo $form->field($model, 'foil_print')->radioList([
                    'two_page' => 'ทั้งหน้า/หลัง',
                    'one_page' => 'หน้าเดียว'
                ], [
                    'inline' => true,
                    'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                        $radio = Html::beginTag('div', ['class' => 'radio inline-block']) .
                            Html::beginTag('label', ['class' => 'radio-inline']) .
                            Html::radio($name, $checked, ['value' => $value, 'id' => Html::getInputId($model, 'foil_print').'-'.$index]) .
                            Html::tag('span', Icon::show('circle', ['class' => 'cr-icon']), ['class' => 'cr']) .
                            ucwords($label) .
                            Html::endTag('label') .
                            Html::endTag('div');
                        return $radio;
                    }
                ])->label('ปั๊มฟอยล์ทั้งหน้า/หลัง หรือหน้าเดียว?');
                ?>
            </div>
        </div>
        <!-- ปั๊มนูน -->
        <span class="label label-option"
              style="display: <?= $queryBuilder->isShowInput($option, 'emboss_size_width') ? '' : 'none'; ?>">
            <?= Icon::show('angle-double-down') . ' ปั๊มนูน ' . Icon::show('angle-double-down') ?>
        </span>
        <div class="row emboss-option"
             style="display: <?= $queryBuilder->isShowInput($option, 'emboss_size_width') ? '' : 'none'; ?>">
            <div class="col-xs-6 col-sm-3 col-md-3 emboss-size-width">
                <?php
                echo $form->field($model, 'emboss_size_width')->textInput([
                    //'type' => 'number',
                    //'min' => 0,
                    'placeholder' => 'กว้าง'
                ])->label('กว้าง');
                ?>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-3 emboss-size-height">
                <?php
                echo $form->field($model, 'emboss_size_height')->textInput([
                    //'type' => 'number',
                    //'min' => 0,
                    'placeholder' => 'ยาว'
                ])->label('ยาว');
                ?>
            </div>
            <div class="col-xs-6 col-sm-3 col-md-3 emboss-size-unit">
                <?php
                echo $form->field($model, 'emboss_size_unit')->widget(Select2::classname(), [
                  //  'data' => ArrayHelper::map(TblUnit::find()->asArray()->all(), 'unit_id', 'unit_name'),
                    'data' => ArrayHelper::map(TblUnit::find()->where(['unit_id' => [2,3]])->asArray()->all(), 'unit_id', 'unit_name'),
                    'options' => ['placeholder' => 'เลือกหน่วย'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'size' => Select2::MEDIUM,
                ])->label('หน่วย');/*($queryBuilder->getInputLabel($option, 'emboss_size_unit', $model));*/
                ?>
            </div>
        </div>
        <div class="row emboss-option"
             style="display: <?= $queryBuilder->isShowInput($option, 'emboss_print') ? '' : 'none'; ?>">
             <div class="col-xs-12 col-sm-12 col-md-12 foil-size-width">
                <?php
                echo $form->field($model, 'emboss_print')->radioList([
                    'two_page' => 'ทั้งหน้า/หลัง',
                    'one_page' => 'หน้าเดียว'
                ], [
                    'inline' => true,
                    'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                        $radio = Html::beginTag('div', ['class' => 'radio inline-block']) .
                            Html::beginTag('label', ['class' => 'radio-inline']) .
                            Html::radio($name, $checked, ['value' => $value, 'id' => Html::getInputId($model, 'emboss_print').'-'.$index]) .
                            Html::tag('span', Icon::show('circle', ['class' => 'cr-icon']), ['class' => 'cr']) .
                            ucwords($label) .
                            Html::endTag('label') .
                            Html::endTag('div');
                        return $radio;
                    }
                ])->label('ปั๊มนูนทั้งหน้า/หลัง หรือหน้าเดียว?');
                ?>
            </div>
        </div>
        <!-- ปะกาว  -->
            <!--------ปะกาวจะไม่แสดงข้อมูลหน้า web เนื่องจากมีการบังคับให้เลือก auto เลย จากหน้าตั้งค่าสินค้า ลูกค้าจะไม่สามารถเลือกเองได้---> 
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 glue"
                 style="display: <?= $queryBuilder->isShowInput($option, 'glue') ? '' : 'none'; ?>">
                <?php
                $model->glue = $queryBuilder->isShowInput($option, 'glue') ? 1 : 0;
                echo $form->field($model, 'glue')->radioList([
                    0 => 'No',
                    1 => 'Yes'
                ], [
                    'inline' => true,
                    'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                        $radio = Html::beginTag('div', ['class' => 'radio inline-block hidden']) .
                            Html::beginTag('label', ['class' => 'radio-inline']) .
                            Html::radio($name, $checked, ['value' => $value, 'id' => Html::getInputId($model, 'glue').'-'.$index]) .
                            Html::tag('span', Icon::show('circle', ['class' => 'cr-icon']), ['class' => 'cr']) .
                            ucwords($label) .
                            Html::endTag('label') .
                            Html::endTag('div');
                        return $radio;
                    }
                ])->label(false);
                ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?= Html::activeHiddenInput($model, 'quotation_id'); ?>
                <?= Html::activeHiddenInput($model, 'product_id'); ?>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <?= $modelProduct['product_description'] ?>
    </div>
</div>

