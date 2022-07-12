<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderItem */

// $this->title = 'Create Order Item';
// $this->params['breadcrumbs'][] = ['label' => 'Order Items', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
