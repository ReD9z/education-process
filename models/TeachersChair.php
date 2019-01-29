<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teachersChair".
 *
 * @property integer $id
 * @property integer $chair_id
 * @property integer $users_id
 *
 * @property Users $users
 * @property Chair $chair
 */
class TeachersChair extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teachersChair';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chair_id', 'users_id'], 'integer'],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
            [['chair_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chair::className(), 'targetAttribute' => ['chair_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chair_id' => 'Chair ID',
            'users_id' => 'Users ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChair()
    {
        return $this->hasOne(Chair::className(), ['id' => 'chair_id']);
    }

    public function getTeachersDiscipline()
    {
        return $this->hasOne(TeachersDiscipline::className(), ['teachers_chair' => 'id']);
    }
}
