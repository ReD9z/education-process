<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trainingChoice".
 *
 * @property integer $id
 * @property integer $types_training_id
 * @property integer $plan_id
 *
 * @property Files[] $files
 * @property Timetable[] $timetables
 * @property Plan $plan
 * @property TypesTraining $typesTraining
 */
class TrainingChoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trainingChoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['types_training_id', 'plan_id'], 'required'],
            [['types_training_id', 'plan_id'], 'integer'],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_id' => 'id']],
            [['types_training_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypesTraining::className(), 'targetAttribute' => ['types_training_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'types_training_id' => 'Types Training ID',
            'plan_id' => 'Plan ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(Files::className(), ['training_choice_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTimetables()
    {
        return $this->hasMany(Timetable::className(), ['training_choice_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypesTraining()
    {
        return $this->hasOne(TypesTraining::className(), ['id' => 'types_training_id']);
    }
}
