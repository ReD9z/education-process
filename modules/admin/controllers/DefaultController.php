<?php

namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\models\Users;
use app\models\UsersSearch;
use app\models\ProfileMessages;
use yii\data\Pagination;
use app\models\Messages;
use app\models\Chat;
use app\models\Role;
use app\models\Groups;
use yii\data\ActiveDataProvider;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $profile = new ActiveDataProvider([
            'query' => Users::find()
            ->where(['id' => Yii::$app->user->identity->id])
            ->with('profiles', 'profileMessages')
        ]);

        $messages = new ActiveDataProvider([
            'query' => Messages::find()->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $groups = Groups::find()->all();

        foreach ($groups as $groups_value) {
            $arrGroups[$groups_value->id] = $groups_value->groupsName($groups_value);
        }

        $model = new Messages();
    
        if ($model->load(Yii::$app->request->post())) {
            $model->groups_id = $groups_id;
            $model->users_id = $users_id;
            $model->date = date('Y.m.d H:i:s', strtotime('+1 hour'));
            if($model->save()) {
                return $this->redirect(['/']);   
            }
        }

        $users_model = new Users();
        $usersSearch = new UsersSearch();
        $users = $usersSearch->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model'=> $model,
            'messages' => $messages,
            'profile' => $profile,
            'arrGroups' => $arrGroups,
            'usersSearch' => $usersSearch,
            'users' => $users,
            'users_model' => $users_model,
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

    public function actionUpdate($id) {

        $messages = Messages::find()->where(['id' => $id])->one();

        if ($messages->load(Yii::$app->request->post()) && $messages->save()) {
            return $this->redirect(['default/index']);
        } else {
            return $this->render('update', [
                'messages' => $messages,
            ]);
        }
       
    }

    public function actionDel($id)
    {
        $model =  Messages::findOne($id)->delete();

        return $this->redirect(['default/index']);
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
                return $this->redirect(['/admin/profile', 'id' => $id]);   
            }
        }

        return $this->render('profile', [
            'profile' => $profile,
            'model' => $model,
            'messages' => $messages,
        ]);
    }
}
