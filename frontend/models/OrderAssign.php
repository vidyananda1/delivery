<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_assign".
 *
 * @property int $id
 * @property int $order_detail_id
 * @property int $employee_id
 * @property string $date_of_delivery
 * @property string $record_status
 */
class OrderAssign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_assign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_detail_id', 'employee_id', 'date_of_delivery'], 'required'],
            [['order_detail_id', 'employee_id'], 'integer'],
            [['date_of_delivery'], 'safe'],
            [['record_status'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_detail_id' => 'Order Detail ID',
            'employee_id' => 'Employee ID',
            'date_of_delivery' => 'Date Of Delivery',
            'record_status' => 'Record Status',
        ];
    }
}
