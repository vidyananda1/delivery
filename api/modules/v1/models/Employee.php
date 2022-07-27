<?php

namespace api\modules\v1\models;

use Yii\db\ActiveRecord;
use Yii;
date_default_timezone_set('Asia/Kolkata');
use common\models\User;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $cat_name
 * @property string $created_date
 * @property int $created_by
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

    public $name;
    public $username;
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_name', 'address', 'phone', 'user_id', 'created_by','emp_type'], 'required'],
            [['address','emp_type'], 'string'],
            [['user_id', 'created_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['employee_name'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 10],
            [['record_status'], 'string', 'max' => 1],
            [['name','username','password'],'string'],
            [['username'],'unique','targetClass'=>'\common\models\user','message'=>'User name already taken']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_name' => 'Employee Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'user_id' => 'User ID',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            //'updated_by' => 'Updated By',
            'name' => "Role",
            'username'=> 'User Name',
            'password' => 'Password',
            'updated_date' => 'Updated Date',
            'record_status' => 'Record Status',
        ];
    }


public function signup()
    {
       
        $user = new User();
        $rand_id = rand(10,1000);
        if(!User::findOne($rand_id))
            $user->id = $rand_id;
        $user->username = $this->username;
        //$user->status = 10;
        // $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        // $user->generateEmailVerificationToken();
        if($user->save())
            return  $user->id;
        else {
            print_r($user->errors);
            die;
        }
        return 0;

    }
}
