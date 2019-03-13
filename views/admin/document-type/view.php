<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Document Types', 'url' => ['document-type-index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="document-type-view">
    <p>
        <?= Html::a('Update', ['document-type-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['document-type-delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="panel panel-default">
    	  <div class="panel-heading">
    			<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
    	  </div>
    	  <div class="panel-body">
              <?= DetailView::widget([
                  'model' => $model,
                  'attributes' => [
                      'id',
                      'name',
                      'regex',
                  ],
              ]) ?>
    	  </div>
    </div>

</div>
