<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use app\models\Profile;
use app\models\Role;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\ImageUpload;
use yii\data\ActiveDataProvider;

class UsersController extends Controller
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
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $role = Role::find()->all();

        foreach ($role as $value) {
            $arrRole[$value->id] = $value->name;
        }
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'arrRole' => $arrRole,
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
        $model = new Users();
        $profile = new Profile();

        $images = new ImageUpload;

        if ($model->load(Yii::$app->request->post())) {
            $hash = $model->hashPassword($model->password);
            $model->password = $hash;
            $date = $model->addDate($model->date);
            $model->date = $date;
            if ($model->save()) {
                if ($profile->load(Yii::$app->request->post())) {
                    $profile->users_id = $model->id;
                    $file = UploadedFile::getInstance($profile, 'image');
                    $profile->saveImage($images->uploadFile($file, $profile->image));
                    if($profile->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'profile' => $profile,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
     
        $profile = Profile::find()->where(['users_id' => $id])->one();
    
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                if ($profile->load(Yii::$app->request->post())) {
                    $profile->users_id = $id;
                    if($profile->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }

        } else {
            return $this->render('update', [
                'model' => $model,
                'profile' => $profile
            ]);
        }
    }

    public function actionPassword($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $hash = $model->hashPassword($model->password);
            $model->password = $hash;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]); 
            }
        }
    
        return $this->render('password', [
            'model' => $model,
        ]);
    }

    public function actionImage($id)
    {
        $images = new ImageUpload;

        $model = $this->findModel($id); 

        $profile = Profile::find()->where(['users_id' => $id])->one();

        if($profile->load(Yii::$app->request->post())) {
            $profile->users_id = $model->id;
            $file = UploadedFile::getInstance($profile, 'image');
            $profile->saveImage($images->uploadFile($file, $profile->image));
            if($profile->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('image', [
            'profile' => $profile,
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрашиваемая страница не существует!');
        }
    }
}
