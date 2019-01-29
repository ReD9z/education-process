<?php

namespace app\controllers;
use yii\filters\AccessControl;
use Yii;
use app\models\Journals;
use app\models\JournalsSearch;
use app\models\Timetable;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\Groups;
use app\models\Institute;
use app\models\Students;
use app\models\TypesTraining;
use app\models\RecordBook;
use app\models\ModelsFun;

/**
 * JournalsController implements the CRUD actions for Journals model.
 */
class JournalsController extends Controller
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
                            return Yii::$app->user->identity->role_id === 1 || Yii::$app->user->identity->role_id === 3;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays a single Journals model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($groups = null, $users = null)
    {

        $timetable = Timetable::find()->where(['groups_id' => $groups])->orWhere(['users_id' => $users])->all();
 
        $training = TypesTraining::find()->all();

        foreach ($timetable as $timetable_value) {
            $event = new \yii2fullcalendar\models\Event();
            $event->id = $timetable_value->id;
            $event->title = $timetable_value->plan->discipline->name;
            $event->color = $timetable_value->trainingChoice->typesTraining->color;
            if ($timetable_value->trainingChoice->typesTraining->id === 2 || $timetable_value->trainingChoice->typesTraining->id === 3) {
                $event->url = Url::to(['/journals/record','id' => $timetable_value->id, 'groups' => $timetable_value->groups_id]);
            }
            else {
                $event->url = Url::to(['/journals/journals','id' => $timetable_value->id, 'groups' => $timetable_value->groups_id]);
            }
            $event->start = date('Y-m-d\TH:i:s\Z',strtotime($timetable_value->date.' '.$timetable_value->couple->start));
            $event->end = date('Y-m-d\TH:i:s\Z',strtotime($timetable_value->date.' '.$timetable_value->couple->end));

            $events[] = $event;
        } 

        return $this->render('view', [
            'events' => $events,
            'training' => $training
        ]);
    }

    public function actionJournals($id, $groups)
    {
        $timetable = Timetable::findOne($id);
    
        $dataProvider = new ActiveDataProvider([
            'query' => Journals::find()->joinWith('students')->where(['students.groups_id' => $groups, 'timetable_id' => $id]),
        ]);
        
        return $this->render('journals', [
            'timetable' => $timetable,
            'dataProvider' => $dataProvider,
            'groups' => $groups,
        ]);
    }

    public function actionRecord($id, $groups)
    {
        $timetable = Timetable::findOne($id);

        $dataProvider = new ActiveDataProvider([
            'query' => RecordBook::find()->joinWith('students')->where(['students.groups_id' => $groups, 'timetable_id' => $id]),
        ]);
    
        return $this->render('record', [
            'timetable' => $timetable,
            'dataProvider' => $dataProvider,
            'groups' => $groups,
        ]);
    }

    /**
     * Creates a new Journals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($groups, $timetable)
    {
        $timetable_now = Timetable::findOne($timetable);
       
        $journals = new ActiveDataProvider([
            'query' => Students::find()
            ->with('journals')
            ->where(['groups_id' => $groups]),
        ]);
       
        $model = new Journals();

        if ($model->load(Yii::$app->request->post())) {
            ModelsFun::addData('Journals', $timetable);
            return $this->redirect(['journals', 'id' => $timetable, 'groups' => $groups]);
        }
      

        return $this->renderAjax('create', [
            'journals' => $journals,
            'groups' => $groups,
            'timetable' => $timetable,
        ]);
    }

    public function actionBook($groups, $timetable)
    {
        $timetable_now = Timetable::findOne($timetable);
       
        $journals = new ActiveDataProvider([
            'query' => Students::find()
            ->with('journals')
            ->where(['groups_id' => $groups]),
        ]);
       
        $model = new RecordBook();

        if ($model->load(Yii::$app->request->post())) {
            ModelsFun::addData('RecordBook', $timetable);
            return $this->redirect(['record', 'id' => $timetable, 'groups' => $groups]);
        }
      

        return $this->renderAjax('book', [
            'journals' => $journals,
            'groups' => $groups,
            'timetable' => $timetable,
        ]);
    }


    public function actionUpdaterecord($id)
    {
        $model = RecordBook::findOne($id);

        $record = new ActiveDataProvider([
            'query' => RecordBook::find()->where(['id' => $id]),
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['record', 'id' => $model->timetable_id, 'groups' => $model->students->groups_id]);
        } 


        return $this->renderAjax('updaterecord', [
            'model' => $model,
            'record' => $record,
        ]);
    }
 
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $journals = new ActiveDataProvider([
            'query' => Journals::find()->where(['id' => $id]),
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['journals', 'id' => $model->timetable_id, 'groups' => $model->students->groups_id]);
        } 


        return $this->renderAjax('update', [
            'model' => $model,
            'journals' => $journals
        ]);
       
    }


    
    /**
     * Finds the Journals model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Journals the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Journals::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
