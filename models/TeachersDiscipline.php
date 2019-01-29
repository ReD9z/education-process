<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teachersDiscipline".
 *
 * @property integer $id
 * @property integer $teachers_chair
 * @property integer $discipline_id
 *
 * @property TeachersChair $id0
 * @property Discipline $discipline
 */
class TeachersDiscipline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teachersDiscipline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teachers_chair', 'discipline_id'], 'integer'],
            [['discipline_id'], 'required'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => TeachersChair::className(), 'targetAttribute' => ['id' => 'id']],
            [['discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discipline::className(), 'targetAttribute' => ['discipline_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teachers_chair' => 'Teachers Chair',
            'discipline_id' => 'Discipline ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeachersChair()
    {
        return $this->hasOne(TeachersChair::className(), ['id' => 'teachers_chair']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscipline()
    {
        return $this->hasOne(Discipline::className(), ['id' => 'discipline_id']);
    }
}
