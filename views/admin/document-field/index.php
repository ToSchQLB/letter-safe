<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DocumentFieldSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Fields';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-field-index col-md-12">

    <p>
        <?= Html::a('Create Document Field', ['document-field-create'], ['class' => 'btn btn-success']) ?>
    </p>

      <div class="panel panel-default">
          <div class="panel-heading">
              <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
          </div>
          <div class="panel-body">
              <?= GridView::widget([
                  'dataProvider' => $dataProvider,
                  'filterModel' => $searchModel,
                  'columns' => [
                      'name',
                      'regex',
                      'element',

                      [
                          'class' => 'yii\grid\ActionColumn',
                          'urlCreator' => function($action, $model, $key, $index)
                          {
                              $params = is_array($key) ? $key : ['id' => (string) $key];
                              $params[0] = '/admin/document-field-' . $action ;

                              return \yii\helpers\Url::toRoute($params);
                          }
                      ],
                  ],
              ]); ?>
          </div>
      </div>

</div>
