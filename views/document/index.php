<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$lastDate=null;
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
              <div class="row">
                <?php Pjax::begin(); ?>
                <?php
                    foreach ($dataProvider->models as $model){
                        $datediff = date_diff(new DateTime($model->date),new DateTime());
                        if($datediff->days == 0 && (is_null($lastDate) ? -1 : $lastDate) < 0){
                            $html = "</div><div class='row col-md-12'><h3>".Yii::t('app','today')."</h3></div><div class='row'>";
                        }elseif($datediff->days == 1 && (is_null($lastDate) ? -1 : $lastDate) < 1){
                            $html = "</div><div class='row col-md-12'><h3>".Yii::t('app','yesterday')."</h3></div><div class='row'>";
                        }elseif($datediff->days <= 7 && (is_null($lastDate) ? -1 : $lastDate) < 2){
                            $html = "</div><div class='row col-md-12'><h3>".Yii::t('app','this week')."</h3></div><div class='row'>";
                        }elseif($datediff->days <= 14 && (is_null($lastDate) ? -1 : $lastDate) < 8){
                            $html = "</div><div class='row col-md-12'><h3>".Yii::t('app','last week')."</h3></div><div class='row'>";
                        }else{
                            $dt = new DateTime($model->date);
                            $monat = $dt->format("Ym");
                            if(strcmp($lastDate,$monat)!=0){
                                $html = "</div><div class='row col-md-12'><h3>".Yii::t('app',$dt->format("F"))." ".$dt->format("Y")."</h3></div><div class='row'>";
                                $lastDate = $dt->format("Ym");
                            }else{
                                $html = "";
                            }

                        }
                        echo $html;
                        echo $this->render('_lv_document_item',['model'=>$model]);
                    }
//                ListView::widget([
//                    'dataProvider' => $dataProvider,
//                    'itemOptions' => ['class' => 'item'],
//                    'viewParams' => ['lastDate'=>$lastDate],
//                    'itemView' => '_lv_document_item'
//                ])
                ?>
                <?php Pjax::end(); ?>
              </div>
              </div>
          </div>
    </div>
</div>

<?php

$js = <<<js
$('[data-toggle="popover"]').popover(); 
js;

$this->registerJs($js);

$css = <<<css
	.popover{
		max-width: 400px!important;
	}
css;

$this->registerCss($css);


