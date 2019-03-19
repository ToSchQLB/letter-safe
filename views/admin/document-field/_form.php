<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentField */
/* @var $form yii\widgets\ActiveForm */
/* @var $dthf \app\models\DocumentTypeHasField */
?>
<div class="document-field-form col-md-12">

    <div class="panel panel-default">
    	  <div class="panel-heading">
    			<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
    	  </div>
    	  <div class="panel-body">
              <?php $form = ActiveForm::begin(); ?>

              <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

              <?= $form->field($model, 'regex')->textInput() ?>

              <?= $form->field($model, 'element')->textInput(['maxlength' => true]) ?>

              <?php if (isset($dthf) && !is_null($dthf)): ?>

                <?=
                  $form->field($dthf, 'required')->widget(\kartik\widgets\SwitchInput::class,[
                        'pluginOptions' => [
                                'onColor' => 'success',
                                'offColor' => 'danger',
                                'onText' => Yii::t('app', 'Yes'),
                                'offText'=> Yii::t('app', 'No'),
                        ]
                  ])
                ?>
              <?php endif; ?>

              <div class="form-group">
                  <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
              </div>

              <?php ActiveForm::end(); ?>
    	  </div>
    </div>


</div>
