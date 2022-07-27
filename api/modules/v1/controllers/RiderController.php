<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\Cors;
use yii\rest\ActiveController;
use api\modules\v1\models\Appversion;
use common\models\User;
use common\models\LoginForm;
use api\modules\v1\models\Seller;
use api\modules\v1\models\Customer;
use api\modules\v1\models\Events;
use api\modules\v1\models\Category;
use api\modules\v1\models\OrderDetail;
use api\modules\v1\models\OrderItem;
use api\modules\v1\models\SliderImage;
use api\modules\v1\models\Employee;
use api\modules\v1\models\OrderAssign;

class RiderController extends ActiveController
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


    public function actionRiderlogin()
	{
    	if($postdata = file_get_contents("php://input")) {
    		$request = json_decode($postdata);

    		$model = new LoginForm();
    		$model->username = $request->username;
    		$model->password = $request->password;
    		if($model->validate()) {

    			$user = User::find()->asArray()->select('auth_key,user_role,id')->where(['username'=>$model->username])->andWhere(['status'=>10])->one();
    			//echo "<pre>"; print_r($user);die;
    			if ($user) {

    				$data = [
    				'status' => 'success',
    				'msg' => $user
    			];
    			}else{

    				$data = [
    				'status' => 'fail',
    				'msg' => 'User Not found'
    			];
    			}

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

						$details = User::find()->asArray()->select('employee.employee_name,
								   user.username,employee.address,employee.phone,
								   employee.emp_type,user.user_role,user.email')
								   ->leftJoin('employee', 'user.id=employee.user_id')
								   ->where(['user.id'=>$request->id])->all();

						if($details){
							$data = ['status'=>'success', 'msg'=>$details];

						}else{
							$data = ['status'=>'fail', 'msg'=>'Data not found for the given ID'];
						}
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


	public function actionChangepassword() {
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$chkuser = User::find()->where(['auth_key'=>$token])->one();
					//echo "<pre>"; print_r($chkuser->firstname);die;
				if($chkuser) {
					if($postdata = file_get_contents("php://input")) {
						$request = json_decode($postdata);
						

						// if($chkuser) {

						if($chkuser->validatePassword($request->oldpassword)) {
							
							$chkuser->setPassword($request->newpassword);
							//$chkuser->generateAuthKey();
							
	            				if($chkuser->save()){
	            					$data = [
									'status' => 'success',
									'msg' => 'New Password Created'
									];

	            				}else{
	            					$data = [
									'status' => 'fail',
									'msg' => 'Unable to create New Password'
									];

	            				}
							
						} else {
							$data = [
								'status' => 'fail',
								'msg' => 'Incorrect Old password'
							];
						}
						}else{
							$data = ['status'=>'fail', 'msg'=>'Invalid Body'];
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

	public function actionCarouselimage()
	{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = Seller::find()->where(['auth_key'=>$token])->one();
				if($user) {
							
						
							$index = SliderImage::find()->asArray()
							->select('id,images,image_title')
							->where(['record_status'=>'1'])->all();

							if($index){
									$data = ['status'=>'success', 'msg'=>$index];
								}else{
									$data = ['status'=>'fail', 'msg'=>'Invalid Data record'];
								}
								
						// 	}else{
						// 	$data = ['status'=>'fail', 'msg'=>$model->errors];
						// }
					
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

	public function actionDeliverytoday()
	{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
						
						$emp = Employee::find()->where(['user_id'=>$user->id])->one();
						if($emp){
						$today = date('Y-m-d');	
						$orderdet = OrderAssign::find()->asArray()->select('order_detail.id,
								invoice,order_detail.customer_name,order_detail.customer_phone,
								order_detail.order_date,order_detail.date_of_delivery,
								order_detail.payable_amount,order_detail.delivery_charge,
								seller.s_name As Seller-Name')
								->leftJoin('order_detail', 'order_assign.order_detail_id
									=order_detail.id')
								->leftJoin('seller', 'order_detail.seller_id=seller.id')
								->where(['order_assign.employee_id'=>$emp->id])
								->andwhere(['order_assign.date_of_delivery'=>$today])
								->andwhere(['order_detail.date_of_delivery'=>$today])
								->andFilterWhere(['or',['order_detail.delivery_status'=>'PENDING'],['order_detail.delivery_status'=>'OUT FOR DELIVERY']])
								->andwhere(['order_detail.record_status'=>'1'])
								->andwhere(['order_assign.record_status'=>'1'])->all();
						//echo "<pre>";print_r($orderdet);die;
						if($orderdet){
							foreach ($orderdet as $key => $value) {
							 //echo "<pre>";print_r($value);die;
							$item[]= '';
							$orderitem = OrderItem::find()->asArray()->select('order_item.id,order_detail_id,product_name,
								cat_name as Product-Category,product_quantity,product_price')
								->leftJoin('category', 'order_item.product_category
									=category.id')
								->where(['order_item.order_detail_id'=>$value['id']])
								->andwhere(['order_item.record_status'=>'1'])
								->all();
							foreach ($orderitem as $key1 => $value1) {
								//echo "<pre>";print_r($value1);die;
								$ord = OrderItem::find()->asArray()->select('product_name,
								cat_name as Product-Category,product_quantity,product_price')
								->leftJoin('category', 'order_item.product_category
									=category.id')
								->where(['order_item.id'=>$value1['id']])
								->andwhere(['order_item.record_status'=>'1'])
								->one();
								//echo "<pre>";print_r($value1);die;
								$item[] = $ord;
							}
							

						}
						
						if($orderdet && $item ){
							// echo "<pre>";print_r($item);die;

							//return json_encode($status);
							$data = ['status'=>'success', 'order-detail'=>$orderdet, 'order-items'=>$item];
						}else{
							$data = ['status'=>'fail', 'msg'=>'Not able to find data'];
						}
						}else{
							$data = ['status'=>'fail', 'msg'=>'fail to find orderID in order_detail'];
							return json_encode($data);
						}
						}else{

							$data = ['status'=>'fail', 'msg'=>'fail to find rider'];
							return json_encode($data);
							
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


	public function actionAlldelivery()
	{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = User::find()->where(['auth_key'=>$token])->one();
				if($user) {
						
						$emp = Employee::find()->where(['user_id'=>$user->id])->one();
						if($emp){
						
						$orderdet = OrderAssign::find()->asArray()->select('order_detail.id,
								invoice,order_detail.customer_name,order_detail.customer_phone,
								order_detail.order_date,order_detail.date_of_delivery,
								order_detail.payable_amount,order_detail.delivery_charge,
								seller.s_name As Seller-Name')
								->leftJoin('order_detail', 'order_assign.order_detail_id
									=order_detail.id')
								->leftJoin('seller', 'order_detail.seller_id=seller.id')
								->where(['order_assign.employee_id'=>$emp->id]) 
								->andwhere(['order_detail.record_status'=>'1'])
								->andwhere(['order_assign.record_status'=>'1'])->all();
						//echo "<pre>";print_r($orderdet);die;
						if($orderdet){
							foreach ($orderdet as $key => $value) {
							 //echo "<pre>";print_r($value);die;
							$item[]= '';
							$orderitem = OrderItem::find()->asArray()->select('order_item.id,order_detail_id,product_name,
								cat_name as Product-Category,product_quantity,product_price')
								->leftJoin('category', 'order_item.product_category
									=category.id')
								->where(['order_item.order_detail_id'=>$value['id']])
								->andwhere(['order_item.record_status'=>'1'])
								->all();
							foreach ($orderitem as $key1 => $value1) {
								//echo "<pre>";print_r($value1);die;
								$ord = OrderItem::find()->asArray()->select('product_name,
								cat_name as Product-Category,product_quantity,product_price')
								->leftJoin('category', 'order_item.product_category
									=category.id')
								->where(['order_item.id'=>$value1['id']])
								->andwhere(['order_item.record_status'=>'1'])
								->one();
								//echo "<pre>";print_r($value1);die;
								$item[] = $ord;
							}
							

						}
						
						if($orderdet && $item ){
							// echo "<pre>";print_r($item);die;

							//return json_encode($status);
							$data = ['status'=>'success', 'order-detail'=>$orderdet, 'order-items'=>$item];
						}else{
							$data = ['status'=>'fail', 'msg'=>'Not able to find data'];
						}
						}else{
							$data = ['status'=>'fail', 'msg'=>'fail to find orderID in order_detail'];
							return json_encode($data);
						}
						}else{

							$data = ['status'=>'fail', 'msg'=>'fail to find rider'];
							return json_encode($data);
							
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

	public function actionUpdatedelivery() {
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$chkuser = User::find()->where(['auth_key'=>$token])->one();
					//echo "<pre>"; print_r($chkuser->firstname);die;
				$emp = Employee::find()->where(['user_id'=>$user->id])->one();
				if($emp) {

					if($postdata = file_get_contents("php://input")) {
						$request = json_decode($postdata);
						
						$ord = OrderDetail::find()->where(['id'=>$request->order_id])->one();

						if(!$ord){
							$data = ['status'=>'fail', 'msg'=>'OrderID not found'];
							return json_encode($data);
						}

						if($request->order_id){
							$ord->delivery_status = $request->delivery_status;
						}else{
							$ord->delivery_status = $ord->delivery_status;
						}

						if($request->cancel_reason){
							$ord->cancel_reason = $request->cancel_reason;
						}else{
							$ord->cancel_reason = $ord->cancel_reason;
						}

						if($ord->save()){
							$data = ['status'=>'success', 'msg'=>'Delivery Status Updated'];
						}else{
							$data = ['status'=>'fail', 'msg'=>'Unable to update delivery status'];
						}

			
						}else{
							$data = ['status'=>'fail', 'msg'=>'Invalid Body'];
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

	



  //   public function actionVersion()
  //   {
		// if($headers = apache_request_headers())
		// {
		// 	if($token = $headers['token'])
		// 	{
		// 		if($postdata = file_get_contents("php://input"))
		// 		{
		// 			$request = json_decode($postdata);
		// 			$app = Appversion::find()->where(['sl'=>$request->id])->one();
		// 			return '{"reply":"'.$app->version.'"}';
		// 		}
		// 		else
		// 		{
		// 			return "invalid Token";
		// 		}
		// 	}
		// 	else
		// 	{
		// 		return "invalid header";
		// 	}
		// }
		// else
		// {
		// return '{"reply":"Invalid Header"}';
		// }
  //   }
}
