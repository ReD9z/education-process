<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chair;

/**
 * ChairSearch represents the model behind the search form about `app\models\Chair`.
 */
class ChairSearch extends Chair
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['full_name', 'small_name', 'institute_id'], 'safe'],
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
        $query = Chair::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        //$query->joinWith('institute');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'institute_id' => $this->institute_id,
        ]);

        $query->andFilterWhere(['like', 'chair.full_name', $this->full_name])
            ->andFilterWhere(['like', 'chair.small_name', $this->small_name]);
           // ->andFilterWhere(['like', 'institute.full_name', $this->institute_id]);
        return $dataProvider;
    }
}
