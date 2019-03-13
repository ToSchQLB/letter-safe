<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentType */

$this->title = 'Update Document Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Document Types', 'url' => ['document-type-index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['document-type-view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="document-type-update">

    <div class="panel panel-default">
    	  <div class="panel-heading">
    			<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
    	  </div>
    	  <div class="panel-body">
              <?= $this->render('_form', [
                  'model' => $model,
              ]) ?>
    	  </div>
    </div>

</div>
