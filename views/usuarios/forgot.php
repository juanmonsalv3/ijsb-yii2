<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
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
            <h4>¿Olvidaste la Contraseña?</h4>
            Ingresa tu dirección de email registrada para enviar las instrucciones
            </div>
        <div class="site-login">

            <?php $form = ActiveForm::begin([
                'method'=>'post',
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
            ]); ?>
                
            <div class="col-md-12">
                <?= $form->field($model, 'email')?>
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
