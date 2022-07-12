<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "expense".
 *
 * @property int $id
 * @property string $item_name
 * @property string $date
 * @property int $quantity
 * @property float $price
 * @property int $created_by
 * @property string $created_date
 * @property int|null $updated_by
 * @property string|null $updated_date
 * @property string $record_status
 */
class Expense extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expense';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'date', 'quantity', 'price', 'created_by'], 'required'],
            [['date', 'created_date', 'updated_date'], 'safe'],
            [['quantity', 'created_by', 'updated_by'], 'integer'],
            [['price'], 'number'],
            [['item_name'], 'string', 'max' => 255],
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
            'item_name' => 'Item Name',
            'date' => 'Date',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'record_status' => 'Record Status',
        ];
    }
}
