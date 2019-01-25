<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 10/1/2562
 * Time: 13:30
 */

namespace adminlte\helpers;

use yii\helpers\BaseHtml;
use kartik\icons\Icon;

class Html extends BaseHtml
{
    public static function btnCancelModal()
    {
        return static::button(Icon::show('close') . 'ยกเลิก', [
            'class' => 'btn btn-default',
            'data-dismiss' => 'modal',
            'data-toggle' => 'tooltip',
            'title' => 'ยกเลิก'
        ]);
    }

    public static function btnCloseModal()
    {
        return static::button(Icon::show('close') . 'ปิด', [
            'class' => 'btn btn-default',
            'data-dismiss' => 'modal',
            'data-toggle' => 'tooltip',
            'title' => 'ปิด'
        ]);
    }

    public static function btnSubmitModal()
    {
        return static::submitButton(Icon::show('save') . 'บันทึก', [
            'class' => 'btn btn-success',
            'data-toggle' => 'tooltip',
            'title' => 'บันทึก'
        ]);
    }

    public static function alertSuccess($text = 'Success')
    {
        return static::beginTag('div',['class' => 'alert alert-success alert-dismissible']).
            static::button('x',['class' => 'close','data-dismiss' => 'alert','aria-hidden' => 'true']).
            static::tag('strong',Icon::show('check',['class' => 'icon']).' '.$text).
            static::endTag('div');
    }

    public static function starRequired()
    {
        return static::tag('span', '*', ['style' => 'color: red;']);
    }
}