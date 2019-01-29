<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/**
 * This is the model class for table "students".
 *
 * @property integer $id
 * @property integer $groups_id
 * @property integer $users_id
 *
 * @property Journals[] $journals
 * @property Groups $groups
 * @property Users $users
 */
class Students extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'students';
    }

    public function rules()
    {
        return [
            [['groups_id', 'users_id'], 'required'],
            [['groups_id', 'users_id'], 'integer'],
            [['groups_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['groups_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groups_id' => 'Groups ID',
            'users_id' => 'Users ID',
            'payment' => 'Оплата за обучение'
        ];
    }

    public function getJournals()
    {
        return $this->hasOne(Journals::className(), ['students_id' => 'id']);
    }

    public function getRecordBook()
    {
        return $this->hasOne(RecordBook::className(), ['students_id' => 'id']);
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::className(), ['students_id' => 'id']);
    }

    public function getGroups()
    {
        return $this->hasOne(Groups::className(), ['id' => 'groups_id']);
    }

    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    public function journalsVisit($arr, $url)
    {
        return
            Html::tag('span', $this->journals->visitNum($arr, 2), 
                ['class' => 'badge list-group-item-danger form-action', 'title' => 'Отсутствовал', 'data-target' => Url::to([$url.'/lecture', 'visit' => 2, 'users' => $arr->users_id])]
            ).
            Html::tag('span', $this->journals->visitNum($arr, 3), 
                ['class' => 'badge list-group-item-warning form-action', 'title' => 'Отсутствовал по уважительной причине', 'data-target' => Url::to([$url.'/lecture', 'visit' => 3, 'users' => $arr->users_id])]
            ).
            Html::tag('span', $this->journals->visitNum($arr, 1), 
                ['class' => 'badge list-group-item-success form-action', 'title' => 'Присутствовал', 'data-target' => Url::to([$url.'/lecture', 'visit' => 1, 'users' => $arr->users_id])]
            )
        ;
       
    }

    public function journalsEva($arr, $url)
    {
        return 
            Html::tag('span', $arr->journals->evaNum($arr, 5), 
                ['class' => 'badge list-group-item-danger form-action', 'title' => 'Неудовлетворительно', 'data-target' => Url::to([$url.'/lecture', 'eva' => 5, 'users' => $arr->users_id])]
            ).
            Html::tag('span', $arr->journals->evaNum($arr, 3), 
                ['class' => 'badge list-group-item-warning form-action', 'title' => 'Удовлетворительно', 'data-target' => Url::to([$url.'/lecture', 'eva' => 3, 'users' => $arr->users_id])]
            ).
            Html::tag('span', $arr->journals->evaNum($arr, 2), 
                ['class' => 'badge list-group-item-info form-action', 'title' => 'Хорошо', 'data-target' => Url::to([$url.'/lecture', 'eva' => 2, 'users' => $arr->users_id])]
            ).
            Html::tag('span', $arr->journals->evaNum($arr, 1), 
                ['class' => 'badge list-group-item-success form-action', 'title' => 'Отлично', 'data-target' => Url::to([$url.'/lecture', 'eva' => 1, 'users' => $arr->users_id])]
            )
        ; 
    }

    public function journalsStat($arr, $url = null)
    {
        if ($arr->journals == null) {
            return 
                '<ul class="list-group">'.
                    '<li class="list-group-item">Посещение: Нет информации</li>'.
                    '<li class="list-group-item">Оценки: Нет информации</li>'.
                '</ul>'
            ;
        } else {
            return
                '<ul class="list-group">'.
                    '<li class="list-group-item">Посещение'.$this->journalsVisit($arr, $url).'</li>'.
                    '<li class="list-group-item">Оценки'.$this->journalsEva($arr, $url).'</li>'.
                '</ul>'
            ;
        }
    }

    public function recordVisit($arr, $url)
    {
        return 
            Html::tag('span', $this->recordBook->visitNum($arr, 2), 
                ['class' => 'badge list-group-item-danger form-action', 'title' => 'Отсутствовал', 'data-target' => Url::to([$url.'/session', 'visit' => 2, 'users' => $arr->users_id])]
            ).
            Html::tag('span', $this->recordBook->visitNum($arr, 3), 
                ['class' => 'badge list-group-item-warning form-action', 'title' => 'Отсутствовал по уважительной причине', 'data-target' => Url::to([$url.'/session', 'visit' => 3, 'users' => $arr->users_id])]
            ).
            Html::tag('span', $this->recordBook->visitNum($arr, 1),
                ['class' => 'badge list-group-item-success form-action', 'title' => 'Присутствовал', 'data-target' => Url::to([$url.'/session', 'visit' => 1, 'users' => $arr->users_id])]
            )
        ;
       
    }

    public function recordEva($arr, $url)
    {
        return 
            Html::tag('span', $arr->recordBook->evaNum($arr, 4), 
                ['class' => 'badge form-action', 'title' => 'Зачеты', 'data-target' => Url::to([$url.'/session', 'eva' => 4, 'users' => $arr->users_id])]
            ).
            Html::tag('span', $arr->recordBook->evaNum($arr, 5), 
                ['class' => 'badge list-group-item-danger form-action', 'title' => 'Неудовлетворительно', 'data-target' => Url::to([$url.'/session', 'eva' => 5, 'users' => $arr->users_id])]
            ).
            Html::tag('span', $arr->recordBook->evaNum($arr, 3), 
                ['class' => 'badge list-group-item-warning form-action', 'title' => 'Удовлетворительно', 'data-target' => Url::to([$url.'/session', 'eva' => 3, 'users' => $arr->users_id])]
            ).
            Html::tag('span', $arr->recordBook->evaNum($arr, 2), 
                ['class' => 'badge list-group-item-info form-action', 'title' => 'Хорошо', 'data-target' => Url::to([$url.'/session', 'eva' => 2, 'users' => $arr->users_id])]
            ).
            Html::tag('span', $arr->recordBook->evaNum($arr, 1),
                ['class' => 'badge list-group-item-success form-action', 'title' => 'Отлично', 'data-target' => Url::to([$url.'/session', 'eva' => 1, 'users' => $arr->users_id])]
            )
        ; 
    }

    public function recordStat($arr, $url = null)
    {
        if ($arr->recordBook == null) {
            return 
                '<ul class="list-group">'.
                    '<li class="list-group-item">Посещение: Нет информации</li>'.
                    '<li class="list-group-item">Оценки: Нет информации</li>'.
                '</ul>'
            ;
        } else {
            return
                '<ul class="list-group">'.
                    '<li class="list-group-item">Посещение'.$this->recordVisit($arr, $url).'</li>'.
                    '<li class="list-group-item">Оценки'.$this->recordEva($arr, $url).'</li>'.
                '</ul>'
            ;
        }
    }

    public function paymentStat($arr)
    {
        if ($arr->payment == null) {
             return '';
        } 
        else {
            return 
                '<li class="list-group-item">'.
                    $arr->groups->course->name.
                    $arr->payment->paymentGet($arr->payment).
                '</li>'.
                '<div class="alert alert-danger">Оплата за обучение</div>'
            ;

        }
    }

}
