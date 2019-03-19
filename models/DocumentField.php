<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document_field".
 *
 * @property integer $id
 * @property string $name
 * @property string $regex
 * @property int $element
 *
 * @property DocumentTypeHasField[] $documentTypeHasFields
 * @property DocumentType[] $documentTypes
 * @property DocumentValue[] $documentValues
 * @property Document[] $documents
 */
class DocumentField extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document_field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
            [['regex'], 'string', 'max'=>1024],
            [['element'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentTypeHasFields()
    {
        return $this->hasMany(DocumentTypeHasField::className(), ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentTypes()
    {
        return $this->hasMany(DocumentType::className(), ['id' => 'document_type_id'])->viaTable('document_type_has_field', ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentValues()
    {
        return $this->hasMany(DocumentValue::className(), ['field_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::className(), ['id' => 'document_id'])->viaTable('document_value', ['field_id' => 'id']);
    }
}
