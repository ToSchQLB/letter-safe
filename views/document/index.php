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
              <div class="col-md-12">
                <?php //Pjax::begin(); ?>
                <?= $this->render('_documents_list',['models'=>$dataProvider->models,'size'=>2]) ?>
                <?= \yii\widgets\LinkPager::widget([
                    'id' => 'wp2',
                    'pagination'=>$dataProvider->pagination,
                ]); ?>
                <?php //Pjax::end(); ?>
              </div>
          </div>
    </div>
</div>

