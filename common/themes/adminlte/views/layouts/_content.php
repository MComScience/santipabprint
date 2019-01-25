<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 10/1/2562
 * Time: 9:05
 */
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $this->title; ?>
            <small></small>
        </h1>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'options' => [
                'class' => 'breadcrumb',
            ],
            'tag' => 'ol',
        ]) ?>
    </section>
    <!-- Main content -->
    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>
<!-- /.content-wrapper -->
