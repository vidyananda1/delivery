<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Seller;
use app\models\Customer;
use app\models\OrderAssign;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Order Details';
// $this->params['breadcrumbs'][] = $this->title;

$seller= ArrayHelper::map(Seller::find()->all(), 'id', 's_name');

$dstatus = ['PENDING'=>'PENDING','DELIVERED'=>'DELIVERED','OUT FOR DELIVERY'=>'OUT FOR DELIVERY','CANCEL ALL'=>'CANCEL ALL','CANCEL PARTIAL'];

// $this->title = 'Order Details';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-detail-index">

    <br><br><br>
    <div class="panel panel-body bod" >
        <div class="panel-heading head rot" style="">
            Pending Delivery  
        </div>
    <br><br>

    <?= Html::beginForm(['order-detail/assign'],'post');?>
        <div class="col-sm-4">
            <?= Html::submitButton('Assign Rider', ['class' => 'btn btn-success','value'=>'riderassign','name'=>'submit']) ?>
        </div><br><br>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' =>['class' => 'table'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
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
                'label'=>'',
                'filter'=>'',

            ],

            ['class' => 'yii\grid\CheckboxColumn'],
            //'invoice',

            [
                'attribute'=>'invoice',
                'label'=>'Invoice',
                'value' => function ($model) {

                  return Html::a($model->invoice, ['order-detail/iteminfo', 'id' => $model->id], ['class' => 'popup2','style'=>'font-weight:bold']);  
                            },
                            'format' => 'raw',
            ],

            'customer_name', 
            [
                'attribute'=>'customer_phone',
                'label'=>'Primary No',
            ],

            [
                'attribute'=>'customer_phone',
                'value'=>function($model) {
                    $cus = Customer::find()->where(['phone'=>$model->customer_phone])->one();
                    return isset($cus) ? 
                    $cus->sec_phone : '';
                },
                'label'=>'Alternate No',
            ],

            [
                'attribute'=>'customer_phone',
                'value'=>function($model) {
                    $cus = Customer::find()->where(['phone'=>$model->customer_phone])->one();
                    return isset($cus) ? 
                    $cus->address : '';
                },
                'label'=>'Primary Address',
            ],

            [
                'attribute'=>'customer_phone',
                'value'=>function($model) {
                    $cus = Customer::find()->where(['phone'=>$model->customer_phone])->one();
                    return isset($cus) ? 
                    $cus->landmark : '';
                },
                'label'=>'Primary Landmark',
            ],

            [
                'attribute'=>'customer_phone',
                'value'=>function($model) {
                    $cus = Customer::find()->where(['phone'=>$model->customer_phone])->one();
                    return isset($cus) ? 
                    $cus->sec_address : '';
                },
                'label'=>'Secondary Address',
            ],

            [
                'attribute'=>'customer_phone',
                'value'=>function($model) {
                    $cus = Customer::find()->where(['phone'=>$model->customer_phone])->one();
                    return isset($cus) ? 
                    $cus->sec_landmark : '';
                },
                'label'=>'Secondary Landmark',
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
            // 'total_price',
            // 'discount',
            'payable_amount',
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
            'delivery_status',
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
      background-color:#cc533b;
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

            'header' => '<h4>Update order</h4>',

            'id' => 'jobPop1',

            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            


        ]);


       

        Modal::end();


Modal::begin([

            'header' => '<h4>Item Info</h4>',

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
