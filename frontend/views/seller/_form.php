<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Seller */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seller-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 's_name')->textInput(['maxlength' => true])
    ->label("Seller's Name") ?>

    <?= $form->field($model, 's_phone')->textInput(['maxlength' => true])
    ->label("Seller's Phone") ?>

    <?= $form->field($model, 's_address')->textarea(['rows' => 6])
    ->label("Seller's Address") ?>

    <?= $form->field($model, 's_remark')->textInput(['maxlength' => true])
    ->label("Remark") ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
