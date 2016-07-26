<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Document */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="letter-form">
    <h1>TEST</h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sender_id')->widget(\kartik\select2\Select2::className(),[
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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true,"onclick"=>"fillInput('document-title')"]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= Html::hiddenInput('activeInput') ?>

    <?php //$form->field($model, 'folder')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $js = <<<JS
function fillInput(name) {
    $('input[name="activeInput"]').val(name); 
}

function writeToInput(text) {
    alt = $('#'+$('input[name="activeInput"]').val()).val();
    if(alt == '')
        $('#'+$('input[name="activeInput"]').val()).val(text);
    else
        $('#'+$('input[name="activeInput"]').val()).val(alt + ' ' + text);
}
JS;

    $this->registerJs($js, \yii\web\View::POS_END);

    ?>

</div>
