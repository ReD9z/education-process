<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "typesTraining".
 *
 * @property integer $id
 * @property string $name
 * @property string $color
 * @property TrainingChoice[] $trainingChoices
 */
class TypesTraining extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'typesTraining';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'color'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 11],
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
            'color' => 'Цвет',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingChoices()
    {
        return $this->hasMany(TrainingChoice::className(), ['types_training_id' => 'id']);
    }
}
