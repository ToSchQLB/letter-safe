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
            <?= \yii\helpers\Html::a(Yii::t('app', 'Download'), "./data/{$model->folder}/in.pdf", ['class' => 'btn btn-default', 'target'=>'_blank']) ?>
            <?= \yii\helpers\Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], ['class' => 'btn btn-danger',
              'data' => [
                  'method' => 'post',
                  'confirm' => Yii::t('app','Are you sure you want to delete this item?'),
              ]]) ?>
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

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Yii::t('app','Tags') ?></h3>
    </div>
    <div class="panel-body">
        <?php \yii\widgets\Pjax::begin(['id'=>'pjax_tag']); ?>
            <?= $this->render('_tags',['model'=>$model])?>
        <?php \yii\widgets\Pjax::end();
        $js = <<<js
$(document).on('submit', 'form[data-pjax]', function(event) {
    event.preventDefault();
    $.pjax.submit(event, '#pjax_tag');
});
js;
    $this->registerJs($js);
        ?>
    </div>
</div>

<?php \yii\web\YiiAsset::register($this); ?>