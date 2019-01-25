<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 24/1/2562
 * Time: 11:57
 */

namespace common\components;

use Yii;
use yii\base\Component;

class SlugUrl extends Component
{
    public function create($str)
    {
        $slug = preg_replace('@[\s!:;_\?=\\\+\*/%&#]+@', '-', $str);
        $slug = mb_strtolower($slug, Yii::$app->charset);
        $slug = trim($slug, '-');

        return $slug;
    }
}