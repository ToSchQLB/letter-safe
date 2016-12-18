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
			      'itemOptions' => ['class' => 'col-md-4 btn'],
			      'itemView' => function ($model, $key, $index, $widget) {
                      $res = '<div class="btn-lg tag_'.$model->color.'" style="padding:5px 0px; height: 33px"> ';
                      $res .= '<div class="col-md-6 text-left">';
				      $res .= Html::a(
				          '<i class="fa fa-tag" aria-hidden="true"></i> '.Html::encode($model->name)
                          ,['view', 'id' => $model->id]
                          ,[
                              'class'=>'tag_'.$model->color. ' text-left',
                              'style'=>'width: 95%; margin: auto;'
                          ]
                      );
                      $res .= '</div>';
                      $count = count($model->documentHasTags);
                      $link_edit = \yii\helpers\Url::to(['/tag/update','id'=>$model->id]);
                      $res .= <<<html
                        <div class="col-md-3">$count</div>
                        <div class="col-md-3 text-right">
                            <a href="$link_edit" class="tag_$model->color"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </div>
html;

                      $res .='</div>';

                      return $res;

			      },
		      ]) ?>
    	  </div>
    </div>

</div>
