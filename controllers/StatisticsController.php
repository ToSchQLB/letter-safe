<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 19.03.2019
 * Time: 21:21
 */

namespace app\controllers;


use yii\db\mssql\PDO;
use yii\filters\AccessControl;
use yii\web\Controller;

class StatisticsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($sender=null,$field=null,$filter=null,$filtervalue=null)
    {
        $data = null;
        if($sender != null && $field != null){
            $sql = <<<sql
SELECT document.date, replace(document_value.value, '.','') value FROM document
INNER JOIN document_value on document.id = document_value.document_id
WHERE document.sender_id = :sender AND document_value.field_id = :field
sql;
            if(!is_null($filter) && !empty($filter)){
                $sql .= " AND document.id in (SELECT document_id FROM document_value WHERE field_id=:filter AND value = :filterValue)";
            }
            $command = \Yii::$app->db->createCommand($sql);
            $command->bindParam('sender',$sender, PDO::PARAM_INT);
            $command->bindParam('field',$field, PDO::PARAM_INT);
            if(!is_null($filter) && !empty($filter)){
                $command->bindParam('filter', $filter, PDO::PARAM_INT);
                $command->bindParam('filterValue', $filtervalue, PDO::PARAM_STR);
            }
            $data = $command->queryAll();
        }

        return $this->render('index',[
            'sender' => $sender,
            'field' => $field,
            'filter' => $filter,
            'filtervalue' => $filtervalue,
            'data' => $data
        ]);
    }
}