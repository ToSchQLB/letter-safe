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
use yii\console\Controller;

/**
 * Class HocrController
 * @package app\commands
 */
class HocrController extends Controller
{

    /**
     * eine hocr File parsen
     * @param $file
     */
    public function actionExecute($inFile, $outFile)
    {
//        echo $file;
        $parser = new HocrParser($inFile);
        $parser->parse();
        $parser->save($outFile);
    }

}