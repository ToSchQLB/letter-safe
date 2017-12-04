<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 04.12.2017
 * Time: 22:25
 */
namespace app\components;

use yii\helpers\Html;

class NavBar extends \yii\bootstrap\NavBar{

    /**
     * Renders collapsible toggle button.
     * @return string the rendering toggle button.
     */
    protected function renderToggleButton()
    {
        $bar = Html::tag('span', '', ['class' => 'icon-bar']);
        $screenReader = "<span class=\"sr-only\">{$this->screenReaderToggleText}</span>";

        return Html::button("{$screenReader}\n{$bar}\n{$bar}\n{$bar}", [
            'class' => 'navbar-toggle',
            'data-toggle' => 'collapse',
            'data-target' => "#{$this->containerOptions['id']}",
        ]). '<div class="input-group hidden-lg" style="padding-top: 8px;width: calc(100% - 200px);float: right;margin-right: 15px;">
        <span class="input-group-addon" id="basic-addon1">
            <i class="fa fa-search" aria-hidden="true"></i>
        </span>
        <input id="searchTextInput2" class="form-control" placeholder="suchen..." aria-describedby="basic-addon1" type="text">
    </div>';
    }
}