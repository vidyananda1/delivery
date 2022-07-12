<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OrderDetail */

// $this->title = $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Order Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
// \yii\web\YiiAsset::register($this);
?>
<div class="order-detail-view">

    

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'customer_id',
            'invoice',
            'customer_phone',
            'date_of_delivery',
            'total_price',
            'discount',
            'payable_amount',
            'payment_type',
            'seller_id',
            'pay_out',
            'pay_out_date',
            'pay_out_remark',
            'updated_by',
            'updated_date',
            'record_status',
        ],
    ]) ?>

</div>
