
<?php
// use app\models\Registration;
// use app\models\FeeCounter;
 

//use app\models\Counterno;

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Seller;
use app\models\Employee;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Order Details';
// $this->params['breadcrumbs'][] = $this->title;

$seller= ArrayHelper::map(Seller::find()->all(), 'id', 's_name');
$rider= ArrayHelper::map(Employee::find()->all(), 'user_id', 'employee_name');
$distribute= ['1'=>'Yes','0'=>'No'];

$this->title = '';

// $reg = Registration::find()->where(['record_status'=>'1'])->count();
// // $mem = Member::find()->where(['record_status'=>'1'])->count();
// $admfee = Registration::find()->where(['record_status'=>'1'])->sum('paid_amount');
// $monthfee = FeeCounter::find()->where(['record_status'=>'1'])->sum('amount_receive');

?>

<link href='https://fonts.googleapis.com/css?family=Oregano' rel='stylesheet'>
<H3 style="text-align:center;color: #7B68EE;"></H3>

<div style="background:#dae2e3; padding: 20px;border-radius: 7px">
  <br>
<div class="row body">
    <div class="col-lg-4 col-xs-4">
      <div class="info-box shadow" style="border-radius: 3px;padding:5px 10px 10px 20px;">

        <span class="info-box-icon bg-aqua ani" style="box-shadow: 1px 1px 4px  #bec2c4;"><i class="fa fa-users" ></i></span>

        <div class="info-box-content text-center" >
          <span class="info-box-text"style="text-align:center;font-family: 'Oregano';font-size: 18px;">Total Customers</span>
          <span class="info-box-number" style="text-align:center;font-family: 'Oregano';font-size: 22px;"><?= 1 ?></span>
        </div>

      </div>
      
    </div>
    <div class="col-lg-4 col-xs-4">
      <div class="info-box shadow" style="border-radius: 3px;padding:5px 10px 10px 20px;">

        <span class="info-box-icon bg-yellow ani" style="box-shadow: 1px 1px 4px  #bec2c4;"><i class="fa fa-usd" ></i></span>

        <div class="info-box-content text-center" >
          <span class="info-box-text"style="text-align:center;font-family: 'Oregano';font-size: 18px;">Total Sellers</span>
          <span class="info-box-number" style="text-align:center;font-family: 'Oregano';font-size: 22px;"> <?= 1 ?></span>
        </div>

      </div>
      
    </div>

    <div class="col-lg-4 col-xs-4">
      <div class="info-box shadow" style="border-radius: 3px;padding:5px 10px 10px 20px;">

        <span class="info-box-icon bg-green ani" style="box-shadow: 1px 1px 4px  #bec2c4;"><i class="fa fa-usd" ></i></span>

        <div class="info-box-content text-center" >
          <span class="info-box-text"style="text-align:center;font-family: 'Oregano';font-size: 18px;">Overall Income</span>
          <span class="info-box-number" style="text-align:center;font-family: 'Oregano';font-size: 22px;">Rs <?= 1 ?></span>
        </div>

      </div>
      
    </div>
    
   
  </div>
