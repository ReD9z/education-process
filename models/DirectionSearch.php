<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Direction;

/**
 * DirectionSearch represents the model behind the search form about `app\models\Direction`.
 */
class DirectionSearch extends Direction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'chair_id', 'study_id', 'period','study','qualification_id'], 'integer'],
            [['full_name', 'small_name'], 'safe'],
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
        $query = Direction::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'chair_id' => $this->chair_id,
            'study_id' => $this->study_id,
            'period' => $this->period,
            'qualification_id' => $this->qualification_id,
        ]);

        $query->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'small_name', $this->small_name]);
        return $dataProvider;
    }
}
