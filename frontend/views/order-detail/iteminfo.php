<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\Category;
use app\models\Customer;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Order Details';
// $this->params['breadcrumbs'][] = $this->title;

$cat= ArrayHelper::map(Category::find()->all(), 'id', 'cat_name');
?>
<div class="order-detail-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="table-responsive">
     <?= GridView::widget([
        'dataProvider' => $dataProvider1,
        'tableOptions' =>['class' => 'table'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'order_detail_id',
            'product_name',
            //'product_category',
            [
                'attribute' => 'product_category',
                'value' => function($model) use($cat) {
                    return isset($model->product_category) ? 
                    $cat[$model->product_category] : '';
                },
                'label' => "Product Category",
                
            ],
            'product_quantity',
            'product_price',
            //'updated_by',
            //'updated_date',
            //'record_status',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>

