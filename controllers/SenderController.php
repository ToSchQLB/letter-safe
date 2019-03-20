<?php

namespace app\controllers;

use app\commands\ImportController;
use app\models\Document;
use app\models\DocumentSearch;
use Yii;
use app\models\Sender;
use app\models\SenderSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SenderController implements the CRUD actions for Sender model.
 */
class SenderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @param string $q Suchbegriff
     * @return \yii\console\Response|\yii\web\Response
     */
    public function actionAjaxSelect2($q)
    {
        $result = [];
        $response = Yii::$app->response;
        $sender = Sender::find()->select(['id','name','adress1','zip','town'])->where(['like', 'name', $q])->asArray()->all();

        for($c=0; $c < 30 && $c < count($sender); $c++){
            array_push(
                $result,
                [
                    'id'=>$sender[$c]['id'],
                    'text'=>$sender[$c]['name'].'<br>'
                        .$sender[$c]['adress1'].'<br>'
                        .$sender[$c]['zip'].' '.$sender[$c]['town']]
            );
        }

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
//        $response->data = $result;
        $response->data = ['results' => $result];
//        $response->data = ['results' => $sender];

        return $response;
    }

    public function actionAjaxCreate(){

        $model = new Sender();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $response->data = $model->toArray();

            return $response;
        }
    }

    /**
     * Lists all Sender models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SenderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sender model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchmodel = new DocumentSearch();
        $documents = $searchmodel->search(['DocumentSearch'=>['sender_id'=>$id]]);
//        $documents = Document::find()
//            ->where(['sender_id'=>$id])
//            ->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'documents' => $documents
        ]);
    }

    /**
     * Creates a new Sender model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sender();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sender model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Sender model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionReanalyse($id){
        $sender = $this->findModel($id);
        foreach ($sender->documents as $document) {
            ImportController::doDocumentTypeDetection($document->id);
        }
        $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Finds the Sender model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sender the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sender::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
