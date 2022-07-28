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

class SellerController extends ActiveController
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

   

   public function actionSellerlogin()
	{
		if($postdata = file_get_contents("php://input")) {
			$request = json_decode($postdata);

			$model = Seller::find()->where(['s_phone'=>$request->username])->one();
			$model->s_phone = $request->username;
			$model->password = $request->password;
			//print_r($model->password );die;
//			$student = Students::find()->where(['stud_reg_no'=>$model->stud_reg_no])->one();
			if($model->validatePassword($model->password)) {
				$seller = Seller::find()->where(['s_phone'=>$request->username])->one();
				if ($seller->save()) {
					$user = Seller::find()->asArray()->select('auth_key,id')->where(['s_phone'=>$model->s_phone])->all();

					$data = [
						'status' => 'success',
						'msg' => $user
					];
				}else{
					$data = [
						'status' => 'fail',
						'msg' => 'Not able to generate TOKEN'
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
				$user = Seller::find()->where(['auth_key'=>$token])->one();
				if($user) {
					if($postdata = file_get_contents("php://input")) {
						$request = json_decode($postdata);

						$det=Seller::find()->asArray()->select('s_name, s_phone,s_address,device_id')->where(['s_phone'=>$request->username])->all();

						if ($det) {

							$data = [
								'status' => 'success',
								'msg' => $det
							];
						}else{
							$data = [
								'status' => 'fail',
								'msg' => 'Seller not found'
							];
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
				$chkuser = Students::find()->where(['auth_key'=>$token])->one();
					//echo "<pre>"; print_r($chkuser->firstname);die;
				if($chkuser) {
					if($postdata = file_get_contents("php://input")) {
						// echo "<pre>"; print_r($postdata);die;
						$request = json_decode($postdata);
						//echo "<pre>"; print_r($request->oldpassword);die;
						
						if($chkuser->validatePassword($request->oldpassword)) {
							$chkuser->setPassword($request->newpassword);
							
            				if($chkuser->save()){
            					$data = [
								'status' => 'success',
								'msg' => 'New Password Created'
								];

            				}else{
            					$data = [
								'status' => 'fail',
								'msg' => 'Unable to change password'
								];

            				}

							
						} else {
							$data = [
								'status' => 'fail',
								'msg' => 'Incorrect Old password'
							];
						}
						}else{
							$data = ['status'=>'fail', 'msg'=>$chkuser->errors];
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


	public function actionCheckcustomer() {
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = Seller::find()->where(['auth_key'=>$token])->one();
				if($user) {
					if($postdata = file_get_contents("php://input")) {
						$request = json_decode($postdata);

						$cus = Customer::find()->asArray()->select('cus_name,address,sec_address,landmark,sec_landmark,phone,sec_phone')
								->Where(['or',['phone'=> $request->phone],
								['sec_phone'=>$request->phone]])
								->andWhere(['record_status'=>1])->all();

						if($cus){
							$data = ['status'=>'success', 'msg'=>$cus];
						}else{
							$data = ['status'=>'fail', 'msg'=>'Customer not found'];
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

	public function actionAddcustomer() {
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = Seller::find()->where(['auth_key'=>$token])->one();
				if($user) {
					if($postdata = file_get_contents("php://input")) {
						$request = json_decode($postdata);

						$chk = Customer::find()->asArray()
								->Where(['or',['phone'=> $request->p_phone],
								['sec_phone'=>$request->s_phone]])
								->orWhere(['or',['phone'=> $request->s_phone],
								['sec_phone'=>$request->p_phone]])
								->andWhere(['record_status'=>1])->one();

						if(!$chk){

						$model = new Customer();

						$model->cus_name = $request->customer_name;
						$model->address = $request->p_address;
						$model->sec_address = $request->s_address;
						$model->landmark = $request->p_landmark;
						$model->sec_landmark = $request->s_landmark;
						$model->phone = $request->p_phone;
						$model->sec_phone = $request->s_phone;
						$model->created_by = $user->id;
						

						if($model->save()){
							$data = ['status'=>'success', 'msg'=>'Customer Created'];
						}else{
							$data = ['status'=>'fail', 'msg'=>'Customer not able to save'];
						}
					}else{
						$data = ['status'=>'fail', 'msg'=>'Customer Already present'];
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


	public function actionCustomerdata($id)
	{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = Seller::find()->where(['auth_key'=>$token])->one();
				if($user) {
							
						
							$index = Customer::find()->asArray()->select('id,cus_name,
								address,sec_address,landmark,sec_landmark,phone,sec_phone,record_status')->where(['id'=>$id])->all();

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

	public function actionCustomerupdate()
	{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = Seller::find()->where(['auth_key'=>$token])->one();
				if($user) {
						if($postdata = file_get_contents("php://input")) {
							$request = json_decode($postdata);	
							$dept = Customer::find()->where(['id'=>$request->id])->one();

							if($dept){

								if(isset($request->customer_name)){
									$dept->cus_name = $request->customer_name;
								}else{
									$dept->cus_name = $dept->cus_name;
								}

								if(isset($request->p_address)){
									$dept->address = $request->p_address;
								}else{
									$dept->address = $dept->address;
								}

								if(isset($request->s_address)){
									$dept->sec_address = $request->s_address;
								}else{
									$dept->sec_address = $dept->sec_address;
								}

								if(isset($request->p_landmark)){
									$dept->landmark = $request->p_landmark;
								}else{
									$dept->landmark = $dept->landmark;
								}

								if(isset($request->s_landmark)){
									$dept->sec_landmark = $request->s_landmark;
								}else{
									$dept->sec_landmark = $dept->sec_landmark;
								}

								if(isset($request->p_phone)){
									$dept->phone = $request->p_phone;
								}else{
									$dept->phone = $dept->phone;
								}

								if(isset($request->s_phone)){
									$dept->sec_phone = $request->s_phone;
								}else{
									$dept->sec_phone = $dept->sec_phone;
								}

								//$dept->dept_name = $request->department_name;
								$dept->created_by = $user->id;
								$dept->created_date = date('y/m/d h:i:s');

								if($dept->save()){
									$data = ['status'=>'success', 'msg'=>'Customer updated'];
										}else{
											$data = ['status'=>'fail', 'msg'=>'Fail to update'];
										}
								}else{
									$data = ['status'=>'fail', 'msg'=>'Invalid id'];
								}
								
							}else{
							$data = ['status'=>'fail', 'msg'=>$dept->errors];
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


	public function actionOrdertoday()
	{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = Seller::find()->where(['auth_key'=>$token])->one();
				if($user) {
						
						$today = date('Y-m-d');	
						$orderdet = OrderDetail::find()->asArray()->select('order_detail.id,
								invoice,customer_name,customer_phone,
								order_date,date_of_delivery,payable_amount,
								delivery_charge,delivery_status,cancel_reason,
								 s_name As Seller-Name')
								->leftJoin('seller', 'order_detail.seller_id=seller.id')
								->where(['order_detail.seller_id'=>$user->id])
								->andwhere(['order_detail.date_of_delivery'=>$today])
								->andwhere(['order_detail.record_status'=>'1'])
								->andwhere(['seller.record_status'=>'1'])->all();
						//echo "<pre>";print_r($orderdet);die;
						
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
							$data = ['status'=>'success', 'msg'=>$orderdet, 'msg1'=>$item];
						}else{
							$data = ['status'=>'fail', 'msg'=>'Not able to find data'];
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


	public function actionOrderlist()
	{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = Seller::find()->where(['auth_key'=>$token])->one();
				if($user) {
							
						$orderdet = OrderDetail::find()->asArray()->select('order_detail.id,invoice,
								customer_name,customer_phone,order_date,date_of_delivery,
								payable_amount,delivery_charge,delivery_status,cancel_reason,s_name As Seller-Name')
								->leftJoin('seller', 'order_detail.seller_id=seller.id')
								->where(['order_detail.seller_id'=>$user->id])
								->andwhere(['order_detail.record_status'=>'1'])
								->andwhere(['seller.record_status'=>'1'])->all();
						//echo "<pre>";print_r($orderdet);die;
						
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
							$data = ['status'=>'success', 'msg'=>$orderdet, 'msg1'=>$item];
						}else{
							$data = ['status'=>'fail', 'msg'=>'Not able to find data'];
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


	public function actionPayout()
	{
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = Seller::find()->where(['auth_key'=>$token])->one();
				if($user) {
							
						$orderdet = OrderDetail::find()->asArray()->select('order_detail.id,
								invoice,customer_name,customer_phone,order_date,
								date_of_delivery,payable_amount AS Payout-Amount,
								pay_out,pay_out_date,pay_out_remark')
								->where(['order_detail.seller_id'=>$user->id])
								->andwhere(['order_detail.record_status'=>'1'])
								->all();
						//echo "<pre>";print_r($orderdet);die;
						
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
							 echo "<pre>";print_r($item);die;

							//return json_encode($status);
							$data = ['status'=>'success', 'msg'=>$orderdet, 'msg1'=>$item];
						}else{
							$data = ['status'=>'fail', 'msg'=>'Not able to find data'];
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

	public function actionAssignorder() {
		if($headers = apache_request_headers())
		{
			if(isset($headers['token']) && $token = $headers['token']) {
				$user = Seller::find()->where(['auth_key'=>$token])->one();
				
				if($user) {
					if($postdata = file_get_contents("php://input")) {
						$request = json_decode($postdata,true);
						//echo "<pre>"; print_r($request);die;
						$transaction = Yii::$app->db->beginTransaction();
						try{
								
								//echo "<pre>"; print_r($chk);die;
										  
								$model = new OrderDetail();

								$inv = "#".$this->randomNoGenerator(4);
								$model->invoice = $inv;
								$model->customer_name = $request[0]['customer_name'];
								$model->customer_phone = $request[0]['customer_phone'];
								$model->order_date = $request[0]['order_date'];
								$model->date_of_delivery = $request[0]['delivery_date'];
								$model->total_price = $request[0]['total_price'];

								if(isset($request[0]['discount'])){
											$model->discount = $request[0]['discount'];
										}else{
											$model->discount = $model->discount;
										}

								$model->payable_amount = $request[0]['payable_amount'];
								$model->seller_id = $user->id;
								$model->updated_by = $user->id;

								$cus = Customer::find()->asArray()->select('id')
										 ->where(['phone'=>$request[0]['customer_phone']])
										 ->andWhere(['record_status'=>'1'])->one(); 
								// //die($totalm);		  
								// echo "<pre>"; print_r($totalm['total_marks']);"</pre>";die;

								if ($cus) {
									$model->customer_id = $cus['id'];
								}else{
									$data = ['status'=>'fail', 'msg'=>'No customer found'];
								}
						
								if($model->save(false)){

									$count = count($request);
									for($i=1; $i<$count;$i++){
											$item = new OrderItem();
											//$request[$i]["question_id"]
											//echo $request[$i]["question_id"];
											//$r_detail->stud_id = $model->stud_id;
											$item->order_detail_id = $model->id;
						                	$item->product_name = $request[$i]["product_name"];
						                	$item->product_category = $request[$i]["product_category"];
						                	$item->product_quantity = $request[$i]["product_quantity"];
						                	$item->product_price = $request[$i]["product_price"];
						                	$flag=$item->save(false);
									}

							if ($flag) {
								$transaction->commit();
								$data = ['status'=>'success', 'msg'=>'Submitted Successfully'];
							}else{
								$transaction->rollback();
								$data = ['status'=>'success', 'msg'=>'Fail Submit'];
							}

							
							}else{
								$transaction->rollback();
								$data = ['status'=>'fail', 'msg'=>'Fail to add order Items'];
							}

						} catch (Exception $e) {
				              $transaction->rollBack();
				        }
						
						}else{
							$data = ['status'=>'fail', 'msg'=>'errors in sending data'];
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


	public function randomNoGenerator($digits) {
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
    }	
	 
}
