<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Seller;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Order Details';
// $this->params['breadcrumbs'][] = $this->title;

$seller= ArrayHelper::map(Seller::find()->all(), 'id', 's_name');
$dstatus = ['DELIVERED'=>'DELIVERED','CANCEL PARTIAL'=>'CANCEL PARTIAL'];

// $this->title = 'Order Details';
// $this->params['breadcrumbs'][] = $this->title;
$payout = ['YES'=>'YES','NO'=>'NO'];
?>
<div class="order-detail-index">

    <br><br><br>
    <div class="panel panel-body bod" >
        <div class="panel-heading head rot" style="">
            Showing Pay-Out Details  
        </div>
    <br><br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' =>['class' => 'table'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'customer_id',
            'invoice',
            [
                'attribute' => 'seller_id',
                'value' => function($model) use($seller) {
                    return isset($model->seller_id) ? $seller[$model->seller_id] : '';
                },
                'label' => 'Seller',
                'filter' => Select2::widget([
                                'model' => $searchModel,
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'attribute' => 'seller_id',
                                'options' => ['prompt' => 'Select Seller ...'],
                                'pluginOptions' => ['allowClear' => true],
                                'data' => $seller,
                        ]),
            ],
            //'customer_phone',
            //'order_date',
            [
                'attribute'=>'order_date',
                'value' => function($model)  {
                    return isset($model->order_date) ? date('d-m-Y',strtotime($model->order_date)) : '';
                },
                'filter'=>DatePicker::widget([
                            'model' => $searchModel,
                            'attribute'=>'order_date',
                            'clientOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                                ]
                            ])
            ],
            [
                'attribute'=>'date_of_delivery',
                'value' => function($model)  {
                    return isset($model->date_of_delivery) ? date('d-m-Y',strtotime($model->date_of_delivery)) : '';
                },
                'filter'=>DatePicker::widget([
                            'model' => $searchModel,
                            'attribute'=>'date_of_delivery',
                            'clientOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                                ]
                            ])
            ],

            [
                'attribute'=>'delivery_status',
                'filter'=>$dstatus,
            ],
            
            // 'total_price',
            // 'discount',
            //'payable_amount',
            //'payment_type',
            [
                'attribute'=> 'payable_amount',
                'label'=> 'Pay-Out Amount',
            ],
            //'pay_out',
            [
                'attribute'=>'pay_out',
                
                'contentOptions' => function ($model) {
                            if($model->pay_out == "YES"){
                                return ['style' => 
                                'font-style:oblique;font-weight:bold;
                                text-align:center;font-size:16px;background:#23ba5b;color:white'];
                                }else{
                                return ['style' => 
                                'font-style:oblique;font-weight:bold;
                                text-align:center;font-size:16px;background:#e65d32;color:white'];
                            }

                        },
                'format' => 'raw',
                'filter'=>$payout,

            ],
            'pay_out_date',
            'pay_out_remark',
            //'updated_by',
            //'updated_date',
            //'record_status',

            //['class' => 'yii\grid\ActionColumn'],
            [
              'value' => function ($model) {
                return Html::a('<span class="glyphicon glyphicon-usd"></span>', ['order-detail/payamount', 'id' => $model->id], ['class' => 'btn btn-success popup1 ']);  
                        },
                        'format' => 'raw',
             ],
        ],
    ]); ?>

</div>
</div>
</div>

<link href='https://fonts.googleapis.com/css?family=Oregano' rel='stylesheet'>
<style type="text/css">
    .head{
        padding:17px;
        margin-top: -50px;
        border-radius: 10px;
        background-color: #e647b1;
        color: #f5f8fc;
        font-family: 'Oregano';
        font-size: 20px;
        box-shadow: 1px 1px 4px gray;
    }

    .rot{
      background-color:#188a94;
      padding: 20px;
      margin-top: -65px;
      border-radius: 5px;
      transform: translateZ(0);
      transition: all .3s cubic-bezier(.34,1.61,.7,1);

    }   
    .rot:hover {
              transform: scale(1.04,1.04);
            
    }
    .bod{
        padding: 20px;
        box-shadow: 1px 1px 3px gray;
    }
    
</style>
<?php

Modal::begin([

            'header' => '<h4>Create Order</h4>',

            'id' => 'jobPop',

            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            


        ]);


       

        Modal::end();

Modal::begin([

            'header' => '<h4>Pay-Out Update</h4>',

            'id' => 'jobPop1',

            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            


        ]);


       

        Modal::end();
?>



<?php $this->registerJs("$(function() {

   $('.popup').click(function(e) {
     e.preventDefault();
     $('#jobPop').modal('show').find('.modal-body')
     .load($(this).attr('href'));
   });
    $('.popup1').click(function(e) {
     e.preventDefault();
     $('#jobPop1').modal('show').find('.modal-body')
     .load($(this).attr('href'));
   });
});");
