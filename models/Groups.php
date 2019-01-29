<?php

namespace app\models;

use Yii;
use yii\bootstrap\ButtonDropdown;

/**
 * This is the model class for table "groups".
 *
 * @property integer $id
 * @property string $name
 * @property integer $direction_id
 *
 * @property Direction $direction
 * @property Students[] $students
 */
class Groups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'direction_id', 'course_id', 'price'], 'required'],
            [['direction_id', 'course_id', 'price', 'name'], 'integer'],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::className(), 'targetAttribute' => ['direction_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Номер группы',
            'direction_id' => 'Направление',
            'course_id' => 'Курс',
            'price' => 'Оплата за год(руб)',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirection()
    {
        return $this->hasOne(Direction::className(), ['id' => 'direction_id']);
    }

    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

    public function getStudents()
    {
        return $this->hasMany(Students::className(), ['groups_id' => 'id']);
    }

    public function getTimetable()
    {
        return $this->hasOne(Timetable::className(), ['groups_id' => 'id']);
    }

    public function groupsName()
    {
        $str = $this->course->name;
        preg_match("/(^\d{1,2}|100$)/", $str, $course);
        return
            $this->direction->small_name.
            $course[1].$this->name
        ;
    }

    public static function groupsAll()
    {
        $groups = Groups::find()->all();

        foreach ($groups as $groups_value) {
            $arrGroups[$groups_value->id] = $groups_value->groupsName($groups_value);
        }

        return $arrGroups;
    }

    public static function groupsTeachers($users)
    {
        $groups = Groups::find()->joinWith('timetable')->where(['timetable.users_id' => $users])->all();

        foreach ($groups as $groups_value) {
            $arrGroupsTeachers[$groups_value->id] = $groups_value->groupsName($groups_value);
        }

        return $arrGroupsTeachers;
    }

     public static function groupsUsers($users)
    {
        $students = Students::find()->where(['users_id' => $users])->one();

        return $students->groups->groupsName();
    }

        
}
