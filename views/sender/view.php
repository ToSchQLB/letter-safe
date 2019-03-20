<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sender */
/* @var $documents \app\models\Document[] */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Senders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sender-view">

    <div class="col-md-8">
        <div class="panel panel-default">
        	  <div class="panel-heading">
        			<h3 class="panel-title"><?= Yii::t('app','Sender documents')?></h3>
        	  </div>
        	  <div class="panel-body">
                  <?php \yii\widgets\Pjax::begin(); ?>    <?= \yii\widgets\ListView::widget([
                      'dataProvider' => $documents,
                      'itemOptions' => ['class' => 'item'],
                      'itemView' => function ($model, $key, $index, $widget) {
                          $html = <<<HTML
                        <div class="col-md-3">
            <div class="panel panel-default">
                  <div class="panel-heading" style="height: 55px">
                        <h3 class="panel-title">{$model->title}</h3>
                  </div>
                  <div class="panel-body text-center" style="padding: 0">
                    <div class="document-preview" style="background-image: url('./data/{$model->folder}/thumb.jpeg'); height: 200px;"></div>
                  </div>
            </div>
            </div>
HTML;

                          return Html::a(
                              $html,
                              ['/document/view', 'id' => $model->id]
                          );
                      },
                  ]) ?>
                  <?php \yii\widgets\Pjax::end(); ?>
        	  </div>
        </div>

    </div>
    <div class="col-md-4">

        <div class="panel panel-default">
        	  <div class="panel-heading">
        			<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        	  </div>
        	  <div class="panel-body">
                  <?php if(isset($model->logo)): ?>
                      <img class="img-responsive" src=".<?= \app\models\Sender::LOGO_PATH.$model->logo ?>"><br><br>
                  <?php endif; ?>

                  <p>
                      <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                      <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                          'class' => 'btn btn-danger',
                          'data' => [
                              'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                              'method' => 'post',
                          ],
                      ]) ?>

                      <?= Html::a(Yii::t('app', 'reanalyse'), ['reanalyse', 'id' => $model->id],[
                          'class' => 'btn btn-warning pull-right',
                          'data' => [
                              'confirm' => Yii::t('app', 'Are you sure you want to reanalyse all item?'),
                              'method' => 'post',
                          ],
                      ]) ?>
                  </p>

                  <?= DetailView::widget([
                      'model' => $model,
                      'attributes' => [
//                          'id',
                          'name',
                          'name_2',
                          'adress1',
                          'adress2',
                          'zip',
                          'town',
                          'state',
                          'country',
                      ],
                  ]) ?>
        	  </div>
        </div>

    </div>




    



</div>
