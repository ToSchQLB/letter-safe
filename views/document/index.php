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
                <div id="doc_pager" style="position: sticky; bottom: 15px; z-index: 9999; width: 100%; background-color: #fff;">
                    <?= \yii\widgets\LinkPager::widget([
                        'id' => 'wp2',
                        'pagination'=>$dataProvider->pagination,
                        'options'=>[
                            'class' => 'pagination',
                            'style'=>'margin:0px;margin-bottom:15px'
                        ]
                    ]); ?>
                </div>
                <?php //Pjax::end(); ?>
              </div>
          </div>
    </div>
</div>
<?php

$js =<<<js
$('#doc_pager').affix({
    offset:{
        bottom: 20
    }
});
js;

//$this->registerJs($js);

