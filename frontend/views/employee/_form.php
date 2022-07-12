<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$roles = ['admin'=>'Admin','staff'=>"Staff"];
/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin([
        'id' => 'employee-form'
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'employee_name')->textInput(['maxlength' => true]) ?> 
        </div>
        
        <div class="col-md-6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
           <?php 
            if(!isset($update)) 
             echo $form->field($model, 'username',['enableAjaxValidation'=>true])->textInput() 
            ?> 
        </div>
        <div class="col-md-4">
            <?php
            if(!isset($update)) 
                echo $form->field($model, 'password')->passwordInput() 
            ?>
        </div>
        <div class="col-md-4">
           <?= $form->field($model, 'name')->dropDownList($roles, ['prompt' => '']) ?> 
        </div>
    </div>
    
    
    
    
    

    
 

    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
