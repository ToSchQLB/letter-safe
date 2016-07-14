<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Letter */

$this->title = Yii::t('app', 'Create Letter');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Letters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letter-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_upload', [
        'model' => $model,
    ]) ?>

</div>
