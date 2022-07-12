<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Seller;
use app\models\OrderAssign;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Order Details';
// $this->params['breadcrumbs'][] = $this->title;

$seller= ArrayHelper::map(Seller::find()->all(), 'id', 's_name');
//$voter= ArrayHelper::map(Voter::find()->all(), 'voter_id', 'name');
$distribute= ['1'=>'Yes','0'=>'No'];
?>
<div class="order-detail-index">

    <br><br><br>
    <div class="panel panel-body bod" >
        <div class="panel-heading head rot" style="">
            Today's Delivery Task  
        </div>
    <br><br>

    <p>
        <?= Html::a('Add Order', ['create'], ['class' => 'btn btn-primary popup']) ?>
        
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' =>['class' => 'table'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'invoice',

            [
                'attribute'=>'invoice',
                'label'=>'Invoice',
                'value' => function ($model) {

                  return Html::a($model->invoice, ['order-detail/orderinfo', 'id' => $model->id], ['class' => 'popup2','style'=>'font-weight:bold']);  
                            },
                            'format' => 'raw',
            ],

            // 'customer_name', 
            // 'customer_phone',
            //'order_date',
            

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
            // 'total_price',
            // 'discount',
            
            // 'payment_type',


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

            'payable_amount',

            'delivery_charge',

            [
                'attribute'=>'delivery_status',
                
                'contentOptions' => function ($model) {
                            if($model->delivery_status == "PENDING"){
                                return ['class'=> 'label label-danger','style' => 
                                'font-style:oblique;font-weight:bold;
                                text-align:center;font-size:16px;'];
                                }else{
                                return ['class'=> 'label label-warning','style' => 
                                'font-style:oblique;font-weight:bold;
                                text-align:center;font-size:16px;'];
                            }

                        },
                'format' => 'raw',

            ],


            [
                'attribute'=>'id',
                
                'value' => function ($model) {

                    $chk = OrderAssign::find()->where(['order_detail_id'=>$model->id])->andWhere(['record_status'=>'1'])->one();

                            if($chk){
                                return '<span class="glyphicon glyphicon-ok text-success"></span>';
                                }else{
                                return '<span class="glyphicon glyphicon-remove text-danger"></span>';
                            }

                        },
                'format' => 'raw',
                'label'=>'Assign to Rider',
                'filter'=>'',

            ],

            

            [
              'value' => function ($model) {
                if($model->delivery_status=='OUT FOR DELIVERY'){
                    return '';
                }
                return Html::a('<span class="glyphicon glyphicon-edit"></span>', ['order-detail/dcharge', 'id' => $model->id], ['class' => 'btn btn-success popup1 ']);  
                        },
                        'format' => 'raw',
             ],
            //'cancel_reason',
            // 'pay_out',
            // 'pay_out_date',
            // 'pay_out_remark',
            //'updated_by',
            //'updated_date',
            //'record_status',

            //['class' => 'yii\grid\ActionColumn'],
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

            'header' => '<h4>Add Order</h4>',

            'id' => 'jobPop',

            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            


        ]);


       

        Modal::end();

Modal::begin([

            'header' => '<h4>Update Delivery Charge</h4>',

            'id' => 'jobPop1',

            'size' => 'modal-md',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            


        ]);


       

        Modal::end();


Modal::begin([

            'header' => '<h4>Delivery Information</h4>',

            'id' => 'jobPop2',

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
   $('.popup2').click(function(e) {
     e.preventDefault();
     $('#jobPop2').modal('show').find('.modal-body')
     .load($(this).attr('href'));
   });
});");
