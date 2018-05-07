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
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3 <?= isset($model->sender->css_class) ? $model->sender->css_class : '' ?>" style="height: 75px; display: flex;">
                <?php if(!is_null(isset($model->sender->logo) ? $model->sender->logo : null )): ?>
                    <img src="img/sender/logo/<?= $model->sender->logo?>" class="img-responsive" style="max-height: 75px; margin: auto">
                <?php else: ?>

                <?php endif; ?>
            </div>
            <div class="col-md-9">
                <row>
                    <?php if(isset($model->sender)): ?>
                    <b><?= $model->sender->name ?></b><br>
                    <?= $model->sender->adress1 .' - '.$model->sender->zip.' '.$model->sender->town ?>
                    <?php endif; ?>
                </row>
            </div>
        </div>
    </div>
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
	<div class="row" style="border-top-style: solid; margin-bottom: 5px;">
		<div class="col-md-12" style="margin-top: 5px;">
			<?php foreach ($model->documentTags as $tag):?>
                <div class="btn btn-sm tag_<?= $tag->color?>">
                    <i class="fa fa-tag"></i> <?= $tag->name ?>
                </div>
			<?php endforeach; ?>
        </div>
	</div>
<?php endif; ?>

