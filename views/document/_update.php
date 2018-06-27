<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Document */
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?=  Yii::t(
                    'app',
                    'Update {modelClass}: ',
                    [
                        'modelClass' => 'Document',
                    ]
            ) .
            "<b>" .$model->title . "</b>" ?>
        </h3>
    </div>
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
