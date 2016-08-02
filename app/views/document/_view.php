<?php
/* @var $this yii\web\View */
/* @var $model app\models\Document */
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= \yii\helpers\Html::encode($model->title) ?></h3>
    </div>
    <div class="panel-body">
        <p>
            <?= \yii\helpers\Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= \yii\helpers\Html::a(Yii::t('app', 'Download'), "./data/{$model->folder}/in.pdf", ['class' => 'btn btn-default']) ?>
            <?php /* Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                      'class' => 'btn btn-danger',
                      'data' => [
                          'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                          'method' => 'post',
                      ],
                  ]) */?>
        </p>

        <?= \yii\widgets\DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id'
                [
                    'attribute' => 'sender_id',
                    'format' => 'raw',
                    'value' => isset($model->sender_id) ? $model->sender->getFullAddress() : null
                ],
//                'sender_id',
                'title',
                [
                    'format' => ['date','php:d.m.Y'],
                    'attribute' => 'date'
                ]
                //'message:ntext',
                //'folder',
            ],
        ]) ?>
    </div>
</div>