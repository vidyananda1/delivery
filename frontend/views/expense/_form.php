<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Expense */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expense-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
           <?= $form->field($model, 'item_name')->textInput(['maxlength' => true]) ?> 
        </div>
        <div class="col-md-6">
           <?= $form->field($model, 'quantity')->textInput() ?> 
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
           <?= $form->field($model, 'date')->widget(
                        DatePicker::className(), [
                            // inline too, not bad
                             'inline' => false, 
                             
                             'options' => ['placeholder' => '---- Select Date ----','class'=> 'date'],

                             // modify template for custom rendering
                            //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                'clientOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'yyyy-mm-dd',     


                            ]
                    ])->label('Select Date');?>
        </div>
        <div class="col-md-6">
           <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>

    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
