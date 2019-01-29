<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property integer $students_id
 * @property integer $course_id
 * @property integer $status
 * @property string $date
 *
 * @property Course $course
 * @property Students $students
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['students_id', 'course_id', 'status', 'date'], 'required'],
            [['students_id', 'course_id', 'status'], 'integer'],
            [['date'], 'safe'],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['students_id'], 'exist', 'skipOnError' => true, 'targetClass' => Students::className(), 'targetAttribute' => ['students_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'students_id' => 'Students ID',
            'course_id' => 'Course ID',
            'status' => 'Status',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasOne(Students::className(), ['id' => 'students_id']);
    }

    public function paymentGet($arr)
    {
        if ($arr->status == 1) {
            return '<span class="badge list-group-item-success">Бюджетник</span>';
        }
        elseif($arr->status == 2){
            return '<span class="badge list-group-item-success">Оплатил</span> - сумма ('.$arr->students->groups->price.' руб.)';
        }
        elseif($arr->status == 3) {
            return '<span class="badge list-group-item-danger">Не оплатил</span> - сумма ('.$arr->students->groups->price.' руб.)';
        }
    }
}
