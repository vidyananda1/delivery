<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

/**
 * CustomerSearch represents the model behind the search form of `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by'], 'integer'],
            [['cus_name', 'address', 'sec_address', 'landmark', 'sec_landmark', 'phone', 'sec_phone', 'created_date', 'record_status'], 'safe'],
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
        $query = Customer::find();

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
            'created_by' => $this->created_by,
            'created_date' => $this->created_date,
        ]);

        $query->andFilterWhere(['like', 'cus_name', $this->cus_name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'sec_address', $this->sec_address])
            ->andFilterWhere(['like', 'landmark', $this->landmark])
            ->andFilterWhere(['like', 'sec_landmark', $this->sec_landmark])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'sec_phone', $this->sec_phone])
            ->andFilterWhere(['like', 'record_status', $this->record_status]);

        return $dataProvider;
    }
}
