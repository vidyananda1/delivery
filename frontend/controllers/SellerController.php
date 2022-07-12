<?php

namespace frontend\controllers;

use Yii;
use app\models\Seller;
use app\models\SellerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SellerController implements the CRUD actions for Seller model.
 */
class SellerController extends Controller
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
     * Lists all Seller models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SellerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Seller model.
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
     * Creates a new Seller model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Seller();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->s_name = strtoupper($model->s_name);
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->setPassword("any@2022");
            $model->created_by = Yii::$app->user->id;
            if(!$model->save()){
                //print_r($model->errors);die;
                Yii::$app->session->setFlash('danger', 'Failed to create Category!');
                return $this->redirect(Yii::$app->request->referrer);
            }else{
                Yii::$app->session->setFlash('success', 'Category Successfully created!');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Seller model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->s_name = strtoupper($model->s_name);
            $model->updated_by = Yii::$app->user->id;
            $model->updated_date = date('Y-m-d h:i:s');
            if(!$model->save()){
                //print_r($model->errors);die;
                Yii::$app->session->setFlash('danger', 'Failed to create Category!');
                return $this->redirect(Yii::$app->request->referrer);
            }else{
                Yii::$app->session->setFlash('success', 'Category Successfully created!');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Seller model.
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
     * Finds the Seller model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Seller the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Seller::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
