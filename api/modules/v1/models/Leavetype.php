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
class Leavetype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leave_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','category_id','no_of_leaves','created_by'], 'required'],
            [['created_date','status'],'safe'],
            [['created_by','no_of_leaves','category_id'], 'integer'],
            [['name'],'string','max'=>20],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' =>\common\models\User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'no_of_leaves' => 'No of Leaves',
            'category_id' => 'CategoryID',
            'created_date' => 'Created Date',
            
        ];
    }
}
