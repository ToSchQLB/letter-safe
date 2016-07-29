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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Document'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            $html = <<<HTML
            <div class="col-md-3">
<div class="panel panel-default">
	  <div class="panel-heading">
			<h3 class="panel-title">{$model->title}</h3>
	  </div>
	  <div class="panel-body text-center">
			<img src="./data/{$model->folder}/thumb.jpeg">
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
    <?php Pjax::end(); ?></div>