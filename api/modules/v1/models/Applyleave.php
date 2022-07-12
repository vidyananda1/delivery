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
class Applyleave extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apply_leave';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emp_id', 'category_id', 'start_date', 'end_date', 'no_of_days','reason','applied_date', 'created_by'], 'required'],
            [['approval_status_id','shift','approval_status_id','type'],'safe'],
            [['emp_id','category_id', 'no_of_days','created_by','approval_status_id'], 'integer'],
            [['shift','type'],'string','max'=>20],
            [['reason'],'string','max'=>200],
            [['created_date'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' =>\common\models\User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'emp_id' => 'Emp ID',
            'category_id' => 'CategoryID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'no_of_days' => 'No Of Days',
            'type' => 'Type',
            'shift' => 'Shift',
            'reason' => 'Reason',
            'applied_date' => 'Applied Date',
            'approval_status_id' => 'Approval Status ID',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            
        ];
    }
}
