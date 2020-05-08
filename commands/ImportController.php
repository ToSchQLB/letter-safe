<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 15.07.2016
 * Time: 22:51
 */

namespace app\commands;


use app\components\HocrParser;
use app\components\HocrPaser;
use app\models\Document;
use app\models\DocumentField;
use app\models\DocumentType;
use app\models\DocumentValue;
use app\models\Sender;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class HocrController
 * @package app\commands
 */
class ImportController extends Controller
{

    const FILELIST_MODUS_LINEAR = 1;
    const FILELIST_MODUS_SORTIERT = 2;

    /**
     * @param $id
     */
    public static function doDocumentTypeDetection($id)
    {
        $document = Document::findOne($id);
        DocumentValue::deleteAll(['document_id' => $id]);
        $fulltext = $document->full_text;

        $documentTypeDetected = false;

        $fulltextArray = explode("\n", $fulltext);

        $documentTypes = DocumentType::find()->all();

        foreach ($documentTypes as $documentType) {
//            echo '::' . $documentType->name . '::' . chr(10);
            if (count(preg_grep("/{$documentType->regex}/i", $fulltextArray)) > 0) {
                $allRequiredFieldsDetected = true;
                $documentValues            = [];
                foreach ($documentType->documentTypeHasFields as $dtHasField) {
                    $matches = [];
                    $df      = $dtHasField->field;
//                    echo $df->regex . " - " . $df->element . "\n";
                    preg_match_all("/" . $df->regex . "/im", $fulltext, $matches);
                    if (isset($matches[$df->element]) && count($matches[$df->element]) > 0) {
//                        echo $matches[$df->element][0] . "\n";
                        $documentValues[] = [
                            'document_id' => $document->id,
                            'field_id' => $df->id,
                            'value' => $matches[$df->element][0]
                        ];
                    } else {
                        if ($dtHasField->required == 1) {
                            $allRequiredFieldsDetected = false;
                        }
                    }
                }
                if ($allRequiredFieldsDetected) {
                    $document->document_type_id = $documentType->id;
                    $document->save();

                    foreach ($documentValues as $documentValue) {
                        $model             = new DocumentValue();
                        $model->attributes = $documentValue;
                        $model->save();
                    }
                    return;
                }
            }
        }
    }

    /**
     * eine hocr File parsen
     * @param $file
     */
    public function actionText($id)
    {
        $document = Document::findOne($id);
        $basedir = $this->getFolderByDocument($document);
        if(file_exists($basedir.'/text.txt')){
            $data = file_get_contents($basedir.'/text.txt');
            echo 'Text: '.$data;
            $document->full_text = $data;
            $document->save();
        }
    }

    public function actionStatus($id,$status){
        $document = Document::findOne($id);
        $document->status = $status;
        $document->save();
    }

    public function actionAnalyseSender($id){
        $document = Document::findOne($id);
        $basedir = $this->getFolderByDocument($document);
        if(file_exists($basedir."/text.json")){
            $jsonData = json_decode(file_get_contents($basedir."/text.json"));
            foreach ($jsonData as $jsonDatum) {
                if($jsonDatum->page ==1){
                    foreach ($jsonDatum->text as $textItem) {
                        $textItem->content = rtrim($textItem->content,",");
                        if($textItem->left >= 200 && $textItem->top >= 405 && $textItem->left <= 960 && $textItem->top <= 650){
                            Console::stdout("Suche: ".$textItem->content .chr(10) . chr(13));
                            Console::moveCursorNextLine();
                            $senders = Sender::find()->where([
                                'or',
                                [
                                    'like',
                                    'short_name',
                                    $textItem->content
                                ],[
                                    'like',
                                    'name',
                                    $textItem->content
                                ],[
                                    'like',
                                    'name_2',
                                    $textItem->content
                                ]
                            ])->asArray()->all();
                            Console::moveCursorNextLine();
                            Console::stdout("Sender: ".count($senders));
                            Console::moveCursorNextLine();
                            Console::moveCursorNextLine();
                            if(!is_null($senders)){
                                foreach ($senders as $sender) {
                                    print_r($sender);
                                    Console::stdout('Suche: '.$sender['name'].' ... ');
                                    if (stripos($document->full_text, $sender['name'])!== false) {
                                        Console::stdout('gefunden');
                                        Console::moveCursorNextLine();
                                        $document->sender_id = $sender['id'];
                                        $document->save();
                                        return;
                                    }
                                    else{
                                        Console::stdout('nein');
                                    }
                                    Console::moveCursorNextLine();
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function actionDetectDocumentType($id){
        self::doDocumentTypeDetection($id);
    }

	public function actionDeleteTiff($id){
		$document = Document::findOne($id);
		$basedir = \Yii::$app->basePath.'/web/data/'.$document->folder;
		if(isset(\Yii::$app->params['mediaPath'])){
			$basedir = \Yii::$app->params['mediaPath'].$document->folder;
		}
		if(file_exists($basedir.'/temp.tiff')){
			unlink($basedir.'/temp.diff');
		}
    }

    public function actionCreateFileList($id, $modus = self::FILELIST_MODUS_LINEAR){
        $fileList = [];
	    $document = Document::findOne($id);
        $basedir = $this->getFolderByDocument($document);
//        var_dump($basedir);
//        var_dump(scandir($basedir));
        foreach (scandir($basedir) as $item){
            if(strpos($item, 'pdf-page')!==false){
//                var_dump($item);
                $itemNo = intval(str_replace(['pdf-page-','.jpeg'],['',''],$item));
//                var_dump($itemNo);
                $fileList[$itemNo]= $basedir.'/'.$item .chr(13).chr(10);
            }
        }
//        var_dump($fileList);
//        die();
        ksort($fileList);
        if($modus == self::FILELIST_MODUS_SORTIERT){
            $nfl = [];
            for($i=0; $i <= count($fileList)/2; $i++);
            {
                $nfl[] = $fileList[$i];
                $nfl[] = $fileList[count($fileList)-1-$i];
            }
            if(count($nfl) != count($fileList)){
                $nfl[] = $fileList[intval(count($fileList))+1];
            }
            $fileList = $nfl;
        }

        file_put_contents($basedir.'/file_list.txt', implode('',$fileList));
    }

    /**
     * @param $document Document
     * @return string
     */
    private function getFolderByDocument($document){
        $basedir = \Yii::$app->basePath.'/web/data/'.$document->folder;
        if(isset(\Yii::$app->params['mediaPath'])){
            $basedir = \Yii::$app->params['mediaPath'].$document->folder;
        }
        return $basedir;
    }

}