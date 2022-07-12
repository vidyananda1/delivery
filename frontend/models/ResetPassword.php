<?php
namespace frontend\models;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidParamException;
use yii\base\Model;
use common\models\User;

/**
 * Password reset form
 */
class ResetPassword extends Model
{
    public $newpassword;

    public function rules()
    {
        return [
            ['newpassword', 'required'],
            ['newpassword', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
          'newpassword' => 'New Password',
          ];
    }

    public function resetPassword($id)
    {
        $user = User::find()->where(['employee_id' => $id])->one();
        $user->setPassword($this->newpassword);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
