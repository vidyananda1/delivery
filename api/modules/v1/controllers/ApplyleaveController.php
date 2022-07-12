<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\Cors;
use yii\rest\ActiveController;
use api\modules\v1\models\Appversion;
use common\models\User;
use common\models\LoginForm;
use api\modules\v1\models\Applyleave;
use api\modules\v1\models\Status;
use api\modules\v1\models\Events;
use api\modules\v1\models\Category;
use api\modules\v1\models\Leavetype;
use api\modules\v1\models\LeaveName;
use api\modules\v1\models\Leavebalance;
use api\modules\v1\models\Approvalstatus;

class ApplyleaveController extends ActiveController
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

   

	public function actionApply() {
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				
				if($user) {
					if($postdata = file_get_contents("php://input")) {
						// echo "<pre>"; print_r($postdata);die;
						$request = json_decode($postdata);
						$model = new Applyleave();
						$model->start_date = $request->start_date;
						$model->end_date = $request->end_date;
						$total= $this->calc_no_of_days($model->start_date, $model->end_date);
						$model->no_of_days = $total;
						$model->reason = $request->reason;
						$model->emp_id = $user->emp_id;
						$model->applied_date = $request->applied_date;
						//$cat = Category::find()->where(['name'=>$request->category_id])->one();
						$model->category_id = $request->category_id;
						//$leave_type = Leavetype::find()->asArray()->where(['name'=>$request->leave_type_id])->one();
						$model->leave_type_id = $request->leave_name_id;

						$model->created_by = $user->id;
						$model->type = $request->type;
						$app_status=Approvalstatus::find()->where(['app_status'=>"PENDING"])->one();
						$model->approval_status_id = $app_status->id;

						if($model->type == 'fullday'){
							$model->shift = null;
						}elseif($model->type=='halfday' && isset($request->shift)){
							$model->shift = $request->shift;
						} else {
							return ['status'=>'fail', 'msg'=>'Failed. Invalid Day type/Shift'];
						}
				
						if($model->save()){
							Yii::$app->db->createCommand()->insert('apply_status',['apply_id' => 
							   	$model->id,'approval_status_id' =>$model->approval_status_id,'created_by'=>$user->id ])->execute();
								
							$data = ['status'=>'success', 'msg'=>'Leave applied'];
							}
						}else{
							$data = ['status'=>'fail', 'msg'=>$model->errors];
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

	public function actionLeavename()
	{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
							
						$leavetype = LeaveName::find()->asArray()->select('id,name')->all();

						//return json_encode($status);
						$data = ['status'=>'success', 'msg'=>$leavetype];
					
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

	public function actionCategory()
	{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
							
						$category = Category::find()->asArray()->select('id,cat_name')->all();

						//return json_encode($status);
						$data = ['status'=>'success', 'msg'=>$category];
					
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



	public function actionBalance()
	{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
							
						$balance = Leavebalance::find()->asArray()->select('leave_name.name,balance,category.cat_name')
						->leftJoin('leave_type', 'leave_balance.leave_type_id=leave_type.id')
						->leftJoin('leave_name', 'leave_type.leave_name_id=leave_name.id')
						->leftJoin('category', 'leave_balance.category_id=category.id')
						->where(['leave_balance.employee_id'=>$user->emp_id])
						->andwhere(['record_status'=>"1"])->all();

						//return json_encode($status);
						$data = ['status'=>'success', 'msg'=>$balance];
					
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

	public function actionCountday()
	{
		if($postdata = file_get_contents("php://input")) {
			$request = json_decode($postdata);
			$start_date =$request->start_date;
			$end_date =$request->end_date;
			//$leave_type_id =$request->leave_type_id;

			//$cat = Category::find()->asArray()->where(['id'=>$category_id])->one();
			$total = $this->calc_no_of_days($start_date, $end_date);
			
			$data = ['status'=>'success', 'msg'=>$total];
		} else {
			$data = ['status'=>'fail', 'msg'=>'Invalid body'];
		}
			return json_encode($data);
		}

		public function calc_no_of_days($start_date, $end_date) {
			$event = Events::find()->where(['between', 'date', $start_date, $end_date])->count();
			$start= strtotime($start_date);
			$end= strtotime($end_date);
			$diff= abs($end-$start);

			$numberDays = ($diff/86400)+1;  // 86400 seconds in one day
			//$numberDays = intval($numberDays)+1;

			//$event = intval($event);
			$total= $numberDays-$event;
			return $total;
		}

		public function actionApprovalstatus()
		{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
					if($postdata = file_get_contents("php://input")) {
						$request = json_decode($postdata);
						$approval_id = $request->approval_id;
						$apply_id = $request->apply_id;
						//$leave_type = $request->leave_type_id;
						//$no_of_days = $request->no_of_days;

						//print_r($approval_id);die;
							
						$status = Applyleave::find()->where(['id'=>$apply_id])->one();
						$applystatus = Status::find()->where(['apply_id'=>$apply_id])->one();
						 //print_r($status);die;

						$applystatus->approval_status_id = $approval_id;
						//$applystatus->approval_status_id = $approval_id;

							

					if($applystatus->save()){

						$approve = Approvalstatus::find()->where(['id'=>$status->approval_status_id])->one();

						if($approve->app_status == "APPROVED" || $approve->app_status == "APPROVED WITHOUT PAY"){
							$leavebal = Leavebalance::find()->where(['employee_id'=>$status->emp_id])->andWhere(['leave_type_id'=>$status->leave_type_id])->one();
							//print_r($leavebal);die;
							$no_of_days = $status->no_of_days;
							$leavebal->balance-= $no_of_days;
							$leavebal->save();
						}

						//return json_encode($status);
						$data = ['status'=>'success', 'msg'=>'Approved/Rejected'];
							}
						}else{
							$data = ['status'=>'fail', 'msg'=>$model->errors];
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
