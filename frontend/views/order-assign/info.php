<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
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
        'dataProvider' => $dataProvider,
        'tableOptions' =>['class' => 'table'],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'invoice',
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
            //'order_date',
            //'date_of_delivery',
            [
                'attribute'=>'date_of_delivery',
                'value' => function($model)  {
                    return isset($model->date_of_delivery) ? date('d-m-Y',strtotime($model->date_of_delivery)) : '';
                },
                'label'=>'Delivery Date',
                
            ],
            // 'total_price',
            // 'discount',
           
            // 'payment_type',
            
            // [
            //     'attribute'=>'seller_id',
            //     'label'=>'Seller',
            // ],
            'payable_amount',
            'delivery_charge',
            // 'cancel_reason',
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

<hr style="border: solid 1px #37658c">

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

