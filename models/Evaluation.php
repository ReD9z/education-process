<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evaluation".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Journals[] $journals
 */
class Evaluation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJournals()
    {
        return $this->hasMany(Journals::className(), ['evaluation_id' => 'id']);
    }

    public function getRecordBook()
    {
        return $this->hasOne(RecordBook::className(), ['evaluation_id' => 'id']);
    }

    public static function EvaValue()
    {
        $arr = ['1' => '5', '2' => '4', '3' => '3', '5' => '2', '4' => 'Зачет'];
        return $arr;
    }

    public static function JournalEvaValue()
    {
        $arr = ['1' => '5', '2' => '4', '3' => '3', '5' => '2'];
        return $arr;
    }
}
