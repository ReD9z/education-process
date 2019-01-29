<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Plan;
use app\models\PlanSearch;
use app\models\TrainingChoice;
use app\models\Direction;
use app\models\Files;
use app\models\FilesAdd;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;



/**
 * PlanController implements the CRUD actions for Plan model.
 */
class PlanController extends Controller
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
     * Lists all Plan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $direction = Direction::find()->all();

        foreach ($direction as $value) {
            $arrDirection[$value->id] = $value->full_name;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'arrDirection' => $arrDirection
        ]);
    }

    /**
     * Displays a single Plan model.
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
     * Creates a new Plan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Plan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Plan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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

    /**
     * Deletes an existing Plan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionChoice($id)
    {
        $model = new TrainingChoice();

        $dataProvider = new ActiveDataProvider([
            'query' => TrainingChoice::find()->where(['plan_id' => $id]),
        ]);
       
        if ($model->load(Yii::$app->request->post())) {
            $model->plan_id = $id;
            if ($model->save()) {
                return $this->redirect(['/admin/plan/choice/', 'id' => $id]);
            }
        }

        return $this->render('choice', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFiles($training, $plan)
    {
        $model = new Files();
        $files = new FilesAdd;

        $dataProvider = new ActiveDataProvider([
            'query' => Files::find()->where(['training_choice_id' => $training]),
        ]);

        if ($model->load(Yii::$app->request->post()))
        {
            $file = UploadedFile::getInstance($model, 'path');
            $model->path = $file;
            $model->training_choice_id = $training;
            $model->plan_id = $plan;

            if($model->saveFile($files->uploadFile($file, $model->path)))
            {
                return $this->redirect(['/admin/plan/files', 'training' => $training, 'plan' => $plan]);
            }
        }
        return $this->render('files', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

  
    public function actionDel($id, $training, $plan)
    {
        $model = Files::findOne($id);
        $model->delete();
       
        return $this->redirect(['/admin/plan/files', 'training' => $training, 'plan' => $plan]);
    }

    public function actionDelch($id, $plan)
    {
        $model = TrainingChoice::findOne($id);
        $model->delete();
       
        return $this->redirect(['/admin/plan/choice', 'id' => $plan]);
    }

    /**
     * Finds the Plan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Plan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Plan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
