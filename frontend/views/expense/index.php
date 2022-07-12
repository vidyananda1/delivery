<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ExpenseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Expenses';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-index">
    <br><br><br>
    <div class="panel panel-body bod" >
        <div class="panel-heading head rot" style="">
            Showing Expense Details  
        </div>
    <br><br>

    <p>
        <?= Html::a('Add Expense', ['create'], ['class' => 'btn btn-primary popup']) ?>
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
            'item_name',
            //'date',
            [
                'attribute'=>'date',
                'label'=>'Date of Expenses',
                'value'=>function ($model) {
                        return isset($model->date) ? date('d-m-Y',strtotime($model->date)) : ' ';
                    },
            ],
            'quantity',

            
            [
                'attribute'=>'price',
                'label'=>'Price (Rs)',
                'value'=>function ($model) {
                        return isset($model->price) ? "Rs ".$model->price : ' ';
                    },
            ],
            //'created_by',
            //'created_date',
            //'updated_by',
            //'updated_date',
            //'record_status',

            //['class' => 'yii\grid\ActionColumn'],
            [
              'value' => function ($model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['expense/update', 'id' => $model->id], ['class' => 'btn btn-xs btn-warning popup1']);  
                        },
                        'format' => 'raw',
                    ],

            [
              'value' => function ($model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['expense/delete', 'id' => $model->id], ['class' => 'btn btn-xs btn-danger','data-confirm' => 'Are you sure to delete ?','data-method' => 'post',]);  
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

            'header' => '<h4>Create Expense</h4>',

            'id' => 'jobPop',

            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            


        ]);


       

        Modal::end();

Modal::begin([

            'header' => '<h4>Update Expense</h4>',

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
