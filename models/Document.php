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
 * @property integer $status
 * @property string $input_filename
 * @property string $input_file_extentsion
 * @property date $input_date
 * @property int document_type_id
 *
 * @property Sender $sender
 * @property DocumentType $documentType
 * @property DocumentHasTag[] $documentHasTags
 * @property Tags[] $documentTags
 * @property DocumentValue[] $documentValues
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
	        [['document_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentType::className(), 'targetAttribute' => ['document_type_id' => 'id']],
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

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDocumentType()
	{
		return $this->hasOne(DocumentType::className(), ['id' => 'document_type_id']);
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDocumentHasTags()
	{
		return $this->hasMany(DocumentHasTag::className(), ['document_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDocumentTags(){
		return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->via('documentHasTags');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDocumentValues(){
		return $this->hasMany(DocumentValue::className(), ['document_id' => 'id']);
	}
}
