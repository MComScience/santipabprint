<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 21/1/2562
 * Time: 10:37
 */
namespace adminlte\widgets;

use Closure;
use yii\helpers\Html;
use kartik\grid\CheckboxColumn as BaseCheckboxColumn;
use yii\helpers\Json;

class CheckboxColumn extends BaseCheckboxColumn
{
    public $content;

    protected function renderDataCellContent($model, $key, $index)
    {
        /*if ($this->content !== null) {
            return parent::renderDataCellContent($model, $key, $index);
        }*/
        if ($this->content instanceof Closure) {
            return call_user_func($this->content, $model, $key, $index, $this);
        }
        if ($this->checkboxOptions instanceof Closure) {
            $options = call_user_func($this->checkboxOptions, $model, $key, $index, $this);
        } else {
            $options = $this->checkboxOptions;
        }
        if (!isset($options['value'])) {
            $options['value'] = is_array($key) ? Json::encode($key) : $key;
        }
        if ($this->cssClass !== null) {
            Html::addCssClass($options, $this->cssClass);
        }
        return Html::checkbox($this->name, !empty($options['checked']), $options);
    }
}