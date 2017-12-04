<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 29.07.2016
 * Time: 22:40
 */

use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">
    <?php
    \app\components\NavBar::begin([
        'brandLabel' => 'Letter Safe',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
        'innerContainerOptions' =>[
            'class' => 'container-fluid',
        ]
    ]);
    echo \yii\bootstrap\Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'encodeLabels' => false,
        'items' => [
            [
                'label' => '<i class="fa fa-home" aria-hidden="true"></i> '.Yii::t('app','Home'),
                'url' => ['/site/index']
            ],[
                'label' => '<i class="fa fa-file-text" aria-hidden="true"></i> ' .Yii::t('app','Documents'),
                'url' => ['/document/index'],
                'visible'=>!Yii::$app->user->isGuest
            ],[
                'label' => '<i class="fa fa-building" aria-hidden="true"></i> '.Yii::t('app','Senders'),
                'url' => ['/sender/index'],
                'visible'=>!Yii::$app->user->isGuest
            ],[
                'label' => '<i class="fa fa-tags" aria-hidden="true"></i> '. Yii::t('app','Tags'),
                'url'=>['/tag/index'],
                'visible'=>!Yii::$app->user->isGuest
            ],[
                'label' => '<i class="fa fa-user" aria-hidden="true"></i> '. Yii::t('app','User'),
                'url'=>['/user/index'],
                'visible'=>!Yii::$app->user->isGuest
            ],[
                'label' => '<i class="fa fa-plus-square" aria-hidden="true"></i> ' .Yii::t('app','Add Document'),
                'url' => ['/document/create'],
                'visible'=>!Yii::$app->user->isGuest
            ]
            /*,
                Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link']
                    )
                    . Html::endForm()
                    . '</li>'
                )*/
        ],
    ]);
    echo \yii\bootstrap\Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [

            Yii::$app->user->isGuest ? (
            ['label' => '<i class="fa fa-sign-in"></i> Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    '<i class="fa fa-sign-out"></i> Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    ?>
    <?php if(!Yii::$app->user->isGuest): ?>
<!--    <div class="input-group" style="position: absolute; width: 275px; right: 10px; margin-top: 8px;">-->
    <div class="input-group hidden-xs hidden-sm hidden-md" style="float: right; width: 250px; padding-top: 8px;">
        <span class="input-group-addon" id="basic-addon1">
            <i class="fa fa-search" aria-hidden="true"></i>
        </span>
        <input id="searchTextInput" type="text" class="form-control" placeholder="suchen..." aria-describedby="basic-addon1">
    </div>
    <?php else: ?>

    <?php endif;

    \app\components\NavBar::end();
    ?>
<!--    <div  class="row" >-->
        <div id="searchResultPanel" style="margin-top: 50px; margin-bottom: -30px; display: none;" class="panel panel-default">
              <div class="panel-heading">
                    <h3 class="panel-title">Suchergebnis</h3>
              </div>
              <div class="panel-body" id="searchResults">
                  <i class="fa fa-refresh fa-spin fa-3x fa-fw" aria-hidden="true"></i>
                  <span class="sr-only">Refreshing...</span> bitte warten...
              </div>
        </div>
<!--    </div>-->
</header>
<?php
    $url = \yii\helpers\Url::to(['document/ajax-search','q'=>'']);
    $js = <<<js
    $('#searchTextInput').keyup(function() {
        if($(this).val().length != 0){
            $('#searchResultPanel').show(500);
            $.ajax('{$url}'+$(this).val(),{
                dataType: "json",
                success: function(data) {
                    var result = "";
                    
                    for(var i = 0 ; i < data.length; i++){
                        result = result + '<div class="col-md-2">';
                        result = result + '<a href="index.php?r=document/view&id='+data[i].id+'">';
                        result = result + '<div style="background-image: url(\'./data/'+data[i].folder+'/thumb.jpeg\'); height: 150px;" class="document-preview"></div>';
                        result = result + '<div class="text-center">'+data[i].title+'</div>';
                        result = result + '</a>';
                        result = result + '</div>';
                    }
                    
                    if (data.length == 0){
                        result = 'keine Dokumente gefunden <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>';
                    }
                    
                    $('#searchResults').html(result);
                }
            })
        } else {
            $('#searchResultPanel').hide(500);
        }
    })
js;
    $this->registerJs($js);
?>
