<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Category;
use app\models\Customer;
use dosamigos\datepicker\DatePicker;

$cus= ArrayHelper::map(Customer::find()->all(), 'id', 'cus_name');
$ph= ArrayHelper::map(Customer::find()->all(), 'phone', 'phone');
$cat= ArrayHelper::map(Category::find()->all(), 'id', 'cat_name');

/* @var $this yii\web\View */
/* @var $model app\models\OrderDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-detail-form">

    <?php $form = ActiveForm::begin(); ?>
   
    <div class="row">
        <div class="col-md-6">
           <?= $form->field($model, 'pay_out_date')->widget(
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
                    ])->label('Date of payout');?> 
        </div>
        <div class="col-md-6">
           <?= $form->field($model, 'pay_out')->dropDownList([ 'YES' => 'YES', 'NO' => 'NO'], ['prompt' => ''])->label('Pay Out'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'pay_out_remark')->textInput() ?>
        </div>
    </div>
        


    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

