<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $cus_name
 * @property string $address
 * @property string|null $sec_address
 * @property string $landmark
 * @property string|null $sec_landmark
 * @property string $phone
 * @property string|null $sec_phone
 * @property int $created_by
 * @property string $created_date
 * @property string $record_status
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cus_name', 'address', 'landmark', 'phone', 'created_by'], 'required'],
            [['created_by'], 'integer'],
            [['created_date'], 'safe'],
            [['cus_name', 'address', 'sec_address', 'landmark', 'sec_landmark'], 'string', 'max' => 255],
            [['phone', 'sec_phone'], 'string', 'max' => 10],
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
            'cus_name' => 'Cus Name',
            'address' => 'Address',
            'sec_address' => 'Sec Address',
            'landmark' => 'Landmark',
            'sec_landmark' => 'Sec Landmark',
            'phone' => 'Phone',
            'sec_phone' => 'Sec Phone',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'record_status' => 'Record Status',
        ];
    }
}
