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
