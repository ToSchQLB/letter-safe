<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->widget(\kartik\widgets\ColorInput::className(),[
	    'showDefaultPalette' => false,
	    'pluginOptions' => [
		    'showInput' => true,
		    'showInitial' => true,
		    'showPalette' => true,
		    'showPaletteOnly' => true,
		    'showSelectionPalette' => true,
		    'showAlpha' => false,
		    'allowEmpty' => false,
		    'preferredFormat' => 'name',
		    'palette' => [
			    [
				    "white", "black", "grey", "silver", "gold", "brown",
			    ],
			    [
				    "red", "orange", "yellow", "indigo", "maroon", "pink"
			    ],
			    [
				    "blue", "green", "violet", "cyan", "magenta", "purple",
			    ],
		    ]
	    ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
