<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tags');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">

    <div class="panel panel-default">
    	  <div class="panel-heading">
    			<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
    	  </div>
    	  <div class="panel-body">
              <p>
			      <?= Html::a(Yii::t('app', 'Create Tag'), ['create'], ['class' => 'btn btn-success']) ?>
              </p>
		      <?= ListView::widget([
			      'dataProvider' => $dataProvider,
			      'itemOptions' => ['class' => 'col-md-4 text-center'],
			      'itemView' => function ($model, $key, $index, $widget) {

				      return Html::a(
				          '<i class="fa fa-tag" aria-hidden="true"></i> '.Html::encode($model->name)
                          ,['view', 'id' => $model->id]
                          ,[
                              'class'=>'btn btn-lg tag_'.$model->color,
                              'style'=>'width: 95%; margin: auto;'
                          ]
                      );

			      },
		      ]) ?>
    	  </div>
    </div>

</div>
