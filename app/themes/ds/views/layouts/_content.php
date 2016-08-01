<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 29.07.2016
 * Time: 23:23
 */
?>
<div class="container-fluid" style="margin-top: 50px">
    <div class="row">
        <?= \yii\widgets\Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>

    <div class="row">
        <?= $content ?>
    </div>
</div>

