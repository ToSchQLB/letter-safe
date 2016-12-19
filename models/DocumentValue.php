<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document_value".
 *
 * @property integer $document_id
 * @property integer $field_id
 * @property string $value
 *
 * @property DocumentField $field
 * @property Document $document
 */
class DocumentValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id', 'field_id'], 'required'],
            [['document_id', 'field_id'], 'integer'],
            [['value'], 'string', 'max' => 100],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentField::className(), 'targetAttribute' => ['field_id' => 'id']],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => Document::className(), 'targetAttribute' => ['document_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'document_id' => Yii::t('app', 'Document ID'),
            'field_id' => Yii::t('app', 'Field ID'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(DocumentField::className(), ['id' => 'field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(Document::className(), ['id' => 'document_id']);
    }
}
