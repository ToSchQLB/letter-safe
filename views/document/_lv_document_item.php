<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 18.12.2016
 * Time: 20:13
 */

    $html = <<<HTML
        <div class="col-md-2">
            <div class="panel panel-default">
                  <div class="panel-heading" style="height: 55px">
                        <h3 class="panel-title">{$model->title}</h3>
                  </div>
                  <div class="panel-body text-center" style="padding: 0">
                    <div class="document-preview" style="background-image: url('./data/{$model->folder}/thumb.jpeg'); height: 200px;"></div>
                  </div>
            </div>
        </div>
HTML;

echo \yii\helpers\Html::a(
    $html,
    ['view', 'id' => $model->id]
);
