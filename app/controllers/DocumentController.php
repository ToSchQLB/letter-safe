<?php

namespace app\controllers;

use app\models\Queue;
use Yii;
use app\models\Document;
use app\models\DocumentSearch;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
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

    public function actionAjaxAnalysebox()
    {
        $documents = Document::find()->where(['<','status',60])->all();
        if(count($documents)==0)
            return '';
        return $this->renderAjax('ajax-analysebox',[
            'documents' => $documents
        ]);
    }

    public function actionAjaxInbox()
    {
        $documents = Document::find()->where(['and',['>=','status',60],['<','status',255]])->all();
        if(count($documents)==0)
            return '';
        return $this->renderAjax('ajax-inbox',[
            'documents' => $documents
        ]);
    }

    public function actionAjaxSearch($q){
        $data = Document::find()
            ->joinWith('sender')
            ->where(['or',['like','sender.name',$q],['like','document.full_text',$q]])
            ->asArray()
            ->all();

        $response = Yii::$app->getResponse();
        $response->format = Response::FORMAT_JSON;
        $response->data = $data;

        return $data;
    }

    public function actionAjaxFileUpload()
	{
		if(!Yii::$app->request->isAjax)
			die('kein Ajax');

		$files = UploadedFile::getInstancesByName('letterFile');

		$folder = uniqid();
        $basePath = Yii::$app->basePath;
        $folder_absolute = $basePath . '/web/data/'.$folder;
        mkdir( $folder_absolute);
        chmod( $folder_absolute, 0700);
		$inFile = $folder_absolute.'/in';
        $inFilePdf = $folder_absolute.'/in.pdf';

        $letter = new Document();
        $letter->folder = $folder;
        $letter->save();

        $file_transfer_succes = true;
        foreach ($files as $index => $file) {
            if(strcmp($file->extension,'pdf')!=0) {
                if ($file->saveAs($inFile . '-' . $index . '.' . $file->extension)) {
                    chmod($inFile . '-' . $index . '.' . $file->extension, 0600);
                }
            }else{
                $file->saveAs($inFilePdf);
                chmod($inFilePdf, 0600);
            }
        }
        if(strcmp($files[0]->extension,'pdf')!=0) {
            Queue::createNewJob("php {$basePath}/yii import/status {$letter->id} 1");
            Queue::createNewJob("convert {$folder_absolute}/*.{$files[0]->extension} {$folder_absolute}/tmp.tiff");
            Queue::createNewJob("php {$basePath}/yii import/status {$letter->id} 10");
            Queue::createNewJob("tesseract -l deu -psm 1 {$folder_absolute}/tmp.tiff {$folder_absolute}/in pdf");
            Queue::createNewJob("php {$basePath}/yii import/status {$letter->id} 20");
            Queue::createNewJob("tesseract -l deu -psm 1 {$folder_absolute}/tmp.tiff {$folder_absolute}/text hocr");
            Queue::createNewJob("php {$basePath}/yii import/status {$letter->id} 30");
            Queue::createNewJob("php {$basePath}/yii hocr/execute \"{$folder_absolute}/text.hocr\" \"{$folder_absolute}/text.json\"");
            Queue::createNewJob("php {$basePath}/yii import/status {$letter->id} 40");
            Queue::createNewJob("tesseract -l deu -psm 1 {$folder_absolute}/tmp.tiff {$folder_absolute}/text txt");
            Queue::createNewJob("php {$basePath}/yii import/status {$letter->id} 41");
            Queue::createNewJob("php {$basePath}/yii import/text {$letter->id}");
            Queue::createNewJob("php {$basePath}/yii import/status {$letter->id} 42");
        } else {
            Queue::createNewJob("pdftohtml -xml " . $inFilePdf . " " . $folder_absolute . "/data");
            Queue::createNewJob("php {$basePath}/yii import/status {$letter->id} 40");
        }
        Queue::createNewJob("convert -thumbnail 325 -background white -alpha remove " . $inFilePdf . "[0] " . $folder_absolute . "/thumb.jpeg");
        Queue::createNewJob("php {$basePath}/yii import/status {$letter->id} 50");
        Queue::createNewJob("pdftoppm -png " . $inFilePdf . " " . $folder_absolute . "/seite");
        Queue::createNewJob("php {$basePath}/yii import/status {$letter->id} 60");
//            echo exec('php '.Yii::$app->basePath.'/yii queue/execute');// > /dev/null 2>&1 &');



        $letter->input_filename = $files[0]->baseName;
        $letter->input_file_extension = $files[0]->extension;
        $letter->input_date = new Expression('now()');
//		$letter->folder = $folder;
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
        $model = $this->findModel($id);

        system('rm -rf '.Yii::$app->basePath.'/web/data/'.$model->folder);

        $model->delete();

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
