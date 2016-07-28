<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SenderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sender-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'adress1') ?>

    <?= $form->field($model, 'adress2') ?>

    <?= $form->field($model, 'zip') ?>

    <?php // echo $form->field($model, 'town') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'country') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
