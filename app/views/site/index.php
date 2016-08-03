<?php
/* @var $this yii\web\View */
$this->title = 'Document Safe';
?>
<div class="site-index">

    <div class="jumbotron" style="padding-top: 15px; padding-bottom: 15px;">
        <h1>Document Safe</h1>
    </div>
    
    <div class="col-md-2">
        <div class="panel panel-info">
        	  <div class="panel-heading">
        			<h3 class="panel-title"><?= Yii::t('app','statistics')?></h3>
        	  </div>
        	  <div class="panel-body">
                  <div class="row">
                      <div class="col-md-6"><?= Yii::t('app', 'documents')?></div>
                      <div class="col-md-6 text-right">
                          <b><?= \app\models\Document::find()->count() ?> <i class="fa fa-file-text-o" aria-hidden="true"></i></b>
                      </div>

                      <div class="col-md-6"><?= Yii::t('app', 'senders')?></div>
                      <div class="col-md-6 text-right">
                          <b><?= \app\models\Sender::find()->count() ?> <i class="fa fa-building-o" aria-hidden="true"></i></b>
                      </div>
                  </div>
        	  </div>
        </div>
    </div>

    <div class="col-md-10" id="analyseBoxPanel">
        <div class="panel panel-info">
        	  <div class="panel-heading">
        			<h3 class="panel-title"><?= Yii::t('app','Documentanalyse') ?></h3>
        	  </div>
        	  <div class="panel-body">
                <div class="row" id="analyseBox"></div>
        	  </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">
        	  <div class="panel-heading">
        			<h3 class="panel-title"><?= Yii::t('app','Inbox') ?></h3>
        	  </div>
        	  <div class="panel-body">
        			<table class="table table-hover">
        				<thead>
        					<tr>
                                <th></th>
                                <th width="250px"></th>
                                <th>Dateiname</th>
                                <th>Datum</th>

        					</tr>
        				</thead>
        				<tbody id="inbox">

        				</tbody>
        			</table>
        	  </div>
        </div>
    </div>

</div>

<?php
    $url = \yii\helpers\Url::to(['/document/ajax-analysebox']);
    $urlInbox = \yii\helpers\Url::to(['/document/ajax-inbox']);
    $js = <<<js
function loadAnalyseBox() {
    $.ajax({
      url: '{$url}',
      success: function(data) {
        $('#analyseBox').html(data);
      }
  })
}
function loadInBox() {
    $.ajax({
      url: '{$urlInbox}',
      success: function(data) {
        $('#inbox').html(data);
      }
  })
} 

window.setInterval(function(){
    loadAnalyseBox();
    loadInBox();
}, 5000);

loadAnalyseBox();
loadInBox();
js;

$this->registerJs($js);
