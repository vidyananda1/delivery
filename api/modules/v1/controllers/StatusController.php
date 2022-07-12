<?php

namespace api\modules\v1\controllers;

use yii\filters\Cors;
use yii\rest\ActiveController;
use api\modules\v1\models\Appversion;
use api\modules\v1\models\Applyleave;
use common\models\User;
use api\modules\v1\models\Status;
use api\modules\v1\models\Employee;
use api\modules\v1\models\Leavebalance;
use api\modules\v1\models\Approvalstatus;


class StatusController extends ActiveController
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


   

	public function actionStatus()
		{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
					if($postdata = file_get_contents("php://input")) {
						$request = json_decode($postdata);
						$emp_id = $request->emp_id;
							
						$status = Status::find()->asArray()->select('approval_status.app_status,apply_leave.start_date,apply_leave.end_date,apply_status.apply_id')
						->leftJoin('apply_leave', 'apply_status.apply_id=apply_leave.id')
						->leftJoin('approval_status', 'apply_status.approval_status_id=approval_status.id')
						->where(['apply_leave.emp_id'=>$emp_id])->all();


						//return json_encode($status);
						$data = ['status'=>'success', 'msg'=>$status];
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

	public function actionStatusdetail()
		{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
					if($postdata = file_get_contents("php://input")) {
						$request = json_decode($postdata);
						$apply_id = $request->apply_id;
							
						$status = Applyleave::find()->asArray()->select('approval_status.app_status,apply_leave.type,apply_leave.emp_id,apply_leave.shift,apply_leave.reason,
						employee.name,apply_leave.start_date,apply_status.apply_id,apply_leave.end_date,apply_leave.no_of_days')
						->leftJoin('apply_status', 'apply_leave.id=apply_id')
						->leftJoin('approval_status', 'apply_status.approval_status_id=approval_status.id')
						->leftJoin('employee',
						'employee_id=apply_leave.emp_id')
						->where(['employee.record_status'=>1])
						->andWhere(['apply_leave.id'=>$apply_id])->all();

						//return json_encode($status);
						$data = ['status'=>'success', 'msg'=>$status];
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

	public function actionStatusadmin()
		{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
							
						$status = Applyleave::find()->asArray()->select('approval_status.app_status,apply_leave.emp_id,apply_leave.start_date')
						->leftJoin('apply_status', 'apply_leave.id=apply_id')
						->leftJoin('approval_status', 'apply_status.approval_status_id=approval_status.id')
						->leftJoin('employee',
						'employee_id=apply_leave.emp_id')
						->where(['employee.record_status'=>1])
						->all();

						//return json_encode($status);
						$data = ['status'=>'success', 'msg'=>$status];
					
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


	public function actionStatusdetailadmin()
		{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
					if($postdata = file_get_contents("php://input")) {
						$request = json_decode($postdata);
						$apply_id = $request->apply_id;
							
						$status = Applyleave::find()->asArray()->select('approval_status.app_status,apply_leave.type,apply_leave.emp_id,apply_leave.shift,apply_leave.reason,
						employee.name,apply_leave.start_date,apply_status.apply_id,apply_leave.end_date,apply_leave.no_of_days')
						->leftJoin('apply_status', 'apply_leave.id=apply_id')
						->leftJoin('approval_status', 'apply_status.approval_status_id=approval_status.id')
						->leftJoin('employee',
						'employee_id=apply_leave.emp_id')
						->where(['employee.record_status'=>1])
						->andWhere(['apply_leave.id'=>$apply_id])->all();

						//return json_encode($status);
						$data = ['status'=>'success', 'msg'=>$status];
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


	


	public function actionDashboard()
		{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
							$leavebal= Leavebalance::find()->asArray()->select('leave_name.name,leave_balance.balance')->leftJoin('leave_name','leave_balance.leave_name_id=leave_name.id')->where(['employee_id'=>$user->emp_id])->all();

							$reject = Status::find()->asArray()->leftJoin(
								 		'apply_leave','apply_status.apply_id=apply_leave.id
								 		')->leftJoin('approval_status','apply_status.approval_status_id=approval_status.id')->where(['apply_leave.emp_id'=>$user->emp_id])->andWhere(['approval_status.app_status'=>'Reject'])->count();
							$pending = Status::find()->asArray()->leftJoin(
								 		'apply_leave','apply_status.apply_id=apply_leave.id
								 		')->leftJoin('approval_status','apply_status.approval_status_id=approval_status.id')->where(['apply_leave.emp_id'=>$user->emp_id])->andWhere(['approval_status.app_status'=>'Pending'])->count();
							$approve = Status::find()->asArray()->leftJoin(
								 		'apply_leave','apply_status.apply_id=apply_leave.id
								 		')->leftJoin('approval_status','apply_status.approval_status_id=approval_status.id')->where(['apply_leave.emp_id'=>$user->emp_id])->andWhere(['OR', ['app_status' => 'Approved'],['app_status' => 'Approved Without Pay']])->count();

						//return json_encode($reject);
						$data = ['status'=>'success', 'pending'=>$pending,'approve'=>$approve,'reject'=>$reject,'leavebal'=>$leavebal];
					
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

	public function actionDashboardadmin()
		{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user->username=="admin") {
							

							//$leavebal= Leavebalance::find()->asArray()->select('leave_balance.employee_id,leave_name.name,leave_balance.balance')->leftJoin('leave_name','leave_balance.leave_name_id=leave_name.id')->all();
							$employee = Employee::find()->asArray()->where(['record_status'=>1])->count();

							$reject = Status::find()->asArray()->leftJoin(
								 		'apply_leave','apply_status.apply_id=apply_leave.id
								 		')->leftJoin('approval_status','apply_status.approval_status_id=approval_status.id')->Where(['approval_status.app_status'=>'Reject'])->count();

							$pending = Status::find()->asArray()->leftJoin(
								 		'apply_leave','apply_status.apply_id=apply_leave.id
								 		')->leftJoin('approval_status','apply_status.approval_status_id=approval_status.id')->Where(['approval_status.app_status'=>'Pending'])->count();

							$approve = Status::find()->asArray()->leftJoin(
								 		'apply_leave','apply_status.apply_id=apply_leave.id
								 		')->leftJoin('approval_status','apply_status.approval_status_id=approval_status.id')->Where(['OR', ['app_status' => 'Approved'],['app_status' => 'Approved Without Pay']])->count();

						//return json_encode($reject);
						$data = ['status'=>'success', 'pending'=>$pending,'approve'=>$approve,'reject'=>$reject,'employee'=>$employee,];
					
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
