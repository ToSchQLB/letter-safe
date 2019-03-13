<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $regex
 *
 * @property DocumentTypeHasField[] $documentTypeHasFields
 * @property DocumentField[] $fields
 */
class DocumentType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
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
        return $this->hasMany(DocumentTypeHasField::className(), ['document_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFields()
    {
        return $this->hasMany(DocumentField::className(), ['id' => 'field_id'])->viaTable('document_type_has_field', ['document_type_id' => 'id']);
    }
}
