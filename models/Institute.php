<?php

namespace app\models;

use Yii;
use yii\bootstrap\ButtonDropdown;

/**
 * This is the model class for table "institute".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $small_name
 *
 * @property Chair[] $chairs
 */
class Institute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'institute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name', 'small_name'], 'required'],
            [['full_name', 'small_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Институт',
            'full_name' => 'Полное название',
            'small_name' => 'Сокращеное название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChairs()
    {
        return $this->hasOne(Chair::className(), ['institute_id' => 'id']);
    }

}
