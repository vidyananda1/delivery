<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OrderAssign */

$this->title = 'Create Order Assign';
$this->params['breadcrumbs'][] = ['label' => 'Order Assigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-assign-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
