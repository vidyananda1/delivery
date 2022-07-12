<?php
 use app\models\Employee;
 use app\models\ApplyLeave;
 use app\models\ApplyStatus;
 use app\models\ApprovalStatus;

//use app\models\Counterno;

$this->title = '';
?>
<div class="background">
</div>
<link href='https://fonts.googleapis.com/css?family=Metamorphous' rel='stylesheet'>
<H2 style="text-align:center;color: #7B68EE; text-shadow:2px 1px 2px #C0C0C0;"><b>BANK POLICY MANAGEMENT</b></H2>
  <br>
  <br>
<?php
date_default_timezone_set('Asia/Kolkata');
setlocale(LC_MONETARY, 'en_IN');  


$today = date('Y-m-d');

?>
  
  <div class="row ">
    <div class="col-lg-6 col-xs-6 " >
          <!-- small box -->
          <div class="small-box shadow" style="background: linear-gradient(to bottom, #33ccff 0%, #48628c 100%); ">
            <div class="inner">
             

              <h4 style="text-align:center;font-size: 25px;"><b>Total Investors</b></h4>
            </div> 
            <div><h4 style="text-align:center;font-size: 20px"><b>1</b></h4></div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            
                <a href="index.php?r=employee/create" class="small-box-footer" style="border-radius: 5px">ADD +<i class="fa fa-arrow-circle-right"></i></a> 
          </div>
    </div>
    <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box shadow" style="background: linear-gradient(to bottom, #99ff99 -6%, #13852e 106%)">
            <div class="inner">
             

              <h4 style="text-align:center;font-size: 25px"><b>Total Users</b></h4>
            </div>
            <div><h4 style="text-align:center;font-size: 20px"><b>1</b></h4></div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            
                <a href="index.php?r=employee/create" class="small-box-footer" style="border-radius: 5px">ADD +<i class="fa fa-arrow-circle-right"></i></a> 
          </div>
    </div>
  </div>
    <br>
  <div class="row ">  
    
    <div class="col-lg-12 col-xs-12">
          <!-- small box -->
          <div class="small-box shadow" style="background: linear-gradient(to bottom, #ff9966 -7%, #cf2204 135%)">
            <div class="inner">
             

              <h4 style="text-align:center;font-size: 25px"><b>Amount Till Now</b></h4>
            </div>
            <div><h4 style="text-align:center;font-size: 20px"><b>Rs 1</b></h4></div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            
                <a href="index.php?r=employee/create" class="small-box-footer" style="border-radius: 5px">ADD +<i class="fa fa-arrow-circle-right"></i></a> 
          </div>
    </div>
  </div>
 <link href='https://fonts.googleapis.com/css?family=Oregano' rel='stylesheet'>
    
  <style type="text/css">
    .shadow {
  
              box-shadow: 3px 3px 4px  grey;
              border-radius: 5px;
            }
    .background{
                opacity: 0.2;
                background: linear-gradient(to right, #99ccff 12%, #3366cc 114%);
                position: fixed; 
                margin-left: -10%;
                margin-top:-5%;
                margin-right: -3%;
                width: 150%; 
                height: 100%;

            }

  </style>
   



