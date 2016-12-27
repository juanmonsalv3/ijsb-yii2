<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Perfiles;
use yii\helpers\ArrayHelper;

$this->title = 'Nuevo Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><?=$this->title ?></h3>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'id' => 'formulario',
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
           ]);
        ?>
        <div class="form-group">
            <?= $form->field($model, "perfil")->dropDownList(ArrayHelper::map(Perfiles::find()->all(), 'id_perfil', 'nombre')) ?>   
        </div>

        <div class="form-group">
            <?= $form->field($model, "login")->input("text") ?>   
        </div>

        <div class="form-group">
            <?= $form->field($model, "password")->input("password") ?>   
        </div>

        <div class="form-group">
            <?= $form->field($model, "password_repeat")->input("password") ?>   
        </div>

        <div class="form-group">
            <?= $form->field($model, "nombres")->input("text") ?>   
        </div>

        <div class="form-group">
            <?= $form->field($model, "apellidos")->input("text") ?>   
        </div>

        <div class="form-group">
            <?= $form->field($model, "email")->input("text") ?>   
        </div>

        <?= Html::submitButton("<span class='glyphicon glyphicon-floppy-disk'></span> Registrar Usuario", ["class" => "btn btn-primary"]) ?>
        <?php $form->end() ?>
    </div>
</div>