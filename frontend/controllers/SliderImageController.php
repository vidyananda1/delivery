<?php

namespace frontend\controllers;

use Yii;
use app\models\SliderImage;
use app\models\SliderImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * SliderImageController implements the CRUD actions for SliderImage model.
 */
class SliderImageController extends Controller
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
     * Lists all SliderImage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SliderImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SliderImage model.
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
     * Creates a new SliderImage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SliderImage();

        if ($model->load(Yii::$app->request->post())) {

            $random= rand(100,1000);

            $model->created_by = Yii::$app->user->id;
            if($model->imagefile=UploadedFile::getInstance($model,'imagefile'))
            { 
                $model->imagefile=UploadedFile::getInstance($model,'imagefile');
                $model->imagefile->saveAs('images/'.$random.'.'.$model->imagefile->extension);
                $model->images = $random.'.'.$model->imagefile->extension;
            }
            if(!$model->save(false)){
                //echo "<pre>";print_r($model->errors);die;
                Yii::$app->session->setflash('danger', 'Failed to save Carousel Image!');
                return $this->redirect(Yii::$app->request->referrer);
            } else{
                Yii::$app->session->setflash('success', 'Successfully saved Carousel Image !');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SliderImage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $random= rand(100,1000);

            $model->updated_by = Yii::$app->user->id;
            $model->updated_date = date('Y-m-d H:i:s');
            if($model->imagefile=UploadedFile::getInstance($model,'imagefile'))
            { 
                $model->imagefile=UploadedFile::getInstance($model,'imagefile');
                $model->imagefile->saveAs('images/'.$random.'.'.$model->imagefile->extension);
                $model->images= $random.'.'.$model->imagefile->extension;
            }
            if(!$model->save(false)){
                //echo "<pre>";print_r($model->errors);die;
                Yii::$app->session->setflash('danger', 'Failed to update Carousel Image!');
                return $this->redirect(Yii::$app->request->referrer);
            } else{
                Yii::$app->session->setflash('success', 'Successfully Updated Carousel Image !');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SliderImage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       $data = $this->findModel($id);

        
        unlink('images/' . $data->images);
        $this->findModel($id)->delete();
        Yii::$app->session->setflash('success', 'Successfully Deleted Carousel Image !');
        return $this->redirect(['index']);
    }

    /**
     * Finds the SliderImage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SliderImage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SliderImage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
