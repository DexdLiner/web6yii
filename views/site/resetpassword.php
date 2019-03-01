<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Password reset token'
/* @var $this yii\web\View */
/* @var $model app\models\Userdb */
/* @var $form ActiveForm */
?>
<div class="site-userRepeatPassword">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'created_at') ?>
    <?= $form->field($model, 'updated_at') ?>
    <?= $form->field($model, 'auth_key') ?>
    <?= $form->field($model, 'status') ?>
    <?= $form->field($model, 'password_reset_token') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-userRepeatPassword -->
