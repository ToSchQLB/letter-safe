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
//            'minimumInputLength' => 3,
//            'language' => [
//                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
//            ],
            'ajax' => [
                'url' => \yii\helpers\Url::to(['/sender/ajax-select2']),
                'dataType' => 'json',
                'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }')
            ],
//            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new \yii\web\JsExpression('function(sender) { return sender.name + "<br>" + sender.adress1 + "<br>"+sender.zip+" " +sender.town; }'),
            'templateSelection' => new \yii\web\JsExpression('function (sender) { return sender.name + "<br>" + sender.adress1 + "<br>"+sender.zip+" " +sender.town; }'),
        ],
    ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?php //$form->field($model, 'folder')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>