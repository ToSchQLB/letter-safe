<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Document */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="letter-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= \kartik\file\FileInput::widget([
        'name' => 'letterFile[]',
        'language' => 'de',
        'options' => ['multiple' => true],
        'pluginOptions' => [
//            'previewFileType' => 'any',
            'uploadAsync' => false,
//            'uploadUrl' => \yii\helpers\Url::to(['/document/ajax-file-upload']),
            'uploadUrl' => 'index.php?r=/document/ajax-file-upload',
//            'maxFileCount' => 10
        ]
    ]); ?>


    <?php ActiveForm::end(); ?>

</div>
