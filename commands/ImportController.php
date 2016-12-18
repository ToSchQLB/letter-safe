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
use yii\console\Controller;

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
        $basedir = \Yii::$app->basePath.'/web/data/'.$document->folder;
        if(isset(Yii::$app->params['mediaPath'])){
            $basedir = \Yii::$app->params['mediaPath'].$document->folder;
        }
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

}