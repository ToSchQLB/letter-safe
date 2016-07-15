<?php

namespace app\controllers;

use Yii;
use app\models\Letter;
use app\models\LetterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LetterController implements the CRUD actions for Letter model.
 */
class LetterController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

	public function actionAjaxFileUpload()
	{
		if(!Yii::$app->request->isAjax)
			die('kein Ajax');

		$file = UploadedFile::getInstanceByName('letterFile');

		$folder = $this->getUniqueId() . $this->getUniqueId();
		$inFile = 'data/'.$folder.'/in'.$file->extension;

		if($file->saveAs($inFile,true)){
			$im = new Imagick();

			$im->setResolution(300,300);
			if( strcmp( strtolower($file->extension), 'pdf') == 0 ){
				$im->readimage($inFile.'[0]');
			} else {
				$im->readimage($inFile);
			}

			$im->setImageFormat('jpeg');
			$im->writeImage('data/'.$folder.'/thumb.jpg');
			$im->clear();
			$im->destroy();


		}


		$letter = new Letter();
		$letter->folder = $folder;
		$letter->save();


    }

    /**
     * Lists all Letter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LetterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Letter model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Letter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Letter();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Letter model.
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
     * Deletes an existing Letter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Letter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Letter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Letter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
