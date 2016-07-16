<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Letter */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Letters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letter-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sender_id',
            'title',
            'message:ntext',
            'folder',
        ],
    ]) ?>

</div>
<div class="col-lg-8">
    <?php
        $folder_relative = 'data/'.$model->folder;
        $folder_absolute = Yii::$app->basePath . "/web/data/". $model->folder;
        $xml = file_get_contents($folder_absolute.'/data.xml');    // gets XML content from file
        $doc = new DOMDocument();
        $doc->loadXML($xml);


//        $xml = str_replace(array("\n", "\r", "\t"), '', $xml);    // removes newlines, returns and tabs
//        // replace double quotes with single quotes, to ensure the simple XML function can parse the XML
//        $xml = trim(str_replace('"', "'", $xml));
//        $simpleXml = simplexml_load_string($xml);
//        $data = json_encode($simpleXml);
        $page_count = $doc->getElementsByTagName('page')->length;
        for($p=1; $p<= $page_count; $p++){
            $pageDom = $doc->getElementsByTagName('page')->item($p-1);
            $w=$pageDom->attributes->getNamedItem('width')->textContent;
            echo "<div class='text-center' style='padding: 20px; margin-bottom: 20px; background-color: #3c3c3c'>";
            echo "<img src='{$folder_relative}/seite-{$p}.png' usemap='#mapSeite{$p}' width='{$w}'/>";
            echo "<map name='mapSeite{$p}'>";
            $cn_count = $pageDom->childNodes->length;
            for($cn=1; $cn <= $cn_count; $cn++){
                $childNode = $pageDom->childNodes->item($cn-1);
                if (strcmp($childNode->nodeName,'text')==0){
                    $y1 = $childNode->attributes->getNamedItem('top')->textContent;
                    $x1 = $childNode->attributes->getNamedItem('left')->textContent;
                    $y2 = ($childNode->attributes->getNamedItem('height')->textContent * 1) + $y1;
                    $x2 = ($childNode->attributes->getNamedItem('width')->textContent * 1) + $x1;
                    $title = $childNode->textContent;
                    echo "<area shape='rect' coords='{$x1},{$y1},{$x2},{$y2}' href='#' title='{$title}' alt='{$title}'>";
                }
            }
            echo "</map>";
            echo "</div>";
        }

//        echo '<pre>'; print_r($doc->getElementsByTagName('page')); echo '</pre>';
//        echo '<pre>'; print_r($doc->getElementsByTagName('page')->item(0)); echo '</pre>';
//        echo '<pre>'; print_r($doc); echo '</pre>';
    ?>

<!--    <div class="row">-->
<!--        <div class="col-md-10"></div>-->
<!--        <div class="col-md-2"></div>-->
<!--    </div>-->

</div>