<br><br>
<div  class="row ">
<div class="col-md-12">
<div class="panel panel-body" >
        <div class="panel-heading body" style="">
             
            <p>
                <b class="text-muted" style="font-size: 17px">Showing Today's Delivery Activity</b> 
                <button id="print" class="btn btn-sm btn-success" style="float:right"><span class = 'glyphicon glyphicon-print'></span></button>
            </p>
        </div>
    <br><br>
    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
        
    <div class="table-responsive">
      <div class=" report">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'tableOptions' =>['class' => 'table table-bordered'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'invoice',
            'customer_name', 
            'customer_phone',
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
            // 'total_price',
            // 'discount',
            'payable_amount',
            'delivery_charge',
            'payment_type',


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

            [
                'attribute'=>'delivery_status',
                
                'contentOptions' => function ($model) {
                            if($model->delivery_status == "CANCEL ALL" || $model->delivery_status == "CANCEL PARTIAL" ){
                                return ['style' => 'font-style:oblique;font-weight : bold;color:white;text-align:center;background:#db3b3b'];
                                }else{
                                return ['style' => 'font-style:oblique;font-weight : bold;color:white;text-align:center;background:#66c248;'];
                            }

                        },
                'format' => 'raw',

            ],

            

            // [
            //   'value' => function ($model) {
            //     return Html::a('<span class="glyphicon glyphicon-edit"></span>', ['order-detail/dcharge', 'id' => $model->id], ['class' => 'btn btn-success popup1 ']);  
            //             },
            //             'format' => 'raw',
            //         ],
            
            [
              'attribute'=>'cancel_reason',
              'label'=>'Reason (if cancel)'
            ],
            // 'pay_out',
            // 'pay_out_date',
            // 'pay_out_remark',
            //'updated_by',
            [
                'attribute'=>'updated_by',
                'label'=>'Delivered By',
                'value'=>function($model) use($rider) {
                    return isset($model->updated_by) ? $rider[$model->updated_by] : '';
                }, 
            ],
            //'updated_date',
            //'record_status',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
</div>
</div>
<br><br>
<div class="row body">

<div class="col-md-12 " >
      <div class="card shadow" style="background-color: white;padding: 25px;">
        <div class="card-header rot">
            <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                  <h4 style="text-align:center;font-family: 'Oregano';font-size: 20px;color: #f5f8fc">Income Chart</h4>
                </div>
            </div>
        </div>
        <div class="card-body" >
          <div id="interests_div" ></div>
        </div>
      </div>

</div>
</div>
<br>
</div>


  <!-- <div id="invested_div" ></div> -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);
function drawBasic() {
  var columns=[];
  columns.push(["Month","Amount"]);
  var invested = 1;
  var interests = 1;
  invested = columns.concat(invested);
  interests = columns.concat(interests);
  
  var invested = google.visualization.arrayToDataTable(invested);
  var interests = google.visualization.arrayToDataTable(interests);

  var options = {
    // title:"",
    width: 200,
    height: 330,
    legend: { position: 'top' },
    bar: { groupWidth: '40%' },
    
  };


  var interests_options = {
    // title:"",
    width: 200,
    height: 330,
    legend: { position: 'top' },
    bar: { groupWidth: '40%' },
    
  };
  

  var chartInterests = new google.visualization.ColumnChart(
  document.getElementById('interests_div'));
  
  var chartInvested = new google.visualization.ColumnChart(
  document.getElementById('invested_div'));


  chartInterests.draw(interests,interests_options);
  
  chartInvested.draw(invested,options);
} 
</script>
<style>
  .shadow {
              
              box-shadow: 2px 5px 6px #bfbbbb;;
              border-radius: 5px;
            }
    .background{
                opacity: 0.2;
                background: linear-gradient(to right, #99ccff 12%, #3366cc 114%);
                position: fixed; 
                margin-left: -10%;
                margin-top:-5%;
                margin-right: -3%;
                width: 150%; 
                height: 100%;

            }
  .card {
    margin-top: 12px;
    border: thin solid #ccc;
    border-radius: 4px;
    height: 410px;
}
.card-body, .card-header, .card-footer {
    padding: 12px;
}
.card-label {
    text-transform: uppercase;
    font-size: 12px;
    font-family: 'IBM Plex Sans', sans-serif;
    min-height: 34px;
}
.card-value {
    font-size: 36px;
}
.card-summary {
    font-size: 10px;
    padding-left: 8px;
}
.card-header {
    border-bottom: thin solid #ccc;
}
.card-footer {
    border-top: thin solid #ccc;
}
.ani{
      margin-top:-20px;
      border-radius: 5px;
      transform: translateZ(0);
      transition: all .3s cubic-bezier(.34,1.61,.7,1);

    }        
    .ani:hover {
            position: relative; 
            margin-top:-60px;
            
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
              transform: scale(1.1,1.1);
            
    }

  @media print {
  body  *{
    visibility: hidden;
  }
  .report, .report * {
    visibility: visible;
  }
  .report {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    /*border-collapse: collapse;*/
    
  }

}

</style>
<?php
$this->registerJs('
$("#print").click(function(){
    // var divName = "report";
    // var printContents = document.getElementById(divName).innerHTML;
    // document.body.innerHTML = printContents;
    window.print();
})
');