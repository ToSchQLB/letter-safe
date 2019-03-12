<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 12.03.2019
 * Time: 16:39
 */

namespace app\controllers;


use yii\web\Controller;

class SetupController extends Controller
{
    public function actionInitDb()
    {
        echo '<pre>' .system('cd '. __DIR__ .'/../ && php yii migrate --interactive=0') . '</pre>';
        die();
    }
}