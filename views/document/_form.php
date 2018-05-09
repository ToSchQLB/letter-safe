<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Document */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="letter-form">
    <?php $form = ActiveForm::begin(['id'=>'sender-update-form']); ?>

    <?= $form->field($model, 'sender_id')
        ->widget(\kartik\select2\Select2::className(),[
        'pluginOptions' => [
            'allowClear' => true,
            'ajax' => [
                'url' => \yii\helpers\Url::to(['/sender/ajax-select2']),
                'dataType' => 'json',
                'data' => new \yii\web\JsExpression("function(params) { return {q:params.term}; }")
            ],
        ],
        'initValueText' => isset($model->sender_id) ? $model->sender->getFullAddress() : ''
    ]) ?>

    <a class="sender-button btn btn-primary col-md-12" href="javascript:toggleSenderForm()">
        <?= Yii::t('app/sender','Create Sender') ?>
    </a>

    <div class="senderform" style="display: none">
        <?php
            $sender = new \app\models\Sender();
            echo $this->render('_sender-form',['model'=>$sender,'form'=>$form]);
        ?>
    </div>

    <?= $form->field($model, 'document_type_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\DocumentType::find()->asArray()->all(),'id','name'),
        [
            'prompt'=>Yii::t('app', '_empty')
        ]
    ) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true,"onclick"=>"fillInput('document-title')"]) ?>

    <?= $form->field($model, 'date')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type'=>\kartik\datecontrol\DateControl::FORMAT_DATE,
        'autoWidget'=>false,
        'options'=>[
            "onclick"=>"fillInput('document-date')"
        ]
    ]); ?>



    <?php //$form->field($model, 'folder')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(
                $model->isNewRecord ?
                    Yii::t('app', 'Create') :
                    Yii::t('app', 'Update'),
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $url = \yii\helpers\Url::to(['/sender/ajax-create']);
    $js = <<<JS

function toggleSenderForm() {
  $('.sender-button').toggle();
  $('.senderform').toggle();
  $('.field-document-sender_id').toggle();
}

function addSender(){
    $.ajax('{$url}',{
        data: $('#sender-update-form').serialize(),
        method: 'POST',
        dataType : 'JSON',
        success: function(data){
            // $('#document-sender_id').val(data.id);
            $("#document-sender_id option").val(data.id);
            $('#select2-document-sender_id-container').html(data.name);
            toggleSenderForm();
        }
    })
}
JS;

    $this->registerJs($js, \yii\web\View::POS_END);

    ?>

</div>
