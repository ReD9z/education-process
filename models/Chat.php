<?php

namespace app\models;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property integer $id
 * @property string $text
 * @property integer $users_id
 * @property integer $users_send
 * @property string $date
 *
 * @property Users $users
 * @property Users $usersSend
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['users_id', 'users_send'], 'required'],
            [['users_id', 'users_send'], 'integer'],
            [['date'], 'safe'],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
            [['users_send'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_send' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'users_id' => 'Users ID',
            'users_send' => 'Users Send',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsersSend()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_send']);
    }



    public function chatList($arr)
    {
        if (Yii::$app->user->identity->id === $arr->users_id) {
            return
                '<span class="pull-right">'.
                Html::a(Html::img('/uploads/'.$arr->users->profiles->image, 
                ['class' => 'media-object img-circle','style'=>'margin-right: 10px;']),
                ['site/profile', 'id' => $arr->users_id]).
                '</span>'.
                '<div class="media-body">'.
                    '<div class="alert alert-warning" style="margin-bottom:5px;">'.
                        $arr->text.
                    '</div>'.
                    '<small class="text-muted pull-right">'.$arr->usersSend->username.' | '. $arr->date .'</small>'.
                '</div>'
            ;
        }
        if (Yii::$app->user->identity->id === $arr->users_send) {
             return 
                '<span class="pull-left">'.
                Html::a(Html::img('/uploads/'.$arr->users->profiles->image, 
                ['class' => 'media-object img-circle']),
                ['site/profile', 'id' => $arr->users_send]).
                '</span>'.
                '<div class="media-body">'.
                    '<div class="alert alert-success" style="margin-bottom:5px; margin-right:10px;">'.
                        $arr->text.
                    '</div>'.
                    '<small class="text-muted">'.$arr->usersSend->username.' | '. $arr->date .'</small>'.
                '</div>'
            ;
        }
    }
}


