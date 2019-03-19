<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentField */

$this->title = 'Update Document Field: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Document Fields', 'url' => ['document-field-index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['document-field-view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-field-update">

<!--    <h1></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'dthf' => $dthf,
    ]) ?>

</div>
