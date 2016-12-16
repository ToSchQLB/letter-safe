<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "queue".
 *
 * @property integer $id
 * @property string $time
 * @property string $job
 */
class Queue extends \yii\db\ActiveRecord
{
    public static function createNewJob($job)
    {
        $queue = new Queue();
        $queue->job =$job;
        $queue->save();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'queue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'safe'],
            [['job'], 'required'],
            [['job'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'time' => Yii::t('app', 'Time'),
            'job' => Yii::t('app', 'Job'),
        ];
    }
}
