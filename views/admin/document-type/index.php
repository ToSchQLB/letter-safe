<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \app\models\search\DocumentTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-type-index">
    <p>
        <?= Html::a('Create Document Type', ['document-type-create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    'name',
                    [
                            'attribute' => 'regex',
                            'format'    => 'raw',
                            'value'     => function($model){
                                return "<code>{$model->regex}</code>";
                            }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'urlCreator' => function($action, $model, $key, $index)
                        {
                            $params = is_array($key) ? $key : ['id' => (string) $key];
                            $params[0] = '/admin/document-type-' . $action ;

                            return \yii\helpers\Url::toRoute($params);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
