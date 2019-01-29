<?php

namespace app\models;
use yii\web\IdentityInterface;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $username
 * @property string $auth_key
 * @property integer $role_id
 * @property string $date
 *
 * @property Profile[] $profiles
 * @property Students[] $students
 * @property Teachers[] $teachers
 * @property TeachersChair[] $teachersChairs
 * @property Role $role
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'password', 'username','role_id'], 'required'],
            [['role_id'], 'integer'],
            [['date'], 'safe'],
            [['login', 'password', 'username', 'auth_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'username' => 'ФИО',
            'auth_key' => 'Auth Key',
            'date' => 'Дата',
            'role_id' => 'Права пользователя'
        ];
    }

    public function hashPassword($password)
    {
       return Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        //return static::findOne(['access_token' => $token]);
    }
   
    public static function findByUsername($login)
    {
        return static::findOne(['login' => $login]);
    }

    public static function addDate($date)
    {
        return date("Y-m-d h:i:s", strtotime($date));
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
    
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function generateAuthKey()
    {
       $this->auth_key = Yii::$app->security->generateRandomString();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasOne(Profile::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasOne(Students::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeachers()
    {
        return $this->hasMany(Teachers::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeachersChairs()
    {
        return $this->hasOne(TeachersChair::className(), ['users_id' => 'id']);
    }

    public function getProfileMessages()
    {
        return $this->hasOne(ProfileMessages::className(), ['users_id' => 'id']);
    }

    public function getTimetable()
    {
        return $this->hasOne(Timetable::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    public function profileGet($arr)
    {
        return
            Html::img('/uploads/'.$arr->profiles->image, ['style' => 'width: 200px;']).
            '<div class="caption">'.
                '<h4 class="text-center">'.$arr->username.'</h4>'.
                '<p><b>Адрес: </b>'. $arr->profiles->address.'</p>'.
                '<p><b>E-mail: </b>'. $arr->profiles->email.'</p>'.
                '<p><b>Телефон: </b>'. $arr->profiles->phone.'</p>'.
                '<p><b>Права: </b>'. $arr->role->name.'</p>'.
                '<p><b>Отзывы: </b>'.$this->recommend($arr).'</p>'.
                $this->chatGet($arr).
            '</div>'
        ;
    }

    public function recommend($arr)
    {
        if ($this->profileMessages == null) {
            return 'отсутствуют';
        } else {
            return 
            Html::tag('span', $this->profileMessages->numRec($arr->id, 3),
                ['class' => 'badge list-group-item-danger', 'title' => 'Отрицательный']
            ).
            Html::tag('span', $this->profileMessages->numRec($arr->id, 2), 
                ['class' => 'badge list-group-item-warning', 'title' => 'Нейтральный']
            ).
            Html::tag('span', $this->profileMessages->numRec($arr->id, 1),
                ['class' => 'badge list-group-item-success', 'title' => 'Положительный']
            )
            ;
        }
    }

    public function chatGet($arr)
    {
       if (Yii::$app->user->identity->id === $arr->id) {
           return '';
       }else {
            return '<p>'. Html::a('<i class="fa fa-commenting-o"></i> Чат</a>', ['chat','id' => $arr->id], ['class' => 'btn btn-primary']).'</p>';
       }
    }

    public function chatIcon($name)
    {
           
        if ($name->id == Yii::$app->user->identity->id) {
            return '';
        }
        else {
            return Html::a(
                '<i class="fa fa-comment-o"></i>',
                ['site/chat', 'id' => $name->id], ['class' => 'badge list-group-item-success', 'title' => 'Чат']
            );
        }
    }

    public function profileIcon($name) {
        return Html::a(
            '<i class="fa fa-user-circle-o"></i>',
            ['profile', 'id' => $name->id], ['class' => 'badge list-group-item-warning', 'title' => 'Профиль']
        ); 
    }

    public static function role($id)
    {
        $groups_id = Students::find()->where(['users_id' => $id])->one();
        return $groups_id->groups_id; 
    }
}
