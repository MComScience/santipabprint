<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/1/2562
 * Time: 10:36
 */

namespace common\components;

use adminlte\helpers\Html;
use common\modules\app\models\TblBookBinding;
use common\modules\app\models\TblCoating;
use common\modules\app\models\TblColorPrinting;
use common\modules\app\models\TblDiecut;
use common\modules\app\models\TblFoilColor;
use common\modules\app\models\TblFold;
use common\modules\app\models\TblPaper;
use common\modules\app\models\TblPaperSize;
use common\modules\app\models\TblPaperType;
use common\modules\app\models\TblPerforate;
use common\modules\app\models\TblPerforateOption;
use common\modules\app\models\TblUnit;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class QueryBuilder extends Component
{

    public $modelOption;
    public $product;
    public $options;

    public function init()
    {
        parent::init();
        if ($this->modelOption === null) {
            throw new InvalidConfigException('"modelOption" has not been set');
        }
        $this->options = unserialize($this->product->product_options);
    }

    //ขนาด
    public function getPaperSizeOption()
    {
        // $option = $this->modelOption;
        $setting = ArrayHelper::getValue($this->options, 'paper_size_id', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []); //static::decodeOption($option['paper_size_option']);
        $query = TblPaperSize::find()->where(['paper_size_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'paper_size_id', 'paper_size_name', 'paper_size_description');
        if (ArrayHelper::isIn('custom', $condition)) {
            $options = ArrayHelper::merge([
                'custom' => 'กำหนดเอง' . Html::tag('p', Html::tag('span', 'กำหนดขนาดเอง', [
                    'class' => 'desc',
                ]), []),
            ], $options);
        }
        return $options;
    }

    // กระดาษปกหนังสือ
    public function getBookCoversPaperOption()
    {
        $setting = ArrayHelper::getValue($this->options, 'book_covers_paper', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $papers = TblPaper::find()->where(['paper_id' => $condition])->orderBy('paper_type_id asc,paper_gram asc')->all();
        $paperTypes = TblPaperType::find()->where(['paper_type_id' => ArrayHelper::getColumn($papers, 'paper_type_id')])->all();
        $options = [];
        foreach ($paperTypes as $paperType) {
            $children = [];
            foreach ($papers as $paper) {
                if ($paper['paper_type_id'] === $paperType['paper_type_id']) {
                    $children[$paper['paper_id']] = $paper->paper_name;
                }
            }
            if ($children) {
                $options[$paperType['paper_type_name']] = $children;
            }
        }
        return $options;;
    }

    // กระดาษขาวดำ(เนื้อใน)
    public function getBookInnerPaperWithoutColorOption()
    {
        $setting = ArrayHelper::getValue($this->options, 'book_inner_paper_without_color', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $papers = TblPaper::find()->where(['paper_id' => $condition])->orderBy('paper_type_id asc,paper_gram asc')->all();
        $paperTypes = TblPaperType::find()->where(['paper_type_id' => ArrayHelper::getColumn($papers, 'paper_type_id')])->all();
        $options = [];
        foreach ($paperTypes as $paperType) {
            $children = [];
            foreach ($papers as $paper) {
                if ($paper['paper_type_id'] === $paperType['paper_type_id']) {
                    $children[$paper['paper_id']] = $paper->paper_name;
                }
            }
            if ($children) {
                $options[$paperType['paper_type_name']] = $children;
            }
        }
        return $options;;
    }


    // กระดาษเนื้อใน
    public function getBookInnerPaperOption()
    {
        $setting = ArrayHelper::getValue($this->options, 'book_inner_paper', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $papers = TblPaper::find()->where(['paper_id' => $condition])->orderBy('paper_type_id asc,paper_gram asc')->all();
        $paperTypes = TblPaperType::find()->where(['paper_type_id' => ArrayHelper::getColumn($papers, 'paper_type_id')])->all();
        $options = [];
        foreach ($paperTypes as $paperType) {
            $children = [];
            foreach ($papers as $paper) {
                if ($paper['paper_type_id'] === $paperType['paper_type_id']) {
                    $children[$paper['paper_id']] = $paper->paper_name;
                }
            }
            if ($children) {
                $options[$paperType['paper_type_name']] = $children;
            }
        }
        return $options;;
    }

    public function getPaperOption()
    {
        // $option = $this->modelOption;
        $setting = ArrayHelper::getValue($this->options, 'paper_id', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []); // static::decodeOption($option['paper_option']);
        // $papers = TblPaper::find()->where(['paper_id' => $condition])->all();
        $papers = TblPaper::find()->where(['paper_id' => $condition])->orderBy('paper_type_id asc,paper_gram asc')->all();
        $paperTypes = TblPaperType::find()->where(['paper_type_id' => ArrayHelper::getColumn($papers, 'paper_type_id')])->all();
        $options = [];
        foreach ($paperTypes as $paperType) {
            //$papers = TblPaper::find()->where(['paper_type_id' => $paperType['paper_type_id']])->asArray()->all();
            $children = [];
            foreach ($papers as $paper) {
                if ($paper['paper_type_id'] === $paperType['paper_type_id']) {
                    $children[$paper['paper_id']] = $paper->paper_name;
                }
            }
            if ($children) {
                $options[$paperType['paper_type_name']] = $children;
            }
        }
        return $options;
    }

    //ด้านหน้าพิมพ์
    public function getBeforePrintOption()
    {
        /*$option = $this->modelOption;
        $condition = static::decodeOption($option['print_one_page']);*/
        $setting = ArrayHelper::getValue($this->options, 'print_color', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $query = TblColorPrinting::find()->where(['color_printing_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'color_printing_id', 'color_printing_name', 'color_printing_descriotion');
        return $options;
    }

    //ด้านหลังพิมพ์
    public function getAfterPrintOption()
    {
        $option = $this->modelOption;
        $condition = static::decodeOption($option['print_two_page']);
        $query = TblColorPrinting::find()->where(['color_printing_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'color_printing_id', 'color_printing_name', 'color_printing_descriotion');
        return $options;
    }

    //เคลือบ
    public function getCoatingOption()
    {
        /*$option = $this->modelOption;
        $condition = static::decodeOption($option['coating_option']);*/
        $setting = ArrayHelper::getValue($this->options, 'coating_id', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $query = TblCoating::find()->where(['coating_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'coating_id', 'coating_name', 'coating_description');
        if (ArrayHelper::isIn('N', $condition)) {
            $options = ArrayHelper::merge([
                'N' => 'ไม่เคลือบ',
            ], $options);
        }
        return $options;
    }

    //ไดคัท
    public function getDiecutRoundedOption()
    {
        /*$option = $this->modelOption;
        $condition = static::decodeOption($option['diecut_option']);*/
        $setting = ArrayHelper::getValue($this->options, 'diecut_id', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $diecuts = TblDiecut::find()->where(['diecut_id' => $condition])->asArray()->all();
//        $diecutGroups = TblDiecutGroup::find()->where(['diecut_group_id' => ArrayHelper::getColumn($diecuts, 'diecut_group_id')])->all();
        //        $options = [];
        //        foreach ($diecutGroups as $diecutGroup) {
        //            $children = [];
        //            foreach ($diecuts as $diecut) {
        //                if ($diecut['diecut_group_id'] === $diecutGroup['diecut_group_id']) {
        //                    $children[$diecut['diecut_id']] = $diecut['diecut_name'];
        //                }
        //            }
        //            if ($children) {
        //                $options[$diecutGroup['diecut_group_name']] = $children;
        //            }
        //        }
        /* return ArrayHelper::merge([
        'N' => 'ไม่ไดคัท',
        'default' => 'ไดคัทตามรูปแบบ'
        ], $options); */
        return ArrayHelper::map($diecuts, 'diecut_id', 'diecut_name');
    }

    //วิธีพับ
    public function getFoldOption()
    {
        /*$option = $this->modelOption;
        $condition = static::decodeOption($option['fold_option']);*/
        $setting = ArrayHelper::getValue($this->options, 'fold_id', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $query = TblFold::find()->where(['fold_id' => $condition])->asArray()->orderBy('fold_id asc')->all();
        $options = $this->renderOption($query, 'fold_id', 'fold_name', 'fold_description');
        if (ArrayHelper::isIn('N', $condition)) {
            $options = ArrayHelper::merge([
                'N' => 'ไม่พับ',
            ], $options);
        }
        return $options;
    }

    //สีฟอยล์
    public function getFoilOption()
    {
        /*$option = $this->modelOption;
        $condition = static::decodeOption($option['foil_color_option']);*/
        $setting = ArrayHelper::getValue($this->options, 'foil_color_id', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $query = TblFoilColor::find()->where(['foil_color_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'foil_color_id', 'foil_color_name', 'foil_color_description');
        return $options;
    }

    //วิธีเข้าเล่ม
    public function getBookBindingOption()
    {
        // $option = $this->modelOption;
        $setting = ArrayHelper::getValue($this->options, 'book_binding_id', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []); // static::decodeOption($option['book_binding_option']);
        $query = TblBookBinding::find()->where(['book_binding_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'book_binding_id', 'book_binding_name', 'book_binding_description');
        if (ArrayHelper::isIn('N', $condition)) {
            $options = ArrayHelper::merge([
                'N' => 'ไม่เข้าเล่ม',
            ], $options);
        }
        return $options;
    }

    public static function decodeOption($option)
    {
        if (!empty($option)) {
            return Json::decode($option);
        }
        return [];
    }

    private function renderOption($items, $key, $value, $desc)
    {
        $options = [];
        foreach ($items as $item) {
            $options[] = [
                'key' => $item[$key],
                'value' => $item[$value] .
                Html::tag('p', Html::tag('span', $item[$desc], [
                    'class' => 'desc',
                ]), [])
            ];
        }
        return ArrayHelper::map($options, 'key', 'value');
    }

    public function getInputLabel($option, $field, $model)
    {
        $textRequired = Html::tag('span', '*', ['class' => 'text-danger']);
        if (isset($option[$field]['label'])) {
            return $option[$field]['label'] . ($option[$field]['required'] === '1' ? $textRequired : '');
        }
        return $model->getAttributeLabel($field);
    }

    public function isShowInput($option, $field)
    {
        $isShow = false;
        if (isset($option[$field]) && isset($option[$field]['value']) && $option[$field]['value'] === '1') {
            $isShow = !$isShow;
        }
        return $isShow;
    }

    //ตัด/เจาะ
    public function getPerforateOption()
    {
        /*$option = $this->modelOption;
        $condition = static::decodeOption($option['perforate_option']);*/
        $setting = ArrayHelper::getValue($this->options, 'perforate_option_id', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $perforateOptions = TblPerforateOption::find()->where(['perforate_option_id' => $condition])->asArray()->all();
        $perforates = TblPerforate::find()->where(['perforate_id' => ArrayHelper::getColumn($perforateOptions, 'perforate_id')])->all();
        $options = [];
        foreach ($perforates as $perforate) {
            $children = [];
            foreach ($perforateOptions as $perforateOption) {
                if ($perforateOption['perforate_id'] == $perforate['perforate_id']) {
                    $children[$perforateOption['perforate_option_id']] = $perforateOption['perforate_option_name'];
                }
            }
            if ($children) {
                $options[$perforate['perforate_name']] = $children;
            }
        }
        return $options;
    }

    // ตัดเป็นตัว+เจาะมุม,ตัดเป็นตัว
    public function getPerforate()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'perforate', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('perforate');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = $option;
            }
        }
        return ArrayHelper::map($dataOptions, 'id', 'name');
    }

    // หน่วยฟอยล์
    public function getFoilUnitOption()
    {
        $setting = ArrayHelper::getValue($this->options, 'foil_size_unit', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        return ArrayHelper::map(TblUnit::find()->where(['unit_id' => $condition])->asArray()->all(), 'unit_id', 'unit_name');
    }

    // หน่วย ปั๊มนูน
    public function getEmbossUnitOption()
    {
        $setting = ArrayHelper::getValue($this->options, 'emboss_size_unit', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        return ArrayHelper::map(TblUnit::find()->where(['unit_id' => $condition])->asArray()->all(), 'unit_id', 'unit_name');
    }

    // หน่วยขนาดกำหนดเอง
    public function getPaperSizeCustomUnitOption()
    {
        $setting = ArrayHelper::getValue($this->options, 'paper_size_unit', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        return ArrayHelper::map(TblUnit::find()->where(['unit_id' => $condition])->asArray()->all(), 'unit_id', 'unit_name');
    }

    // พิมพ์ สองหน้า/หน้าเดียว
    public function getPrintOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'print_option', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('print_option');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'id' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getCoatingOnePageTwoPageOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'coating_option', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('coating_option');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'value' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getDicutStatusOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'diecut_status', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('diecut_status');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'value' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getFoilPrintOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'foil_print', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('foil_print');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'value' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getEmbossPrintOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'emboss_print', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('emboss_print');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'value' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getGlueOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'glue', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('glue');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'value' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getRopeOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'rope', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('rope');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'value' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getLandOrientOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'land_orient', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('land_orient');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'value' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getFoilStatusOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'foil_status', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('foil_status');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'value' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getEmbossStatusOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'emboss_status', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('emboss_status');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'value' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getDiecutOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'diecut', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('diecut');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'id' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getBookBindingStatusOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'book_binding_status', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('book_binding_status');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'id' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getPerforatedRippedOption()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'perforated_ripped', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('perforated_ripped');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'id' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getRunningNumberOptions()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'running_number', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('running_number');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'id' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    public function getWindowBoxOptions()
    {
        $dataOptions = [];
        $setting = ArrayHelper::getValue($this->options, 'window_box', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $inputOptions = InPutOptions::getOption('window_box');
        foreach ($inputOptions as $option) {
            if (ArrayHelper::isIn($option['id'], $condition)) {
                $dataOptions[] = [
                    'id' => $option['id'],
                    'text' => $option['name'],
                ];
            }
        }
        return $dataOptions;
    }

    // หน่วยติดหน้าต่าง
    public function getWindowBoxUnitOption()
    {
        $setting = ArrayHelper::getValue($this->options, 'window_box_unit', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        return ArrayHelper::map(TblUnit::find()->where(['unit_id' => $condition])->asArray()->all(), 'unit_id', 'unit_name');
    }

    //สีที่พิมพ์ปกหนังสือ
    public function getBookCoversColorOption()
    {
        $setting = ArrayHelper::getValue($this->options, 'book_covers_color', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $query = TblColorPrinting::find()->where(['color_printing_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'color_printing_id', 'color_printing_name', 'color_printing_descriotion');
        return $options;
    }

    //สี่ที่พิมพ์(เนื้อใน)
    public function getBookInnerColorOption()
    {
        $setting = ArrayHelper::getValue($this->options, 'book_inner_color', []);
        $condition = empty($setting['options']) ? [] : ArrayHelper::getValue($setting, 'options', []);
        $query = TblColorPrinting::find()->where(['color_printing_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'color_printing_id', 'color_printing_name', 'color_printing_descriotion');
        return $options;
    }

}
