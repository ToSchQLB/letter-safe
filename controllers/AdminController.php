<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 13.03.2019
 * Time: 20:18
 */

namespace app\controllers;


use app\models\DocumentField;
use app\models\DocumentType;
use app\models\search\DocumentFieldSearch;
use app\models\search\DocumentTypeSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function actionDocumentType()
    {
        $searchModel = new DocumentTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('document_type_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'document-typ-delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DocumentType models.
     * @return mixed
     */
    public function actionDocumentTypeIndex()
    {
        $searchModel = new DocumentTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('document-type/index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single DocumentType model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDocumentTypeView($id)
    {
        return $this->render('document-type/view', [
            'model' => $this->findDocumentTypeModel($id),
        ]);
    }

    /**
     * Creates a new DocumentType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDocumentTypeCreate()
    {
        $model = new DocumentType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['document-type-view', 'id' => $model->id]);
        }

        return $this->render('document-type/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DocumentType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDocumentTypeUpdate($id)
    {
        $model = $this->findDocumentTypeModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['document-type-view', 'id' => $model->id]);
        }

        return $this->render('document-type/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocumentType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDocumentTypeDelete($id)
    {
        $this->findDocumentTypeModel($id)->delete();

        return $this->redirect(['document-type-index']);
    }

    /**
     * Lists all DocumentField models.
     * @return mixed
     */
    public function actionDocumentFieldIndex()
    {
        $searchModel = new DocumentFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('document-field/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocumentField model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDocumentFieldView($id)
    {
        return $this->render('document-field/view', [
            'model' => $this->findDocumentFieldModel($id),
        ]);
    }

    /**
     * Creates a new DocumentField model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDocumentFieldCreate()
    {
        $model = new DocumentField();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['document-field-view', 'id' => $model->id]);
        }

        return $this->render('document-field/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DocumentField model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDocumentFieldUpdate($id)
    {
        $model = $this->findDocumentFieldModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['document-field-view', 'id' => $model->id]);
        }

        return $this->render('document-field/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocumentField model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDocumentFieldDelete($id)
    {
        $this->findDocumentFieldModel($id)->delete();

        return $this->redirect(['document-field-index']);
    }

    /**
     * Finds the DocumentField model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DocumentField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findDocumentFieldModel($id)
    {
        if (($model = DocumentField::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * Finds the DocumentType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DocumentType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findDocumentTypeModel($id)
    {
        if (($model = DocumentType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}