<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Expense */

// $this->title = 'Create Expense';
// $this->params['breadcrumbs'][] = ['label' => 'Expenses', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
