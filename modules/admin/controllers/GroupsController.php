<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Groups;
use app\models\GroupsSearch;
use app\models\Users;
use app\models\Students;
use app\models\Direction;
use app\models\Course;
use app\models\Journals;
use app\models\RecordBook;
use app\models\Payment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

class GroupsController extends Controller
{
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

    public function actionIndex()
    {
        $searchModel = new GroupsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $direction = Direction::find()->all();

        foreach ($direction as $value) {
            $arrDirection[$value->id] = $value->full_name;
        }

        $course = Course::find()->all();

        foreach ($course as $value) {
            $arrCourse[$value->id] = $value->name;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'arrDirection' => $arrDirection,
            'arrCourse' => $arrCourse,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Groups();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionStudents($id)
    {
        $students = new ActiveDataProvider([
            'query' => Students::find()->where(['groups_id' => $id]),
        ]);

        $model = new Students();
        
        $users_model = Users::find()->where(['role_id' => 2])->all();

        $arrUsers = [];
        foreach ($users_model as $value) {
            if ($value->id === $value->students->users_id) {
                
            }
            else {
                $arrUsers[$value->id] = $value->username;
            }
        }
       
        if ($model->load(Yii::$app->request->post())) {
            $model->groups_id = $id;
            if (Students::find()->where(['users_id' => $model->users_id])->exists()) {
                Yii::$app->session->setFlash('success',"Пользователь уже состоит в группе!"); 
            }
            elseif ($model->save()) {
                return $this->redirect(['students', 'id' => $id]);
            }
        }
        
        return $this->render('students', [
            'model' => $model,
            'arrUsers' => $arrUsers,
            'students' => $students,
        ]);
    }

    public function actionLecture($visit = null, $users, $eva = null) {
        if ($eva == null) {
            $journals = new ActiveDataProvider([
                'query' => Journals::find()
                ->joinWith(['students'])
                ->where(['visit_id' => $visit,'students.users_id' => $users])
                ,
                'pagination' => [
                    'pageSize' => 8,
                    
                ],
            ]);
        }else {
            $journals = new ActiveDataProvider([
                'query' => Journals::find()
                ->joinWith(['students'])
                ->where(['evaluation_id' => $eva,'students.users_id' => $users])
                ,
                'pagination' => [
                    'pageSize' => 8,
                    
                ],
            ]);
        }

        return $this->renderAjax('lecture', [
            'journals' => $journals,
        ]);
    }

    public function actionSession($visit = null, $users, $eva = null) {

        if ($eva == null) {
            $record = new ActiveDataProvider([
                'query' => RecordBook::find()
                ->joinWith(['students'])
                ->where(['visit_id' => $visit,'students.users_id' => $users])
                ,
                'pagination' => [
                    'pageSize' => 8,
                    
                ],
            ]);
        }else {
            $record = new ActiveDataProvider([
                'query' => RecordBook::find()
                ->joinWith(['students'])
                ->where(['evaluation_id' => $eva,'students.users_id' => $users])
                ,
                'pagination' => [
                    'pageSize' => 8,
                    
                ],
            ]);
        }

        return $this->renderAjax('session', [
            'record' => $record,
        ]);
    }


    public function actionStatistics($id) {

        $students = new ActiveDataProvider([
            'query' => Students::find()->with('journals')->where(['groups_id' => $id]),
            'pagination' => [
                'pageSize' => 8,
                
            ],
        ]);

        return $this->render('statistics', [
            'students' => $students,
            'groups' => $this->findModel($id),
        ]);
    }

    public function actionPayment($groups, $course) {

        $model = Payment::find()->joinWith('students')->where(['students.groups_id' => $groups, 'course_id' => $course])->all();

        $payment = new ActiveDataProvider([
            'query' => Payment::find()->joinWith('students')->where(['students.groups_id' => $groups, 'course_id' => $course]),
        ]);
        
        return $this->render('payment', [
            'payment' => $payment,
            'groups' => $groups,
            'course' => $course,
            'model' => $model,
        ]);
    }

    public function actionPrice($groups, $course) {

        $students = Students::find()->where(['groups_id' => $groups])->all();
        
        $model = new Payment();

        if ($model->load(Yii::$app->request->post())) {
            $arr = Yii::$app->request->post('Payment');
            for ($i=0; $i < count($arr['students_id']); $i++) { 
                Yii::$app->db->createCommand()->insert('Payment', [
                    'students_id' => $arr['students_id'][$i],
                    'course_id' => $course,
                    'status' => $arr['status'][$i],    
                    'date' =>  date('Y.m.d'),
                ])->execute();
            }
            return $this->redirect(['payment', 'groups' => $groups, 'course' => $course]);
        }

        return $this->render('price', [
            'students' => $students,
            'model' => $model,
        ]);
    }

    public function actionUpdateprice($id, $groups, $course)
    {
        $model = Payment::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['payment', 'id' => $model->id, 'groups' => $groups, 'course' => $course]);
        } else {
            return $this->render('updateprice', [
                'model' => $model,
            ]);
        }
    }

    public function actionDel($id, $groups)
    {
        $model = Students::findOne($id);
        $model->delete();
       
        return $this->redirect(['/admin/groups/students', 'id' => $groups]);
    }

    protected function findModel($id)
    {
        if (($model = Groups::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует.');
        }
    }
}
