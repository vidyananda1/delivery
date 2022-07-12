<?php

namespace api\modules\v1\models;

use Yii\db\ActiveRecord;
use Yii;
date_default_timezone_set('Asia/Kolkata');

/**
 * This is the model class for table "leave_name".
 *
 * @property int $id
 * @property string $name
 * @property int $created_by
 * @property string $created_date
 * @property string $status
 */
class LeaveName extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_name';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_by', 'status',], 'required'],
            [['created_by'], 'integer'],
            [['created_date'], 'safe'],
            [['status',], 'string'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'status' => 'Status',
        ];
    }
}
