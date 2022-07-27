<?php

namespace api\modules\v1\models;

use Yii\db\ActiveRecord;
use Yii;
use Exception;

/**
 * This is the model class for table "slider_image".
 *
 * @property int $id
 * @property string $images
 * @property string $image_title
 * @property int $created_by
 * @property string $created_date
 * @property int|null $updated_by
 * @property string|null $updated_date
 * @property string $record_status
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_name','customer_id', 'invoice', 'customer_phone', 'date_of_delivery', 'total_price', 'payable_amount', 'seller_id','order_date'], 'required'],
            [['customer_id', 'discount', 'seller_id', 'updated_by'], 'integer'],
            [['date_of_delivery', 'pay_out_date', 'updated_date','order_date'], 'safe'],
            [['total_price', 'payable_amount','delivery_charge'], 'number'],
            [['payment_type', 'pay_out','delivery_status'], 'string'],
            [['invoice'], 'string', 'max' => 200],
            [['customer_phone'], 'string', 'max' => 10],
            [['customer_name','pay_out_remark'], 'string', 'max' => 255],
            [['cancel_reason'], 'string', 'max' => 250],
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
            'customer_id' => 'Customer ID',
            'customer_name' => 'Customer Name',
            'invoice' => 'Invoice',
            'customer_phone' => 'Customer Phone',
            'date_of_delivery' => 'Date Of Delivery',
            'order_date' => 'Order Date',
            'total_price' => 'Total Price',
            'discount' => 'Discount',
            'payable_amount' => 'Payable Amount',
            'payment_type' => 'Payment Type',
            'seller_id' => 'Seller ID',
            'delivery_charge' => 'Delivery Charge',
            'pay_out' => 'Pay Out',
            'pay_out_date' => 'Pay Out Date',
            'pay_out_remark' => 'Pay Out Remark',
            'delivery_status' => 'Delivery Status',
            'cancel_reason' => 'Cancel Reason',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'record_status' => 'Record Status',
        ];
    }
}
