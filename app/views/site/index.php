<?php
/* @var $this yii\web\View */
$this->title = 'Document Safe';
?>
<div class="site-index">

    <div class="jumbotron">
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

    <div class="col-md-12">
        <div class="panel panel-default">
        	  <div class="panel-heading">
        			<h3 class="panel-title"><?= Yii::t('app','Inbox') ?></h3>
        	  </div>
        	  <div class="panel-body">

        	  </div>
        </div>
    </div>

</div>