<?php

use yii\widgets\Breadcrumbs;

?>
<section class="pageTitleSection"
         style="background-image: url(http://santipab.co.th/wp-content/uploads/NoteBook%20Galler/Diary%201.JPG);">
    <div class="container">
        <div class="pageTitleInfo">
            <h2><?= $this->title ?></h2>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'options' => ['class' => 'breadcrumb']
            ]) ?>
        </div>
    </div>
</section>