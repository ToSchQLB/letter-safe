<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 16.12.2016
 * Time: 22:28
 */

/* @var $model \app\models\Document */
?>
<div class="row">
    <div class="col-md-12">
    <?php
    foreach ($model->documentHasTags as $tag):?>
        <a data-pjax href="<?= \yii\helpers\Url::to(['tag/remove-from-document','document'=>$tag->document,'tag'=>$tag->tag_id])?>" style="margin-bottom: 5px" class="btn btn-sm tag_<?= $tag->tag->color?>">
            <i class="fa fa-tag"></i> <?= $tag->tag0->name ?>
        </a>
    <?php endforeach; ?>
    </div>
</div>
<div class="row">
    <?= \yii\helpers\Html::beginForm(['tag/add-to-document'],'get',['data-pjax' => '', 'class' => 'form-inline']); ?>
    <div class="col-md-6">
        <?= \yii\helpers\Html::hiddenInput('document',$model->id) ?>
        <?= \yii\helpers\Html::dropDownList('tag',null,\yii\helpers\ArrayHelper::map(
            app\models\Tag::find()->where(['not',['in','id',(new \yii\db\Query)->select('tag')->from('document_has_tag')->where(['document'=>$model->id])]])->all(),
            'id',
            'name'
        )); ?>
    </div>
    <div class="col-md-6">
        <?= \yii\helpers\Html::submitButton(Yii::t('app','add')) ?>
    </div>
    <?= \yii\helpers\Html::endForm(); ?>
</div>
