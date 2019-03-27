<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tag */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tag',
]) . ' ' .$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tag-create col-md-12">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= $this->title ?></h3>
        </div>
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
