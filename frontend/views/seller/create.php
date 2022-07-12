<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seller */

// $this->title = 'Create Seller';
// $this->params['breadcrumbs'][] = ['label' => 'Sellers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="seller-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
