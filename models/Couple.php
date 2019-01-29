<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "couple".
 *
 * @property integer $id
 * @property string $name
 * @property string $start
 * @property string $end
 *
 * @property Timetable[] $timetables
 */
class Couple extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'couple';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'start', 'end'], 'required'],
            [['start', 'end'], 'safe'],
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
            'start' => 'Начало',
            'end' => 'Конец',
        ];
    }

    public static function addTime($time)
    {
        return date("h:i:s", strtotime($time));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimetables()
    {
        return $this->hasMany(Timetable::className(), ['couple_id' => 'id']);
    }
}
