<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 28.07.2016
 * Time: 20:20
 */

/* @var $this yii\web\View */
/* @var $model app\models\Document */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t(
                'app','Create {modelClass}',
                ['modelClass'=>Yii::t('app/sender','Sender')]
        ) ?>
    </div>
	<div class="panel-body">


    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model,'name')->textInput(["onclick"=>"fillInput('sender-name')"]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'adress1')->textInput(["onclick"=>"fillInput('sender-adress1')"]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'adress2')->textInput(["onclick"=>"fillInput('sender-adress2')"]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model,'zip')->textInput(["onclick"=>"fillInput('sender-zip')"]) ?>
        </div>
        <div class="col-sm-8">
            <?= $form->field($model,'town')->textInput(["onclick"=>"fillInput('sender-town')"]) ?>
        </div>
    </div>

    <a href="javascript:toggleSenderForm()" class="col-md-6 btn btn-danger">
        <?= Yii::t('app','cancel') ?>
    </a>
    <a class="col-md-6 btn btn-primary" href="javascript:addSender()">
        <?= Yii::t('app','create') ?>
    </a>

    </div>
</div>