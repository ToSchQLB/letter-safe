<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Documents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">

    <div class="panel panel-default">
    	  <div class="panel-heading">
    			<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
    	  </div>
    	  <div class="panel-body">
                <?php Pjax::begin(); ?>    <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => ['class' => 'item'],
                    'itemView' => function ($model, $key, $index, $widget) {
                        $html = <<<HTML
                        <div class="col-md-2">
            <div class="panel panel-default">
                  <div class="panel-heading" style="height: 55px">
                        <h3 class="panel-title">{$model->title}</h3>
                  </div>
                  <div class="panel-body text-center" style="padding: 0">
                    <div class="document-preview" style="background-image: url('./data/{$model->folder}/seite-1.png'); height: 200px;"></div>
                  </div>
            </div>
            </div>
HTML;

                        return Html::a(
                            $html,
                            ['view', 'id' => $model->id]
                        );
                    },
                ]) ?>
                <?php Pjax::end(); ?>
          </div>
    </div>
</div>
