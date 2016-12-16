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
        if(file_exists(\Yii::$app->basePath.'/web/data/'.$document->folder.'/text.txt')){
            $data = file_get_contents(\Yii::$app->basePath.'/web/data/'.$document->folder.'/text.txt');
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