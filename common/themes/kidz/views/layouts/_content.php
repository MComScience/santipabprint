<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/11/2561
 * Time: 22:37
 */

use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

?>
<transition>
  <router-view></router-view>
</transition>
<div v-if="$route.matched.length == 0" class="content-wrapper">
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

