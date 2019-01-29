<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "direction".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $small_name
 * @property integer $chair_id
 * @property integer $study_id
 * @property integer $qualification_id
 * @property integer $period
 *
 * @property Study $study
 * @property Chair $chair
 * @property Qualification $qualification
 * @property Groups[] $groups
 */
class Direction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'direction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name', 'small_name', 'chair_id', 'study_id', 'qualification_id', 'period'], 'required'],
            [['chair_id', 'study_id', 'qualification_id', 'period'], 'integer'],
            [['full_name', 'small_name'], 'string', 'max' => 255],
            [['study_id'], 'exist', 'skipOnError' => true, 'targetClass' => Study::className(), 'targetAttribute' => ['study_id' => 'id']],
            [['chair_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chair::className(), 'targetAttribute' => ['chair_id' => 'id']],
            [['qualification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Qualification::className(), 'targetAttribute' => ['qualification_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Полное название',
            'small_name' => 'Сокращенное название',
            'chair_id' => 'Кафедра',
            'study_id' => 'Форма обучения',
            'qualification_id' => 'Квалификация обучения',
            'qualification.name' => 'Квалификация обучения',
            'chair.full_name' => 'Кафедра',
            'study.name' => 'Форма обучения',
            'period' => 'Срок обучения',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudy()
    {
        return $this->hasOne(Study::className(), ['id' => 'study_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChair()
    {
        return $this->hasOne(Chair::className(), ['id' => 'chair_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQualification()
    {
        return $this->hasOne(Qualification::className(), ['id' => 'qualification_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Groups::className(), ['direction_id' => 'id']);
    }

    public function getPlan()
    {
        return $this->hasOne(Plan::className(), ['direction_id' => 'id']);
    }
}
