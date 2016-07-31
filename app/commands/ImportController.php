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
        $content = '';
        if(file_exists(\Yii::$app->basePath.'/web/data/'.$document->folder.'/text.json')){
            $data = json_decode(file_get_contents(\Yii::$app->basePath.'/web/data/'.$document->folder.'/text.json'));
            foreach ($data->page as $page) {
                foreach ($page as $text) {
                    $content .= $text->content .' ';
                }
            }
        }
        $document->message = $content;
        $document->save;
    }

}