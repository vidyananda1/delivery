<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderAssign */

$this->title = 'Update Order Assign: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Order Assigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-assign-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
