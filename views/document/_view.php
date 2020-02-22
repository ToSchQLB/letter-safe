<?php
/* @var $this yii\web\View */
/* @var $model app\models\Document */
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= \yii\helpers\Html::encode($model->title) ?></h3>
    </div>
    <div class="panel-body">
        <div class="">
            <div class="btn-group" role="group" style="width: 100%">
                <?= \yii\helpers\Html::a(
                        Yii::t('app', 'Update'),
                        ['update', 'id' => $model->id],
                        ['style'=>'width:25%','class' => 'btn btn-primary']
                ) ?>

                <?= \yii\helpers\Html::a(
                        Yii::t('app', 'Download'),
                        "./data/{$model->folder}/in.pdf",
                        ['style'=>'width:25%','class' => 'btn btn-default', 'target'=>'_blank']
                ) ?>

		<?= \yii\helpers\Html::a(
			Yii::t('app', 'reanalyse'),
			['reanalyse', 'id' => $model->id],
			[
				'style' => 'width: 25%',
				'class' => 'btn btn-warning',
				'data' =>[
					'method' =>  'post',
				]
			]
		) ?>

                <?= \yii\helpers\Html::a(
                        Yii::t('app', 'Delete'),
                        ['delete', 'id' => $model->id],
                        [
                                'style'=>'width:25%','class' => 'btn btn-danger',
                                'data' => [
                                  'method' => 'post',
                                  'confirm' => Yii::t(
                                          'app',
                                          'Are you sure you want to delete this item?'
                                  ),
                                ]
                        ]
                ) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php if(isset($model->sender)): ?>
                <div class="col-md-3 <?= $model->sender->css_class ?>" style="height: 75px; display: flex;">
                    <?php if(!is_null($model->sender->logo)): ?>
                        <img src="img/sender/logo/<?= $model->sender->logo?>" class="img-responsive" style="max-height: 75px; margin: auto">
                    <?php else: ?>

                    <?php endif; ?>
                </div>
                <div class="col-md-9">
                    <row>
                        <h4><?= $model->sender->name ?></h4>
                    </row>
                    <row>
                        <?= $model->sender->adress1 .' - '.$model->sender->zip.' '.$model->sender->town ?>
                    </row><br>
                    <row>
                        <a href="<?= \yii\helpers\Url::to(['sender/view','id'=>$model->sender_id])?>">
                            <?= Yii::t('app','view all documnets')?>
                        </a>
                    </row>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row" style="margin-bottom: 5px">
            <div class="col-md-12">
                <div class="col-md-3">Datum:</div>
                <div class="col-md-9"><?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') ?></div>
            </div>
        </div>


        <?php \yii\widgets\DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => Yii::t('app','Document Type'),
                    'value' => isset($model->documentType) ? $model->documentType->name : null,
                ],
                [
                    'attribute' => 'sender_id',
                    'format' => 'raw',
                    'value' => isset($model->sender_id) ? $model->sender->getFullAddress() : null
                ],
//                'sender_id',
                //'title',
                [
                    'format' => ['date','php:d.m.Y'],
                    'attribute' => 'date'
                ]
                //'message:ntext',
                //'folder',
            ],
        ]) ?>
    </div>
</div>

    <div class="panel panel-info" style="margin-top: -40px; margin-bottom: 25px">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Yii::t('app','Tags') ?></h3>
        </div>
        <div class="panel-body">
            <?php \yii\widgets\Pjax::begin(['id'=>'pjax_tag']); ?>
            <?= $this->render('_tags',['model'=>$model])?>
            <?php \yii\widgets\Pjax::end();
            $js = <<<js
$(document).on('submit', 'form[data-pjax]', function(event) {
    event.preventDefault();
    $.pjax.submit(event, '#pjax_tag');
});
js;
            $this->registerJs($js);
            ?>
        </div>
    </div>

<?php if(!is_null($model->documentType)):
	if(!is_null($model->documentType->documentTypeHasFields)): ?>
<div class="panel panel-default" style="margin-top: -40px;">
	  <div class="panel-heading">
			<h3 class="panel-title"><?= Yii::t('app','documnet information')?></h3>
	  </div>
	  <div class="panel-body">
          <?= \yii\helpers\Html::beginForm(['/document/save-values'],'POST',['id'=>'documentValueForm']) ?>
          <?php foreach ($model->documentType->documentTypeHasFields as $index =>  $field):
	          $documentValue = \app\models\DocumentValue::findOne([
	                'document_id'=>$model->id,
		            'field_id' => $field->field_id
	          ]);
	          if(is_null($documentValue)){
		          $documentValue = new \app\models\DocumentValue();
	          }
          ?>
              <?= \yii\helpers\Html::hiddenInput("documentValue[$index][document_id]",$model->id) ?>
              <?= \yii\helpers\Html::hiddenInput("documentValue[$index][field_id]",$field->field_id) ?>
	          <div class="form-group">
		          <label for="documentValue-value-<?= $field->field->name ?>" class="control-label"><?= $field->field->name ?></label>
                <?= \yii\bootstrap\Html::activeTextInput(
	                $documentValue,
	                'value',
	                [
	                	'name'=>"documentValue[$index][value]",
		                'class'=>'form-control document-value',
		                'id' => 'documentValue-value-'.$field->field->name,
	                    "onclick"=>"fillInput('documentValue-value-".$field->field->name."')"
	                ]
                ) ?>
	          </div>
          <?php endforeach; ?>
          <?= \yii\helpers\Html::endForm() ?>
	  </div>
</div>
<?php endif; endif;
$ajaxUrl = \yii\helpers\Url::to(['/document/save-values']);
$js = <<<js
	$('.document-value').change(function() {
	    var form = $(this).closest('form');
		 sendDocumentValueForm(form);
	});

	function sendDocumentValueForm(form){
		$.post('$ajaxUrl', form.serialize()); 
	}
js;
	$this->registerJs($js,\yii\web\View::POS_END);
?>

<?php \yii\web\YiiAsset::register($this); ?>