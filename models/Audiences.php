<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "audiences".
 *
 * @property integer $id
 * @property integer $institute_id
 * @property string $name
 *
 * @property Institute $institute
 * @property Timetable[] $timetables
 */
class Audiences extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'audiences';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['institute_id', 'name'], 'required'],
            [['institute_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['institute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institute::className(), 'targetAttribute' => ['institute_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'institute_id' => 'Институт',
            'name' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitute()
    {
        return $this->hasOne(Institute::className(), ['id' => 'institute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimetables()
    {
        return $this->hasMany(Timetable::className(), ['audiences_id' => 'id']);
    }
}
