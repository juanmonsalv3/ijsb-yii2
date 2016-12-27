<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
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
        <br/><br/>
        <div class="site-login">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-md-10\">{input}</div>\n<div class=\"col-md-10\"></div>",
                    'labelOptions' => ['class' => 'col-md-2 control-label'],
                ],
            ]); ?>
                
            <?= $form->field($model, 'username') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"col-md-offset-2 col-md-5\">{input} {label}</div>\n<div class=\"col-lg-7\">{error}</div>",
            ]) ?>


            <div class="form-group">
                <div class="col-md-offset-2 col-md-6">
                    <?= Html::submitButton('Ingresar', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                    <a href="<?=Url::toRoute(['usuarios/forgot'])?>" class="btn btn-primary" >Olvidé mi contraseña</a>
                </div>
            </div>
            <h6>Si no has activado aún tu cuenta y quieres recibir nuevamente el correo de confirmación haz click <a href="<?=Url::toRoute(['usuarios/resend'])?>">aquí</a></h6>
            <?php ActiveForm::end(); ?>
            <br/>
        </div>
    </div>
</div>
