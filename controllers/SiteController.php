<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use app\models\Users;
use app\models\Students;
use app\models\Timetable;
use app\models\Institute;
use app\models\Chat;
use app\models\Groups;
use app\models\GroupsSearch;
use app\models\Files;
use app\models\Messages;
use app\models\Journals;
use app\models\ProfileMessages;
use app\models\RecordBook;
use app\models\Payment;
use app\models\UsersSearch;
use app\models\Role;
use app\models\RolesModel;
use app\models\TeachersChair;
use app\models\TeachersChairSearch;
use app\models\StudentsSearch;


class SiteController extends Controller
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
                    return $this->redirect(['login']);  
                },
               'only' => ['login', 'index', 'signup'],
               'rules' => [
                   [
                       'allow' => true,
                       'actions' => ['login', 'signup'],
                       'roles' => ['?'],
                   ],
                   [
                       'allow' => true,
                       'actions' => ['index'],
                       'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role_id === 1 || Yii::$app->user->identity->role_id === 2 || Yii::$app->user->identity->role_id === 3;
                        },
                       'roles' => ['@'],
                   ],

               ],
           ],
       ];
   }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $role = Yii::$app->user->identity->role_id;

        $users_id = Yii::$app->user->identity->id; 

        $dateToDay = date('Y.m.d');

        $groups_id = Users::role($users_id);

        $statistics = new ActiveDataProvider([
            'query' => Students::find()->where(['groups_id' => $groups_id, 'users_id' => $users_id]),
        ]);

        $payment = new ActiveDataProvider([
            'query' => Payment::find()->joinWith(['students'])->where(['students.users_id' => $users_id]),
        ]);

        $profile = new ActiveDataProvider([
            'query' => Users::find()
            ->where(['id' => $users_id])
            ->with('profiles', 'profileMessages')
        ]);

        $messages = new ActiveDataProvider([
            'query' => Messages::find()->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        $arrGroupsTeachers = Groups::groupsTeachers($users_id);

        $arrGroups = Groups::groupsAll();

        if (Yii::$app->user->identity->role_id == 2) {
            $timetable = new ActiveDataProvider([
                'query' => Timetable::find()
                ->where(['groups_id' => $groups_id, 'date' => $dateToDay])
                ->orderBy('couple_id ASC'),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            $usersGroups = Groups::groupsUsers($users_id);
        }

        if (Yii::$app->user->identity->role_id == 3) {
            $timetable = new ActiveDataProvider([
                'query' => Timetable::find()
                ->where(['users_id' => $users_id, 'date' => $dateToDay])
                ->orderBy('couple_id ASC'),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
         
        }

        $model = new Messages();
        if ($model->load(Yii::$app->request->post())) {
            $model->users_id = $users_id;
            $model->date = date('Y.m.d H:i:s', strtotime('+1 hour'));
            if($model->save()) {
                return $this->redirect(['/']);   
            }
        }

        if (Yii::$app->user->identity->role_id == 1 || Yii::$app->user->identity->role_id == 3) {
            $users_model = new Users();
            $usersSearch = new UsersSearch();
            $users = $usersSearch->search(Yii::$app->request->queryParams);
        }

        if (Yii::$app->user->identity->role_id == 2) {
            $users_model = new Students();
            $usersSearch = new StudentsSearch();
            $users = $usersSearch->search(Yii::$app->request->queryParams, $groups_id);
        }

        $groups_model = new Groups();
        $groupsSearch = new GroupsSearch();
        $groups = $groupsSearch->search(Yii::$app->request->queryParams);


        $teachers_model = new TeachersChair;
        $teachersSearch = new TeachersChairSearch();
        $teachers = $teachersSearch->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'model'=> $model,
            'timetable' => $timetable,
            'messages' => $messages,
            'statistics' => $statistics,
            'payment' => $payment,
            'profile' => $profile,
            'arrGroups' => $arrGroups,
            'usersSearch' => $usersSearch,
            'users' => $users,
            'users_model' => $users_model,
            'groups_id' => $groups_id,
            'teachers' => $teachers,
            'arrGroupsTeachers' => $arrGroupsTeachers,
            'groups_model' => $groups_model,
            'groupsSearch' => $groupsSearch,
            'teachersSearch' => $teachersSearch,
            'groups' => $groups,
            'usersGroups' => $usersGroups,
        ]);
    }

    public function actionStatistics($id) {

        $students = new ActiveDataProvider([
            'query' => Students::find()->where(['groups_id' => $id]),
            'pagination' => [
                'pageSize' => 8,
                
            ],
        ]);

        $groups = Groups::find()->where(['id' => $id])->all();
        $groups_name = $groups[0]->groupsName($groups[0]);
        
        return $this->render('statistics', [
            'students' => $students,
            'groups_name' => $groups_name,
        ]);
    }

    public function actionUpdate($id) {

        $messages = Messages::find()->where(['id' => $id])->one();

        if ($messages->load(Yii::$app->request->post()) && $messages->save()) {
            return $this->redirect(['/']);
        } else {
            return $this->renderAjax('update', [
                'messages' => $messages,
            ]);
        }
       
    }

    public function actionDel($id)
    {
        $model =  Messages::findOne($id)->delete();

        return $this->redirect(['/']);
    }

    public function actionLecture($visit = null, $users, $eva = null) {
        if ($eva == null) {
            $journals = new ActiveDataProvider([
                'query' => Journals::find()
                ->joinWith(['students'])
                ->where(['visit_id' => $visit,'students.users_id' => $users])
                ->orderBy('date DESC')
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
                ->orderBy('date DESC')
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
                ->orderBy('date DESC')
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
                ->orderBy('date DESC')
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

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionChat($id)
    {
        $model = new Chat();

        $chat = new ActiveDataProvider([
            'query' => Chat::find()
            ->orderBy('id DESC')
            ->where(['users_id' => $id, 'users_send' => Yii::$app->user->identity->id])
            ->orWhere(['users_id' => Yii::$app->user->identity->id, 'users_send' => $id]),
            'pagination' => false,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $model->users_send = Yii::$app->user->identity->id;
            $model->users_id = $id;
            $model->date = date('Y.m.d H:i:s', strtotime('+1 hour'));
            if($model->save()) {
                return $this->redirect(['/site/chat', 'id' => $id]);   
            }
        }

        return $this->render('chat', [
            'model' => $model,
            'chat' => $chat,
            'id' => $id,
        ]);
    }

    public function actionProfile($id)
    {   

        $profile = new ActiveDataProvider([
            'query' => Users::find()
            ->where(['id' => $id])
            ->with('profiles', 'profileMessages')
        ]);

        $messages = new ActiveDataProvider([
            'query' => ProfileMessages::find()
            ->where(['users_id' => $id])
            ->orderBy('id DESC')
        ]);

        $model = new ProfileMessages();

        if ($model->load(Yii::$app->request->post())) {
            $model->users_id = $id;
            $model->date = date('Y.m.d H:i:s', strtotime('+1 hour'));
            if($model->save()) {
                return $this->redirect(['/site/profile', 'id' => $id]);   
            }
        }

        return $this->render('profile', [
            'profile' => $profile,
            'model' => $model,
            'messages' => $messages,
        ]);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
