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
   
    <div>
        <div class="col-md-6">
           <?= $form->field($model, 'delivery_charge')->textInput()->label('Delivery Charge (Rs)') ?> 
        </div>
        <div class="col-md-6">
           <?= $form->field($model, 'delivery_status')->dropDownList([ 'CANCEL ALL' => 'CANCEL ALL', 'CANCEL PARTIAL' => 'CANCEL PARTIAL', 'DELIVERED' => 'DELIVERED', 'OUT FOR DELIVERY' => 'OUT FOR DELIVERY', ], ['prompt' => '']) ?>
        </div>
    </div>
        


    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

