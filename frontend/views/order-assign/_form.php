<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Employee;
use app\models\OrderDetail;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\OrderAssign */
/* @var $form yii\widgets\ActiveForm */

$emp= ArrayHelper::map(Employee::find()->where(['emp_type'=>'Rider'])->all(), 'id', 'employee_name');
$invoice= ArrayHelper::map(OrderDetail::find()->all(), 'id', 'invoice');
$name= ArrayHelper::map(OrderDetail::find()->all(), 'id', 'customer_name');
$phone= ArrayHelper::map(OrderDetail::find()->all(), 'id', 'customer_phone');
$dod= ArrayHelper::map(OrderDetail::find()->all(), 'id', 'date_of_delivery');
$dc= ArrayHelper::map(OrderDetail::find()->all(), 'id', 'delivery_charge');

?>

<div class="order-assign-form">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="panel panel-body">
    <div class="row">
    	<div class="col-sm-6">
        	
        	<?= $form->field($model, 'employee_id')->widget(Select2::classname(), [
                'data' => $emp,
                'language' => 'de',
                'options' => ['placeholder' => '....Select Rider....'],
                'pluginOptions' => [
                'allowClear' => true
                ],
            ])->label('Select Rider');
            ?>
    	</div>
	</div>

	<hr>
	<table class="table table-condensed text-center">
        <tr>
            <th>Sl</th><th>Invoice</th>
            <th>Customer Name</th><th>Customer Phone</th><th>Date of Delivery</th>
            <th>Delivery Charge</th>
        </tr>
        <?php foreach ($li as $sl => $rider) { ?>
            <tr>
                <td>
                    <?= $sl+1 ?>
                    <?= $form->field($modelsrider, "[{$sl}]order_detail_id")->hiddenInput(['value'=>$rider->id])->label(false) ?>
                    <?= $form->field($modelsrider, "[{$sl}]date_of_delivery")->hiddenInput(['value'=>$rider->date_of_delivery])->label(false) ?>
                </td>
                <td><?= $invoice[$rider->id] ?></td>
                <td><?= $name[$rider->id] ?></td>
                <td><?= $phone[$rider->id] ?></td>
                <td><?= date('d-m-Y',strtotime($dod[$rider->id])) ?></td>
                <td><?= $dc[$rider->id] ?></td>
            </tr>
        <?php } ?>
    </table>
        
<br>
<div class="form-group text-center">
    <?= Html::submitButton('Assign', ['class' => 'btn btn-success']) ?>
    
</div>
</div>
<?php ActiveForm::end(); ?>

</div>
