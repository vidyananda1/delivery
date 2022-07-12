<?php

use yii\helpers\Html;
$this->title = 'Status Change';

?>
<!DOCTYPE html>
<html>
<head>
    <style>
.alerterror {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.alertsuccess {
  padding: 20px;
  background-color: #53c653;
  color: white;
}
</style>
    <title></title>
</head>
<body>
        <h1><?php // Html::encode($this->title) ?></h1>

    <?php if($a =="error"){ $message="Opps! There was an error. Please try again."; ?>

    <div class="alerterror">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <?php }
    else if($a=="success"){ $message="Status successfully updated!"; ?>

    <div class="alertsuccess ">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <?php }
    else if($a=="already"){ 
        $message="Uh Oh! Status has been already changed!"; ?>
        <div class="alerterror">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <?php }
    else if($a=="wait"){ $message="Whoops! Please wait while the food is being prepared."; ?>
    <div class="alerterror ">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <?php } ?>
</body>
</html>

    
