<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/**
 * UsersSearch represents the model behind the search form about `app\models\Users`.
 */
class UsersSearch extends Users
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['login', 'globalSearch', 'username', 'role.name', 'role_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Users::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

        $query->joinWith(['profiles', 'role']);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'role_id' => $this->role_id,
           // 'profiles.address' => $this->profiles->address,
        ]);

        $query->orFilterWhere(['like', 'login', $this->login])
            ->orFilterWhere(['like', 'username', $this->username])
            ->orFilterWhere(['like', 'role_id', $this->role_id])
            ->orFilterWhere(['like', 'username', $this->globalSearch])
            ->orFilterWhere(['like', 'role.name', $this->globalSearch])
        ;

        return $dataProvider;
    }

}