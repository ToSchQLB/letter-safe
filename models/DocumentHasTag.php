<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document_has_tag".
 *
 * @property integer $document
 * @property integer $tag
 *
 * @property Tag $tag0
 * @property Document $document0
 */
class DocumentHasTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document_has_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document', 'tag'], 'integer'],
            [['tag'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag' => 'id']],
            [['document'], 'exist', 'skipOnError' => true, 'targetClass' => Document::className(), 'targetAttribute' => ['document' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'document' => 'Document',
            'tag' => 'Tag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag0()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument0()
    {
        return $this->hasOne(Document::className(), ['id' => 'document']);
    }
}
