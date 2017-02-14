<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 12.02.2017
 * Time: 13:12
 */

use app\models\Document;

/* @var Document[] $models */
/* @var int $size */

$groupByMonth = isset($groupByMonth) ? $groupByMonth : true;
$lastDate=null;

?>
    <div class="row">
<?php
foreach ($models as $model){
    $datediff = date_diff(new DateTime($model->date),new DateTime());
    $dt = new DateTime($model->date);
    $monat = $dt->format("Ym");
    if(strcmp($lastDate,$monat)!=0 && $groupByMonth){
        $html = "</div><div class='row col-md-12'><h3>".Yii::t('app',$dt->format("F"))." ".$dt->format("Y")."</h3></div><div class='row'>";
        $lastDate = $dt->format("Ym");
    }else{
        $html = "";
    }
    echo $html;
    echo $this->render('_lv_document_item',['model'=>$model,'size'=>$size]);
}
?>
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

