<?php
use yii\helpers\Url;

//$this->title = "Reports";


?>
<link href='https://fonts.googleapis.com/css?family=Oregano' rel='stylesheet'>
<div class="row">
<div class="col-md-12" style="padding-right: 50px;">
    <div class="head" style="font-family: 'Oregano';color: white;font-size: 24px;" >
        <span class="glyphicon glyphicon-file" >&nbsp;</span>Showing Report Breakup
    </div>
  
<br><br>
<div class="panel panel-body" style="box-shadow: 1px 2px 3px gray;">
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">OVERALL</a></li>
    <li><a data-toggle="tab" href="#menu2">EXPENSES</a></li>
    
  </ul>

  <div class="tab-content">
    <br>
    <div id="home" class="tab-pane fade in active">
        <div class="col-md-3 label label-primary">
            <h4> Overall Delivery Report</h4>
        </div>
        <br><br><br>
        <?php echo $this->render('_search',['model'=>$model,'formName'=>'admission-form','button'=>'admin-button','div'=>'admin-report','url'=>Url::to(['admission']) ]); ?>
        <div id="admin-report"></div>
    </div>
    <div id="menu2" class="tab-pane fade">
      <div class="col-md-3 label label-warning">
            <h4> Expenses Report</h4>
        </div>
        <br><br><br>
        <?php echo $this->render('_search',['model'=>$model ,'formName'=>'expenses-form','button'=>'expenses-button','div'=>'expenses-report','url'=>Url::to(['expenses']) ]); ?>
        <div id="expenses-report"></div>
    </div>
  </div>

        
</div>
</div>
</div>
<style type="text/css">
    
    .head{
      border:solid 1px #9750bf;
      background-color: #9750bf;
      padding: 17px;
      border-radius: 10px;
      box-shadow: 1px 2px 4px gray;
      transform: translateZ(0);
      transition: all .3s cubic-bezier(.34,1.61,.7,1);

    }   
    .head:hover {
              transform: scale(1.03,1.03);
            
    }
</style>
