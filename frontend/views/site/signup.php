<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Restaurant;
use yii\helpers\ArrayHelper;

$this->title = 'Create User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?php // Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create User:</p>

    
        
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <div class="col-md-12 contentBox">
            <div class="col-md-6">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>
            <!-- <div class="col-md-6">
                <?php/* $form->field($model, 'type')->dropDownlist(['foodwifi' => 'Foodwifi',
                'restaurant' => 'Restaurant'],['prompt'=>'Select User Type',
                'onchange' => '
                        var type = $("#signupform-type").val();
                        if(type == "restaurant")
                        {

                            $.post("index.php?r=site%2Ftypelist&type="+type,function(data)
                            {
                               
                                    $("select#signupform-type_id").html(data);
                                    $("#type_id").show();
                                                             
                            })
                        }
                        else
                        {
                            $("#type_id").hide();
                        }
                    '
                ])*/ ?>
               <!--  <div id="type_id">
                <?php 
                                
                   /* $restaurant= Restaurant::find()->where('status="Activey"')->all();
                    
                   
                    echo $form->field($model, "type_id")->dropDownList(
                    ArrayHelper::map($restaurant, 'id', 'name'),
                    ['prompt'=>'Select Restaurant']
                    )->label("Restaurant")*/

                ?>
                </div> -->

            </div> -->
              
             </div>
               <div class="form-group" align="right">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
       
   
</div>
<?php
$script = <<< JS

    $(document).ready(function() {
        if($("select#type").val() == "restaurant")
        {
            $("#type_id").show();
        }
        else
        {
            $("#type_id").hide();
        }
    
    });

JS;
$this->registerJS($script);

?>
