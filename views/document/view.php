<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Document */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="doc-pages" class="col-lg-8 visible-lg" style="position: absolute;height: calc(100% - 120px);margin-top: -20px; overflow-y: scroll">
    <?php
        $folder_relative = 'data/'.$model->folder;
        $folder_absolute = Yii::$app->basePath . "/web/data/". $model->folder;
        if(isset(Yii::$app->params['mediaPath'])){
            $folder_absolute = Yii::$app->params['mediaPath'].$model->folder;
        }
        if(file_exists($folder_absolute.'/data.xml')) {

            $xml = file_get_contents($folder_absolute . '/data.xml');    // gets XML content from file
            $doc = new DOMDocument();
            $doc->loadXML($xml);

            $page_count = $doc->getElementsByTagName('page')->length;
            for ($p = 1; $p <= $page_count; $p++) {
                $pageDom = $doc->getElementsByTagName('page')->item($p - 1);
                $w = $pageDom->attributes->getNamedItem('width')->textContent;
                echo "<div class='text-center' style='padding: 20px; margin-bottom: 20px; background-color: #3c3c3c'>";
                echo "<img src='{$folder_relative}/seite-{$p}.png' usemap='#mapSeite{$p}' width='{$w}'/>";
                echo "<map name='mapSeite{$p}'>";
                $cn_count = $pageDom->childNodes->length;
                for ($cn = 1; $cn <= $cn_count; $cn++) {
                    $childNode = $pageDom->childNodes->item($cn - 1);
                    if (strcmp($childNode->nodeName, 'text') == 0) {
                        $y1 = $childNode->attributes->getNamedItem('top')->textContent;
                        $x1 = $childNode->attributes->getNamedItem('left')->textContent;
                        $y2 = ($childNode->attributes->getNamedItem('height')->textContent * 1) + $y1;
                        $x2 = ($childNode->attributes->getNamedItem('width')->textContent * 1) + $x1;
                        $title = $childNode->textContent;
                        echo "<area shape='rect' coords='{$x1},{$y1},{$x2},{$y2}' href=\"javascript: writeToInput('{$title}')\" title='{$title}' alt='{$title}'>";
                    }
                }
                echo "</map>";
                echo "</div>";
            }
        } else {
            $data = file_exists($folder_absolute.'/text.json') ? json_decode(file_get_contents($folder_absolute . '/text.json')) : [];
            foreach ($data as $page) {
                if((count($data)<10) && file_exists("{$folder_absolute}/seite-1.png"))
                    $resource = new Imagick("{$folder_absolute}/seite-".$page->page.".png");
                else
                    $resource = new Imagick("{$folder_absolute}/seite-".sprintf("%02d",$page->page).".png");
                $width = $resource->getImageWidth();
                $proportion = $width / $page->width * 0.75;
                $w = $page->width * $proportion;
                echo "<div class='text-center' style='padding: 20px; margin-bottom: 20px; background-color: #3c3c3c'>";
                if(count($data)<10 && file_exists("{$folder_absolute}/seite-1.png"))
                    echo "<img src='{$folder_relative}/seite-".$page->page.".png' usemap='#mapSeite{$page->page}' width='{$w}'/>";
                else
                    echo "<img src='{$folder_relative}/seite-".sprintf("%02d",$page->page).".png' usemap='#mapSeite{$page->page}' width='{$w}'/>";
                echo "<map name='mapSeite{$page->page}'>";
                foreach ($page->text as $text) {
                    $y1 = round($text->top * $proportion,0);
                    $x1 = round($text->left * $proportion);
                    $y2 = round(($text->height * $proportion) + $y1);
                    $x2 = round(($text->width * $proportion) + $x1);
                    $title = $text->content;
                    echo "<area shape='rect' coords='{$x1},{$y1},{$x2},{$y2}' href=\"javascript: writeToInput('{$title}')\" title='{$title}' alt='{$title}'>";
                }
                echo "</map>";
                echo "</div>";
            }
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
<div id="doc-meta" class="col-lg-4 col-lg-offset-8 visible-lg" style="margin-top: -20px; padding: 0px; height: calc(100% - 120px); overflow-y: scroll;position: absolute;">
    <?= Html::hiddenInput('activeInput') ?>
    <?= $this->render($mode == 'view' ? '_view' : '_update', [
        'model' => $model,
    ]) ?>

</div>
<div class="row">
    <div id="doc-meta-small" class="col-xs-12 hidden-lg"></div>
    <div id="doc-pages-small" class="col-xs-12 hidden-lg" style="margin-top: -20px;"></div>
</div>
<?php
$js = <<<js
    function fillInput(name) {
        $('input[name="activeInput"]').val(name); 
    }

    function writeToInput(text) {
        var inputField = $('#'+$('input[name="activeInput"]').val());
        alt = inputField.val();
        if(alt == '')
            inputField.val(text);
        else
            inputField.val(alt + ' ' + text);
            
        if($('input[name="activeInput"]').val() == 'document-date'){
            $('#document-date-disp').val(text);
            $('#document-date-disp').change();
        }
        
        if(inputField.hasClass('document-value')){
            sendDocumentValueForm();
        }
    }
    $('#doc-pages-small').html($('#doc-pages').html());
    $('#doc-meta-small').html($('#doc-meta').html());
js;
$this->registerJs($js,\yii\web\View::POS_END);
$css = <<<css
#doc-pages-small img {
    max-width: 100%;
}
css;
$this->registerCss($css);

