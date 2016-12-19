<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document_type_has_field".
 *
 * @property integer $document_type_id
 * @property integer $field_id
 *
 * @property DocumentField $field
 * @property DocumentType $documentType
 */
class DocumentTypeHasField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document_type_has_field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_type_id', 'field_id'], 'required'],
            [['document_type_id', 'field_id'], 'integer'],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentField::className(), 'targetAttribute' => ['field_id' => 'id']],
            [['document_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DocumentType::className(), 'targetAttribute' => ['document_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'document_type_id' => Yii::t('app', 'Document Type ID'),
            'field_id' => Yii::t('app', 'Field ID'),
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
    public function getDocumentType()
    {
        return $this->hasOne(DocumentType::className(), ['id' => 'document_type_id']);
    }
}
