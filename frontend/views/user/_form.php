<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Restaurant;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-12 contentBox">
            <div class="col-md-6">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

               
            </div>
            <!-- <div class="col-md-6">
                <?php/* $form->field($model, 'type')->dropDownlist(['foodwifi' => 'Foodwifi',
                'restaurant' => 'Restaurant'],['prompt'=>'Select User Type',
                'onchange' => '
                        var type = $("#user-type").val();
                        //alert(type);
                        if(type == "restaurant")
                        {

                            // $.post("index.php?r=site%2Ftypelist&type="+type,function(data)
                            // {
                               
                            //         $("select#user-type_id").html(data);
                                    $("#type_id").show();
                                                             
                           // })
                        }
                        else
                        {
                            $("#type_id").hide();
                        }
                    '
                ])*/ ?>
                <div id="type_id">
                <?php 
                                
                    /*$restaurant= Restaurant::find()->where('status="Active"')->all();
                    
                   
                    echo $form->field($model, "type_id")->dropDownList(
                    ArrayHelper::map($restaurant, 'id', 'name'),
                    ['prompt'=>'Select Restaurant']
                    )->label("Restaurant")*/

                ?>
                </div>

            </div> -->
              
             </div>

    <div class="form-group" align="right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS


$(document).ready(function() {

    var type = $("#user-type").val();
                        //alert(type);
                        if(type == "restaurant")
                         {

                        //     $.post("index.php?r=site%2Ftypelist&type="+type,function(data)
                        //     {
                               
                        //             $("select#user-type_id").html(data);
                                    $("#type_id").show();
                                                             
                           // })
                        }
                        else
                        {
                            $("#type_id").hide();
                        }
    
    });
JS;
$this->registerJS($script);

?>
