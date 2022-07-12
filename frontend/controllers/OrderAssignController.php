<?php

namespace frontend\controllers;

use Yii;
use app\models\OrderAssign;
use app\models\OrderAssignSearch;
use app\models\OrderDetail;
use app\models\OrderDetailSearch;
use app\models\OrderItem;
use app\models\OrderItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Model;

/**
 * OrderAssignController implements the CRUD actions for OrderAssign model.
 */
class OrderAssignController extends Controller
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
     * Lists all OrderAssign models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderAssignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionInfo($id)
    {
        $searchModel = new OrderDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['order_detail.id'=>$id]);

        $searchModel1 = new OrderItemSearch();
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
        $dataProvider1->query->andFilterWhere(['order_item.order_detail_id'=>$id]);

        return $this->renderAjax('info', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel1' => $searchModel1,
            'dataProvider1' => $dataProvider1,
        ]);
    }

    /**
     * Displays a single OrderAssign model.
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

    /**
     * Creates a new OrderAssign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new OrderAssign();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionCreate($list)
    {
        $model = new OrderAssign();
        $modelsrider = new OrderAssign();
       
        $li = json_decode($list);

        //echo "<prev>";print_r($li);die;
        if ($model->load(Yii::$app->request->post())) {
            $modelsrider = Model::createMultiple(OrderAssign::classname());
            Model::loadMultiple($modelsrider, Yii::$app->request->post());

            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($modelsrider as  $sta) {
                    //echo "<prev>";print_r($sta);die;
                    if(!empty($sta->order_detail_id) && !empty($sta->date_of_delivery)) {
                        $sta->employee_id = $model->employee_id;
                        //$sta->date_of_delivery = ;
                        if (!($flag = $sta->save(false)) ) {
                            $transaction->rollBack();
                            Yii::$app->session->setflash('danger', 'Failed to save!');
                            return $this->redirect(['order-detail/deliverydet']);
                        }
                    }
                }
                $transaction->commit();
                Yii::$app->session->setflash('success', 'Successfully created!');
                return $this->redirect(['order-assign/index']);
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setflash('danger', 'Failed to save!');
                return $this->redirect(['order-detail/deliverydet']);
            }
        } else {
            return $this->render('_form', [
                'model' => $model,
                'modelsrider' => $modelsrider,
                'li' => $li
            ]);
        }
    }

    /**
     * Updates an existing OrderAssign model.
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

    /**
     * Deletes an existing OrderAssign model.
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
     * Finds the OrderAssign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrderAssign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderAssign::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
