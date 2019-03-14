<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentType */

$this->title = Yii::t('app', 'Document Type') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Document Types', 'url' => ['document-type-index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="document-type-view">
    <div class="col-md-12" style="margin-bottom: 15px">
        <?= Html::a('Update', ['document-type-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['document-type-delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'name',
                        [
                            'attribute' => 'regex',
                            'format'    => 'raw',
                            'value'     => "<code>{$model->regex}</code>"
                        ]
                    ],
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
        	  <div class="panel-heading">
        			<h3 class="panel-title"><?= Yii::t('app', 'Document Fields') ?></h3>
        	  </div>
        	  <div class="panel-body">
        			<?= \yii\grid\GridView::widget([
        			        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels'=>$model->documentTypeHasFields, 'key' => 'field_id']),
                            'columns' => [
                                    'field.name',
                                    [
                                            'attribute' => 'required',
                                            'format'    => 'raw',
                                            'value'     => function($model){
        			                            if($model->required == 1){
        			                                return "<span class=\"label label-success\">" . Yii::t('app', 'Yes') . "</span>";
                                                }
                                                return "<span class=\"label label-danger\">" . Yii::t('app', 'No') . "</span>";
                                            }
                                    ],
                                    [
                                            'attribute' => 'field.regex',
                                            'format' => 'raw',
                                            'value' => function($model){
        			                            return "<code>{$model->field->regex}</code>";
                                            }
                                    ],[
                                            'class'     => ActionColumn::class,
                                            'template'  => '{update} {delete}',
                                            'urlCreator'=> function ($action, $modelA, $key, $index) use ($model) {
        			                            $action = 'document-field-'.$action;
                                                $params = is_array($key) ? $key : ['documentType'=>$model->id, 'id' => (string) $key];
                                                $params[0] = $action;
                                                return \yii\helpers\Url::toRoute($params);
                                            }
                                    ]
                            ]
                    ]) ?>
        	  </div>
        </div>
    </div>
    

</div>
