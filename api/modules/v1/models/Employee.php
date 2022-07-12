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
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'employee_id', 'phone', 'branch_id', 'department_id', 'designation_id', 'created_by'], 'required'],
            [['employee_id', 'branch_id', 'department_id', 'designation_id', 'created_by'], 'integer'],
            [['created_date'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 10],
            [['record_status'], 'string', 'max' => 1],
            [['employee_id'], 'unique'],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'department_id']],
            [['designation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designation::className(), 'targetAttribute' => ['designation_id' => 'designation_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' =>\common\models\User::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'employee_id' => 'Employee ID',
            'phone' => 'Phone',
            'branch_id' => 'Branch',
            'department_id' => 'Department',
            'designation_id' => 'Designation',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'record_status' => 'Record Status',
            
        ];
    }
}
