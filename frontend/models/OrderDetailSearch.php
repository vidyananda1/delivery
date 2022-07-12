<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrderDetail;

/**
 * OrderDetailSearch represents the model behind the search form of `app\models\OrderDetail`.
 */
class OrderDetailSearch extends OrderDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'discount', 'seller_id', 'updated_by'], 'integer'],
            [['customer_name','invoice', 'customer_phone', 'date_of_delivery', 'payment_type', 
            'pay_out', 'pay_out_date', 'pay_out_remark', 'updated_date','delivery_status',
            'record_status','cancel_reason','order_date'], 'safe'],
            [['total_price', 'payable_amount'], 'number'],
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
        $query = OrderDetail::find();

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
            'customer_id' => $this->customer_id,
            'date_of_delivery' => $this->date_of_delivery,
            'total_price' => $this->total_price,
            'discount' => $this->discount,
            'payable_amount' => $this->payable_amount,
            'seller_id' => $this->seller_id,
            'pay_out_date' => $this->pay_out_date,
            'updated_by' => $this->updated_by,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'customer_phone', $this->customer_phone])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'payment_type', $this->payment_type])
            ->andFilterWhere(['like', 'delivery_status', $this->delivery_status])
            ->andFilterWhere(['like', 'pay_out', $this->pay_out])
            ->andFilterWhere(['like', 'cancel_reason', $this->cancel_reason])
            ->andFilterWhere(['like', 'pay_out_remark', $this->pay_out_remark])
            ->andFilterWhere(['like', 'record_status', $this->record_status]);

        return $dataProvider;
    }
}
