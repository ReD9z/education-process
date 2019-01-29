<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Plan;

/**
 * PlanSearch represents the model behind the search form about `app\models\Plan`.
 */
class PlanSearch extends Plan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'direction_id', 'time'], 'integer'],
            [['discipline_id','course_id', 'semester_id'], 'safe'],
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
        $query = Plan::find();

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
        $query->joinWith(['discipline','course','semester']);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
           // 'discipline_id' => $this->discipline_id,
            'direction_id' => $this->direction_id,
            'time' => $this->time,
            //'course_id' => $this->course_id,
            //'semester_id' => $this->semester_id,
        ]);


        $query->andFilterWhere(['like', 'discipline.name', $this->discipline_id])
            ->andFilterWhere(['like', 'course.name', $this->course_id])
            ->andFilterWhere(['like', 'semester.name', $this->semester_id]);   
            

        return $dataProvider;
    }
}
