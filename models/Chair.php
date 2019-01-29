<?php

namespace app\models;

use Yii;
use yii\bootstrap\ButtonDropdown;

/**
 * This is the model class for table "chair".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $small_name
 * @property integer $institute_id
 *
 * @property Institute $institute
 * @property Direction[] $directions
 * @property TeachersChair[] $teachersChairs
 */
class Chair extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chair';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name', 'small_name', 'institute_id'], 'required'],
            [['institute_id'], 'integer'],
            [['full_name', 'small_name'], 'string', 'max' => 255],
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
            'full_name' => 'Полное название',
            'small_name' => 'Сокращеное название',
            'institute_id' => 'Институт',
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
    public function getDirections()
    {
        return $this->hasOne(Direction::className(), ['chair_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeachersChairs()
    {
        return $this->hasOne(TeachersChair::className(), ['chair_id' => 'id']);
    }

}
