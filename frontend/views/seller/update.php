<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seller */

// $this->title = 'Update Seller: ' . $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Sellers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="seller-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
