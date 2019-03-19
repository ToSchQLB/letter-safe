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
                            Console::stdout("Suche: ".$textItem->content);
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
        $document = Document::findOne($id);
        $fulltext = $document->full_text;

        $documentTypeDetected = false;

        $fulltextArray = explode("\n",$fulltext);

        #Rechnung
        if(count(preg_grep("/(rechnung|barverkauf)/i", $fulltextArray))>0){
            $dt = DocumentType::findOne(['name'=>'Rechnung']);
            $matches = [];

            #Rechnungsbetrag
            preg_match_all("/(gesamt|brutto|end| )(betrag|summe)[ :,a-z]*([\d,.]+)[\W]{0,1}[e,€,â]{0,1}/i",$fulltext,$matches);
            if(count($matches[3]) > 0){

                Console::moveCursorNextLine();
                Console::moveCursorNextLine();
                Console::stdout('RECHNUNG:');
                Console::moveCursorNextLine();
                Console::moveCursorNextLine();
                $document->document_type_id = $dt->id;
                $document->save();
                $docValue = new DocumentValue();
                $docValue->document_id = $document->id;
                $docValue->field_id = DocumentField::findOne(['name'=>'Rechnungsbetrag'])->id;
                $docValue->value = $matches[3][0];
                $docValue->save();
                $documentTypeDetected = true;
                Console::stdout('Betrag: '.$matches[3][0]);
                Console::moveCursorNextLine();
            }

            if($documentTypeDetected){
                # Rechnungsnummer
                $matches = [];
                preg_match_all("/(rechnung|beleg|be1eg)(nr|nummer|s-nr|snummer)[\W\s]*([\w-\/]*)/i",$fulltext,$matches);
                if(count($matches[3])>0){
                    $document->document_type_id = $dt->id;
                    $document->save();
                    $docValue = new DocumentValue();
                    $docValue->document_id = $document->id;
                    $docValue->field_id = DocumentField::findOne(['name'=>'Rechnungsnummer'])->id;
                    $docValue->value = $matches[3][0];
                    $docValue->save();
                    Console::stdout('Rechnungsnummer: '.$matches[3][0]);
                    Console::moveCursorNextLine();
                }

                #Kundennummer
                $matches = [];
                preg_match_all("/(kd|kunden|mitglied)(s-nr|snummer|-nr|nummer)[\W\s]*([\w-\/]*)/i",$fulltext,$matches);
                if(count($matches[2])>0){
                    $document->document_type_id = $dt->id;
                    $document->save();
                    $docValue = new DocumentValue();
                    $docValue->document_id = $document->id;
                    $docValue->field_id = DocumentField::findOne(['name'=>'Kundennummer'])->id;
                    $docValue->value = $matches[3][0];
                    $docValue->save();
                    Console::stdout('Kundennummer: '.$matches[3][0]);
                    Console::moveCursorNextLine();
                }

                #Auftragsnummer
                $matches = [];
                preg_match_all("/auftrag(s-nr|snummer)[\W\s]*([\w-\/]*)/i",$fulltext,$matches);
                if(count($matches[2])>0){
                    $document->document_type_id = $dt->id;
                    $document->save();
                    $docValue = new DocumentValue();
                    $docValue->document_id = $document->id;
                    $docValue->field_id = DocumentField::findOne(['name'=>'Auftragsnummer'])->id;
                    $docValue->value = $matches[2][0];
                    $docValue->save();
                    Console::stdout('Auftragsnummer: '.$matches[2][0]);
                    Console::moveCursorNextLine();
                }
            }
        }

        #Versicherung
        if(count(preg_grep("/(versicherung)/i", $fulltextArray))>0){
            $dt = DocumentType::findOne(['name'=>'Versicherung']);
            $matches = [];

            #Rechnungsbetrag
            preg_match_all("/(versicherung)(nr| nr|nummer|s-nr|snummer)[\W\s]*([\w-\/]*)/i",$fulltext,$matches);
            if(count($matches[3]) > 0){

                Console::moveCursorNextLine();
                Console::moveCursorNextLine();
                Console::stdout('Versicherung:');
                Console::moveCursorNextLine();
                Console::moveCursorNextLine();
                $document->document_type_id = $dt->id;
                $document->save();
                $docValue = new DocumentValue();
                $docValue->document_id = $document->id;
                $docValue->field_id = DocumentField::findOne(['name'=>'Versicherungsnummer'])->id;
                $docValue->value = $matches[3][0];
                $docValue->save();
                $documentTypeDetected = true;
                Console::stdout('Betrag: '.$matches[3][0]);
                Console::moveCursorNextLine();
            }
        }
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