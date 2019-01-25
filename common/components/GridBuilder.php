<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 21/1/2562
 * Time: 9:31
 */
namespace common\components;

use yii\base\Component;
use adminlte\helpers\Html;
use kartik\icons\Icon;
use yii\data\ActiveDataProvider;
use common\modules\app\models\TblPaperSize;
use common\modules\app\models\TblColorPrinting;
use common\modules\app\models\TblPaper;
use common\modules\app\models\TblCoating;
use common\modules\app\models\TblDiecut;
use common\modules\app\models\TblFold;
use common\modules\app\models\TblFoilColor;
use common\modules\app\models\TblBookBinding;

class GridBuilder extends Component
{
    public static function getDataPaperSize($model)
    {
        $provider = new ActiveDataProvider([
            'query' => TblPaperSize::find(),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $provider;
    }

    public static function getDataColorPrinting($model)
    {
        $provider = new ActiveDataProvider([
            'query' => TblColorPrinting::find(),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $provider;
    }

    public static function getDataPaper($model)
    {
        $provider = new ActiveDataProvider([
            'query' => TblPaper::find(),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $provider;
    }

    public static function getDataCoating($model)
    {
        $provider = new ActiveDataProvider([
            'query' => TblCoating::find(),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $provider;
    }

    public static function getDataDiecut($model)
    {
        $provider = new ActiveDataProvider([
            'query' => TblDiecut::find(),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $provider;
    }

    public static function getDataFold($model)
    {
        $provider = new ActiveDataProvider([
            'query' => TblFold::find(),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $provider;
    }

    public static function getDataFoilColor($model)
    {
        $provider = new ActiveDataProvider([
            'query' => TblFoilColor::find(),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $provider;
    }

    public static function getDataBookBinding($model)
    {
        $provider = new ActiveDataProvider([
            'query' => TblBookBinding::find(),
            'pagination' => [
                'pageSize' => false,
            ],
        ]);
        return $provider;
    }

    public static function getCheckboxTemplate($value, $checked = false)
    {
        return Html::beginTag('div', ['class' => 'checkbox', 'style' => 'margin-top: 0px;margin-bottom: 0px;']) .
            Html::beginTag('label',['style' => 'min-height: 0px;padding-left: 5px;']) .
            Html::checkbox('selection[]', $checked, ['value' => $value, 'class' => 'kv-row-checkbox']) .
            Html::tag('span', Icon::show('ok', ['class' => 'cr-icon', 'framework' => Icon::BSG]), ['class' => 'cr']) .
            Html::endTag('label') .
            Html::endTag('div');
    }

    public static function getCheckboxHeaderTemplate()
    {
        return Html::beginTag('div', ['class' => 'checkbox', 'style' => 'margin-top: 0px;margin-bottom: 0px;']) .
            Html::beginTag('label',['style' => 'min-height: 0px;padding-left: 5px;']) .
            Html::checkbox('selection_all', false, ['class' => 'select-on-check-all', 'value' => 1]) .
            Html::tag('span', Icon::show('ok', ['class' => 'cr-icon', 'framework' => Icon::BSG]), ['class' => 'cr']) .
            Html::endTag('label') .
            Html::endTag('div');
    }
}