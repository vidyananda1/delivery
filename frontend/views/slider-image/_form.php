<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SliderImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-image-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data']]); ?>
    
            
            <?= $form->field($model, 'image_title')->textInput(['maxlength' => true]) ?>
        
            
            <div class="row">
                <div class="col-md-6">
                   <?= $form->field($model, 'imagefile')->fileInput()->label(false) ?> 
                </div>
                <div class="col-md-6">
                    <?php $url = (isset($model->images))?$model->images: "images/white.png"?>
                    <img id="picture" src=<?=$url ?>  style="width: 100%;"> 
                </div>
            </div>
            
            <br>

    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJS('


$(document).on("change","#sliderimage-imagefile",function(){
  if(this.files.length>0){
      let size = (this.files[0].size)/1024;
      if(size>400){
         let help = $(this).closest("div").next().append("12312");
         help.innerHTML = "file too big";
         console.log(this.files);
         alert("File too big(maximum file size 400 kb)");
         this.value ="";
      }
  }
});

$(document).on("change","#sliderimage-imagefile",function(){
 
      var myImg = this.files[0];
      var myImgType = myImg["type"];
      var validImgTypes = ["image/jpg", "image/jpeg", "image/png"];

      if ($.inArray(myImgType, validImgTypes) < 0) {
        alert("File should be in JPEG/PNG Format");
      } else {
        var image = document.getElementById("picture");
        image.src = URL.createObjectURL(event.target.files[0]);
      }


});



');
?>