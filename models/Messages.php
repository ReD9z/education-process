<?php

namespace app\models;
use yii\helpers\Html;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "messages".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $users_id
 * @property integer $groups_id
 * @property string $date
 *
 * @property Groups $groups
 * @property Users $users
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'users_id', 'groups_id'], 'required'],
            [['text'], 'string'],
            [['users_id', 'groups_id'], 'integer'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['groups_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['groups_id' => 'id']],
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
            'text' => 'Сообщение',
            'users_id' => 'Users ID',
            'groups_id' => 'Groups ID',
            'date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasOne(Groups::className(), ['id' => 'groups_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }


    public function panelBody($arr)
    {
        return 
        '<div class="panel-body">'.
            '<div class="media">'.
                Html::a(
                    Html::img('/uploads/'.$arr->users->profiles->image, ['class' => 'media-object img-circle']), 
                ['site/profile', 'id' => $arr->users_id], ['class' => 'pull-left']).
                '<div class="pull-right">'.
                    $this->bottonUptDel($arr).
                '</div>'.
                '<div class="media-body">'.
                    Html::a($arr->users->username, ['site/profile', 'id' => $arr->users_id]).
                    ' <i class="fa fa-share"></i> '.
                    $arr->groups->groupsName($arr->groups).'<br>'.
                    '<b>'.$arr->users->role->name.'</b><br>'.
                '</div>'.
            '</div>'.
            '<hr>'.
            '<h3>'.$arr->title.'</h3>'.
            $arr->text.
        '</div>'
        ;
    }

    public function bottonUptDel($arr)
    {
        if (Yii::$app->user->identity->id == $arr->users_id) {
            return Html::tag('span', '<i class="fa fa-pencil-square"></i>', 
                ['data-target' => Url::to(['/site/update', 'id' => $arr->id]), 'class' => 'btn btn-primary btn-xs form-action', 'title' => 'Редактировать', 'style' => 'margin-right: 5px;',]
            ).
            Html::a('<i class="fa fa-times-circle"></i>', ['del', 'id' => $arr->id], [
                'class' => 'btn btn-danger btn-xs',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                    'method' => 'post',
                    'title' => 'Удалить',
                ],
            ]);
        }
    }


    public function panelFooter($arr)
    {
        return
            '<div class="panel-footer">'.
                '<p class="text-right"><i class="fa fa-calendar"></i> '.
                '<small class="text-muted">'. $arr->date. '</small></p>'.
            '</div>'
        ;
    }
    
}
