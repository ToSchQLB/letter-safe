<?php
/**
 * Created by PhpStorm.
 * User: toni.schreiber
 * Date: 21.12.2016
 * Time: 08:33
 */

/**
 * @var $model \app\models\Document
 * @var $this \yii\web\View
 */
?>
<div class="row" style="border-bottom-style: solid">
	<div class="col-md-6"><?= Yii::t('app','sender') ?></div>
	<div class="col-md-6"><?= isset($model->sender) ? $model->sender->name : null;?></div>
</div>
<div class="row">
<?php foreach ($model->documentValues as $documentValue):?>
    <?php if(strlen($documentValue->value)>0): ?>
        <div class="col-md-6"><?= $documentValue->field->name ?></div>
        <div class="col-md-6"><?= $documentValue->value ?></div>
    <?php endif; ?>
<?php endforeach; ?>
</div>
<?php if(count(($model->documentTags))>0): ?>
	<div class="row" style="border-top-style: solid">
		<div class="col-md-12"><?= Yii::t('app','tags')?></div>
		<div class="col-md-12">
			<?php foreach ($model->documentTags as $tag) {
				echo $tag->name .' ';
			}?>
        </div>
	</div>
<?php endif; ?>

