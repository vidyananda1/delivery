<?php

namespace frontend\controllers;

use app\models\Registration;
use app\models\Counter;
use app\models\Expense;
use app\models\FeeCounter;
use app\models\Report;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * TaxController implements the CRUD actions for Tax model.
 */
class ReportController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        // 'actions' => ['index','create','update','view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
     
        $model = new Report();
       
        $startDate = '';
        $endDate = '';
        if($model->load(Yii::$app->request->queryParams)) {
            $startDate = $model->start_date;
            $endDate  = $model->end_date;
            $reg = Registration::find()->select('registration.date,paid_amount as total,name,reg_id,due_amount')->asArray()->where(['between','date(registration.date)',$startDate,$endDate])->groupBy('registration.date,registration.reg_id')->all();

            $regsum = Registration::find()->select('SUM(paid_amount) as total')->asArray()->where(['between','date(date)',$startDate,$endDate])->all();

            // $payments = Counter::find()->leftJoin('registration','registration.id=counter.member_code')->select('registration.investor_name as investor_name, registration.member_code as member_code, date_of_payment, rate_of_interest, invested_amount, paid_amount,rate_of_interest')->asArray()->where(['between','date(date_of_payment)',$startDate,$endDate])->andWhere(['counter.record_status'=>1])->all();

            // $sumPayments = Counter::find()->select('SUM(paid_amount) as total')->asArray()->where(['between','date(date_of_payment)',$startDate,$endDate])->andWhere(['record_status'=>1])->all();
            
            // print_r($payments);die;
            return $this->renderAjax('index', [
                // 'searchModel' => $searchModel,
                // 'dataProvider' => $dataProvider,
                'reg' => $reg,
                //'payments'=>$payments,
                'regsum' => $regsum[0]['total'],
                //'sumPayments' => $sumPayments[0]['total'],
                'model' => $model,
            ]);
        }
        return $this->render('_form',['model'=>$model]);
       
    }

    public function actionAdmission($startDate,$endDate) {
        $model = new Report();
        $reg = Registration::find()->select('registration.date,paid_amount as total,name,reg_id,due_amount')->asArray()->where(['between','date(registration.date)',$startDate,$endDate])->groupBy('registration.date,registration.reg_id')->all();

        $regsum = Registration::find()->select('SUM(paid_amount) as total')->asArray()->where(['between','date(date)',$startDate,$endDate])->all();
        
        $dueSum = Registration::find()->select('SUM(due_amount) as total')->asArray()->where(['between','date(date)',$startDate,$endDate])->all();


        return $this->renderAjax('index', [
            'reg' => $reg,
            'regsum' => $regsum[0]['total'],
            'model' => $model,
            'dueSum'=>$dueSum[0]['total']
        ]);
    }

    public function actionFees($startDate,$endDate) {
        $fees = FeeCounter::find()->leftJoin('registration','registration.reg_id=fee_counter.registration_id')->select('registration.name,fee_counter.date,fee_counter.amount_receive ,fee_counter.registration_id,fee_counter.due_amount')->asArray()->where(['between','date(fee_counter.date)',$startDate,$endDate])->groupBy('fee_counter.date,fee_counter.registration_id')->all();
        // echo "<pre>";print_r($fees);echo "</pre>";die;
        $sumAmountReceived = 0;
        $sumAmountDue = 0;
        foreach($fees as $key=>$value) {
             $sumAmountReceived += $value["amount_receive"];
             $sumAmountDue += $value["due_amount"];
        }

        return $this->renderAjax('fees', [
            'fees' => $fees,
            'sumAmountReceived' => $sumAmountReceived,
            'sumAmountDue'=>$sumAmountDue
        ]);
    }

    public function actionExpenses($startDate,$endDate) {
        $expenses = Expense::find()->select('ex_name,date,amount')->asArray()->where(['between','date(date)',$startDate,$endDate])->groupBy('date')->all();
        // echo "<pre>";print_r($expenses);echo "</pre>";die;
        $sumAmount = 0;
        
        foreach($expenses as $key=>$value) {
             $sumAmount += $value["amount"];
             
        }

        return $this->renderAjax('expenses', [
            'expenses' => $expenses,
            'sumAmount' => $sumAmount,
        ]);
    }
    

}
