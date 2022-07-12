<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Employee;
use app\models\OrderDetail;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderAssignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Order Assigns';
// $this->params['breadcrumbs'][] = $this->title;
$emp= ArrayHelper::map(Employee::find()->where(['emp_type'=>'Rider'])->all(), 'id', 'employee_name');
?>
<div class="order-assign-index">

    <br><br><br>
        <div class="panel panel-body bod" >
            <div class="panel-heading head rot" style="">
                Task Assign to Riders
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
            
            // [
            //     'attribute'=> 'order_detail_id',
            //     'label'=>'Order ID',
            // ],

            [
                'attribute'=>'order_detail_id',
                'label'=>'Invoice',
                'value' => function ($model) {

                  $inv = OrderDetail::find()->where(['id'=>$model->order_detail_id])->one();

                  return Html::a($inv->invoice, ['order-assign/info', 'id' => $model->id], ['class' => 'popup','style'=>'font-weight:bold']);  
                            },
                            'format' => 'raw',
            ],
            

            [
                'attribute' => 'employee_id',
                'value' => function($model) use($emp) {
                    return isset($model->employee_id) ? $emp[$model->employee_id] : '';
                },
                'label' => "Rider's Name",
                'filter' => Select2::widget([
                                'model' => $searchModel,
                                'theme' => Select2::THEME_BOOTSTRAP,
                                'attribute' => 'employee_id',
                                'options' => ['prompt' => 'Select Rider ...'],
                                'pluginOptions' => ['allowClear' => true],
                                'data' => $emp,
                        ]),
            ],
            //'date_of_delivery',
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
                'attribute'=>'order_detail_id',
                'label'=>'Delivery Status',
                'value' => function ($model) {

                  $chk = OrderDetail::find()->where(['id'=>$model->order_detail_id])->one();

                  return isset($chk) ? $chk->delivery_status : '';  
                            },
                'format' => 'raw',
                'filter'=>'',
            ],
            //'record_status',

            //['class' => 'yii\grid\ActionColumn'],

            [
              'value' => function ($model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['order-assign/update', 'id' => $model->order_detail_id], ['class' => 'btn btn-xs btn-warning popup1']);  
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
      background-color:#37658c;
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

            'header' => '<h4 style="color: #37658c">Delivery Info</h4>',

            'id' => 'jobPop',

            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            


        ]);


       

        Modal::end();

Modal::begin([

            'header' => '<h4>Update Task Assign</h4>',

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
