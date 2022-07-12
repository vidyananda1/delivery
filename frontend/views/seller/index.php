<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SellerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Sellers';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-index">
    <br><br><br>
    <div class="panel panel-body bod" >
        <div class="panel-heading head rot" style="">
            Showing Seller Details  
        </div>
    <br><br>

    <p>
        <?= Html::a('Add Seller', ['create'], ['class' => 'btn btn-primary popup']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class'=>'table'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'s_name',
            [
                'attribute'=>'s_name',
                'label'=>"Seller's Name",
            ],
            //'s_phone',
            [
                'attribute'=>'s_phone',
                'label'=>"Seller's Phone",
            ],
            //'s_address:ntext',
            [
                'attribute'=>'s_address',
                'label'=>"Seller's Address",
            ],
            // 'auth_key',
            // 'password_hash',
            
            [
                'attribute'=>'s_remark',
                'label'=>'Remark',
            ],
            //'created_by',
            //'created_date',
            //'updated_by',
            //'updated_date',
            //'record_status',

            //['class' => 'yii\grid\ActionColumn'],
            [
              'value' => function ($model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['seller/update', 'id' => $model->id], ['class' => 'btn btn-xs btn-warning popup1']);  
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

            'header' => '<h4>Create Seller</h4>',

            'id' => 'jobPop',

            'size' => 'modal-md',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            


        ]);


       

        Modal::end();

Modal::begin([

            'header' => '<h4>Update Seller</h4>',

            'id' => 'jobPop1',

            'size' => 'modal-md',
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