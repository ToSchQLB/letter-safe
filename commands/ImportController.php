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
                        if($textItem->left >= 200 && $textItem->top >= 405 && $textItem->left <= 960 && $textItem->top <= 650){
                            $sender = Sender::find()->where(['like','name',$textItem->content])->one();
                            if(!is_null($sender)){
//                                echo $textItem->content;
//                                print_r($sender);
                                $document->sender_id = $sender['id'];
                                $document->save();
                                return;
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
        $matches = [];
        preg_match_all("/(gesamt|brutto| )betrag[ :,a-z]*([\d,.]+)[\W]{0,1}[e,€]/i",$fulltext,$matches);
        if(count($matches[2]) > 0){
            $document->document_type_id = 1;
            $document->save();
            $docValue = new DocumentValue();
            $docValue->document_id = $document->id;
            $docValue->field_id = 2;
            $docValue->value = $matches[2][0];
            $docValue->save();
        }
    }

	public function actionDeleteTiff($id){
		$document = Document::findOne($id);
		$basedir = \Yii::$app->basePath.'/web/data/'.$document->folder;
		if(isset(Yii::$app->params['mediaPath'])){
			$basedir = \Yii::$app->params['mediaPath'].$document->folder;
		}
		if(file_exists($basedir.'/temp.tiff')){
			unlink($basedir.'/temp.diff');
		}
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