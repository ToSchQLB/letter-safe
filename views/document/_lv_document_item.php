<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 18.12.2016
 * Time: 20:13
 */

$popoverTitle = Yii::t('app','document details');
$popoverContent = str_replace("\"","'",$this->render('_document_popover',['model'=>$model]));
    $html = <<<HTML
        <div class="col-md-$size" data-toggle="popover" title="$popoverTitle" data-content= "$popoverContent"
		data-trigger = "hover" data-placement = "auto right" data-html="true">
            <div class="panel panel-default" >
                  <div class="panel-heading" style="height: 55px">
                        <h3 class="panel-title">{$model->title}</h3>
                  </div>
                  <div class="panel-body text-center" style="padding: 0">
                    <div class="document-preview" 
                        style="background-image: url('./data/{$model->folder}/thumb.jpeg'); height: 200px;">
                    </div>
                  </div>
            </div>
        </div>
HTML;

echo \yii\helpers\Html::a(
    $html,
    ['/document/view', 'id' => $model->id],
	[

	]
);
