<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sender */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sender-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="col-md-8">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <div class="col-md-8">
                <?= $form->field($model, 'name_2')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <?= $form->field($model, 'adress1')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'adress2')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'zip')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-8">
                <?= $form->field($model, 'town')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <?php # $form->field($model, 'state')->textInput(['maxlength' => true]) ?>

        <?php # $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?php if(isset($model->logo)): ?>
            <img class="img-responsive" src=".<?= \app\models\Sender::LOGO_PATH.$model->logo ?>" style="max-width: 333px">
        <?php else: ?>
            <span style="border-style: solid; border-width: 2px; display: table-cell;
                height: 100px; margin-bottom: 15px; text-align: center; vertical-align: middle; width: 200px;"
            >
                <?= Yii::t('app', 'no logo')?></span>
        <?php endif; ?>
        <?= $form->field($model, 'logoUpload')->fileInput() ?>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
