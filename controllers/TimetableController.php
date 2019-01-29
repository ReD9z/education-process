<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Timetable;
use app\models\Institute;
use app\models\Groups;
use app\models\Files;
use app\models\TypesTraining;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
/**
 * TimetableController implements the CRUD actions for Timetable model.
 */
class TimetableController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\NotFoundHttpException('У вас нет доступа');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role_id === 1 || Yii::$app->user->identity->role_id === 2 || Yii::$app->user->identity->role_id === 3;
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionView($id = null, $users = null)
    {
        $timetable = Timetable::find()->where(['groups_id' => $id])->orWhere(['users_id' => $users])->all();

        $training = TypesTraining::find()->all();

        foreach ($timetable as $timetable_value) {
            $event = new \yii2fullcalendar\models\Event();
            $event->id = $timetable_value->id;
            $event->title = $timetable_value->plan->discipline->name;
            $event->color = $timetable_value->trainingChoice->typesTraining->color;
            $event->targetUrl = Url::to(['/timetable/detail','timetable' => $timetable_value->id]);
            $event->start = date('Y-m-d\TH:i:s\Z',strtotime($timetable_value->date.' '.$timetable_value->couple->start));
            $event->end = date('Y-m-d\TH:i:s\Z',strtotime($timetable_value->date.' '.$timetable_value->couple->end));

            $events[] = $event;
        } 

        return $this->render('view', [
            'events' => $events,
            'training' => $training
        ]);
    }

 
    public function actionDetail($timetable)
    {
        $timetable = new ActiveDataProvider([
            'query' => Timetable::find()->where(['id' => $timetable])
        ]);
        
        return $this->renderAjax('detail', [
            'timetable' => $timetable,
        ]);
        
    }
}
