<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Restablecer Contraseña';
?>
<style>
    .form-horizontal .control-label {
        text-align: left
    }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <br/>
        <div class="alert alert-info" role="alert">
            <h4>Restablecer contraseña</h4>
            Ingresa tu nueva contraseña
            </div>
        <div class="site-login">

            <?php $f = ActiveForm::begin([
                'method'=>'post',
                'id' => 'reset-form',
                'options' => ['class' => 'form-horizontal'],
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
            ]); ?>
                
            <div class="col-md-12">
                
                <?= Html::activeHiddenInput($form, 'id')?>
                <?= Html::activeHiddenInput($form, 'authKey')?>
                <?= $f->field($form, 'password')->passwordInput()?>
                <?= $f->field($form, 'password_repeat')->passwordInput()?>
            </div>
            
            <div class="form-group">
                <div class="col-md-6">
                    <?= Html::submitButton('Enviar', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <br/>
        </div>
    </div>
</div>
