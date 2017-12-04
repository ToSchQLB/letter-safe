<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 29.07.2016
 * Time: 22:05
 */

use yii\helpers\Html;


?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="Page Description">
        <meta name="author" content="Toni">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

        <!-- Bootstrap -->
        <link href="theme/dist/css/bootstrap.css" rel="stylesheet">
        <link href="theme/dist/css/bootstrap-theme.css" rel="stylesheet">

        <link href="css/sender.css" rel="stylesheet">
        <link href="css/tag.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?= $this->render(
            '_header.php'
//            ['directoryAsset' => $directoryAsset]
        ) ?>
        <?php
        $js = <<<js
                $('#searchTextInput2').on('keyup',function() {
                $('#searchTextInput').val($('#searchTextInput2').val());
                $('#searchTextInput').trigger("keyup");
        })
js;
        $this->registerJs($js,\yii\web\View::POS_END); ?>

        <?= $this->render(
            '_content.php',
            ['content' => $content]
        ) ?>

        <?= $this->render(
            '_footer.php'
//            ['directoryAsset' => $directoryAsset]
        ) ?>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="theme/dist/js/bootstrap.min.js"></script>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
