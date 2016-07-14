<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Letter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="letter-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= \kartik\file\FileInput::widget([
        'name' => 'files[]',
        'language' => 'de',
        'options' => ['multiple' => true],
        'pluginOptions' => ['previewFileType' => 'any', 'uploadUrl' => \yii\helpers\Url::to(['/site/file-upload'])]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
