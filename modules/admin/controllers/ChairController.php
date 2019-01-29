<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Chair;
use app\models\Institute;
use app\models\TeachersChair;
use app\models\ChairSearch;
use app\models\Users;
use app\models\Discipline;
use app\models\TeachersDiscipline;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;


/**
 * ChairController implements the CRUD actions for Chair model.
 */
class ChairController extends Controller
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
     * Lists all Chair models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChairSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $institute = Institute::find()->all();

        foreach ($institute as $value) {
            $arrInstitute[$value->id] = $value->full_name;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'arrInstitute' => $arrInstitute,
        ]);
    }

    /**
     * Displays a single Chair model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Chair model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Chair();

        $institute = Institute::find()->all();

       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'institute' => $institute
            ]);
        }
    }

    /**
     * Updates an existing Chair model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionTeachers($id)
    {
        $teachers = new ActiveDataProvider([
            'query' => TeachersChair::find()->where(['chair_id' => $id]),
        ]);

        $model = new TeachersChair();
        
        $users_model = Users::find()->where(['role_id' => 3])->all();

        $arrUsers = [];
        foreach ($users_model as $value) {
            if ($value->id === $value->teachersChairs->users_id) {
                
            }
            else {
                $arrUsers[$value->id] = $value->username;
            }
        }
       
        if ($model->load(Yii::$app->request->post())) {
            $model->chair_id = $id;
            if (TeachersChair::find()->where(['users_id' => $model->users_id])->exists()) {
                Yii::$app->session->setFlash('success',"Пользователь уже состоит в группе!"); 
            }
            elseif ($model->save()) {
                return $this->redirect(['teachers', 'id' => $id]);
            }
        }
        
        return $this->render('teachers', [
            'model' => $model,
            'arrUsers' => $arrUsers,
            'teachers' => $teachers,
        ]);
    }

    public function actionDel($id, $chair)
    {
        $model = TeachersChair::findOne($id);
        $model->delete();
       
        return $this->redirect(['/admin/chair/teachers', 'id' => $chair]);
    }

    public function actionDeld($id, $chair)
    {
        $model = TeachersDiscipline::findOne($id);
        $model->delete();
       
        return $this->redirect(['/admin/chair/discipline', 'id' => $chair]);
    }


    public function actionDiscipline($id)
    {
        $TeachersDiscipline = new ActiveDataProvider([
            'query' => TeachersDiscipline::find()->where(['teachers_chair' => $id]),
        ]);

        $model = new TeachersDiscipline();
        
        $discipline = Discipline::find()->all();

       
        if ($model->load(Yii::$app->request->post())) {
            $model->teachers_chair = $id;
            if($model->save()){
                return $this->redirect(['discipline', 'id' => $id]);
            }
        }

        
        return $this->render('discipline', [
            'model' => $model,
            'TeachersDiscipline' => $TeachersDiscipline,
            'discipline' => $discipline,
            'id' => $id
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $institute = Institute::find()->all();

        foreach ($institute as $value) {
            $arrInstitute[$value->id] = $value->full_name;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'arrInstitute' => $arrInstitute
            ]);
        }
    }

    /**
     * Deletes an existing Chair model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Chair model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chair the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chair::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует!');
        }
    }
}
