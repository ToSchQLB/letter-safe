<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sender */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sender',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Senders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sender-update">

    <div class="panel panel-default">
    	<!-- Default panel contents -->
    	<div class="panel-heading"><b><?= Html::encode($this->title) ?></b></div>
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>



</div>
