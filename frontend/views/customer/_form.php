<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-12">
            <?= $form->field($model, 'cus_name')->textInput(['maxlength' => true])->label("Customer's Name") ?>
        </div>
        
    </div>
    <div style="background: #e6f5fa; padding:10px;border-radius: 5px">
        <div ><b>Primary Address</b></div>
        <hr style="border-color: #188a94">
       <div class="row">
       
            <div class="col-md-4">
                <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'landmark')->textInput(['maxlength' => true]) ?>
            </div>
           
        </div> 
    </div>
    <br><br>
    <div style="background: #e6f5fa; padding:10px;border-radius: 5px">
        <div ><b>Secondary Address</b></div>
        <hr style="border-color: #188a94">
       <div class="row">
       
            <div class="col-md-4">
                <?= $form->field($model, 'sec_address')->textInput(['maxlength' => true])
                ->label('Secondary Address') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'sec_phone')->textInput(['maxlength' => true])
                ->label('Secondary Phone') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'sec_landmark')->textInput(['maxlength' => true])
                ->label('Secondary Landmark') ?>
            </div>
           
        </div> 
    </div>
     
    <br><br>
    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
