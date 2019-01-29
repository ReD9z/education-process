<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Timetable;
use app\models\Plan;
use app\models\TrainingChoice;
use app\models\TeachersDiscipline;
use app\models\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\models\TypesTraining;
use app\models\Audiences;
use app\models\Institute;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Timetable models.
     * @return mixed
     */
    public function actionIndex($groups, $direction)
    {
        $timetable = Timetable::find()->where(['groups_id' => $groups])->all();

        $training = TypesTraining::find()->all();

        foreach ($timetable as $timetable_value) {
            $event = new \yii2fullcalendar\models\Event();
            $event->id = $timetable_value->id;
            $event->title = $timetable_value->plan->discipline->name;
            $event->color = $timetable_value->trainingChoice->typesTraining->color;
            $event->targetUrl = Url::to(['/admin/timetable/update','id' => $timetable_value->id, 'direction' => $direction, 'groups' => $groups]);
            $event->start = date('Y-m-d\TH:i:s\Z',strtotime($timetable_value->date.' '.$timetable_value->couple->start));
            $event->end = date('Y-m-d\TH:i:s\Z',strtotime($timetable_value->date.' '.$timetable_value->couple->end));

            $events[] = $event;
        }

        return $this->render('index', [
            'events' => $events,
            'training' => $training
        ]);
    }

    /**
     * Creates a new Timetable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($groups, $direction)
    {
        $model = new Timetable();

        $timetable = Timetable::find()->all();

        $plan = Plan::find()->all();

        foreach ($plan as $plan_value) {
            if ($plan_value->direction_id == $direction) {
                $arrPlan[$plan_value->id] = $plan_value->discipline->name;
            }
        }

        $institutes = new Institute();

        $institute = Institute::find()->all();
    
        foreach ($institute as $institute_value) {
            $instituteArr[$institute_value->id] = $institute_value->full_name;
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->groups_id = $groups;
            if ($model->save()) {
                 return $this->redirect(['/admin/timetable/index', 'groups' => $groups, 'direction' => $direction]);
            }
        } 

        return $this->renderAjax('create', [
            'model' => $model,
            'arrPlan' => $arrPlan,
            'instituteArr' => $instituteArr,
            'institutes' => $institutes,
            'arrAudiences' => [],
            'arrChoice' => [],
            'arrUsers' => [],
        ]);
        
    }

    public function actionAudiences($id) {
        $audiences = Audiences::find()->where(['institute_id' => $id])->all();
        foreach ($audiences as $audiences_value) {
            echo "<option value ='".$audiences_value->id."''>". $audiences_value->name ."</option>";
        }
    }

    public function actionList($id) {
        $countChoice = TrainingChoice::find()->where(['plan_id' => $id])->count();
        $choice =  TrainingChoice::find()->where(['plan_id' => $id])->all();
        if($countChoice > 0) {
            echo "<option>выбрать</option>";
            foreach ($choice as $choices) {
                echo "<option value ='".$choices->id."''>". $choices->typesTraining->name ."</option>";
            }
        }
        else {
            echo "<option>-</option>";
        }
    }

    public function actionUsers($id) {
        $plan = Plan::find()->where(['id' => $id])->all();
        $teachers = TeachersDiscipline::find()->all();
        foreach ($plan as $plan_value) {
            foreach ($teachers as $teachers_value) {
                if ($teachers_value->discipline_id === $plan_value->discipline_id) {
                    echo "<option value ='".$teachers_value->teachersChair->users_id."''>". $teachers_value->teachersChair->users->username ."</option>";
                }
            }
        }
    }
    /**
     * Updates an existing Timetable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $groups, $direction)
    {
        $model = $this->findModel($id);

        $timetable = Timetable::find()->all();

        $choice = TrainingChoice::find()->where(['plan_id' => $model->plan_id])->all();

        $plan = Plan::find()->where(['direction_id' => $direction])->all();

        $teachers = TeachersDiscipline::find()->all();

        $institutes = new Institute();

        $institute = Institute::find()->all();
    
        foreach ($institute as $institute_value) {
            $instituteArr[$institute_value->id] = $institute_value->full_name;
        }

        $audiences = Audiences::find()->all();
        foreach ($audiences as $audiences_value) {
            $arrAudiences[$audiences_value->id] = $audiences_value->name;
        }


        foreach ($choice as $value) {
            $arrChoice[$value->id] = $value->typesTraining->name;
        }

        $arrUsers = [];
        $arrPlan = [];

        foreach ($plan as $plan_value) {
            foreach ($teachers as $teachers_value) {
                if ($teachers_value->discipline_id === $plan_value->discipline_id) {
                    $arrUsers[$teachers_value->teachersChair->users_id] = $teachers_value->teachersChair->users->username;
                }
            }
        }

        foreach ($plan as $value) {
            $arrPlan[$value->id] = $value->discipline->name;
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->groups_id = $groups;
            if ($model->save()) {
                return $this->redirect(['/admin/timetable/index', 'groups' => $groups, 'direction' => $direction]);
            }
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'arrPlan' => $arrPlan,
                'arrChoice' => $arrChoice,
                'groups' => $groups,
                'direction' => $direction,
                'arrUsers' => $arrUsers,
                'instituteArr' => $instituteArr,
                'institutes' => $institutes,
                'arrAudiences' => $arrAudiences,
            ]);
        }
    }

    /**
     * Deletes an existing Timetable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $groups, $direction)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/admin/timetable/index', 'groups' => $groups, 'direction' => $direction]);
    }

    /**
     * Finds the Timetable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Timetable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Timetable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
