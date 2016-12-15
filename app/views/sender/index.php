<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SenderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Senders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sender-index">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
                    /* @var $model \app\models\Sender */
                    $logo = \app\models\Sender::LOGO_PATH . $model->logo;
                    $docCount = count($model->documents);
                    $panelContent = "";
                    if(!empty($model->logo)){
                        $panelContent = <<<html
                            <img src=".$logo" class="img-responsive">
html;
                    } else {
                        $text = substr($model->name,0,30);
                        $panelContent = <<<html
                            <h2 style="width: 100%;">$text</h2>
html;

                    }
                    $html = <<<HTML
<div class="col-md-2">
    <div class="panel panel-default">
        <!--<div class="panel-heading" style="height: 55px">
            <h3 class="panel-title">{$model->name}</h3>
        </div>-->
        <div class="panel-body text-center" style="padding: 5px 5px; height: 150px; display: flex; align-items: center; width: 100%;">
            $panelContent
        </div>
        <div class="panel-footer" style="padding: 2px 15px;">
            <small>$docCount Dokumente</small>
        </div>
    </div>
</div>
HTML;

                    return Html::a(
                        $html,
                        ['/sender/view', 'id' => $model->id]
                    );
                },
            ]) ?>
        </div>
    </div>
</div>
