<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderDetail */

// $this->title = 'Create Order Detail';
// $this->params['breadcrumbs'][] = ['label' => 'Order Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-detail-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelitem' => $modelitem,
    ]) ?>

</div>
