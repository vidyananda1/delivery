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
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_detail_id', 'product_name', 'product_category', 'product_quantity', 'product_price', 'updated_by'], 'required'],
            [['order_detail_id', 'product_category', 'product_quantity', 'updated_by'], 'integer'],
            [['product_price'], 'number'],
            [['updated_date'], 'safe'],
            [['product_name'], 'string', 'max' => 255],
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
            'product_name' => 'Product Name',
            'product_category' => 'Product Category',
            'product_quantity' => 'Product Quantity',
            'product_price' => 'Product Price',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'record_status' => 'Record Status',
        ];
    }
}
