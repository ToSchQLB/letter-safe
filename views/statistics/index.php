<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 19.03.2019
 * Time: 21:29
 */

/** @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
?>
<?= \yii\helpers\Html::beginForm('','get') ?>
<div class="col-md-12">
    <div class="panel panel-default">
    	  <div class="panel-heading">
    			<h3 class="panel-title"><?= Yii::t('app', 'Update diagram') ?></h3>
    	  </div>
    	  <div class="panel-body">
              <div class="row">
                  <div class="col-md-4">
                      Sender: <?= \kartik\widgets\Select2::widget([
                          'name' => 'sender',
                          'options' => ['placeholder' => Yii::t('app', 'please select...')],
                          'data' => ArrayHelper::map(\app\models\Sender::find()->asArray()->all(), 'id', 'name'),
                          'value' => $sender
                      ])?>
                  </div>
                  <div class="col-md-4">
                      Field: <?= \kartik\widgets\Select2::widget([
                          'name' => 'field',
                          'value' => $field,
                          'options' => ['placeholder' => Yii::t('app', 'please select...')],
                          'data' => ArrayHelper::map(\app\models\DocumentField::find()->asArray()->all(), 'id', 'name')
                      ])?>
                  </div>
                  <div class="col-md-4">
                      <?= \yii\bootstrap\Html::submitButton(
                          Yii::t('app', 'show diagram'),
                          [
                              'class' => 'btn btn-info',
                              'style' => 'margin-top: 20px'
                          ]
                      ) ?>
                  </div>
              </div>
    	  </div>
    </div>
    <br>
    <div class="panel panel-default">
    	  <div class="panel-heading">
    			<h3 class="panel-title"></h3>
    	  </div>
    	  <div class="panel-body">
              <div id="myfirstchart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    	  </div>
    </div>
</div>

<?= \yii\helpers\Html::endForm() ?>

<?php
if(!is_null($data)){
    $this->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css');
    $this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js');
    $this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js');

    $data = json_encode($data);

    $js = <<<js
new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: {$data},
  // The name of the data record attribute that contains x-values.
  xkey: 'date',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['value']
});
js;

    $this->registerJs($js);
}
