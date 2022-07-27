<?php

namespace frontend\controllers;

use Yii;
use app\models\OrderDetail;
use app\models\OrderDetailSearch;
use app\models\OrderItem;
use app\models\OrderItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Customer;
use app\models\OrderAssign;

/**
 * OrderDetailController implements the CRUD actions for OrderDetail model.
 */
class OrderDetailController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all OrderDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOrderinfo($id)
    {

        $searchModel = new OrderDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['order_detail.id'=>$id]);

        $searchModel1 = new OrderItemSearch();
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
        $dataProvider1->query->andFilterWhere(['order_item.order_detail_id'=>$id]);

        return $this->renderAjax('delinfo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
        ]);
    }

    public function actionIteminfo($id)
    {

        $searchModel1 = new OrderItemSearch();
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
        $dataProvider1->query->andFilterWhere(['order_item.order_detail_id'=>$id]);

        return $this->renderAjax('iteminfo', [
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
        ]);
    }

    public function actionDelivereditem($id)
    {

        $searchModel1 = new OrderItemSearch();
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
        $dataProvider1->query->andFilterWhere(['order_item.order_detail_id'=>$id]);

        return $this->renderAjax('delivereditem', [
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
        ]);
    }

    public function actionCancelitem($id)
    {

        $searchModel1 = new OrderItemSearch();
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
        $dataProvider1->query->andFilterWhere(['order_item.order_detail_id'=>$id]);

        return $this->renderAjax('cancelitem', [
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
        ]);
    }

    public function actionActiveorder()
    {
        $today = date('Y-m-d');
        $searchModel = new OrderDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['order_detail.date_of_delivery'=>$today])
        ->andFilterWhere(['or',['delivery_status'=>'PENDING'],['delivery_status'=>'OUT FOR DELIVERY']])
        ->andFilterWhere(['order_detail.record_status'=>'1']);

        return $this->render('activeorder', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



   

    public function actionDelivery()
    {
        $searchModel = new OrderDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['delivery_status'=>'DELIVERED'])
        ->andFilterWhere(['order_detail.record_status'=>'1']);

        return $this->render('delivery', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionPayout()
    {
        $searchModel = new OrderDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['or',['delivery_status'=>'DELIVERED'],
        ['delivery_status'=>'CANCEL PARTIAL']])
        ->andFilterWhere(['order_detail.record_status'=>'1']);

        return $this->render('indexpay', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeliverydet()
    {
        $searchModel = new OrderDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['delivery_status'=>'PENDING'])
        ->andFilterWhere(['order_detail.record_status'=>'1']);

        return $this->render('deliverydet', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCancel()
    {
        $searchModel = new OrderDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['or',['delivery_status'=>'CANCEL ALL'],
        ['delivery_status'=>'CANCEL PARTIAL']])
        ->andFilterWhere(['order_detail.record_status'=>'1']);

        return $this->render('cancel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionAssign()
    {

        if($selection=(array)Yii::$app->request->post('selection'))
        {
            if(Yii::$app->request->post()) {
                $list= OrderDetail::find()->asArray()->select('id,invoice,
                    customer_name,customer_phone,date_of_delivery,delivery_charge')->where(['id'=>$selection])->all();
                //echo "<pre>";print_r($list);die;
                if($_POST['submit'] == 'riderassign') {
                    return $this->redirect(['order-assign/create','list' => json_encode($list)]);
                }
                else{
                     return $this->redirect(['order-detail/deliverydet']);
                }
                
            }
            
        }
        else
        {

            Yii::$app->session->setFlash('danger', "Your have not selected any row");
            return $this->redirect(['order-detail/deliverydet']);
        }

       
    }

    /**
     * Displays a single OrderDetail model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPhone($ph)
    {
        $reg = Customer::find()->where(['phone'=>$ph])->one();
        //die($count);
        if ($reg) {
        
        $name = $reg->cus_name;
        
        $data = ["name"=>$name];
        return json_encode($data);
    }else{
            return 0;
        }
    }

    /**
     * Creates a new OrderDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderDetail();
        $modelitem = [new OrderItem()];

        if ($model->load(Yii::$app->request->post()) ) {
            $cus = "#".$this->randomNoGenerator(4);
            $model->invoice = $cus;

            $model->updated_by = Yii::$app->user->id;

            $modelitem = Model::createMultiple(OrderItem::classname());
            Model::loadMultiple($modelitem, Yii::$app->request->post());

           
            // // validate all models
            // $valid = $model->validate();
            // $valid = Model::validateMultiple($modelitem) && $valid;
            
            //if ($valid) {
                 //die('4');
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelitem as $sta) {
                            $sta->order_detail_id = $model->id;
                            $sta->updated_by = Yii::$app->user->id;
                            if (! ($flag = $sta->save(false))) {
                                //die('4');
                                $transaction->rollBack();
                                Yii::$app->session->setFlash('danger', 'Failed to Order!');
                                return $this->redirect(['order-detail/index']);
                                //break;
                            }
                        }
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Successully Ordered!');
                        return $this->redirect(['order-detail/index']);
                        //return $this->redirect(['customer-receipt/print','order_detail_id' => $model->id,'target'=>'_blank']);

                    }
                       
                    
                } catch (Exception $e) {
                    //die('1');
                    $transaction->rollBack();
                }
            //}
           //die('0'); 
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'modelitem'=> $modelitem,
        ]);
    }


    public function randomNoGenerator($digits) {
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
    }

    /**
     * Updates an existing OrderDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionDcharge($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $chk = OrderAssign::find()->where(['order_detail_id'=>$id])->andWhere(['record_status'=>'1'])->one();
            if(!$chk){
                Yii::$app->session->setFlash('danger', 'Please Assign Riders first!!');
                return $this->redirect(['activeorder']);
            }
            if(!$model->save()){
                //print_r($model->errors);die;
                Yii::$app->session->setFlash('danger', 'Failed to Add Delivery Charge!');
                return $this->redirect(Yii::$app->request->referrer);
            }else{
                Yii::$app->session->setFlash('success', 'Delivery Charges Successfully Added!');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('dcharge', [
            'model' => $model,
        ]);
    }

    public function actionPayamount($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('payamount', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OrderDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OrderDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
