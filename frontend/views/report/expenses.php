<?php
$this->title = 'Expenses Report';
?>
<div id="report-expenses">
<div class="headings">Expenses Report</div>
    

<table style="border:solid black 1px;width:100%;">
    <tr>
        <th>Expense Name</th>
        <th>Amount Paid</th>
        <th>Date</th>
    </tr>

<?php
foreach($expenses as $key=>$value) { 
?>
<tr>
    <td><?=$value["ex_name"]?></td>
    <td><?= $value["amount"] ?></td>
    <td><?= date('d-m-Y',strtotime($value["date"]))?></td>
</tr>
<?php } ?>
<tr>
    <td class="sub-header"  >Total (in Rs.)</td>
    <td  colspan="2"><?=$sumAmount?></td>
</tr>
</table>
</div>
<button id="printExpense">Print</button>
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

@media print {
  body * {
    visibility: hidden;
  }
  #report-expenses, #report-expenses * {
    visibility: visible;
  }
  #report-expenses {
    position: absolute;
    left: 0;
    top: 0;
  }
}


</style>
<?php
$this->registerJs('
$("#printExpense").click(function(){
    window.print();
    window.reload();
})
');