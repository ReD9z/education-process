<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profileMessages".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $users_id
 * @property string $date
 *
 * @property Users $users
 */
class ProfileMessages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profileMessages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'users_id','text', 'status'], 'required'],
            [['text'], 'string'],
            [['users_id'], 'integer'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'text' => 'Отзыв',
            'status' => 'Тип отзыва',
            'users_id' => 'Users ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    public function messages($arr)
    {
        return
            '<div class="'.$this->panel($arr).'">'.
                '<div class="panel-heading">'.
                    '<h3 class="panel-title">'.$arr->title.'</h3>'.
                '</div>'.
                '<div class="panel-body">'.
                    $arr->text.
                    '<hr>'.
                    '<p class="text-right">'.
                    '<i class="fa fa-calendar"></i> '.
                        '<small class="text-muted">'.$arr->date.'</small>'.
                    '</p>'.
                '</div>'.
            '</div>'
        ;
    }

    public function message()
    {
        $arr = ['1' => 'Положительный отзыв', '2' => 'Отрицательный отзыв', '3' => 'Нейтральный отзыв'];
        return $arr;
    }

    public function panel($arr)
    {
        if ($arr->status == 1) {
            return 'panel panel-success';
        }
        else if($arr->status == 2) {
            return 'panel panel-warning';
        }
        else if($arr->status == 3) {
            return 'panel panel-danger';
        }
    }

    public function numRec($arr, $num)
    {
        $messages = ProfileMessages::find()->where(['users_id' => $arr, 'status' => $num])->all();

        return count($messages); 
    }

}
