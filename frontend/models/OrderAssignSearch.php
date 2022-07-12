<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrderAssign;

/**
 * OrderAssignSearch represents the model behind the search form of `app\models\OrderAssign`.
 */
class OrderAssignSearch extends OrderAssign
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_detail_id', 'employee_id'], 'integer'],
            [['date_of_delivery', 'record_status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = OrderAssign::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'order_detail_id' => $this->order_detail_id,
            'employee_id' => $this->employee_id,
            'date_of_delivery' => $this->date_of_delivery,
        ]);

        $query->andFilterWhere(['like', 'record_status', $this->record_status]);

        return $dataProvider;
    }
}
