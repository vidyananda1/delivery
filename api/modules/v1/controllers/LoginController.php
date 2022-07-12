<?php

namespace api\modules\v1\controllers;

use yii\filters\Cors;
use yii\rest\ActiveController;
use api\modules\v1\models\Appversion;
use common\models\User;
use common\models\LoginForm;

class LoginController extends ActiveController
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['*', 'http://localhost'],
                    'Access-Control-Request-Method' => ['POST', 'PUT'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['X-Wsse','X-CSRF-Token','X-CSRF','*'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],
            ],
        ];
    }

    public $modelClass = 'api\modules\v1\models\Appversion';


    public function actionLogin()
    {
    	if($postdata = file_get_contents("php://input")) {
    		$request = json_decode($postdata);

    		$model = new LoginForm();
    		$model->username = $request->username;
    		$model->password = $request->password;
    		if($model->validate()) {
    			$user = User::find()->asArray()->select('auth_key')->where(['username'=>$model->username])->one();

    			$data = [
    				'status' => 'success',
    				'msg' => $user['auth_key']
    			];
    		} else {
    			$data = [
    				'status' => 'fail',
    				'msg' => 'Incorrect username/password'
    			];
    		}
    	} else {
    		$data = [
				'status' => 'fail',
				'msg' => ' Invalid body'
			];
    	}

    	return json_encode($data);
	}

	public function actionGetusers() {
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
					if($postdata = file_get_contents("php://input")) {
						$request = json_decode($postdata);

						return json_encode(User::find()->asArray()->select('username, email')->where(['username'=>$request->username])->all());
					} else {
						$data = ['status'=>'fail', 'msg'=>'Missing body'];
					}
				} else {
					$data = ['status'=>'fail', 'msg'=>'Invalid token'];
				}
			} else {
				$data = ['status'=>'fail', 'msg'=>'Missing token'];
			}
		} else {
			$data = ['status'=>'fail', 'msg'=>'Invalid header'];
		}
		return json_encode($data);
	}    

    public function actionVersion()
    {
		if($headers = apache_request_headers())
		{
			if($token = $headers['token'])
			{
				if($postdata = file_get_contents("php://input"))
				{
					$request = json_decode($postdata);
					$app = Appversion::find()->where(['sl'=>$request->id])->one();
					return '{"reply":"'.$app->version.'"}';
				}
				else
				{
					return "invalid Token";
				}
			}
			else
			{
				return "invalid header";
			}
		}
		else
		{
		return '{"reply":"Invalid Header"}';
		}
    }
}
