<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="bg">
      <img class="name" src="images/bck.jpg">
    </div>

    <br><br><br>
    <div class="row" style="padding: 20px;">
        <div class="col-lg-4"></div>
        <div class="col-lg-2"></div>
        <div class="col-lg-4" style="color: #dae1e8;">
            <h1 style="text-align: center;"><?= strtoupper(Html::encode($this->title)) ?></h1>

            <p style="color: #dae1e8;">Please fill out the following fields to login:</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true,'style'=>'opacity:0.6']) ?>

                <?= $form->field($model, 'password')->passwordInput(['style'=>'opacity:0.6']) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#dae1e8;margin:1em 0">
                    If you forgot your password you can <b> <?= Html::a('reset it.', ['site/request-password-reset'],['class'=>'text-danger']) ?></b>
                </div>

                <div class="form-group text-center">
                    <?= Html::submitButton(' Login ', ['class' => 'btn btn-warning', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
        
    </div>

<style type="text/css">
     #bg {
          position: fixed; 
          top: -50%; 
          left: -50%; 
          width: 200%; 
          height: 200%;
        }
#bg img {
          position: absolute; 
          top: 0; 
          left: 0; 
          right: 0; 
          bottom: 0; 
          margin: auto; 
          min-width: 50%;
          min-height: 50%;
        }
</style>
