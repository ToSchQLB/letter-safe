<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 15.07.2016
 * Time: 22:51
 */

namespace app\commands;

use app\models\Queue;
use yii\console\Controller;
use yii\helpers\Console;

class QueueController extends Controller
{
    var $lockFile = '.lock_queue';
    /**
     * Execute job queue
     */
    public function actionExecute()
    {
        if(file_exists(\Yii::$app->runtimePath.'/'.$this->lockFile)){
            $this->stdout('Queue allready active!'.chr(10).chr(13), Console::FG_RED);
            return 0;
        }

        $this->lockQueue();
        $this->executeQueue();
    }

    public function actionLockQueue()
    {
        $this->lockFile();
    }

    public function actionUnlockQueue(){
        $this->unlock();
    }

    private function executeQueue(){
        $jobs = Queue::find()->all();
        echo chr(10).chr(13). exec('whoami').chr(10).chr(13);
        foreach ($jobs as $job) {
            echo $job->id.': '.$job->job;

            echo exec($job->job);

            $job->delete();
        }
        if(Queue::find()->count() == 0){
            $this->unlock();
        }else{
            $this->executeQueue();
        }
    }

    private function unlock(){
        unlink(\Yii::$app->runtimePath.'/'.$this->lockFile);
        $this->stdout('Queue stopped'.chr(10).chr(13), Console::FG_GREEN);
    }

    private function lockQueue(){
        $file = fopen(\Yii::$app->runtimePath.'/'.$this->lockFile,'w+');
        fwrite($file,time());
        fclose($file);
    }
}