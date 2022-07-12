<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\Items;
use app\models\Category;
use app\models\OrderDetail;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use app\models\Customer;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DateRangePicker;

$this->title = 'Reports';
?>
<br>
<div style="border: solid 1px #e8eaed;padding:10px;border-radius: 7px;background: #e8eaed">
<div id="report">
<div class="headings">Admission Report</div>
    

<table style="border:solid #c4c2c2 1px;width:100%;font-size: 15px;">
    <tr style="background: #188a94;color: #edebeb">
        <th>Hosteller Name</th>
        <th>Registration ID</th>
        <th>Amount Paid</th>
        <th>Due Amount</th>
        <th>Date</th>
    </tr>

<?php
foreach($reg as $key=>$value) { 
?>
<tr>
    <td><?=$value["name"]?></td>
    <td><?=$value["reg_id"]?></td>
    <td><?= $value["total"] ?></td>
    <td><?=$value["due_amount"]?></td>
    <td><?= date('d-m-Y',strtotime($value["date"]))?></td>
</tr>
<?php } ?>
<tr style="font-weight: bold">
    <td class="sub-header"  colspan="2">Total (in Rs.)</td>
    <td  class="sub-header"><?=$regsum?></td><td><?=$dueSum?></td>
    <td></td>
</tr>
</table>
</div>
<br>
<div class="text-right">
<button id="print" class="btn btn-sm btn-primary">Print</button>
</div>
<br><br><br>
</div>
<style >
    table,th,td {
        border: 1px solid #c4c2c2;
        font-family: 'Open Sans';
        text-align: center;
    }
    .headings{
        font-size: 1.5em;
        font-family: 'Open Sans';
        /* margin-left: 50px; */
    }
    .sub-header{
        text-align: center;
        /* font-weight:bold */
    }
/* @media print {
  header,footer, form { 
    display: none; 
  }
} */
@media print {
  body * {
    visibility: hidden;
  }
  #report, #report * {
    visibility: visible;
  }
  #report {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    
  }
}


</style>
<?php
$this->registerJs('
$("#print").click(function(){
    // var divName = "report";
    // var printContents = document.getElementById(divName).innerHTML;
    // document.body.innerHTML = printContents;
    window.print();
})
');