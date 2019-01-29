<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property integer $id
 * @property integer $training_choice_id
 * @property integer $plan_id
 * @property string $path
 * @property string $name
 *
 * @property Plan $plan
 * @property TrainingChoice $trainingChoice
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['training_choice_id', 'plan_id', 'path', 'name'], 'required'],
            [['training_choice_id', 'plan_id'], 'integer'],
            [['path', 'name'], 'string', 'max' => 255],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_id' => 'id']],
            [['training_choice_id'], 'exist', 'skipOnError' => true, 'targetClass' => TrainingChoice::className(), 'targetAttribute' => ['training_choice_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'training_choice_id' => 'Training Choice ID',
            'plan_id' => 'Plan ID',
            'path' => 'Файлы',
            'name' => 'Название',
        ];
    }

    public function saveFile($filename)
    {
        $this->path = $filename;
        return $this->save(false);
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
    public function getTrainingChoice()
    {
        return $this->hasOne(TrainingChoice::className(), ['id' => 'training_choice_id']);
    }
}
