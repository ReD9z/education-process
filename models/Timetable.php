<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;

/**
 * This is the model class for table "timetable".
 *
 * @property integer $id
 * @property integer $users_id
 * @property integer $groups_id
 * @property integer $plan_id
 * @property integer $couple_id
 * @property integer $training_choice_id
 * @property string $date
 *
 * @property Journals[] $journals
 * @property Couple $couple
 * @property Groups $groups
 * @property Plan $plan
 * @property TrainingChoice $trainingChoice
 * @property Users $users
 */
class Timetable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'timetable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users_id', 'groups_id', 'plan_id', 'couple_id', 'training_choice_id', 'audiences_id', 'date'], 'required'],
            [['users_id', 'groups_id', 'plan_id', 'couple_id', 'training_choice_id','audiences_id'], 'integer'],
            [['date'], 'safe'],
            [['couple_id'], 'exist', 'skipOnError' => true, 'targetClass' => Couple::className(), 'targetAttribute' => ['couple_id' => 'id']],
            [['groups_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['groups_id' => 'id']],
            [['audiences_id'], 'exist', 'skipOnError' => true, 'targetClass' => Audiences::className(), 'targetAttribute' => ['audiences_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_id' => 'id']],
            [['training_choice_id'], 'exist', 'skipOnError' => true, 'targetClass' => TrainingChoice::className(), 'targetAttribute' => ['training_choice_id' => 'id']],
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
            'users_id' => 'Преподаватель',
            'groups_id' => 'Группа',
            'plan_id' => 'Учебный план',
            'couple_id' => 'Пара',
            'training_choice_id' => 'Тип лекции',
            'audiences_id' => 'Аудитория',
            'date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJournals()
    {
        return $this->hasMany(Journals::className(), ['timetable_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCouple()
    {
        return $this->hasOne(Couple::className(), ['id' => 'couple_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    public function getAudiences()
    {
        return $this->hasOne(Audiences::className(), ['id' => 'audiences_id']);
    }

     public function getRecordBook()
    {
        return $this->hasOne(RecordBook::className(), ['timetable_id' => 'id']);
    }

    public function listFiles($arr)
    {
        foreach ($arr->plan->files as $files_value) {
            if ($arr->training_choice_id === $files_value->training_choice_id && $arr->plan_id === $files_value->plan_id) {
                echo '<li class="list-group-item">'. Html::a($files_value->name, ['/uploads/files/'.$files_value->path], ['title' => $files_value->name]).'</li>';  
            }
        }
    }

    public function listArr($arr)
    {
        return
        '<li class="list-group-item"><b>Группа: </b>'.Html::a($arr->groups->groupsName(), ['site/statistics', 'id' => $arr->groups_id]).'</li>'.
        '<li class="list-group-item"><b>Дата: </b>'.$arr->date.'</li>'.
        '<li class="list-group-item"><b>'.$arr->couple->name.': </b>'.$arr->couple->start.'-'.$arr->couple->end.'</li>'.
        '<li class="list-group-item"><b>Дисциплина: </b>'.$arr->plan->discipline->name.'</li>'.
        '<li class="list-group-item"><b>Тип занятия: </b>'.$arr->trainingChoice->typesTraining->name.'</li>'.
        '<li class="list-group-item">'.
            ButtonDropdown::widget([
                'label' =>  $arr->users->username,
                'options' => ['class' => 'btn btn-default', 'style' => 'margin-bottom:10px; width:100%'],
                'containerOptions' => ['style'=> 'width:100%;'],
                'dropdown' => [
                    'items' => [
                        ['label' => 'Расписание', 'url' => ['timetable/view', 'users' => $arr->users_id]],
                        ['label' => 'Профиль', 'url' => ['site/profile', 'id' => $model->users_id]],
                    ],
                ],
            ]).
        '</li>'
        ;
    }

    public function accessList($model, $role)
    {
            if ($role == 2) {
                return
                    '<ul class="list-group">'.
                        '<li class="list-group-item">'.
                            Html::tag('p', '<b>'.$model->couple->name.': </b>'.$model->couple->start.'-'.$model->couple->end).
                            Html::tag('p', '<b>Дисциплина: </b>'.$model->plan->discipline->name).
                            Html::tag('p', '<b>Тип занятия: </b>'.$model->trainingChoice->typesTraining->name).
                            Html::tag('p', '<b>Преподаватель: </b>'. Html::a($model->users->username, ['site/profile', 'id' => $model->users_id])).
                            Html::tag('span', 'О занятии', 
                            [
                                'class' => 'btn btn-success timetable-detail', 'title' => 'О занятии',
                                'data-target' => Url::to(['/timetable/detail', 'timetable' => $model->id])
                            ]).
                        '</li>'.
                    '</ul>'
                ;
            }

            else if ($role == 3) {
                if ($model->trainingChoice->typesTraining->id == 2 || $model->trainingChoice->typesTraining->id == 3) {
                    return
                    '<ul class="list-group">'.
                        '<li class="list-group-item">'.
                            Html::tag('p', '<b>'.$model->couple->name.': </b>'.$model->couple->start.'-'.$model->couple->end).
                            Html::tag('p', '<b>Дисциплина: </b>'.$model->plan->discipline->name).
                            Html::tag('p', '<b>Тип занятия: </b>'.$model->trainingChoice->typesTraining->name).
                            Html::tag('p', '<b>Группа: </b>'. Html::a($model->groups->groupsName(), ['site/statistics', 'id' => $model->groups_id])).
                            Html::a('Отметить студентов',
                                ['/journals/record', 'id' => $model->id, 'groups' => $model->groups_id],
                                ['class' => 'btn btn-success', 'title' => 'Отмитить']
                            ).
                        '</li>'.
                    '</ul>'
                    ;
                } else {
                    return
                    '<ul class="list-group">'.
                        '<li class="list-group-item">'.
                            Html::tag('p', '<b>'.$model->couple->name.': </b>'.$model->couple->start.'-'.$model->couple->end).
                            Html::tag('p', '<b>Дисциплина: </b>'.$model->plan->discipline->name).
                            Html::tag('p', '<b>Тип занятия: </b>'.$model->trainingChoice->typesTraining->name).
                            Html::tag('p', '<b>Группа: </b>'. Html::a($model->groups->groupsName(), ['site/statistics', 'id' => $model->groups_id])).
                            Html::a('Отметить студентов',
                                ['/journals/journals', 'id' => $model->id, 'groups' => $model->groups_id],
                                ['class' => 'btn btn-success', 'title' => 'Отмитить']
                            ).
                            
                        '</li>'.
                    '</ul>'
                    ;
                }
            }
            else {
                return '';
            }

        }
    }
