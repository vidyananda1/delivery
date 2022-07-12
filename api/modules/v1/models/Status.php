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
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apply_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apply_id'], 'required'],
            [['approval_status_id'],'safe'],
            [['apply_id','created_by','approval_status_id'], 'integer'],
           
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
            'apply_id' => 'Apply ID',
            'approval_status_id' => 'ApprovalStatusID',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            
        ];
    }
}
