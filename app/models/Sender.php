<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sender".
 *
 * @property integer $id
 * @property string $name
 * @property string $adress1
 * @property string $adress2
 * @property string $zip
 * @property string $town
 * @property string $state
 * @property string $country
 *
 * @property Letter[] $letters
 */
class Sender extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sender';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'adress1', 'adress2', 'town'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 5],
            [['state', 'country'], 'string', 'max' => 100],
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
            'adress1' => Yii::t('app', 'Adress1'),
            'adress2' => Yii::t('app', 'Adress2'),
            'zip' => Yii::t('app', 'Zip'),
            'town' => Yii::t('app', 'Town'),
            'state' => Yii::t('app', 'State'),
            'country' => Yii::t('app', 'Country'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLetters()
    {
        return $this->hasMany(Letter::className(), ['sender_id' => 'id']);
    }
}
