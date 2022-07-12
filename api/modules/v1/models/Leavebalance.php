<?php

namespace api\modules\v1\models;

use Yii\db\ActiveRecord;
use Yii;
date_default_timezone_set('Asia/Kolkata');

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $name
 * @property int $employee_id
 * @property string $phone
 * @property string $email
 * @property int $branch_id
 * @property int $department_id
 * @property int $designation_id
 * @property int $created_by
 * @property string $created_date
 * @property int|null $updated_by
 * @property string|null $updated_date
 * @property string $record_status
 */
class Leavebalance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_balance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['leave_type_id','employee_id','category_id','balance','received_leave'], 'required'],
            
            [['leave_type_id','employee_id','category_id','balance','received_leave'], 'integer'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => 'EmployeeID',
            'leave_type_id' => 'LeaveTypeID',
            'category_id' => 'CategoryID',
            'balance' => 'Balance',
            //'created_date' => 'Created Date',
            
        ];
    }
}
