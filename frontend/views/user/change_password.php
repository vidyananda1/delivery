<?php
//use app\widgets\Alert;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = "Change Password";
?>



<div class="change-password">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'currentPassword')->passwordInput() ?>

    <?= $form->field($model, 'newPassword')->passwordInput() ?>

    <?= $form->field($model, 'newPasswordConfirm')->passwordInput() ?>

    <div class="form-group">
       <div class="col-lg-offset-2 col-lg-10">
       <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
       </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

