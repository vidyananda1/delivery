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
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type','no_of_months','name','created_by'], 'required'],
            [['created_date','status'],'safe'],
            [['created_by','no_of_months'], 'integer'],
            [['name'],'string','max'=>20],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'no_of_days' => 'No of Days',
            'created_date' => 'Created Date',
            
        ];
    }
}
