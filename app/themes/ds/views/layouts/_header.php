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
    \yii\bootstrap\NavBar::begin([
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
            ['label' => '<i class="fa fa-home" aria-hidden="true"></i> '.Yii::t('app','Home'), 'url' => ['/site/index']],
            ['label' => '<i class="fa fa-file-text" aria-hidden="true"></i> ' .Yii::t('app','Documents'), 'url' => ['/document/index']],
            ['label' => '<i class="fa fa-building" aria-hidden="true"></i> '.Yii::t('app','Senders'), 'url' => ['/sender/index']],
            ['label' => '<i class="fa fa-plus-square" aria-hidden="true"></i> ' .Yii::t('app','Add Document'), 'url' => ['/document/create']]/*,
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
    \yii\bootstrap\NavBar::end();
    ?>
</header>
