<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SliderImage */

// $this->title = 'Create Slider Image';
// $this->params['breadcrumbs'][] = ['label' => 'Slider Images', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-image-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
