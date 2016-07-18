<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "letter".
 *
 * @property integer $id
 * @property integer $sender_id
 * @property string $title
 * @property string $date
 * @property string $message
 * @property string $folder
 *
 * @property Sender $sender
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender_id'], 'integer'],
            [['message'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['folder'], 'string', 'max' => 100],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sender::className(), 'targetAttribute' => ['sender_id' => 'id']],
            [['date'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sender_id' => Yii::t('app', 'Sender'),
            'title' => Yii::t('app', 'Title'),
            'message' => Yii::t('app', 'Message'),
            'folder' => Yii::t('app', 'Folder'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(Sender::className(), ['id' => 'sender_id']);
    }
}
