<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cclass */

$this->title = 'Create Cclass';
$this->params['breadcrumbs'][] = ['label' => 'Cclasses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cclass-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
