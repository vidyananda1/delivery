<?php
$this->title = 'Reports';
?>
<div id="report-fee">
<div class="headings">Fees Report</div>
    

<table style="border:solid black 1px;width:100%;">
    <tr>
        <th>Hosteller Name</th>
        <th>Registration ID</th>
        <th>Amount Paid</th>
        <th>Due Amount</th>
        <th>Date</th>
    </tr>

<?php
foreach($fees as $key=>$value) { 
?>
<tr>
    <td><?=$value["name"]?></td>
    <td><?=$value["registration_id"]?></td>
    <td><?= $value["amount_receive"] ?></td>
    <td><?=$value["due_amount"]?></td>
    <td><?= date('d-m-Y',strtotime($value["date"]))?></td>
</tr>
<?php } ?>
<tr>
    <td class="sub-header"  colspan="2">Total (in Rs.)</td>
    <td  class="sub-header"><?=$sumAmountReceived?></td><td><?=$sumAmountDue?></td>
    <td></td>
</tr>
</table>
</div>
<button id="printFees">Print</button>
<br><br><br>

<style >
    table,th,td {
        border: 1px solid;
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
  #report-fee, #report-fee * {
    visibility: visible;
  }
  #report-fee {
    position: absolute;
    left: 0;
    top: 0;
  }
}


</style>
<?php
$this->registerJs('
$("#printFees").click(function(){
    // var divName = "report";
    // var printContents = document.getElementById(divName).innerHTML;
    // document.body.innerHTML = printContents;
    window.print();
})
');