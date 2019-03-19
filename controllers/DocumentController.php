<?php

namespace app\controllers;

use app\models\DocumentValue;
use app\models\Queue;
use Yii;
use app\models\Document;
use app\models\DocumentSearch;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Json;
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
    public $enableCsrfValidation = false;

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
        $documents = Document::find()->where(['and',['>=','status',60],['<','status',100]])->all();
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
        if(isset(Yii::$app->params['mediaPath'])){
            $folder_absolute = Yii::$app->params['mediaPath'].$folder;
        }
        mkdir( $folder_absolute);
        chmod( $folder_absolute, 0700);
        $inFileName = 'in';
		$inFile = $folder_absolute.'/'.$inFileName;
        $inFilePdf = $folder_absolute.'/in.pdf';
        $fileListName = 'file_list.txt';
        $fileListPath = $folder_absolute.'/'. $fileListName;

        $document = new Document();
        $document->folder = $folder;
        $document->save();

        $fileList = '';

        $file_transfer_succes = true;
        foreach ($files as $index => $file) {
            if(strcmp($file->extension,'pdf')!=0) {
                if ($file->saveAs($inFile . '-' . $index . '.' . $file->extension)) {
                    chmod($inFile . '-' . $index . '.' . $file->extension, 0666);
                    $fileList .= $inFile. '-'.$index.'.'.$file->extension.chr(13).chr(10);
                }
            }else{
                $file->saveAs($inFilePdf);
                chmod($inFilePdf, 0666);
                Queue::createNewJob("php {$basePath}/yii import/status {$document->id} 1");
                Queue::createNewJob("convert -density 300 $inFilePdf -background white -alpha remove {$folder_absolute}/pdf-page.jpeg");
                Queue::createNewJob("php {$basePath}/yii import/create-file-list {$document->id}");
                Queue::createNewJob("php {$basePath}/yii import/status {$document->id} 20");
            }
        }
        if(strcmp($files[0]->extension,'pdf')!=0) {
            file_put_contents($fileListPath, $fileList);
            Queue::createNewJob("php {$basePath}/yii import/status {$document->id} 1");
            /* entfällt
            if (strcmp($files[0]->extension, 'tiff') != 0) {
                Queue::createNewJob("convert {$folder_absolute}/*.{$files[0]->extension} {$folder_absolute}/tmp.tiff");
                Queue::createNewJob("php {$basePath}/yii import/status {$document->id} 10");
            }*/
//            Queue::createNewJob("tesseract -l deu -psm 1 {$folder_absolute}/tmp.tiff {$folder_absolute}/in pdf");
            Queue::createNewJob("tesseract {$folder_absolute}/{$fileListName} {$folder_absolute}/in pdf -l deu -psm 1");
            Queue::createNewJob("php {$basePath}/yii import/status {$document->id} 20");
        }
//        Queue::createNewJob("tesseract -l deu -psm 1 {$folder_absolute}/tmp.tiff {$folder_absolute}/text hocr");
        Queue::createNewJob("tesseract {$folder_absolute}/{$fileListName} {$folder_absolute}/text hocr -l deu -psm 1 ");
        Queue::createNewJob("php {$basePath}/yii import/status {$document->id} 30");
        Queue::createNewJob("php {$basePath}/yii hocr/execute \"{$folder_absolute}/text.hocr\" \"{$folder_absolute}/text.json\"");
        Queue::createNewJob("php {$basePath}/yii import/status {$document->id} 40");
//        Queue::createNewJob("tesseract -l deu -psm 1 {$folder_absolute}/tmp.tiff {$folder_absolute}/text txt");
        Queue::createNewJob("tesseract {$folder_absolute}/{$fileListName} {$folder_absolute}/text txt -l deu -psm 1 ");
        Queue::createNewJob("php {$basePath}/yii import/status {$document->id} 41");
        Queue::createNewJob("php {$basePath}/yii import/text {$document->id}");
        Queue::createNewJob("php {$basePath}/yii import/status {$document->id} 42");
        Queue::createNewJob("convert -thumbnail 325 -background white -alpha remove " . $inFilePdf . "[0] " . $folder_absolute . "/thumb.jpeg");
        Queue::createNewJob("php {$basePath}/yii import/status {$document->id} 50");
        Queue::createNewJob("pdftoppm -png " . $inFilePdf . " " . $folder_absolute . "/seite");
        Queue::createNewJob("php {$basePath}/yii import/status {$document->id} 60");
		Queue::createNewJob("php {$basePath}/yii import/delete-tiff {$document->id}");
		Queue::createNewJob("php {$basePath}/yii import/analyse-sender {$document->id}");
        Queue::createNewJob("php {$basePath}/yii import/detect-document-type {$document->id}");
//            echo exec('php '.Yii::$app->basePath.'/yii queue/execute');// > /dev/null 2>&1 &');



        $document->input_filename = $files[0]->baseName;
        $document->input_file_extension = $files[0]->extension;
        $document->input_date = new Expression('now()');
//		$document->folder = $folder;
		$document->save();
	    
    	return Json::encode([
            'files' => [
                0 => [
                    'name' => 'neues Dokument hochgeladen',
                    'size' => count($files),
                    'url' => './img/success.png',
                    'url' => './img/success.png',
                    'delete' => '/index.php?r=document/delete&id='.$document->id,
                    'deleteType' => 'POST'
                ]
            ]
        ]);


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
            if($model->status < 100){
                $model->status = 100;
                $model->save();
            }
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

    public function actionSaveValues(){
	    if(isset($_POST['documentValue'])){
//		    print_r($_POST['documentValue']);
		    foreach ($_POST['documentValue'] as $attributes){
			    $dv = DocumentValue::findOne(['document_id'=>$attributes['document_id'],'field_id'=>$attributes['field_id']]);
			    if(is_null($dv)){
				    $dv = new DocumentValue();
			    }
			    $dv->setAttributes($attributes);
			    $dv->save();

			    print_r($dv->attributes);
		    }
	    }
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
