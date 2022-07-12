<?php
    namespace frontend\models;

    use Yii;
    use common\models\User;
    use yii\base\Model;
    use yii\base\InvalidArgumentException;

    class Forgetpassword extends Model
    {
       public $email;
       public $_user;


       
      public function rules()
       {
        return [
         ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
       
        ];
      }

      public function attributeLabels()
      {
    return [
        //'user_profile_id' => 'User Profile ID',
        //'user_ref_id' => 'User Ref ID',
        'email' => 'Email',
          ];
       }

public function verifyEmail()
    {
         
          $user = User::findOne(['status' => User::STATUS_ACTIVE,'email' => $this->email,]);


        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

         return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
    
      }
    }


     

      
