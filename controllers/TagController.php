<?php

namespace app\controllers;

use app\models\Document;
use app\models\DocumentHasTag;
use app\models\DocumentSearch;
use Yii;
use app\models\Tag;
use app\models\TagSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
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
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tag model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $documents = Document::find()
            ->joinWith('documentHasTags')
            ->where(['document_has_tag.tag_id'=>$id])
            ->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'documents' => $documents
        ]);
    }

    /**
     * Creates a new Tag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tag();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tag model.
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
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAddToDocument($document,$tag)
    {
        if (DocumentHasTag::find()->where(['document_id' => $document, 'tag_id' => $tag])->count() == 0) {
            $model = new DocumentHasTag();
            $model->document_id = $document;
            $model->tag_id = $tag;
            $model->save();
        }
        if(Yii::$app->request->isAjax)
            echo $this->renderAjax('/document/_tags',['model'=>Document::findOne($document)]);
        else
            echo $this->render('/document/view',['model'=>Document::findOne($document),'mode'=>'view']);
    }

    public function actionRemoveFromDocument($document,$tag)
    {
        $model = DocumentHasTag::findOne(['document_id'=>$document,'tag_id'=>$tag]);
        if(!is_null($model)){
            $model->delete();
        }
        if(Yii::$app->request->isAjax)
            echo $this->renderAjax('/document/_tags',['model'=>Document::findOne($document)]);
        else
            echo $this->render('/document/view',['model'=>Document::findOne($document),'mode'=>'view']);
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
