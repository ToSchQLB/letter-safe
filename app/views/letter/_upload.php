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
        'name' => 'letterFile',
        'language' => 'de',
        'options' => ['multiple' => true],
        'pluginOptions' => ['previewFileType' => 'any', 'uploadUrl' => \yii\helpers\Url::to(['/letter/ajax-file-upload'])]
    ]); ?>


    <?php ActiveForm::end(); ?>

</div>
