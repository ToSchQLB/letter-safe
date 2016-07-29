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
        'brandLabel' => 'Document Safe',
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
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Documents', 'url' => ['/document/index']],
            ['label' => 'add Document', 'url' => ['/document/create']]/*,
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
