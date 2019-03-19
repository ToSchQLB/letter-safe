<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 19.03.2019
 * Time: 21:21
 */

namespace app\controllers;


use yii\db\mssql\PDO;
use yii\web\Controller;

class StatisticsController extends Controller
{
    public function actionIndex($sender=null,$field=null)
    {
        $data = null;
        if($sender != null && $field != null){
            $sql = <<<sql
SELECT document.date, replace(document_value.value, '.','') value FROM document
INNER JOIN document_value on document.id = document_value.document_id
WHERE document.sender_id = :sender AND document_value.field_id = :field
sql;
            $command = \Yii::$app->db->createCommand($sql);
            $command->bindParam('sender',$sender, PDO::PARAM_INT);
            $command->bindParam('field',$field, PDO::PARAM_INT);
            $data = $command->queryAll();
        }

        return $this->render('index',[
            'sender' => $sender,
            'field' => $field,
            'data' => $data
        ]);
    }
}