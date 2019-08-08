<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/1/2562
 * Time: 10:36
 */

namespace common\components;

use common\modules\app\models\TblBookBinding;
use common\modules\app\models\TblCoating;
use common\modules\app\models\TblColorPrinting;
use common\modules\app\models\TblDiecut;
use common\modules\app\models\TblDiecutGroup;
use common\modules\app\models\TblFoilColor;
use common\modules\app\models\TblFold;
use common\modules\app\models\TblPaper;
use common\modules\app\models\TblPaperSize;
use common\modules\app\models\TblPaperType;
use common\modules\app\models\TblProductOption;
use common\modules\app\models\TblPerforateOption;
use common\modules\app\models\TblPerforate;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use adminlte\helpers\Html;

class QueryBuilder extends Component {

    public $modelOption;

    public function init() {
        parent::init();
        if ($this->modelOption === null) {
            throw new InvalidConfigException('"modelOption" has not been set');
        }
    }

    //ขนาด
    public function getPaperSizeOption() {
        $option = $this->modelOption;
        $condition = static::decodeOption($option['paper_size_option']);
        $query = TblPaperSize::find()->where(['paper_size_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'paper_size_id', 'paper_size_name', 'paper_size_description');
        return ArrayHelper::merge([
                    'custom' => 'กำหนดเอง' . Html::tag('p', Html::tag('span', 'กำหนดขนาดเอง', [
                                'class' => 'desc'
                            ]), []),
                        ], $options);
    }

    public function getPaperOption() {
        $option = $this->modelOption;
        $condition = static::decodeOption($option['paper_option']);
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
    public function getBeforePrintOption() {
        $option = $this->modelOption;
        $condition = static::decodeOption($option['print_one_page']);
        $query = TblColorPrinting::find()->where(['color_printing_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'color_printing_id', 'color_printing_name', 'color_printing_descriotion');
        return $options;
    }

    //ด้านหลังพิมพ์
    public function getAfterPrintOption() {
        $option = $this->modelOption;
        $condition = static::decodeOption($option['print_two_page']);
        $query = TblColorPrinting::find()->where(['color_printing_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'color_printing_id', 'color_printing_name', 'color_printing_descriotion');
        return $options;
    }

    //เคลือบ
    public function getCoatingOption() {
        $option = $this->modelOption;
        $condition = static::decodeOption($option['coating_option']);
        $query = TblCoating::find()->where(['coating_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'coating_id', 'coating_name', 'coating_description');
        return ArrayHelper::merge([
                    'N' => 'ไม่เคลือบ'
                        ], $options);
    }

    //ไดคัท
    public function getDiecutOption() {
        $option = $this->modelOption;
        $condition = static::decodeOption($option['diecut_option']);
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
    public function getFoldOption() {
        $option = $this->modelOption;
        $condition = static::decodeOption($option['fold_option']);
        $query = TblFold::find()->where(['fold_id' => $condition])->asArray()->orderBy('fold_id asc')->all();
        $options = $this->renderOption($query, 'fold_id', 'fold_name', 'fold_description');
        return ArrayHelper::merge([
                    'N' => 'ไม่พับ',
                        ], $options);
    }

    //สีฟอยล์
    public function getFoilOption() {
        $option = $this->modelOption;
        $condition = static::decodeOption($option['foil_color_option']);
        $query = TblFoilColor::find()->where(['foil_color_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'foil_color_id', 'foil_color_name', 'foil_color_description');
        return $options;
    }

    //วิธีเข้าเล่ม
    public function getBookBindingOption() {
        $option = $this->modelOption;
        $condition = static::decodeOption($option['book_binding_option']);
        $query = TblBookBinding::find()->where(['book_binding_id' => $condition])->asArray()->all();
        $options = $this->renderOption($query, 'book_binding_id', 'book_binding_name', 'book_binding_description');
        return ArrayHelper::merge([
                    'N' => 'ไม่เข้าเล่ม'
                        ], $options);
    }

    public static function decodeOption($option) {
        if (!empty($option)) {
            return Json::decode($option);
        }
        return [];
    }

    private function renderOption($items, $key, $value, $desc) {
        $options = [];
        foreach ($items as $item) {
            $options[] = [
                'key' => $item[$key],
                'value' => $item[$value] .
                Html::tag('p', Html::tag('span', $item[$desc], [
                            'class' => 'desc'
                        ]), [])
            ];
        }
        return ArrayHelper::map($options, 'key', 'value');
    }

    public function getInputLabel($option, $field, $model) {
        $textRequired = Html::tag('span', '*', ['class' => 'text-danger']);
        if (isset($option[$field]['label'])) {
            return $option[$field]['label'] . ($option[$field]['required'] === '1' ? $textRequired : '');
        }
        return $model->getAttributeLabel($field);
    }

    public function isShowInput($option, $field) {
        $isShow = false;
        if (isset($option[$field]) && isset($option[$field]['value']) && $option[$field]['value'] === '1') {
            $isShow = !$isShow;
        }
        return $isShow;
    }

    //ตัด/เจาะ
    public function getPerforateOption() {
        $option = $this->modelOption;
        $condition = static::decodeOption($option['perforate_option']);
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

}
