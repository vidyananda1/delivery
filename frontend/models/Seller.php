<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seller".
 *
 * @property int $id
 * @property string $s_name
 * @property string $s_phone
 * @property string $s_address
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $s_remark
 * @property int $created_by
 * @property string $created_date
 * @property int|null $updated_by
 * @property string|null $updated_date
 * @property string $record_status
 */
class Seller extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seller';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['s_name', 's_phone', 's_address', 'auth_key', 'password_hash', 'created_by'], 'required'],
            [['s_address'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['s_name', 'auth_key', 'password_hash', 's_remark'], 'string', 'max' => 255],
            [['s_phone'], 'string', 'max' => 10],
            [['device_id'], 'string', 'max' => 250],
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
            'device_id' => 'Device Id',
            's_name' => 'S Name',
            's_phone' => 'S Phone',
            's_address' => 'S Address',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            's_remark' => 'S Remark',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
            'record_status' => 'Record Status',
        ];
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
