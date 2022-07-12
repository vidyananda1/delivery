<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use app\models\SliderImage;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SliderImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Slider Images';
// $this->params['breadcrumbs'][] = $this->title;
$cat = ['1'=>'Active','0'=>'Inactive'];
?>
<div class="slider-image-index">
    <br><br><br>

    <div class="panel panel-body bod" >
        <div class="panel-heading head rot" style="">
            Showing Carousel Images  
        </div>
    <br><br>

    <p>
        <?= Html::a('Add Corousel-Image', ['create'], ['class' => 'btn btn-primary popup']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' =>['class' => 'table'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'images',
            [
            'attribute' =>'images',
            'value' => function ($model) {
                $photo= SliderImage::find()->where(['images'=>$model->images])->one();
              if($photo){
               return "images/".$photo->images;
              } else{
                return  "NULL";
              }
            },
            'format' => ['image',['width'=>'80','height'=>'80']],
            'label' => 'Carousel Image',
            'filter'=>'',
            ],
            'image_title',
            // 'created_by',
            // 'created_date',
            //'updated_by',
            //'updated_date',
            //'record_status',

            [
                'attribute'=>'record_status',
                'value' => function ($model) use($cat) {
                return isset($model->record_status) ? $cat[$model->record_status] : ' ';
                },
                'contentOptions' => function ($model) {
                            if($model->record_status == "1"){
                                return ['style' => 
                                'color:green;text-align:center;font-style:oblique;font-weight:bold;font-size:20px;'];
                            }else{
                                return ['style' => 
                                'font-style:oblique;font-weight:bold;color:red;
                                text-align:center;font-size:20px;'];
                            }

                        },
                'format' => 'raw',
                'filter' => $cat,

            ],

            [
              'value' => function ($model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['slider-image/update', 'id' => $model->id], ['class' => 'btn btn-xs btn-warning popup1']);  
                        },
                        'format' => 'raw',
                    ],

            [
              'value' => function ($model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['slider-image/delete', 'id' => $model->id], ['class' => 'btn btn-xs btn-danger','data-confirm' => 'Are you sure to delete ?','data-method' => 'post',]);  
                        },
                        'format' => 'raw',
                    ],

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

            'header' => '<h4>Create Slider-Image</h4>',

            'id' => 'jobPop',

            'size' => 'modal-md',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            


        ]);


       

        Modal::end();

Modal::begin([

            'header' => '<h4>Update Slider-Image</h4>',

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