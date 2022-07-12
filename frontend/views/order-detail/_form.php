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

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <div class="col-md-4">
          <?= $form->field($model, 'customer_phone')->widget(Select2::classname(), [
                'data' => $ph,
                'language' => 'de',
                'options' => ['placeholder' => '------- Enter Phone No -------'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Phone No'); 

            ?>
        </div>
        <div class="col-md-4">
           <?= $form->field($model, 'customer_name')->textInput(['readonly' => true]) ?> 
        </div>
        <div class="col-md-4">
           <?= $form->field($model, 'date_of_delivery')->widget(
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
                    ])->label('Delivery Date');?> 
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?> 
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'discount')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'payable_amount')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'payment_type')->dropDownList([ 'CASH' => 'CASH', 'GPAY' => 'GPAY', 'NET-BANKING' => 'NET-BANKING', 'CASH & GPAY' => 'CASH & GPAY', 'CASH & NET-BANKING' => 'CASH & NET-BANKING', ], ['prompt' => '']) ?>
        </div>
    </div>


    <hr style="border: solid 1px #bfbfbf">
         <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 20, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelitem[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'polling_booth_id',
            
        ],
    ]); ?>
    <div class="container-items "><!-- widgetContainer -->
    <div class=" pull-right">
    <button type="button" class="add-item btn btn-success btn-sm"><i class="glyphicon glyphicon-plus"></i> ADD</button>
    </div>
    <br><br>
    <div class="item">
    <?php foreach ($modelitem as $i => $modelsitem): ?>
        <?php
        if (!$modelsitem->isNewRecord) {
            echo Html::activeHiddenInput($modelsitem, "[{$i}]id");
        }
        ?>

        <div class="row" style="padding: 10px">
            <div  class=" panel-info">
                <div class="panel-heading">
                <div class=" pull-right " >
                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                </div>
                <div class="row">
                    
                    <div class="col-sm-4">
                        
                        <?= $form->field($modelsitem, "[{$i}]product_name")->textInput(['maxlength' => true])->label('Item Name'); ?>
                    </div> 
                    <div class="col-sm-4">
                        
                        <?= $form->field($modelsitem, "[{$i}]product_category")->dropDownList($cat, ['prompt' => ''])->label('Category') ?>
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-md-4" >
                        <?= $form->field($modelsitem, "[{$i}]product_quantity")->textInput(['maxlength' => true])->label('Quantity'); ?>
                    </div> 
                    <div class="col-md-4" >
                        <?= $form->field($modelsitem, "[{$i}]product_price")->textInput(['class'=>'price form-control'])->label('Price (Rs)'); ?>
                    </div>
                     
                </div>
                
            </div>
           </div> 
        </div><!-- .row -->


    <?php endforeach; ?>
    </div>  
</div>
    <?php DynamicFormWidget::end();?>
    <br>


    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
//$url = Url::to(["amount"]);
$ph = Url::to(["phone"]);
$this->registerJs('
$(".select").select2();
$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    // console.log("beforeInsert");
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    $(".select").select2();
    // console.log("afterInsert");
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    // console.log("Deleted item!");
    getData();

});

$(".dynamicform_wrapper").on("limitReached", function (e, item) {
    alert("Limit reached");
});

$(document).on("change", "#orderdetail-customer_phone",   function () {
    var code = $("#orderdetail-customer_phone").val();
    var url = "'.$ph.'";
    $.post(url+"&ph="+code, function(data) {
                if(!data)
                {
                  alert("Phone Number not found !!");
                } 
                else{
                    var value = $.parseJSON(data); 
                    $("#orderdetail-customer_name").val(value.name); 

                }
            });
  });

$(document).on("change", ".price",   function main() {
  getData();
});

 function getData() {
    var arr = [];
    const numberItems = document.querySelectorAll(".price");
    var hasData = 1;
    numberItems.forEach(function(a) {
        if(!getSum(a)){
         hasData = 0;
         return ;
        }
         arr.push(getSum(a));
    });
    if(!hasData) {
         return ;
    }
    else {
         return  requestSum(arr);
    }
}

function getSum(a) {
    var id = a.id;
    var item_no = id.substring(
        id.indexOf("-")+1,
        id.lastIndexOf("-"),
    )
    var orderItemId = `orderitem-${item_no}-item_id`;
    var orderItemValue = document.getElementById(orderItemId).value;
    const price =  $("#orderdetail-price");
    const amount =  $("#orderdetail-total");
    // console.log(a.value);
    if(orderItemValue=="" || a.value=="") {
        // console.log("value empty");
        price.val(0);
        amount.val(0);
        return 0;
    }
    return {"itemId":orderItemValue,"itemCount":a.value};
    
}

function requestSum(arr) {
    var tax =  $("#orderdetail-tax_id").val();
    var discount =  $("#orderdetail-discount").val();
    const price =  $("#orderdetail-price");
    const amount =  $("#orderdetail-total");
    const discount_amount =  $("#orderdetail-discount_amount");
    const tax_amount =  $("#orderdetail-tax_amount");
    const url = "'.$ph.'";
    
    if(tax=="")
        tax = 0 ;
    if(discount=="")
        discount = 0;
    $.ajax({
        url : "'.$ph.'",
        type : "POST",
        data : {
            "arr" :arr,"discount":discount,"tax":tax
        },
        dataType:"json",
        success : function(response) {              
            // var obj = JSON.parse(data);
            amount.val(response["amount"]);
            price.val(response["sum"]);
            discount_amount.val(response["discount"]);
            tax_amount.val(response["tax"]);
        },
        error : function(request,error)
        {
            alert("Request: "+JSON.stringify(request));
        }
    });
    return 1;
}

') ?>
