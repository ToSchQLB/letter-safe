<?php

namespace app\controllers;

use app\models\Queue;
use Yii;
use app\models\Document;
use app\models\DocumentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LetterController implements the CRUD actions for Letter model.
 */
class DocumentController extends Controller
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

		$folder = uniqid();
        $basePath = Yii::$app->basePath;
        $folder_absolute = $basePath . '/web/data/'.$folder;
        mkdir( $folder_absolute);
        chmod( $folder_absolute, 0700);
		$inFile = $folder_absolute.'/in.'.$file->extension;
        $inFilePdf = $folder_absolute.'/in.pdf';

		if($file->saveAs($inFile,true)){
            chmod( $inFile, 0600);
            if(strcmp($file->extension,'pdf')!=0) {
                Queue::createNewJob("convert {$folder_absolute}/*.{$file->extension} {$folder_absolute}/tmp.tiff");
                Queue::createNewJob("tesseract -l deu {$folder_absolute}/tmp.tiff {$folder_absolute}/in pdf");
                Queue::createNewJob("tesseract -l deu {$folder_absolute}/tmp.tiff {$folder_absolute}/text hocr");
                Queue::createNewJob("php {$basePath}/yii hocr/execute \"{$folder_absolute}/text.hocr\" \"{$folder_absolute}/text.json\"");
            } else {
                Queue::createNewJob("pdftohtml -xml " . $inFilePdf . " " . $folder_absolute . "/data");
            }
            Queue::createNewJob("convert -thumbnail x300 -background white -alpha remove " . $inFilePdf . "[0] " . $folder_absolute . "/thumb.jpeg");
            Queue::createNewJob("pdftoppm -png " . $inFilePdf . " " . $folder_absolute . "/seite");
            echo exec('php '.Yii::$app->basePath.'/yii queue/execute');// > /dev/null 2>&1 &');
		}

		$letter = new Document();
		$letter->folder = $folder;
		$letter->save();


    }

    /**
     * Lists all Letter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentSearch();
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
            'mode' => 'view',
        ]);
    }

    /**
     * Creates a new Letter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Document();

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
            return $this->render('view', [
                'model' => $model,
                'mode' => 'edit',
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
     * @return Document the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Document::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
